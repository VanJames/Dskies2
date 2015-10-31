<?php
$this->pageTitle = Yii::app()->name;
?>
<style>
    .section-body-type4 {
        padding: 10px 15px 10px;
    }

    .section-body-type4 .left {
        float: left;
        width: 620px;
    }

    .section-body-type4 .right {
        padding-left: 8px;
        float: left;
    }

    .section-body-type4 .banner2 img {
        margin: 0 15px;
        cursor: pointer;
        width: 214px;
    }

    .section-body-type4 .banner2 {
        width: 488px;
        overflow: hidden;
    }

    .section-body-type4 .banner2 ul {
        width: 200%;
        position: relative;
    }

    .section-body-type4 .banner2 li {
        float: left;
    }
</style>
<div class="">
    <div class="banner">
        <ul>
            <li style="height: 282px;"><?= CHtml::image(CHtml::normalizeUrl(Yii::app()->request->baseUrl . '/images/home/banner11.jpg')); ?></li>
            <li><?= CHtml::image(CHtml::normalizeUrl(Yii::app()->request->baseUrl . '/images/home/banner13.jpg')); ?></li>
            <li><?= CHtml::image(CHtml::normalizeUrl(Yii::app()->request->baseUrl . '/images/home/banner12.jpg'), '', array('usemap' => '#try-out')); ?></li>
            <li><?= CHtml::image(CHtml::normalizeUrl(Yii::app()->request->baseUrl . '/images/home/banner14.jpg'), '', array('usemap' => '#exhibition', 'width' => '1200px')); ?></li>
        </ul>
        <map name="try-out">
            <area href="<?= Yii::app()->request->baseUrl . '/site/register' ?>" shape="rect" coords="453,171,750,239"
                  alt="無料体験を申込む"/>
        </map>
        <map name="exhibition">
            <area href="http://www.ts-expo.jp/" shape="rect" coords="150,0 865,140" alt="ts-expo"/>
            <area href="http://www.ecommerceexpo-osaka.com/" shape="rect" coords="150,150 865,280" alt="expo-osaka"/>
        </map>
    </div>

    <div class="section">
        <div class="section-head-type2">楽天ショップの運営で、最も頼れるアナリシスツール</div>
        <div class="section-body text-center">
            <?= CHtml::image(CHtml::normalizeUrl('/images/home/adventage.jpg'), 'advantageMap', array('usemap' => '#advantageMap')); ?>
            <map name="advantageMap">
                <area href="<?= Yii::app()->request->baseUrl . '/site/product' ?>" shape="rect" coords="353,39,613,185"
                      alt="プロダクト"/>
                <area href="<?= Yii::app()->request->baseUrl . '/site/guide#guide1' ?>" shape="rect"
                      coords="730,42,936,57" alt="利用ガイド-業種分析について"/>
                <area href="<?= Yii::app()->request->baseUrl . '/site/guide#guide4' ?>" shape="rect"
                      coords="952,98,1162,116" alt="利用ガイド-広告分析について"/>
                <area href="<?= Yii::app()->request->baseUrl . '/site/guide#guide2' ?>" shape="rect"
                      coords="684,181,936,200" alt="利用ガイド-ショップ分析について"/>
                <area href="<?= Yii::app()->request->baseUrl . '/site/guide#guide3' ?>" shape="rect"
                      coords="958,207,1180,225" alt="利用ガイド-商品分析について"/>
            </map>
        </div>
    </div>
    <div class="section">
        <div class="section-head-type2"><span class="col-lg-6">楽天市場全ジャンル売上シェア</span><span class="col-lg-6"
                                                                                          style="padding-left: 139px;"><a
                    name="try" id='try'> </a>データの精度確認</span></div>
        <div class="section-body-type2 clearfix">
            <div class="left border-right">
                <?= CHtml::image(CHtml::normalizeUrl('/images/home/data-example.jpg')); ?>
            </div>
            <div class="right fz-13" id="_trySales">
            </div>
        </div>
    </div>
    <div class="section">
        <div class="section-head-type2"><span class="col-lg-6">Nint動画チュートリアル</span><span class="col-lg-6"
                                                                                         style="padding-left: 42px;">Nintをご利用のお客様</span>
        </div>
        <div class="section-body-type4 clearfix">
            <div class="left border-right">
                <table>
                    <tbody>
                    <tr>
                        <td><?= CHtml::image(CHtml::normalizeUrl('/images/home/banner-left.png'), '', array('class' => 'banner-direct disable-click', 'data-num' => '-1')); ?></td>
                        <td>
                            <div class="banner2">
                                <ul id="banner2-ul">
                                    <?php
                                    $imgToVideos = array(
                                        'play0' => 'd-aDrm7USik',
                                        'play1' => 'pjNUVYtFMDs',
                                        'play2' => 'MWgeWr7P1nM',
                                        'play3' => 'p7AQqkKO4tw',
                                        'play4' => 'oPpyz6FK25M',
                                    );
                                    ?>
                                    <?php foreach ($imgToVideos as $i => $v): ?>
                                        <li>
                                            <?= CHtml::image(CHtml::normalizeUrl("/images/$i.jpg"), '', array('class' => 'vidio-trigger', 'data-url' => "https://www.youtube.com/embed/$v?autoplay=1&wmode=opaque")); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </td>
                        <td><?= CHtml::image(CHtml::normalizeUrl('/images/home/banner-right.png'), '', array('class' => 'banner-direct', 'data-num' => '1')); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="right">
                <div style="width: 520px;height: 123px;">
                    <table style="height:123px;">
                        <tbody>
                        <tr>
                            <?php
                            $imgToShops = array(
                                'shop1.png' => 'http://www.rakuten.ne.jp/gold/jellyfish-shop/',
                                'shop2.jpg' => 'http://www.rakuten.co.jp/ttclub/',
                                'shop3.png' => 'http://www.rakuten.ne.jp/gold/lt-nike/',
//                            'shop4.png' => 'http://www.rakuten.co.jp/importjack/',
                            );
                            $shopImgs = array_rand($imgToShops, 2);
                            ?>
                            <?php foreach ($shopImgs as $si): ?>
                                <td><span
                                        class="image-shadow"><?= CHtml::link(CHtml::image(CHtml::normalizeUrl('/images/' . $si), '', array('width' => '215px')), $imgToShops[$si], array('target' => '_blank')); ?></span>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-right "><a class="more-link fz-14" href="/site/page?view=praise">more>></a></p>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="section-head-type2"><span style="margin-left: 15px;">Nintをもっと詳しく知るために</span></div>
        <div class="section-body-type3 ">
            <ul class="clearfix">
                <li class="col-lg-4 border-right"><p class="head">どうして今、Nintが必要なのか？</p>

                    <p class="body">
                        現在ECショップの運営にはデータ分析が必要な時代です。しかし自店舗のデータのみでは限界があり、もし業界と他店舗のデータを利用できれば、もっと多角的な分析と運営が可能になります。<br/>Nintならこうした問題を解決できます！
                    </p>

                    <p class="text-right"><a href="<?= Yii::app()->request->baseUrl ?>/site/product">
                            <button class="btn seo-tiny-up-button fz-14">Nint(ニント)とは？</button>
                        </a></p>
                </li>
                <li class="col-lg-4 border-right"><p class="head">まずは無料トライアルから!!</p>

                    <p class="body">Nint は初めてのお客様に、<?= Yii::app()->params['probationTime'] ?>
                        日の無料トライアルをご利用いただいております。<br/>期間中は、業種ごとの売上推移はもちろんのこと気になるショップの広告・商品戦略もご覧頂けます。
                    </p>

                    <p class="text-right"><a href="<?= Yii::app()->request->baseUrl ?>/site/register">
                            <button class="btn seo-tiny-up-button fz-14">無料体験を申込む</button>
                        </a></p>
                </li>
                <li class="col-lg-4"><p class="head">よくある質問(FAQ)</p>

                    <p class="body">
                        ・<a href="<?= Yii::app()->request->baseUrl . '/site/faq?page=1' ?>">ショップの売上は
                            どうやって推測してますか？</a><br/>
                        ・<a href="<?= Yii::app()->request->baseUrl . '/site/faq?page=1#faq4' ?>">データはどこから集めてますか？</a><br/>
                        ・<a href="<?= Yii::app()->request->baseUrl . '/site/faq?page=2' ?>">アドウェイズテクノロジーとはどんな会社ですか？</a><br/>
                        ・<a href="<?= Yii::app()->request->baseUrl . '/site/faq?page=3' ?>">中国版Nint（情報通）はどんなものですか？</a><br/>
                        ・<a href="<?= Yii::app()->request->baseUrl . '/site/faq?page=4' ?>">無料トライアル版は誰でも使えますか？</a></p>

                    <p class="text-right " style="height: 37px;"><a class="more-link fz-14"
                                                                    href="<?= Yii::app()->request->baseUrl ?>/site/faq">more>></a>
                    </p>
                </li>
            </ul>

        </div>
    </div>
</div>
<?php $this->renderPartial('/common/_vidioFramePop'); ?>
<script src="<?= Yii::app()->baseUrl; ?>/js/jquery/jquery.scroll.js"></script>
<script src="<?= Yii::app()->baseUrl; ?>/js/question-mark.js"></script>
<script>
    $(function () {
        $('.banner').unslider({
            speed: 500,               //  The speed to animate each slide (in milliseconds)
            delay: 6000,              //  The delay between slide animations (in milliseconds)
            arrows: true,               //  Enable keyboard (left, right) arrow shortcuts
            dots: true,               //  Display dot navigation
            fluid: false              //  Support responsive design. May break non-responsive designs
        });

        var roller = {
            defaults: {
                container: '.scroll-wrap',
                className: '.shop-error-range-wrap',
                itemClassName: '.shop-error-range',
                second: 2500,
                eachCompleteSecond: 700
            },
            roll: function (top) {
                $(roller.defaults.className).animate({
                    top: 0
                }, roller.defaults.eachCompleteSecond, function () {
                    var $this = $(this);
                    var $last = $this.find(roller.defaults.itemClassName).last();
                    $last.prependTo($this);
                    $this.css('top', '-' + top + 'px');
                });
            },
            init: function () {
                var timer;
                var $this = $(roller.defaults.className);
                var $last = $this.find(roller.defaults.itemClassName).last();
                var top = $last.height();
                $this.css('top', '-' + top + 'px');
                $last.prependTo($this);
                timer = setInterval(function () {
                    roller.roll(top);
                }, roller.defaults.second);
                $(roller.defaults.container).hover(function () {
                    clearInterval(timer);
                }, function () {
                    timer = setInterval(function () {
                        roller.roll(top);
                    }, roller.defaults.second);
                });
            }
        }

        roller.init();

        var $b2 = $('#banner2-ul');
        var b2_num = $('li', $b2).size();
        var cur_num = 0;
        $b2.css('width', b2_num * 50 + '%');
        var $dire = $('img.banner-direct');
        $dire.click(function () {
            var $this = $(this);
            cur_num += $this.data('num');
            $dire.removeClass('disable-click');
            if (cur_num < 0) {
                cur_num = 0;
                $this.addClass('disable-click');
                return;
            } else if (cur_num > b2_num - 2) {
                cur_num = b2_num - 2;
                $this.addClass('disable-click');
                return;
            }
            $b2.animate({left: '-' + cur_num * 50 + '%'});
        })
    });

    get_sales();
    function get_sales() {
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/site/getSales',
            type: 'GET',
            data: {
                shop_id: ""
            },
            //*-			dataType : 'json',
            success: function (res) {
                $("#_trySales").html(res);
            }
        })
    }
    function post_shop_name() {
        var shop_name = document.getElementById("input1").value;
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/site/getSales',
            type: 'POST',
            data: {
                shop_name: shop_name
            },
            success: function (res) {
                $("#_trySales").html(res);
            }
        })
    }
    function post_deviation_type(type) {
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/site/getSales',
            type: 'POST',
            data: {
                deviation_type: type
            },

            success: function (res) {
                $("#_trySales").html(res);
            }
        })
    }
    function jump_sign() {
        window.location.href = '<?= Yii::app()->request->baseUrl; ?>/site/register';
    }
</script>