$(function() {
    $('form').data('category_fee', $('#category_fee_hidden').val());
    $('form').data('shop_fee', $('#shop_fee_hidden').val());
    $('form').data('item_fee', $('#item_fee_hidden').val());
    $('form').data('marketing_fee', $('#marketing_fee_hidden').val());
    $('form').data('search_fee', $('#search_fee_hidden').val());
    $('form').data('seo_fee', $('#seo_fee_hidden').val());
    $('form').data('multi_type', $('#multi_type_hidden').val());
    calcTotalFee();

    $(document).find('input[type="radio"]').on('change', function() {
        var type = $(this).val();
        $.ajax({
            url: baseUrl + '/site/buyPackage',
            type: 'POST',
            data: {
                type: type
            },
            dataType: 'json',
            success: function(resp) {
                $('form').data('category_fee', resp.categoryFee);
                $('form').data('shop_fee', resp.shopFee);
                $('form').data('item_fee', resp.itemFee);
                $('form').data('marketing_fee', resp.marketingFee);
                $('form').data('search_fee', resp.searchFee);
                $('form').data('seo_fee', resp.seoFee);
            }
        });
    });

    $(document).on('change', '.chk-one', function() {
        var num = $('.chk-one:checked').length;
        $.ajax({
            url: baseUrl + '/site/getCategoryFee',
            type: 'POST',
            data: {
                num: num
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('category_fee', resp);
                    $('#category_fee_hidden').val(resp);
                    $('#category_fee').text(resp);
                    calcTotalFee();
                }
            }
        });
    });

    $(document).on('change', '#Buy_shop_select', function() {
        var selectType = $(this).val();
        $.ajax({
            url: baseUrl + '/site/getPrice',
            type: 'POST',
            data: {
                buyType: 'shop',
                selectType: selectType
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('shop_fee', resp);
                    $('#shop_fee_hidden').val(resp);
                    $('#shop_fee').text(resp);
                    calcTotalFee();
                }
            }
        });
    });

    $(document).on('change', '#Buy_item_select', function() {
        var selectType = $(this).val();
        $.ajax({
            url: baseUrl + '/site/getPrice',
            type: 'POST',
            data: {
                buyType: 'item',
                selectType: selectType
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('item_fee', resp);
                    $('#item_fee_hidden').val(resp);
                    $('#item_fee').text(resp);
                    calcTotalFee();
                }
            }
        });
    });

    $(document).on('change', '#Buy_marketing_select', function() {
        var selectType = $(this).val();
        $.ajax({
            url: baseUrl + '/site/getPrice',
            type: 'POST',
            data: {
                buyType: 'marketing',
                selectType: selectType
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('marketing_fee', resp);
                    $('#marketing_fee_hidden').val(resp);
                    $('#marketing_fee').text(resp);
                    calcTotalFee();
                }
            }
        });
    });

    $(document).on('change', '#Buy_search_select', function() {
        var selectType = $(this).val();
        $.ajax({
            url: baseUrl + '/site/getPrice',
            type: 'POST',
            data: {
                buyType: 'search',
                selectType: selectType
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('search_fee', resp);
                    $('#search_fee_hidden').val(resp);
                    $('#search_fee').text(resp);
                    calcTotalFee();
                }
            }
        });
    });

    $(document).on('change', '#Buy_seo_select', function() {
        var selectType = $(this).val();
        $.ajax({
            url: baseUrl + '/site/getPrice',
            type: 'POST',
            data: {
                buyType: 'seo',
                selectType: selectType
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('seo_fee', resp);
                    $('#seo_fee_hidden').val(resp);
                    $('#seo_fee').text(resp);
                    calcTotalFee();
                }
            }
        });
    });

    $(document).on('change', '#Buy_month_select', function() {
        var selectType = $(this).val();
        $.ajax({
            url: baseUrl + '/site/getMultiType',
            type: 'POST',
            data: {
                selectType: selectType
            },
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    $('form').data('multi_type', resp);
                    $('#multi_type_hidden').val(resp);
                    calcTotalFee();
                }
            }
        });
    });

});

function calcTotalFee() {
    var total_fee = (parseInt($('form').data('category_fee')) + parseInt($('form').data('item_fee')) + parseInt($('form').data('marketing_fee')) + parseInt($('form').data('search_fee'))
            + parseInt($('form').data('seo_fee')) + parseInt($('form').data('shop_fee'))) * $('form').data('multi_type');
    $('#total_fee').text(total_fee);
    $('#total_fee_hidden').val(total_fee);
}