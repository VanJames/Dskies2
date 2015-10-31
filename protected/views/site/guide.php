
<div class="site-guide-first">
<?php foreach ($introductionCategorys as $key => $introductionCategory):    ?>
    <?php $introductionCategory = $introductionCategorys[$key]; ?>
    <div class="clearfix">

        <div class="left">
            <div class="wide-wave-section border-top-type1">
                <?php if ($key == 0) :?>
                    <div class="head">利用ガイド</div>
                <?php endif; ?>
                <div class="body">
                    <p class="analysis-name"><?php echo $introductionCategory['title'] ?></p>
                    <div class="state-box clearfix">
                        <?php  $introductionCategory['img_url']= '/images/play'.$introductionCategory[id].'.jpg';#test?>
                        <div class="lbox"><?php echo CHtml::image(CHtml::normalizeUrl(Util::getRelativeUrl($introductionCategory['img_url'])), '', array('width' => '310','class'=>'vidio-trigger','data-url'=>$introductionCategory->introduction_video['url'])); ?></div>
                        <div class="rbox">
                            <p class="text"><?php echo $introductionCategory['content'] ?></p>
                            <p class="text-center margin-none"><a href="/site/guide?page=<?php echo $introductionCategory['id'] ?>&intro_id=1"><button class="btn seo-tiny-up-button" >もっと詳しく見る</button></a></p>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="right">

            <div class="tiny-box">

                <div class="head"><a name="guide<?php echo $introductionCategory['id'] ?>" id="<?php echo $introductionCategory['id'] ?>" > </a><?php echo $introductionCategory['title'] ?></div>
                <div class="body">
                    <ul class="">
                        <?php
                        if (isset($introductions[$key])) {
                            foreach ($introductions[$key] as $introduction) {
                                ?>
                                <li><a href="/site/guide?page=<?php echo $introductionCategory['id'] ?>&intro_id=<?php echo $introduction['intro_id'] ?>"><?php echo $introduction['short_title'] ?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php $this->renderPartial('/common/_vidioFramePop');?>

