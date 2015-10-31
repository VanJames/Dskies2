<div class="breadcrumbs">
広告分析 » <span>ショップ一覧</span></div>
<div class="marketing clearfix" id="content">
                <!-- form -->
<form method="GET" action="/marketing/list" id="list_form" class="form-inline"><div class="form-set">
    <div class="clearfix">
        <div class="col-lg-4">
            <label for="shop-title">追跡中から検索</label>
            <div class="input-group">
                <input type="text" value="flags tsubo shop" placeholder="ショップ名を入力" name="shop-title" id="shop-title" class="form-control" autocomplete="off">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        検索                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-4">
            <label for="shop-url">ショップ追跡</label> 
            <div class="input-group">
                <input type="hidden" value="1" id="enabled_type">
                <input type="hidden" value="既に&lt;span class='red'&gt;11&lt;/span&gt;店舗が登録されており、&lt;br/&gt;残り&lt;span class='red'&gt;139&lt;/span&gt;店舗を追加することができます。&lt;br/&gt;を広告分析に追加登録しますか？&lt;br/&gt;(追加後&lt;span class='red'&gt;30&lt;/span&gt;日間は一覧から削除できません。)" id="pop_msg">
                <input type="text" placeholder="ショップURLを入力" id="shop-url" class="form-control">
                <span class="input-group-btn">
                    <button id="add-notice" class="btn btn-primary" type="button">
                        追加                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <a href="/marketing/search" class="btn explosive-button"></a>            </div>
        </div>
    </div>
</div>
<input type="hidden" name="is_csv" value="0" id="is_csv"></form><!-- table -->
<p class="text-right button-group">
    <span class="pull-left">追加済みショップ(11/150)</span>
        <button onclick="csvDownload('list_form')" class="btn csv-dl-button" type="button"></button>
    <input type="button" value="" name="yt0" id="del-notice" class="btn del-button"></p>

<div id="chk-box">
    <div class="grid-view" id="marketing-shop-list">
        <table class="items">
            <thead>
                <tr>
                    <th rowspan="2">ショップ名<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th rowspan="2">上昇指数<span data-pop="上昇指数は、前月の1日から楽天の最新更新日までの期間に、売上指数が急激に上がった日の数値が確認できます。" class="question-mark"></span></th>
                    <th rowspan="2">最近30日<br>売上指数<br>（千円）</th>
                    <th rowspan="2">商品数<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th colspan="2">WEB広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th colspan="2">サーチ広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th colspan="2">メール広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>アフィ広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th rowspan="2">商品名<br>変更数<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th rowspan="2">価格<br>変更数<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th rowspan="2">ポイント<br>変更数<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th class="w-90" rowspan="2">操作<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th class="w-90" rowspan="2"><input type="checkbox" id="chk-all" name="chk-all" value="1"> <label for="chk-all">選択</label></th>
                </tr>
                <tr>
                    <th>ショップ<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>商品<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>ショップ<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>商品<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>ショップ<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>商品<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                    <th>ショップ<br>広告<span data-pop="" style="display:none;" class="question-mark"></span></th>
                </tr>
            </thead>
            <tbody>
                                                                                    <tr class="even">
                            <td><a href="http://www.rakuten.co.jp/flags/" target="_blank">flags tsubo shop</a></td>
                            <td><span class="color-blue">2.78</span></td>
                            <td>15,350</td>
                            <td>66</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>2</td>
                            <td>0%</td>
                            <td>59</td>
                            <td>13</td>
                            <td>0</td>
                            <td>
                                                                    <a onclick="goToNext(event)" href="/marketing/topItemList/216056" title="商品一覧"><img id="intro-step-2" data-step="2" alt="" src="/images/icon/op-item.png"></a>                                    <a href="/marketing/analysis/216056" title="広告解析"><img alt="" src="/images/icon/op-ad.png"></a>                                                                                            </td>
                            <td><input type="checkbox" name="myNoticeShop[]" title="" value="216056" class="chk-one">                            </td>
                        </tr>
                                                </tbody>
        </table>
                    <div class="pager">
                            </div>
            </div>
</div>
<script src="/js/marketing/list.js"></script>
<script src="/js/question-mark.js"></script>            </div>