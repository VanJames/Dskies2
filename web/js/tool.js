/**
 * Created by fanxu(746439274@qq.com) on 2015/11/4.
 */
if (typeof FX == "undefined") { FX = {}; }
FX.form = { page:1, pageSize:20, end:false, lastUpdate:0, isAjaxUrl:'',  preAppend:false, initOriginalFormData:{}, agt : navigator.userAgent.toLowerCase(),
    is_op : function(){return (this.agt.indexOf("opera") != -1)},
    is_ie : function(){return (this.agt.indexOf("msie") != -1) && document.all && !is_op},
    is_mac : function(){return (this.agt.indexOf("mac") != -1)},
    is_gk : function(){return (this.agt.indexOf("gecko") != -1)},
    is_sf : function(){return (this.agt.indexOf("safari") != -1)},
    ajax:function(url,data,type,dataType){
        if(this.isAjaxUrl==url)return false;if(!url) return false; if(!data) data = {}; if(!type) type = 'post';
        if(!dataType) dataType = 'json'; var that = this; this.isAjaxUrl = url;
        $.ajax({ url: url, type: type, data: data, dataType:dataType,
            error:function(data){ FX.form.isAjaxUrl = ''; alert('网络错误!'); }
        }).done(function(data){ that.isAjaxUrl = '';
            if(data.error_code==0){
                if(data.data.backUrl){ if(data.data.msg){ alert(data.data.msg); }
                    location.href=data.data.backUrl; return true;
                } that.ajaxSuccess(data.data); }
            else{ that.ajaxFailed(data); }
        }); return this; },
    submit:function(form){ if($(form).attr('ajaxfalse')){ return false; }
        this.ajax($(form).attr('action'),this.getFormJson(form),$(form).attr('method')); },
    ajaxSuccess:function(data){ alert( data );  }, ajaxFailed:function(data){ alert( data.message ); },
    //将form中的值转换为键值对。
    getFormJson : function(frm) { var o = {}; var a = $(frm).serializeArray();
        $.each(a, function () { if (o[this.name] !== undefined) {
                if (!o[this.name].push) { o[this.name] = [o[this.name]]; }
                o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } });
        return o; },
    validate:function(o){ var input_type = $(o).attr('input-type'),filter  = '',msg='',val=$(o).val();
        if(!val&&$(o).attr('null-msg')){  msg = $(o).attr('null-msg') || '不能为空';
            alert( msg ); $(o).addClass('form-error').focus(); return false; }
        if(!val&&!$(o).attr('null-msg')){ return true; }
        switch (input_type){
            case 'email':
                filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                msg = $(o).attr('error-msg') || '邮箱格式不正确!';
                break;
            case 'phone':
                filter = /^(13[0-9]|15[0-9]|18[0-9]|17[0-9])\d{8}$/;
                msg = $(o).attr('error-msg') || '手机号格式不正确!';
                break;
            case 'number':
                filter = /^[0-9]*$/;
                msg = $(o).attr('error-msg') || '数字格式不正确!';
                break;
            case 'account':
                filter = /^[a-zA-z][a-zA-Z0-9_]{2,9}$/;
                msg = $(o).attr('error-msg') || '格式不正确!';
                break;
            default :
                break;
        }
        if(filter&&!filter.test(val)){
            //error handle
            alert(msg); $(o).addClass('form-error').focus();
            return false;
        }
        return true;
    }
};
//$('form').on('blur','.validator',function(){
//    FX.form.validate(this);
//});
$('form').on('submit',function(){ var formValidate = true; $.each($(this).find('.validator'),function(k,v){
        if(!FX.form.validate(v)){ $(v).focus(); formValidate = false; return false; } });
    if( !formValidate ){ return false; } FX.form.submit(this); });