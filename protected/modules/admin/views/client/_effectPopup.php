<?php

?>
<div class="modal fade " id="effect-popup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="orderId2" id="orderId2" value=0/>
                    <input type="hidden" name="defaultDate" id="defaultDate" value="<?= date('Y-m-d H:i:s') ?>"/>

                    <div class="row">
                        <label for="payTime">选择</label>
                        <input type="text" id="payTime" data-field="datetime" readonly/>

                        <div id="dtBox"></div>
                    </div>
                    <p class="text-center red fz-12" id='error_msg2' style="display:none"> t </p>

                    <p class="text-center">
                        <button id="effect-pop" type="button" class="btn setTime ml-5">设定</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    /*$(document).ready(function () {
        $("#dtBox").DateTimePicker({
            defaultDate: $("#defaultDate").val(),
            dateTimeFormat: "yyyy-MM-dd HH:mm:ss"
        })
    });*/
    $('#effect-pop').on('click', function () {
        $.ajax({
            url: '<?= Yii::app()->request->baseUrl; ?>/admin/client/setTime',
            type: 'GET',
            data: {
                orderId: $("#orderId2").val(),
                payTime: $("#payTime").val()
            },
            dataType: 'json',
            success: function (res) {
                if (res.ok) {
                    location.href = '<?= Yii::app()->request->baseUrl; ?>/admin/client/buyList';
                } else {
                    $('#error_msg2').show().html(res.msg);
                }
            }
        });
    });
</script>