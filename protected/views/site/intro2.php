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
    <body><div id="fixed-title">精心策划关键字 大促时候显身手</div>
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
            for ($index = 1; $index <= 20; $index++) {
                echo '<div id="section-' . $index . '" ' . ($index > 1 ? ' class="hide"' : '') . '>';
                $this->renderpartial('intro2/' . $index);
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
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;搜索是网上购物时最常用的手段，投放サーチ広告是重要的营销决策。Nint系统提供店铺投放的广告类型、关键字等信息，供我们参考，同时，也能学到投放サーチ広告的技巧。",

                        },
                        {
                            element: '#intro-step-2',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点击“广”，可以查看店铺在大促期间的成交及营销活动",
                            tooltipPosition: "left"
                        },
                        {
                            element: '#intro-step-3',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8.31日，店铺是之前7天平均业绩的20.18倍，高达26658千円",

                        },
                        {
                            element: '#intro-step-4',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点击“上升”，可查看当日成交的商品及其营销活动",
                            tooltipPosition: "left" 
                        },
                        {
                            element: '#intro-step-5',
                            intro: "该商品一举进入総合榜 名列43位"
 
                        },
                        {
                            element: '#intro-step-6',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点击“广”查看其广告解析，分析其成绩是如何取得的",
                             tooltipPosition: "left"
                        },
                        {
                            element: '#intro-step-7',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8.24日，商品名称中增加“スーパーSALE限定プライス”大促字样，价格从1944円降至1555円活动价",
                        },
                        {
                            element: '#intro-step-8',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;在8.26、8.29-9.2日均投放了search广告"
                        },
                        {
                            element: '#intro-step-9',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点击“サ”，查看投放的关键字",

                        },
                        {
                            element: '#intro-step-10',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大促前夕，主要投放了“ブラ”等相关关键字",
                            tooltipPosition: "top"
                        },
                        {
                            element: '#intro-step-11',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点击“more”查看全部关键字"
                        },
                        {
                            element: '#intro-step-12',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;从8.30日起，增加了“下着”等大批关键字，甚至使用了“下着 男性、下着 子供”等非直接相关关键字，提高曝光率"
                        },
                        {
                            element: '#intro-step-13',
                            intro: "关闭“more”"
                        },
                        {
                            element: '#intro-step-14',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;同时，可以看到店铺不断的在调整投放的关键字，每天都会去掉一些效果不好的关键字。所谓大胆假设、小心求证、精心策划",
                        },
                        {
                            element: '#intro-step-15',
                            intro: "回到广告分析页面查看其它广告",
                        },
                        {
                            element: '#intro-step-16',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;在大促期间，店铺还投放了乐天邮件、首页特集、手机特集等各种各样的广告-可以通过Nint系统自行查看广告的详细信息。",
                            tooltipPosition: "right"
                        },
                        {
                            element: '#intro-step-17',
                            intro: "总结：<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;以上我们可以看到：该店铺8.24日在商品名称中“スーパーSALE限定プライス”大促字样，并降至活动价",

                        },
                        {
                            element: '#intro-step-18',
                            intro: "总结：<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;在8.26、8.29-9.2日投放了search广告。开始，只投放了“ブラ”相关关键字；临近活动，加投了“下着”等大批关键字增加曝光，并且每天都不断进行调整。所谓大胆假设、小心求证！<br/>因此，我们可以通过Nint系统查看和参考优秀店铺的关键字，切不可拍脑袋想关键字，投放之后又不管不顾。",
                            tooltipPosition: "right"
                        },
                        {
                            element: '#intro-step-19',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;活动期间8.31-9.2日，还投放了邮件、特集等热门位置广告进行推广，参与包邮、多店购等营销活动。",
                            tooltipPosition: "left"
                        },
                        {
                            element: '#intro-step-20',
                            intro: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;通过以上一系列营销活动，商品表现优异：在大促期间，一直排在インナー・下ンナー・下着ナー・下着行业首位。"
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