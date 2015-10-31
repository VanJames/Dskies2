<?php
$this->pageTitle = '销售额统计';
$sum_fee = 0;
$sum_fee1 = 0;
$sum_fee2 = 0;
$sum_fee3 = 0;
?>
<div class="center_main" style="width: 500px;">
<?= CHtml::beginForm(array(''), 'GET',array('id' => 'searchForm')) ?>
    请输入检索条件:<br />
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">销售</th>
            <?php
                $salesHash["-1"] = "不限";
                $salesHash = $salesHash + CHtml::listData($sales, 'mid', 'name');
            ?>
            <td style="border-style: none"><?= CHtml::activeDropDownList($form, 'sales_id', $salesHash, array('class' => 'txt1', 'style' => 'width: 240px')) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">期间选择</th>
            <td style="border-style: none">
                <?php echo CHtml::activeDropDownList($form, 'minMonth', $monthRangeMax, array('class' => 'txt1', 'style' => 'width: 110px')); ?>
                ~
                <?php echo CHtml::activeDropDownList($form, 'maxMonth', $monthRangeMax, array('class' => 'txt1', 'style' => 'width: 110px')); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">类型</th>
            <td style="border-style: none">
                <?= CHtml::activeRadioButtonList($form, 'type', array("店铺详情","订单详情"), array('class' => 'txt1', 'style' => 'width: 20px','template'=>'{input}{label}','separator'=>""))?>
            </td>
        </tr>
    </table>
    <br />
    <?= CHtml::hiddenField('is_csv', 0, array('id' => 'is_csv')) ?>
    <?php if($form->type){
                echo "<button type='button' class='pull-right' onclick='csvDownload()'>订单详情下载</button>";
            }else{
                echo "<button type='button' class='pull-right' onclick='csvDownload()'>店铺详情下载</button>";
        }
    ?>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="center_main">
    <?php if($form->type):?>
        <table style="border-style: none">
            <tr>
                <th rowspan="2" style="width: 100px;">到款日期</th>
                <th rowspan="2" style="width: 100px;">客户编号</th>
                <th rowspan="2" style="width: 100px;">会员ID</th>
                <th rowspan="2" style="width: 100px;">公司名(汇款名称)</th>
                <th rowspan="2" style="width: 100px;">初月费用</th>
<!--             <th rowspan="2" style="width: 100px;">服务费用</th>
                <th rowspan="2" style="width: 20px;">月数</th>-->
                <th colspan="2" style="width: 200px;">服务期限</th>
                <?php 
                for ($i = 0;;$i++){
                    $str = date('Y-m-d',strtotime("+$i months", strtotime($form->minMonth.'-01')));
                    $month = date('Y',strtotime($str)).'年'.date('m',strtotime($str)).'月';
                    echo "<th colspan='2' style='width: 100px;'>$month</th>";
                    $sum[$str] = 0;
                    $start_fee_sum[$str] = 0;
                    if (strtotime($str) >= strtotime($form->maxMonth.'-01')) break;
                }
                ?>
            </tr>
            <tr>
                <th style="width: 100px;">开始</th>
                <th style="width: 100px;">结束</th>
                <?php 
                for ($i = 0;;$i++){
                    $str = date('Y-m-d',strtotime("+$i months", strtotime($form->minMonth.'-01')));
                    echo "<th style='width: 100px;'>初始费用</th>";
                    echo "<th style='width: 100px;'>费用</th>";
                    if (strtotime($str) >= strtotime($form->maxMonth.'-01')) break;
                }
                ?>
            </tr>
            <?php if($data): ?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td style="text-align: center"><?= $row['date']; ?></td>
                    <td style="text-align: center">LTJP<?= sprintf("%05d",$row['id']); ?></td>
                    <td style="text-align: center"><?= $row['name']; ?></td>
                    <td style="text-align: center;white-space: normal;width:150px"><?= strip_tags($row['company']); ?></td>
                    <td style="text-align: center"><?= $row['fee']; ?></td>
<!--                    <td style="text-align: center">6</td>
                    <td style="text-align: center">7</td>-->
                    <td style="text-align: center"><?= $row['start_month'] ? $row['start_month'] : preg_replace('/-01$/','',$row['month']); ?></td>
                    <td style="text-align: center"><?= $row['end_month'] ? $row['end_month'] : preg_replace('/-01$/','',$row['month']); ?></td>
                    <?php 
                        for ($i = 0;;$i++){
                            $str = date('Y-m-d',strtotime("+$i months", strtotime($form->minMonth.'-01')));
                            $start_fee = $str == $row["start_month"]."-01"?$row["start_fee"]:0;
                            echo "<td style='text-align: center'>".Util::myNumberFormat($start_fee)."</td>";
                            echo "<td style='text-align: center'>".Util::myNumberFormat($row["each_month"][$str])."</td>";
                            $start_fee_sum[$str] += $start_fee;
                            $sum[$str] += $row["each_month"][$str];
                            if (strtotime($str) >= strtotime($form->maxMonth.'-01')) break;
                        }
                    ?>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>
                <tr>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <?php 
                        for ($i = 0;;$i++){
                            $str = date('Y-m-d',strtotime("+$i months", strtotime($form->minMonth.'-01')));
                            echo "<td style='text-align: center'>".Util::myNumberFormat($start_fee_sum[$str])."</td>";
                            echo "<td style='text-align: center'>".Util::myNumberFormat($sum[$str])."</td>";
                            if (strtotime($str) >= strtotime($form->maxMonth.'-01')) break;
                        }
                    ?>
                </tr>
        </table>
    <?php endif;?>
                         
    <?php if(!$form->type):?>
        <table style="border-style: none">
            <tr>
                <th style="width: 100px;">shopName</th>
                <th style="width: 100px;">销售</th>
                <th style="width: 100px;">客户编号</th>
                <th style="width: 100px;">新增付款</th>
                <th style="width: 100px;">销售额(日币)</th>
                <th style="width: 100px;">当前待分摊销售额(日币)</th>
                <th style="width: 100px;">待分摊销售额(日币)</th>
                <th style="width: 100px;">操作</th>
            </tr>
            <?php foreach ($data as $row): 
                    if($row['fee'] || $row['fee2']){ ?>
                <tr>
                    <td style="text-align: center"><?= $row['shopName']; ?></td>
                    <td style="text-align: center"><?= $row['salesName'] ?></td>
                    <td style="text-align: center">LTJP<?= sprintf("%05d",$row['id']); ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($row['pay_fee'])) ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($row['fee'])) ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($row['fee2'])) ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($row['fee3'])) ?></td>
                    <td style="text-align: center">
                        <a href='<?= CHtml::normalizeUrl(array("client/examineStatBuy", "mid" => $row['mid'])) ?>' title="查看" target="_blank">查看</a>
                    </td>
                </tr>
            <?php }
                     $sum_fee += $row['pay_fee'];
                     $sum_fee1 += $row['fee'];
                     $sum_fee2 += $row['fee2'];
                     $sum_fee3 += $row['fee3'];
                     endforeach; ?>
                <tr>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($sum_fee)) ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($sum_fee1)) ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($sum_fee2)) ?></td>
                    <td style="text-align: center"><?= Util::myNumberFormat(floor($sum_fee3)) ?></td>
                    <td style="text-align: center"></td>
                </tr>
        </table>
    <?php endif;?>
    <?php  $this->widget('CLinkPager',array('pages'=>$pages));?>
</div>

<script type="text/javascript">
function csvDownload(){
    $('#is_csv').val(1);
    $('#searchForm').submit();
    $('#is_csv').val(0);
    return;
}</script>