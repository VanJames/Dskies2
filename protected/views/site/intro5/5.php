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
広告分析 &raquo; <a href="/marketing/list">ショップ一覧</a> &raquo; <a href="/marketing/list/253792">アトリエ365</a> &raquo; <span>商品一覧</span></div>                        <div id="content" class="marketing clearfix">
                <div class="submenu">
                    <a class="ml-5" href="/marketing/topItemList/253792"><span class="head"></span><span class="body">商品一覧</span><span class="foot"></span></a>                    <a class="ml-5" href="/marketing/analysis/253792"><span class="head"></span><span class="body">広告解析</span><span class="foot"></span></a>    
</div>   <!-- form -->
<form class="form-inline" id="topItemList_form" action="/marketing/topItemList/253792" method="get"><div class="form-set">
    <div class="row">
        <div class="form-group">
            <label for="RSearcherForm_cid">ジャンル</label>            <select class="item-category-list form-control" data-level="1" data-parent="0" name="" id="">
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
 <input id="item-category-cid" name="RSearcherForm[cid]" type="hidden" value="" /><script src="/js/marketing/search.js"></script>    <div class="row">
        <label for="item-title">商品名　</label> <input type="text" class="form-control" id="item-title" name="item-title" value="【6時間限定】スマートモデル半袖形態安定Yシャツ全18色【SNC】【ワイシャツ】/sun-ms-set-1066-ts【楽ギフ_包装】【RCP】【カッターシャツ】">
    </div>
    <div class="row">
	<label for="type">広告種類</label>
	<select class="form-control" name="adTypeChange" id="adTypeChange">
<option value="all" selected="selected">制限がない</option>
<option value="web">WEB広告</option>
<option value="email">メール広告</option>
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
<input type="hidden" name="adType" id="adType" value='all'/>
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
        <button type="submit" class="btn btn-primary">検索</button>
    </div>
</div>
<input id="is_csv" type="hidden" value="0" name="is_csv" /> 
</form><!-- table -->
<p class="text-right button-group">
    <button type="button" class="btn csv-dl-button" onclick="csvDownload('topItemList_form')"></button>
</p>
<div id="item-list" class="grid-view">
<div class="summary">1件の結果を1から1まで表示します。</div>
<table class="items">
<thead>
<tr>
<th colspan="2">商品名<span class="question-mark" style="display:none;" data-pop=""></span></th><th>ジャンル<span class="question-mark" style="display:none;" data-pop=""></span></th><th><a href="/marketing/topItemList/253792?sort=price&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">価格</a><span class="question-mark" style="display:none;" data-pop=""></span></th><th><a href="/marketing/topItemList/253792?sort=point&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">ポイ<br/>ント</a><span class="question-mark" style="display:none;" data-pop=""></span></th><th><a href="/marketing/topItemList/253792?sort=last_7&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">最近7日<br/>売上指数<br/>（千円）</a><span class="question-mark"  data-pop="楽天ランキングの更新日から過去7日間のランキング順位、レビュー数、価格、トレンドなどを元に算出した指数です。"></span></th><th><a href="/marketing/topItemList/253792?sort=last_14&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">最近14日<br/>売上指数<br/>（千円）</a><span class="question-mark"  data-pop="楽天ランキングの更新日から過去14日間のランキング順位、レビュー数、価格、トレンドなどを元に算出した指数です。"></span></th><th><a class="glyphicon glyphicon-arrow-down" href="/marketing/topItemList/253792?sort=last_30&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">最近30日<br/>売上指数<br/>（千円）</a><span class="question-mark"  data-pop="楽天ランキングの更新日から過去30日間のランキング順位、レビュー数、価格、トレンドなどを元に算出した指数です。"></span></th><th><a href="/marketing/topItemList/253792?sort=review_num&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">レビュ<br/>ー数</a><span class="question-mark" style="display:none;" data-pop=""></span></th><th><a href="/marketing/topItemList/253792?sort=review_rate&amp;sortBy=asc&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91">商品<br/>評価</a><span class="question-mark" style="display:none;" data-pop=""></span></th><th>商品広告<span class="question-mark" style="display:none;" data-pop=""></span></th><th>操作<span class="question-mark" style="display:none;" data-pop=""></span></th></tr>
</thead>
<tbody>
<tr id="intro-step-5" data-step="5" class="odd">
<td class="text-left"><img src="http://thumbnail.image.rakuten.co.jp/@0_mall/shirtshouse/cabinet/syouhin4/sun-ms-set-1066-700.jpg?_ex=60x60" alt="" /></td><td class="text-left" width="380px"><a target="_blank" href="http://item.rakuten.co.jp/shirtshouse/sun-ms-set-1066-ts">【6時間限定】スマートモデル半袖形態安定Yシャツ 全18色【SNC】【ワイシャツ】/sun-ms-set-1066-ts【楽ギフ_包装】【RCP】【カッターシャツ】</a></td><td class="text-left"><a href="/marketing/topItemList/253792?lv1cid=551177&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91&amp;page=1">メンズファッション</a> <span style="color:#FF8000">»</span> <a href="/marketing/topItemList/253792?lv2cid=100372&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91&amp;page=1">スーツ</a> <span style="color:#FF8000">»</span> <a href="/marketing/topItemList/253792?lv3cid=206363&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91&amp;page=1">ワイシャツ</a></td><td>700</td><td>1倍</td><td>--</td><td>--</td><td>--</td><td>62</td><td>4.23</td><td class="text-left" width="160px"></td><td width="100px"><a title="広告解析" href="/marketing/analysisItemDetailFromTopItemList/253792?itemCode=sun-ms-set-1066-ts"><img src="/images/icon/op-ad.png" alt="marketing" /></a> <a title="商品追跡" href="/marketing/trackFromTopItemList/253792?itemCode=sun-ms-set-1066-ts"><img src="/images/icon/op-track.png" alt="track" /></a></td></tr>
</tbody>
</table>
<div class="keys" style="display:none" title="/marketing/topItemList/253792?RSearcherForm%5Bcid%5D=&amp;item-title=%E3%80%906%E6%99%82%E9%96%93%E9%99%90%E5%AE%9A%E3%80%91%E3%82%B9%E3%83%9E%E3%83%BC%E3%83%88%E3%83%A2%E3%83%87%E3%83%AB%E5%8D%8A%E8%A2%96%E5%BD%A2%E6%85%8B%E5%AE%89%E5%AE%9AY%E3%82%B7%E3%83%A3%E3%83%84%E5%85%A818%E8%89%B2%E3%80%90SNC%E3%80%91%E3%80%90%E3%83%AF%E3%82%A4%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91%2Fsun-ms-set-1066-ts%E3%80%90%E6%A5%BD%E3%82%AE%E3%83%95_%E5%8C%85%E8%A3%85%E3%80%91%E3%80%90RCP%E3%80%91%E3%80%90%E3%82%AB%E3%83%83%E3%82%BF%E3%83%BC%E3%82%B7%E3%83%A3%E3%83%84%E3%80%91&amp;adTypeChange=all&amp;adTypeChangeWeb=all&amp;adTypeChangeEmail=all&amp;adTypeChangeCpc=all&amp;adType=all&amp;is_csv=0"><span>253792,sun-ms-set-1066-ts</span></div>
</div>	<script src="/js/question-mark.js"></script>            </div>
            
                                    <div class="section inner-helper">
                <div class="section-head-type2"><span style="margin-left: 15px;">Nintをもっと詳しく知るために</span></div>
                <div class="section-body-type3 ">
                    <ul class="clearfix">
                        <li class="col-lg-6 border-right"> 
                                                                <dl>
                                        <dt>基本操作</dt>
                                        <dd><div class="lbox"><a href="#" class='vidio-trigger red underline fz-14' data-url='https://www.youtube.com/embed/oPpyz6FK25M?autoplay=1&wmode=opaque'>初心者必見ビデオ</a></div></dd> 
                                    </dl>
                                                                                            <dl>
                                        <dt>画面説明</dt>
                                        <dd><a class="underline fz-14" href="/site/guide?page=8&intro_id=18" target="_blank">画面詳細説明</a></dd> 
                                    </dl>
                            
                                                            
                        </li> 
                        <li class="col-lg-6">
                                                            <dl>
                                    <dt>利用ガイド</dt>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=7" target="_blank">商品の広告ICONとPR内容を調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=8" target="_blank">ショップのメルマガを調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=10" target="_blank">ある商品の全ての広告状況を調べる</a></dd>
                                                                    </dl>
                                                    </li> 
                    </ul>

                </div>
            </div>
                                
        </div>