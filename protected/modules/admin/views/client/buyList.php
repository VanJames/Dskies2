<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/css/DateTimePicker.css"/>
<script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/DateTimePicker.js"></script>

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/css/DateTimePicker-ltie9.css"/>
<script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/DateTimePicker-ltie9.js"></script>
<![endif]-->
<?php
$this->pageTitle = '订单列表';
?>
<div class="center_main">
    <?= CHtml::beginForm(array(''), 'GET') ?>
    请输入检索条件:<br/>
    <table style="border-style: none">

        <?php foreach (array('id', 'shopName') as $attribute): ?>
            <tr>
                <th style="width: 100px;"><?= CHtml::activeLabel($form, $attribute) ?>
                </th>
                <td style="border-style: none"><?= CHtml::activeTextField($form, $attribute, array('class' => 'txt1', 'style' => 'width: 236px')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th style="width: 100px;">订单状态</th>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'orderState', array('0' => '未付款', '1' => '已付款', '2' => '过期'), array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">创建时间</th>
            <td style="border-style: none"><?php $this->activeDatePicker($form, 'minCreateTime', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
                &nbsp;～&nbsp; <?php $this->activeDatePicker($form, 'maxCreateTime', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">生效时间</th>
            <td style="border-style: none"><?php $this->activeDatePicker($form, 'minPayTime', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
                &nbsp;～&nbsp; <?php $this->activeDatePicker($form, 'maxPayTime', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">总价</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'minTotalFee', array('class' => 'txt1', 'style' => 'width: 101px')) ?>
                &nbsp;～&nbsp; <?= CHtml::activeTextField($form, 'maxTotalFee', array('class' => 'txt1', 'style' => 'width: 101px')) ?>
            </td>
        </tr>
    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="chk_box">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'buyList',
        'selectableRows' => 0,
        'columns' => array(
            array(
                'name' => 'id',
                'type' => 'raw',
                'value' => '$data->id',
            ),
            array(
                'name' => 'shop_name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->member->name, Yii::app()->request->baseUrl."/admin/client/detail?clientId=".$data->member->client->id)',
            ),
            array(
                'name' => '订单类型',
                'type' => 'raw',
                'value' => '$data->type ? "追加" : "非追加"',
            ),
            array(
                'name' => '创建时间',
                'type' => 'raw',
                'value' => '$data->create_time',
            ),
            array(
                'name' => 'pay_time',
                'type' => 'raw',
                'value' => '$data->pay_time',
            ),
            array(
                'name' => '金额',
                'type' => 'raw',
                'value' => '"￥".Util::myNumberFormat(floor(PersonalUtil::computeFirstMonthFee($data->id)))',
            ),
            array(
                'name' => '总金额',
                'type' => 'raw',
                'value' => '"￥".Util::myNumberFormat(floor($data->total_fee*(1+Yii::app()->params[taxPercent])))',
            ),
            array(
                'name' => '期間(月)',
                'type' => 'raw',
                'value' => '$data->month_num',
            ),
            array(
                'name' => 'shop_id',
                'type' => 'raw',
                'value' => '$data->member->shop->shop_id',
            ),
            array(
                'name' => '状态',
                'type' => 'raw',
                'value' => '$data->order_state==1?"已付款":($data->create_time<date("Y-m-d", strtotime("-10 day",time()))?"过期":"未付款")',
            ),
            array(
                'class' => 'ext.MyButtonColumn',
                'header' => '操作',
                'template' => '{examine} {takeEffect} {discount}',
                'htmlOptions' => array('style' => 'width: 72px; text-align: center'),
                'buttons' => array(
                    'examine' => array(
                        'label' => '查看',
                        'url' => 'CHtml::normalizeUrl(array("client/examineBuy", "mid" => $data->member->mid, "id" => $data->id))',
                        'options' => array('target' => '_blank'),
                        'visible' => '(isset($data->member))',
                    ),
                    'takeEffect' => array(
                        'label' => '(!$data->type && ($data->pay_time > "0000-00-00 00:00:00")) ? "修改时间" : "生效"',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'activeParam' => '$data->type . "," . $data->id',
                        'options' => array('class' => 'for-effect'),
                        'visible' => 'Util::canSeeTakeEffect($data, ' . $this->adminUser->id . ')',
                    ),
                    'discount' => array(
                        'label' => '打折',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'activeParam' => '$data->id',
                        'options' => array('class' => 'for-discount', 'title' => '打折',),
                        'visible' => 'Util::canSeeDiscount($data, ' . $this->adminUser->id . ')',
                    ),
                ),
            ),
        ),
    ));
    ?>
</div>
<?= $this->renderPartial('/client/_discountPopup'); ?>
<?= $this->renderPartial('/client/_effectPopup'); ?>

<script type="text/javascript">
    function doane(event) {
        e = event ? event : window.event;
        if (!e)
            return;
        if (jQuery.browser.msie) {
            e.returnValue = false;
            e.cancelBubble = true;
        } else if (e) {
            e.stopPropagation();
            e.preventDefault();
        }
    }
    function open(obj, url) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                operatorId: <?= $this->adminUser->member->mid; ?>
            },
            dataType: 'json',
            success: function (resp) {
                if (resp.ok) {
                    alert(resp.msg);
                    obj.style.display = 'none';
                    location.reload();
                }
                else
                    alert(resp.msg);
            }
        });
    }

    jQuery('#buyList a.for-discount').live('click', function () {
        $('#orderId').val($(this).data('sid'))
        $('#discount-popup').modal('show')
        return false
    })
    jQuery('#buyList a.for-effect').live('click', function () {
        var ary = $(this).data('sid').split(",")
        if (ary[0] == 1) {
            $.ajax({
                url: '<?= Yii::app()->request->baseUrl; ?>/admin/client/setTime',
                type: 'GET',
                data: {
                    orderId: ary[1],
                    payTime: '2015-01-01 00:00:00'
                },
                dataType: 'json',
                success: function () {
                    location.href = '<?= Yii::app()->request->baseUrl; ?>/admin/client/buyList';
                }
            });
        } else {
            $('#orderId2').val(ary[1])
            $.ajax({
                url: '<?= Yii::app()->request->baseUrl; ?>/admin/client/defaultPayTime',
                type: 'GET',
                data: {
                    orderId: $("#orderId2").val()
                },
                dataType: 'json',
                success: function (result) {
                    if (result.ok) {
                        $('#defaultDate').val(result.payTime)
                        $("#dtBox").DateTimePicker({
                            defaultDate: $("#defaultDate").val(),
                            dateTimeFormat: "yyyy-MM-dd HH:mm:ss"
                        })
                        $('#effect-popup').modal('show')
                    }
                }
            });
        }
        return false
    })
</script>
<script src="<?= Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>

