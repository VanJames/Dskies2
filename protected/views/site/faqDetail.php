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
                           <input type="hidden" name="page" value="<?php echo $page?>"/>
                           <input type="hidden" name="title" value="<?php echo $title?>"/>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary"  >
                            <?php echo Util::t('btn_submit'); ?>
                        </button>
                    </span>
                </div>
                </form>
            </div>
        </div>
         
        <div class="wide-wave-section">
            <div class="head"><?php echo $title;?></div>
            <div class="body">
            <?php foreach ($faqs as $faq){?>
                <div class="faq-box">
                    <p class="question"><a name="faq<?php echo $faq['id'];?>" id="faq<?php echo $faq['id'];?>"> </a><?php echo Util::replaceKeyword($keyword,$faq['title']);?></p>
                    <p class="answer" style="display: block;"><?php echo Util::replaceKeyword($keyword,$faq['content']);?></p>
                            <span class="feedback fz-14 form-inline" style="display: block;">
                                <input id="feedback_active_<?php echo  $faq['id'];?>" class="form-control" type="radio" name="feedback" value="<?php echo  $faq['id'];?>_1"/><label for="feedback_active_<?php echo $faq['id'];?>">解決</label>
                                <input id="feedback_negative_<?php echo  $faq['id'];?>" class="form-control" type="radio" name="feedback" value="<?php echo  $faq['id'];?>_2"/><label for="feedback_negative_<?php echo  $faq['id'];?>">未解決</label>
                            </span>
                            <span class="thanks fz-13">フィードバックありがとうございました</span>
                </div>
           <?php }?>
             </div>
        </div>      
         
    </div>
</div>
<script>
    $(function(){
        $('p.question').click(function(){
            $(this).next('p.answer').toggle('slow');
        })
    })
        
    $('span.feedback').click(function(){
        var feedback = $(this);
        var a = $("input[name='feedback']:checked",feedback).val();
		$.ajax({
			url : '<?php echo Yii::app()->request->baseUrl; ?>/site/faqFeedBack',
			type : 'GET',
			data : {
				id_status : a
			},
			dataType : 'json',
			success : function(res) {
                feedback.toggle();
                feedback.siblings('span.thanks').toggle();
            }
        })
    })
</script>