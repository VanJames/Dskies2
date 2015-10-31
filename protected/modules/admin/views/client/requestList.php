<?php
$this->pageTitle = '请求列表';

function wrapRedSpan($str) {
    return '<span style="color:red">' . $str . '</span>';
}

function nearDeadline($date) {
    return date('Y-m-d', strtotime('+5 day')) > $date;
}

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
                CHtml::activeDropDownList($form, 'state', array('0' => '未付款', '1' => '已付款'), array('class' => 'txt1', 'style' => 'width: 240px')
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
    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="chk_box">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'requestList',
        'selectableRows' => 0,
        'columns' => array(
            array(
                'name' => 'id',
                'type' => 'raw',
                'value' => '$data->id',
            ),
            array(
                'name' => '订单号',
                'type' => 'raw',
                'value' => '(nearDeadline($data->date) && !$data->state) ? wrapRedSpan($data->request_id) : $data->request_id',
            ),
            array(
                'name' => 'date',
                'type' => 'raw',
                'value' => '$data->date',
            ),
            array(
                'name' => 'shop_name',
                'type' => 'raw',
                'value' => '$data->member->name',
            ),
            array(
                'name' => '创建时间',
                'type' => 'raw',
                'value' => '$data->created',
            ),
			array(
                'name' => 'pay_time',
                'type' => 'raw',
                'value' => '$data->pay_time',
            ),
            array(
                'name' => '金额',
                'type' => 'raw',
                'value' => '"￥".Util::myNumberFormat(floor(($data->fee?$data->fee:Request::getPrice($data->mid))*(Yii::app()->params["taxPercent"]+1)))',
            ),
            array(
                'name' => 'shop_id',
                'type' => 'raw',
                'value' => '$data->member->shop->shop_id',
            ),
            array(
                'name' => '状态',
                'type' => 'raw',
                'value' => '$data->state==1?"已付款":"未付款"',
            ),
            array(
                'class' => 'CButtonColumn',
                'header' => '操作',
                'template' => '{examine} {takeEffect}',
                'htmlOptions' => array('style' => 'width: 72px; text-align: center'),
                'buttons' => array(
                    'examine' => array(
                        'label' => '查看',
                        'url' => 'CHtml::normalizeUrl(array("client/examineRequest", "mid" => $data->member->mid, "id" => $data->request_id))',
                        'options' => array('target' => '_blank'),
                        'visible' => '(isset($data->member))',
                    ),
                    'takeEffect' => array(
                        'label' => '生效',
                        'url' => 'CHtml::normalizeUrl(array("client/requestTakeEffect", "orderId"=> $data->id))',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'options' => array('onclick' => 'ajaxTakeEffect(event, this)'),
                        'visible' => '$data->canSeeTakeEffect(' . $this->adminUser->id . ')',
                    ),
                ),
            ),
        ),
    ));
    ?>
</div>

<script type="text/javascript">
    function ajaxTakeEffect(e, obj) {
        if (confirm("确定要生效吗")) {
            doane(e);
            open(obj, obj.href);
        } else {
            doane(e);
        }
    }
    function ajaxTransform(e, obj) {
        if (confirm("确定要转为半年吗")) {
            doane(e);
            open(obj, obj.href);
        } else {
            doane(e);
        }
    }
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
                operatorId: <?php echo $this->adminUser->member->mid; ?>
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

</script>
