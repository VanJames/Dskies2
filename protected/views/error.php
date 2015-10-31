<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<div class="error-page">
    <div class="error-logo">
        <img src="<?=$baseUrl?>/images/error-man.png" />
    </div>
    <p class="is-error">Error</p>
    <?php 
        if(Yii::app()->errorHandler->error['message'])
            echo "<p>",Yii::app()->errorHandler->error['message'],"</p>";
        $err_msg = $message;
        if(!isset($err_msg))
            echo "<p>エラー！</p>";
        else{
            if( !is_array($err_msg) ) {
                $err_msg = array($err_msg);
            }
            foreach($err_msg as $msg){
                echo "<p>$msg</p>";
            }
        }
    ?>
    <a class="underline" href="javascript:history.go(-1);">ここをクリックで戻る 》</a>
</div>
