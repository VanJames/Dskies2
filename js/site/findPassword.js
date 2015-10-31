function verifyEmail() {
    var email = $("#email").val();
    var pattern = /^([.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
    flag = pattern.test(email);
    if (flag) {
        $.ajax({
            url: baseUrl + '/site/verifyEmail',
            type: 'POST',
            data: {
                email: email
            },
            dataType: 'json',
            success: function(res) {
                if (res.flag === 5) {
                    formSubmit();
                } else {
                    $('#email_error').html("※" + res.msg);
                    return false;
                }
            }
        });
    } else {
        $("#email_error").html("※正しいメールアドレスをご入力下さい。");
        return false;
    }
}

function formSubmit() {
    $.ajax({
        url: baseUrl + '/site/findPassword',
        type: 'POST',
        data: $('#form').serialize(),
        dataType: 'json',
        success: function(resp) {
            jAlert(resp.msg, resp.title, function() {
                window.location.href = baseUrl + '/site';
            });
        }
    });
    return false;
}