<?php
$this->pageTitle = '销售日志统计';
?>

<div class="center_main">
    <?= CHtml::beginForm(array(''), 'GET') ?>
    请输入检索条件:<br/>
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">销售日志统计</th>
            <?php
            $salesHash["0"] = "不限";
            $salesHash = $salesHash + CHtml::listData($sales, 'mid', 'name');
            ?>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'sales_id', $salesHash, array('class' => 'txt1', 'style' => 'width: 240px')
                )
                ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">创建时间</th>
            <td style="border-style: none"><?php $this->activeDatePicker($form, 'minDate', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
                &nbsp;～&nbsp; <?php $this->activeDatePicker($form, 'maxDate', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
            </td>
        </tr>

    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>
<div class="center_main">
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">名前</th>
            <th style="width: 100px;">初回電話</th>
            <th style="width: 100px;">キーマン</th>
            <th style="width: 100px;">トライアル発行</th>
            <th style="width: 100px;">初回ログイン</th>
            <th style="width: 100px;">デモ</th>
            <th style="width: 100px;">見積書発行</th>
            <th style="width: 100px;">入金</th>
        </tr>
        <?php foreach ($saleToStat as $salesId=>$row): ?>
            <?php if(!$form->sales_id || $form->sales_id==$salesId): ?>
            <tr>
                <td style="border-style: none; text-align: center"><?= $row['name']; ?></td>
                <?php for($i=1;$i<=7;$i++){
                    $clients[$i] .= $clients[$i] && $row[clients][$i]?",":"";
                    $clients[$i] .= $row[clients][$i];
                ?>
                <td style="border-style: none; text-align: center">
                    <?php if($row[$i]):?>
                        <form method='post' action='<?php echo Yii::app()->baseUrl; ?>/admin/client/list?use_ses=1' target="_blank">
                            <input type='hidden' name='clientIds' value='<?= $row[clients][$i] ?>'>
                            <input type='submit' value='<?= $row[$i] ?>' style='border:none;background:none;text-decoration:underline'>
                        </form>
                    <?php endif; ?>
                </td>
                <?php } ?>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (!empty($sumUp)): ?>
            <tr>
                <td style="border-style: none; text-align: center">总计</td>
                <?php for($i=1;$i<=7;$i++){ ?>
                    <td style="border-style: none; text-align: center">
                    <?php if($sumUp[$i]):?>
                        <form method='post' action='<?php echo Yii::app()->baseUrl; ?>/admin/client/list?use_ses=1' target="_blank">
                            <input type='hidden' name='clientIds' value='<?= $clients[$i] ?>'>
                            <input type='submit' value='<?= $sumUp[$i] ?>' style='border:none;background:none;text-decoration:underline'>
                        </form>
                    <?php endif; ?>
                    </td>
                <?php } ?>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>