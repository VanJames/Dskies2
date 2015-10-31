<?php
/**
 * 支持自定义按钮文字翻译
 * @author Elf-mousE <ni.jun@sh.adways.net>
 * @since 2014.05.06
 *
 * @usage
 * ...
 * array(
 *     'class' => 'ext.MyButtonColumn',
 *     'template' => '{button1}',
 *     'buttons' => array(
 *         'button1' => array(
 *             'label' => 'Yii::t("xxx", "xxx")',
 *             ...
 *         ),
 *     ),
 * ),
 * ...
 */
Yii::import('zii.widgets.grid.CGridColumn');

class MyButtonColumn extends CButtonColumn
{
    protected function renderButton($id, $button, $row, $data) {
        $right_str = '';
        if (in_array($id, array('top', 'topevent', 'category', 'event', 'coupon', 'asuraku', 'freeshipping', 'regular', 'gift', 'reward', 'email', 'cpc'))) {
            $right_str = isset($data->advertiseItems->$id) && $data->advertiseItems->$id ? '(' . $data->advertiseItems->$id . ')' : '';
        }
        if (isset($button['visible']) && !$this->evaluateExpression($button['visible'], array('row' => $row, 'data' => $data)))
            return;
        $label = isset($button['label']) ? $this->evaluateExpression($button['label'], array('row' => $row, 'data' => $data)) . $right_str : $id;
        $url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data' => $data, 'row' => $row)) : '#';
        $options = isset($button['options']) ? $button['options'] : array();
        if(isset($button['options']['shop_id']))
            $options['shop_id'] = $this->evaluateExpression($button['options']['shop_id'], array('data' => $data, 'row' => $row));
        if (!isset($options['title']))
            $options['title'] = $label;

        if (isset($button['activeParam'])) {
            $options['data-sid'] = $this->evaluateExpression($button['activeParam'], array('data' => $data, 'row' => $row));
        }
        if (isset($button['imageUrl']) && is_string($button['imageUrl']) && $button['imageUrl'])
            echo CHtml::link(CHtml::image($button['imageUrl'], $label), $url, $options);
        else
            echo CHtml::link($label, $url, $options);
    }
}