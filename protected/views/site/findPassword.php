<div class="user-register">
    <div class="tiny-box">
        <div class="head">パスワードを忘れた方</div>
        <div class="body  fz-13"> 
            <div class="regester-form">
                <form class="form-inline" id='form' name='form' action="<?php echo Yii::app()->request->baseUrl; ?>/site/findPassword" method="post">
                    <table>
                        <tbody> 
                            <tr>
                                <td><label for="">  ■　登録済みメールアドレス</label></td>
                                <td><input type="text"  id='email'  name='email'  class="form-control"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span class="error ml-10" id='email_error'></span></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <p class="text-center" style="margin-top:40px"><button tyle="button"  onClick="verifyEmail();" style="margin-left: 45px;" class="btn seo-tiny-down-button  fz-14">送信する</button></p>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/site/findPassword.js"></script>