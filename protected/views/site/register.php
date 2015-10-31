<div class="user-register">
    <div class="tiny-box">
        <div class="head">会員登録</div>
        <div class="body  fz-13">
            <p class="hint">この度は会員登録のお申し込みをして頂き誠にありがとうございます。</p>

            <p class="hint">本製品のご利用は、現時点では楽天市場でショップの運営をされている方のみとさせて頂きます。</p>

            <p class="hint">会員登録にはお手数ですが、以下の情報をご利用頂けますようお願い申し上げます。</p>

            <p class="hint">また、メールアドレスにはショップを運営をされている方の確認のため、楽天市場にて公開されている。</p>

            <p class="hint">メールアドレスまたは類似のものからのみ選択可能となっております。</p>

            <p class="hint">※ メールアドレスが記載されていない場合は、お手数ですが　「お問い合せフォーム」よりご連絡下さい。</p>

            <div class="regester-form">
                <form class="form-inline" id="register-form"
                      action="<?php echo Yii::app()->request->baseUrl; ?>/site/register" method="post">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <label for=""> ■　会員ID (ショップID) </label>
                                <span class="red">  ※ </span>
                            </td>
                            <td>
                                <input type="text" id='username' name='username' onchange="$('#pass_email').val(0);"
                                       class="form-control">
                                <button type="button" id="username_check_btn" class="btn login-register ml-10 fz-14">
                                    使用可能か確認
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><span class="error" id='username_check'> </span>

                                <div class="shop-id-example">
                                    <例>　ショップURL:　<br/>
                                        <span style="color:#4588ba">http://www.rakuten.co.jp/<i
                                                style="text-decoration: underline" class="red">koregashopiddesu</i>/index.htm</span><br/>
                                        <span class="red"><i>koregashopiddesu</i></span> 　こちらがショップIDになります
                                </div>
                            </td>
                        </tr>

                        <tr id='email_init'>
                            <td>
                                <label for=""> ■　メールアドレス</label>
                                <span class="red">  ※ </span>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>

                        <tbody id='email_show'>
                        </tbody>

                        <tbody>
                        <tr>
                            <td>
                                <label for=""> ■　パスワード</label>
                                <span class="red">  ※ </span>
                            </td>
                            <td><input type="password" id='password' name='password' class="form-control"
                                       onkeyup="updateStrength('password')"><span class="error ml-10"
                                                                                  id='password_error'></span></td>
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
                            <td>
                                <label for=""> ■　パスワード再入力</label>
                                <span class="red">  ※ </span>
                            </td>
                            <td><input type="password" id='repassword' name='repassword' class="form-control">
                                <span class="error ml-10" id='repassword_error'> </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for=""> ■　担当者名前</label>
                                <span class="red">  ※ </span>
                            </td>
                            <td>
                                <input type="text" id='security' name='security' class="form-control">
                                <span class="error ml-10" id='security_error'></span>
                            </td>
                        </tr>
                        <tr>
                            <td><label for=""> ■　携帯電話</label></td>
                            <td><input type="text" id='mobile' name='mobile' class="form-control">
                                <span class="error ml-10" id='mobile_error'></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for=""> ■　固定電話</label>
                                <span class="red">  ※ </span>
                            </td>
                            <td>
                                <input type="text" id='phone' name='phone' class="form-control">
                                <span class="error ml-10" id='phone_error'></span>
                            </td>
                        </tr>
                        <input type='hidden' id='pass_email' value='0'/>
                        </tbody>
                    </table>
                    <p class="text-center" style="margin-top:20px; border-top: 1px solid #ccc;padding-top: 30px;">
                        <button class="btn seo-huge-button  fz-16">利用規約に同意して登録</button>

                    </p>
                    <div class="text-center fz-12"><a
                            href="<?php echo CHtml::normalizeUrl(array('/site/page', 'view' => 'rule')) ?>"
                            target="_blank">利用規約を確認する</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function checkForm() {
        if ($("#pass_email").val() == 0) {
            $('#username_check').focus();
            usernameCheck();
            return false;
        } else if ($("#username").val() == "") {
            $('#username_check').html("※<?php echo Util::t('usernameIsNull') ?>");
            $('#username_check').focus();
            return false;
        } else if ($("input[name='email']:checked").val() == 'other' && $("#email_str_res").val() == '') {
            $('#username_check').html("※<?php echo Util::t('shopEmailIsNull') ?>");
            $('#username_check').focus();
            return false;
        } else if ($("#password").val() == '') {
            $('#username_check').html('');
            $('#password_error').html("※<?php echo Util::t('passwordIsNull') ?>");
            $('#password').focus();
            return false;
        } else if ($("#password").val().length < 6 || $("#password").val().length > 20) {
            $('#password_error').html("※<?php echo Util::t('passwordLength') ?>");
            $('#password').focus();
            return false;
        } else if ($("#repassword").val() != $("#password").val()) {
            $('#repassword_error').html("※<?php echo Util::t('passwordNotSame') ?>");
            $('#repassword').focus();
            return false;
        } else if ($('#security').val() == '') {
            $('#security_error').html("※<?php echo Util::t('securityIsNull') ?>");
            $('#security').focus();
            return false;
        }
        else if ($("#mobile").val().length > 20) {
            $('#mobile_error').html("※<?php echo Util::t('phoneLength') ?>");
            $('#mobile').focus();
            return false;
        } else if ($('#phone').val() == '') {
            $('#phone_error').html("※<?php echo Util::t('phoneIsNull') ?>");
            $('#phone').focus();
            return false;
        }
        else if ($("#phone").val().length > 20) {
            $('#phone_error').html("※<?php echo Util::t('phoneLength') ?>");
            $('#phone').focus();
            return false;
        }
        return true;
    }
</script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/site/register.js"></script>
