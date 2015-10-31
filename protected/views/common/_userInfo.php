<div id="user-info-pop">
    <p><strong class="black">ステータス：<?php echo Yii::app()->user->role->description; ?></strong></p> 

    <p id='member_test' >利用期間：<span id='member_time'><?php echo $_SESSION['memberExpireTime'];?></span> まで</p> 
    <p>情報通楽天版画面へ</p>  
    <p class="text-center"><a href='<?php echo Yii::app()->request->baseUrl; ?>/stat/index' target="_blank"><button class="btn qbt-button">情報通</button></a></p>
    <p>正規版のお申込みは<a href="#" style="text-decoration: underline;" target="_blank">こちらから</a></p>
<p class="text-center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout" ><button class="btn seo-tiny-up-button">ログアウト</button></a></p>
</div>
