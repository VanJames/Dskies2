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
            for ($index = 1; $index <= 34; $index++) {
                echo '<div id="section-' . $index . '" ' . ($index > 1 ? ' class="hide"' : '') . '>';
                $this->renderpartial('introMarketing/' . $index);
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
                            intro: "查看店铺每日的成交及营销活动",
                            tooltipPosition: "left"

                        },
                        {
                            element: '#intro-step-2',
                            intro: "8.31日，店铺上升20.51倍，热销指数高达9,662千円"
 
                        },
                        {
                            element: '#intro-step-3',
                            intro: "查看当日成交的商品及其营销活动",
                            tooltipPosition: "left" 
                        },
                        {
                            element: '#intro-step-4',
                            intro: "该商品综合榜排名上升985，名列16位，成绩斐然！"
 
                        },
                        {
                            element: '#intro-step-5',
                            intro: "查看该商品每日的排名情况及其营销活动，以分析优异成绩的缘由",
                            tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-6',
                            intro: "8.6日 上轮マラソン連動促销活动结束，通过改名和调价，从917円涨价至1335円"
 
                        },
                        {
                            element: '#intro-step-7',
                            intro: "8.21日 大促前10天的时候，改名：增加[楽天スーパーセール連動]大促字样；调价，从1335円降价至665円，半价折扣刺激空前",
                        },
                        {
                            element: '#intro-step-8',
                            intro: "8.31-9.3大促期间，店铺还投放了首页特集、特集、邮件等广告进行推广。可点击查看广告详情。"
                        },
                        {
                            element: '#intro-step-9',
                            intro: "查看商品投放的特集广告"
                        },
                        {
                            element: '#intro-step-10',
                            intro: "特集.大促广告活动：super sales行业广告位 广告页title：【楽天市場】美容・健康・医薬品 | 楽天スーパーSALE投放时间：8.31广告页面.链接：http://event.rakuten.co.jp/campaign/supersale/"
                        },
                        {
                            element: '#intro-step-11',
                            intro: "查看广告截图"
                        },
                        {
                            element: '#intro-step-12',
                            intro: "super sales行业广告位"
                        },
                        {
                            element: '#intro-step-13',
                            intro: "素材详情，文案和图片一览无余"
                        },
                        {
                            element: '#intro-step-14',
                            intro: "回到广告分析页面查看其他广告"
                        },
                        {
                            element: '#intro-step-15',
                            intro: "查看首页特集广告详情"
                        },
                        {
                            element: '#intro-step-16',
                            intro: "首页特集.大促广告活动：super sales免邮广告位 广告页title：【楽天市場】送料込み | 楽天スーパーSALE 投放时间：9.1 广告页面.链接：http://event.rakuten.co.jp/campaign/supersale/"
                        },
                        {
                            element: '#intro-step-17',
                            intro: "查看广告截图"
                        },
                        {
                            element: '#intro-step-18',
                            intro: "super sales免邮广告位"
                        },
                        {
                            element: '#intro-step-19',
                            intro: "素材详情，文案和图片一览无余"
                        },
						{
                            element: '#intro-step-20',
                            intro: "回到首页特集广告页面查看其他广告"
                        },
                        {
                            element: '#intro-step-21',
                            intro: "首页特集.大促广告活动：super sales行业广告位，广告页title：【楽天市場】美容・健康・医薬品 | 楽天スーパーSALE，投放时间：9.1，广告页面.链接：http://event.rakuten.co.jp/campaign/supersale/"
                        },
                        {
                            element: '#intro-step-22',
                            intro: "查看广告截图"
                        },
						{
                            element: '#intro-step-23',
                            intro: "super sales行业广告位"
                        },
                        {
                            element: '#intro-step-24',
                            intro: "素材详情，文案和图片一览无余"
                        },
                        {
                            element: '#intro-step-25',
                            intro: "回到广告分析页面查看其他广告"
                        },
						{
                            element: '#intro-step-26',
                            intro: "查看投放的邮件广告"
                        },
                        {
                            element: '#intro-step-27',
                            intro: "乐天邮件.大促广告活动：super sales行业广告位，邮件主题：楽天市場ニュース，投放时间：8.31"
                        },
                        {
                            element: '#intro-step-28',
                            intro: "查看邮件详细内容"
                        },
						{
                            element: '#intro-step-29',
                            intro: "super sales邮件"
                        },
                        {
                            element: '#intro-step-30',
                            intro: "素材，包括图片、文字"
                        },
                        {
                            element: '#intro-step-31',
                            intro: "回到广告分析页面"
                        },
						{
                            element: '#intro-step-32',
                            intro: "以上我们看到，店铺在上轮マラソン促销之后，先从917涨价至1335"
                        },
                        {
                            element: '#intro-step-33',
                            intro: "再在8.21日，增加“楽天スーパーセール”字样，参与大促，并从1335降价至665，先涨后降半价折扣，强力刺激"
                        },
                        {
                            element: '#intro-step-34',
                            intro: "活动期间，投放supersales特集、首页特集、邮件广告，大力推广。以上一系列活动配合，使商品在大促期间一举进入综合榜单，位列10-18，在行业类目等榜单上更是一直名列前茅，取得了优异的成绩。"
                        },


                    ]}).onbeforechange(function(targetElement) {
                
                    var step = targetElement.id;
                    step = step.replace(/\D/g,'');
//                    if(step ==7 || step == 9) step =5;
                    $('#section-'+step).removeClass('hide').siblings().addClass('hide');
                    var arr = ['12','13','14','18','19','20','23','24','25','29','30','31'];
                    if($.inArray(step,arr) == -1){
                        $("div#header").show();
                        $("div#footer").show();
                    }else{
                        $("div#header").hide();
                        $("div#footer").hide();
                    }
                
                }).start();
            });

        </script>
    </body>


</html>