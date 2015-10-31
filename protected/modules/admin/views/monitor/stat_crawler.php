<div class="center_main">
<?= CHtml::beginForm(array(''), 'GET') ?>
    请输入检索条件:<br />
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">创建时间</th>
            <td style="border-style: none"><?php $this->activeDatePicker($form, 'minDate', array('class' => 'txt1', 'style' => 'width: 150px')) ?>            </td>
            <td>
                <?=CHtml::activeDropDownList($form, 'minHour', array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23), array('style' => 'width: 40px','options'=>array($form->minHour=>array('selected'=>'selected')))) ?>
            </td>
            <td style="border-style: none">    &nbsp;～&nbsp; <?php $this->activeDatePicker($form, 'maxDate', array('class' => 'txt1', 'style' => 'width: 150px')) ?>
            <td style="border-style: none">
                <?=CHtml::activeDropDownList($form, 'maxHour', array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23), array('style' => 'width: 40px','options'=>array($form->maxHour=>array('selected'=>'selected')))) ?>
            </td>

        </tr>
    </table>
    <br />
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>
<div class="grid-view">
    <h5>日本爬虫</h5>
<table class="items">
    <thead>
        <tr>
            <th>日期</th>
            <th>时</th>
            <th>success</th>
            <th>block</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data1)): ?>
                <?php $count = 0; ?>
                <?php foreach ($data1 as $key => $value): ?>
                <?php $className = ($key % 2 == 0) ? 'odd' : 'even'; ?>
                <tr class="<?php echo $className; ?>">
                    <td style="text-align: center"><?php echo $value['dt']; ?></td>
                    <td style="text-align: center"><?php echo $value['hr']; ?></td>
                    <td style="text-align: center"><?php echo $value['success']; ?></td>
                    <td style="text-align: center"><?php echo $value['block']; ?></td>
                </tr>
                <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="13">没有数据</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<table class="items">
    <h5>中国爬虫</h5>
    <thead>
        <tr>
            <th>日期</th>
            <th>时</th>
            <th>success</th>
            <th>block</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data2)): ?>
                <?php $count = 0; ?>
                <?php foreach ($data2 as $key => $value): ?>
                <?php $className = ($key % 2 == 0) ? 'odd' : 'even'; ?>
                <tr class="<?php echo $className; ?>">
                    <td style="text-align: center"><?php echo $value['dt']; ?></td>
                    <td style="text-align: center"><?php echo $value['hr']; ?></td>
                    <td style="text-align: center"><?php echo $value['success']; ?></td>
                    <td style="text-align: center"><?php echo $value['block']; ?></td>
                </tr>
                <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="13">没有数据</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
