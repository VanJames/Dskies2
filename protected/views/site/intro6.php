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
            for ($index = 1; $index <= 12; $index++) {
                echo '<div id="section-' . $index . '" ' . ($index > 1 ? ' class="hide"' : '') . '>';
                $this->renderpartial('intro6/' . $index);
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
                            intro: "大促案例看多了，会发现一些固定套路：先提前降价，再改名加大促字段，再投放广告推一下，大促结束全恢复原状，就像四部曲。这篇案例中，我们将看到不走寻常路的商品，一路走来的独特历程",

                        },
                        {
                            element: '#intro-step-2',
                            intro: "点击查看店铺的商品列表及其业绩和营销活动",
                            tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-3',
                            intro: "可以利用商品名称筛选出商品",
                        },
                        {
                            element: '#intro-step-4',
                            intro: "可以利用商品名称筛选出商品"
 
                        },
                        {
                            element: '#intro-step-5',
                            intro: "查看商品的排名业绩及投放的广告",
                            tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-6',
                            intro: "商品在8.20日即将价格从4536元降至3866元，85折；在直到8.29日的这段时间内，商品在靴类目，均取得了不错的排名成绩：平均排名第10，最好成绩第3位。一般，在大促前一周左右的时间里，消费者都会大幅减少购买，等待大促时更优惠再去购买；而商家在这段期间也会减少推广，为大促做准备。案例商品正是在这段时间趁虚而入，在提前10天时即降到大促活动价，收获了10天的好业绩。"

 
                        },
                        {
                            element: '#intro-step-7',
                            intro: "8.30日，商品名称中增加了“楽天スーパーセール期間　”的大促字样，和“ポイント5倍”的积分字样，正式进入大促模式。<br/>大促期间，最好成绩为行业排名9；一般在20多名。表现并不突出，但也不差"
                        },
                        {
                            element: '#intro-step-8',
                            intro: "临近大促结束，商品去掉了【楽天スーパーセール　ポイント5倍】【05P31Aug14】等大促字样，但并未提价，而是增加了“【期間限定価格9月15日まで】”字样，将促销延续到9.15日"
                        },
                        {
                            element: '#intro-step-9',
                            intro: "Super Sales大促结束后，商品一直表现良好，行业排位在10名左右。<br/>因此在9.16日，商品又将促销延续到9.25日"
                        },
                        {
                            element: '#intro-step-10',
                            intro: "9.17，将价格从3866元调整为4082元；9.18日，增加【楽天お買い物マラソンポイント5倍！】等字样，开始マラソン活动，直到9.23日结束"
                        },
                        {
                            element: '#intro-step-11',
                            intro: "直到9.26日，才将价格恢复为4536元，按原定计划在9.25日结束了促销活动"
                        },
                        {
                            element: '#intro-step-12',
                            intro: "以上，我们看到，该商品在supersales大促前10天即开始折扣促销，而在大促之后将近一个月的时间里，均持续促销，虽然在大促期间表现平平，但在其他时段一直很不错。这种不求一名惊人但求细水长流的策略，值得我们借鉴和学习。"
                        },
                    ]}).onbeforechange(function(targetElement) {
                
                    var step = targetElement.id;
                    step = step.replace(/\D/g,'');
//                    if(step ==7 || step == 9) step =5;
                    $('#section-'+step).removeClass('hide').siblings().addClass('hide');
//                    var arr = ['12','13','14','18','19','20','23','24','25','29','30','31'];
//                    if($.inArray(step,arr) == -1){
//                        $("div#header").show();
//                        $("div#footer").show();
//                    }else{
//                        $("div#header").hide();
//                        $("div#footer").hide();
//                    }
                
                }).start();
            });

        </script>
    </body>


</html>