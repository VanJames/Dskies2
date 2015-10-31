<div class="modal fade " id="login-form-popup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class=" p45" style="font-size: 19px;">●ログイン</h4>
                <form>
                    <input type="hidden" name="checkNum" id="checkNum" value=0>
                    <div class="row p45">
                        <label class="input-label" for="username">会員ID  </label>
                        <input type="text"
                               class="form-control" id="username_login"
                               placeholder="<?php echo ''; ?>"/>
                    </div>
                    <div class="row p45">
                        <label class="input-label" for="password">パスワード</label>
                        <input type="password"
                               class="form-control" id="password_login"
                               placeholder="<?php echo ''; ?>"/>
                    </div>
                    <p class="text-center red fz-12" id='error_msg' style="display:none">  </p>
                    <p class="text-center"><button type="button" class="btn login-login">ログイン</button><button id="login-pop" type="button" class="btn login-register ml-5">会員登録</button></p>
                    <p class="text-center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/findPassword" class="forgot">パスワードを忘れた方はこちら</a></p>
                    <p class="fz-12 p45"><span class="red fz-13">※</span>Nintのご利用には、会員登録が必要です。</p>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#login-pop').on('click',function() {
        location.href='<?php echo CHtml::normalizeUrl(Yii::app()->request->baseUrl.'/site/register');?>';
    });
    $('button.login-login').on('click', function() {
		$.ajax({
			url : '<?php echo Yii::app()->request->baseUrl; ?>/site/ajaxLogin',
			type : 'GET',
			data : {
				username : $("#username_login").val(),
				password : $("#password_login").val(),
				checkNum : $("#checkNum").val(),
				rememberMe : $("#rememberMe").attr("checked")
			},
			dataType : 'json',
			success : function(res) { 
				//alert(res.flag);
				if (res.flag) { 
                    location.href = '<?php echo Yii::app()->request->baseUrl; ?>/stat/index';
 				} else { 
					 $('#error_msg').show();
					 $('#error_msg').html(res.msg);
                     $("#checkNum").val(res.checkNum);
				}
			}
 		});
	});
</script>