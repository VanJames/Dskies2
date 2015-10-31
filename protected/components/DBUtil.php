<?php

class DBUtil {

    public static function getUnionSQL($querys) {
        if (count($querys) >= 2) {
            return "(" . implode(') union all (', $querys) . ")";
        } else {
            return $querys[0];
        }
    }

    public static function getItemTable($date) {
        // 将来会升级为item_yyyymm表
        return 'item';
    }

    public static function getStatItemTable($date) {
        $time = strtotime($date);
        $year = date('Y', $time);
        $month = date('m', $time);
        return "stat_item_{$year}{$month}";
    }

    public static function getShopStatByType($id, $type, $start, $end) {
        $data = array();
        if ($type == 'month') {
            $monthYms = array_reverse(Util::getMonthYm($start, $end));
            foreach ($monthYms as $monthYm) {
                $statShops[] = 'stat_shop_' . $monthYm;
            }
            if ($statShops) {
                $querys = array();
                foreach ($statShops as $statShop) {
                    $ym = substr($statShop, -6);
                    $querys[] = "SELECT sales_index_total AS sales_index, '$ym' AS ym FROM $statShop WHERE shop_id = :shopId ";
                }
                $sql = DBUtil::getUnionSQL($querys);
                $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $id));
                if ($data_tmp) {
                    foreach ($data_tmp as $v) {
                        $data[$v['ym']] = $v;
                    }
                }
            }

            $tables = self::composeStatShopTables($start, $end);
            if ($tables) {
                $querys = array();
                foreach ($tables as $table) {
                    $tbYm = str_replace('stat_shop_', '', $table);
                    $tbYear = substr($tbYm, 0, 4);
                    $tbMonth = substr($tbYm, 4, 2);
                    $querys[] = "SELECT CONCAT_WS('-', $tbYear, $tbMonth) AS date, hot_items_total AS hot_items FROM $table WHERE shop_id = $id";
                }
                $sql = DBUtil::getUnionSQL($querys);
                $res1 = Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($res1 as $r) {
                    $date = Util::getDateTime(Util::getTimestamp($r['date']), 'Ym');
                    $data[$date]['date'] = $r['date'];
                    $data[$date]['hot_items'] = $r['hot_items'];
                }
            }
        } else {
            $startStamp = Util::getTimestamp($start);
            $endStamp = Util::getTimestamp($end);

            $tablesNew = self::composeStatShopTables($start, $end);
            foreach ($tablesNew as $tableNew) {
                $tempMonth = intval(substr($tableNew, -2));
                $tables[$tempMonth] = $tableNew;
            }
            if ($tables) {
                $res = array();
                foreach ($tables as $key => $table) {
                    $sql = "select * from $table where shop_id = $id";
                    $res[$key] = Yii::app()->db->createCommand($sql)->queryAll();
                }
                for ($s = $startStamp; $s <= $endStamp; $s = $s + 24 * 60 * 60) {
                    $data[$s]['date'] = date('Y-m-d', $s);
                    $data[$s]['sales_index'] = $res[date('n', $s)][0]["sales_index_" . date('j', $s)];
                    $data[$s]['hot_items'] = $res[date('n', $s)][0]["hot_items_" . date('j', $s)];
                }
            }
        }

        return $data;
    }

    public static function getTrackSQL($id, $type, $start, $end, $itemCode, $clv, $cid) {
        $sql_count = '';
        $sql_data = '';
        $sql_str = '';
        if ($clv && $cid) {
            $sql_str = " and c.lv{$clv}cid = {$cid}";
        }
        $tables = self::composeTrackTables($start, $end, $type);
        if (!empty($tables)) {
            $querys_count = array();
            $querys_data = array();
            foreach ($tables as $table) {
                $useTableInfo = Util::useSlaveTable('item', substr($table, -6, 4) . '-' . substr($table, -2) . '-01');
                $itemTable = $useTableInfo['table'];
                $sql_condition = "FROM $itemTable i JOIN $table l ON l.shop_id = i.shop_id AND l.item_code = i.item_code JOIN shop s ON i.shop_id = s.shop_id JOIN item_category c ON c.cid = i.cid " .
                    " WHERE l.shop_id = $id {$sql_str} AND l.date >= '$start' AND l.date <= '$end'";
                $sql_condition .= " AND l.date >= '" . $useTableInfo['naturalStartDate'] . "' AND l.date <= '" . $useTableInfo['naturalEndDate'] . "'";
                if ($itemCode) {
                    $sql_condition .= " and i.item_code = '$itemCode'";
                }
                $fields = "i.item_code as item_code, i.title as title, i.img,c.lv1cid,
                    c.lv2cid,c.lv3cid, c.lv1name as lv1name, c.lv2name as lv2name, c.lv3name as lv3name, i.price as price, CONCAT_WS('/', s.name, i.item_code) AS combiCode,
                    l.date as date";
                if (in_array($type, array('price', 'title', 'point'))) {
                    $fields .= ', l.from as `from`, l.to as `to`';
                } elseif ($type == 'new_item') { // 只读log表
                    $sql_condition = "FROM $table l 
                        JOIN item_category c ON c.cid = l.cid 
                        LEFT JOIN $itemTable i ON i.shop_id = l.shop_id AND i.item_code = l.item_code
                        WHERE l.shop_id = $id {$sql_str} AND l.date >= '$start' AND l.date <= '$end'";
                    $fields = 'l.item_code as item_code,l.title as title, l.price as price, l.date as date, 
                        c.lv1cid,c.lv2cid,c.lv3cid,c.lv1name as lv1name, c.lv2name as lv2name, c.lv3name as lv3name,
                        i.img';
                }
                $querys_count[] = "select count(*) as count $sql_condition";
                $querys_data[] = "select $fields $sql_condition";
            }
            $sql_count = DBUtil::getUnionSQL($querys_count);
            $sql_data = DBUtil::getUnionSQL($querys_data);
        }
        return array(
            'sql_count' => $sql_count,
            'sql_data' => $sql_data
        );
    }

    public static function composeTrackTables($start, $end, $type) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), "track_{$type}_log_");
    }

    private static function composeTablesByLoop($startTime, $endTime, $tbPrefix) {
        $tables = array($tbPrefix . date('Y', $endTime) . date('m', $endTime));
        while ($startTime < $endTime) {
            $tbYear = date('Y', $startTime);
            $tbMonth = date('m', $startTime);
            $tables[] = "{$tbPrefix}{$tbYear}{$tbMonth}";
            $startTime = strtotime('first day of next month', $startTime);
        }
        $result = array_unique($tables);
        sort($result);
        return $result;
    }

    public static function composeStatShopTables($start, $end) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), 'stat_shop_');
    }

    public static function composeStatAllShopTables($start, $end) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), 'stat_all_shop_');
    }

    public static function composeStatItemTables($start, $end) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), 'stat_item_');
    }

    public static function composeCpcAdsTables($start, $end) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), 'ads_cpc_ads_');
    }

    public static function composeAdShopTables($start, $end) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), 'advertise_shops_');
    }

    public static function composeAdItemTables($start, $end) {
        return self::composeTablesByLoop(strtotime($start), strtotime($end), 'advertise_items_');
    }

    public static function getStatItemRankTrendData($shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();

        // stat_item_

        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'stat_item_' . $monthYm;
        }


        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where shop_id = :shopId and item_code = :itemCode";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$v['ym']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getStatShopData($shopId, $start, $end) {
        $data = array();
        $tables = array();

        // stat_item_

        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'stat_shop_' . $monthYm;
        }


        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where shop_id = :shopId ";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$v['ym']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getStatItemPriceTrendData($shopId, $itemCode, $start, $end, $cur_price) {
        $data = array();
        $tables = array();

        // stat_item_
        $monthYms = Util::getMonthYm($start, $end);
        $is_result_exist = 0;
        $changement_result = array();

        foreach ($monthYms as $monthYm) {
            $table = "track_price_log_" . $monthYm;
            $sql_model[] = "(SELECT `date`,`from`,`to` FROM `$table` `t` WHERE shop_id=:shopId and item_code=:itemCode AND date >= '$start' AND date <=  '$end' and `from`>0 )";
        }
        $sql_model_merge = implode(' union all ', $sql_model);
        if (count($monthYms) == 1) {
            $sql_model_merge = substr($sql_model_merge, 1, -1);
        }
        $sql_model_merge .= ' order by date';
        $model_tmp = Yii::app()->db->createCommand($sql_model_merge)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));

        if ($model_tmp) {
            foreach ($model_tmp as $row) {
                $changement_result[$row['date']] = $row;
                if (!$tmp_price)
                    $tmp_price = $row['from'];
                $is_result_exist++;
            }
        }
        $start_time_tmp = $start;
        $end_time_tmp = $end;
        while ($start_time_tmp <= $end_time_tmp) {
            if (isset($changement_result[$start_time_tmp])) {
                $tmp_price = $changement_result[$start_time_tmp]["to"];
            }

            $data[$start_time_tmp] = $tmp_price;

            if ($is_result_exist == 0) {
                $data[$start_time_tmp] = $cur_price;
            }

            $start_time_tmp = Util::getNextNDay($start_time_tmp);
        }

        return $data;
    }

    public static function getAdvertiseItemData($shopId, $itemCode, $start, $end) {
        $data = array();

        // advertise_items_
        $monthYms = Util::getMonthYm($start, $end);

        foreach ($monthYms as $monthYm) {
            $table = "advertise_items_" . $monthYm;
            $querys[] = "SELECT * FROM `$table` `t` WHERE shop_id=:shopId and item_code=:itemCode AND date >= '$start' AND date <=  '$end' ";
        }
        $sql = DBUtil::getUnionSQL($querys);
        $sql .= ' order by date';
        $model_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));

        if ($model_tmp) {
            foreach ($model_tmp as $row) {
                $data[$row['date']] = $row;
            }
        }

        return $data;
    }

    public static function getTrackLogData($shopId, $itemCode, $start, $end, $type) {
        $data = array();

        // track_{$type}_log_
        $monthYms = Util::getMonthYm($start, $end);

        foreach ($monthYms as $monthYm) {
            $table = "track_${type}_log_" . $monthYm;
            $querys[] = "SELECT `date`,`from`,`to` FROM `$table` `t` WHERE shop_id=:shopId and item_code=:itemCode AND date >= '$start' AND date <=  '$end' ";
        }
        $sql = DBUtil::getUnionSQL($querys);
        $sql .= ' order by date';
        $model_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));

        if ($model_tmp) {
            foreach ($model_tmp as $row) {
                $data[$row['date']][$type] = $row;
            }
        }

        return $data;
    }

    public static function getSingleShopItem($shopId, $itemCode) {
        $sql = "SELECT i.shop_id, i.item_code, i.title AS item_title, s.title AS shop_title, i.cid FROM item i JOIN shop s ON i.shop_id = s.shop_id WHERE i.shop_id = :shopId AND i.item_code = :itemCode ";
        $bind = array(':shopId' => $shopId, ':itemCode' => $itemCode);
        $data = Yii::app()->db->createCommand($sql)->queryRow(true, $bind);
        return $data;
    }

    public static function getSingleShopItemCid($shopId, $itemCode) {
        $sql = "select i.shop_id,i.item_code,i.title as item_title,s.title as shop_title,c.lv1name,lv2name,lv3name from item i join shop s on i.shop_id = s.shop_id join item_category c on c.cid=i.cid where i.shop_id = :shopId and i.item_code = :itemCode ";
        $bind = array(':shopId' => $shopId, ':itemCode' => $itemCode);
        $data = Yii::app()->db->createCommand($sql)->queryRow(true, $bind);
        return $data;
    }

    public static function getLv1ItemCategoryByAuth() {
        $sql = 'select i.lv1cid as cid, i.lv1name as cname from item_category i join member_category m on m.cid = i.cid and m.mid = :mid  where i.level = 1';
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':mid' => Util::getUserId()));
        $data = array();
        foreach ($result as $value) {
            $data[$value['cid']] = $value['cname'];
        }
        return $data;
    }

    public static function getShopCategoryData() {
        $sql = 'select s.cid ,s.name from shop_category s join item_category_lv0 i on s.cid=i.shop_cid
join member_category m on i.cid=m.cid and m.mid=:mid';
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(":mid" => Yii::app()->user->id));
        $data = array();
        foreach ($result as $value) {
            $data[$value['cid']] = $value['name'];
        }
        return $data;
    }

    public static function getShopMainCategoryData() {
        $sql = "SELECT i.cid, i.name FROM item_category i JOIN member_category m ON i.cid = m.cid AND m.mid = :mid WHERE i.level = 1";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(":mid" => Util::getUserId()));
        $data = array();
        foreach ($result as $value) {
            $data[$value['cid']] = $value['name'];
        }
        return $data;
    }

    //单条
    public static function getTrackWordItemData($wordId, $shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_word_item_' . $monthYm;
        }
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where word_id = :wordId and shop_id = :shopId and item_code = :itemCode";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':wordId' => $wordId, ':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$v['ym']] = $v;
                }
            }
        }
        return $data;
    }

    //多条
    public static function getMultTrackWordItemData($wordId, $shopId, $itemCode, $betweenTime) {
        $data = array();
        $tables = array();
        $startStamp = Util::getTimestamp($betweenTime['start']);
        $endStamp = Util::getTimestamp($betweenTime['end']);
        $monthYms = Util::getMonthYm($betweenTime['start'], $betweenTime['end']);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_word_item_' . $monthYm;
        }
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym  from $table where word_id = :wordId and shop_id= :shopId and item_code=:itemCode ";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':wordId' => $wordId, ':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $key => $v) {
                    $tmp[$v['ym']][] = $v;
                }
                for ($s = $startStamp; $s <= $endStamp; $s = $s + 24 * 60 * 60) {
                    if ($tmp[date('Ym', $s)][0]["rank" . date('j', $s)]) {
                        $data[$s] = $tmp[date('Ym', $s)][0]["rank" . date('j', $s)];
                    } else {
                        $data[$s] = 99999999;
                    }
                }
            } else {
                for ($s = $startStamp; $s <= $endStamp; $s = $s + 24 * 60 * 60) {
                    $data[$s] = 99999999;
                }
            }
        }
        return $data;
    }

    //单条seo
    public static function getTrackWordItemSeoData($wordId, $shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_word_item_seo_' . $monthYm;
        }
        $dataConditions = "date >= '$start' and date < '$end'";
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where word_id = :wordId and shop_id = :shopId and item_code = :itemCode and $dataConditions";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':wordId' => $wordId, ':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$shopId . "_" . $itemCode . "_" . $v['date']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getTrackTitleLogData($shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_title_log_' . $monthYm;
        }
        $dataConditions = "date >= '$start' and date < '$end'";
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where  shop_id = :shopId and item_code = :itemCode and $dataConditions";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$shopId . "_" . $itemCode . "_" . $v['date']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getAdvertiseItemsData($shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'advertise_items_' . $monthYm;
        }
        $dataConditions = "date >= '$start' and date < '$end'";
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where  shop_id = :shopId and item_code = :itemCode and $dataConditions";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$shopId . "_" . $itemCode . "_" . $v['date']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getTrackDescLogData($shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_desc_log_' . $monthYm;
        }
        if ($start == $end) {
            $dataConditions = "date = '$start'";
        } else {
            $dataConditions = "date >= '$start' and date < '$end'";
        }
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where  shop_id = :shopId and item_code = :itemCode and $dataConditions";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$shopId . "_" . $itemCode . "_" . $v['date'] . "_" . $v['type']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getTrackPriceLogData($shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_price_log_' . $monthYm;
        }
        $dataConditions = "date >= '$start' and date < '$end'";
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where  shop_id = :shopId and item_code = :itemCode and $dataConditions";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$shopId . "_" . $itemCode . "_" . $v['date']] = $v;
                }
            }
        }
        return $data;
    }

    public static function getTrackPointLogData($shopId, $itemCode, $start, $end) {
        $data = array();
        $tables = array();
        $monthYms = Util::getMonthYm($start, $end);
        foreach ($monthYms as $monthYm) {
            $tables[] = 'track_point_log_' . $monthYm;
        }
        $dataConditions = "date >= '$start' and date < '$end'";
        if ($tables) {
            $querys = array();
            foreach ($tables as $table) {
                $ym = substr($table, -6);
                $querys[] = "select *, '$ym' as ym from $table where  shop_id = :shopId and item_code = :itemCode and $dataConditions";
            }
            $sql = DBUtil::getUnionSQL($querys);
            $data_tmp = Yii::app()->db->createCommand($sql)->queryAll(true, array(':shopId' => $shopId, ':itemCode' => $itemCode));
            if ($data_tmp) {
                foreach ($data_tmp as $v) {
                    $data[$shopId . "_" . $itemCode . "_" . $v['date']] = $v;
                }
            }
        }
        return $data;
    }

    //track_word_daily
    public static function getTrackWordDailyData($wordId, $start, $end) {
        if ($wordId && $start && $end) {
            $dataConditions = "date >= '$start' and date <= '$end'";
            $sql = "select *  from track_word_daily where word_id = :wordId and $dataConditions";
            $data = Yii::app()->db->createCommand($sql)->queryAll(true, array(':wordId' => $wordId));
            return $data;
        }
        return array();
    }

    //获取notice_word id,便于in使用
    public static function getNoticeWordIds($mid) {
        if ($mid) {
            $res = array();
            $nw_sql = "select word_id from notice_word where mid=:mid";
            $bind[':mid'] = $mid;
            $notice_words = Yii::app()->db->createCommand($nw_sql)->queryAll(true, $bind);
            foreach ($notice_words as $nw) {
                $res[] = $nw['word_id'];
            }
            if ($res) {
                return implode(',', $res);
            }
        }
        return null;
    }

    public static function getActionUrl($action, $intro_id = '') {
        $criteria = new CDbCriteria();
        $criteria->addCondition('action = :action');
        $params = array(':action' => $action);
        $criteria->with = array('category');
        if ($intro_id) {
            $criteria->addCondition('intro_id = :intro_id');
            $params = array_merge($params, array(':intro_id' => $intro_id));
        }
        $criteria->addCondition('category.flag = 1');
        $criteria->params = $params;
        $introduction = Introduction::model()->find($criteria);
        if ($introduction) {
            return Yii::app()->request->baseUrl . "/site/guide?page=" . $introduction->cid . "&intro_id=" . $introduction->intro_id;
        } else {
            return '';
        }
    }

    public static function getActionSolution() {
        $controller = Yii::app()->controller->id;
        $solutions = Introduction::model()->findAll(array("condition" => "action='/$controller'"));
        return $solutions;
    }

    public static function getActionIntroduction() {
        $route = Yii::app()->controller->route;
        $sql = "select i.* from introduction i join
(select i.cid,i.intro_id from introduction i join introduction_category c on i.cid=c.id and c.flag=0 and i.action='/$route' group by i.cid,i.intro_id)t
on i.cid=t.cid and i.intro_id=t.intro_id group by i.cid,i.intro_id";
        $introductions = Yii::app()->db->createCommand($sql)->queryAll();
        return $introductions;
    }

    public static function getLastMonthItemRank($shop_id, $item_code) {
        if ($shop_id && $item_code) {
            $table = "stat_all_item_" . date("Ym", strtotime('- 1 month', time()));
            $sql = "select s.cid, s.sales_index, i.* from $table s join item_category i on s.cid=i.cid where s.shop_id=:shop_id and s.item_code=:item_code and s.sales_index>0
order by i.level limit 1";
            $catInfo = Yii::app()->db->createCommand($sql)->queryRow(true, array(":shop_id" => $shop_id, ":item_code" => $item_code));
            if ($catInfo) {
                $cid = $catInfo['cid'];
                $sales_index = $catInfo['sales_index'];

                $sql = "select count(*) from $table where cid=:cid";
                $total_mum = Yii::app()->db->createCommand($sql)->queryScalar(array(":cid" => $cid));
                if ($sales_index) {
                    $sql = "select count(*) from $table where cid=:cid and sales_index>:sales_index";
                    $rank = Yii::app()->db->createCommand($sql)->queryScalar(array(":cid" => $cid, ":sales_index" => $sales_index));
                    $rank += 1;
                } else {
                    $rank = $total_mum + 1;
                }
                return array($catInfo, $rank, $total_mum);
            }
        }
        return array(0, 0);
    }

    public static function getLastMonthShopRank($shop_id) {
        $table = "stat_all_shop_" . date("Ym", strtotime('- 1 month', time()));
        $sql = "SELECT i.name,s.cid,s.sales_index FROM $table s join item_category i on s.cid=i.cid and i.level=1 where shop_id=:shop_id order by sales_index desc limit 1;";
        $maxCat = Yii::app()->db->createCommand($sql)->queryRow(true, array(":shop_id" => $shop_id));
        if ($maxCat) {
            $sql = "SELECT count(*) FROM $table s where cid=:cid and sales_index>:sales_index;";
            $rank = Yii::app()->db->createCommand($sql)->queryScalar(array(":cid" => $maxCat['cid'], ":sales_index" => $maxCat['sales_index']));
            $rank += 1;
            $sql = "SELECT count(*) FROM $table s where cid=:cid";
            $totalNum = Yii::app()->db->createCommand($sql)->queryScalar(array(":cid" => $maxCat['cid']));
            return array($maxCat['name'], $rank, $totalNum);
        }
    }

    public static function getVideo($icid) {
        $sql = "select url from introduction_video where icid=:icid";
        return Yii::app()->db->createCommand($sql)->queryScalar(array("icid" => $icid));
    }

    public static function sentMessage($mids, $title, $detail, $sender=0) {
        $db = Yii::app()->db;
        $sql = "insert member_message (mid, date, title, detail, sender, created) 
select mid,curdate(),:title,:detail,:sender,now() from member";
        
        if(is_array($mids) && count($mids)>0){
            $midStr = implode(",", $mids);
            $sql .= " where mid in ($midStr)";
        }elseif($mids==0){
            ;
        }
        else{
            $sql .= " where mid=$mids";
        }
        $db->createCommand($sql)->execute(array(':title' => $title, ':detail' => $detail, ':sender'=>$sender));

    }

}
