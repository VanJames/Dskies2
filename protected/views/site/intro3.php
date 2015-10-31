<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"></meta>
        <meta content="IE=edge" http-equiv="X-UA-Compatible"></meta>
        <meta content="width=device-width, initial-scale=1" name="viewport"></meta>
        <link href="/favicon.ico" rel="shortcut icon"></link>
        <link href="/css/bootstrap.min.css" rel="stylesheet"></link>
        <link href="/css/rakuten-theme.css" rel="stylesheet"></link>
        <!--[if IE 7]>
        <link rel="stylesheet" href="/css/ie7.css"></link>
         <![endif]-->
        <link href="/css/gridview/styles.css" type="text/css" rel="stylesheet"></link>


        <title>Nint-広告分析</title>
        <!--[if IE 8]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script>var baseUrl = '';</script>
        <script src="/js/main.js"></script>

    </head>

    <?php
    $url = CHtml::asset(Yii::getPathOfAlias('system.web.widgets.pagers.pager') . '.css');
    Yii::app()->getClientScript()->registerCssFile($url);
    ?>
    <body>
	<div id="fixed-title">回馈老客户 借大促清仓过季库存</div>
        <div id="header">
            <a href="/site/index"><img src="/images/logo.png" /></a>
            <div id="user-inner-info">
                <div class="up"><span>weng.zuming(Admin)</span> 
                    <span class="emial-wrap">
                        <a href="/personal/letter" id="letter">
                            <img src="/images/email.png" class="va-top"/>                    </a>
                    </span>&nbsp;&nbsp;&nbsp;
                    <span>利用期限&nbsp;&nbsp;&nbsp;2015-12-02</span>&nbsp;&nbsp;&nbsp;<a href="/site/logout" id="logout"><img src="/images/logout.png"></a></div>
                <div class="down color-white"><a href="/personal/buy1">購入</a><span class="seperate"></span><a target="_blank" href="/site/faq">FAQ</a><span class="seperate"></span><a target="_blank" href="/site/guide">利用ガイド</a> </div>
            </div>
        </div>
        <div>
            <?php
            for ($index = 1; $index <= 14; $index++) {
                echo '<div id="section-' . $index . '" ' . ($index > 1 ? ' class="hide"' : '') . '>';
                $this->renderpartial('intro3/' . $index);
                echo '</div>';
            }
            ?>
        </div>

        <div id="footer">
            <a href="/site/page?view=privacy">個人情報の取扱いについて</a>&#12288;&#12288;<a href="/site/page?view=trade_law">特定商取引の表示</a>&#12288;&#12288;<a href="/site/support">問い合せ</a>&#12288;&#12288;<a href="/site/company">会社紹介</a>&#12288;&#12288;<a href="/site/page?view=rule">利用規約</a>
        </div>
        <script>
            function goToNext(e){
                doane(e);
                $('a.introjs-nextbutton').click();
                    
                return false;
            }
            function doane(event) {
                e = event ? event : window.event;
                if(!e) return;
                if(jQuery.browser.msie) {
                    e.returnValue = false;
                    e.cancelBubble = true;
                } else if(e) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            }
            $(function() {

                Rakuten.plugins.intro({
                    steps:[
						{
                            element: '#intro-step-1',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp季节变化，我们不断的面对新品上架的抉择，也承受过季商品清仓的压力。清仓时降价是可以接受的，但仍需要考虑降低价格带来的影响。客户会觉着低价意味着不好的质量吗？购买过清仓品的客户，会不会不再愿意正价购买非清仓品？面对首次购买商品的新客户，会有这样那样的一些顾虑，那么面向了解自身产品质量、喜爱品牌的老客户低价清仓回馈，是不是一条值得考虑的好选择呢？",
                        },
                        {
                            element: '#intro-step-2',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp商品一览，列示了店铺所有商品的成交情况",
                            tooltipPosition: "left"

                        },
                        {
                            element: '#intro-step-3',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp可以通过行业类目、商品名称、广告类型等筛选出关注的商品"
 
                        },
                        {
                            element: '#intro-step-4',
                            intro: "通过商品名检索",
                        },
                        {
                            element: '#intro-step-5',
                            intro: "检索到您关注的商品"
 
                        },
                        {
                            element: '#intro-step-6',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp查看这双凉鞋SuperSales期间的营销活动和业绩情况",
                            tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-7',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp通过改名，商品名称中增加了“楽天スーパーSALE”大促字样；<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格调整，从3456元降价至1000元，非常大幅度的折扣；<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp积分，1倍积分调整为2倍积分<br>"
 
                        },
                        {
                            element: '#intro-step-8',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp店铺去掉了大促字样，因为在大促期间，虽然スーパーSALE的搜索量特别高，但所有活动商品基本都会使用，即搜索结果会特别多，最终泯然众人；因此店铺避其锋芒，而代之以限时促销这样的日常热搜关键字，提高搜索有效性",
 
                        },
                        {
                            element: '#intro-step-9',
                            intro: "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp从8.28日起直到9.2日大促期间，发送了店铺邮件"
                        },
						{
                            element: '#intro-step-10',
                            intro: "查看邮件"
                        },
						{
                            element: '#intro-step-11',
                            intro: "查看邮件详细情况",
							tooltipPosition: "left"
                        },
						{
                            element: '#intro-step-12',
                            intro: "向订阅店铺邮件的老客户推荐该商品"
                        },
						{
                            element: '#intro-step-13',
                            intro: "回到广告解析页面"
                        },
						{
                            element: '#intro-step-14',
                            intro: "总结:<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp8.31日SuperSales正值夏末，凉鞋已经过季，店铺给予了非常大的折扣外，营销上，一方面避大促锋芒，使用日常热搜关键字，提高搜索有效性；另一方面，集中向了解自身产品质量、喜爱品牌的老客户推广这种大折扣过季商品，由于老客户喜爱品牌、了解产品质量，他们更有可能购买以作为明年夏天的鞋子。<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp通过以上努力，商品取得了行业排名16的好成绩，作为一件已过季商品，如此表现实属不易，值得我们在清仓时借鉴。"
                        },


                    ]}).onbeforechange(function(targetElement) {
                
                    var step = targetElement.id;
                    step = step.replace(/\D/g,'');
                    //if(step ==7 || step == 9) step =5;
                    $('#section-'+step).removeClass('hide').siblings().addClass('hide');
                
                }).start();
            });

        </script>
    </body>


</html>