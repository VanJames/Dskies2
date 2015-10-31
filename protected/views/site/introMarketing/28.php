<div class="container-fluid">
            <ul class="nav nav-tabs">
                <li><a href="/stat">業種分析</a></li>
                <li><a href="/shop">ショップ分析</a></li>
                <li><a href="/item">商品分析</a></li>
                <li class="active"><a href="/marketing">広告分析</a></li>
                <!--                <li><a href="/search">検索分析</a></li>
                                <li><a href="/seo">SEO分析</a></li>-->
                <li><a href="/personal">アカウント</a></li>
                <li><a href="/news">攻略！</a></li>
            </ul>
                            <div class="breadcrumbs">
広告分析 &raquo; <a href="/marketing/list">ショップ一覧</a> &raquo; <a href="/marketing/list/197539">ルイール　コン美ニエンスショップ</a> &raquo; <a href="/marketing/analysis/197539">広告解析</a> &raquo; <a href="/marketing/analysisItemList/197539?date=2014-08-31">2014-08-31 商品一覧</a> &raquo; <a href="/marketing/analysisItemList/197539?itemCode=pmm-yami&date=2014-08-31">送料無料！潤い力＆肌触りがスゴイ? 【NEW プリュ プラセンタ モイスチュアマスク（35枚入）】[M1] シートパック マスク フェイスパックシート フェイスマスク 顔用 美容マスク プラチナ 白金 plus 日本製[yami]</a> &raquo; <a href="/marketing/analysisItemDetail/197539?itemCode=pmm-yami&date=2014-08-31">広告詳細分析</a> &raquo; <span>商品広告</span> &raquo; <span>楽天メルマガ</span></div>                        <div id="content" class="marketing clearfix">
                <div class="submenu">
    
</div>   <!-- form -->

<form class="form-inline" id="analysisItemAdFromDetail_form" action="/marketing/analysisItemAdFromItemDetail/197539?itemCode=pmm-yami&amp;date=2014-08-31" method="get">
<div style="display:none"><input type="hidden" value="pmm-yami" name="itemCode" />
<input type="hidden" value="2014-08-31" name="date" /></div><div class="form-set">

    <div class="row">
	<label for="type">広告種類</label>
	<select class="form-control" name="adTypeChange" id="adTypeChange">
<option value="web">WEB広告</option>
<option value="email" selected="selected">メール広告</option>
<option value="cpc">サーチ広告</option>
</select>		<select class="form-control" style="display:none" name="adTypeChangeWeb" id="adTypeChangeWeb">
<option value="all">全て</option>
<option value="top">トップ</option>
<option value="m_top">トップ(スマホ)</option>
<option value="topevent">トップ特集</option>
<option value="event">特集</option>
<option value="m_event">特集(スマホ)</option>
<option value="category">ジャンル</option>
<option value="m_category">ジャンル(スマホ)</option>
<option value="coupon">クーポン</option>
<option value="asuraku">あす楽</option>
<option value="freeshipping">送料無料</option>
<option value="regular">定期購入</option>
<option value="product">プロダクト</option>
<option value="ranking">ランキング</option>
</select>	<select class="form-control" style="display:inline" name="adTypeChangeEmail" id="adTypeChangeEmail">
<option value="all">全て</option>
<option value="email_0" selected="selected">楽天メルマガ</option>
<option value="email_1">ショップメルマガ</option>
</select>	<select class="form-control" style="display:none" name="adTypeChangeCpc" id="adTypeChangeCpc">
<option value="all">全て</option>
<option value="p_cpc">サーチ広告</option>
<option value="m_cpc">サーチ広告(スマホ)</option>
</select>
</div>
<input type="hidden" name="adType" id="adType" value='email_0'/>
<script type="text/javascript">
$(document).on('change', '#adTypeChange', function() {
	var $this 	= $(this);
	if($this.val() == 'web'){
		$("#adTypeChangeWeb").show();
		$("#adTypeChangeEmail").hide();
		$("#adTypeChangeCpc").hide();
	}else if($this.val() == 'email'){
        $("#adTypeChangeWeb").hide();
        $("#adTypeChangeEmail").show();
        $("#adTypeChangeCpc").hide();
    }else if($this.val() == 'cpc'){
        $("#adTypeChangeEmail").hide();
        $("#adTypeChangeWeb").hide();
        $("#adTypeChangeCpc").show();
    }else {
        $("#adTypeChangeEmail").hide();
        $("#adTypeChangeWeb").hide();
        $("#adTypeChangeCpc").hide();
    }
	$("#adType").val($(this).val());
 });
$(document).on('change', '#adTypeChangeWeb', function() {
	$("#adTypeChangeEmail").hide();
	$("#adTypeChangeCpc").hide();
	if($(this).val() == 'all'){
		$("#adType").val('web');
	}else{
		$("#adType").val($(this).val());
	}
 });
$(document).on('change', '#adTypeChangeEmail', function() {
	$("#adTypeChangeWeb").hide();
    $("#adTypeChangeCpc").hide();
	if($(this).val() == 'all'){
		$("#adType").val('email');
	}else{
		$("#adType").val($(this).val());
	}
 });
$(document).on('change', '#adTypeChangeCpc', function() {
    $("#adTypeChangeWeb").hide();
    $("#adTypeChangeEmail").hide();
	if($(this).val() == 'all'){
		$("#adType").val('cpc');
	}else{
		$("#adType").val($(this).val());
	}
 });
</script>
    <div class="row">

    <label>
    日時   </label>
    <input size="10" maxlength="10" class="form-control" id="BetweenTime_start" type="text" value="2014-08-31" name="BetweenTime[start]" />    <span id='fenge'>~</span>
    <input size="10" maxlength="10" class="form-control" id="BetweenTime_end" type="text" value="2014-09-04" name="BetweenTime[end]" />
</div>

    <div class="row">
        <button type="submit" class="btn btn-primary">
            検索        </button>
    </div>
</div>
<input id="is_csv" type="hidden" value="0" name="is_csv" /></form><p class="text-right button-group">
        <button type="button" class="btn csv-dl-button" onclick="csvDownload('analysisItemAdFromDetail_form')"></button>
    <!-->
</p>

<!-- table -->
<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th rowspan="2">日時</th>
                            <th rowspan="2">総合</th>
                            <th rowspan="2">美容?コスメ?香水</th>
                            <th rowspan="2">スキンケア</th>
                            <th rowspan="2">パック?マスク（シートタイプ）</th>
                            <th rowspan="2">顔用</th>
                            <th rowspan="2">その他</th>
                                                            <th rowspan="2" width='120px'>タイプ</th>
                    <th rowspan="2" width='290px'> タイトル</th>
                    <th rowspan="2" width='180px'>内容</th>
                                    </tr>
                </thead>
        <tbody>
                                                                <tr class="even">
                    <td>2014-08-31</td>
                                            <td>16</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>--</td>
                                                                                            <td colspan="3">
                                                                    <table class="table-in-table">
                                                                                    <tr class="border-none">
                                                <td width=120px>楽天メルマガ</td>
                                                <td width=290px>楽天市場ニュース</td>
                                                <td id="intro-step-28" data-step="28" width=180px><a target="_blank" href="#" onclick="goToNext(event)">メール内容</a></td>
                                            </tr>
                                                                            </table>
                                                            </td>
                                                            </tr>
                                            <tr class="odd">
                    <td>2014-09-01</td>
                                            <td>10</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>--</td>
                                                                                            <td colspan="3">
                                                            </td>
                                                            </tr>
                                            <tr class="even">
                    <td>2014-09-02</td>
                                            <td>16</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>--</td>
                                                                                            <td colspan="3">
                                                                    <table class="table-in-table">
                                                                                    <tr class="border-none">
                                                <td width=120px>楽天メルマガ</td>
                                                <td width=290px>楽天ランキング市場ニュース</td>
                                                <td width=180px><a target="_blank" href="/marketing/showEmail/63440">メール内容</a></td>
                                            </tr>
                                                                            </table>
                                                            </td>
                                                            </tr>
                                            <tr class="odd">
                    <td>2014-09-03</td>
                                            <td>18</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>--</td>
                                                                                            <td colspan="3">
                                                            </td>
                                                            </tr>
                                            <tr class="even">
                    <td>2014-09-04</td>
                                            <td>89</td>
                                            <td>7</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>--</td>
                                                                                            <td colspan="3">
                                                            </td>
                                                            </tr>
                            </tbody>
    </table>
</div>
<div class="modal fade" id="review-point-popup" tabindex="-1">
    <div class="modal-dialog " style="width:450px;height:150px;padding-top:100px">
        <div class="modal-content">
            <div class="modal-header">
                <span id="modal-title"></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function show(msg) {
        $('#review-point-popup').modal('show');
        $('.modal-body').html(msg);
    }
</script>
            </div>
            
                                            
        </div>