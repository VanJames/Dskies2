<?php

class MyDbAuthManager extends CDbAuthManager {

    public function checkAccess($itemName, $userId, $params=array()) {
        if (!empty($this->defaultRoles) && $this->checkDefaultRoles($itemName, $params))
            return true;

        $sql = "SELECT name, type, description, t1.bizrule, t1.data, t2.bizrule AS bizrule2, t2.data AS data2 FROM {$this->itemTable} t1, {$this->assignmentTable} t2 WHERE name=itemname AND userid=:userid";
        $command = $this->db->createCommand($sql);
        $command->bindValue(':userid', $userId);

        // check directly assigned items
        $names = array();
        foreach ($command->queryAll() as $row) {
            Yii::trace('Checking permission "' . $row['name'] . '"', 'system.web.auth.CDbAuthManager');
            if ($this->executeBizRule($row['bizrule2'], $params, unserialize($row['data2']))
                    && $this->executeBizRule($row['bizrule'], $params, unserialize($row['data']))) {
                if ($row['name'] === $itemName) {
                    //添加权限过期时间判断
                    if (!$this->checkExpireTime(unserialize($row['data2']))) {
                        return false;
                    }
                    //添加每月有效时间判断
//                    if(!$this->checkLimitDay(unserialize($row['data']))){
//                        return false;
//                    } 

                    return true;
                }
                $names[] = $row['name'];
            }
        }

        // check all descendant items
        while ($names !== array()) {
            $items = $this->getItemChildren($names);
            $names = array();
            foreach ($items as $item) {
                Yii::trace('Checking permission "' . $item->getName() . '"', 'system.web.auth.CDbAuthManager');
                if ($this->executeBizRule($item->getBizRule(), $params, $item->getData())) {
                    if ($item->getName() === $itemName)
                        return true;
                    $names[] = $item->getName();
                }
            }
        }

        return false;
    }

    public function checkExpireTime($data) {
        if (isset($data['expireTime'])) {
            return strtotime(date('Y-m-d')) <= strtotime($data['expireTime']);
        }

        if (isset($data['startDay'])) {
            if (date('d') < $data['startDay']) {
                return false;
            }
        }
        if (isset($data['endDay'])) {
            if (date('d') > $data['endDay']) {
                return false;
            }
        }
        return true;
    }

    public function checkLimitDay($data) {
        if (isset($data['startDay'])) {
            if (date('d') < $data['startDay']) {
                return false;
            }
        }
        if (isset($data['endDay'])) {
            if (date('d') > $data['endDay']) {
                return false;
            }
        }
        return true;
    }

}
