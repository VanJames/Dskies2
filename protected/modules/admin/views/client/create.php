<?php
$this->pageTitle = '创建账号';
?>
<div class="center_main">
    <?= CHtml::beginForm(array(''), 'POST', array('id' => 'createForm')) ?>
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;"><?= CHtml::label('ID', '') ?>
            </th>
            <td style="border-style: none"><?= CHtml::textField('name', '', array('class' => 'txt1', 'style' => 'width: 236px', 'id' => 'name')) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;"><?= CHtml::label('密码', '') ?>
            </th>
            <td style="border-style: none"><?= CHtml::textField('pwd', '', array('class' => 'txt1', 'style' => 'width: 236px', 'id' => 'pwd')) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;"><?= CHtml::label('权限', '') ?></th>
            <td style="border-style: none"><?=
                CHtml::dropDownList('auth', 1, $authDropDownList, array('class' => 'txt1', 'style' => 'width: 240px', 'id' => 'auth'))
                ?></td>
        </tr>

    </table>
    <br/>
    <?= CHtml::submitButton('创建', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<script>var baseUrl = '<?php echo Yii::app()->baseUrl; ?>';</script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/main.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery/jquery.alert.js"></script>
<script type="text/javascript">
    $(function () {
        $('#createForm').submit(function () {
            if (checkForm()) {
                $.ajax({
                    url: baseUrl + '/admin/client/create',
                    type: 'POST',
                    data: $('#createForm').serialize(),
                    dataType: 'json',
                    success: function (resp) {
                        jAlert(resp.msg, resp.title, function () {
                            if (resp.ok) {
                                window.location.href = baseUrl + '/site/login';
                            } else {
                                window.location.href = baseUrl + '/admin/client/create';
                            }
                        });
                    }
                });
            }
            return false;
        });

        function checkForm() {
            var valid = false;
            if ($("#name").val().length === 0) {
                jAlert('ID不能为空');
                $('#id').focus();
            }
            else if ($("#pwd").val().length === 0) {
                jAlert('密码不能为空');
                $('#pwd').focus();
            }
            else {
                valid = true;
            }
            return valid;
        }
    });
</script>
