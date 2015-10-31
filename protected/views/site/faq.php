<div class="scale-1120">
    <?php require_once('faqLeft.php');?>
    <div class="right">
        <div class="wide-wave-section">
            <div class="head">キーワードから検索</div>
            <div class="body">
            	<form  action="/site/faq" method="get" >
                <div class="input-group">
                    <input type="text" name='keyword' id='keyword'
                           class="form-control" 
                           value="<?php echo $keyword?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary"  >
                            <?php echo Util::t('btn_submit'); ?>
                        </button>
                    </span>
                </div>
                </form>
            </div>
        </div>
        <?php if($keyword){?>
         	<?php foreach ($faqs as $faq){ 
	        ?>
	        <div class="wide-wave-section">
	            <div class="head"><?php echo  $faq['title'];?></div>
	            <div class="body">
	            <?php foreach ($faq['faq'] as $f){?>
	                <div class="faq-box">
	                    <p class="question">Q <?php echo Util::replaceKeyword($keyword, $f['title']);?></p>
	                    <p class="answer">A <?php echo Util::replaceKeyword($keyword, $f['content']);?></p>
                            <span class="feedback fz-14 form-inline">
                                <input id="feedback_active_<?php echo  $faq['id'];?>" class="form-control" type="radio" name="feedback" value="1"/><label for="feedback_active_<?php echo $faq['id'];?>">解決</label>
                                <input id="feedback_negative_<?php echo  $faq['id'];?>" class="form-control" type="radio" name="feedback" value="2"/><label for="feedback_negative_<?php echo  $faq['id'];?>">未解決</label>
                            </span>
                            <span class="thanks fz-13">フィードバックありがとうございました</span>
	                </div>
	           <?php }?>
	             </div>
	        </div>      
	        <?php }?>  
        <?php }else{?>
	        <?php foreach ($faqCategorys as $faqCategory){
	        	if(in_array($faqCategory['flag'], array(1,2))){
	        ?>
	        <div class="wide-wave-section">
	            <div class="head"><?php echo $faqCategory['title'];?></div>
	            <div class="body">
	            <?php foreach ($faqCategory['faq'] as $faq){?>
	                <div class="faq-box">
	                    <p class="question">Q <?php echo $faq['title'];?></p>
	                    <p class="answer">A <?php echo $faq['content'];?></p>
                            <span class="feedback fz-14 form-inline" >
                                <input id="feedback_active_<?php echo  $faq['id'];?>" class="form-control" type="radio" name="feedback" value="1"/><label for="feedback_active_<?php echo $faq['id'];?>">解決</label>
                                <input id="feedback_negative_<?php echo  $faq['id'];?>" class="form-control" type="radio" name="feedback" value="2"/><label for="feedback_negative_<?php echo  $faq['id'];?>">未解決</label>
                            </span>
                            <span class="thanks fz-13">フィードバックありがとうございました</span>
	                </div>
	           <?php }?>
	             </div>
	        </div>      
	        <?php
	        	}
	        }?>  
        <?php }?>
    </div>
</div>
<script>
    $(function(){
        $('p.question').click(function(){
            $(this).next('p.answer').toggle('slow');
            $(this).siblings('span.feedback').toggle();
        })

    })
</script>