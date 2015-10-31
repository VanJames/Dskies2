<style>
.error {
text-align: center;
}
</style>
<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<div class="error">
    <img src="<?=$baseUrl?>/images/admin/error.gif" /><br />
    <?php 
        echo Yii::app()->errorHandler->error['message'],"<br/>";
        $err_msg = $this->stash['errors'];
        if(!isset($err_msg))
            echo "出错啦！";
        else{
            if( !is_array($err_msg) ) {
                $err_msg = array($err_msg);
            }
            foreach($err_msg as $msg){
                echo $msg,"<br/>";
            }
        }
    ?>
    点击<a href="javascript:history.go(-1);">这里</a>返回
</div>