
$('#username_check_btn').on('click', function() {
    $.ajax({
        url: baseUrl + '/site/checkUsername',
        type: 'POST',
        data: {
            username: $("#username").val()
        },
        dataType: 'json',
        success: function(res) {
            if (res.flag === 5) {
                $('#email_show').show();
                $('#email_show').html(getEmailHtml(res.email, res.email_str_res));
                $('#email_init').hide();
                $('#username_check').html("※" + res.msg);
                $('#pass_email').val(5);
            } else {
                $('#email_init').show();
                $('#email_show').hide();
                $('#username_check').html("※" + res.msg);
                $('#pass_email').val(0);
            }
        }
    });
});
function getEmailHtml(email, email_str_res) {
    $str = '';
    if (email_str_res) {
        $str += '<tr>';
        $str += '<td><label for="">  ■　メールアドレス</label><span class="red">   ※ </span></td>';
        $str += '<td><div class="input-group" style="width: 200px;">';
        $str += '     <span class="input-group-addon"><input type="radio"  name="email" checked value="other"></span>';
        $str += '     <input type="text" id="email_str_res" name="email_str_res" class="form-control" placeholder="その他のアドレス">';
        $str += '     <span class="input-group-addon">@' + email_str_res + '</span>';
        $str += '</div><input type="hidden" id="email_str_right" value="@' + email_str_res + '" name="email_str_right"></td>';
        $str += '</tr>';
    }
    for (var i = 0, len = email.length; i < len; i++) {
        if (email_str_res === '' && i === 0) {
            $str += '<tr><td><label for="">  ■　メールアドレス</label></td><td><input type="radio" name="email" checked value= ' + email[i] + ' class="form-control"> ' + email[i] + '</td></tr><tr>';
        } else {
            $str += '<tr><td></td><td><input type="radio" name="email" value= ' + email[i] + ' class="form-control"> ' + email[i] + '</td></tr><tr>';
        }
    }

    return $str;
}
function updateStrength(field_id) {
    var input_field = document.getElementById(field_id);
    var input_str = input_field.value;
    var input_length = input_str.length;
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
    if (input_length >= 8) {
        strength++;
    }
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
    if (input_length < 6) {
        if (input_length === 0) {
            $('#low').removeClass('low');
        } else {
            $('#low').addClass('low');
        }
        $('#normal').removeClass('normal');
        $('#strong').removeClass('strong');
        $('#strength_text').html('弱');
    }
}

$('#register-form').submit(function() {
    if (checkForm()) {
        $.ajax({
            url: baseUrl + '/site/register',
            type: 'POST',
            data: $('#register-form').serialize(),
            dataType: 'json',
            success: function(resp) {
                if (resp.ok) {
                    window.location.href = baseUrl + '/site/registerDone';
                } else {
                    jAlert(resp.msg, resp.title, function(){
                        ;
                    });
                }
            }
        });
    }
    return false;
});