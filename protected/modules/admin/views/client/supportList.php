<div class="center_main">
    <?= CHtml::beginForm(array(''), 'GET') ?>
    请输入检索条件:<br />
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">是否回复</th>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'isReplay', array('0' => '否', '1' => '是', '2' => '不限'), array('class' => 'txt1', 'style' => 'width: 240px', 'options'=>array(0 =>array("selected"=>1)))
                )
                ?></td>
        </tr>
    </table>
    <br />
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="chk_box">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'supportList',
        'selectableRows' => 0,
        'columns' => array(
            array(
                'name' => 'id',
                'type' => 'raw',
                'value' => '$data->id',
            ),
            array(
                'name' => '店铺',
                'type' => 'raw',
                'value' => '$data->shop_name',
            ),
            array(
                'name' => '会社名',
                'type' => 'raw',
                'value' => '$data->company_name',
            ),
            array(
                'name' => '部门',
                'type' => 'raw',
                'value' => '$data->department_name',
            ),
            array(
                'name' => '担当',
                'type' => 'raw',
                'value' => '$data->name',
            ),
            array(
                'name' => '问题类型',
                'type' => 'raw',
                'value' => 'Support::getSupportTypeDescription($data->support_type)',
            ),
            array(
                'name' => '内容',
                'type' => 'raw',
                'value' => 'HtmlSnippet::showSupportDesc($data->description)',
            ),
            array(
                'name' => '创建时间',
                'type' => 'raw',
                'value' => '$data->create_time',
            ),
            array(
                'name' => '客户身份',
                'type' => 'raw',
                'value' => '$data->member->authAssignment->auth_item->description',
            ),
            array(
                'name' => '操作',
                'type' => 'raw',
                'value' => 'Util::makeMailToLink($data->email, Yii::app()->params->salesInspectorEmail, $data->description) . ($data->status ? "" : CHtml::button("标为已回复", array("class" => "mark", "data-sid" => $data->id)));',
            ),
        ),
    ));
    ?>
</div>

<script>var baseUrl = '<?php echo Yii::app()->baseUrl; ?>';</script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/main.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery/jquery.alert.js"></script>
<script type="text/javascript">
    $(function() {
        $(document).on('click', '.mark', function() {
            $this = $(this);
            jConfirm('mark reply, sure?', null, function(re) {
                if (re) {
                    $.ajax({
                        url: baseUrl + '/admin/client/markSupport',
                        type: 'POST',
                        data: {
                            supportId: $this.data('sid')
                        },
                        dataType: 'json',
                        success: function(resp) {
                            if (resp.ok) {
                                location.reload();
                            } else {
                                jAlert(resp.msg);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
