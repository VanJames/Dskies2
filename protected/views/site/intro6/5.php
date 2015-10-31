<div class="breadcrumbs">
広告分析 » <a href="/marketing/list">ショップ一覧</a> » <a href="/marketing/list/216056">flags tsubo shop</a> » <span>商品一覧</span></div>
<div class="marketing clearfix" id="content">
                <div class="submenu">
                    <a href="/marketing/topItemList/216056" class="ml-5"><span class="head"></span><span class="body">商品一覧</span><span class="foot"></span></a>                    <a href="/marketing/analysis/216056" class="ml-5"><span class="head"></span><span class="body">広告解析</span><span class="foot"></span></a>    
</div>   <!-- form -->
<form method="get" action="/marketing/topItemList/216056" id="topItemList_form" class="form-inline"><div class="form-set" id="intro-step-3" data-step="3">
    <div class="row">
        <div class="form-group">
            <label for="RSearcherForm_cid">ジャンル</label>            <select id="" name="" data-parent="0" data-level="1" class="item-category-list form-control">
<option value="">All</option>
<option value="100000">百貨店・総合通販・ギフト</option>
<option value="100005">花・ガーデン・DIY</option>
<option value="100026">パソコン・周辺機器</option>
<option value="100227">食品</option>
<option value="100316">水・ソフトドリンク</option>
<option value="100371">レディースファッション</option>
<option value="100433">インナー・下着・ナイトウエア</option>
<option value="100533">キッズ・ベビー・マタニティ</option>
<option value="100804">インテリア・寝具・収納</option>
<option value="100938">ダイエット・健康</option>
<option value="100939">美容・コスメ・香水</option>
<option value="101070">スポーツ・アウトドア</option>
<option value="101114">車・バイク</option>
<option value="101164">おもちゃ・ホビー・ゲーム</option>
<option value="101213">ペット・ペットグッズ</option>
<option value="101240">CD・DVD・楽器</option>
<option value="101381">旅行・出張・チケット</option>
<option value="101438">学び・サービス・保険</option>
<option value="200162">本・雑誌・コミック</option>
<option value="200163">不動産・住まい</option>
<option value="211742">TV・オーディオ・カメラ</option>
<option value="215783">日用品雑貨・文房具・手芸</option>
<option value="216129">ジュエリー・アクセサリー</option>
<option value="216131">バッグ・小物・ブランド雑貨</option>
<option value="402853">デジタルコンテンツ</option>
<option value="503190">車用品・バイク用品</option>
<option value="510901">日本酒・焼酎</option>
<option value="510915">ビール・洋酒</option>
<option value="551167">スイーツ・お菓子</option>
<option value="551169">医薬品・コンタクト・介護</option>
<option value="551177">メンズファッション</option>
<option value="558885">靴</option>
<option value="558929">腕時計</option>
<option value="558944">キッチン用品・食器・調理器具</option>
<option value="562637">家電</option>
</select><span></span> 
        </div>
</div>
 <input type="hidden" value="" name="RSearcherForm[cid]" id="item-category-cid"><script src="/js/marketing/search.js"></script>    <div class="row">
        <label for="item-title">商品名&#12288;</label> <input type="text" value="楽天週間ランキング1位" name="item-title" id="item-title" class="form-control">
    </div>
    <div class="row">
	<label for="type">広告種類</label>
	<select id="adTypeChange" name="adTypeChange" class="form-control">
<option selected="selected" value="all">制限がない</option>
<option value="web">WEB広告</option>
<option value="email">メール広告</option>
<option value="cpc">サーチ広告</option>
</select>		<select id="adTypeChangeWeb" name="adTypeChangeWeb" style="display:none" class="form-control">
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
</select>	<select id="adTypeChangeEmail" name="adTypeChangeEmail" style="display:none" class="form-control">
<option value="all">全て</option>
<option value="email_0">楽天メルマガ</option>
<option value="email_1">ショップメルマガ</option>
</select>	<select id="adTypeChangeCpc" name="adTypeChangeCpc" style="display:none" class="form-control">
<option value="all">全て</option>
<option value="p_cpc">サーチ広告</option>
<option value="m_cpc">サーチ広告(スマホ)</option>
</select>
</div>
<input type="hidden" value="all" id="adType" name="adType">
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
</script>    <div class="row">
        <button class="btn btn-primary" type="submit">検索</button>
    </div>
</div>
<input type="hidden" name="is_csv" value="0" id="is_csv"> 
</form><!-- table -->
<p class="text-right button-group">
    <button onclick="csvDownload('topItemList_form')" class="btn csv-dl-button" type="button"></button>
</p>
<div class="grid-view" id="item-list">
<div class="summary">1件の結果を1から1まで表示します。</div>
<table class="items">
<thead>
<tr>
<th colspan="2">商品名<span data-pop="" style="display:none;" class="question-mark"></span></th><th>ジャンル<span data-pop="" style="display:none;" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=price&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D">価格</a><span data-pop="" style="display:none;" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=point&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D">ポイ<br>ント</a><span data-pop="" style="display:none;" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=last_7&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D">最近7日<br>売上指数<br>（千円）</a><span data-pop="楽天ランキングの更新日から過去7日間のランキング順位、レビュー数、価格、トレンドなどを元に算出した指数です。" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=last_14&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D">最近14日<br>売上指数<br>（千円）</a><span data-pop="楽天ランキングの更新日から過去14日間のランキング順位、レビュー数、価格、トレンドなどを元に算出した指数です。" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=last_30&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D" class="glyphicon glyphicon-arrow-down">最近30日<br>売上指数<br>（千円）</a><span data-pop="楽天ランキングの更新日から過去30日間のランキング順位、レビュー数、価格、トレンドなどを元に算出した指数です。" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=review_num&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D">レビュ<br>ー数</a><span data-pop="" style="display:none;" class="question-mark"></span></th><th><a href="/marketing/topItemList/216056?sort=review_rate&amp;sortBy=asc&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D">商品<br>評価</a><span data-pop="" style="display:none;" class="question-mark"></span></th><th>商品広告<span data-pop="" style="display:none;" class="question-mark"></span></th><th>操作<span data-pop="" style="display:none;" class="question-mark"></span></th></tr>
</thead>
<tbody>
<tr class="odd" id="intro-step-4" data-step="4">
<td class="text-left"><img alt="" src="http://thumbnail.image.rakuten.co.jp/@0_mall/flags/cabinet/img60847243.jpg?_ex=60x60"></td><td width="380px" class="text-left"><a href="http://item.rakuten.co.jp/flags/10001001" target="_blank">＼楽天週間ランキング1位受賞商品／週末限定価格  【アシックス商事】【テクシーリュクス&#12288;TEXCY LUXE &#12288;】Sports Biz Style TU7704 TU7705 TU7706 TU7707 TU7715</a></td><td class="text-left"><a href="/marketing/topItemList/216056?lv1cid=558885&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D&amp;page=1">靴</a> <span style="color:#FF8000">»</span> <a href="/marketing/topItemList/216056?lv2cid=110983&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D&amp;page=1">メンズ靴</a> <span style="color:#FF8000">»</span> <a href="/marketing/topItemList/216056?lv3cid=304080&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D&amp;page=1">ビジネスシューズ</a></td><td>3,564</td><td>1倍</td><td>1,726</td><td>2,954</td><td>6,118</td><td>1,734</td><td>4.52</td><td width="160px" class="text-left"><i class="ads_icon"><a title="楽天メルマガ" href="/marketing/analysisItemAdFromTopItemList?id=216056&amp;itemCode=10001001&amp;date=&amp;type=email_0"><img src="/images/adType_icon/email_0.png"><b class="color-email_0-2">2</b></a></i></td><td width="100px"><a onclick="goToNext(event)" href="/marketing/analysisItemDetailFromTopItemList/216056?itemCode=10001001" title="広告解析"><img id="intro-step-5" data-step="5" alt="marketing" src="/images/icon/op-ad.png"></a> <a href="/marketing/trackFromTopItemList/216056?itemCode=10001001" title="商品追跡"><img alt="track" src="/images/icon/op-track.png"></a></td></tr>
</tbody>
</table>
<div title="/marketing/topItemList/216056?RSearcherForm%5Bcid%5D=&amp;item-title=%E6%A5%BD%E5%A4%A9%E9%80%B1%E9%96%93%E3%83%A9%E3%83%B3%E3%82%AD%E3%83%B3%E3%82%B01%E4%BD%8D&amp;adTypeChange=all&amp;adTypeChangeWeb=all&amp;adTypeChangeEmail=all&amp;adTypeChangeCpc=all&amp;adType=all&amp;is_csv=0" style="display:none" class="keys"><span>216056,10001001</span></div>
</div>	<script src="/js/question-mark.js"></script>            </div>