<?php

class ClientController extends MyAdminController {

    public $defaultAction = 'list';
    public $limit_public_num = 10;

    public function actions() {
        return array(
        );
    }

    public function behaviors() {
        return array(
            'datePicker' => array('class' => 'DatePickerBehavior'),
        );
    }

    public function actionList() {
        $this->pageTitle = '客户列表';
        $form = new ClientSearchForm;
        $form->attributes = $_GET['ClientSearchForm'];

        $criteria = new MyDbCriteria(array(
            'with' => array('shop', 'salesman', 'member', 'creater', 'shop.shopCategory', 'shop.mainCategory'),
        ));
        if($form->minAffiliateRate)
            $form->minAffiliateRate *= 10;
        if($form->maxAffiliateRate)
            $form->maxAffiliateRate *= 10;
        Helper::addCompareConditions($criteria, $form, array(
            'LoginTimes' => 'member.login_times',
            'SalesIndex30' => 'shop.last_30_sales_index',
            'AffiliateRate' => 'shop.affiliate_rate',
            'NoticedTimes' => 't.noticed_num',
        ));

        if ($form->isCreaterSelf == 1)
            $criteria->addCondition("t.creater_id=member.mid");
        elseif ($form->isCreaterSelf == 2)
            $criteria->addCondition("t.creater_id<>member.mid");

        // 处理销售日志过来的post请求
		if($_POST['clientIds'])
			Yii::app()->user->setState('clientIds', $_POST['clientIds']);

		//使用session
		if($_GET['use_ses'])
			$clientIds = Yii::app()->user->getState('clientIds');
		
		if($clientIds && preg_match("/(\d+,)*\d+/",$clientIds)){
			$criteria->addCondition("t.id in (".$clientIds .")");
		}

        if ($form->isSales == 1) {
            $criteria->addCondition("member.is_sales = 1");
        } elseif ($form->isSales == 2) {
            $criteria->addCondition("member.is_sales = 0");
        }

        $columns1 = array(
            't.name' => $form->shopName,
            'shop.address' => $form->address,
            'shop.title' => $form->shopTitle,
            'shop.company' => $form->company,
            'shop.security' => $form->security,
        );
        
        
        if($clientIds && preg_match("/(\d+,)*\d+/",$clientIds)){
            $criteria->addCondition("t.id in (".$clientIds .")");
            $form->sales_status = '-1';
            $form->sales_id = '-1';
        }
        else{
            //客户状态
    		if(!isset($form->sales_status) || $form->sales_status == -2){
    			$criteria->addCondition("t.sales_status<>7");
    		}else if($form->sales_status >= 0){
    			$columns['t.sales_status'] = $form->sales_status;
    		}
        }
			
        if(isset($form->sales_id)){
            if($form->sales_id!=-1){
                if($form->sales_id==-2)
                    $criteria->addCondition("t.sales_id<>0");
                else
                    $columns['t.sales_id'] = $form->sales_id;
            }
        }
        else{
            $criteria->addCondition("t.sales_id<>0");
        }
			
        if($form->categorys_id!="-1")
            $columns['shop.main_cid'] = $form->categorys_id;

        $criteria->addSearchConditions($columns1);
        if($columns)
            $criteria->addColumnCondition($columns);
        
        $sort = new CSort('Client');
        $sort->attributes['last_30_sales_index'] = array(
            'asc' => 'shop.last_30_sales_index',
            'desc' => 'shop.last_30_sales_index DESC',
            'label' => '最近30天销售额',
            'default' => 'asc',
        );/*
        $sort->attributes['affiliate_rate'] = array(
            'asc' => 'shop.affiliate_rate',
            'desc' => 'shop.affiliate_rate DESC',
            'label' => '佣金比例',
            'default' => 'asc',
        );
        $sort->attributes['noticed_num'] = array(
            'asc' => 't.noticed_num',
            'desc' => 't.noticed_num DESC',
            'label' => '被关注次数',
            'default' => 'asc',
        );*/
		//按照上次登录时间倒序排列
		$sort->attributes['last_login_time'] = array(
            'asc' => 'member.last_login_time',
            'desc' => 'member.last_login_time DESC',
            'label' => '上次登录时间',
            'default' => 'desc',
        );
		$sort->attributes['last_operate_time'] = array(
            'asc' => 't.last_sales_action_time',
            'desc' => 't.last_sales_action_time DESC',
            'label' => '最后销售行为时间',
            'default' => 'desc',
        );
		$sort->attributes['last_time'] = array(
            'asc' => 'member.expire_time',
            'desc' => 'member.expire_time DESC',
            'label' => '过期时间',
            'default' => 'desc',
        );
        $sort->defaultOrder = array('last_login_time' => true);


        $dataProvider = new CActiveDataProvider('Client', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $this->module->params->pageSize / 5),
            'sort' => $sort,
        ));
        

        $sales = Member::model()->findAll(array("condition" => "status=1"));

        $itemCategoryCriteria = new CDbCriteria();
        $itemCategoryCriteria->select = 'cid, name';
        $itemCategoryCriteria->condition = 'level = 1';
        $categorys = ItemCategory::model()->findAll($itemCategoryCriteria);

        if($form->minAffiliateRate)
            $form->minAffiliateRate /= 10;
        if($form->maxAffiliateRate)
            $form->maxAffiliateRate /= 10;
        $this->render('list', array(
            'form' => $form,
            'dataProvider' => $dataProvider,
            'sales' => $sales,
            'categorys' => $categorys,
        ));
    }

    public function actionDetail($clientId, $chartType = 1, $lineType = 1, $pieLevel = 1) {
        //require_once('vendor/autoload.php');
        $client = Client::model()->with(array('shop', 'member'))->findByPk($clientId);
        $form = new ClientDetailForm();

        if ($_POST) {
            $form->attributes = $_POST['ClientDetailForm'];
            $client->security = $form->security;
            $client->mobile = $form->mobile;
            $client->phone = $form->phone;
            $client->email = $form->email;
            $client->remark = $form->remark;
            if (isset($form->sales_id)) {
                $client->sales_id = $form->sales_id;
            }
            $isSave = 1;
            $saveResult = $client->save(false);
        }

        $sales = Member::model()->findAll(array("condition" => "status=1"));

        $dataProvider = new CActiveDataProvider('ClientLog', array(
            'criteria' => array(
                'condition' => 'client_id=' . $clientId,
                'order' => 'date DESC',
                'with' => 'salesman',
            ),
            'pagination' => array('pageSize' => $this->module->params->pageSize / 5),
        ));

        $db = Yii::app()->db;
        //TODO maybe date_format(date) need to change to date >= and date <= ?
        $sql_ad = "SELECT sum(a.ias_web+a.ias_mobile) as web_fee,
sum(a.ias_web) as web_fee_web,sum(a.ias_mobile) as web_fee_mobile,
sum(a.cpc_web_05_full+a.cpc_web_05_part+a.cpc_web_07+a.cpc_mobile_05_full+a.cpc_mobile_05_part+a.cpc_mobile_07) as cpc_fee,
sum(a.cpc_web_05_full+a.cpc_mobile_05_full) as cpc_fee_full,sum(a.cpc_web_05_part+a.cpc_mobile_05_part) as cpc_fee_part,sum(a.cpc_web_07+a.cpc_mobile_07) as cpc_fee_07
FROM ads_invest a
join shop s on s.shop_id=a.shop_id
join client c on c.name=s.name
where date_format(a.date,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m') and c.id=:id";
        $ad_fee = $db->createCommand($sql_ad)->queryRow(true, array(":id" => $clientId));

        $chartType = in_array($chartType, range(1, 3)) ? $chartType : 1;
        $shopSaleIndex = array();
        $saleTables = DBUtil::composeStatAllShopTables(date('Y-m-d', strtotime('-3 months')), date('Y-m-d'));
        foreach($saleTables as $tb) {
            $Ym = substr($tb, -6);
            $shopSaleIndex[$Ym] = $db->createCommand("SELECT sales_index FROM $tb WHERE shop_id = " . $client->shop->shop_id . " AND cid = 0")->queryScalar();
        }

        //生成折线图
        $itemSaleIndex = array();
        $monthToItems = array();
        $items = array();
        $lineType = in_array($lineType, range(0, 3)) ? $lineType : 0;
        $itemTables = $lineType ? array('stat_item_' . date('Ym', strtotime('-' . ($lineType - 1) . ' months'))) : DBUtil::composeStatItemTables(date('Y-m-d', strtotime('-2 months')), date('Y-m-d'));
        foreach($itemTables as $tb){
            $Ym = substr($tb, -6);
            //only one shop, so items can be distinguished by item_code
            $result = $db->createCommand("SELECT item_code FROM $tb WHERE shop_id = " . $client->shop->shop_id . " ORDER BY sales_index_total DESC LIMIT 3")->queryColumn();
            $monthToItems[$Ym] = $result;
            foreach ($result as $t) {
                if (!in_array($t, $items)){
                    array_push($items, $t);
                }
            }
        }
        $itemStr = "'" . implode("','", $items) . "'";
        $itemAllTables = DBUtil::composeStatItemTables(date('Y-m-d', strtotime('-3 months')), date('Y-m-d'));
        foreach ($itemAllTables as $tb) {
            $Ym = substr($tb, -6);
            $itemSaleIndex[$Ym] = array();

            $iSaleRows = $db->createCommand("SELECT item_code, sales_index_total FROM $tb WHERE shop_id = " . $client->shop->shop_id . " AND item_code IN ($itemStr)")->queryAll();
            $iToSales = array();
            foreach ($iSaleRows as $r) {
                $iToSales[$r['item_code']] = $r['sales_index_total'];
            }
            $itemSaleIndex[$Ym] = $iToSales;
        }
        $itemTitles = $db->createCommand("SELECT item_code, title FROM item WHERE shop_id = " . $client->shop->shop_id . " AND item_code IN ($itemStr)")->queryAll();
        $iToTitles = array();
        foreach ($itemTitles as $it) {
            $iToTitles[$it['item_code']] = $it['title'];
        }
        //折线图区域结束

        //生成饼图
        $pieLevel = in_array($pieLevel, range(1, 4)) ? $pieLevel : 1;
        $cidRow = $db->createCommand("SELECT ic.lv{$pieLevel}cid cid, ic.lv{$pieLevel}name name, sum(c.last_30_sales_index) sales_index FROM item i JOIN cur_item c ON i.shop_id = c.shop_id AND i.item_code = c.item_code
            JOIN item_category ic ON i.cid = ic.cid WHERE i.shop_id = :shop_id GROUP BY ic.lv{$pieLevel}cid HAVING cid > 0 ORDER BY sales_index DESC LIMIT 1")->queryRow(true, array(':shop_id' => $client->shop->shop_id));
        $cid = $cidRow['cid'];
        $cName = $cidRow['name'];

        $cLevel = $pieLevel + 1;
        $mainItemSale = $db->createCommand("SELECT ic.lv{$cLevel}cid, ic1.name, SUM(c.last_30_sales_index) sales_index FROM item i JOIN cur_item c ON i.shop_id = c.shop_id AND i.item_code = c.item_code JOIN item_category ic ON i.cid = ic.cid AND ic.lv{$cLevel}cid > 0
            JOIN item_category ic1 ON ic.lv{$cLevel}cid = ic1.cid AND ic1.parent_cid = :cid WHERE i.shop_id = :shop_id GROUP BY ic.lv{$cLevel}cid ORDER BY sales_index DESC ")->queryAll(true, array(":cid" => $cid, ":shop_id" => $client->shop->shop_id));
        $mainItemRank = $db->createCommand("SELECT ic.lv{$cLevel}cid, ic1.name, SUM(c.last_30_num) num FROM item i JOIN cur_item c ON i.shop_id = c.shop_id AND i.item_code = c.item_code JOIN item_category ic ON i.cid = ic.cid AND ic.lv{$cLevel}cid > 0
            JOIN item_category ic1 ON ic.lv{$cLevel}cid = ic1.cid AND ic1.parent_cid = :cid WHERE i.shop_id = :shop_id GROUP BY ic.lv{$cLevel}cid ORDER BY num DESC ")->queryAll(true, array(":cid" => $cid, ":shop_id" => $client->shop->shop_id));
        //饼图区域结束

        $this->render('detail', compact('client', 'sales', 'form', 'isSave', 'saveResult', 'dataProvider', 'ad_fee',
            'chartType', 'shopSaleIndex','items', 'itemSaleIndex', 'iToTitles', 'lineType', 'mainItemSale', 'mainItemRank', 'pieLevel', 'cName'));
    }

    public function actionEditMember($mid) {
        $this->pageTitle = '客户详情';
        $member = Member::model()->findByPk($mid);
        if(!$member){
            $this->renderError();
        }
        $memberAuth = unserialize($member->data);
        
        $form = new MemberForm();

        if ($_POST) {
            $form->attributes = $_POST['MemberForm'];
            if($member->authAssignment->itemname=='TrialMember' || $this->adminUser->member->authAssignment->itemname=='ServicePackSuperAdmin'){
                if($form->trailDays>0 && $form->trailDays<=15){
                    $member->expire_time = date("Y-m-d", strtotime("+" . $form->trailDays . " day"));
                }
            }
            
//            if($this->adminUser->member->authAssignment->itemname=='ServicePackSuperAdmin'){
                if(preg_match("/\d+/", $form->noticeShopNumLimit) && $form->noticeShopNumLimit<500)
                    $memberAuth['noticeShopNumLimit'] = $form->noticeShopNumLimit;
                if(preg_match("/\d+/", $form->itemNumLimit) && $form->itemNumLimit<500)
                    $memberAuth['itemNumLimit'] = $form->itemNumLimit;
                if(preg_match("/\d+/", $form->analysisShopNumLimit) && $form->analysisShopNumLimit<500)
                    $memberAuth['analysisShopNumLimit'] = $form->analysisShopNumLimit;
                if(preg_match("/\d+/", $form->hitNumLimit) && $form->hitNumLimit<500)
                    $memberAuth['hitNumLimit'] = $form->hitNumLimit;
                if(preg_match("/\d+/", $form->edcNumLimit) && $form->edcNumLimit<30)
                    $memberAuth['edcNumLimit'] = $form->edcNumLimit;
                $member->data= serialize($memberAuth);
//            }
            
            $member->save(false);
            
            if($form->hasTrailTask){
                $sql = "insert ignore auth_assignment (itemname, userid, flag) values ('TrialTask', $mid, 0)";
                Yii::app()->db->createCommand($sql)->execute();
            }
            else{
                $sql = "delete from auth_assignment where itemname='TrialTask' and userid=$mid";
                Yii::app()->db->createCommand($sql)->execute();
            }
            
//            if($this->adminUser->member->authAssignment->itemname=='ServicePackSuperAdmin'){
                $selectedCategorys = $form->categorys;
                if(is_array($selectedCategorys) && count($selectedCategorys)>0){
                    $sql = "delete from member_category where mid=$mid";
                    Yii::app()->db->createCommand($sql)->execute();
                    $sql = "insert ignore member_category (mid,cid) values ";
                    $sql = $sql."($mid," . implode("),($mid,", $selectedCategorys) . ")";
                    Yii::app()->db->createCommand($sql)->execute();
                }
//            }
            
            $isSave = 1;
        }
        
        $sql = "select itemname from auth_assignment where userid='$mid' and itemname='TrialTask'";
        $TrialTask = Yii::app()->db->createCommand($sql)->queryScalar();
        if($TrialTask)
            $form->hasTrailTask = 1;
        
        $form->categorys =  Yii::app()->db->createCommand("select cid from member_category where mid=$mid")->queryColumn();
        $categorys = Yii::app()->db->createCommand("select cid,name from item_category where level=1 and del_flag=0")->queryAll();
        $this->render('editMember', array(
            'member' => $member,
            'memberAuth' => $memberAuth,
            'form' => $form,
            'isSave' => $isSave,
            'categorys' => $categorys,
        ));
    }

    public function actionCreateTrial() {
        $this->pageTitle = '创建试用账号';
        $clientId = $_REQUEST['clientId'];
        $email = $_REQUEST['email'];
        if ($clientId && $email) {
            $sql = "select mid from member where email=:email";
            $mid = Yii::app()->db->createCommand($sql)->queryScalar(array(":email"=>$email));
            if($mid){
                $this->render("createTrial", array("duplicateEmail"=>1));
                return;
            }
            $this->createTrial($clientId, $email);
            $this->redirect(CHtml::normalizeUrl(array('client/sendEmail', 'clientId' => $clientId)));
        } else {
            $this->render("createTrial");
        }
    }

    public function actionSendEmail($clientId) {
        $this->pageTitle = '发邮件';
        $clientId = $_REQUEST['clientId'];
        if ($clientId) {
            $sql = "select c.id, m.email from member m join client c on m.name=c.name where c.id=:id";
            $info = Yii::app()->db->createCommand($sql)->queryRow(true, array(":id" => $clientId));
            $this->render("sendEmail", array('info' => $info));
        }
    }

    public function actionGetEmail() {
        $request = Yii::app()->request;
        $clientId = $request->getParam('clientId');
        $type = $request->getParam('type', 1);
        $db = Yii::app()->db;
        if ($clientId) {
            if ($type == 1) {
                $info = $db->createCommand("select m.origin_password, m.email, m.name, s.company from member m join client c on m.name=c.name join shop s on m.name=s.name where c.id=:id")->queryRow(true, array(":id" => $clientId));
                $this->render("email", array('info' => $info));
            } elseif ($type == 2) {
                $info = $db->createCommand("SELECT r.request_id requestId, r.date, r.fee, m.mid, m.name, m.email, s.company FROM request r JOIN member m ON r.mid = m.mid JOIN client c ON m.name = c.name LEFT JOIN shop s ON m.name = s.name WHERE c.id = :id AND r.date >= CURRENT_DATE AND r.date <= DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY ) AND r.state = 0 LIMIT 1")->queryRow(true, array(':id' => $clientId));
                if (empty($info)){
                    $info = array(
                        'company' => '',
                        'date' => '',
                        'fee' => '',
                        'requestId' => '',
                    );
                }
                $info['pay'] = Request::getPrice($info['mid']) * (Yii::app()->params["taxPercent"] + 1);
                $sales = $db->createCommand("SELECT c.name FROM member m JOIN client c ON m.name = c.name WHERE m.mid = :mid")->queryScalar(array(':mid' => $this->adminUser->member->mid));
                $this->render("payRemind2", array_merge($info, compact('sales')));
            }
        }
    }

    public function actionBuyList() {
        $form = new BuySearchForm;
        $form->attributes = $_GET['BuySearchForm'];

        $criteria = new MyDbCriteria();
        $criteria->alias = 'b';
        $criteria->with = array('member', 'member.shop','member.client');

        Helper::addCompareConditions($criteria, $form, array(
            'CreateTime' => 'b.create_time',
			'PayTime' => 'b.pay_time',//添加pay_time查询
            'TotalFee' => 'b.total_fee',
        ));

        if ($form->orderState == 1)
            $criteria->addCondition("b.order_state=1");
        elseif ($form->orderState == 2){
			$orderDate = date("Y-m-d", strtotime("-10 day",time()));
			$criteria->addCondition("b.order_state=0");
			$criteria->addCondition("b.create_time< :create_time");
			$criteria->params[':create_time']=$orderDate; 
		}
        elseif ($form->orderState == 0){
			$orderDate = date("Y-m-d", strtotime("-10 day",time()));
			$criteria->addCondition("b.order_state=0");
			$criteria->addCondition("b.create_time>= :create_time");
			$criteria->params[':create_time']=$orderDate;
		}
		
		$columns = array(
            'b.id' => $form->id,
            'shop.name' => $form->shopName,
        );
        $criteria->addColumnCondition($columns);
		
		//添加pay_time排序
		$sort = new CSort();
		$sort->attributes = array(
			'defaultOrder'=>'b.pay_time DESC',
			'pay_time'=>array(
				'asc'=>'b.pay_time',
				'desc'=>'b.pay_time desc',
				'label' => '生效时间',
			),
		); 

        $dataProvider = new CActiveDataProvider('Buy', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $this->module->params->pageSize / 5),
			'sort' => $sort,
        ));
		
        $this->render('buyList', array(
            'form' => $form,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionDefaultPayTime() {
        $orderId = Yii::app()->request->getParam('orderId');
        if ($orderId) {
            $date = Yii::app()->db->createCommand("SELECT if(date(date_add(m.expire_time, INTERVAL 1 DAY)) > curdate(), date_add(m.expire_time, INTERVAL 1 DAY), curdate()) FROM buy b JOIN member m ON b.mid = m.mid WHERE b.id = $orderId")->queryScalar();
            $result['payTime'] = date('Y/m/d', strtotime($date));
            $result['ok'] = true;
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionRequestList() {
        $form = new RequestSearchForm;
        $form->attributes = $_GET['RequestSearchForm'];

        $criteria = new MyDbCriteria();
        $criteria->alias = 'b';
        $criteria->with = array('member', 'member.shop');

        Helper::addCompareConditions($criteria, $form, array(
            'CreateTime' => 'b.create_time',
			'PayTime' => 'b.pay_time',//添加pay_time查询
        ));
		
		$columns = array(
            'b.request_id' => $form->id,
            'b.state' => $form->state,
            'shop.name' => $form->shopName,
        );
        $criteria->addColumnCondition($columns);
		$sort = new CSort('Request');
        $sort->attributes['date'] = array(
            'asc' => 'b.date',
            'desc' => 'b.date DESC',
            'label' => '截止时间',
            'default' => 'asc',
        );
		$sort->attributes['pay_time'] = array(
            'asc' => 'b.pay_time',
            'desc' => 'b.pay_time DESC',
            'label' => '生效时间',
            'default' => 'desc',
        );
		$sort->defaultOrder = array('date' => false);
        $dataProvider = new CActiveDataProvider('Request', array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array('pageSize' => $this->module->params->pageSize / 5),
        ));
        $this->render('requestList', array(
            'form' => $form,
            'dataProvider' => $dataProvider,
        ));
    }


    public function actionSupportList() {
        $this->pageTitle = '用户反馈列表';

        $form = new SupportSearchForm;
        $form->attributes = $_GET['SupportSearchForm'];
        $criteria = new MyDbCriteria();

        if ($form->isReplay == 0)
            $criteria->addCondition("t.status=0");
        elseif ($form->isReplay == 1)
            $criteria->addCondition("t.status=1");

        $criteria->with = array('member', 'member.authAssignment', 'member.authAssignment.auth_item');
        //$criteria->order = "t.id";
        $dataProvider = new CActiveDataProvider('Support', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $this->module->params->pageSize / 5),
        ));
        $this->render('supportList', compact('form', 'dataProvider'));
    }
	
	public function actionSaleList() {
        $this->pageTitle = '销售列表';
        $form = new SaleSearchForm;
        $form->attributes = $_GET['SaleSearchForm'];

        $criteria = new MyDbCriteria(array(
            'with' => array('client','salesman'),
        ));
		//$criteria->alias = 'client_log';
		
		if(empty($form->maxDate))
			$form->maxDate = date("Y-m-d");
		$form->minDate = date("Y-m-d",strtotime("-3 day",strtotime($form->maxDate)));
		Helper::addCompareConditions($criteria, $form, array(
            'Date' => 'date',
        ));
		
		if(isset($form->sales_id))
			if($form->sales_id != 0)
				$columns['client.sales_id'] = $form->sales_id;
				
		if($columns)
            $criteria->addColumnCondition($columns);
			
		$sort = new CSort('ClientLog');
        $sort->attributes['modified'] = array(
            'asc' => 't.modified',
            'desc' => 't.modified DESC',
            'label' => '最近有活动',
            'default' => 'desc',
        );
		$sort->defaultOrder = array('modified' => true);


        $dataProvider = new CActiveDataProvider('ClientLog', array(
            'criteria' => $criteria,
			'sort' => $sort,
            //'pagination' => array('pageSize' => $this->module->params->pageSize ),
        ));
		$dataProvider->pagination->pageSize = $dataProvider->getTotalItemCount();
		
		$sales = Member::model()->findAll(array("condition" => "status=1"));
		$data = $dataProvider->getData();
		foreach($data as $clientLog){
			$clientList[$clientLog->client->name] = $clientLog;
			$clientLogList[$clientLog->client->name][$clientLog->date] = $clientLog;
		}
		
		//var_dump($data);

        $this->render('saleList', array(
            'form' => $form,
            'dataProvider' => $dataProvider,
			'data' => $data,
			'sales' => $sales,
			'clientLogList' => $clientLogList,
			'clientList' => $clientList,
			'shopCount' => $shopCount,
			'maxDate' => $form->maxDate,
        ));
    }

	public function actionClientLogStat() {
        $form = new ClientLogForm;
        $form->attributes = $_GET['ClientLogForm'];
        
        if(!$form->minDate)
            $form->minDate = date("Y-m-01");
        if(!$form->maxDate)
            $form->maxDate = date("Y-m-d");
            
        $sql = "select c.client_id,c.date,c.status,c.sales_id,s.name from 
  (select c.client_id,max(c.date) as date from
    (SELECT distinct(c.client_id) as client_id
      FROM client_log c
      join member s on c.sales_id=s.mid and s.is_sales=1
      WHERE c.date<=:maxDate AND c.date>=:minDate
    ) t
    join client_log c on t.client_id=c.client_id and c.date<:minDate group by c.client_id
  )t
  join client_log c on t.client_id=c.client_id and t.date=c.date
  join member s on c.sales_id=s.mid
union
  SELECT c.client_id,date,c.status,c.sales_id,s.name
  FROM client_log c
  join member s on c.sales_id=s.mid and s.is_sales=1
  WHERE c.date<=:maxDate AND c.date>=:minDate order by date";
        $data = Yii::app()->db->createCommand($sql)->queryAll(true, array(":minDate"=>$form->minDate, ":maxDate"=>$form->maxDate));
        $saleToStat = array();
        $salesIds = Yii::app()->db->createCommand("SELECT mid FROM member WHERE is_sales = 1")->queryColumn();
        $clientStatus = array();
        foreach($data as $one){
            if($one['date']<$form->minDate){
                $clientStatus[$one['client_id']] = $one['status']==8?0:$one['status'];
            }
            else{
                if($one['status']==8){
                    $clientStatus[$one['client_id']] = 0;
                }
                else{
                    while(empty($clientStatus[$one['client_id']]) || $clientStatus[$one['client_id']]<$one['status']){
                        $clientStatus[$one['client_id']] +=1;
                        $salesId = $one['sales_id'];
                        $saleToStat[$salesId]['name'] = $one['name'];
                        $saleToStat[$salesId][$clientStatus[$one['client_id']]] += 1;
                        $saleToStat[$salesId]['clients'][$clientStatus[$one['client_id']]] .= $saleToStat[$salesId]['clients'][$clientStatus[$one['client_id']]]?",".$one['client_id']:$one['client_id'];
                    }
                }
            }
            
        }
//        var_dump($saleToStat);
        unset($saleToStat[0]);
        $sumUp = array();
        if (empty($form->sales_id)) {
            foreach($saleToStat as $stat) {
                for ($i = 1; $i < 8; $i ++){
                    $sumUp[$i] += $stat[$i] ? $stat[$i] : 0;
                }
            }
        }

		$sales = Member::model()->findAll(array("condition" => "status=1 AND is_sales = 1"));
        $this->render('clientLogStat', compact('form', 'sales', 'saleToStat', 'sumUp'));
    }

    public function actionModifyClient() {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $value = $_REQUEST['value'];

        if (in_array($name, array('security', 'mobile', 'phone', 'remark'))) {
            $istrue = Yii::app()->db->createCommand("update client set $name=:value where id=:id")->execute(array(':value' => $value, ':id' => $id));
        }

        if ($istrue) {
            echo'ok';
        } else {
            echo false;
        }
    }

    public function actionImitate() {
        $clientId = $_GET['clientId'];
        $record = Client::model()->with(array('member'))->findByPk($clientId);
        $userIdentity = new UserIdentity("", "");
        $userIdentity->setId($record->member->mid);
        Yii::app()->user->login($userIdentity);
        Yii::app()->user->setState('rakuten_sales_mid', $this->adminUser->member->mid);
        $this->redirect($this->createUrl('/stat/index'));
    }

    public function actionExamineBuy() {
        $request = Yii::app()->request;
        $mid = $request->getParam('mid');
        $id = $request->getParam('id');

        $userIdentity = new UserIdentity("", "");
        $userIdentity->setId($mid);
        Yii::app()->user->login($userIdentity);
        Yii::app()->user->setState('rakuten_sales_mid', $this->adminUser->member->mid);
        $this->redirect($this->createUrl('/personal/orderDetail?id=' . $id));
    }
    
    public function actionExamineStatBuy() {
        $request = Yii::app()->request;
        $mid = $request->getParam('mid');

        $userIdentity = new UserIdentity("", "");
        $userIdentity->setId($mid);
        Yii::app()->user->login($userIdentity);
        Yii::app()->user->setState('rakuten_sales_mid', $this->adminUser->member->mid);
        $this->redirect($this->createUrl('/personal/requestList'));
    }

    public function actionExamineRequest() {
        $request = Yii::app()->request;
        $mid = $request->getParam('mid');
        $id = $request->getParam('id');

        $userIdentity = new UserIdentity("", "");
        $userIdentity->setId($mid);
        Yii::app()->user->login($userIdentity);
        Yii::app()->user->setState('rakuten_sales_mid', $this->adminUser->member->mid);
        $this->redirect($this->createUrl('/personal/requestDetail?id=' . $id));
    }

    public function actionMarkSupport() {
        Yii::app()->db->createCommand("UPDATE support SET status = 1 WHERE id = {$_POST['supportId']}")->execute();
        $message['ok'] = TRUE;
        echo CJSON::encode($message);
        Yii::app()->end();
    }

    public function actionOpenClient() {
        $this->createTrial($_REQUEST['clientId']);
        $message['ok'] = TRUE;

        echo CJSON::encode($message);
        Yii::app()->end();
    }

    private function createTrial($clientId, $email = "") {
        $db = Yii::app()->db;
        $transaction = $db->beginTransaction();

        $client = Client::model()->with('member')->findByPk($clientId);
        $client->setCreaterId($this->adminUser->member->mid);
        $client->save();

        if (empty($client->member->mid)) {
            $data = serialize(Yii::app()->params['memberData']);
            $shop = Shop::model()->find('name = :name', array(':name' => $client->name));

            $password = rand(100000, 9999999);
            $member = new Member();
            $member->name = $client->name;
            $member->data = $data;
            $member->password = Member::hashPassword($password);
            $member->origin_password = $password;
            $member->email = $email;
            $member->security = $client->security;
            $member->mobile = $client->mobile;
            $member->phone = $client->phone;
            $member->created = date('Y-m-d H:i:s');
            $member->expire_time = date("Y-m-d H:i:s", strtotime("+" . Yii::app()->params->probationTime . " day"));
            $member->insert();

            $noticeCatalog = new NoticeCatalog();
            $noticeCatalog->mid = $member->mid;
            $noticeCatalog->name = Yii::app()->params['defaultNoticeCatalogName'];
            $noticeCatalog->insert();

            $shop_id1 = $shop->shop_id;
            $shop_id2 = Yii::app()->params['trialDefaultShopId'];
            $shop_id3 = Yii::app()->params['trialMarketingShopId'];
            $sql = "insert notice_shop (mid, shop_id, shop_flag, marketing_flag, insert_time, marketing_time) values
(:mid, :shop_id1, 1, 0, now(), 0), (:mid, :shop_id2, 1, 0, now(), 0), (:mid, :shop_id3, 0, 1, 0, now())";
            Yii::app()->db->createCommand($sql)->execute(array(":mid" => $member->mid, ":shop_id1" => $shop_id1, ":shop_id2" => $shop_id2, ":shop_id3" => $shop_id3));

            Member::assignAuth($member->mid, 'TrialMember');
            $this->noticeMainCategory($member->mid);
            
            #添加销售日志
            $client = Client::model()->find('name=:name', array(':name'=>$member->name));
            $clientlog = ClientLog::getClientLog($client->id, date("Y-m-d"), $client->sales_id);
            $clientlog->status = 3; #开通试用
            $clientlog->save(false);
        }

        $transaction->commit();
    }

    private function noticeMainCategory($mid) {
        $Ym = date('Ym', strtotime('-1 month', time()));
        $sql = "SELECT sa.cid FROM stat_all_shop_$Ym sa 
            JOIN (SELECT cid FROM item_category WHERE level = 1) t ON t.cid = sa.cid 
            JOIN (SELECT shop_id FROM shop s JOIN member m ON m.name = s.name AND m.mid = $mid) s ON sa.shop_id = s.shop_id
            ORDER BY sa.sales_index DESC LIMIT 1";
        $cid = Yii::app()->db->createCommand($sql)->queryScalar();

        if (empty($cid)) {
            $cid = Yii::app()->params['defaultCid'];
        }

        $memberCategory = new MemberCategory();
        $memberCategory->mid = $mid;
        $memberCategory->cid = $cid;
        $memberCategory->save();
    }

    public function actionTakeEffect() {
        $member = Member::model()->with('authAssignment')->findByPk($this->adminUser->member->mid);
        $orderId = Yii::app()->request->getParam('orderId');
        if (empty($orderId)) {
            $result['msg'] = '该订单不存在';
        } elseif ($member->authAssignment->itemname !== 'ServicePackSuperAdmin') {
            $result['msg'] = '很抱歉,您没有权限作此操作';
        } else {
            $result = Buy::takeEffect($orderId);
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionSalesDiscount() {
        $id = Yii::app()->request->getParam('id');
        $member = Member::model()->with('authAssignment')->findByPk($this->adminUser->member->mid);
        if (empty($id)) {
            $result['msg'] = '订单号不能为空';
        } elseif ($member->authAssignment->itemname !== 'ServicePackSuperAdmin' && $member->authAssignment->itemname !== 'ServicePackAdmin') {
            $result['msg'] = '很抱歉,您没有权限作此操作';
        } else {
            $percent = Yii::app()->request->getParam('percent');
            if(preg_match("/^\d+[\d\.]*$/",$percent) && $percent>=0 && $percent<=20){
                $buyInfo = Yii::app()->db->createCommand("select * from buy where id=:id")->queryRow(true,array(":id"=>$id));
                if($buyInfo['order_state']!=0){
                    $result['msg'] = '只能修改未生效订单';
                }
                else{
                    $month_fee = $buyInfo['category_fee']*$buyInfo['category_num']+$buyInfo['shop_fee']*$buyInfo['shop_num']+$buyInfo['item_fee']*$buyInfo['item_num']+$buyInfo['marketing_fee']*$buyInfo['marketing_num'];
                    $startFee = $buyInfo['startFee'];
                    $totalFee = $month_fee*($buyInfo['month_num'])+$startFee;
                    $totalFee -= $month_fee*$buyInfo['month_num']*$buyInfo['discount_percent']/100;
                    $totalFee -= $month_fee*$buyInfo['month_num']*$percent/100;
                    if($buyInfo['month_num']==12){
                        $totalFee -= $startFee;
                        if($buyInfo['is_all']){
                            $totalFee -= $month_fee*$buyInfo['month_num']*$buyInfo['allPay_discount_percent']/100;
                        }
                    }
                    $sql = "update buy set total_fee=:total_fee,sales_discount_percent=:sales_discount_percent where id=:id";
                    Yii::app()->db->createCommand($sql)->execute(array(":total_fee"=>$totalFee, ":sales_discount_percent"=>$percent, ":id"=>$id));
                    $result['msg'] = '操作成功';
                    $result['ok'] = true;
                }
            }
            else{
                $result['msg'] = '折扣数值错误';
            }
        }
        echo CJSON::encode($result);
    }

    public function actionSetTime() {
        $request = Yii::app()->request;
        $id = $request->getParam('orderId');
        $member = Member::model()->with('authAssignment')->findByPk($this->adminUser->member->mid);
        if (empty($id)) {
            $result['msg'] = '订单号不能为空';
        } elseif ($member->authAssignment->itemname !== 'ServicePackSuperAdmin' && $member->authAssignment->itemname !== 'ServicePackAdmin') {
            $result['msg'] = '很抱歉,您没有权限作此操作';
        } else {
            $payTime = $request->getParam('payTime');
            //TODO time validation
            if ($payTime >= 0) {
                $buyInfo = Yii::app()->db->createCommand("select * from buy where id=:id")->queryRow(true, array(":id" => $id));
                Yii::app()->db->createCommand("UPDATE buy SET pay_time = :pay_time, sales_time=now() WHERE id = :id")->execute(array(':pay_time' => $payTime, ':id' => $id));
                if (!$buyInfo['order_state'] && $payTime <= date('Y-m-d H:i:s')) {
                    $result = Buy::takeEffect($id);
                } else {
                    $result['msg'] = '操作成功';
                    $result['ok'] = true;
                }
            } else {
                $result['msg'] = '日期格式不对';
            }
        }
        echo CJSON::encode($result);
    }

    public function actionRequestTakeEffect() {
        $member = Member::model()->with('authAssignment')->findByPk($this->adminUser->member->mid);
        $orderId = Yii::app()->request->getParam('orderId');
        if (empty($orderId)) {
            $result['msg'] = '该订单不存在';
        } elseif ($member->authAssignment->itemname !== 'ServicePackSuperAdmin') {
            $result['msg'] = '很抱歉,您没有权限作此操作';
        } else {
            $result = Request::takeEffect($orderId);
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionTransform() {
        $member = Member::model()->with('authAssignment')->findByPk($this->adminUser->member->mid);
        $orderId = Yii::app()->request->getParam('orderId');
        if (empty($orderId)) {
            $result['msg'] = '该订单不存在';
        } elseif ($member->authAssignment->itemname !== 'ServicePackSuperAdmin') {
            $result['msg'] = '很抱歉,您没有权限作此操作';
        } else {
            $db = Yii::app()->db;
            $buy = $db->createCommand("SELECT * FROM buy WHERE id = $orderId FOR UPDATE ")->queryRow();
            $result['ok'] = false;
            if (empty($buy)) {
                $result['msg'] = '该订单不存在';
            } elseif($buy['order_state']) {
                $result['msg'] = '该订单已生效';
            } elseif($buy['month_num'] == 6) {
                $result['msg'] = '该订单已转为半年';
            } else {
                $db->createCommand("UPDATE buy SET month_num = 6, total_fee = total_fee / 2 WHERE id = $orderId")->execute();
                $result['ok'] = true;
                $result['msg'] = '操作成功';
            }
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionEditLog($clientId,$date=0) {
        $this->pageTitle = '日志编辑';
        $client = Client::model()->with(array('shop', 'member'))->findByPk($clientId);
        $date = $date?$date:date("Y-m-d", time());
        $time = date("Y-m-d H:i:s", time());
        $sales_id = $this->adminUser->member->mid;
        $clientlog = ClientLog::model()->find('client_id=:client_id and date=:date', array(':client_id'=>$clientId,':date'=>$date));



        $criteria = new CDbCriteria;
        $criteria->addCondition("client_id=$clientId and date<='$date'");
        $criteria->limit = 1;
        $criteria->order = 'date desc';
        $clientlog_status = ClientLog::model()->findAll($criteria);

        if(!$clientlog){
            $clientlog = new ClientLog;
            $clientlog->client_id = $clientId;
            $clientlog->date = $date;
            $clientlog->created = $time;
            next;
        }

        $form = new ClientLogForm();
        if ($_POST) {
            $form->attributes = $_POST['ClientLogForm'];
            if($clientlog_status[0]->status !=7 && $form->status == 7){
                $this->renderError();
            }
            
//            if(!$clientlog->status || $date == date("Y-m-d", time()) || $form->status==8 || $clientlog->status==8){
                $clientlog->status = $form->status;
                if(!$client->sales_status || $date == date("Y-m-d", time()) || $form->status==8){
                    $sql = "update client set sales_status = :sales_status where id =:id";
                    Yii::app()->db->createCommand($sql)->execute(array(":sales_status"=>$form->status,":id"=>$clientId));
                }
//            }
            $clientlog->sales_action = $form->sales_action?implode(",",$form->sales_action):"";
            $clientlog->remark = $form->remark;
            $clientlog->sales_id = $sales_id;
//            $clientlog->action_num += 1;

            $isSave = 1;
            $saveResult = $clientlog->save(false);
        }
        
        $dataProvider = new CActiveDataProvider('ClientLog', array(
            'criteria' => array(
                'condition'=>'client_id='.$clientId,
                'order'=>'date DESC',
                'with'=>'salesman',
            ),
            'pagination' => array('pageSize' => $this->module->params->pageSize / 5),
            'sort' => $sort,
        ));
        
        $this->render('editLog', array(
            'dataProvider' => $dataProvider,
            'clientlog' => $clientlog,
            'form' => $form,
            'client' => $client,
            'isSave' => $isSave,
            'saveResult' => $saveResult,
            'clientlog_status'=> $clientlog_status,
        ));
    }

    public function actionCreate() {
        $request = Yii::app()->request;
        $db = Yii::app()->db;
        $allAuth = $db->createCommand("SELECT name, description FROM auth_item WHERE type = 2")->queryAll();
        $authDropDownList = array();
        foreach ($allAuth as $key => $auth) {
            #想了下，这里不应该有创建正式账号的可能
            if ($auth['name'] != 'NormalMember') {
                $authDropDownList[$key] = $auth['description'];
            }
        }

        if ($request->isAjaxRequest) {
            if (!empty($_POST)) {
                $params['title'] = '创建账号';
                $params['ok'] = false;

                if ($this->adminUser->member->authAssignment->itemname == 'ServicePackSuperAdmin') {
                    $transaction = $db->beginTransaction();
                    $name = $request->getParam('name');
                    $exist = $db->createCommand("SELECT 1 FROM member WHERE name = '$name' LIMIT 1")->queryScalar();
                    if ($exist) {
                        $params['msg'] = '该帐号已被创建';
                        echo CJSON::encode($params);
                        exit;
                    }
                    $pwd = $request->getParam('pwd');
                    $password = Member::hashPassword($pwd);
                    $auth = $request->getParam('auth');
                    $authItem = $allAuth[$auth]['name'];
                    if ($authItem == 'NormalMember') {
                        $authItem = 'TrialMember';
                    }

                    $template = $db->createCommand("SELECT m.mid, m.data FROM member m JOIN auth_assignment a ON a.userid = m.mid WHERE a.itemname = '$authItem' AND m.data <> '' LIMIT 1")->queryRow();
                    $templateId = $template['mid'];
                    $data = $template['data'];
                    $created = date('Y-m-d H:i:s');
                    $expireGap = '';
                    switch($authItem) {
                        case 'NormalMember':
                            $expireGap = '+ 1 year';
                            break;
                        case 'ServicePackAdmin':
                            $expireGap = '+ 3 month';
                            break;
                        case 'ServicePackSuperAdmin':
                            $expireGap = '+ 1 year';
                            break;
                        case 'TrialMember':
                            $expireGap = '+ 15 day';
                            break;
                    }
                    $expire_time = date("Y-m-d H:i:s", strtotime($expireGap));
                    $status = in_array($authItem, array('ServicePackAdmin', 'ServicePackSuperAdmin')) ? 1 : 0;

                    $db->createCommand("INSERT INTO member (name, password, origin_password, data, status, created, expire_time) VALUES ('$name', '$password', '$pwd', '$data', $status, '$created', '$expire_time')")->execute();
                    $mid = $db->createCommand(" SELECT LAST_INSERT_ID()")->queryScalar();
                    $db->createCommand("INSERT INTO client (name) VALUES ('$name')")->execute();
                    $db->createCommand("INSERT INTO auth_assignment(itemname, userid, flag) VALUES ('$authItem', $mid, 1)")->execute();
                    #建默认关注目录
                    $defaultCatalogName = Yii::app()->params['defaultNoticeCatalogName'];
                    $db->createCommand("INSERT INTO notice_catalog (mid, name) VALUES ($mid, '$defaultCatalogName')")->execute();
                    $results = $db->createCommand("SELECT * FROM member_category m WHERE mid = $templateId")->queryAll();
                    $insertValues = array();
                    foreach ($results as $result) {
                        $insertValues[] = "($mid, {$result['cid']}, '{$result['expire_time']}', '{$result['modified']}')";
                    }
                    $valueStr = implode(',', $insertValues);
                    $insertSql = "INSERT INTO member_category (mid, cid, expire_time, modified) VALUES $valueStr";
                    $db->createCommand($insertSql)->execute();

                    $db->createCommand("INSERT notice_shop (mid, shop_id, shop_flag, marketing_flag, insert_time, marketing_time) VALUES (:mid, :shop_id1, 1, 0, now(), '0000-00-00 00:00:00'), (:mid, :shop_id2, 0, 1, '0000-00-00 00:00:00', now())")
                        ->execute(array(':mid' => $mid, ':shop_id1' => Yii::app()->params['trialDefaultShopId'], ':shop_id2' => Yii::app()->params['trialMarketingShopId']));

                    $params['msg'] = '操作成功，请用设定的账号与初始密码登陆验证一下';
                    $params['ok'] = true;
                    $transaction->commit();
                } else {
                    $params['msg'] = '很抱歉,您没有权限作此操作';
                }
                echo CJSON::encode($params);
            }
        } else {
            $this->render('create', compact('authDropDownList'));
        }
    }

    public function actionReset() {
        $request = Yii::app()->request;
        $params['ok'] = false;
        if ($request->isAjaxRequest) {
            $db = Yii::app()->db;
            $params['title'] = '重置帐号';

            $mid = $request->getParam('mid');
            $name = $db->createCommand("SELECT name FROM member WHERE mid = $mid LIMIT 1")->queryScalar();
            if (!Util::canReset($mid)) {
                $params['msg'] = '此帐号不能重置';
            } else {
                $transaction = $db->beginTransaction();

                $pwd = rand(100000, 9999999);
                $password = Member::hashPassword($pwd);
                $expire_time = date("Y-m-d H:i:s", strtotime("+ 7 day"));
                $db->createCommand("UPDATE member SET password = '$password', origin_password = '$pwd', login_times = 0, last_login_time = '0000-00-00 00:00:00', expire_time = '$expire_time' WHERE mid = $mid")->execute();
                $db->createCommand("DELETE FROM notice_shop WHERE mid = $mid")->execute();
                $db->createCommand("DELETE FROM notice_item WHERE mid = $mid")->execute();
                $db->createCommand("DELETE FROM notice_catalog WHERE mid = $mid")->execute();
                #建默认关注目录
                $defaultCatalogName = Yii::app()->params['defaultNoticeCatalogName'];
                $db->createCommand("INSERT INTO notice_catalog (mid, name) VALUES ($mid, '$defaultCatalogName')")->execute();
                $db->createCommand("DELETE FROM action_log WHERE mid = $mid")->execute();

                $params['msg'] = '操作成功，新生成的（账户名:密码）为（' . "$name:$pwd" . '）';
                $params['ok'] = true;
                $transaction->commit();
            }
            echo CJSON::encode($params);
        }
    }
    

    public function actionStatBuy() {
        $form = new StatBuySearchForm;
        $form->attributes = $_GET['StatBuySearchForm'];

        $minMonth = $form->minMonth?$minMonth = $form->minMonth . "-01":date("Y-m-01");
        $maxMonth = $form->maxMonth?$form->maxMonth . "-01":$maxMonth = date("Y-m-01");
        
        $form->minMonth = $form->minMonth?$form->minMonth : date("Y-m");
        $form->maxMonth = $form->maxMonth?$form->maxMonth : date("Y-m");
        $form->type =  isset($form->type)?$form->type:0;

        $request = Yii::app()->request;
        $isCsv = $request->getParam('is_csv', 0);

        if(!$form->type){
            $sql = "SELECT b.mid,sum(b.pay_fee) as pay_fee,sum(fee) as fee,m.name as shopName,s.name as salesName FROM stat_buy b
join member m on m.mid=b.mid
join client c on c.name=m.name
join member s on s.status=1 and s.is_sales=1 and c.sales_id=s.mid
where month>=:minMonth and month<=:maxMonth ";
            $criteria = array(":minMonth"=>$minMonth,":maxMonth"=>$maxMonth);

            if(isset($form->sales_id) && $form->sales_id!=-1){
                $sql .= "and s.mid=:mid group by mid";
                $criteria[":mid"] = $form->sales_id;
            }
            else{
                $sql .= "group by mid";
            }
            $data_csv = Yii::app()->db->createCommand($sql)->queryAll(true,$criteria);
            
            $page_criteria=new CDbCriteria();
            $pages = new CPagination(count($data_csv));
            $pages->pageSize = 20;
            $pages->applyLimit($page_criteria);
            $page_sql = $sql." LIMIT ".$pages->currentPage*$pages->pageSize.",".$pages->pageSize."";
            $data = Yii::app()->db->createCommand($page_sql)->queryAll(true,$criteria);

            $sql_2 = "SELECT b.mid,sum(fee) as fee FROM stat_buy b
join member m on m.mid=b.mid
join client c on c.name=m.name
join member s on s.status=1 and s.is_sales=1 and c.sales_id=s.mid
where month>:curMonth
group by b.mid";
            $sql_3 = "SELECT * FROM member_id m group by mid;";
            $sql_4 = "SELECT s.mid,sum(s.start_fee+s.fee) as fee FROM stat_buy_order s
join member m on s.mid=m.mid
join client c on m.name=c.name
join member sa on c.sales_id=sa.mid and sa.is_sales=1
join buy b on s.order_id=b.id and b.pay_time<:date + INTERVAL 1 month
where s.month>=:date + INTERVAL 1 month and s.type=1
group by s.mid";
            $sql_5 = "SELECT s.mid,sum(s.start_fee+s.fee) as fee FROM stat_buy_order s
join request r on s.type=2 and s.order_id=r.id and month>=:date + INTERVAL 1 month 
and r.pay_time<:date + INTERVAL 1 month
group by s.mid";
            $cur_fee = Yii::app()->db->createCommand($sql_2)->queryAll(true,array(":curMonth"=>date("Y-m-01")));
            $cur_fee = Util::i_array_column($cur_fee, 'fee', 'mid');
            $mid_id = Yii::app()->db->createCommand($sql_3)->queryAll(true);
            $mid_id = Util::i_array_column($mid_id, 'id', 'mid');
            $during_fee = Yii::app()->db->createCommand($sql_4)->queryAll(true,array(":date"=>$maxMonth));
            $during_fee = Util::i_array_column($during_fee, 'fee', 'mid');
            $type2_fee = Yii::app()->db->createCommand($sql_5)->queryAll(true,array(":date"=>$maxMonth));
            $type2_fee = Util::i_array_column($type2_fee, 'fee', 'mid');
            
            foreach($data as $key=>$row){
                $data[$key]["fee2"] = $cur_fee[$row["mid"]];    //fee2为当前待分摊销售额
                $data[$key]["id"] = $mid_id[$row["mid"]];
                $data[$key]["fee3"] = $during_fee[$row["mid"]] + $type2_fee[$row["mid"]];    //fee3为待分摊销售额
            }
            foreach($data_csv as $key=>$row){
                $data_csv[$key]["fee2"] = $cur_fee[$row["mid"]];    //fee2为当前待分摊销售额
                $data_csv[$key]["id"] = $mid_id[$row["mid"]];
                $data_csv[$key]["fee3"] = $during_fee[$row["mid"]];    //fee3为待分摊销售额
                if($type2_fee[$row["mid"]]){
                    $data_csv[$key]["fee3"] = $type2_fee[$row["mid"]];
                }
            }

            if($isCsv == 1){
                $fields = array('shopName' => 'shopName', 'salesName' => '销售', 'id' => '客户编号', 'pay_fee' => '新增付款', 
'fee' => '销售额(日币)','fee2' => '当前待分摊销售额(日币)','fee3' => '待分摊销售额(日币)');
                $head = array_map('strip_tags', $fields);
                $body = array();
                if (!empty($data_csv)) {
                    $sum_row = array();
                    foreach ($data_csv as $each) {
                        $row = array();
                        foreach (array_keys($fields) as $field) {
                            $row[$field] = $each[$field];
                            $sum_row[$field] += $row[$field];

                            if (in_array($field, array('pay_fee','fee', 'fee2' ,'fee3'))) {
                                $row[$field] = Util::myNumberFormat($row[$field]);
                            }
                            if ($field == "id") {
                                $row[$field] = "LTJP".sprintf("%05d",$each[$field]);
                            }
                            $row[$field] = strip_tags($row[$field]);
                        }
                        if($row["fee"] != 0 or $row["fee2"] != 0){
                            $body[] = $row;
                        }
                    }
                    foreach (array_keys($fields) as $field) {
                        if (in_array($field, array('pay_fee','fee', 'fee2' ,'fee3'))) {
                            $sum_row[$field] = Util::myNumberFormat($sum_row[$field]);
                        }else{
                            $sum_row[$field] = '';
                        }
                    }
                    $body[] = $sum_row;
                }
                CSV::download($head, $body);
                Yii::app()->end();
            }
        }else{
            $insert_sql = "insert into member_id (mid)
select mid from (SELECT s.* FROM stat_buy_order s
join member m on s.mid=m.mid
join shop sp on m.name=sp.name
join client c on m.name=c.name
join member ss on ss.mid=c.sales_id and ss.is_sales=1 group by mid) g
where not exists (select * from member_id where member_id.mid=g.mid)";
            Yii::app()->db->createCommand($insert_sql)->execute();
            
            $sql = "SELECT date(ifnull(b.pay_time,r.pay_time)) as date,mi.id,m.name,sp.company,left(b.pay_time,7) as start_month,left(b.pay_time+interval b.month_num-1 month,7) as end_month,s.month,s.type,s.order_id,s.fee,s.start_fee FROM stat_buy_order s
join member m on s.mid=m.mid
left join member_id mi on m.mid=mi.mid
join shop sp on m.name=sp.name
join client c on m.name=c.name
join member ss on ss.mid=c.sales_id and ss.is_sales=1
left join buy b on s.type=1 and s.order_id=b.id
left join request r on s.type=2 and s.order_id=r.id
where s.month>=:minMonth and s.month<=:maxMonth ";
            $criteria = array(":minMonth"=>$minMonth,":maxMonth"=>$maxMonth);
            if(isset($form->sales_id) && $form->sales_id!=-1){
                $sql .= " and ss.mid=:mid";
                $criteria[":mid"] = $form->sales_id;
            }
            $sql .= " order by mi.id,s.start_fee desc";
            
            $data_all = Yii::app()->db->createCommand($sql)->queryAll(true,$criteria);
            
//            $page_criteria=new CDbCriteria();
//            $pages = new CPagination(count($data_all));
//            $pages->pageSize = 60;
//            $pages->applyLimit($page_criteria);
//            $page_sql = $sql." LIMIT ".$pages->currentPage*$pages->pageSize.",".$pages->pageSize."";
//            $data_all = Yii::app()->db->createCommand($page_sql)->queryAll(true,$criteria);
            
            foreach($data_all as $info){
                $data[$info["order_id"]] = isset($data[$info["order_id"]])?$data[$info["order_id"]]:$info;
                $data[$info["order_id"]]["each_month"][$info["month"]] = $info["fee"];
            }

            if($isCsv == 1){
                $fields = array('date' => '到款日期', 'id' => '客户编号', 'name' => '会员ID','company' => '公司名(汇款名称)',
'fee' => '初月费用','start_month' => '服务期限-开始', 'end_month' => '服务期限-结束');
                for ($i = 0;;$i++){
                    $str = date('Y-m-d',strtotime("+$i months", strtotime($form->minMonth.'-01')));
                    $month = date('Y',strtotime($str)).'年'.date('m',strtotime($str)).'月';
                    $temp[$str] = $str;
                    $fields[$str."start_fee"] = $month."初始费用";
                    $start_tmp[$str] = $str."start_fee";
                    $fields[$str] = $month;
                    if (strtotime($str) >= strtotime($form->maxMonth.'-01')) break;
                }

                $head = array_map('strip_tags', $fields);
                $body = array();
                if (!empty($data)) {
                    foreach ($data as $each) {
                        $row = array();
                        foreach (array_keys($fields) as $field) {
                            $row[$field] = $each[$field];
                            
                            if(in_array($field, array('start_month','end_month'))){
                                $row[$field] = $each[$field] ? $each[$field] : preg_replace('/-01$/','',$each['month']);
                            }
                            if (in_array($field, array('fee'))) {
                                $row[$field] = Util::myNumberFormat($each[$field]);
                            }
                            if (in_array($field, $temp)) {
                                $row[$field] = Util::myNumberFormat($each["each_month"][$field]);
                            }
                            if (in_array($field, $start_tmp)) {
                                $row[$field] = $field == $each["start_month"]."-01start_fee"?Util::myNumberFormat($each["start_fee"]):0;
                            }
                            if ($field == "id") {
                                $row[$field] = "LTJP".sprintf("%05d",$each[$field]);
                            }
                            $row[$field] = strip_tags($row[$field]);
                        }
                        $body[] = $row;
                    }
                }
                CSV::download($head, $body);
                Yii::app()->end();
            }
        }

        $sales = Member::model()->findAll(array("condition" => "status=1 and is_sales=1"));
        $monthRangeMin = Util::getMonthRangeMin();
        $monthRangeMax = Util::getMonthRangeMax();
        $monthRangeMin = array_reverse($monthRangeMin);
        $monthRangeMax = array_reverse($monthRangeMax);

        $this->render('statBuy', array(
            'pages' => $pages,
            'data' => $data,
            'form' => $form,
            'sales' => $sales,
            'monthRangeMin' => $monthRangeMin,
            'monthRangeMax' => $monthRangeMax
        ));
    }

    public function actionRecommand() {
        $lastMonth = date("Ym",strtotime("-1 month"));
        $render_arr = array();
        $db = Yii::app()->db;
        $this->pageTitle = 'レコメンド作成';
        $render_arr['form'] = new RecommandSearchForm;
        $render_arr['form']->attributes = $_GET['Form'];

        $sql_packages = "select * from buy_package where del_flag=0 order by `order`";
        $render_arr['buyPackages'] = Yii::app()->db->createCommand($sql_packages)->queryAll();
        $render_arr['buyPrices'] = Yii::app()->params['buyPrice'];
        
        $sql_category = "SELECT cid,name FROM item_category i where level=1";
        $category = Yii::app()->db->createCommand($sql_category)->queryAll();
        $render_arr['category'] = Util::i_array_column($category, 'name', 'cid');

        if($_GET){
            $render_arr['shop'] = Shop::model()->find('name = :name', array(':name' => $render_arr['form']->shopName));
            $sql = "SELECT i.cid,i.name,s.sales_index FROM stat_all_shop_".$lastMonth." s join item_category i
on s.cid=i.cid and i.level=1 where shop_id= :shop_id order by sales_index desc limit 3";
            $sql_sum = "SELECT sum(sales_index) as sum FROM stat_all_shop_".$lastMonth." s join item_category i 
on s.cid=i.cid and i.level=1 where shop_id= :shop_id ";

            $sales = Yii::app()->db->createCommand($sql)->queryAll(true,array(":shop_id"=>$render_arr['shop']->shop_id));
            $render_arr['sum'] = Yii::app()->db->createCommand($sql_sum)->queryRow(true,array(":shop_id"=>$render_arr['shop']->shop_id));
            $render_arr['sales'] = Util::i_array_column($sales, 'sales_index', 'name');
            $render_arr['cids'] = Util::i_array_column($sales, 'cid');
            
            $client = Client::model()->find('name=:name', array(':name' => $render_arr['form']->shopName));
            $render_arr['clientId'] = $client->id;
        }

        if($_POST){
            $mid = Member::model()->find('name = :name', array(':name' => $render_arr['form']->shopName))->mid;
            $category_num = $_POST['category_num'];
            array_pop($category_num);
            $shop_num = $_POST['shop_num'];
            array_pop($shop_num);
            $item_num = $_POST['item_num'];
            array_pop($item_num);
            $marketing_num = $_POST['marketing_num'];
            array_pop($marketing_num);
            $month_num = $_POST['month_num'];
            $discount_name = $_POST['discount_name'];
            
            for($i=0;$i<count($category_num);$i++){
                $category_reasons[] = array('category'=> $_POST['category'][$i],'category_reasons'=>$_POST['category_reasons'][$i]);
            }
            for($i=0;$i<count($shop_num);$i++){
                $shop_reasons[] = $_POST['shop_reasons'][$i];
            }
            for($i=0;$i<count($item_num);$i++){
                $item_reasons[] = $_POST['item_reasons'][$i];
            }
            for($i=0;$i<count($marketing_num);$i++){
                $marketing_reasons[] = $_POST['marketing_reasons'][$i];
            }
            $arr = array($category_reasons,$category_num,$shop_reasons,$shop_num,$item_reasons,$item_num,$marketing_reasons,$marketing_num);
            foreach($arr as $key => $value){
                $arr[$key] = serialize($value);
            }
            $criteria = array(
                ':mid' => $mid,
                ':category_reasons' => $arr[0],
                ':category_num' => $arr[1],
                ':shop_reasons' => $arr[2],
                ':shop_num' => $arr[3],
                ':item_reasons' => $arr[4],
                ':item_num' => $arr[5],
                ':marketing_reasons' => $arr[6],
                ':marketing_num' => $arr[7],
                ':discount_name' => $discount_name,
                ':month_num' => $month_num
            );
            if($mid){
                $sql_insert = "replace into recommand (mid,category_reasons,category_num,
shop_reasons,shop_num,item_reasons,item_num,marketing_reasons,marketing_num,month_num,discount_name,created) 
values (:mid,:category_reasons,:category_num,:shop_reasons,:shop_num,
:item_reasons,:item_num,:marketing_reasons,:marketing_num,:month_num,:discount_name,now())";
                Yii::app()->db->createCommand($sql_insert)->execute($criteria);
                $render_arr['isSave'] = 1;
            }
        }
        if($_GET || $_POST){
            $mid = Member::model()->find('name = :name', array(':name' => $render_arr['form']->shopName))->mid;
            if($mid){
                $requests = $db->createCommand("SELECT * FROM recommand WHERE mid = $mid")->queryRow();
                if($requests){
                    $render_arr['month'] = $requests[month_num];
                    array_splice($requests,10,1);
                    //$discount_name = array_splice($requests,10,1)[discount_name];
                    foreach($requests as $key=>$value){
                        $requests[$key] = unserialize($value);
                    }
                    $render_arr['requests'] = $requests;
                }
                $render_arr['mid'] = $mid   ;
            }
        }
        

        $this->render('recommand', $render_arr);
    }

    public function actionStatBuySales(){
        $form = new StatBuySearchForm;
        $form->attributes = Yii::app()->request->getParam('StatBuySearchForm');
        if (!$form->minMonth) {
            $form->minMonth = date('Y-m', strtotime('first day of previous month'));
        }
        if (!$form->maxMonth) {
            $form->maxMonth = '2015-12';
        }
        $minMonth = $form->minMonth . '-01';
        $maxMonth = $form->maxMonth . '-01';
        $startDate = date('Y-m-d', strtotime('first day of this month', strtotime($minMonth)));
        $endDate = date('Y-m-d', strtotime('last day of this month', strtotime($maxMonth)));
        $sql = "SELECT sb.month, sum(sb.order_num) as order_num, sum(sb.order_fee) as order_fee, sum(sb.valid) as valid, sum(sb.first_fee) as first_fee, sum(sb.month_fee) as month_fee, sum(sb.first_fee) as first, sum(sb.fee) as fee, sum(sb.expected_month_fee) as expected_month_fee, sum(sb.expected_fee) as expected_fee
FROM stat_buy sb JOIN member m ON sb.mid = m.mid JOIN client c ON c.name = m.name JOIN member s ON c.sales_id = s.mid AND s.status = 1 AND s.is_sales = 1 WHERE sb.month >= :minMonth AND sb.month <= :maxMonth";
        $criteria = array(":minMonth"=>$startDate,":maxMonth"=>$endDate);
        if(isset($form->sales_id) && $form->sales_id!=-1){
            $sql .= " AND s.mid = :mid ";
            $criteria[":mid"] = $form->sales_id;
        }
        $sql .= ' GROUP BY sb.month';
        $records = Yii::app()->db->createCommand($sql)->queryAll(true, $criteria);
        $monthStat = array();
        foreach ($records as $r) {
            $monthStat[$r['month']] = $r;
        }
        $totalStat = array();
        $fields = array(
            'order_num',
            'order_fee',
            'valid',
            'first_fee',
            'month_fee',
            'first',
            'fee',
            'expected_month_fee',
            'expected_fee'
        );
        foreach ($fields as $f) {
            $totalStat[$f] = 0;
        }
        foreach ($monthStat as $stat) {
            foreach($fields as $field) {
                if ($field == 'valid') {
                    continue;
                }
                $totalStat[$field] += $stat[$field];
            }
        }

        $this->render('statBuySales', compact('form', 'monthStat', 'totalStat'));
    }

    public function actionDelRecommand() {
        if ($this->inAjax) {
            $message = '';
            $param = array();
            $mid = $_POST['mid'];
            $sql = "delete from recommand where mid=".$mid;

            $suc = Yii::app()->db->createCommand($sql)->execute();

            if ($suc) {
                $message = '成功';
                $param['ok'] = true;
            }else{
                $message = '删除失败';
            }

            $this->renderajax($message,'',$param);
        }
    }

}