<?php
class FitController extends MyAdminController
{
    public function behaviors() {
        return array(
        );
    }
    protected function beforeAction($action)
    {
        parent::beforeAction($action);
        if (!$this->module->adminUser->checkAccess('Developer')) {
            $this->renderError(Util::t('没权限'));
        }
        return true;
    }
    
    public function actionParameterListLowR()
    {
        $this->pageTitle = '问题拟合参数列表';

        $form = new FitLowRSearchForm;
        $form->attributes = $_GET['FitLowRSearchForm'];

        if (Helper::isEmpty($form->date)) {
            $form->date = date('Y-m-d', strtotime('-2 days'));
        }
        if (Helper::isEmpty($form->minHeadR2)) {
            $form->minHeadR2 = '0.00001';
        }
        if (Helper::isEmpty($form->maxHeadR2)) {
            $form->maxHeadR2 = '0.3';
        }
        if (Helper::isEmpty($form->minTailR2)) {
            $form->minTailR2 = '0.00001';
        }
        if (Helper::isEmpty($form->maxTailR2)) {
            $form->maxTailR2 = '0.1';
        }

        $start_date = date('Y-m-01', strtotime($form->date));
        $end_date = date('Y-m-01', strtotime('+1 month', strtotime($start_date)));

        $criteria = new MyDbCriteria;
        $criteria->addBetweenCondition('p.date', $start_date, $end_date);
        $criteria->addCondition("p.head_r2 BETWEEN {$form->minHeadR2} AND {$form->maxHeadR2} OR p.tail_r2 BETWEEN {$form->minTailR2} AND {$form->maxTailR2}");

        $sql = "SELECT p.date, IFNULL(c.cid, 0) cid, IFNULL(c.name, '综合') name, IFNULL(c.level, 0) level, p.samples, p.parent_samples, p.type, p.head_err, p.head_r2, p.tail_samples, p.tail_err, p.tail_r2 FROM fit_parameter p LEFT JOIN item_category c ON c.cid = p.cid WHERE {$criteria->condition} ORDER BY p.date DESC, p.head_r2";
        $data = Yii::app()->db->createCommand($sql)->queryAll(true, $criteria->params);

        $this->render('parameter_list_low_r', array(
            'form' => $form,
            'data' => $data,
        ));
    }
    public function actionParameterList()
    {
        $this->pageTitle = '拟合参数列表';

        $form = new FitSearchForm;
        $form->attributes = $_GET['FitSearchForm'];

        if (Helper::isEmpty($form->date)) {
            $form->date = date('Y-m-d', strtotime('-2 days'));
        }

        $criteria = new MyDbCriteria;
        
        $columns = array(
            'p.date' => $form->date,
            'p.type' => $form->type,
        );
        $criteria->addColumnCondition($columns);

        Helper::addCompareConditions($criteria, $form, array(
            'Samples' => 'p.samples',
            'HeadR2' => 'p.head_r2',
            'TailR2' => 'p.tail_r2',
        ));

        $sql = "SELECT IFNULL(c.cid, 0) cid, IFNULL(c.name, '综合') name, IFNULL(c.level, 0) level, p.samples, p.parent_samples, p.type, p.head_err, p.head_r2, p.tail_samples, p.tail_err, p.tail_r2 FROM fit_parameter p LEFT JOIN item_category c ON c.cid = p.cid WHERE {$criteria->condition} ORDER BY p.head_r2";
        $data = Yii::app()->db->createCommand($sql)->queryAll(true, $criteria->params);

        $this->render('parameter_list', array(
            'form' => $form,
            'data' => $data,
        ));
    }

    public function actionParameterDetail($cid)
    {
        $this->pageTitle = '拟合参数详情';

        if ($cid == 0) {
            $cat = array('cid' => 0, 'name' => '综合', 'level' => 0);
        } else {
            $cat = Yii::app()->db->createCommand('SELECT cid, name, level FROM item_category WHERE cid = ?')->queryRow(true, array($cid));
        }

        $sql = 'SELECT date, samples, parent_samples, type, head_err, head_r2, tail_samples, tail_err, tail_r2 FROM fit_parameter WHERE cid = ? AND date BETWEEN CURDATE() - INTERVAL 31 DAY AND CURDATE() - INTERVAL 2 DAY ORDER BY date DESC';
        $data = Yii::app()->db->createCommand($sql)->queryAll(true, array($cid));

        $this->render('parameter_detail', array(
            'cat' => $cat,
            'data' => $data,
        ));
    }

    public function actionErrorList()
    {
        $this->pageTitle = '误差列表';

        $form = new FitErrorSearchForm;
        $form->attributes = $_GET['FitErrorSearchForm'];

        if (Helper::isEmpty($form->date)) {
            $form->date = date('Y-m-d', strtotime('-2 days'));
        }
        $month = date('Ym', strtotime($form->date));

        if (Helper::isEmpty($form->mode)) {
            $form->mode = 'day';
        }

        if (Helper::isEmpty($form->type)) {
            $form->type = 'all';
        }
        $type = $form->type == 'all' ? 'category' : $form->type;

        $criteria = new MyDbCriteria;

        $columns = array('e.date' => $form->mode == 'day' ? $form->date : '0000-00-00 00:00:00');

        switch ($form->type) {
        case 'all':
            $select = array('IFNULL(c.cid, 0) cid', "IFNULL(c.name, '综合') name", 'IFNULL(c.level, 0) level');
            $criteria->join = 'LEFT JOIN item_category c ON e.cid = c.cid';
            $criteria->addCondition('c.level = 1 OR c.level IS NULL');
            break;
        case 'shop':
            $select = array('s.shop_id', 's.name', 's.title');
            $criteria->join = 'JOIN shop s ON e.shop_id = s.shop_id';
            if (preg_match('#^http://www\.rakuten\.co\.jp/([^/]+)/?$#', $form->name, $matches)) {
                $columns['s.name'] = $matches[1];
            }
            break;
        case 'item':
            $select = array('s.shop_id', 's.name', 's.title shop_title', 'i.item_code', 'i.title item_title');
            $criteria->join = 'JOIN shop s ON e.shop_id = s.shop_id JOIN item i ON e.shop_id = i.shop_id AND e.item_code = i.item_code';
            if ($form->mode == 'day') {
                $select = array_merge($select, array('p.cid', "IF(se.type = 'head', p.head_r2, p.tail_r2) r2"));
                $criteria->join .= " JOIN sales_estimate_$month se ON e.date = se.date AND e.shop_id = se.shop_id AND e.item_code = se.item_code LEFT JOIN fit_parameter p ON se.date = p.date AND se.cid = p.cid";
            }
            if (preg_match('#^http://item\.rakuten\.co\.jp/([^/]+)/(.+)$#', $form->name, $matches)) {
                $columns['s.name'] = $matches[1];
                $columns['e.item_code'] = $matches[2];
            }
            break;
        case 'category':
            $select = array('IFNULL(c.cid, 0) cid', "IFNULL(c.name, '综合') name", 'IFNULL(c.level, 0) level');
            $criteria->join = 'LEFT JOIN item_category c ON e.cid = c.cid';
            $columns['e.cid'] = $form->name;
            break;
        }

        foreach ($form->numberAttributes() as $attribute) {
            $select[] = "e.$attribute";
        }
        $select = implode(', ', $select);

        $criteria->addColumnCondition($columns);

        foreach ($form->numberAttributes() as $attribute) {
            Helper::addCompareConditions($criteria, $form, array(ucfirst($attribute) => "e.$attribute"));
        }

        $sql = "SELECT COUNT(*) FROM estimate_{$type}_{$month} e {$criteria->join} WHERE {$criteria->condition}";
        $count = Yii::app()->db->createCommand($sql)->queryScalar($criteria->params);

        $sql = "SELECT $select FROM estimate_{$type}_{$month} e {$criteria->join} WHERE {$criteria->condition} ORDER BY e.error DESC";
        $dataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount' => $count,
            'params' => $criteria->params,
            'pagination' => array('pageSize' => 100),
        ));

        $this->render('error_list', array(
            'form' => $form,
            'dataProvider' => $dataProvider,
        ));
    }

    private function buildIntervalSelect($col, $intervals)
    {
        $count = count($intervals);
        $select[] = "IFNULL(SUM($col < {$intervals[0]}), 0)";
        for ($i = 1; $i < $count; $i++) {
            $select[] = "IFNULL(SUM($col >= {$intervals[$i - 1]} AND $col < {$intervals[$i]}), 0)";
        }
        $select[] = "IFNULL(SUM($col >= {$intervals[$count - 1]}), 0)";
        return implode(', ', $select);
    }

    public function actionErrorStat()
    {
        $this->pageTitle = '误差统计';

        $form = new FitErrorStatForm;
        $form->attributes = $_GET['FitErrorStatForm'];

        if (Helper::isEmpty($form->date)) {
            $form->date = date('Y-m-d', strtotime('-2 days'));
        }
        $month = date('Ym', strtotime($form->date));

        if (Helper::isEmpty($form->mode)) {
            $form->mode = 'day';
        }

        if (Helper::isEmpty($form->type)) {
            $form->type = 'all';
        }
        $type = $form->type == 'all' ? 'category' : $form->type;

        $criteria = new MyDbCriteria;
        $criteria->addColumnCondition(array('e.date' => $form->mode == 'day' ? $form->date : '0000-00-00 00:00:00'));
        foreach ($form->numberAttributes() as $attribute) {
            Helper::addCompareConditions($criteria, $form, array(ucfirst($attribute) => "e.$attribute"));
        }

        if ($form->type == 'all') {
            $criteria->join = 'LEFT JOIN item_category c ON e.cid = c.cid';
            $criteria->addCondition('c.level = 1 OR c.level IS NULL');
        }

        $intervals = array(0.02, 0.05, 0.1, 0.2, 0.3, 0.5);
        $select = $this->buildIntervalSelect('error', $intervals);

        $sql = "SELECT $select FROM estimate_{$type}_{$month} e {$criteria->join} WHERE {$criteria->condition}";
        $data = Yii::app()->db->createCommand($sql)->queryRow(false, $criteria->params);

        $this->render('error_stat', array(
            'form' => $form,
            'intervals' => $intervals,
            'data' => $data,
        ));
    }

    public function actionErrorReport()
    {
        $this->pageTitle = '误差报表';

        $intervals = array(0.2, 0.4, 0.6, 0.8);
        $count = count($intervals);

        for ($i = 2; $i < 9; $i++) {
            $time = strtotime("-$i days");
            $date = date('Y-m-d', $time);
            $month = date('Ym', $time);

            $select = array();
            foreach (array('head', 'tail') as $col) {
                $select[] = "IFNULL(SUM({$col}_r2 < 0.5), 0)";
                $select[] = $this->buildIntervalSelect("{$col}_r2", $intervals);
            }
            $select = implode(', ', $select);

            $sql = "SELECT $select FROM fit_parameter WHERE date = ?";
            $row = Yii::app()->db->createCommand($sql)->queryRow(false, array($date));
            $data[$date]['head_r2'] = array_slice($row, 0, $count + 2);
            $data[$date]['tail_r2'] = array_slice($row, $count + 2);

            foreach (array('all' => 0.05, 'shop' => 0.2, 'item' => 0.3, 'category' => 0.1) as $type => $error) {
                $select = implode(', ', array("IFNULL(SUM(e.error > $error), 0)", $this->buildIntervalSelect('error', $intervals)));
                $table = implode('_', array('estimate', ($type == 'all' ? 'category' : $type), $month));

                $criteria = new MyDbCriteria;
                $criteria->addColumnCondition(array('e.date' => $date));
                if ($type == 'all') {
                    $criteria->join = 'LEFT JOIN item_category c ON e.cid = c.cid';
                    $criteria->addCondition('c.level = 1 OR c.level IS NULL');
                }

                $sql = "SELECT $select FROM $table e {$criteria->join} WHERE {$criteria->condition}";
                $data[$date][$type] = Yii::app()->db->createCommand($sql)->queryRow(false, $criteria->params);
            }
        }

        $this->render('error_report', array(
            'intervals' => $intervals,
            'data' => $data,
        ));
    }
}
