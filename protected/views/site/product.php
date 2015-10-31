
<?php echo CHtml::image(CHtml::normalizeUrl(Yii::app()->baseUrl . '/images/home/product-banner.jpg')); ?>
<?php echo CHtml::image(CHtml::normalizeUrl(Yii::app()->baseUrl . '/images/home/product-top.jpg')); ?>
<?php foreach (array('top', 'center', 'bottom', 'abyss') as $name) : ?>
    <div class="product-image-wrap">
        <?php foreach (array(1, 2, 3) as $num) :?>

            <?php echo CHtml::image(CHtml::normalizeUrl(Yii::app()->baseUrl . '/images/home/product-' . $name . '-' . $num . '.jpg'),'',array('usemap'=>'#'. $name . '-' . $num)); ?>

            <?php endforeach; ?>
    </div>
<?php endforeach; ?>
            <map name="top-3">
                <area href="<?php echo Yii::app()->request->baseUrl ?>/site/register" shape="rect" coords="23,69,1013,220" alt="無料体験を申込む" />
            </map>
            <map name="center-3">
                <area href="<?php echo Yii::app()->request->baseUrl ?>/site/index#try" shape="rect" coords="24,99,1014,210" alt="自店舗の売上からご確認下さい！" />
            </map>
            <map name="bottom-3">
                <area href="<?php echo Yii::app()->request->baseUrl ?>/site/index#try" shape="rect" coords="22,48,1014,158" alt="自店舗の売上からご確認下さい！" />
            </map>
            <map name="abyss-3">
                <area href="<?php echo Yii::app()->request->baseUrl ?>/site/register" shape="rect" coords="26,130,1013,277" alt="無料体験を申込む" />
            </map>

