$(function() {
    $('#Support_shop_name').blur(function() {
        var shopName = $('#Support_shop_name').val();
        if (shopName.length) {
            $.ajax({
                url: baseUrl + '/site/queryFieldByName',
                type: 'POST',
                data: {
                    field: 'company',
                    name: shopName
                },
                dataType: 'json',
                success: function(resp) {
                    if (resp.ok) {
                        $('#Support_company_name').attr('value', resp.company);
                    }
                }
            });
        }
    });

    $('#support-form').submit(function() {
        if (checkForm()) {
            $.ajax({
                url: baseUrl + '/site/support',
                type: 'POST',
                data: $('#support-form').serialize(),
                dataType: 'json',
                success: function(resp) {
                    jAlert(resp.msg, resp.title, function(){
                        window.location.href = baseUrl + '/site/support';
                    });
                }
            });
        }
        return false;
    });
    
    function checkForm() {
        var valid = false;
        if ($("#Support_shop_name").val().length === 0) {
            $('#shop_name_error').html("※" + Rakuten.text.site.shopNameNone);
            $('#Support_shop_name').focus();
        }
        else if ($("#Support_name").val().length === 0) {
            $('#name_error').html("※" + Rakuten.text.site.nameNone);
            $('#Support_name').focus();
        }
        else if ($("#Support_support_type").val().length === 0 || $("#Support_support_type").val() === '0') {
            $('#support_type_error').html("※" + Rakuten.text.site.supportTypeNone);
        }
        else if ($("#Support_description").val().length === 0) {
            $('#description_error').html("※" + Rakuten.text.site.descriptionNull);
            $('#Support_description').focus();
        }
        else {
            valid = true;
        }
        return valid;
    }
});
