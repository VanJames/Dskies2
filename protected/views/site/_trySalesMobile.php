<style type="text/css">
    .single-shop-evaluate-mobile {
        width: auto;
        border: 1px;
        padding: 5px 20px;
    }

    .evaluate-mobile {
        width: auto;
    }

    .image-mobile {
        width: 100%;
    }

    .blue-h-button-mobile {
        background-image: url(http://static.nint.jp/images/button-group.png);
        background-repeat: no-repeat;
        border: none;
        display: inline-block;
        text-shadow: 3px 3px 5px #ccc;
        *padding: 0;
        background-position: 0 -443px;
        height: 39px;
        width: 110px;
        color: #fff;
    }

    .scroll-wrap {
        height: 179px;
        border: 1px solid #ccc;
        overflow: hidden;
        padding: 5px 10px;
    }

    .shop-error-range-wrap {
        position: relative;
    }

    .scroll-wrap span.ib {
        padding: 5px 0;
        vertical-align: top;
    }

    .single-shop-evaluate-mobile{
        border: 1px solid #ccc;
        overflow: hidden;
        padding: 5px 20px;
    }
    .single-shop-evaluate-mobile td{
        padding: 5px 2px;
    }
    .choose-error-range{
        padding: 10px;
    }
    .choose-error-range td{
        padding: 7px 0;
    }
</style>
<p><?= CHtml::image(CHtml::normalizeUrl('/images/home/is_correct.jpg'), '', array('class' => 'image-mobile')); ?></p>
<p class="search form-inline">
    <input id=input1 style="width:200px;height:40px;color: black;padding-right: 24px;" type="text" class="form-control"
           placeholder="ショップIDを入力"/>
    <button type="submit" class="btn blue-h-button-mobile fw-b" onclick="post_shop_name()">売上チェック</button>
</p>
<div class="scroll-wrap" <?php if ($status != 1)
    echo 'style="display: none;"' ?>>

    <div>
        <例>　ショップURL:　<br/><span style="color:#4588ba">http://www.rakuten.co.jp/<i style="text-decoration: underline"
                                                                                  class="red">koregashopiddesu</i>
                <br/>/index.htm</span><br/><span
                class="red"><i>koregashopiddesu</i></span> 　こちらがショップIDになります
    </div>
</div>

<div class="single-shop-evaluate-mobile fz-14" <?php if ($status == 1)
    echo 'style="display: none;"' ?>>
    <table class="w-full">
        <tbody>
        <tr>
            <td><strong class="fz-14"><?= $log['title'] ?></strong></td>
        </tr>
        <tr>
            <td><span class="ib" style="width:55%"><?= $dateStr ?>売上推測</span><span class="ib text-right"
                                                                                     style="width:45%"><?= Util::myNumberFormat($log['sales_index_total']) ?>
                    千円</span></td>

        </tr>
        <tr>
            <td><span class="ib" style="width:55%">売上ランキング(<?= $log['name'] ?>)</span><span
                    class="ib text-right" style="width:45%"><?= Util::myNumberFormat($rank['0']['count(*)'] + 1); ?>
                    位</span></td>

        </tr>
        </tbody>
    </table>
</div>
<div class="choose-error-range" <?php if ($status != 2 || $log['deviation_type'])
    echo 'style="display: none;"' ?>>
    <table class="w-full">
        <tbody>
        <tr>
            <td width="10%" class="text-center"><input type="radio" class="" name="type" value='1'
                                                      onclick="post_deviation_type(this.value)"/></td>
            <td width="40%">誤差5％未満</td>
            <td width="10%" class="text-center"><input type="radio" class="" name="type" value='2'
                                                      onclick="post_deviation_type(this.value)"/></td>
            <td width="40%">誤差10％未満</td>
        </tr>
        <tr>
            <td width="10%" class="text-center"><input type="radio" class="" name="type" value='3'
                                                      onclick="post_deviation_type(this.value)"/></td>
            <td width="40%">誤差15%未満</td>
            <td width="10%" class="text-center"><input type="radio" class="" name="type" value='4'
                                                      onclick="post_deviation_type(this.value)"/></td>
            <td width="40%">誤差15%以上</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="fifteen-free-wrap text-center" <?php if (!$log['deviation_type'])
    echo 'style="display: none;"' ?>>
    <a href="<?= Yii::app()->request->baseUrl; ?>/site/register"><?= CHtml::image(CHtml::normalizeUrl('/images/home/7-free.jpg')); ?></a>
</div>