<style type="text/css">
    .center_main td {
        white-space: normal
    }
</style>
<div class="center_main">
    <?= CHtml::beginForm(array('clientId'=>$client->id), 'POST') ?>
    客户信息一览:<br />
    <span class="red"><?php if($isSave) echo $isSave?"保存成功":"保存失败"; ?></span><br />
    <table style="border-style: none;float:left;width:500px">
		<tr>
			<th style="width: 100px;">用户名</th>
            <td style="border-style: none"><?= $member->name ?></td>
		</tr>
		<tr>
			<th style="width: 100px;">试用权限族<br>（csv下载，关注删除）</th>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'hasTrailTask', array("0"=>"无","1"=>"有"), array('class' => 'txt1', 'style' => 'width: 240px', 'options'=>array($form->hasTrailTask =>array("selected"=>1)))
                )
                ?></td>
		</tr>
		<tr>
			<th style="width: 100px;">过期天数</th>
            <?php 
                $trailDaysHash[0] = "不变";
                for($i=1;$i<=15;$i++)
                    $trailDaysHash[$i] = $i; 
            ?>
            <td style="border-style: none"><?=
                CHtml::activeDropDownList($form, 'trailDays', $trailDaysHash, array('class' => 'txt1', 'style' => 'width: 240px', 'options'=>array($form->trailDays =>array("selected"=>1)))
                )
                ?></td>
		</tr>
        <?php if($this->adminUser->member->authAssignment->itemname=='ServicePackSuperAdmin'): ?>
		<tr>
			<th style="width: 100px;">最大关注店铺数</th>
			<td style="border-style: none"><?= CHtml::activeTextField($form, 'noticeShopNumLimit', array('class' => 'txt1', 'style' => 'width: 236px', 'value'=>$memberAuth['noticeShopNumLimit'])) ?></td>
		</tr>
		<tr>
			<th style="width: 100px;">最大宝贝目录树</th>
			<td style="border-style: none"><?= CHtml::activeTextField($form, 'itemNumLimit', array('class' => 'txt1', 'style' => 'width: 236px', 'value'=>$memberAuth['itemNumLimit'])) ?></td>
		</tr>
		<tr>
			<th style="width: 100px;">最大关注广告数</th>
			<td style="border-style: none"><?= CHtml::activeTextField($form, 'analysisShopNumLimit', array('class' => 'txt1', 'style' => 'width: 236px', 'value'=>$memberAuth['analysisShopNumLimit'])) ?></td>
		</tr>
		<tr>
			<th style="width: 100px;">最大关注单品数</th>
			<td style="border-style: none"><?= CHtml::activeTextField($form, 'hitNumLimit', array('class' => 'txt1', 'style' => 'width: 236px', 'value'=>$memberAuth['hitNumLimit'])) ?></td>
		</tr>
        <tr>
            <th style="width: 100px;">最大关注EDC数</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'edcNumLimit', array('class' => 'txt1', 'style' => 'width: 236px', 'value'=>$memberAuth['edcNumLimit'])) ?></td>
        </tr>
		<tr>
			<th style="width: 100px;">类目</th>
			<td style="border-style: none">
                <?php
                    foreach($categorys as $i=>$category){
                        $checkBoxData[$category['cid']] = $category['name'];
                    }
                ?>
                <?= CHtml::activeCheckBoxList($form, 'categorys', $checkBoxData, array("checkAllLast"=>1)) ?>
            </td>
		</tr>
        <?php endif; ?>
    </table>

    <br style="clear:both"/>
    <?= CHtml::submitButton('提交', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
    <br />
</div>

