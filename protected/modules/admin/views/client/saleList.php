<div class="center_main">
<?= CHtml::beginForm(array(''), 'GET') ?>
    请输入检索条件:<br />
    <table style="border-style: none">
		<tr>
			<th style="width: 100px;">销售</th>
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
            <th style="width: 100px;">截止时间</th>
            <td style="border-style: none">
			<?php $this->activeDatePicker($form, 'maxDate', array('class' => 'txt1', 'style' => 'width: 120px')) ?>
            </td>
        </tr>
    </table>
    <br />
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>
<div>
<br />
<p><a href="#heji">查看合计</a></p>
</div>
<?php
 $css = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview/styles.css';
        Yii::app()->getClientScript()->registerCssFile($css);
?>
<div class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th >shop</th>
            <?php for ($j=0; $j<4;$j++): ?>
            <th><?php 
			$date=date("Y-m-d",strtotime("-$j day",strtotime($maxDate)));
			echo $date;
			?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    <?php if(!empty($clientLogList)) foreach ($clientLogList as $shops => $clientLog): ?>
        <?php $className = ($i++ % 2 == 0) ? 'odd' : 'even'; ?>
        <tr class="<?php echo $className; ?>">
            <td style="text-align: left; width:300px">
				<table>
					<tr>
						<th style="text-align: left; width:150px">商店</th>
						<td style="width:150px"><?=CHtml::link($shops, Yii::app()->request->baseUrl."/admin/client/detail?clientId=".$clientList[$shops]->client_id); ?></td>
						<?php $member=Member::model()->find(array("condition" => "name='$shops'"));?>
					<?php if(!empty($member)): ?>
					</tr>
					<tr>
						<th style="text-align: left; width:150px">登录总次数</th>
						<td style="width:150px"><?=$member->login_times ?></td>
					</tr>
					<tr>
						<th style="text-align: left; width:150px">上次登录时间</th>
						
						<td style="width:150px"><?=empty($member->last_login_time)?"":date("m-d",strtotime($member->last_login_time)) ?></td>
					</tr>
					<tr>
						<th style="text-align: left; width:150px">近30天操作次数</th>
						<td style="width:150px"><?=$member->actionLog->last_30_login_times ?></td>
					</tr>
					<?php endif; ?>
				</table>			
			</td>
            <?php for ($j=0; $j<4;$j++): ?>
            <td style="text-align: right; vertical-align: top; width:300px">
			<?php $date=date("Y-m-d",strtotime("-$j day",strtotime($maxDate)));?>
			<?php if(!empty($clientLog[$date])): ?>
						<table>
							<tr>
								<th style="text-align: left;width:100px">销售</th>
								<td style="width:200px"><?=$clientLog[$date]->salesman->name ?></td>
							</tr>
							<tr>
								<th style="text-align: left;width:100px">客户状态</th>
								<td style="width:200px"><?=ClientLog::getShopStatusDescription($clientLog[$date]->status) ?></td>
								<?php $shopCount[$date][$clientLog[$date]->status]++; ?>
							</tr>
							<tr>
								<th style="text-align: left;width:100px">销售行为</th>
								<td style="width:200px"><?=ClientLog::getSalesActionDescription($clientLog[$date]->sales_action) ?></td>
								<?php 
									$arrs=explode(",",$clientLog[$date]->sales_action);
									//if(!empty($arrs))
										foreach($arrs as $salesAction) $salesCount[$date][$salesAction]++;
								?>
							</tr>
							<tr>
								<th style="text-align: left;width:100px">登录次数</th>
								<td style="width:200px"><?=$clientLog[$date]->login_times ?></td>
							</tr>
							<tr>
								<th style="text-align: left;width:100px">操作次数</th>
								<td style="width:200px"><?=$clientLog[$date]->action_num ?></td>
							</tr>
							<tr>
								<th style="text-align: left;width:100px">备注</th>
								<td style="width:200px"><?php 
									$str = $clientLog[$date]->remark;
									// $len = 40;
									// if(strlen($str) > $len) echo '<span title="'.$str.'">'.Helper::strcut($str,0,$len).'...</span>';
									// else 
									echo $str;
								?></td>
							</tr>
						</table>
			<?php endif; ?>
			</td>
            <?php endfor; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
	<tbody>
	<tr>
            <td style="border-style: none"><a name="heji">客户状态合计</a></td>
            <?php for ($j=0; $j<4;$j++): ?>
            <td style="border-style: none"><?php 
			$date=date("Y-m-d",strtotime("-$j day",strtotime($maxDate)));
			for($sj=0; $sj<=8; $sj++)
				if($shopCount[$date][$sj]>0) echo ClientLog::getShopStatusDescription($sj)."(".$shopCount[$date][$sj].")";
			?></td>
            <?php endfor; ?>
        </tr>
		<tr>
			<td style="border-style: none">销售行为合计</td>
			<?php for ($j=0; $j<4;$j++): ?>
            <td style="border-style: none"><?php 
			$date=date("Y-m-d",strtotime("-$j day",strtotime($maxDate)));
			for($sj=1; $sj<=3; $sj++)
				if($salesCount[$date][$sj]>0) echo ClientLog::getSalesActionDescription($sj)."(".$salesCount[$date][$sj].")";
			?></td>
            <?php endfor; ?>
		</tr>
		</tbody>
</table>
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
            success: function(msg) {
                if (msg.ok) {
                    alert('操作成功');
                    obj.style.display = 'none';
                    location.reload();
                }
                else
                    alert('很抱歉,您没有权限作此操作!');
            }
        });
    }

</script>
