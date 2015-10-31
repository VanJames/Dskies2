<div class="left">
        <div class="tiny-box">
            <div class="head">カテゴリから選択</div>
            <div class="body">
                <ul class="">
                	<?php foreach ($faqCategorys as $faqCategory ){
                		if(!$faqCategory['flag']){
                	?>
                    <li><a href="/site/faq?page=<?php echo $faqCategory['id']?>&title=<?php echo urlencode($faqCategory['title'])?>"><?php echo $faqCategory['title']?></a></li>
                    <?php }}?>
                </ul>
            </div>
        </div>
        <div class="tiny-box">
            <div class="head">Nintへのお問い合せ</div>
            <div class="body">
                <p>Nintへのご質問には、業務効率化のために問い合せフォームからのみ行っております。</p>
                <p class="text-center"><a href="<?php echo Yii::app()->request->baseUrl ?>/site/support"><button class="btn seo-button">お問い合せフォームへ</button></a></p>
            </div>
        </div>
    </div>