<div class="modal fade " id="discount-popup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="orderId" id="orderId" value=0>

                    <div class="row">
                        <label for="percent">减免</label>
                        <input type="text" id="percent"/>%（0到20之间）
                    </div>
                    <p class="text-center red fz-12" id='error_msg' style="display:none"> t </p>

                    <p class="text-center">
                        <button id="discount-pop" type="button" class="btn discount ml-5">打折</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#discount-pop').on('click', function () {
        $.ajax({
            url: '<?php echo Yii::app()->request->baseUrl; ?>/admin/client/salesDiscount',
            type: 'GET',
            data: {
                id: $("#orderId").val(),
                percent: $("#percent").val()
            },
            dataType: 'json',
            success: function (res) {
                if (res.ok) {
                    location.href = '<?php echo Yii::app()->request->baseUrl; ?>/admin/client/buyList';
                } else {
                    $('#error_msg').show().html(res.msg);
                }
            }
        });
    });
</script>