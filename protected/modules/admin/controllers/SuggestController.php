<?php

/**
 * User: diaoshoujun
 * Date: 14/11/28
 * Time: 下午2:03
 */
class SuggestController extends MyAdminController
{
    public $defaultAction = 'list';
    public $defaultSimilarity = 0.6;

    public function actions() {
        return array();
    }

    public function behaviors() {
        return array(//            
            'datePicker' => array('class' => 'DatePickerBehavior'),
        );
    }

    public function beforeAction($action) {
        //TODO comment this before commit:
//        require_once('vendor/autoload.php');
        return parent::beforeAction($action);
    }

    public function actionList() {
        $request = Yii::app()->request;
        $shopName = $request->getParam('shopName');
        $similarity = $request->getParam('similarity');
        if (empty($similarity)) {
            $similarity = $this->defaultSimilarity;
        }
        //TODO change to use SuggestForm
        //TODO escape string
        $shopCorrect = 1;
        if ($shopName) {
            $db = Yii::app()->db;
            //TODO add shopname auto complete
            $shop = $db->createCommand("SELECT shop_id, title, name FROM shop WHERE name = '$shopName'")->queryRow();
            $shopId = $shop['shop_id'];
            if (!$shopId) {
                $shopCorrect = 0;
                $this->render('list', compact('statistics', 'fieldToRank', 'shopStat', 'shop', 'shopCorrect', 'similarity', 'showRankToValue'));
                exit;
            }
            $suggestIds = $this->getSimilarShops($shopId, $similarity);
            $allShopIds = array_merge(array($shopId), $suggestIds);
            $allShopIdStr = implode(',', $allShopIds);
            $statistics = $db->createCommand("SELECT * FROM suggest_shop WHERE shop_id IN ($allShopIdStr)")->queryAll();
            foreach ($statistics as $row) {
                if ($row['shop_id'] == $shopId) {
                    $shopStat = $row;
                }
            }
            $fields = SuggestUtil::getAllSuggestFields();
            $fieldToRank = array();
            foreach ($fields as $field) {
                $fieldToRank[$field] = SuggestUtil::getRankByField($shopId, $statistics, $field);
            }

            $showRankToValue = array();
            $showPercentArr = SuggestUtil::getShowPercentArr();
            foreach ($fields as $field) {
                $allValues = array();
                foreach ($statistics as $stat) {
                    array_push($allValues, $stat[$field]);
                }
                rsort($allValues);
                $selectValue = array();
                foreach (array_keys($showPercentArr) as $showPercent) {
                    $showRank = $showPercent ? round(count($statistics) * $showPercent / 100) : 1;
                    $index = $showRank - 1;
                    $selectValue[$showPercent] = $allValues[$index];
                }
                $showRankToValue[$field] = $selectValue;
            }
        }
        $this->render('list', compact('statistics', 'fieldToRank', 'shopStat', 'shop', 'shopCorrect', 'similarity', 'showRankToValue'));
    }

    private function getSimilarShops($shopId, $similarity = 0.6) {
        //ensure all similar shops are in table suggest_shop
        $sql = "SELECT s.target_id FROM shop_similarity s JOIN suggest_shop ss ON s.target_id = ss.shop_id WHERE s.shop_id = :shopId AND s.similarity >= :similarity ORDER BY s.similarity DESC";
        return Yii::app()->db->createCommand($sql)->queryColumn(array(":shopId" => $shopId, ":similarity" => $similarity));
    }

    public function actionSearch() {
        $request = Yii::app()->request;
        $shopId = $request->getParam('shopId', 0);
        $fields = $request->getParam('fields');
        $similarity = $request->getParam('similarity') ? $request->getParam('similarity') : 0.6;
        $shopStat = $this->getShopStat($shopId);
        $suggestIds = $this->getSimilarShops($shopId, $similarity);
        $shopIdStr = implode(',', $suggestIds);
        $db = Yii::app()->db;
        $sqls = array();

        if (!is_array($fields) || count($fields) == 0)
            $this->renderError("比较方面不能为空");
        $allFields = SuggestUtil::getAllSuggestFields();
        foreach ($fields as $tmpField1) {
            if (!in_array($tmpField1, $allFields)) {
                $this->renderError("比较方面不存在");
            }
        }

        if (count($suggestIds) == 0)
            $suggestShops = array();
        else {
            $limit = round(count($suggestIds) * 0.1);
            foreach ($fields as $tmpField1) {
                $tmpSql = "(select *,0";
                foreach ($fields as $tmpField2) {
                    $tmpSql .= "+if($tmpField2>" . $shopStat[$tmpField2] . ",1,0)";
                }
                $tmpSql .= " as specialIndex from suggest_shop where shop_id IN ($shopIdStr) and $tmpField1>" . $shopStat[$tmpField1] . " order by $tmpField1 desc LIMIT $limit)";
                $sqls[] = $tmpSql;
            }
            $sql = implode(" union ", $sqls);
            $sql = "select ss.*, s.name, s.title, s.shop_id, st.similarity, c.id AS clientId from ($sql) ss
JOIN shop_similarity st ON ss.shop_id = st.shop_id AND st.target_id = $shopId 
JOIN shop s ON ss.shop_id = s.shop_id
JOIN client c ON c.name = s.name
ORDER BY ss.specialIndex DESC, st.similarity DESC LIMIT $limit";

            $rawSuggestShops = $db->createCommand($sql)->queryAll();

            $allShopIds = array_merge(array($shopId), $suggestIds);
            $allShopIdStr = implode(',', $allShopIds);
            $statistics = $db->createCommand("SELECT * FROM suggest_shop WHERE shop_id IN ($allShopIdStr)")->queryAll();
            $fieldToRank = array();
            foreach ($fields as $field) {
                $fieldToRank[$field] = SuggestUtil::getRankByField($shopId, $statistics, $field);
            }

            $suggestShops = array();
            $shopIdToIndex = array();
            foreach ($rawSuggestShops as $shop) {
                $newShop = array();
                $fieldToPercent = array();
                $specialIndex = 0;
                foreach ($shop as $key => $value) {
                    $newShop[$key] = $value;
                    if (in_array($key, $fields)) {
                        $tmpPercent = round(SuggestUtil::getRankByField($shop['shop_id'], $statistics, $key) / count($statistics) * 100);
                        if ($tmpPercent <= 10 && $tmpPercent > 0) {
                            $specialIndex ++;
                            $fieldToPercent[$key] = $tmpPercent;
                        }
                    }
                }
                $newShop['specialIndex'] = $specialIndex;
                $newShop['percent'] = $fieldToPercent;

                $newShopId = $shop['shop_id'];
                $shopIdToIndex[$newShopId] = $specialIndex;
                $shopIdToSimilar[$newShopId] = $newShop['similarity'];
                $suggestShops[$newShopId] = $newShop;
            }

            //array is empty when the particular index of some shop is #1 and no other shop does better
            if ($shopIdToSimilar) {
                array_multisort($shopIdToIndex, SORT_DESC, $shopIdToSimilar, SORT_DESC, $suggestShops);
            }

        }
        $this->render('search', compact('suggestShops', 'fields', 'shopStat', 'fieldToRank', 'statistics', 'shopId', 'similarity'));
    }

    private function getShopStat($shopId) {
        return Yii::app()->db->createCommand("SELECT * FROM suggest_shop WHERE shop_id = $shopId")->queryRow();
    }

    public function actionNotice() {
        $request = Yii::app()->request;
        $watchers = $request->getParam('watchers');
        $shopToMid = array();
        $ok = false;
        foreach ($watchers as $watcher) {
            $wantNoNames = explode(':', $watcher);
            if (empty($wantNoNames[0])) {
                $msg = "没有此用户:{$wantNoNames[0]}";
                echo CJSON::encode(compact('msg', 'ok'));
                Yii::app()->end();
            }
            $tmpShopId = $wantNoNames[1];
            $shopToMid[$tmpShopId][] = $wantNoNames[0];
        }

        if (!empty($shopToMid)) {
            $result = 0;
            $noticeTypes = array('shop', 'marketing');
            foreach ($noticeTypes as $noticeType) {
                if ($noticeType == 'shop') {
                    $flag = 'shop_flag';
                    $time = 'insert_time';
                    $shopIds = $_REQUEST['sShops'];
                } else {
                    $flag = 'marketing_flag';
                    $time = 'marketing_time';
                    $shopIds = $_REQUEST['mShops'];
                }

                if (empty($shopIds)) {
                    $msg = "没有选择店铺";
                    echo CJSON::encode(compact('msg', 'ok'));
                    Yii::app()->end();
                }

                $values = array();
                foreach ($shopIds as $shopId) {
                    foreach ($shopToMid[$shopId] as $mid) {
                        array_push($values, "($mid, $shopId, 1, NOW())");
                    }
                }

                $result += Yii::app()->db->createCommand("INSERT notice_shop (mid, shop_id, $flag, $time) VALUES " . implode(',', $values) . " ON DUPLICATE KEY UPDATE $flag = VALUES($flag), $time = VALUES($time)")->execute();
            }

            if ($result) {
                $msg = "成功关注";
                $ok = true;
            } else {
                $msg = "没有记录有变化，请检查是否已关注这些店铺";
            }
        }
        echo CJSON::encode(compact('msg', 'ok'));
        Yii::app()->end();
    }

    public function actionSimilar() {
        $db = Yii::app()->db;
        $request = Yii::app()->request;
        $shopId = $request->getParam('shopId');
        if (empty($shopId)) {
            $shopName = $request->getParam('shopName');
            $shopId = $db->createCommand("SELECT shop_id FROM shop WHERE name = '$shopName' LIMIT 1")->queryScalar();
        }
        $similarity = $request->getParam('similarity');
        if (empty($similarity)) {
            $similarity = $this->defaultSimilarity;
        }

        if ($shopId) {
            $suggestIds = $this->getSimilarShops($shopId, $similarity);
            $allShopIdStr = implode(',', array_merge(array($shopId), $suggestIds));
            $statistics = $db->createCommand("SELECT s.name, s.title, c.id AS clientId, ss.*, st.similarity FROM suggest_shop ss JOIN shop s ON s.shop_id = ss.shop_id JOIN client c ON c.name = s.name LEFT JOIN shop_similarity st ON st.shop_id = s.shop_id AND st.target_id = $shopId
 WHERE ss.shop_id IN ($allShopIdStr) ORDER BY st.similarity DESC, ss.sales DESC ")->queryAll();
            $fields = SuggestUtil::getAllSuggestFields();
            $shopStats = array();
            foreach ($statistics as $row) {
                $rowId = $row['shop_id'];
                $rowStat = array();
                $fieldToRank = array();
                foreach ($fields as $field) {
                    $fieldToRank[$field] = SuggestUtil::getRankByField($rowId, $statistics, $field);
                }
                $rowStat['fieldsRank'] = $fieldToRank;
                foreach ($row as $key => $value) {
                    $rowStat[$key] = $value;
                }
                $shopStats[$rowId] = $rowStat;

                if ($rowId == $shopId) {
                    $standardStat = $row;
                }
            }
        }
        $this->render('similar', compact('shopStats', 'standardStat'));
    }
    
    public function actionSimilar2() {
        $db = Yii::app()->db;
        $this->pageTitle = '店铺推荐2';
        
        $shopName = $_GET['shopName'];
        $similarity = $_GET['similarity'];
        $minDate = $_GET['minDate'];
        $maxDate = $_GET['maxDate'];
        $type = $_GET['type'];
        $kpi_list = $_GET['kpi_list'];
        $kpi_rank = $_GET['kpi_rank'];
        
        if (empty($similarity)) $similarity = $this->defaultSimilarity;
        if (empty($minDate)) $minDate = date("Y-m-d",strtotime("-30 days"));
        if (empty($maxDate)) $maxDate = date("Y-m-d");
        if (empty($type)) $type = 0;
        if (empty($kpi_rank)) $kpi_rank = 0;
        $table = $type ? "suggest_shop_item_day" : "suggest_shop_day";

        $sql = "SELECT sp.shop_id,sp.name,sp.last_mon_sales_index,ss.* FROM shop_similarity s
JOIN ".$table." ss ON s.target_id = ss.shop_id
JOIN shop p on p.shop_id=s.shop_id
JOIN shop sp on sp.shop_id=ss.shop_id
WHERE p.name = '".$shopName."' AND s.similarity
 >= ".$similarity." and ss.date>='".$minDate."' and ss.date<='".$maxDate."' ORDER BY s.similarity DESC";
        $data = $db->createCommand($sql)->queryAll(true);
        
        $shopId = $db->createCommand("SELECT shop_id FROM shop WHERE name = '$shopName' LIMIT 1")->queryScalar();
        if ($shopId) {
            $suggestIds = $this->getSimilarShops($shopId, $similarity);
            $allShopIdStr = implode(',', array_merge(array($shopId), $suggestIds));
            $statistics = $db->createCommand("SELECT s.name, s.title, c.id AS clientId, ss.*, st.similarity FROM suggest_shop ss JOIN shop s ON s.shop_id = ss.shop_id JOIN client c ON c.name = s.name LEFT JOIN shop_similarity st ON st.shop_id = s.shop_id AND st.target_id = $shopId
 WHERE ss.shop_id IN ($allShopIdStr) ORDER BY st.similarity DESC, ss.sales DESC ")->queryAll();
            $fields = SuggestUtil::getAllSuggestFields();
            $shopStats = array();
            foreach ($statistics as $row) {
                $rowId = $row['shop_id'];
                $rowStat = array();
                $fieldToRank = array();
                foreach ($fields as $field) {
                    $fieldToRank[$field] = SuggestUtil::getRankByField($rowId, $statistics, $field);
                }
                $rowStat['fieldsRank'] = $fieldToRank;
                foreach ($row as $key => $value) {
                    $rowStat[$key] = $value;
                }
                $shopStats[$rowId] = $rowStat;

                if ($rowId == $shopId) {
                    $standardStat = $row;
                }
            }
        }

        $this->render('similar2', array(
            'data'=>$data,
            'shopName'=>$shopName,
            'similarity'=>$similarity,
            'minDate'=>$minDate,
            'maxDate'=>$maxDate,
            'type'=>$type,
            'kpi_list'=>$kpi_list,
            'shopStats'=>$shopStats,
            'standardStat'=>$standardStat,
            'kpi_rank'=>$kpi_rank
        ));
    }
	
	public function actionSimilar3() {
        $db = Yii::app()->db;
        $this->pageTitle = '成长店铺';
		$date1 = date('Ym', strtotime('-1 month'));
		$date2 = date('Ym', strtotime('-2 month'));
		$date3 = date('Ym', strtotime('-3 month'));
        
		$sql = "SELECT s.shop_id,sp.name as shop_name,sp.title as shop_title,cl.id as client_id,i.name as item_name, sp.main_cid,s.sales_index_total FROM stat_shop_$date1 s
 join stat_shop_$date2 s1 on s.shop_id=s1.shop_id
 join stat_shop_$date3 s2 on s.shop_id=s2.shop_id
 join shop sp on s.shop_id=sp.shop_id
 join item_category i on sp.main_cid = i.cid
 join client cl on cl.name = sp.name
 where s.sales_index_total>10000 and s.sales_index_total>s1.sales_index_total and s1.sales_index_total>s2.sales_index_total and s.sales_index_total>1.5*s2.sales_index_total";
	
	$data = $db->createCommand($sql)->queryAll(true);
	$dataProvider=new CArrayDataProvider($data, array());
	//$dataProvider->pagination->pageSize = $dataProvider->getTotalItemCount();
	$dataProvider->pagination->pageSize = 20;
	
	$this->render('similar3', array(
		'dataProvider'=>$dataProvider,
		'data' => $data,
	));
    }
}