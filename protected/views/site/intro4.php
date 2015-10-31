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
                $this->renderpartial('intro4/' . $index);
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
                            intro: "同是快消行业，不同商品的营销方式差别却很大。<br>化妆品，广告促销是不二法门，看到粉嫩的图片再配上关于效果的煽情文案，小姑娘们即蜂拥而至；<br>但对于手表，大砸广告或许效果有限，少有土豪会因为看到一个广告就出手买下一块表。消费者大多是各方打探-这个时候的广告是必要的-找到心仪的那一块，趁大促优惠时再抱回家。<br>那么只能降价吗？是否还有更多选择呢？让我们来看看优秀店铺是如何做的。",

                        },
                        {
                            element: '#intro-step-2',
                            intro: "查看店铺的销售业绩和营销活动。",
							tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-3',
                            intro: "8.31日，店铺热销指数上涨10倍，达到10,897千円。",
                        },
                        {
                            element: '#intro-step-4',
                            intro: "69件商品调价，72件商品调整了积分。是如我们所料降价、升积分，给予客户优惠吗？"
 
                        },
                        {
                            element: '#intro-step-5',
                            intro: "查看价格调整的详细情况",
                            
 
                        },
                        {
                            element: '#intro-step-6',
                            intro: "确实进行了降价",
							tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-7',
                            intro: "查看积分调整的详细情况",
 
                        },
                        {
                            element: '#intro-step-8',
                            intro: "可以看到并不像我们预料的那样加倍积分，反而将之前的5倍或10倍积分均调整为1倍，即降低了积分。<br>这提醒我们，关于商品，我们手中不只有价格，积分也是有效工具。将平时的积分福利换成力度更大的价格折扣，平时大促兼顾，两全其美。"
                        },
						{
                            element: '#intro-step-9',
                            intro: "当然，别忘记活动款需要改名"
                        },
						{
                            element: '#intro-step-10',
                            intro: "查看改名的详细情况",
							tooltipPosition: "left"
                        },
						{
                            element: '#intro-step-11',
                            intro: "增加【楽天スーパーセール】字样"
                        },
						{
                            element: '#intro-step-12',
                            intro: "店铺在8.25日-大促前一周，降价，同时降低了积分"
                        },
						{
                            element: '#intro-step-13',
                            intro: "8.27增加的大促字样"
                        },
						{
                            element: '#intro-step-14',
                            intro: "最终取得了优秀的业绩。<br>手表这种产品，替代品的多-品牌众多、款式丰富；消费支出占比较高-相对杂志等一般消费品；耐用性高-一块手表可以戴很久-即使加价，也可迟一些再买；并非生活中所不可缺少的-尤其是当前社会，除了固有的计时功能，手表更多的具备了装饰、品味身份象征等功效，以上种种特点，决定了手表是一种对价格非常敏感的商品。但是，就像我们案例中看到的那样，我们的选择不仅仅只有降价。"
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