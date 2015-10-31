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
            for ($index = 1; $index <= 21; $index++) {
                echo '<div id="section-' . $index . '" ' . ($index > 1 ? ' class="hide"' : '') . '>';
                $this->renderpartial('intro5/' . $index);
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
                            intro: "有效的方法能让我们事半功倍，强力的广告位能让商品一举成名。在本案例中，可以看到一个默默无闻的商品借助广告一举上榜，只是可惜于没有其他营销活动配合，仅仅昙花一现。",

                        },
                        {
                            element: '#intro-step-2',
                            intro: "查看店铺所有商品的近期业绩和营销活动情况",
							tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-3',
                            intro: "可根据所属类目、商品名、投放的广告筛选出想查看的商品",
                        },
                        {
                            element: '#intro-step-4',
                            intro: "输入检索条件，点击检索"
 
                        },
                        {
                            element: '#intro-step-5',
                            intro: "查询到您需要查看的信息",                           
                        },
                        {
                            element: '#intro-step-6',
                            intro: "查看商品的排名业绩及投放的广告",
							tooltipPosition: "left"
 
                        },
                        {
                            element: '#intro-step-7',
                            intro: "可以看到，商品一直默默无闻，连在“ボタンダウン”榜单上都没有出现过",
 
                        },
                        {
                            element: '#intro-step-8',
                            intro: "8.6日，投放了广告，商品一举进入综合榜单，并在8.6-8.13日持续一周的时间里，均榜上有名；"
                        },
						{
                            element: '#intro-step-9',
                            intro: "查看所投放的广告"
                        },
						{
                            element: '#intro-step-10',
                            intro: "6時間限定 タイムセール广告位<br>广告页title：【楽天市場】6時間限定 タイムセール | 楽天最安値に挑戦！大特価の商品が日替わりで登場！<br>投放时间：8.6<br>广告页面链接：http://event.rakuten.co.jp/bargain/timesale/",
                        },
						{
                            element: '#intro-step-11',
                            intro: "查看广告页面截图"
                        },
						{
                            element: '#intro-step-12',
                            intro: "投放6時間限定タイムセール＆日替わりアイテム广告"
                        },
						{
                            element: '#intro-step-13',
                            intro: "素材详情，文案和图片一览无余"
                        },
						{
                            element: '#intro-step-14',
                            intro: "上一轮广告效应结束后，商品又退出榜单"
                        },
						{
                            element: '#intro-step-15',
                            intro: "8.31日，商品又投放了广告，一举进入综合榜单，并在8.31-9.3日大促期间，均榜上有名；"
                        },
						{
                            element: '#intro-step-16',
                            intro: "查询到您需要查看的信息",                           
                        },
						{
                            element: '#intro-step-17',
                            intro: "6時間限定 タイムセール广告位<br>广告页title：【楽天市場】6時間限定 タイムセール | 楽天最安値に挑戦！大特価の商品が日替わりで登場！<br>投放时间：8.31<br>广告页面链接：http://event.rakuten.co.jp/bargain/timesale/",                           
                        },
						{
                            element: '#intro-step-18',
                            intro: "查看广告页面截图",                           
                        },
						{
                            element: '#intro-step-19',
                            intro: "投放6時間限定タイムセール＆日替わりアイテム广告",                           
                        },
						{
                            element: '#intro-step-20',
                            intro: "素材详情，文案和图片一览无余",                           
                        },
						{
                            element: '#intro-step-21',
                            intro: "以上可以看到，该商品一直未能上榜，表现平平，但通过投放6時間限定タイムセール＆日替わりアイテム广告，一举登上榜单并持续多天，说明该广告位非常有效，能帮助我们强力推广商品，但可惜该商品后续营销乏力，无以配合，一朝业绩仅成昙花一现。",                           
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