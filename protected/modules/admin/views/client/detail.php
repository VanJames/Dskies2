<style type="text/css">
    .center_main td {
        white-space: normal
    }
</style>
<?php
$this->pageTitle = '客户详情';
$intervals = range(0, 3);
$months = array();
foreach ($intervals as $i){
    $months[$i] = date('Ym', strtotime("-$i months"));
}

if ($mainItemSale) {
    $x = array();
    $y = array();
    $totalY = 0;
    $s = 0;
    $other = 0;
    foreach ($mainItemSale as $i => $value) {
        if ($i < 30) {
            $x[] = $value['name'];
            $y[] = $value['sales_index'];
            $cids[] = $value['cid'];
        } else {
            $other += $value['sales_index'];
        }
        $totalY += $value['sales_index'];
    }

    if ($other > 0) {
        $x[] = 'other';
        $y[] = $other;
    }

    $dataX = implode(",", $x);
    $dataY = implode(',', $y);
    $dataCids = implode(',', $cids);
}
//$cssPath = $this->module->getCssPathUrl();
//Yii::app()->clientScript->registerCssFile($cssPath . '/client.css');
?>
<div class="center_main">
    <?= CHtml::beginForm(array('clientId' => $client->id), 'POST') ?>
    客户信息一览:<br/>
    <span class="red"><?php if ($isSave) echo $saveResult ? "保存成功" : "保存失败"; ?></span><br/>
    <table style="border-style: none;float:left;width:500px">
        <tr>
            <th style="width: 100px;">shopName</th>
            <td style="border-style: none"><?= $client->name ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">Title</th>
            <td style="border-style: none"><?= $client->shop->title ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">会社名</th>
            <td style="border-style: none"><?= $client->shop->company ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">地址</th>
            <td style="border-style: none"><?= $client->shop->address ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">担当者</th>
            <td style="border-style: none"><?= $client->shop->security ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">联系电话</th>
            <td style="border-style: none"><?= $client->shop->tel ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">email</th>
            <td style="border-style: none;word-break:break-all"><?= $client->shop->email ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">登陆次数</th>
            <td style="border-style: none"><?= $client->member->login_times ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">上次登录时间</th>
            <td style="border-style: none"><?= $client->member->last_login_time ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">过期时间</th>
            <td style="border-style: none"><?= $client->member->expire_time ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">最近30天操作次数</th>
            <td style="border-style: none"><?= $client->member->actionLog->last_30_login_times ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">最近30天销售额</th>
            <td style="border-style: none"><?= $client->shop->last_30_sales_index ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">主营类目</th>
            <td style="border-style: none"><?= $client->shop->shopCategory->name ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">担当者</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'security', array('class' => 'txt1', 'style' => 'width: 236px', 'value' => $client->security)) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">手机</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'mobile', array('class' => 'txt1', 'style' => 'width: 236px', 'value' => $client->mobile)) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">电话</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'phone', array('class' => 'txt1', 'style' => 'width: 236px', 'value' => $client->phone)) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">E-mail</th>
            <td style="border-style: none"><?= CHtml::activeTextField($form, 'email', array('class' => 'txt1', 'style' => 'width: 236px', 'value' => $client->email)) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">状态</th>
            <td style="border-style: none"><?php
                $status = ClientLog::getShopStatusDropDown();
                echo $status[$client->sales_status];
                ?></td>
        </tr>
        <tr>
        <tr>
            <th style="width: 100px;">销售</th>
            <?php
            $salesHash = CHtml::listData($sales, 'mid', 'name');
            $salesHash[0] = "无销售";
            ?>
            <td style="border-style: none">
                <?php if ($this->adminUser->member->authAssignment->itemname == 'ServicePackSuperAdmin' || $client->sales_id == 0 || $this->adminUser->member->mid == $client->sales_id): ?>
                    <?= CHtml::activeDropDownList($form, 'sales_id', $salesHash, array('class' => 'txt1', 'style' => 'width: 240px', 'options' => array($client->sales_id => array("selected" => 1)))) ?>
                <?php else: ?>
                    <?= $salesHash[$client->sales_id] ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">备注</th>
            <td style="border-style: none"><?= CHtml::activeTextArea($form, 'remark', array('class' => 'txt1', 'style' => 'width: 360px;height:180px', 'value' => $client->remark)) ?></td>
        </tr>
    </table>
    <div>
        <table style="border-style: none">
            <tr>
                <th style="width: 100px;">上月销售额</th>
                <td style="border-style: none"><?= $client->shop->last_mon_sales_index ?></td>
            </tr>
            <?php $shopRankInfo = DBUtil::getLastMonthShopRank($client->shop->shop_id); ?>
            <tr>
                <th style="width: 100px;">上月最高销售额类目</th>
                <td style="border-style: none"><?= $shopRankInfo['0'] ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">上月最高销售额类目排名</th>
                <?php $shopRankInfo = DBUtil::getLastMonthShopRank($client->shop->shop_id); ?>
                <td style="border-style: none"><?= $shopRankInfo['1'] . "/" . $shopRankInfo['2'] ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">WEB广告(web+mobile)</th>
                <?php
                $advertiseInfo = $client->shop->advertiseShops->attributes;
                ?>
                <td style="border-style: none"><?= AdvertiseShops::webAdsSum($advertiseInfo) ?>
                    +<?= AdvertiseItems::webAdsSum($advertiseInfo) ?>
                    (<?= round($ad_fee['web_fee_web'], 2) ? round($ad_fee['web_fee_web'], 2) : 0 ?>
                    +<?= round($ad_fee['web_fee_mobile'], 2) ? round($ad_fee['web_fee_mobile'], 2) : 0 ?>)
                </td>
            </tr>
            <tr>
                <th style="width: 100px;">cpc广告(完全一致+部分一致+课金)</th>
                <td style="border-style: none"><?= $advertiseInfo['cpc_shop'] ?>+<?= $advertiseInfo['cpc'] ?>
                    (<?= round($ad_fee['cpc_fee_full'], 2) ? round($ad_fee['cpc_fee_full'], 2) : 0 ?>
                    +<?= round($ad_fee['cpc_fee_part'], 2) ? round($ad_fee['cpc_fee_part'], 2) : 0 ?>
                    +<?= round($ad_fee['cpc_fee_07'], 2) ? round($ad_fee['cpc_fee_07'], 2) : 0 ?>)
                </td>
            </tr>
            <tr>
                <th style="width: 100px;">mail广告</th>
                <td style="border-style: none"><?= $advertiseInfo['email_0_shop'] + $advertiseInfo['email_1_shop'] ?>
                    +<?= $advertiseInfo['email_0'] + $advertiseInfo['email_1'] ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">改名次数</th>
                <td style="border-style: none"><?= $advertiseInfo['title_change'] ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">改价次数</th>
                <td style="border-style: none"><?= $advertiseInfo['price_change'] ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">改point次数</th>
                <td style="border-style: none"><?= $advertiseInfo['point_change'] ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">30天最高销售额商品名</th>
                <td style="border-style: none">
                    <a href="http://item.rakuten.co.jp/<?= $client->shop->name ?>/<?= $client->shop->maxSalesItem30day->item_code ?>"
                       target="_blank">
                        <?= $client->shop->maxSalesItem30day->item->title ?>
                    </a>
                </td>
            </tr>
            <tr>
                <th style="width: 100px;">30天最高销售额商品销售额</th>
                <td style="border-style: none"><?= $client->shop->maxSalesItem30day->last_30_sales_index ?></td>
            </tr>
            <?php $rankInfo = DBUtil::getLastMonthItemRank($client->shop->maxSalesItem30day->item->shop_id, $client->shop->maxSalesItem30day->item->item_code); ?>
            <tr>
                <th style="width: 100px;">30天最高销售额商品类目</th>
                <?php
                $catStr = $rankInfo[0]['lv1name'];
                for ($i = 2; $i <= 5; $i++) {
                    if ($rankInfo[0]['lv' . $i . 'name'])
                        $catStr .= " >> " . $rankInfo[0]['lv' . $i . 'name'];
                }
                ?>
                <td style="border-style: none"><?= $catStr ?></td>
            </tr>
            <tr>
                <th style="width: 100px;">30天最高销售额商品类目排名</th>
                <td style="border-style: none"><?= $rankInfo['1'] . "/" . $rankInfo["2"] ?></td>
            </tr>
        </table>
        <table style="border-style: none" width="840px">
            <tr>
                <td><a id="btn1">shop売上推移</a></td>
                <td><a id="btn2">商品売上推移</a></td>
                <td><a id="btn3">主力商品構成</a></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div id="chart1" <?= $chartType == 1 ? '' : 'style="display:none"'?>></div>
                    <div id="list1" <?= $chartType == 1 ? '' : 'style="display:none"'?> align="center">

                        <span><今月売上><?= Util::myNumberFormat($shopSaleIndex[$months[0]])?>(千円)</span>
                        <span><先月売上><?= Util::myNumberFormat($shopSaleIndex[$months[1]])?>(千円)</span>
                        <span><2々月売上><?= Util::myNumberFormat($shopSaleIndex[$months[2]])?>(千円)</span>
                        <span><3々月売上><?= Util::myNumberFormat($shopSaleIndex[$months[3]])?>(千円)</span>
                    </div>
                    <div id="chart2" <?= $chartType == 2 ? '' : 'style="display:none"'?>></div>
                    <div id="radio2" <?= $chartType == 2 ? '' : 'style="display:none"'?> align="center">
                        <input type="radio" name="lineType" value="1" <?= $lineType == 1 ? 'checked' : '' ?>/>今月トップ3
                        <input type="radio" name="lineType" value="2" <?= $lineType == 2 ? 'checked' : '' ?>/>先月トップ3
                        <input type="radio" name="lineType" value="3" <?= $lineType == 3 ? 'checked' : '' ?>/>先々月トップ3
                        <input type="radio" name="lineType" value="0" <?= $lineType == 0 ? 'checked' : '' ?>/>全商品
                    </div>
                    <div id="chart3" <?= $chartType == 3 ? '' : 'style="display:none"'?>>
                        <table>
                            <tr>
                                <td colspan="2" align="center"><strong>直近30日売上:<?= empty($totalY) ? '' : Util::myNumberFormat($totalY) ?>(千円)</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><strong>——<?= empty($cName) ? '' : $cName ?>——</strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="chart3a" style="width: 420px"></div>
                                </td>
                                <td>
                                    <div id="chart3b" style="width: 420px"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="radio3" <?= $chartType == 3 ? '' : 'style="display:none"'?> align="center">
                        <input type="radio" name="pieLevel" value="1" <?= $pieLevel == 1 ? 'checked' : '' ?>/>全ジャンル
                        <input type="radio" name="pieLevel" value="2" <?= $pieLevel == 2 ? 'checked' : '' ?>/>第一階層
                        <input type="radio" name="pieLevel" value="3" <?= $pieLevel == 3 ? 'checked' : '' ?>/>第二階層
                        <input type="radio" name="pieLevel" value="4" <?= $pieLevel == 4 ? 'checked' : '' ?>/>第三階層
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear:both"/>
    <?= CHtml::submitButton('提交', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
    <br/>
    <?php if ((isset($client->member))): ?>
        <a href='<?= CHtml::normalizeUrl(array("client/imitate", "clientId" => $client->id)) ?>'>模拟用户</a>&nbsp;&nbsp;&nbsp;
    <?php endif ?>
    <?php if (empty($client->creater_id) && empty($client->member->mid)): ?>
        <a href='<?= CHtml::normalizeUrl(array("client/createTrial", "clientId" => $client->id)) ?>'>开通</a>&nbsp;&nbsp;&nbsp;
    <?php endif ?>
    <?php if ((isset($client->member))): ?>
        <a href='<?= CHtml::normalizeUrl(array("client/sendEmail", "clientId" => $client->id)) ?>'
           target='_blank'>发邮件</a>&nbsp;&nbsp;&nbsp;
    <?php endif ?>
    <a href='<?= CHtml::normalizeUrl(array("client/editLog", "clientId" => $client->id)) ?>' target='_blank'>编辑日志</a>&nbsp;&nbsp;&nbsp;
    <a href='<?= CHtml::normalizeUrl(array("client/editMember", "mid" => $client->member->mid)) ?>' target='_blank'>修改权限</a>&nbsp;&nbsp;&nbsp;
    <a href='<?= CHtml::normalizeUrl(array("suggest/list", "shopName"=> $client->name)) ?>' target='_blank'>店铺推荐</a>&nbsp;&nbsp;&nbsp;
</div>

<div class="chk_box">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'id' => 'alllogs',
        'selectableRows' => 0,
        'columns' => array(
            array(
                'name' => '日期',
                'type' => 'raw',
                'value' => 'CHtml::link($data->date, Yii::app()->request->baseUrl."/admin/client/editLog?clientId=".$data->client_id."&date=".$data->date,ClientLog::getHtmlOption())',
            ),
            array(
                'name' => '销售',
                'type' => 'raw',
                'value' => '$data->salesman->name',
            ),
            array(
                'name' => '客户状态',
                'type' => 'raw',
                'value' => 'ClientLog::getShopStatusDescription($data->status)',
                'htmlOptions' => array('style' => 'width: 80px;'),
            ),
            array(
                'name' => '销售行为',
                'type' => 'raw',
                'value' => 'ClientLog::getSalesActionDescription($data->sales_action)',
            ),
            array(
                'name' => '备注',
                'type' => 'raw',
                'value' => '$data->remark',
            ),
            array(
                'name' => '用户登录次数',
                'type' => 'raw',
                'value' => '$data->login_times',
                'htmlOptions' => array('style' => 'width: 70px;'),
            ),
            array(
                'name' => '用户操作次数',
                'type' => 'raw',
                'value' => '$data->action_num',
                'htmlOptions' => array('style' => 'width: 70px;'),
            ),

        ),
    ));
    ?>
</div>
<?php
if ($shopSaleIndex) {
    $xAxis1 = json_encode(array_keys($shopSaleIndex));
    $data1 = implode(',', $shopSaleIndex);
}
if ($items) {
    $Yms2 = array_keys($itemSaleIndex);
    $xAxis2 = json_encode($Yms2);
    $itemData = array();
    foreach ($items as $i) {
        $itemData[$i] = array();
        $itemData[$i]['name'] = $iToTitles[$i];
        $tmp2 = array();
        foreach ($Yms2 as $t) {
            array_push($tmp2, empty($itemSaleIndex[$t][$i]) ? 0 : $itemSaleIndex[$t][$i]);
        }
        $itemData[$i]['data'] = '[' . implode(',', $tmp2) . ']';
    }
    $seriesAry2 = array();
    foreach ($itemData as $iD) {
        array_push($seriesAry2, "{name:'" . addslashes($iD['name']) . "',data:" . $iD['data'] . "}");
    }
    $series2 = '[' . implode(',', $seriesAry2) . ']';
}

if ($mainItemRank) {
    $x4 = array();
    $y4 = array();
    $totalY4 = 0;
    $s4 = 0;
    $other4 = 0;
    foreach ($mainItemRank as $i => $value) {
        if ($i < 30) {
            $x4[] = $value['name'];
            $y4[] = $value['num'];
            $cids4[] = $value['cid'];
        } else {
            $other4 += $value['num'];
        }
        $totalY4 += $value['num'];
    }

    if ($other4 > 0) {
        $x4[] = 'other';
        $y4[] = $other4;
    }

    $dataX4 = implode(",", $x4);
    $dataY4 = implode(',', $y4);
    $dataCids4 = implode(',', $cids4);
} else {
    $totalY4 = 0;
    $dataX4 = '';
    $dataY4 = '';
    $dataCids4 = '';
    $catStr4 = '';
}
?>
<script src="<?= Yii::app()->baseUrl; ?>/js/highcharts/highcharts.js"></script>
<script>
    function fmoney(s, n) {
        n = n > 0 && n <= 20 ? n : 2;
        s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
        var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1];
        t = "";
        for (i = 0; i < l.length; i++) {
            t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
        }
        return t.split("").reverse().join("") + "." + r;
    }

    $(function () {
        $('#chart1').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'shop売上推移'
            },
            xAxis: {
                categories: <?= $xAxis1?>
            },
            yAxis: {
                title: {
                    text: '売上'
                }
            },
            tooltip: {
                formatter: function () {
                    return '売上:' + fmoney(this.y) + '(千円)';
                }
            },
            series: [{
                data: [<?= $data1?>]
            }]
        });
        $('#chart2').highcharts({
            title: {
                text: '商品売上推移'
            },
            xAxis: {
                categories: <?= $xAxis2?>
            },
            tooltip: {
                formatter: function () {
                    return this.series.name + '<br/>売上:' + fmoney(this.y) + '(千円)';
                }
            },
            yAxis: {
                title: {
                    text: '商品売上'
                }
            },
            series: <?= $series2?>
        });

        var dataX = "<?= $dataX?>".split(',');
        var dataY = "<?= $dataY?>".split(',');
        var newDataY = [];

        for (var i = 0, len = dataY.length; i < len; i++) {
            tmp = [];
            tmp.push(dataX[i]);
            tmp.push(parseInt(dataY[i], 10));
            newDataY.push(tmp);
        }
        $('#chart3a').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: '<strong>売上比率</strong>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
            },
            series: [{
                name: 'シェア',
                data: newDataY
            }]
        });

        var dataX4 = "<?= $dataX4?>".split(',');
        var dataY4 = "<?= $dataY4?>".split(',');
        var newDataY4 = [];

        var len4 = dataY4.length;
        for (var i = 0; i < len4; i++) {
            tmp = [];
            tmp.push(dataX4[i]);
            tmp.push(parseInt(dataY4[i], 10));
            newDataY4.push(tmp);
        }
        $('#chart3b').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: '<strong>商品比率</strong>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
            },
            series: [{
                name: 'シェア',
                data: newDataY4
            }]
        });

        $("input[type='radio'][name='lineType']").change(
            function () {
                window.location = '<?= Yii::app()->request->baseUrl?>/admin/client/detail?clientId=<?= $client->id?>&lineType='
                + $("input[type='radio'][name='lineType']:checked").val() + '&chartType=2';
            }
        );

        $("input[type='radio'][name='pieLevel']").change(
            function () {
                window.location = '<?= Yii::app()->request->baseUrl?>/admin/client/detail?clientId=<?= $client->id?>&pieLevel='
                + $("input[type='radio'][name='pieLevel']:checked").val() + '&chartType=3';
            }
        );

        $('#btn1').click(function () {
            $('#chart1').show();
            $('#list1').show();
            $('#chart2').hide();
            $('#radio2').hide();
            $('#chart3').hide();
            $('#radio3').hide();
        });
        $('#btn2').click(function () {
            $('#chart1').hide();
            $('#list1').hide();
            $('#chart2').show();
            $('#radio2').show();
            $('#chart3').hide();
            $('#radio3').hide();
        });
        $('#btn3').click(function () {
            $('#chart1').hide();
            $('#list1').hide();
            $('#chart2').hide();
            $('#radio2').hide();
            $('#chart3').show();
            $('#radio3').show();
        });
    });
</script>
