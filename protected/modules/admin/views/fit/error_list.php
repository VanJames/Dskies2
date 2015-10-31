<div class="center_main">
<?php echo CHtml::form(array(''), 'GET'); ?>
请输入误差检索条件:<br />
<table style="border-style: none">
    <tr>
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'date'); ?></th>
        <td style="border-style: none">
            <?php   
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $form,
                'attribute' => 'date',
                'language' => 'zh_cn',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'size' => '10',
                    'maxlength' => '10',
                    'class' => 'form-control',
                ),
            ));
            ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'mode'); ?></th>
        <td style="border-style:none">
            <?php echo CHtml::activeRadioButtonList($form, 'mode', 
                            array('day' => '按日统计', 'month' => '按月统计'), 
                            array('class' => 'txt1', 'separator' => ' ', 'uncheckValue' => null)
            ); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'type'); ?></th>
        <td style="border-style:none">
            <?php echo CHtml::activeDropDownList($form, 'type', 
                            array('all' => '综合', 'shop' => '店铺', 'item' => '商品', 'category' => '类目'), 
                            array('class' => 'txt1', 'style' => 'width: 230px')
            ); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">名称</th>
        <td style="border-style: none"><?php echo CHtml::activeTextField($form, 'name', array('class' => 'txt1', 'style' => 'width: 230px')); ?></td>
    </tr>
    <?php foreach ($form->numberAttributes() as $attribute): ?>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold"><?php echo CHtml::encode($form->getAttributeLabel($attribute)); ?></th>
        <td style="border-style: none">
            <?php echo CHtml::activeTextField($form, 'min' . ucfirst($attribute), array('class' => 'txt1', 'style' => 'width: 101px')); ?>
            &nbsp;～&nbsp; 
            <?php echo CHtml::activeTextField($form, 'max' . ucfirst($attribute), array('class' => 'txt1', 'style' => 'width: 102px')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<br />
<?php echo CHtml::submitButton('提交', array('class' => 'btnRec', 'style' => 'width: 80px')); ?>
<?php echo CHtml::endForm(); ?>
</div>
<br />
<?php
    switch ($form->type) {
    case 'all':
    case 'category':
        $columns = array(
            'cid',
            array(
                'class' => 'CLinkColumn',
                'header' => '类目名',
                'labelExpression' => '$data["name"]',
                'urlExpression' => 'CHtml::normalizeUrl(array("fit/parameterDetail", "cid" => $data["cid"]))',
                'linkHtmlOptions' => array('target' => '_blank'),
            ),
            'level:text:级别'
        );
        break;
    case 'shop':
        $columns = array(
            'shop_id:text:Shop ID',
            array(
                'class' => 'CLinkColumn',
                'header' => '店铺名',
                'labelExpression' => '$data["title"]',
                'urlExpression' => '"http://www.rakuten.co.jp/{$data[\'name\']}/"',
                'linkHtmlOptions' => array('target' => '_blank'),
            ),
        );
        break;
    case 'item':
        $columns = array(
            'shop_id:text:Shop ID',
            'item_code:text: Item Code',
            array(
                'class' => 'CLinkColumn',
                'header' => '商品名',
                'labelExpression' => '$data["item_title"]',
                'urlExpression' => '"http://item.rakuten.co.jp/{$data[\'name\']}/{$data[\'item_code\']}"',
                'linkHtmlOptions' => array('target' => '_blank'),
            ),
            array(
                'class' => 'CLinkColumn',
                'header' => '店铺',
                'labelExpression' => '$data["shop_title"]',
                'urlExpression' => '"http://www.rakuten.co.jp/{$data[\'name\']}/"',
                'linkHtmlOptions' => array('target' => '_blank'),
            ),
        );
        break;
    }

    $columns = array_merge($columns, array(
        array(
            'type' => 'raw',
            'header' => '销售额',
            'value' => 'number_format($data["sales"], 0)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'type' => 'raw',
            'header' => 'μ',
            'value' => 'number_format($data["miu"], 0)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'type' => 'raw',
            'header' => '|μ| / 销售额',
            'value' => 'number_format(abs($data["miu"]) / $data["sales"], 4)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'type' => 'raw',
            'header' => 'σ',
            'value' => 'number_format($data["sigma"], 0)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'type' => 'raw',
            'header' => '2σ / 销售额',
            'value' => 'number_format(2 * $data["sigma"] / $data["sales"], 4)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'type' => 'raw',
            'header' => '误差',
            'value' => 'number_format($data["error"], 4)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
    ));

    if ($form->mode == 'day' && $form->type == 'item') {
        $columns[] = array(
            'type' => 'raw',
            'header' => 'R^2',
            'value' => 'isset($data["cid"]) ? CHtml::link(number_format($data["r2"], 4), array("fit/parameterDetail", "cid" => $data["cid"]), array("target" => "_blank")) : ""',
            'htmlOptions' => array('style' => 'text-align: right'),
        );
    }

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'sigma_list',
        'selectableRows' => 0,
        'columns' => $columns,
    ));
?>
