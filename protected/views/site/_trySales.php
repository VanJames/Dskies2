<p><?php echo CHtml::image(CHtml::normalizeUrl('/images/home/is_correct.jpg')); ?></p>

<p class="search form-inline">
    <input id=input1 style="width:265px;height:40px;color: black;padding-right: 36px;" type="text" class="form-control" placeholder="ショップIDを入力" />
    <span class="question-mark" data-max="none" data-pop='<div"><例>　ショップURL:　<br/><span style="color:#4588ba">http://www.rakuten.co.jp/<i style="text-decoration: underline" class="red">koregashopiddesu</i>/index.htm</span><br/><span class="red"><i>koregashopiddesu</i></span> 　こちらがショップIDになります</div>' ></span>
    <button type="submit" class="btn blue-h-button fw-b ml-10" onclick="<?php echo ($status == 1 || (date('Y-m-d')>='2015-01-28' && date('Y-m-d')<='2015-01-29')) ? "post_shop_name()" : "jump_sign()"; ?>" >売上チェック</button>
</p>
<div class="scroll-wrap" <?php if ($status != 1)
    echo 'style="display: none;"' ?>>

    <div class="black" style="background-color: #fff">
        <strong>
        <span style="width: 140px;" class="text-center ib">ショップID</span>
        <span style="width: 116px;" class="ib text-right">売上推測</span>
        <span style="width: 124px;" class="text-right  ib">誤差範囲</span>
        </strong>
    </div>
    <ul class="evaluate shop-error-range-wrap">
        <?php $ref = array('1' => '5%', '2' => '10%', '3' => '15%',); ?>
<?php foreach ($logs as $log) : ?>
            <li class="shop-error-range">
                <span style="width: 130px;" class="text-left ib"><?php echo preg_replace('/^(.).*/', '\1', $log['name']); ?>*********</span>
                <span style="width: 107px;" class="ib text-right"><?php echo Util::myNumberFormat($log['sales_index_total']); ?> 千円</span>
                <span style="width: 120px;" class="text-right  ib">
                    <?php
                    if ($log['deviation_type'] == 4) {
                        echo "<span class='ib w-30' style='padding:0;'>15%</span> 以上";

                    } elseif (in_array($log['deviation_type'], array(1, 2, 3))) {
                        echo "<span class='ib w-30' style='padding:0;'>{$ref[$log['deviation_type']]}</span> 未満";
                    }
                    ?>
                </span>
            </li>
<?php endforeach; ?>
    </ul>
</div>

<div class="single-shop-evaluate fz-14" <?php if ($status == 1)
    echo 'style="display: none;"' ?>>
    <table class="w-full">
        <tbody>
            <tr>
                <td><strong class="fz-14"><?php echo $log['title'] ?></strong></td>
            </tr>
            <tr>
                <td><span class="ib" style="width:250px"><?php echo $dateStr ?>売上推測</span><span class="ib text-right" style="width:140px"><?php echo Util::myNumberFormat($log['sales_index_total']) ?> 千円</span></td>

            </tr>
            <tr>
                <td><span class="ib" style="width:320px">売上ランキング(<?php echo $log['name'] ?>)</span><span class="ib text-right"  style="width:70px"><?php echo Util::myNumberFormat($rank['0']['count(*)'] + 1); ?> 位</span></td>

            </tr>
        </tbody>
    </table>
</div>
<div class="choose-error-range" <?php if ($status != 2)
    echo 'style="display: none;"' ?>>
    <table class="w-full">
        <tbody>
            <tr>
                <td width="50" class="text-center"><input type="radio" class="" name="type" value='1' onclick="post_deviation_type(this.value)"/> </td>
                <td width="200">誤差5％未満</td>
                <td width="50" class="text-center"><input type="radio" class="" name="type" value='2' onclick="post_deviation_type(this.value)"/> </td>
                <td width="">誤差10％未満</td>
            </tr>
            <tr>
                <td width="50" class="text-center"><input type="radio" class="" name="type" value='3' onclick="post_deviation_type(this.value)"/> </td>
                <td width="200">誤差15%未満</td>
                <td width="50" class="text-center"><input type="radio" class="" name="type" value='4' onclick="post_deviation_type(this.value)"/> </td>
                <td width="">誤差15%以上</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="fifteen-free-wrap text-center" <?php if ($status != 3)
    echo 'style="display: none;"' ?>>
    <a href="<?php echo Yii::app()->request->baseUrl; ?>/site/register"><?php echo CHtml::image(CHtml::normalizeUrl('/images/home/7-free.jpg')); ?></a>
</div>