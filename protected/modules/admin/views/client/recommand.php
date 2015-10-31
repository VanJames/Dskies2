<style type="text/css">
.m1-list {width: 700px;float:left;}
.m1-list li{ height: 20px; line-height: 20px; padding: 10px 0; overflow: hidden; box-sizing: content-box; }
.m1-list li p{ float: left; }
.m1-list .col1{ width: 236px; }
.m1-list .col2{ width: 100px; text-align: center; float: right;}
.m1-list .col3{ float: right; width: 100px; }
.ul-head {width: 160px;float:left;font-size:16px;padding: 10px 0;clear:both;}
.ul-head p{font-size:12px}
.input-num a {
    background: url("http://static.nint.jp/images/home/input-num-btn.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
    color: #717171;
    float: left;
    height: 22px;
    line-height: 22px;
    width: 25px;    
}
.input-num input {
    border: 1px solid #787b7c;
    float: left;
    height: 22px;
    line-height: 24px;
    outline: medium none;
    text-align: center;
    width: 35px;
}
</style>
<div class="center_main">
    <p>Shop Name の入力後、各種推薦理由と本数を選択し、お薦めコースで問題無ければ「レコメンド作成」ボタンをクリックする</p>
    <?= CHtml::beginForm(array(''), 'GET') ?>
        <span class="red"><?php if($isSave) echo "保存成功"; ?></span><br />
        <table style="border-style: none">
    		<tr>
    			<th style="width: 100px;"><?= CHtml::activeLabel($form, 'shopName') ?></th>
    			<td style="border-style: none"><?= CHtml::activeTextField($form, 'shopName', array('class' => 'txt1', 'style' => 'width: 236px','name'=>'Form[shopName]')) ?> </td>
    			<td style="border-style: none">
                    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    		    </td>
    		</tr>
        </table>
    <?= CHtml::endForm() ?>
    <a href="/admin/client/imitate?clientId=<?= $clientId ?>" title="模拟用户" target="_blank">
        <img alt="模拟用户" src="<?= $this->module->imagePathUrl . '/imitate.gif' ?>">
    </a>
    <?php if($shop->title){ ?>
        <a class="btnRec" href="/admin/suggest/list?shopName=<?= $form->shopName ?>&similarity=0.6" target="_blank" style="margin-left:100px">诊断</a>
        <?php if($requests) echo CHtml::submitButton('删除', array('class' => 'btnRec', 'style' => '','id' => 'del_btn')); ?>
        <?= CHtml::hiddenField('mid', $mid) ?>
        <table style="border-style: none">
            <tr>
    			<th style="width: 100px;">ショップ名</th>
    			<td style="border-style: none"><?= $shop->title ?></td>
    		</tr>
    		<tr>
    			<th style="width: 100px;">会社名</th>
    			<td style="border-style: none"><?= $shop->company ?></td>
    		</tr>
    		<tr>
    			<th style="width: 100px;" rowspan="<?= count($sales)+1 ?>" >取扱いジャンル</th>
            </tr>
            <?php foreach ($sales as $name=>$sales_index): ?>
            <tr>
    		    <td style="border-style: none"><?= $name ?><br /></td>
    		    <td style="border-style: none">(<?= round(($sales_index/$sum[sum])*100).'%' ?>)<br /></td>
    	    </tr>
            <?php endforeach; ?>
        </table>
        <br/>
        <?php
            if(Yii::app()->getAuthManager()->checkAccess('TrialMember',$mid)){
                if($requests){extract($requests);}
        ?>
            <?= CHtml::beginForm(array('Form[shopName]'=>$form->shopName), 'POST',array('name'=>buyForm)) ?>
                <div class="ul-head">業種分析</div>
            	<ul class="m1-list">
            <?php if($category_num){
                for($i=0;$i<count($category_num);$i++){
                    if($category_num[$i]){ ?>
            		<li class="old">
            			<p class="col0"><?= CHtml::activeDropDownList($form, 'category', $category, array('class' => 'txt1', 'style' => 'width: 220px','name'=>'category[]','options'=>array($category_reasons[$i][category]=>array('selected '=>'selected')))) ?></p>
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'categoryReason', $form->categoryReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'category_reasons[]','options'=>array($category_reasons[$i][category_reasons]=>array('selected '=>'selected')))) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='category_num[]' onchange="" value="<?=$category_num[$i]?>"><a type="add">+</a><em>本</em></i></p>
            		</li>
            <?php }}}else{ 
                foreach ($cids as $cid): ?>
            		<li class="old">
            			<p class="col0"><?= CHtml::activeDropDownList($form, 'category', $category, array('class' => 'txt1', 'style' => 'width: 220px','name'=>'category[]','options'=>array($cid=>array('selected '=>'selected')))) ?></p>
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'categoryReason', $form->categoryReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'category_reasons[]','options'=>array(1=>array('selected '=>'selected')))) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='category_num[]' onchange="" value="1"><a type="add">+</a><em>本</em></i></p>
            		</li>
                <?php endforeach; ?>
            <?php } ?>
            		<li class="new">
            			<p class="col0"><?= CHtml::activeDropDownList($form, 'category', $category, array('class' => 'txt1', 'style' => 'width: 220px','name'=>'category[]')) ?></p>
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'categoryReason', $form->categoryReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'category_reasons[]')) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='category_num[]' onchange="" value="0"><a type="add">+</a><em>本</em></i></p>
            		</li>
                </ul>
                <div class="ul-head">ショップ分析</div>
            	<ul class="m1-list">
            <?php if($shop_num){
                for($i=0;$i<count($shop_num);$i++){ 
                    if($shop_num[$i]){?>
            		<li class="old">
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'shopReason', $form->shopReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'shop_reasons[]','options'=>array($shop_reasons[$i]=>array('selected '=>'selected')))) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='shop_num[]' onchange="" value="<?=$shop_num[$i]?>"><a type="add">+</a><em>本</em></i></p>
            		</li>
            <?php }}} ?>
            		<li class="new">
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'shopReason', $form->shopReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'shop_reasons[]')) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='shop_num[]' onchange="" value="0"><a type="add">+</a><em>本</em></i></p>
            		</li>
                </ul>
                <div class="ul-head">商品分析</div>
            	<ul class="m1-list">
            <?php if($item_num){
                for($i=0;$i<count($item_num);$i++){ 
                    if($item_num[$i]){?>
            		<li class="old">
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'itemReason', $form->itemReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'item_reasons[]','options'=>array($item_reasons[$i]=>array('selected '=>'selected')))) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='item_num[]' onchange="" value="<?=$item_num[$i]?>"><a type="add">+</a><em>本</em></i></p>
            		</li>
            <?php }}} ?>
            		<li class="new">
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'itemReason', $form->itemReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'item_reasons[]')) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='item_num[]' onchange="" value="0"><a type="add">+</a><em>本</em></i></p>
            		</li>
                </ul>
                <div class="ul-head">広告分析</div>
            	<ul class="m1-list" >
            <?php if($marketing_num){
                for($i=0;$i<count($marketing_num);$i++){ 
                    if($marketing_num[$i]){?>
            		<li class="old">
                        <p class="col1"><?= CHtml::activeDropDownList($form, 'marketingReason', $form->marketingReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'marketing_reasons[]','options'=>array($marketing_reasons[$i]=>array('selected '=>'selected')))) ?></p>
                        <p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='marketing_num[]' onchange="" value="<?=$marketing_num[$i]?>"><a type="add">+</a><em>本</em></i></p>
            		</li>
            <?php }}} ?>
            		<li class="new">
            			<p class="col1"><?= CHtml::activeDropDownList($form, 'marketingReason', $form->marketingReasons(), array('class' => 'txt1', 'style' => 'width: 220px','name'=>'marketing_reasons[]')) ?></p>
            			<p class="col2"><i class="input-num"><a type="sub">-</a><input type="text" name='marketing_num[]' onchange="" value="0"><a type="add">+</a><em>本</em></i></p>
            		</li>
                </ul>
                <div class="ul-head">契約期間</div>
            	<ul class="m1-list">
            		<li class="row9">
            			<p class="col1">
                            <select name="month_num" id="month_num" onchange="eidt_display('category')">
                                <option value="1">1ヶ月</option>
                                <option value="3">3ヶ月</option>
                                <option value="6">6ヶ月</option>
                                <option value="12" selected>1年</option>
                            </select>
                        </p>
            		</li>
                </ul>
                
                <input type="hidden" name="discount_name" id="hide_discount_name" value="無" /> 
                <div class="ul-head"  id="discount_message_name">お薦めコース</div>
                <ul class="m1-list">
        			<li class="row13">
        				<p class="col4 red" id="discount_name"></p>
        			</li>
                </ul>
                <div class="ul-head">利用料(月額)</div>
                <ul class="m1-list">
    				<li class="row7 bdt">
    					<p class="col4 red" id="month_fee">￥0</p>
    				</li>
                </ul>
                    <div class="ul-head">
                        <p class="red" id="alert_message">最低消費　<?php echo Util::myNumberFormat(Yii::app()->params['buyPrice']['minFee']); ?>円</p>
                        <p class="red" id="alert_message2">業種分析最少选择一个</p>
                    </div>
                <input class="btnRec" id="submit_button" type="button" onclick="validate()" value="レコメンド作成" style='width:100px;float:left;clear:both'>
            <?= CHtml::endForm() ?>
    <?php }}?>
</div>

<script>
var mid = $("#mid").val();
var thisUrl = document.location.href;
var baseUrl = '<?php echo Yii::app()->baseUrl; ?>';
$("#test_b").click(function(){
    x=$("form").serializeArray();
    console.log(x);

});
$('#del_btn').click(function() {
    var r=confirm("确认删除？") 
    if (r==true){
        $.ajax({
            url: baseUrl + '/admin/client/delRecommand',
            type: 'POST',
            data: {
                mid : mid
            },
            dataType: 'json',
            success: function(resp) {
                if (resp.ok) {
                    location.replace(thisUrl);
                }
            }
        });
    }
});
    
    var month_fee;
    $('.m1').toggleClass('on');
    get_package();
    if(<?= $month?$month:0; ?>){
        $('#month_num').val(<?= $month ?>);
    }
    
    var category_num;
    var tmp = 0;
    $('i.input-num a').click(function(){change_num1(this);});
    $('i.input-num input').click(function(){tmp=this.value;});
    $('i.input-num input').change(function(){change_num(this);});
    
    function change_num(obj){
        var target = $(obj);
        var select = target.parents("li").children("p.col1").children();
        if(select.val()>0){
            var num = target.val();
            if(num<0){
                target.val(0);
            }
            if(num==0 && tmp>0){
                var parent_li = target.parents("li");
                parent_li.remove();
                eidt_display();
            }
            else if(num>0 && tmp==0){
                eidt_display();
                
                var parent_li = target.parents("li");
                parent_li.attr("class","old");
                parent_li.after("<li class='add'>"+parent_li.html()+"</li>");
                $('li.add a').click(function(){change_num1(this);});
                $('li.add input').change(function(){change_num(this);});
                $('i.input-num input').click(function(){tmp=this.value});
                $('li.add').attr("class","new");
            }
            
            if(num>1 && select.attr("id")=='category_reasons'){
                target.val(1);
            }
            eidt_display();
        }else{
           alert("请选择理由");
           target.val(0);
        }
    }
    
    
    function change_num1(obj){
        var target = $(obj);
        var select = target.parents("li").children("p.col1").children();
        if(select.val()>0){
            var num = target.siblings("input").val();
            if($(obj).attr('type')=="sub"){
                num = num - 1;
                var parent_li = target.parents("li");
                if(num==0){
                    parent_li.remove();
                }
                if(num<0){
                    num = 0;
                }
                target.siblings("input").val(num);
                eidt_display();
            }
            else if($(obj).attr('type')=="add"){
                num = num - -1;
                target.siblings("input").val(num);
                eidt_display();
                
                var parent_li = target.parents("li");
                parent_li.attr("class","old");
                if(num==1){
                    parent_li.after("<li class='add'>"+parent_li.html()+"</li>");
                    $('li.add a').click(function(){change_num1(this);});
                    $('li.add input').change(function(){change_num(this);});
                    $('i.input-num input').click(function(){tmp=this.value});
                    $('li.add').attr("class","new");
                    eidt_display();
                }
            }
            if(num>1 && select.attr("id")=='category_reasons'){
                target.siblings("input").val(1);
            }
            eidt_display();
        }else{
           alert("请选择理由");
           eidt_display();
        }
    }
    
    function get_package() {
        var package_id = $('#package_id').val();
        <?php foreach($buyPackages as $i=>$buyPackage): ?>
        if(package_id==<?php echo $buyPackage['id'] ?>){
            $('#category').val(<?php echo $buyPackage['category_num'] ?>);
            $('#shop').val(<?php echo $buyPackage['shop_num'] ?>);
            $('#item').val(<?php echo $buyPackage['item_num'] ?>);
            $('#marketing').val(<?php echo $buyPackage['marketing_num'] ?>);
        }
        <?php endforeach; ?>
        eidt_display('category');
    }
    
    
    function eidt_display() {
        var priceHash = {
            "category":"<?php echo $buyPrices['category']; ?>",
            "shop":"<?php echo $buyPrices['shop']; ?>",
            "item":"<?php echo $buyPrices['item']; ?>",
            "marketing":"<?php echo $buyPrices['marketing']; ?>"
        };

        var arrayObj = new Array("category", "shop", "item", "marketing");

        var month_num = $('#month_num').val();

        var category_input = document.getElementsByName('category_num[]');
        category_num=0;
        for(var i=0; i<category_input.length; i++){
            category_num += Number(category_input[i].value);
        }
        var shop_input = document.getElementsByName('shop_num[]');
        var shop_num=0;
        for(var i=0; i<shop_input.length; i++){
            shop_num += Number(shop_input[i].value);
        }
        var item_input = document.getElementsByName('item_num[]');
        var item_num=0;
        for(var i=0; i<item_input.length; i++){
            item_num += Number(item_input[i].value);
        }
        var marketing_input = document.getElementsByName('marketing_num[]');
        var marketing_num=0;
        for(var i=0; i<marketing_input.length; i++){
            marketing_num += Number(marketing_input[i].value);
        }

        month_fee = (category_num*priceHash['category']+shop_num*priceHash['shop']+item_num*priceHash['item']+marketing_num*priceHash['marketing']);
        var start_fee_month = 1;
        if(month_num>=12)
            start_fee_month = 2;
        var start_fee = month_fee*start_fee_month;
        var total_fee = month_fee*month_num+start_fee;
        var discount_fee = 0;
        var year_discount_fee = start_fee;
        var allPay_discount_fee = month_fee*month_num*<?php echo Yii::app()->params['buyPrice']['allPayDiscount']; ?>/100;
        var result_fee = total_fee;
        if(month_num!=1){
            $('.row10').removeClass('hidden');
        }
        else{
            $('#is_all').attr("checked", false);
            $('#is_all').removeAttr("checked");
            $('.row10').addClass('hidden');
        }
        if(month_num==12){
            $('.row13').removeClass('hidden');
            result_fee = result_fee - year_discount_fee;
        }
        
        if($('#is_all').attr("checked")=="checked" && month_num==12){
            result_fee = result_fee - allPay_discount_fee;
            $('.row14').removeClass('hidden');
        }
        else{
            $('.row14').addClass('hidden');
        }
        
        $('#month_fee').html("￥" + fmoney(month_fee,0));
        $('#start_fee').html("￥" + fmoney(start_fee,0));
        $('#total_fee').html("￥" + fmoney(total_fee,0));
        $('#year_discount_fee').html("￥" + fmoney(year_discount_fee,0));
        $('#allPay_discount_fee').html("￥" + fmoney(allPay_discount_fee,0));
        
        $('#discount_message').html("ボリューム割引(0％)");
        $('#discount_fee').html("￥0");
        $('#discount_name').html("無");
        $('#hide_discount_name').val("無");
        <?php foreach($buyPackages as $i=>$buyPackage): ?>
        if(month_fee>=<?php echo $buyPackage['min_fee'] ?>){
            $('#discount_message').html("ボリューム割引(<?php echo $buyPackage['discount'] ?>％)");
            discount_fee = <?php echo $buyPackage['discount'] ?>*month_fee*month_num/100;
            $('#discount_fee').html("￥" + fmoney(discount_fee,0));
            $('#discount_name').html("<?php echo $buyPackage['name'] ?>");
            $('#hide_discount_name').val("<?php echo $buyPackage['name'] ?>");
        }
        <?php endforeach; ?>
            
        result_fee = result_fee - discount_fee;
        $('#result_fee').html("￥" + fmoney(result_fee,0));
        var first_pay = (result_fee - start_fee) / month_num + start_fee;
        $('#first_pay').html("￥" + fmoney(first_pay,0));
        if (month_num > 1 && $('#is_all').attr("checked") !== "checked") {
            var later_pay = (result_fee - start_fee) / month_num;
            $('.row17').removeClass('hidden');
            $('#later_pay').html("￥" + fmoney(later_pay,0));
        } else {
            $('#first_pay').html("￥" + fmoney(result_fee,0));
            $('.row17').addClass('hidden');
        }
        if(month_fee<<?php echo Yii::app()->params['buyPrice']['minFee']; ?>){
            $('#alert_message').removeClass("hidden");
        }
        else{
            $('#alert_message').addClass("hidden");
        }
        
        if(category_num<1){
            $('#alert_message2').removeClass("hidden");
        }
        else{
            $('#alert_message2').addClass("hidden");
        }
        if(category_num<1 || month_fee<<?php echo Yii::app()->params['buyPrice']['minFee']; ?>){
            $("#submit_button").attr('class', 'btnSrch');
        }
        else{
            $("#submit_button").attr('class', 'btnRec');
        }

    }
    
    function validate(){
        if(month_fee>=<?php echo Yii::app()->params['buyPrice']['minFee']; ?> && category_num>0 ){
            document.buyForm.submit();
        }
    }
    
    function fmoney(s, n) {
        var isFloat = true;
        if(n==0){
            isFloat = false;
        }
        n = n > 0 && n <= 20 ? n : 2;
        s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
        var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1];
        t = "";
        for (i = 0; i < l.length; i++) {
            t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
        }
        if(isFloat){
            return t.split("").reverse().join("") + "." + r;
        }
        else{
            return t.split("").reverse().join("")
        }
    }
</script>