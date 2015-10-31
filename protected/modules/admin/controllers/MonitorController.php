<?php
class MonitorController extends MyAdminController
{
    public function behaviors() {
        return array(
            'datePicker' => array('class' => 'DatePickerBehavior'),
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
    
    public function actionIndex($date=0)
    {
        $this->pageTitle = '系统监控';
        $date = $date?$date:date("Y-m-d", time());
        $sql = "SELECT * FROM monitor WHERE date BETWEEN :date - INTERVAL 6 DAY AND :date ORDER BY date DESC";
        $data = Yii::app()->db->createCommand($sql)->queryAll(true,array(':date' => $date,':date' => $date));
        foreach ($data as $i => $row) {
            foreach ($row as $key => $value) {
                $stat[$key][$i] = $value;
            }
        }
        $this->render('index', array(
            'data' => $stat,
        ));
    }
    
    public function actionYahooIndex($date=0)
    {
        $this->pageTitle = 'Yahoo!系统监控';
        $date = $date?$date:date("Y-m-d", time());
        $sql = "SELECT * FROM monitor WHERE date BETWEEN :date - INTERVAL 6 DAY AND :date ORDER BY date DESC";
        $data = Yii::app()->db4->createCommand($sql)->queryAll(true,array(':date' => $date,':date' => $date));
        foreach ($data as $i => $row) {
            foreach ($row as $key => $value) {
                $stat[$key][$i] = $value;
            }
        }
        $this->render('yahoo_index', array(
            'data' => $stat,
        ));
    }

    public function actionStatSpiderRakuten()
    {
        $this->pageTitle = '乐天爬虫统计';

        for ($i = 0; $i < 7; $i++) {
            $cols[] = "IFNULL(s$i.check, 0) check$i, IFNULL(s$i.sent, 0) sent$i";
            $sums[] = "SUM(IFNULL(s$i.check, 0)) check$i, SUM(IFNULL(s$i.sent, 0)) sent$i";
            $joins[] = "LEFT JOIN spider.stat s$i ON s$i.date = CURDATE() - INTERVAL $i DAY AND p.name = s$i.project";
        }
        $sql = 'SELECT p.id, p.full_name, p.priority, ' . implode(', ', $cols) . ' FROM spider.project p ' . implode(' ', $joins);
        $data = Yii::app()->db2->createCommand($sql)->queryAll(true);

        $sql = 'SELECT ' . implode(', ', $sums) . ' FROM spider.project p ' . implode(' ', $joins);
        $sum = Yii::app()->db2->createCommand($sql)->queryRow(true);

        $this->render('stat_spider', array(
            'data' => $data,
            'sum' => $sum,
        ));
    }

    public function actionStatCrawler()
    {   
        $form = new CrawlerSearchForm;
        $form->attributes = $_GET['CrawlerSearchForm'];
        
        $this->pageTitle = '爬虫统计';
        
        $minTime = $form->minDate." ".$form->minHour.":00:00";
        $maxTime = $form->maxDate." ".($form->maxHour+1).":00:00";
        
        if($form->minDate && $form->maxDate){
            $tmp1 = " record_time>='".$minTime."' and record_time<='".$maxTime."' ";
            $tmp2 = " datetime>='".$minTime."' and datetime<='".$maxTime."' ";
        }elseif($form->minDate){
            $tmp1 = " record_time>='".$minTime."' ";
            $tmp2 = " datetime>='".$minTime."' ";
        }else{
            $tmp1 = " record_time>=date_sub(now(), INTERVAL 5 hour) ";
            $tmp2 = " datetime>=date_sub(now(), INTERVAL 5 hour) ";
        }


        //日本
        $sql1 = "select date(record_time) dt , hour(record_time) hr,sum(success) success ,sum(block) block
from task_log force index(x_time)
where task_table_id=1 and ".$tmp1." group by dt,hr with rollup";
        //国内
        $sql2 = "select date(datetime) dt,hour(datetime) hr,sum(if(upload_success>0,upload_success,1)-1) success,count(blocked_project) block
from stat_spider_client
where ".$tmp2." group by dt,hr with rollup";
        
        $data1 = Yii::app()->db2->createCommand($sql1)->queryAll(true);
        $data2 = Yii::app()->db3->createCommand($sql2)->queryAll(true);

        $this->render('stat_crawler', array(
            'form' => $form,
            'data1' => $data1,
            'data2' => $data2,
        ));
    }
}
