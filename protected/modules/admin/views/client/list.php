<div class="center_main">
    <?= CHtml::beginForm(array(''), 'GET') ?>
    请输入客户检索条件:<br/>
    <table style="border-style: none">
        <?php foreach (array('shopName', 'address', 'shopTitle', 'company', 'security') as $attribute): ?>
            <tr>
                <th style="width: 100px;"><?= CHtml::activeLabel($form, $attribute) ?>
                </th>
                <td style="border-style: none"><?= CHtml::activeTextField($form, $attribute, array('class' => 'txt1', 'style' => 'width: 236px')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th style="width: 100px;">最近30天销售额(千元)</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'minSalesIndex30', array('class' => 'txt1', 'style' => 'width: 101px')) ?>
                &nbsp;～&nbsp; <?= CHtml::activeTextField($form, 'maxSalesIndex30', array('class' => 'txt1', 'style' => 'width: 102px')) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">登陆次数</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'minLoginTimes', array('class' => 'txt1', 'style' => 'width: 101px')) ?>
                &nbsp;～&nbsp; <?= CHtml::activeTextField($form, 'maxLoginTimes', array('class' => 'txt1', 'style' => 'width: 102px')) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">是否自己创建</th>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'isCreaterSelf', array('0' => '不限', '1' => '是', '2' => '否'), array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">销售</th>
            <?php
            $salesHash["-2"] = "有销售";
            $salesHash["-1"] = "不限";
            $salesHash["0"] = "无销售";
            $salesHash = $salesHash + CHtml::listData($sales, 'mid', 'name');

            ?>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'sales_id', $salesHash, array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">是否销售</th>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'isSales', array('0' => '不限', '1' => '是', '2' => '否'), array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">类目</th>
            <?php
            $categorysHash["-1"] = "不限";
            $categorysHash = $categorysHash + CHtml::listData($categorys, 'cid', 'name');

            ?>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'categorys_id', $categorysHash, array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">客户状态</th>
            <?php
			$status["-2"] = "未成交";
            $status["-1"] = "不限";
            $status = $status + ClientLog::getShopStatusDropDown()
            ?>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'sales_status', $status, array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="chk_box">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'clients',
        'selectableRows' => 0,
        'cssFile' => Yii::app()->params['baseImageUrl'] . '/css/gridview/styles2.css',
        'columns' => array(
            array(
                'name' => 'shop_name',
                'type' => 'raw',
                'value' => 'CHtml::link("<p ".(!$data->shop->last_7_sales_index ? "class=\"red text-center\"" : "").">".$data->shop->name."</p>", Yii::app()->request->baseUrl."/admin/client/detail?clientId=".$data->id)',
            ),
            array(
                'name' => 'title',
                'type' => 'raw',
                'value' => '$data->shop->title',
            ),
            array(
                'name' => '会社名',
                'type' => 'raw',
                 'value' => '"<p ".($data->shop && $data->shop->getCompanyNum($data->shop->company) >1?"class=\"red text-center\"":"").">".strip_tags($data->shop->company)."</p>"'
            ),
            array(
                'name' => '店铺类目',
                'type' => 'raw',
                'value' => '$data->shop->mainCategory->name',
            ),
//            array(
//                'name' => '联系方式',
//                'type' => 'raw',
//                'value' => '$data->shop->tel',
//            ),
//            array(
//                'name' => '担当者',
//                'type' => 'raw',
//                'value' => 'MyHtml::eidt("security", $data->security, $data->id)',
//                'htmlOptions' => array('style' => 'width: 100px'),
//            ),
//            array(
//                'name' => '手机',
//                'type' => 'raw',
//                'value' => 'MyHtml::eidt("mobile", $data->mobile,$data->id)',
//                'htmlOptions' => array('style' => 'width: 100px'),
//            ),
//            array(
//                'name' => '电话',
//                'type' => 'raw',
//                'value' => 'MyHtml::eidt("phone", $data->phone,$data->id)',
//                'htmlOptions' => array('style' => 'width: 100px'),
//            ),
            array(
                'name' => 'last_30_sales_index',
                'type' => 'raw',
                'value' => '$data->shop->last_30_sales_index',
            ),
            array(
                'name' => '地址',
                'type' => 'raw',
                'value' => '$data->shop->city',
            ),
            array(
                'name' => '状态',
                'type' => 'raw',
                'value' => 'ClientLog::getShopStatusDescription($data->sales_status)',
                 'htmlOptions' => array('nowrap' => 'nowrap'),
            ),
            array(
                'name' => '创建人',
                'type' => 'raw',
                'value' => '$data->creater->name',
            ),
            array(
                'name' => '销售',
                'type' => 'raw',
                'value' => '$data->salesman->name',
            ),
            array(
                'name' => '登陆次数',
                'type' => 'raw',
                'value' => '$data->member->login_times',
            ),
            array(
                'name' => 'last_login_time',
                'type' => 'raw',
                'value' => '$data->member->last_login_time',
            ),
            array(
                'name' => '最近30天操作次数',
                'type' => 'raw',
                'value' => '$data->member->actionLog->last_30_login_times',
            ),
            array(
                'name' => 'last_operate_time',
                'type' => 'raw',
                'value' => '$data->last_sales_action_time',
            ),
            array(
                'name' => 'last_time',
                'type' => 'raw',
                'value' => '$data->member->expire_time',
            ),
            array(
                'class' => 'CButtonColumn',
                'header' => '操作',
                'template' => '{imitate}{editMember}{open}{email}{reset}{suggest}',
                'htmlOptions' => array('style' => 'width: 72px; text-align: center'),
                'buttons' => array(
                    'imitate' => array(
                        'label' => '模拟用户',
                        'url' => 'CHtml::normalizeUrl(array("client/imitate", "clientId" => $data->id))',
                        'imageUrl' => $this->module->imagePathUrl . '/imitate.gif',
                        'options' => array('target' => '_blank'),
                        'visible' => '(isset($data->member))',// && (!isset($data->salesman->mid) || ($data->salesman->mid==' . $this->adminUser->member->mid . '))',
                    ),
                    'editMember' => array(
                        'label' => '修改权限',
                        'url' => 'CHtml::normalizeUrl(array("client/editMember", "mid" => $data->member->mid))',
                        'imageUrl' => $this->module->imagePathUrl . '/member.gif',
                        'options' => array('target' => '_blank'),
                        'visible' => '(isset($data->member)) && ($data->member->authAssignment->itemname=="TrialMember" || ' . $this->adminUser->member->authAssignment->itemname . '=="ServicePackSuperAdmin")',
                    ),
                    'open' => array(
                        'label' => '开通试用',
                        'url' => 'CHtml::normalizeUrl(array("client/createTrial", "clientId"=> $data->id))',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'options' => array('target' => '_blank'),
//                        'options' => array('onclick' => 'ajaxOpenClient(event, this)'),
                        'visible' => 'empty($data->creater_id) && empty($data->member->mid)',
                    ),
                    'email' => array(
                        'label' => 'メール',
                        'url' => 'CHtml::normalizeUrl(array("client/sendEmail", "clientId"=> $data->id))',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'options' => array('target' => '_blank'),
                        'visible' => '(isset($data->member))',// && (!isset($data->salesman->mid) || ($data->salesman->mid==' . $this->adminUser->member->mid . '))',
                    ),
                    'reset' => array(
                        'label' => '重置',
                        'url' => 'CHtml::normalizeUrl(array("client/reset", "mid"=> $data->member->mid))',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'options' => array('onclick' => 'ajaxReset(event, this)'),
                        'visible' => 'isset($data->member) && Util::canReset($data->member->mid)',
                    ),
                    'suggest' => array(
                        'label' => '推薦',
                        'url' => 'CHtml::normalizeUrl(array("suggest/list", "shopName"=> $data->name))',
                        'htmlOptions' => array('style' => 'cursor:pointer'),
                        'options' => array('target' => '_blank'),
                        'visible' => 'SuggestUtil::canSeeSuggest($data->shop->shop_id)',
                    ),
                ),
            ),
        ),
    ));
    ?>
</div>

<script type="text/javascript">
    function view_display(id, tp) {
        $('#' + tp + '_view_' + id).hide();
        $('#' + tp + '_eidt_' + id).show();
        $('#' + tp + '_eidttext_' + id)[0].focus();
    }

    function eidt_display(id, tp, obj) {
        obj.value = obj.value.replace(/\s/g, "");
        if (obj.value != '') {
            var hiddentext = $('#' + tp + '_eidttext_hidden_' + id).val();
            if (hiddentext == obj.value) {
                $('#' + tp + '_view_' + id).show();
                $('#' + tp + '_eidt_' + id).hide();
            } else {
                var str = 'id=' + id + '&name=' + tp + '&value=' + obj.value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/admin/client/modifyClient",
                    data: str,
                    success: function (msg) {
                        if (msg) {
                            $('#' + tp + '_view_' + id).show();
                            $('#' + tp + '_eidt_' + id).hide();
                            $('#' + tp + '_view_' + id).html(obj.value);
                            $('#' + tp + '_eidttext_hidden_' + id).val(obj.value);
                        } else {
                            alert('操作失败' + msg);
                        }
                    }
                });
            }
        } else {
            $('#' + tp + '_view_' + id).show();
            $('#' + tp + '_eidt_' + id).hide();
        }
    }

    function ajaxOpenClient(e, obj) {
        if (confirm("确定要开通吗")) {
            doane(e);
            open(obj, obj.href);
        } else {
            doane(e);
        }
    }
    function ajaxReset(e, obj) {
        if (confirm("确定要重置吗")) {
            doane(e);
            open2(obj, obj.href);
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
                createrId: <?php echo $this->adminUser->member->mid; ?>
            },
            dataType: 'json',
            success: function (msg) {
                if (msg.ok) {
                    alert('操作成功');
                    obj.style.display = 'none';
                }
                else
                    alert('很抱歉,您没有权限作此操作!');
            }
        });
    }
    function open2(obj, url) {
        $.ajax({
            type: 'POST',
            url: url,
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
