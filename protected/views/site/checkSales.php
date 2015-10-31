<!DOCTYPE html>
<html>

<style type="text/css">
    body {
        min-width: 300px;
    }
    .section-body-type-mobile{
        padding: 10px 0px 10px;
    }
    #_trySales {
        width: auto;
    }
</style>
<body>
<div class="popup">
    <div class="section-body-type-mobile clearfix">
        <div class="right fz-13" id="_trySales">
        </div>
    </div>
</div>

</body>
</html>
<script src="<?= Yii::app()->baseUrl; ?>/js/jquery/jquery.scroll.js"></script>
<script>
    get_sales();
    function get_sales() {
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/site/getSalesMobile',
            type: 'GET',
            data: {
                shop_id: "",
                notInitial: 1
            },
            success: function (res) {
                $("#_trySales").html(res);
            }
        })
    }
    function post_shop_name() {
        var shop_name = document.getElementById("input1").value;
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/site/getSalesMobile',
            type: 'POST',
            data: {
                shop_name: shop_name,
                notInitial: 1
            },
            success: function (res) {
                $("#_trySales").html(res);
            }
        })
    }
    function post_deviation_type(type) {
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/site/getSalesMobile',
            type: 'POST',
            data: {
                deviation_type: type,
                notInitial: 1
            },

            success: function (res) {
                $("#_trySales").html(res);
            }
        })
    }
    function jump_sign() {
        window.location.href = '<?= Yii::app()->request->baseUrl; ?>/site/register';
    }
</script>