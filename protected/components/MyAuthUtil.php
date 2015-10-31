<?php

class MyAuthUtil {

    public static function getNumberLimit($type = 'shop') {
        $n = 0;
        $r = Member::model()->findByPk(Yii::app()->user->id);
        $data = unserialize($r->data);
        switch ($type) {
            case 'shop':
                $n = $data['noticeShopNumLimit'];
                break;
            case 'item':
                $n = $data['itemNumLimit'];
                break;
            case 'analysis':
                $n = $data['analysisShopNumLimit'];
                break;
            case 'search':
                $n = $data['keywordNumLimit'];
                break;
            case 'seo':
                $n = $data['seoKeywordNumLimit'];
                break;
            case 'hit':
                $n = $data['hitNumLimit'];
                break;
            case 'brand':
                $n = $data['brandLimit'];
                break;
            case 'edc':
                $n = $data['edcNumLimit'];
                break;
        }
        return $n;
    }

    public static function checkNumberLimit($type, $addNum) {
        $num = self::getNumberLimit($type);
        $mid = Yii::app()->user->id;
        switch ($type) {
            case 'shop':
                $sql = "SELECT COUNT(*) FROM notice_shop WHERE mid=:mid AND shop_flag = 1";
                break;
            case 'item':
                $sql = "SELECT COUNT(*) FROM notice_catalog WHERE mid=:mid";
                break;
            case 'analysis':
                $sql = "SELECT COUNT(*) FROM notice_shop WHERE mid=:mid AND marketing_flag = 1";
                break;
            case 'search':
                $sql = "SELECT COUNT(*) FROM notice_word WHERE mid=:mid ";
                break;
            case 'seo':
                $sql = "SELECT COUNT(*) FROM notice_word WHERE mid=:mid AND seo_enabled = 1";
                break;
            case 'hit':
                $sql = "SELECT count(*) FROM notice_max_sales_item WHERE mid=:mid";
                break;
            case 'brand':
                $sql = "SELECT count(*) FROM notice_brand WHERE mid = :mid AND del_flag = 0";
                break;
            case 'edc':
                $sql = "SELECT count(*) FROM notice_edc WHERE mid = :mid AND del_flag = 0";
                break;
        }

        $cmd = Yii::app()->db->createCommand($sql);
        $count = $cmd->queryScalar(array(':mid' => $mid));
        $pass = $count + $addNum > $num ? FALSE : TRUE;

        return array('pass' => $pass, 'count' => $count * 1, 'total' => $num, 'vacancy' => $num - $count * 1);
    }

    public static function checkCid($cid) {
        $mid = Yii::app()->user->id;

        $db = Yii::app()->db;
        $cmd = $db->createCommand("select lv1cid from item_category where cid=:cid");
        $lv1cid = $cmd->queryScalar(array(':cid' => $cid));

        if (!$lv1cid) {
            return FALSE;
        }
        $cmd = $db->createCommand("SELECT m.cid FROM member_category m where m.mid=:mid and m.cid=:cid and (expire_time>curdate() or expire_time='0000-00-00')");
        $stats = $cmd->queryRow(true, array(':mid' => $mid, ':cid' => $lv1cid));
        if ($stats) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getMemberCategory() {
        $mid = Yii::app()->user->id;
        $db = Yii::app()->db;
        $cmd = $db->createCommand("SELECT cid FROM member_category where mid=:mid");

        $stats = $cmd->queryColumn(array(':mid' => $mid));
        return $stats;
    }

    public static function checkNoticeShop($shopId, $isMarketing = FALSE) {
        $mid = Yii::app()->user->id;
        $exist = NoticeShop::model()->findByPk(array('mid' => $mid, 'shop_id' => $shopId));
        if ($exist) {
            if ($isMarketing) {
                return $exist->marketing_flag;
            } else {
                return $exist->shop_flag;
            }
        } else {
            return $exist;
        }
    }

    public static function checkNoticeWord($wordId) {
        $mid = Yii::app()->user->id;
        $exist = NoticeWord::model()->findByAttributes(array('mid' => $mid, 'word_id' => $wordId, 'search_enabled' => 1));
        return $exist;
    }

    public static function checkNoticeWordSeo($wordId) {
        $mid = Yii::app()->user->id;
        $exist = NoticeWord::model()->findByAttributes(array('mid' => $mid, 'word_id' => $wordId, 'seo_enabled' => 1));
        return $exist;
    }

    public static function getEarliestDateTime() {
        $deltaNumber = self::getDeltaNum();
        $date_delta_num_ago = date("Y-m-d", strtotime("-$deltaNumber month", strtotime(date("Y-m-d"))));
        $r = $date_delta_num_ago;
        if ($date_delta_num_ago < Util::getCreationDate()) {
            $r = Util::getCreationDate();
        }
        return $r;
    }

    public static function getDeltaNum() {
        $deltaNumber = Yii::app()->params->{'authDateRange'}['default'];
        return $deltaNumber;
    }

    public static function checkCancelNotice($type) {
        return TRUE;
    }

}

?>
