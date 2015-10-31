<?php $baseUrl = Yii::app()->request->baseUrl;
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
); 
?>
    
<div class="error-page">
    <p class="pb-20"><img src="<?=$baseUrl?>/images/error.png" /></p>
    <?php 
        echo "<p>エラー！</p>";
        $err_msg = $message;
    ?>
    <a class="underline" href="javascript:history.go(-1);">ここをクリックで戻る 》</a>
</div>