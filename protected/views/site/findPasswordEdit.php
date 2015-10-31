<div class="user-register">


    <div class="tiny-box">
        <div class="head">パスワードを忘れた方 -パスワード変更</div>
        <div class="body  fz-13">
             <div class="regester-form">
                <form class="form-inline" onSubmit="return changePassword()" action="<?php echo Yii::app()->request->baseUrl; ?>/site/findPasswordEdit" method="post">
                    <table>
                        
                           <tbody> 
                            <tr>
                                <td><label for="">  ■　新しいパスワード</label></td>
                                <td><input type="password" id='password'  name='password' class="form-control" onkeyup="updateStrength('password')" ><span class="error ml-10" id='password_error'></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <span class="fz-12">パスワードの安全性：<span id='strength_text'>弱</span></span>
                                    <div class="pass-strength">
                                        <span id='low' class=""></span>
                                        <span id='normal' class=""></span>
                                        <span id='strong' class=""></span>
                                </div>
                                </td>
                            </tr>
                             <tr>
                                <td><label for="">  ■　新しいパスワード再入力</label></td>
                                <td><input type="password"  id='repassword'  name='repassword'  class="form-control"><span class="error ml-10" id='repassword_error'> </span></td>
                            </tr>
                           <input type="hidden"  id='id'  name='id'  value="<?php echo $id?>" class="form-control">
                           <input type="hidden"  id='key'  name='key'  value="<?php echo $key?>" class="form-control">
                            
                        </tbody>
                    </table>
                    <p class="text-center" style="margin-top:40px"> <button style="margin-left: 45px;" class="btn seo-tiny-down-button  fz-14">送信する</button></p>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	function changePassword(){
	   if($("#password").val() == ''){
	        $('#password_error').html("※<?php echo Util::t('passwordIsNull')?>");
	        $('#password').focus();
	        return false;
	    }else  if($("#password").val().length < 6 || $("#password").val().length > 20){
	        $('#password_error').html("※<?php echo Util::t('passwordLength')?>");
	        $('#password').focus();
	        return false;
	    }else if($("#repassword").val() != $("#password").val()){
	        $('#repassword_error').html("※<?php echo Util::t('passwordNotSame')?>");
	        $('#repassword').focus();
	        return false;
	    }
		return true;
	} 
	function updateStrength(field_id){
	    var input_field 	= document.getElementById(field_id);
	    var input_str 		= input_field.value;
	    var input_length	= input_str.length;
	    var strength = 0;
	    number_re = new RegExp("[0-9]");
	    if (number_re.test(input_str)) {
			strength++;
	    }
	    non_alpha_re = new RegExp("[^A-Za-z0-9]");
	    if (non_alpha_re.test(input_str)) {
			strength++;
	    }
	    upper_alpha_re = new RegExp("[A-Z]");
	    if (upper_alpha_re.test(input_str)) {
			strength++;
	    }
	    if(input_length >=8) {
			strength++;
	    }
	    var strength_str; 
	    if (strength <= 1) {
	        $('#low').addClass('low');
	        $('#normal').removeClass('normal');
	        $('#strong').removeClass('strong');
	        $('#strength_text').html('弱');
	    } else if (strength <= 2) {
	    	$('#normal').addClass('normal');
	    	$('#strong').removeClass('strong');
	        $('#strength_text').html('中'); 
	    } else {
	    	$('#low').addClass('low');
	    	$('#normal').addClass('normal');
	    	$('#strong').addClass('strong');
	        $('#strength_text').html('强'); 
	    }
	    if(input_length < 6) {
	        if(input_length == 0){
	    		$('#low').removeClass('low');
	        }else{
	        	$('#low').addClass('low');
	        }
	        $('#normal').removeClass('normal');
	        $('#strong').removeClass('strong');
	        $('#strength_text').html('弱');
	    }
	}
</script>