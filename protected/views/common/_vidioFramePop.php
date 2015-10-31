<div class="modal fade " id="vidio-frame-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-body text-center">
                <iframe id="youtube-iframe" frameborder="0" allowfullscreen="" src="#" style="width:100%;height:100%;z-index: 1"></iframe>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript">
    $(function(){
        $(document).on('click','.vidio-trigger',function(){
            var url = $(this).data('url');
            if(url){
                var src = url;
                $('#youtube-iframe').attr('src',src);
                $('#vidio-frame-popup').modal('show');
            }
        })

        $('#vidio-frame-popup').on('hidden.bs.modal', function () {
            $('#youtube-iframe').removeAttr('src');
        })
    })
</script>