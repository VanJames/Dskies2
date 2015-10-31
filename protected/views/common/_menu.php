<div class="submenu">
    <?php foreach ($submenu as $menu): ?>
        <?php $text = '<span class="head"></span><span class="body">'.$menu['text'].'</span><span class="foot"></span>'; ?>
        <?php echo CHtml::link($text, $menu['url'], array('class' => 'ml-5')); ?>
    <?php endforeach; ?>

</div>   