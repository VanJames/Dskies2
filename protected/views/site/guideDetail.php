<div class="inner-guide">
<?php
$i = 0;
foreach ($introductions as $introduction) {
    $class = $i % 2 == 0 ? '' : 'color-section';
    ?>
    <?php
    $j = 0;
    foreach ($introduction as $intr) {
        ?>
        <div class="section <?php echo $class; ?>" >
            <div class="body clearfix">
                <div class="pull-left"><?php echo CHtml::image(CHtml::normalizeUrl(Util::getRelativeUrl($intr['img_url'])), '', array('width' => 740, 'class' => 'img-border')); ?></div>

                <div class="info">
                    <?php echo $intr['content'] ?>
                </div>
            </div>
        </div>
        <?php
        $j++;
    }
    ?>
    <?php
    $i++;
}
?>
</div>
    
<?php if($introductionCategory && $introductionCategory->flag==0): ?>
<div class="section inner-helper">
    <div class="section-head-type2"><span style="margin-left: 15px;">その他</span></div>
    <div class="section-body-type3 ">
        <ul class="clearfix">
            <li class="col-lg-6 border-right"> 
                <dl>
                    <dt>関連ガイド</dt>
                <dd><span class="col-lg-12">
                    <?php foreach ($otherIntroductions as $otherIntroduction) {
                        $url = Yii::app()->request->baseUrl . "/site/guide?page=" . $_REQUEST['page'] . "&title=" . $_REQUEST['title'] . "&intro_id=" . $otherIntroduction['intro_id'];
                    ?>
                        <p><a class="underline  fz-14" href="<?php echo $url ?>"><?php echo $otherIntroduction['title'] ?></a></p>
                    <?php } ?>
                </span></dd>
                    <dd><span class="col-lg-6">
                    <?php for ($index = 0; $index < 10; $index++)  : ?>
                        <!--p><a class="underline  fz-14" href="#">XXXXXXXXXX</a></p!-->
                    <?php endfor;?>
                </span></dd>
            </li> 
            <li class="col-lg-6"> 
                <!--dl>
                    <dt>ソリューション</dt>
                    <?php foreach ($solutions as $solution) {
                        $url = Yii::app()->request->baseUrl . "/site/guide?page=" . $solution['cid'] . "&intro_id=" . $solution['intro_id'];
                    ?>
                        <dd><a class="underline fz-14"  href="<?php echo $url ?>"><?php echo $solution['title'] ?></a></dd>
                    <?php } ?>
                </dl!-->
                <dl>
                    <dt>ビデオ</dt>
                     <dd>
                    <?php foreach ($introductionVideos as $introductionVideo) {?>                  
                            <?php echo CHtml::image(CHtml::normalizeUrl(Util::getRelativeUrl('/images/play.jpg')), '', array('width' => '200','class'=>'vidio-trigger','data-url'=>$introductionVideo->url)); ?>
                        
                    <?php } ?>
                           </dd> 
                </dl>
            </li> 
        </ul>
<?php $this->renderPartial('/common/_vidioFramePop');?>
    </div>
</div>
<?php endif; ?>


