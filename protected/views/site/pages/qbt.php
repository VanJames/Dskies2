<div class="site-qbt">
    <?php echo CHtml::image(CHtml::normalizeUrl(Yii::app()->baseUrl . '/images/home/qbt_banner.jpg')); ?>
    <div style="margin: 34px 90px 5px 96px">

        <?php for ($index = 6;$index<=12;$index++) : ?>

            <?php $num=$index>9?$index:'0'.$index; echo CHtml::image(CHtml::normalizeUrl(Yii::app()->baseUrl . '/images/home/qbt_' . $num . '.jpg')); ?>

        <?php endfor; ?>
<?php echo CHtml::image(CHtml::normalizeUrl(Yii::app()->baseUrl . '/images/home/qbt_13.jpg'),'',array('usemap'=>'#map')); ?>
        <map name="map">
            <area href="<?php echo Yii::app()->request->baseUrl ?>/site/register" shape="rect" coords="10,153,997,303" alt="" />
        </map>

    </div>
</div>