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
広告分析 &raquo; <a href="/marketing/list">ショップ一覧</a> &raquo; <a href="/marketing/list/253792">アトリエ365</a> &raquo; <a href="/marketing/TopItemList/253792">商品一覧</a> &raquo; <a href="/marketing/TopItemList/253792?itemCode=sun-ms-set-1066-ts">【6時間限定】スマートモデル半袖形態安定Yシャツ 全18色【SNC】【ワイシャツ】/sun-ms-set-1066-ts【楽ギフ_包装】【RCP】【カッターシャツ】</a> &raquo; <a href="/marketing/analysisItemDetailFromTopItemList/253792?itemCode=sun-ms-set-1066-ts">広告分析</a> &raquo; <span>商品広告</span> &raquo; <span>トップ特集</span></div>                        <div id="content" class="marketing clearfix">
                <div class="submenu">
    
</div>   <!-- form -->

<form class="form-inline" id="analysisItemAdFromDetail_form" action="/marketing/analysisItemAdFromItemDetailFromTopItemList/253792?itemCode=sun-ms-set-1066-ts&amp;date=2014-08-06" method="get">
<div style="display:none"><input type="hidden" value="sun-ms-set-1066-ts" name="itemCode" />
<input type="hidden" value="2014-08-06" name="date" /></div><div class="form-set">

    <div class="row">
	<label for="type">広告種類</label>
	<select class="form-control" name="adTypeChange" id="adTypeChange">
<option value="web" selected="selected">WEB広告</option>
<option value="email">メール広告</option>
<option value="cpc">サーチ広告</option>
</select>		<select class="form-control" style="display:inline" name="adTypeChangeWeb" id="adTypeChangeWeb">
<option value="all">全て</option>
<option value="top">トップ</option>
<option value="m_top">トップ(スマホ)</option>
<option value="topevent" selected="selected">トップ特集</option>
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
</select>	<select class="form-control" style="display:none" name="adTypeChangeEmail" id="adTypeChangeEmail">
<option value="all">全て</option>
<option value="email_0">楽天メルマガ</option>
<option value="email_1">ショップメルマガ</option>
</select>	<select class="form-control" style="display:none" name="adTypeChangeCpc" id="adTypeChangeCpc">
<option value="all">全て</option>
<option value="p_cpc">サーチ広告</option>
<option value="m_cpc">サーチ広告(スマホ)</option>
</select>
</div>
<input type="hidden" name="adType" id="adType" value='topevent'/>
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
    <input size="10" maxlength="10" class="form-control" id="BetweenTime_start" type="text" value="2014-08-01" name="BetweenTime[start]" />    <span id='fenge'>~</span>
    <input size="10" maxlength="10" class="form-control" id="BetweenTime_end" type="text" value="2014-08-31" name="BetweenTime[end]" />
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
                            <th rowspan="2">メンズファッション</th>
                            <th rowspan="2">スーツ</th>
                            <th rowspan="2">ワイシャツ</th>
                            <th rowspan="2">半袖形態安定ワイシャツ</th>
                            <th rowspan="2">ボタンダウン</th>
                                        <th rowspan="2" width='90px'>タイプ</th>
                <th rowspan="2" width='290px'>タイトル</th>
                <th rowspan="2" width='140px'>広告ページ</th>
                <th rowspan="2" width='90px'>位置</th>
                <th rowspan="2" width='180px'>内容</th>
                    </tr>
                </thead>
        <tbody>
                                                                <tr class="even">
                    <td>2014-08-01</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-02</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-03</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-04</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-05</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr id="intro-step-10" data-step="10" class="odd">
                    <td>2014-08-06</td>
                                            <td>128</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        
                        <td colspan="5">
                                                            <table class="table-in-table">
                                                                                <tr class="border-none">
                                                <td width=90px>トップ特集</td>
                                                <td width=290px> 【楽天市場】6時間限定 タイムセール | 楽天最安値に挑戦！大特価の商品が日替わりで登場！</td>
                                                <td width=140px><a target="_blank" href="http://event.rakuten.co.jp/bargain/timesale/">掲載ページへ</a><br/><a target="_blank" href="/images/tmp/19248.jpg">キャプチャー</a></td>
                                                <td width=90px></td>
                                                <td width=180px><a target="_blank" href="/images/ias_ads_img/2014-08-06/253792-sun-ms-set-1066-ts-2014-08-06-742.jpg">広告画像</a> &nbsp;</td>
                                            </tr>
                                                                        </table>
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-07</td>
                                            <td>189</td>
                                            <td>6</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-08</td>
                                            <td>--</td>
                                            <td>25</td>
                                            <td>3</td>
                                            <td>3</td>
                                            <td>3</td>
                                            <td>3</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-09</td>
                                            <td>--</td>
                                            <td>218</td>
                                            <td>35</td>
                                            <td>16</td>
                                            <td>8</td>
                                            <td>8</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-10</td>
                                            <td>--</td>
                                            <td>32</td>
                                            <td>5</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-11</td>
                                            <td>--</td>
                                            <td>146</td>
                                            <td>14</td>
                                            <td>9</td>
                                            <td>2</td>
                                            <td>2</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-12</td>
                                            <td>--</td>
                                            <td>48</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>2</td>
                                            <td>2</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-13</td>
                                            <td>--</td>
                                            <td>252</td>
                                            <td>17</td>
                                            <td>7</td>
                                            <td>4</td>
                                            <td>4</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-14</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-15</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-16</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-17</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-18</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-19</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-20</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-21</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-22</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-23</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-24</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-25</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-26</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-27</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-28</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-29</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="odd">
                    <td>2014-08-30</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        
                        <td colspan="5">
                                                    </td>

                                    </tr>
                                            <tr class="even">
                    <td>2014-08-31</td>
                                            <td>900</td>
                                            <td>7</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                        
                        <td colspan="5">
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