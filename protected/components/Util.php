<?php

class Util
{

    private static $ggColor = '#FF8000';

    public static function t($message) {
        return Yii::t('Global', $message);
    }

    public static function getCreationDate() {
        $app_name = get_class(Yii::app());

        if ($app_name == 'CWebApplication') {
            if (strtolower(Yii::app()->controller->id) == 'marketing') {
                if (Yii::app()->user->checkAccess('MarketingPeriod')) {
                    $date = date("Y-m-01", strtotime("-12 month"));
                } else {
                    if (Yii::app()->user->member->authAssignment->itemname == 'TrialMember')
                        $date = date("Y-m-01", strtotime("-1 month"));
                    else
                        $date = date("Y-m-01", strtotime("-2 month"));
                }
            } else {
                if (Yii::app()->user->checkAccess('OtherPeriod')) {
                    $date = date("Y-m-01", strtotime("-12 month"));
                } else {
                    if (Yii::app()->user->member->authAssignment->itemname == "TrialMember" and strtolower(Yii::app()->controller->id) == "shop" and in_array(strtolower(Yii::app()->controller->action->id), array("trend", "trenddetail"))) {
                        $date = date("Y-m-01", strtotime("-3 month"));
                    } else {
                        $date = date("Y-m-01", strtotime("-2 month"));
                    }
                }
            }
        }
        if (empty($date) || $date < '2014-08-01')
            $date = '2014-08-01';

        return $date;
    }

    public static function getShopCategory($shop) {
        return isset($shop->shopCategory) ? $shop->shopCategory->name : '-';
    }

    public static function getShopUrlByModel($shop) {
        return CHtml::link($shop->title, self::getShopUrl($shop->name), array('target' => '_blank'));
    }

    public static function getCategoryByItem($item, $shop_id, $preUrl = '/shop/itemList/') {
        $result = '-';
        if (isset($item->itemCategory)) {
            $itemCategory = $item->itemCategory;
            switch ($preUrl) {
                case '/item/itemList/':
                    $url = $preUrl;
                    $catalogId = isset($_REQUEST['catalogId']) && $_REQUEST['catalogId'] ? $_REQUEST['catalogId'] : '';
                    if (!empty($itemCategory->lv1name)) {
                        $category[] = CHtml::link($itemCategory->lv1name, array($url, 'lv1cid' => $itemCategory->lv1cid, 'catalogId' => $catalogId, 'page' => 1));
                    }
                    if (!empty($itemCategory->lv2name)) {
                        $category[] = CHtml::link($itemCategory->lv2name, array($url, 'lv2cid' => $itemCategory->lv2cid, 'catalogId' => $catalogId, 'page' => 1));
                    }
                    if (!empty($itemCategory->lv3name)) {
                        $category[] = CHtml::link($itemCategory->lv3name, array($url, 'lv3cid' => $itemCategory->lv3cid, 'catalogId' => $catalogId, 'page' => 1));
                    }
                    break;

                default:
                    $url = $preUrl . $shop_id;
                    $title = isset($_GET['item-title']) && $_GET['item-title'] ? $_GET['item-title'] : '';
                    if (!empty($itemCategory->lv1name)) {
                        $category[] = CHtml::link($itemCategory->lv1name, array($url, 'lv1cid' => $itemCategory->lv1cid, 'item-title' => $title, 'page' => 1));
                    }
                    if (!empty($itemCategory->lv2name)) {
                        $category[] = CHtml::link($itemCategory->lv2name, array($url, 'lv2cid' => $itemCategory->lv2cid, 'item-title' => $title, 'page' => 1));
                    }
                    if (!empty($itemCategory->lv3name)) {
                        $category[] = CHtml::link($itemCategory->lv3name, array($url, 'lv3cid' => $itemCategory->lv3cid, 'item-title' => $title, 'page' => 1));
                    }
                    break;
            }
            if (!empty($category)) {
                $ggSeparation = self::getGGSeparation();
                $result = implode($ggSeparation, $category);
            }
        }
        return $result;
    }

    public static function getCategoryByItemForShopItemList($item, $shop_id, $preUrl = '/shop/itemList/') {
        $result = '-';
        if (isset($item->itemCategory)) {
            $itemCategory = $item->itemCategory;

            $url = $preUrl . $shop_id;
            $title = isset($_GET['item-title']) && $_GET['item-title'] ? $_GET['item-title'] : '';
            if (!empty($itemCategory->lv1name)) {
                $category[] = CHtml::link($itemCategory->lv1name, array($url,
                    'RSearcherForm[cid]' => '1_' . $itemCategory->lv1cid,
                    'item-title' => $title, 'page' => 1));
            }
            if (!empty($itemCategory->lv2name)) {
                $category[] = CHtml::link($itemCategory->lv2name, array($url,
                    'RSearcherForm[cid]' => '2_' . $itemCategory->lv2cid,
                    'item-title' => $title, 'page' => 1));
            }
            if (!empty($itemCategory->lv3name)) {
                $category[] = CHtml::link($itemCategory->lv3name, array($url,
                    'RSearcherForm[cid]' => '3_' . $itemCategory->lv3cid,
                    'item-title' => $title, 'page' => 1));
            }
            if (!empty($category)) {
                $ggSeparation = self::getGGSeparation();
                $result = implode($ggSeparation, $category);
            }
        }
        return $result;
    }

    public static function getCategoryByVal($val, $itemCode, $isLink) {
        $result = '-';
        if (!empty($val)) {
            $levels = range(1, 3);
            if ($isLink) {
                $url = self::getCurUrl();
                $path = preg_replace('(/rakuten)i', '', parse_url($url, PHP_URL_PATH));
                $query = parse_url($url, PHP_URL_QUERY);
                $queryArr = array();
                parse_str($query, $queryArr);
                foreach ($levels as $lv) {
                    if (!empty($val["lv{$lv}name"])) {
                        $category[] = CHtml::link($val["lv{$lv}name"], array(self::urlSetValue($path, array_merge($queryArr, array('itemCode' => $itemCode, 'cid' => $val["lv{$lv}cid"], 'clv' => $lv, 'page' => 1)))));
                    }
                }
            } else {
                foreach ($levels as $lv) {
                    if (!empty($val["lv{$lv}name"])) {
                        $category[] = $val["lv{$lv}name"];
                    }
                }
            }
            if (!empty($category)) {
                $ggSeparation = self::getGGSeparation();
                $result = implode($ggSeparation, $category);
            }
        }
        return $result;
    }

    public static function getCategoryByArray($item) {
        $result = '-';
        if (!empty($item)) {
            $levels = range(1, 5);
            foreach ($levels as $lv) {
                if (!empty($item["lv{$lv}name"])) {
                    $category[] = $item["lv{$lv}name"];
                }
            }
            if (!empty($category)) {
                $ggSeparation = self::getGGSeparation();
                $result = implode($ggSeparation, $category);
            }
        }
        return $result;
    }

    public static function getGGSeparation() {
        return ' <span style="color:' . self::$ggColor . '">»</span> ';
    }

    public static function getCurUrl() {
        if (!empty($_SERVER["REQUEST_URI"])) {
            $nowurl = $_SERVER["REQUEST_URI"];
        } else {
            $scriptName = $_SERVER["PHP_SELF"];
            if (empty($_SERVER["QUERY_STRING"])) {
                $nowurl = $scriptName;
            } else {
                $nowurl = $scriptName . "?" . $_SERVER["QUERY_STRING"];
            }
        }
        return $nowurl;
    }

    public static function urlSetValue($url, $params) {
        $a = explode('?', $url);
        $url_f = $a[0];
        $query = $a[1];
        parse_str($query, $arr);
        foreach ($params as $key => $param) {
            $arr[$key] = $param;
        }
        return $url_f . '?' . http_build_query($arr);
    }

    public static function getItemCategory($val, $isHash = TRUE) {
        $result = '-';
        if ($isHash) {
            $levels = range(1, 3);
            foreach ($levels as $lv) {
                if (!empty($val["lv{$lv}name"])) {
                    $category[] = $val["lv{$lv}name"];
                }
            }
        } else {
            $category = array_diff($val, array(''));
        }
        if (!empty($category)) {
            $ggSeparation = self::getGGSeparation();
            $result = implode($ggSeparation, $category);
        }

        return $result;
    }

    public static function getCategoryConditionLink($url, $value, $type, $date) {
        $result = '-';
        $levels = range(1, 3);
        foreach ($levels as $lv) {
            if (!empty($value["lv{$lv}name"])) {
                $category[] = CHtml::link($value["lv{$lv}name"], array($url, 'cid' => $value["lv{$lv}cid"] . "_{$lv}", 'type' => $type, 'date' => $date, 'page' => 1,));
            }
        }
        if (!empty($category)) {
            $ggSeparation = self::getGGSeparation();
            $result = implode($ggSeparation, $category);
        }
        return $result;
    }

    public static function getNoticeShopIdsByMember($mid, $flag) {
        $shop_ids = array();
        $noticeShops = NoticeShop::model()->findAllByAttributes(array('mid' => $mid, "{$flag}" => 1));
        if ($noticeShops) {
            foreach ($noticeShops as $shop) {
                $shop_ids[] = $shop['shop_id'];
            }
        }
        return $shop_ids;
    }

    public static function getPreDate() {
        return 1;
    }

    public static function getPre30Date() {
        return -30;
    }

    public static function getItemTitle($data) {
        $itemTitle = '';
        foreach ($data as $value) {
            $itemTitle = $value['title'];
            break;
        }
        if (!$itemTitle) {
            $shopId = $_GET['id'];
            $itemCode = $_GET['itemCode'];
            $item = DBUtil::getSingleShopItem($shopId, $itemCode);
            $itemTitle = $item['item_title'];
        }
        return $itemTitle;
    }

    public static function getPercent($number) {
        return $number / 100;
    }

    public static function getIcLvStr() {
        $icLevels = range(1, 5);
        $icLvStr = '';
        foreach ($icLevels as $icLevel) {
            $icLvStr .= 'ic.lv' . $icLevel . 'name, ' . 'ic.lv' . $icLevel . 'cid, ';
        }
        return $icLvStr;
    }

    public static function getReviewPoint($shop, $isLinkButton = FALSE) {
        $review_point = Util::getPercent($shop->review_point);
        if (!$isLinkButton) {
            $output = $review_point;
        } else {
            $dataReviewSum = $shop->review_sum;
            $dataReviewPoint = array(
                $review_point,
                Util::getPercent($shop->review_full),
                Util::getPercent($shop->review_info),
                Util::getPercent($shop->review_check),
                Util::getPercent($shop->review_staff),
                Util::getPercent($shop->review_pack),
                Util::getPercent($shop->review_trans)
            );
            $output = CHtml::link($review_point, '#', array(
                'class' => 'review-point',
                'data-reviewSum' => $dataReviewSum,
                'data-reviewPoint' => implode(',', $dataReviewPoint)
            ));
        }
        return $output;
    }

    public static function getShopUrl($name) {
        return "http://www.rakuten.co.jp/{$name}/";
    }

    public static function getItemUrl($shopName, $title, $itemCode) {
        return CHtml::link($title, "http://item.rakuten.co.jp/$shopName/$itemCode", array('target' => '_blank'));
    }

    #getItemUrl函数在广告页面中的补充，主要是针对有广告而item表还没有的情况，left join相关字段为空时使用特定格式的链接
    public static function getItemUrlForAd($shopName, $title, $itemCode) {
        if (isset($title)) {
            return self::getItemUrl($shopName, $title, $itemCode);
        } else {
            $shopTitle = Yii::app()->db->createCommand("SELECT title FROM shop WHERE name = '$shopName' LIMIT 1")->queryScalar();
            return CHtml::link('商品番号 ' . $itemCode . '(' . self::t('itemNotIncluded') . ')', "http://item.rakuten.co.jp/$shopName/$itemCode", array('target' => '_blank')) . '<br/>'
            . CHtml::image(Yii::app()->params['baseImageUrl'] . '/images/flat_icn_shop.gif') . $shopTitle;
        }
    }

    #类似getItemUrlForAd
    public static function getItemImgForAd($image) {
        $useImage = isset($image) ? ($image . "?_ex=60x60") : Yii::app()->params['baseImageUrl'] . '/images/itemNotIncluded.jpg';
        return CHtml::image($useImage, "", array());
    }

    public static function getItemUrlByCombi($combiCode, $title) {
        return CHtml::link($title, "http://item.rakuten.co.jp/$combiCode", array('target' => '_blank'));
    }

    public static function getShopUrlByVar($shopName, $title) {
        return CHtml::link($title, self::getShopUrl($shopName), array('target' => '_blank'));
    }

    public static function getCurItemRank($item, $number) {
        $result = 0;
        if (isset($item->curItem) && in_array($number, array(0, 1, 2, 3))) {
            $rankType = !empty($_GET['rankType']) ? $_GET['rankType'] : 0;
            $curItem = $item->curItem;
            switch ($rankType) {
                case 1:
                    $var = "cur_mon_lv{$number}rank";
                    break;
                case 2:
                    $var = "last_mon_lv{$number}rank";
                    break;
                default:
                    $var = "cur_lv{$number}rank";
                    break;
            }
            $result = $curItem->$var;
        }
        if ($result == 0)
            $result = '--';
        return $result;
    }

    public static function getItemRankPoint($item, $number = 0) {
        if (isset($item->curItem) && in_array($number, array(0, 1, 2, 3))) {
            $rankType = !empty($_GET['rankType']) ? $_GET['rankType'] : 0;
            $curItem = $item->curItem;
            switch ($rankType) {
                case 1:
                    $var = "cur_mon_sales_index";
                    break;
                case 2:
                    $var = "last_mon_sales_index";
                    break;
                default:
                    $var = "cur_sales_index";
                    break;
            }
            $result = $curItem->$var;
        }
        if ($result == 0)
            $result = '--';
        return $result;
    }

    public static function getFakeQuality($rank) {
        return $rank != '-' ? sprintf("%0.1f", (1000 - $rank) / 100) : "0.0";
    }

    public static function now($format = 'Y-m-d H:i:s') {
        return $format ? date($format, time()) : time();
    }

    public static function getDateTime($date = NULL, $format = 'Y-m-d') {
        $time = isset($date) ? $date : time() - 2 * 24 * 3600;
        return date($format, $time);
    }

    public static function getTimestamp($time) {
        return strtotime($time);
    }

    public static function getLastMonthDatetime() {
        $year = date('Y');
        $month = date('m');
        return date('Y-m-d', mktime(0, 0, 0, $month - 1, 1, $year)); #weng  测试更改
    }

    /**
     * 可选月份段（默认近6个月）
     */
    public static function getMonthRange($monthNumber = 6) {
        $year = date('Y');
        $month = date('m');
        $select = array();
        for ($i = MyAuthUtil::getDeltaNum(); $i > 1; $i--) {
            $startMonth = date('Y-m', mktime(0, 0, 0, $month - ($i - 1), 1, $year));
            $limitMonth = date('Y-m', strtotime(Util::getCreationDate()));
            if ($startMonth >= $limitMonth)
                $select[$startMonth] = $startMonth;
        }
        $endMonth = date('Y-m', mktime(0, 0, 0, $month, 1, $year));
        $select[$endMonth] = $endMonth;
        return $select;
    }

    /**
     * min可选月份段,'2014-10'至今，不需要检查权限
     */
    public static function getMonthRangeMin() {
        $year = date('Y');
        $month = date('m');
        $select = array();
        for ($i = 12; $i > 1; $i--) {
            $startMonth = date('Y-m', mktime(0, 0, 0, $month - ($i - 1), 1, $year));
            $limitMonth = '2014-10';
            if ($startMonth >= $limitMonth)
                $select[$startMonth] = $startMonth;
        }
        $endMonth = date('Y-m', mktime(0, 0, 0, $month, 1, $year));
        $select[$endMonth] = $endMonth;
        return $select;
    }
    /**
     * max可选月份段,'2014-10'至今后一年，不需要检查权限
     */
    public static function getMonthRangeMax() {
        $select = array();
        $startMonth = date("Y-m",strtotime("+1 year"));
        $limitMonth = '2014-10';
        while ($startMonth >= $limitMonth) {
            $select[$startMonth] = $startMonth;
            $startMonth = date('Y-m', strtotime('first day of previous month', strtotime($startMonth)));
        }
        return $select;
    }

    /**
     * 是否属于有效月份段（默认允许查询12个自然月）
     */
    public static function isValidMonthRange($startMonth, $endMonth, $monthNumber = 12) {
        $startMonth = Util::getTimestamp($startMonth);
        $endMonth = Util::getTimestamp($endMonth);
        $year = date('Y', $endMonth);
        $month = date('m', $endMonth);
        $validStartMonth = mktime(0, 0, 0, $month - ($monthNumber - 1), 1, $year);
        $limitMonth = Util::getTimestamp(Util::getCreationDate());
        if ($validStartMonth < $limitMonth) {
            $validStartMonth = $limitMonth;
        }
        return ($startMonth >= $validStartMonth && $startMonth <= $endMonth) ? true : false;
    }

    /**
     * 是否属于有效时间段（默认允许查询2个自然月）
     */
    public static function isValidTimeRange($startTime, $endTime, $monthNumber = 2) {
        $monthNumber = MyAuthUtil::getDeltaNum();
        $startTime = Util::getTimestamp($startTime);
        $endTime = Util::getTimestamp($endTime);
        $year = date('Y', $endTime);
        $month = date('m', $endTime);
        $validStartTime = mktime(0, 0, 0, $month - ($monthNumber - 1), 1, $year);
        return ($startTime >= $validStartTime && $startTime <= $endTime) ? true : false;
    }

    public static function loadFile($filename, $type = 'js') {
        $yiiApp = Yii::app();
        $cs = $yiiApp->clientScript;
        $baseUrl = Yii::app()->params['baseImageUrl'];
        if ($type == 'css') {
            $cs->registerCssFile($baseUrl . '/css/' . $filename);
        } else {
            $cs->registerScriptFile($baseUrl . '/js/' . $filename, CClientScript::POS_END);
        }
    }

    public static function loadYiiGridviewCss() {
        Util::loadFile('gridview/styles.css', 'css');
    }

    public static function initIntroAnimate() {
        Util::loadFile('intro.js');
        Util::loadFile('introjs.css', 'css');
    }

    public static function isValidTrack($type) {
        $trackList = array('price', 'title', 'rank', 'new_item', 'point');
        return in_array($type, $trackList);
    }

    public static function getTrackNameMarketing($type = NULL) {
        $tracklist = array(
            'price' => Yii::t('Shop', 'Track Price'),
            'title' => Yii::t('Shop', 'Track Title'),
            'rank' => Yii::t('Shop', 'Track Rank'),
            'new_item' => Yii::t('Shop', 'Track New Item'),
            'point' => Yii::t('Shop', 'Track Point'),
        );
        return isset($type) ? $tracklist[$type] : $tracklist;
    }

    public static function getTrackOneNameMarketing() {
        $hasOne = array('price', 'title', 'point');
        $tracklist = Util::getTrackNameMarketing();
        foreach ($tracklist as $type => $item) {
            if (!in_array($type, $hasOne)) {
                unset($tracklist[$type]);
            }
        }
        return $tracklist;
    }

    public static function getTrackName($type = NULL) {
        $allTracklist = self::getTrackNameMarketing($type);
        $tracklist = self::unsetArrayValueByKey($allTracklist, 'point');
        if (is_string($tracklist) || !isset($type)) {
            return $tracklist;
        } else {
            return isset($tracklist[$type]) ? $tracklist[$type] : '';
        }
    }

    public static function getTrackOneName() {
        $allTracklist = self::getTrackOneNameMarketing();
        $tracklist = self::unsetArrayValueByKey($allTracklist, 'point');
        return $tracklist;
    }

    public static function getTrackOneNameItem() {
        $hasOne = array('price', 'title');
        $tracklist = Util::getTrackNameMarketing();
        foreach (array_keys($tracklist) as $type) {
            if (!in_array($type, $hasOne)) {
                unset($tracklist[$type]);
            }
        }
        return $tracklist;
    }

    private static function unsetArrayValueByKey($array, $key) {
        if (is_array($array) && isset($array[$key])) {
            unset($array[$key]);
        }
        return $array;
    }

    public static function getStringLength($str) {
        if (empty($str)) {
            return 0;
        }
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, 'utf-8');
        } else {
            $wantNoName = array();
            preg_match_all("/./u", $str, $wantNoName);
            return count($wantNoName[0]);
        }
    }

    public static function diffItemTitle($value) {
        $cur_str = $value['to'];
        $ori_str = $value['from'];
        $cur_len = Util::getStringLength($cur_str);
        $ori_len = Util::getStringLength($ori_str);

        $current_name = array();
        $original_name = array();
        for ($i = 0; $i < $cur_len; $i++) {
            $current_name[$i] = mb_substr($cur_str, $i, 1, 'utf-8');
        }
        for ($i = 0; $i < $ori_len; $i++) {
            $original_name[$i] = mb_substr($ori_str, $i, 1, 'utf-8');
        }

        $total_list = array();
        for ($i = 0; $i < $cur_len; $i++) {
            for ($j = 0; $j < $ori_len; $j++) {
                if (strcmp($current_name[$i], $original_name[$j]) != 0) {
                    if ($i == 0 && $j == 0) {
                        $total_list[0][0] = 0;
                    } elseif ($j == 0) {
                        $total_list[$i][0] = $total_list[$i - 1][0];
                    } elseif ($i == 0) {
                        $total_list[0][$j] = $total_list[0][$j - 1];
                    } else {
                        $total_list[$i][$j] = max($total_list[$i - 1][$j - 1], $total_list[$i - 1][$j], $total_list[$i][$j - 1]);
                    }
                } else {
                    if ($i == 0 || $j == 0) {
                        $total_list[$i][$j] = 1;
                    } else {
                        $total_list[$i][$j] = $total_list[$i - 1][$j - 1] + 1;
                    }
                }
            }
        }

        $cur_match_list = array();
        $ori_match_list = array();
        $j = $ori_len - 1;
        for ($i = $cur_len - 1; $i >= 0;
        ) {
            $circle_max = max($total_list[$i - 1][$j - 1], $total_list[$i - 1][$j], $total_list[$i][$j - 1]);
            if (strcmp($current_name[$i], $original_name[$j]) != 0 || $circle_max == $total_list[$i][$j]) {

                if ($circle_max == $total_list[$i - 1][$j]) {
                    $i = $i - 1;
                } elseif ($circle_max == $total_list[$i][$j - 1]) {
                    $j = $j - 1;
                } else {
                    $i = $i - 1;
                    $j = $j - 1;
                }
            } else {
                array_push($cur_match_list, $i);
                array_push($ori_match_list, $j);
                $i = $i - 1;
                $j = $j - 1;
            }
        }

        $_current_name = '';
        for ($i = 0; $i < $cur_len; $i++) {
            if (in_array($i, $cur_match_list)) {
                $_current_name .= $current_name[$i];
            } else {
                $_current_name .= '<span class="red">' . $current_name[$i] . '</span>';
            }
        }
        $_original_name = '';
        for ($i = 0; $i < $ori_len; $i++) {
            if (in_array($i, $ori_match_list)) {
                $_original_name .= $original_name[$i];
            } else {
                $_original_name .= '<del><span class="green">' . $original_name[$i] . '</span></del>';
            }
        }

        return array(
            'old' => $_original_name,
            'new' => $_current_name,
        );
    }

#后几天 

    public static function getNextNDay($date, $n = 1) {
        return date('Y-m-d', strtotime("$n day", strtotime($date)));
    }

    public static function zeroIsLine($num) {
        return $num > 0 && $num != 99999999 ? self::myNumberFormat($num) : '--';
    }

    public static function nullIsZero($num) {
        return $num ? $num : 0;
    }

    public static function getMonthYm($from, $to) {
        $date_from = substr($from, 0, 7) . '-01';
        $date_to = substr($to, 0, 7) . '-01';
        $arr = array();
        while ($date_from <= $date_to) {
            $datetime = new DateTime($date_from);
            array_push($arr, $date_from);
            $datetime->modify("+1 month");
            $date_from = $datetime->format("Y-m-d");
        }
        if ($arr) {
            rsort($arr);
            foreach ($arr as $days) {
                $monthsYm[] = substr($days, 0, 4) . substr($days, 5, 2);
            }
        }
        return $monthsYm;
    }

    public static function getShopAdTypeList() {
        return array(
            'parent' => array(
                'web' => 'WEB広告',
                'email' => Util::t('marketingEmail'),
                'cpc' => Util::t('marketingCpc'),
            ),
            'children' => array(
                'web' => array(
                    'all' => '全て',
                    'top' => Util::t('marketingTop'),
                    'm_top' => Util::t('marketingTopMobile'),
                    'topevent' => Util::t('marketingTopevent'),
                    'event' => Util::t('marketingEvent'),
                    'm_event' => Util::t('marketingEventMobile'),
                    'category' => Util::t('marketingCategory'),
                    'm_category' => Util::t('marketingCategoryMobile'),
                    'coupon' => Util::t('marketingCoupon'),
                    'asuraku' => Util::t('marketingAsuraku'),
                    'freeshipping' => Util::t('marketingFreeshipping'),
                    'regular' => Util::t('marketingRegular'),
                    'product' => Util::t('marketingProduct'),
                    'ranking' => Util::t('marketingRanking'),
                ),
                'email' => array(
                    'all' => '全て',
                    'email_0' => Util::t('marketingEmail_0'),
                    'email_1' => Util::t('marketingEmail_1'),
                ),
                'cpc' => array(
                    'all' => '全て',
                    'p_cpc' => Util::t('marketingCpc'),
                    'm_cpc' => Util::t('marketingCpcMobile'),
                )
            )
        );
    }

    public static function getItemAdTypeList($excludeFlag = true) {
        $itemAdTypeList = array(
            'parent' => array(
                'all' => '制限がない',
                'web' => 'WEB広告',
                'email' => Util::t('marketingEmail'),
                'cpc' => Util::t('marketingCpc'),
            ),
            'children' => array(
                'web' => array(
                    'all' => '全て',
                    'top' => Util::t('marketingTop'),
                    'm_top' => Util::t('marketingTopMobile'),
                    'topevent' => Util::t('marketingTopevent'),
                    'event' => Util::t('marketingEvent'),
                    'm_event' => Util::t('marketingEventMobile'),
                    'category' => Util::t('marketingCategory'),
                    'm_category' => Util::t('marketingCategoryMobile'),
                    'coupon' => Util::t('marketingCoupon'),
                    'asuraku' => Util::t('marketingAsuraku'),
                    'freeshipping' => Util::t('marketingFreeshipping'),
                    'regular' => Util::t('marketingRegular'),
                    'product' => Util::t('marketingProduct'),
                    'ranking' => Util::t('marketingRanking'),
                ),
                'email' => array(
                    'all' => '全て',
                    'email_0' => Util::t('marketingEmail_0'),
                    'email_1' => Util::t('marketingEmail_1'),
                ),
                'cpc' => array(
                    'all' => '全て',
                    'p_cpc' => Util::t('marketingCpc'),
                    'm_cpc' => Util::t('marketingCpcMobile'),
                )
            )
        );

        if ($excludeFlag) {
            unset($itemAdTypeList['parent']['all']);
        }
        return $itemAdTypeList;
    }

    /**
     * 获取单个商品广告类型 名
     */
    public static function getItemAdTypeOne($type, $adList = array()) {
        if (!$adList) {
            $adList = self::getItemAdTypeList();
        }
        foreach ($adList as $ads) {
            foreach ($ads as $key => $ad) {
                if ($type == $key) {
                    return $ad;
                }
                if (is_array($ad)) {
                    foreach ($ad as $k => $a) {
                        if ($type == $k) {
                            return $a;
                        }
                    }
                }
            }
        }
        return '';
    }

    /**
     * 获取单个shop广告类型 名
     */
    public static function getShopAdTypeOne($type, $adList = array()) {
        if (!$adList) {
            $adList = self::getShopAdTypeList();
        }
        foreach ($adList as $ads) {
            foreach ($ads as $key => $ad) {
                if ($type == $key) {
                    return $ad;
                }
                if (is_array($ad)) {
                    foreach ($ad as $k => $a) {
                        if ($type == $k) {
                            return $a;
                        }
                    }
                }
            }
        }
        return '';
    }

    public static function validateAdType($type) {
        return in_array($type, array_merge(array('web', 'email', 'cpc'), self::getAdFields('web'), self::getAdFields('email'), self::getAdFields('cpc')));
    }

    public static function isAdType($checkType, $typeHaystack) {
        $standardTypes = array();
        if (empty($typeHaystack)) {
            return false;
        }
        if (is_array($typeHaystack)) {
            foreach ($typeHaystack as $adField) {
                $standardTypes = array_merge($standardTypes, array($adField), self::getAdFields($adField));
            }
        } else {
            $standardTypes = array_merge(array($typeHaystack), self::getAdFields($typeHaystack));
        }
        return in_array($checkType, $standardTypes);
    }

    public static function getAdTypeId($type) {
        $typeList = array(
            'top' => 1,
            'topevent' => 2,
            'category' => 3,
            'event' => 4,
            'coupon' => 5,
            'asuraku' => 6,
            'freeshipping' => 7,
            'regular' => 8,
            'gift' => 9,
            'reward' => 10
        );
        return $typeList[$type];
    }

    public static function myCheckDate($date, $filter = TRUE) { //检查日期是否合法日期 
        $dateArr = explode("-", $date);
        $bool = FALSE;
        if (is_numeric($dateArr[0]) && is_numeric($dateArr[1]) && is_numeric($dateArr[2])) {
            $bool = checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
        }
        return $bool;
    }

    public static function initBetweenTime() {
        $end_tmp = Util::getDateTime();
        $start_tmp = Util::getLastMonthDatetime();
        if (isset($_REQUEST['BetweenTime']) && $_REQUEST['BetweenTime']) {
            if (!empty($_REQUEST['BetweenTime']['start']))
                $start = $_REQUEST['BetweenTime']['start'];
            if (!empty($_REQUEST['BetweenTime']['end']))
                $end = $_REQUEST['BetweenTime']['end'];
        } else {
            $end = $end_tmp;
            $start = $start_tmp;
        }

        if ($start > $end || $start < MyAuthUtil::getEarliestDateTime() || !self::myCheckDate($start) || !self::myCheckDate($end)) {
            $end = $end_tmp;
            $start = $start_tmp;
        }

        return array('start' => $start, 'end' => $end);
    }

    public static function getEveryCidName($cid, $isTop = FALSE) {
        $cidInfo = ItemCategory::model()->findByPk($cid);
        $cids_name = array();
        if ($isTop)
            array_push($cids_name, '総合');
        if ($cidInfo) {
            for ($index = 1; $index <= $cidInfo->level; $index++) {
                array_push($cids_name, $cidInfo->{"lv${index}name"});
            }
        }
        return $cids_name;
    }

    public static function getFakeData($num, $rateNum = 5000) {
        $d = min(array($num, $rateNum)) / $rateNum * 3 + 6;
        $d = number_format($d, 1);
        if ($num == 0)
            $d = 0;
        return $d;
    }

    public static function adAffiliateRate($n) {
        if (!$n)
            $d = 10;
        else {
            $d = $n[0];
        }
        return number_format($d / 10, 1) . '%';
    }

    public static function getTrackData($id, $type, $form, $page, $itemCode, $clv = 0, $cid = 0) {
        $data = array();
        $pages = '';
        $start = $form->startTime;
        $end = $form->endTime;
        if (Util::isValidTimeRange($start, $end)) {
            $db = Yii::app()->db;
            $pageSize = Yii::app()->params['pageSize']['TrackList'];
            $pageStart = ($page - 1) * $pageSize;
            $result = DBUtil::getTrackSQL($id, $type, $start, $end, $itemCode, $clv, $cid);
            $sql_count = "select sum(a.count) from (" . $result['sql_count'] . ") a";
            $sql_data = "select a.* from (" . $result['sql_data'] . ") as a order by date desc limit $pageStart, $pageSize";
            $count = $db->createCommand($sql_count)->queryScalar();
            $data = $db->createCommand($sql_data)->queryAll();
// 分页
            $pages = new CPagination($count);
            $pages->pageSize = $pageSize;
        } else {
            $form->addError('startTime', Util::t('Invalid Time Range'));
        }
        return array(
            'data' => $data,
            'pages' => $pages,
        );
    }

    public static function getShopTrackData($shopId, $type, $startDate, $endDate, $page, $itemCode, $clv = 0, $cid = 0) {
        if (Util::isValidTimeRange($startDate, $endDate)) {
            $db = Yii::app()->db;
            $pageSize = Yii::app()->params['pageSize']['TrackList'];
            $pageStart = ($page - 1) * $pageSize;
            $result = DBUtil::getTrackSQL($shopId, $type, $startDate, $endDate, $itemCode, $clv, $cid);
            $sql_count = "SELECT SUM(a.count) FROM (" . $result['sql_count'] . ") a";
            $sql_data = "SELECT a.* FROM (" . $result['sql_data'] . ") as a ORDER BY date DESC LIMIT $pageStart, $pageSize";
            $count = $db->createCommand($sql_count)->queryScalar();
            $data = $db->createCommand($sql_data)->queryAll();
            $pages = new CPagination($count);
            $pages->pageSize = $pageSize;
        }
        return compact('data', 'pages');
    }

    public static function getAllShopTrackData($shopId, $type, $startDate, $endDate, $page, $itemCode, $clv = 0, $cid = 0) {
        if (Util::isValidTimeRange($startDate, $endDate)) {
            $db = Yii::app()->db;
//            $pageSize = Yii::app()->params['pageSize']['TrackList'];
//            $pageStart = ($page - 1) * $pageSize;
            $result = DBUtil::getTrackSQL($shopId, $type, $startDate, $endDate, $itemCode, $clv, $cid);
            $sql_count = "SELECT SUM(a.count) FROM (" . $result['sql_count'] . ") a";
            $sql_data = "SELECT a.* FROM (" . $result['sql_data'] . ") as a ORDER BY date DESC";
            $count = $db->createCommand($sql_count)->queryScalar();
            $data = $db->createCommand($sql_data)->queryAll();
//            $pages = new CPagination($count);
//            $pages->pageSize = $pageSize;
        }
        return compact('data');
    }

    public static function getMarketingTrackData($shopId, $type, $startDate, $endDate, $page, $itemCode, $clv = 0, $cid = 0) {
        if (Util::isValidTimeRange($startDate, $endDate)) {
            $db = Yii::app()->db;
            $pageSize = Yii::app()->params['pageSize']['TrackList'];
            $pageStart = ($page - 1) * $pageSize;
            $result = DBUtil::getTrackSQL($shopId, $type, $startDate, $endDate, $itemCode, $clv, $cid);
            $sql_count = "SELECT SUM(a.count) FROM (" . $result['sql_count'] . ") a";
            $sql_data = "SELECT a.* FROM (" . $result['sql_data'] . ") as a ORDER BY date DESC LIMIT $pageStart, $pageSize";
            $count = $db->createCommand($sql_count)->queryScalar();
            $data = $db->createCommand($sql_data)->queryAll();
            $pages = new CPagination($count);
            $pages->pageSize = $pageSize;
        }
        return compact('data', 'pages');
    }

    public static function getAllMarketingTrackData($shopId, $type, $startDate, $endDate, $page, $itemCode, $clv = 0, $cid = 0) {
        if (Util::isValidTimeRange($startDate, $endDate)) {
            $db = Yii::app()->db;
//            $pageSize = Yii::app()->params['pageSize']['TrackList'];
//            $pageStart = ($page - 1) * $pageSize;
            $result = DBUtil::getTrackSQL($shopId, $type, $startDate, $endDate, $itemCode, $clv, $cid);
            $sql_count = "SELECT SUM(a.count) FROM (" . $result['sql_count'] . ") a";
            $sql_data = "SELECT a.* FROM (" . $result['sql_data'] . ") as a ORDER BY date DESC";
            $count = $db->createCommand($sql_count)->queryScalar();
            $data = $db->createCommand($sql_data)->queryAll();
//            $pages = new CPagination($count);
//            $pages->pageSize = $pageSize;
        }
        return compact('data');
    }

    public static function checkDate($date, $type = 'daily') {
        if ($type == 'daily') {
            if (!Util::myCheckDate($date) || $date < Util::getLastMonthDatetime()) {
                $date = Util::getDateTime();
            }
        } elseif ($type == 'month') {

        } else {
            $date = Util::getDateTime();
        }
        return $date;
    }

    public static function shopSearchEachRank(&$item, $level) {
        $r = '<span class="cur-lv light-hide">' . self::zeroIsLine($item['cur_lv' . $level]) . '</span>';
        $r .= '<span class="curmon-lv ">' . self::zeroIsLine($item['curmon_lv' . $level]) . '</span>';
        $r .= '<span class="lastmon-lv light-hide">' . self::zeroIsLine($item['lastmon_lv' . $level]) . '</span>';
        return $r;
    }

    /*
     * return member 的 mid
     */

    public static function getUserId() {

        return Yii::app()->user->id;
    }

    public static function myNumberFormat($number, $n = 0) {
        return number_format($number, $n);
    }

    public static function colorExplosiveNumberFormat($number, $n = 0) {
        $n = self::myNumberFormat($number, $n);
        if ($number < 2)
            return $n;
        elseif ($number >= 2 && $number < 5) {
            return '<span class="color-blue">' . $n . '</span>';
        } elseif ($number >= 5 && $number < 10) {
            return '<span class="color-orange">' . $n . '</span>';
        } else {
            return '<span class="color-red">' . $n . '</span>';
        }
    }

    /**
     * 飙量指数 数字格式化
     */
    public static function explosiveNumberFormat($number, $n = 2) {
        return number_format($number, $n);
    }

    public static function ifPreDay($date, $n = 1, $flag = 1) {
        if ($flag == 0) {
            return true;
        }
        return strtotime("+ $n day", strtotime($date)) < time();
    }

    public static function getSingularitySymbol($thisData, $lastData) {
        if ($thisData == 0 && $lastData == 0) {
            $add = '-';
        } else {
            $gap = self::getSingularityGap($thisData, $lastData);
            $symbol = self::getSingularitySymbolRank($lastData, $thisData);
            $add = $gap . $symbol;
        }

        return "($add)";
    }

    public static function getSingularityGap($thisData, $lastData) {
        if ($thisData > 0 && $lastData == 0) {
            $gap = (1001 - $thisData) . '+';
        } elseif ($thisData == 0 && $lastData > 0) {
            $gap = (1001 - $lastData) . '+';
        } elseif ($thisData > 0 && $lastData > 0) {
            $gap = abs($thisData - $lastData);
        }

        return $gap;
    }

    public static function getSingularitySymbolRank($oldData, $newData) {
        #lastData > thisData means rank up
        if ($oldData == 0 || $oldData > $newData) {
            return '<span style="color:#FF0000">↑</span>';
        } elseif ($newData == 0 || $oldData < $newData) {
            return '<span style="color:#0000FF">↓</span>';
        } else {
            return '';
        }
    }

    /**
     * 价格跟踪 使用
     * 价格跟踪中新价格旁边显示上升或下降的箭头
     */
    public static function getSingularitySymbolTrack($oldData, $newData) {
        if ($oldData < $newData) {
            return '<span style="color:#FF0000">↑</span>';
        } elseif ($oldData > $newData) {
            return '<span style="color:#0000FF">↓</span>';
        } else {
            return '';
        }
    }

    public static function getAdsVal($val) {
        return $val >= 100 ? 99 : $val;
    }

    private static function getAdTypesInOrder($allAdTypes) {
        $standardOrderTypes = array('top', 'topevent', 'event', 'category', 'coupon', 'asuraku', 'freeshipping', 'regular', 'product', 'ranking', 'email_0', 'email_1', 'cpc', 'm_top', 'm_event', 'm_category', 'm_cpc');
        #order: pc_web->pc_cpc->pc_email->m_web->m_cpc->m_email
        return array_intersect($standardOrderTypes, $allAdTypes);
    }

    public static function showUIAdvertise($url, $shopId, $itemCode, $date, $adVars) {
        $str = '';
        if (empty($adVars)) {
            return '';
        }
        $baseUrl = Yii::app()->baseUrl;
        $wrapUrl = $baseUrl . $url . "?id={$shopId}&itemCode={$itemCode}&date={$date}&type=";
        $adList = self::getItemAdTypeList();
        $allAdTypes = self::getAdFieldsToShow();
        $allAdTypesInOrder = self::getAdTypesInOrder($allAdTypes);

        if (is_object($adVars)) {
            $adVars = $adVars->attributes;
        }

        foreach (array_intersect($allAdTypesInOrder, array_keys($adVars)) as $value) {
            if ($adVars[$value]) {
                if ($value == 'cpc') {
                    $str .= '<i class="ads_icon"><a href="' . $wrapUrl . 'p_cpc' . '" title=' . self::getItemAdTypeOne($value, $adList) . '><img src="' . Yii::app()->params['baseImageUrl']  . '/images/adType_icon/cpc.png"/><b class="color-cpc-'
                        . self::getAdsVal($adVars['cpc']) . '">' . self::getAdsVal($adVars['cpc']) . '</b></a></i>';
                } else {
                    $str .= '<i class="ads_icon"><a href="' . $wrapUrl . $value . '" title=' . self::getItemAdTypeOne($value, $adList) . '><img src="' . Yii::app()->params['baseImageUrl']  . '/images/adType_icon/' . $value . '.png"/><b class="color-'
                        . (in_array($value, array('topevent', 'cpc', 'm_cpc', 'email_0', 'email_1')) ? $value : 'common') . '-' . self::getAdsVal($adVars[$value]) . '">' . self::getAdsVal($adVars[$value]) . '</b></a></i>';
                }
            }
        }
        return $str;
    }

    public static function showUIAdvertiseWithoutLink($url, $shopId, $itemCode, $date, $adVars) {
        $str = '';
        if (empty($adVars)) {
            return '';
        }
        $baseUrl = Yii::app()->baseUrl;
        $wrapUrl = $baseUrl . $url . "?id={$shopId}&itemCode={$itemCode}&date={$date}&type=";
        $adList = self::getItemAdTypeList();
        $allAdTypes = self::getAdFieldsToShow();
        $allAdTypesInOrder = self::getAdTypesInOrder($allAdTypes);

        if (is_object($adVars)) {
            $adVars = $adVars->attributes;
        }

        foreach (array_intersect($allAdTypesInOrder, array_keys($adVars)) as $value) {
            if ($adVars[$value]) {
                if ($value == 'cpc') {
                    $str .= '<i class="ads_icon"><img src="' . Yii::app()->params['baseImageUrl']  . '/images/adType_icon/cpc.png" title="' . self::getItemAdTypeOne($value, $adList) . '"/><b class="color-cpc-' . self::getAdsVal($adVars['cpc']) . '">' . self::getAdsVal($adVars['cpc']) . '</b></i>';
                } else {
                    $str .= '<i class="ads_icon"><img src="' . Yii::app()->params['baseImageUrl']  . '/images/adType_icon/' . $value . '.png" title="' . self::getItemAdTypeOne($value, $adList) . '"/><b class="color-' . (in_array($value, array('topevent', 'cpc', 'm_cpc', 'email_0', 'email_1')) ? $value : 'common') . '-' . self::getAdsVal($adVars[$value]) . '">' . self::getAdsVal($adVars[$value]) . '</b></i>';
                }
            }
        }
        return $str;
    }

    public static function showTextAdvertise($url, $shopId, $itemCode, $date, $adVars) {
        $str = '';
        if (empty($adVars)) {
            return '';
        }
        $adList = self::getItemAdTypeList();
        $allAdTypes = self::getAdFieldsToShow();

        if (is_object($adVars)) {
            $adVars = $adVars->attributes;
        }

        foreach (array_intersect($allAdTypes, array_keys($adVars)) as $value) {
            if ($adVars[$value]) {
                $str .= self::getItemAdTypeOne($value, $adList) . '(' . self::getAdsVal($adVars[$value]) . ')';
            }
        }
        return $str;
    }

    public static function getAdFieldsToShow() {
        $allFields = array_merge(self::getAdFields('web'), self::getAdFields('email'), self::getAdFields('cpc'));
        #cpc以前是单层，现在变成两层且字段名没有改变，通盘考虑，只有在这里猥琐一点比较方便，要显示时将逻辑意义上的p_cpc字段换成表中实际字段名cpc
        $showFields = array_merge(array('cpc'), array_diff($allFields, array('p_cpc')));
        return $showFields;
    }

    public static function getAdFields($adType) {
        switch ($adType) {
            case 'web':
                $adFields = array('top', 'm_top', 'topevent', 'event', 'm_event', 'category', 'm_category', 'coupon', 'asuraku', 'freeshipping', 'regular', 'product', 'ranking');
                break;
            case 'email':
                $adFields = array('email_0', 'email_1');
                break;
            case 'cpc':
                $adFields = array('p_cpc', 'm_cpc');
                break;

            default:
                break;
        }
        return $adFields;
    }

    public static function getImgCompare($num1, $num2) {
        if ($num1 < $num2) {
            return '<img src="'.Yii::app()->params['baseImageUrl'] .'/images/down_arrow_new.gif">';
        } elseif ($num1 > $num2) {
            return '<img src="'.Yii::app()->params['baseImageUrl'] .'/images/up_arrow_new.gif">';
        } else {
            return '';
        }
    }

    public static function myCityFormat($city) {
        $patternHash = array(
            '東京都' => "東京都<br/>",
            '道' => "道<br/>",
            '府' => "府<br/>",
            '県' => "県<br/>",
        );
        foreach ($patternHash as $old => $new) {
            $city = str_replace($old, $new, $city);
        }
        return $city;
    }

    public static function getTitle($ctrlId) {
        $str = "Nint-";
        if ($ctrlId == 'stat')
            return $str . Util::t('nav_stat');
        if ($ctrlId == 'shop')
            return $str . Util::t('nav_shop');
        if ($ctrlId == 'marketing')
            return $str . Util::t('nav_marketing');
        if ($ctrlId == 'item')
            return $str . Util::t('nav_item');
        if ($ctrlId == 'search')
            return $str . Util::t('nav_search');
        if ($ctrlId == 'seo')
            return $str . Util::t('nav_seo');
        if ($ctrlId == 'personal')
            return $str . Util::t('nav_personal');
        if ($ctrlId == 'news')
            return $str . Util::t('nav_news1');
        if ($ctrlId == 'edc')
            return $str . Util::t('nav_edc');
    }

    public static function replaceKeyword($keyword, $str) {
        if ($keyword) {
            return str_replace($keyword, "<strong style='color:#FF9D00'>{$keyword}</strong>", $str);
        }
        return $str;
    }

    public static function appearImg($img, $scale = '60x60') {
        if (empty($img)) {
            return '';
        } else {
            return CHtml::image($img . "?_ex=$scale", "", array());
        }
    }

    public static function withinDelJurisdiction() {
        if (Yii::app()->user->role->name == 'NormalMember') {
            return false;
        }
        return Yii::app()->user->checkAccess("DeleteTrack");
    }

    public static function canDeleteShop($flag, $time) {
        return self::withinDelJurisdiction() || ($flag && self::ifPreDay($time, 30));
    }

    public static function canDeleteEdc($flag, $time) {
        return self::withinDelJurisdiction() || ($flag != 1 && $flag != null && strtotime("+ 30 day", strtotime($time)) < time());
    }

    public static function generateString($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    public static function pregCountSql($sql) {
        $countSql = preg_replace('/SELECT [\s\S]* FROM/i', 'SELECT COUNT(*) FROM', $sql);
        if (empty($countSql)) {
            $countSql = $sql;
        }
        return $countSql;
    }

    public static function getRelativeUrl($url) {
        return Yii::app()->baseUrl . $url;
    }

    public static function getTipIds($action) {
        switch ($action) {
            case '/shop/list':
                $page = '1-店铺列表';
                break;
            case '/shop/search':
                $page = '2-店铺搜索';
                break;
            case '/shop/itemlist':
                $page = '4-店铺宝贝列表';
                break;
            case '/shop/_trendReport':
                $page = '5-店铺趋势';
                break;
            case '/shop/trendDetail':
                $page = '6-详细数据表';
                break;
            case '/item/CatalogList':
                $page = '7-宝贝目录列表';
                break;
            case '/item/search':
                $page = '8-宝贝搜索';
                break;
            case '/item/itemlist':
                $page = '9-宝贝列表';
                break;
            case '/common/_itemRankTrendReport':
                $page = '10-宝贝排名走势-店铺';
                break;
            case '/marketing/analysisItemDetailFromTopItemList':
                $page = '10-营销组合-宝贝列表-(宝贝)营销组合分析-1';
                break;
            case '/marketing/analysisItemDetail':
                $page = '10-营销组合-宝贝列表-(宝贝)营销组合分析-1';
                break;
            case '/marketing/list':
                $page = '11-店铺列表';
                break;
            case '/marketing/analysis':
                $page = '12-营销组合分析';
                break;
            case '/marketing/analysisItemList':
                $page = '13-营销组合-详情';
                break;
            case '/marketing/search':
                $page = '14-营销组合-飚量搜索';
                break;
            case '/common/_itemPriceTrendChart':
                $page = '15-价格走势-店铺';
                break;
            case '/shop/_trackNewItem':
                $page = '16-店铺跟踪-上架跟踪';
                break;
            case '/shop/_trackRank':
                $page = '16-店铺跟踪-上榜跟踪';
                break;
            case '/shop/_trackPrice':
                $page = '17-店铺跟踪-调价跟踪';
                break;
            case '/shop/_trackOnePrice':
                $page = '17-店铺相关-宝贝列表-调价跟踪';
                break;
            case '/item/_trackPrice':
                $page = '17-宝贝相关-宝贝列表-调价跟踪';
                break;

            case '/shop/_trackTitle':
                $page = '18-店铺跟踪-改名跟踪';
                break;
            case '/shop/_trackOneTitle':
                $page = '18-店铺相关-宝贝列表-改名跟踪';
                break;
            case '/item/_trackTitle':
                $page = '18-宝贝相关-宝贝列表-改名跟踪';
                break;
            case '/item/_trackOneTitle':
                $page = '18-宝贝相关-宝贝列表-改名跟踪';
                break;

            case '/shop/_trackOnePoint':
                $page = '19-营销组合-宝贝列表-调积分跟踪-1';
                break;

            case '/shop/_trackPoint':
                $page = '19-营销组合-积分变更';
                break;
            case '/marketing/topItemList':
                $page = '20-营销组合-宝贝列表';
                break;
            case '/stat/index':
                $page = array('81-行业分析-行业规模-全行业', '82-行业分析-行业趋势-全行业', '83-行业分析-热销宝贝', '84-行业分析-热销店铺');
                break;

            default:
                break;
        };
        $ids = array();
        if (!empty($page)) {
            $criteria = new CDbCriteria();
            if (is_array($page)) {
                $criteria->addInCondition('page', $page);
            } else {
                $criteria->addCondition("page = '$page'");
            }
            $tips = Tips::model()->findAll($criteria);
            foreach ($tips as $tip) {
                $ids[] = $tip->id;
            }
        }
        return $ids;
    }

    public static function fetchTips($ids) {
        if (empty($ids))
            return array();
        $details = array();
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);
        $tips = Tips::model()->findAll($criteria);
        if (!empty($tips)) {
            foreach ($tips as $tip) {
                $details[$tip->id] = $tip->deleteFlag ? '' : $tip->detail;
            }
        }
        return $details;
    }

    public static function fetchTipsByAction($path) {
        $ids = self::getTipIds($path);
        return self::fetchTips($ids);
    }

    public static function makeMailToLink($mailToAddr, $ccAddr, $text) {
        $href = $mailToAddr;

        $href .= '?body=' . $text;

        if (!empty($ccAddr)) {
            $href .= '&bcc=' . $ccAddr;
        }
        return CHtml::mailto('回复', $href, array());
    }

    public static function showPart($str, $start, $length, $encoding) {
        return mb_substr($str, $start, $length, $encoding);
    }

    public static function getIp() {
        return isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "");
    }

    public static function myDateFormat($date) {
        return date("Y", strtotime($date)) . '年' . date("n", strtotime($date)) . '月' . date("j", strtotime($date)) . '日';
    }

    public static function myMoneyFormat($fee) {
        return '￥' . self::myNumberFormat($fee);
    }

    public static function addLineBreak($str, $step, $encoding) {
        $strLen = mb_strlen($str, $encoding);
        $count = ceil($strLen / $step);
        for ($i = 0; $i < $count; $i ++) {
            $newStrArr[$i] = mb_substr($str, $i * $step, $step, $encoding);
        }

        return implode('<br/>', $newStrArr);
    }

    public static function myMoreStrFormat($str, $showPart, $encoding) {
        $strLen = mb_strlen($str, $encoding);
        if ($strLen > $showPart) {
            $result = mb_substr($str, 0, $showPart, $encoding) . '<br/><a href="javascript:show(\'' . $str . '\')">詳細>></a>';
        } else {
            $result = $str;
        }
        return $result;
    }

    public static function useSlaveTable($table, $date) {
        #not use slave table within 2 months
        $time = strtotime($date);
        if ($time >= strtotime('first day of previous month midnight')) {
            $useTable = $table;
        } else {
            $useTable = $table . '_' . date('Y', $time) . date('m', $time);
        }
        return array('table' => $useTable, 'naturalStartDate' => date('Y-m-d', strtotime('first day of this month', $time)), 'naturalEndDate' => date('Y-m-d', strtotime('last day of this month', $time)));
    }

    public static function initialBetweenTime($date) {
        if (empty($date)) {
            $start = self::getLastMonthDatetime();
            $end = self::getDateTime();
        } else {
            $start = date('Y-m-d', max(strtotime('first day of previous month', strtotime($date)), strtotime(self::getCreationDate())));
            $end = date('Y-m-d', min(strtotime('last day of this month', strtotime($date)), strtotime('-2 day', time())));
        }
        if ($start > $end) {
            $createDate = date('Y-m-d', strtotime(self::getCreationDate()));
            if ($end < $createDate) {
                $start = $end = $createDate;
            }
            $noDataDate = date('Y-m-d', strtotime('-2 day', time()));
            if ($start > $noDataDate) {
                $start = $end = $noDataDate;
            }
        }
        return compact('start', 'end');
    }

    public static function canSeeTakeEffect($order, $adminId) {
        if ($order->order_state) {
            return false;
        }
        $member = Member::model()->with('authAssignment')->findByPk($adminId);
        if ($member->authAssignment->itemname !== 'ServicePackSuperAdmin') {
            return false;
        }
        return true;
    }

    public static function canSeeTransform($order, $adminId, $monthNum) {
        if ($order->order_state) {
            return false;
        }
        if ($order->month_num == $monthNum) {
            return false;
        }
        $member = Member::model()->with('authAssignment')->findByPk($adminId);
        if ($member->authAssignment->itemname !== 'ServicePackSuperAdmin') {
            return false;
        }
        return true;
    }

    public static function canSeeDiscount($order, $adminId) {
        if ($order->order_state) {
            return false;
        }
        $member = Member::model()->with('authAssignment')->findByPk($adminId);
        if (!in_array($member->authAssignment->itemname, array('ServicePackSuperAdmin'))) {
            return false;
        }
        return true;
    }

    public static function buttonStrWithData($options) {
        $newOpts = array();
        foreach ($options as $key => $value) {
            $newOpts[$key] = $value;
        }
        return $newOpts;
    }

    public static function canReset($mid) {
        $name = Yii::app()->db->createCommand("SELECT name FROM member WHERE mid = $mid LIMIT 1")->queryScalar();
        if (empty($name)) {
            return false;
        }
        if (!preg_match('/^rakuten/', $name)) {
            return false;
        }
        return true;
    }

    public static function getColumnForXls($num) {
        $arr = array(0 => 'Z', 1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
        if ($num == 0)
            return '';
        return self::getColumnForXls((int)(($num - 1) / 26)) . $arr[$num % 26];
    }

    public static function useImgField($date) {
        return (strtotime($date) >= strtotime('first day of previous month midnight')) ? 'local_img' : 'img';
    }

    public static function getAllAdPlans() {
        $startDate = date('Y-m-d', strtotime('-3 months'));
        $tomorrow = date('Y-m-d', strtotime('tomorrow'));
        $allAdPlans = Yii::app()->db->createCommand("SELECT * FROM ads_planning WHERE start_date >= '$startDate' AND start_date < '$tomorrow' ORDER BY start_date DESC ")->queryAll();
        return $allAdPlans;
    }

    public static function getAllAdPlanList() {
        $allAdPlans = self::getAllAdPlans();
        $planList = array();
        foreach ($allAdPlans as $plan) {
            $planList[$plan['id']] = $plan['name'] . " (" . $plan['start_date'] . "~" . $plan['end_date'] . ")";
        }
        return $planList;
    }

    public static function getAdPlanTypeByDate($date, $adPlans) {
        $type = 0;
        foreach ($adPlans as $plan) {
            if (strtotime($date) >= strtotime($plan['start_date']) && strtotime($date) <= strtotime($plan['end_date'])) {
                $type = $plan['type'];
            }
        }
        return $type;
    }

    public static function showUIPlanByDate($date, $adPlans) {
        $type = 0;
        foreach ($adPlans as $plan) {
            if (strtotime($date) >= strtotime($plan['start_date']) && strtotime($date) <= strtotime($plan['end_date'])) {
                $type = $plan['type'];
                $title = $plan['name'] . '(' . $plan['start_date'] . '~' . $plan['end_date'] . ')';
            }
        }
        if (empty($type)) {
            return '';
        }
        $adPlanTypes = array(1 => 'point', 2 => 'marathon', 3 => 'superSales');
        return '<img src="' . Yii::app()->params['baseImageUrl'] . '/images/adPlanType_icon/' . $adPlanTypes[$type] . '.png" title="' . $title . '"/>';
    }

    public static function i_array_column($input, $columnKey, $indexKey=null){
        if(!function_exists('array_column')){ 
            $columnKeyIsNumber  = (is_numeric($columnKey))?true:false; 
            $indexKeyIsNull            = (is_null($indexKey))?true :false; 
            $indexKeyIsNumber     = (is_numeric($indexKey))?true:false; 
            $result                         = array(); 
            foreach((array)$input as $key=>$row){ 
                if($columnKeyIsNumber){ 
                    $tmp= array_slice($row, $columnKey, 1); 
                    $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null; 
                }else{ 
                    $tmp= isset($row[$columnKey])?$row[$columnKey]:null; 
                } 
                if(!$indexKeyIsNull){ 
                    if($indexKeyIsNumber){ 
                      $key = array_slice($row, $indexKey, 1); 
                      $key = (is_array($key) && !empty($key))?current($key):null; 
                      $key = is_null($key)?0:$key; 
                    }else{ 
                      $key = isset($row[$indexKey])?$row[$indexKey]:0; 
                    } 
                } 
                $result[$key] = $tmp; 
            } 
            return $result; 
        }else{
            return array_column($input, $columnKey, $indexKey);
        }
     }

}

