<div class="center_main">
    <span>
        <?php $this->datePicker('blablabla', $clientlog->date, array('class' => 'txt1', 'style' => 'width: 120px'), $format='yy-mm-dd') ?>
    </span>
    <button id="date_choose" type="button" class="btnRec" style="width:45px">检索</button>

    <div id="_getlogs">
        <?= CHtml::beginForm(array('clientId'=>$clientlog->client_id), 'POST') ?>
        <span class="red"><?php if($isSave) echo $saveResult?"保存成功":"保存失败"; ?></span><br />
        <table style="border-style: none">
            <tr>
    			<th style="width: 100px;">ショップID</th>
    			<td style="border-style: none"><?= $client->name ?></td>
    		</tr>
    		<tr>
    			<th style="width: 100px;">ショップ名</th>
    			<td style="border-style: none"><?= $client->shop->title ?></td>
    		</tr>
    		<tr>
    			<th style="width: 100px;">会社名</th>
    			<td style="border-style: none"><?= $client->shop->company ?></td>
    		</tr>
            <tr>
                <?php echo $clientlog->date;?>
    			<th style="width: 100px;">顧客ステッタス</th>
                <?php 
                    $status = $clientlog->status?$clientlog->status:$clientlog_status[0]->status;
                    $status = $status?$status:0;
                    $form->status = $status;
                    $allHash = array(1 => '初回電話',2 =>'キーマン',3 => 'トライアル発行',4 => '初回ログイン',5 => 'デモ',6 =>'見積書発行',7 =>'入金',8 =>'保留');
                    $statusHash = ($status && $status!=8) ?array_slice($allHash,$status-1,9-$status,ture):$allHash;
                    if(!$form->status)
                        $form->status = 1;
                ?>
                <td style="border-style: none"><?=
                    CHtml::activeRadioButtonList($form, 'status', $statusHash, array('class' => 'txt1', 'style' => 'width: 20px','template'=>'{input}{label}','separator'=>"")
                    )
                    ?></td>
    		</tr>
            <tr>
    			<th style="width: 100px;">営業アクション</th>
                <?php
                    $form->sales_action = explode(",",$clientlog->sales_action);
                    $actionHash = array(1 => '電話',2 => 'メール',3 =>'訪問');
                ?>
                <td style="border-style: none"><?=
                    CHtml::activeCheckBoxList($form, 'sales_action', $actionHash, array('class' => 'txt1', 'style' => 'width: 20px','template'=>'{input}{label}','separator'=>"")
                    )
                    ?></td>
    		</tr>
    		<tr>
    			<th style="width: 100px;">メモ</th>
               	<td style="border-style: none"><?= CHtml::activeTextArea($form, 'remark', array('class' => 'txt1', 'style' => 'width: 360px;height:180px', 'value'=>$clientlog->remark)) ?></td>
    		</tr>
        </table>
        <br />
        <?= CHtml::submitButton('提交', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
        <?= CHtml::endForm() ?>
    </div>
</div>

<div class="chk_box">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'alllogs',
        'selectableRows' => 0,
        'columns' => array(
            array(
                'name' => '日付',
                'type' => 'raw',
                'value' => 'CHtml::link($data->date, Yii::app()->request->baseUrl."/admin/client/editLog?clientId=".$data->client_id."&date=".$data->date)',
            ),
            array(
                'name' => '営業',
                'type' => 'raw',
                'value' => '$data->salesman->name',
            ),
            array(
                'name' => '顧客ステッタス',
                'type' => 'raw',
                'value' => 'ClientLog::getShopStatusDescription($data->status)',
            ),
            array(
                'name' => '営業アクション',
                'type' => 'raw',
                'value' => 'ClientLog::getSalesActionDescription($data->sales_action)',
            ),
            array(
                'name' => 'メモ',
                'type' => 'raw',
                'value' => '$data->remark',
            ),
            array(
                'name' => 'ログイン回数',
                'type' => 'raw',
                'value' => '$data->login_times',
            ),
            array(
                'name' => '操作回数',
                'type' => 'raw',
                'value' => '$data->action_num',
            ),

        ),
    ));
    ?>
</div>


<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery/jquery.scroll.js"></script>
<script>
$("#date_choose").click(function(){
    var date = $("#blablabla").val();
    location.href = '<?= CHtml::normalizeUrl(array("client/editLog", "clientId"=> $clientlog->client_id)) ?>'+'&date='+date;
});

</script>