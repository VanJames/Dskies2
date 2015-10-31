<?php
$names = SuggestUtil::getAllExplosiveName();
$fieldWithNames = SuggestUtil::getAllFieldWithNames();
foreach($fieldWithNames as $key=>$value){
    if(in_array($key,$names) && $key != 'plan_max_up'){
        $check_lsit[$key] = $value;
    }
}
$stats_count = count($shopStats);
?>
<div class="center_main">
    <?= CHtml::beginForm('similar2', 'GET', array('id' => 'suggestForm')) ?>
    请输入:<br/>
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">目标店铺名</th>
            <td style="border-style: none"><?= CHtml::textField('shopName', $shopName) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">相似度</th>
            <td style="border-style: none"><?= CHtml::textField('similarity', $similarity) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">时间</th>
            <td style="border-style: none">
                <?php $this->datePicker('minDate', $minDate, array('style' => 'width: 120px'), $format = 'yy-mm-dd') ?>&nbsp;～&nbsp; 
                <?php $this->datePicker('maxDate', $maxDate, array('style' => 'width: 120px'), $format = 'yy-mm-dd') ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">类型</th>
            <td style="border-style: none"><?= CHtml::radioButtonList('type',$type, array(0=>'shop',1=>'item'), array('template'=>'{input}{label}','separator'=>"")) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">kpi排名百分比</th>
            <td style="border-style: none"><?= CHtml::textField('kpi_rank', $kpi_rank) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">kpi列表</th>
            <td style="border-style: none;white-space:normal"><?= CHtml::checkBoxList("kpi_list", $kpi_list, $check_lsit, array('class' => 'txt1', 'style' => 'width: 20px','template'=>'{input}{label}','separator'=>"")) ?>
            </td>
        </tr>
    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>
    
<div class="grid-view">
    <table class="items" id="mytable">
        <thead>
        <tr>
            <th>时间</th>
            <th>店铺名</th>
            <?php if($type ==1) echo "<th>item_code</th>"; ?>
            <th>上月销售额</th>
            <th>销售额飙量</th>
            <th>kpi名</th>
            <th>kpi数值</th>
            <th>kpi排名百分比</th>
            <th>飚量指数</th>
        </tr>
        </thead>
        <tbody>
        <?php 
            if($data): 
                foreach ($data as $key => $value): 
                    foreach ($names as $name): 
                        $explosive_name = $name."_explosive";
                        $kpi_list = $kpi_list?$kpi_list:$names;
                        if($value[$explosive_name]>2 && in_array($name,$kpi_list)):
                            if((($kpi_rank > 0) && (((($shopStats[$value["shop_id"]]['fieldsRank'][$name] > $standardStat[$name])) && ((round($shopStats[$value["shop_id"]]['fieldsRank'][$name] / $stats_count * 100))) >= $kpi_rank))) || $kpi_rank == 0):
                                $className = ($count % 2) ? 'odd' : 'even';
                                $count++;
                                echo "<tr class='".$className."'>";
                                echo "<td>".$value['date']."</td>";
                                echo "<td><a href='".Util::getShopUrl($value['name'])."' target='_blank'>".$value['name']."</a></td>";
                                if($type ==1) echo "<td>".Util::getItemUrl($value['name'], $value['item_code'], $value['item_code'])."</td>";
                                echo "<td>".Util::myNumberFormat($value['last_mon_sales_index'])."</td>";
                                echo "<td>".Util::explosiveNumberFormat($value['explosive_index'])."</td>";
                                echo "<td>".$fieldWithNames[$name]."</td>";
                                echo "<td>".$value[$name]."</td>";
                                echo "<td>".(($shopStats[$value["shop_id"]]['fieldsRank'][$name] > $standardStat[$name])? (round($shopStats[$value["shop_id"]]['fieldsRank'][$name] / $stats_count * 100) . '%') : "")."</td>";
                                echo "<td>".Util::explosiveNumberFormat($value[$explosive_name])."</td>";
                                echo "</tr>";
                            endif;
                        endif;
                    endforeach;
                endforeach;
            endif; ?>
        </tbody>
    </table>
</div>

<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(function(){
    $("#mytable").tablesorter({
        cssHeader: "header",
        cssAsc: "headerSortUp",
        cssDesc: "headerSortDown",
        headers: { 
        1:{ sorter: false},
		5:{ sorter: false},
		6:{ sorter: false},
		7:{ sorter: false},
		8:{ sorter: false},
    	}  
    });
});
</script>