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
広告分析 &raquo; <span>ショップ一覧</span></div>                        <div id="content" class="marketing clearfix">
                <!-- form -->
<form class="form-inline" id="list_form" action="/marketing/list" method="GET"><div class="form-set">
    <div class="clearfix">
        <div class="col-lg-4">
            <label for="shop-title">追跡中から検索</label>
            <div class="input-group">
                <input type="text" autocomplete="off"
                       class="form-control" id="shop-title" name="shop-title"
                       placeholder="ショップ名を入力"
                       value="加藤時計店">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        検索                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-4">
            <label for="shop-url">ショップ追跡</label> 
            <div class="input-group">
                <input type="hidden"  id="enabled_type"   value="1"/>
                <input type="hidden"  id="pop_msg"   value="既に<span class='red'>8</span>店舗が登録されており、<br/>残り<span class='red'>142</span>店舗を追加することができます。<br/>を広告分析に追加登録しますか？<br/>(追加後<span class='red'>30</span>日間は一覧から削除できません。)"/>
                <input type="text"
                       class="form-control" id="shop-url"
                       placeholder="ショップURLを入力">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" id="add-notice">
                        追加                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <a class="btn explosive-button" href="/marketing/search"></a>            </div>
        </div>
    </div>
</div>
<input id="is_csv" type="hidden" value="0" name="is_csv" /></form><!-- table -->
<p class="text-right button-group">
    <span class="pull-left">追加済みショップ(8/150)</span>
        <button type="button" class="btn csv-dl-button" onclick="csvDownload('list_form')"></button>
    <input class="btn del-button" id="del-notice" name="yt0" type="button" value="" /></p>

<div id="chk-box">
    <div id="marketing-shop-list" class="grid-view" >
        <table class="items">
            <thead>
                <tr>
                    <th rowspan="2">ショップ名<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th rowspan="2">上昇指数<span class="question-mark"  data-pop="上昇指数は、前月の1日から楽天の最新更新日までの期間に、売上指数が急激に上がった日の数値が確認できます。"></span></th>
                    <th rowspan="2">最近30日<br/>売上指数<br/>（千円）</th>
                    <th rowspan="2">商品数<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th colspan="2">WEB広告<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th colspan='2'>サーチ広告<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th colspan="2">メール広告<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th>アフィ広告<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th rowspan="2">商品名<br/>変更数<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th rowspan="2">価格<br/>変更数<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th rowspan="2">ポイント<br/>変更数<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th rowspan="2" class='w-90'>操作<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th rowspan="2" class='w-90'><input type="checkbox" value="1" name="chk-all" id="chk-all" /> <label for="chk-all">選択</label></th>
                </tr>
                <tr>
                    <th>ショップ<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th>
                    <th>商品<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th></th>
                    <th>ショップ<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th></th>
                    <th>商品<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th></th>
                    <th>ショップ<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th></th>
                    <th>商品<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th></th>
                    <th>ショップ<br/>広告<span class="question-mark" style="display:none;" data-pop=""></span></th></th>
                </tr>
            </thead>
            <tbody>
                                                                                    <tr id="intro-step-1" data-step="1" class="even">
                            <td><a target="_blank" href="http://www.rakuten.co.jp/tokeiten/">加藤時計店　Gショック楽天市場店</a></td>
                            <td>1.95</td>
                            <td>38,434</td>
                            <td>1,228</td>
                            <td>19</td>
                            <td>22</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0%</td>
                            <td>266</td>
                            <td>250</td>
                            <td>1,730</td>
                            <td >
                                                                    <a title="商品一覧" href="/marketing/topItemList/195761"><img src="/images/icon/op-item.png" alt="" /></a>                                    <a title="広告解析" href="/marketing/analysis/195761"><img src="/images/icon/op-ad.png" alt="" /></a>                                                                                            </td>
                            <td><input class="chk-one" value="195761" title="" type="checkbox" name="myNoticeShop[]" />                            </td>
                        </tr>
                                                </tbody>
        </table>
                    <div class="pager">
                            </div>
            </div>
</div>
<script src="/js/marketing/list.js"></script>
<script src="/js/question-mark.js"></script>            </div>
            
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
                                        <dd><a class="underline fz-14" href="/site/guide?page=8&intro_id=1" target="_blank">画面詳細説明</a></dd> 
                                    </dl>
                            
                                                            
                        </li> 
                        <li class="col-lg-6">
                                                            <dl>
                                    <dt>利用ガイド</dt>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=1" target="_blank">気になるショップを直接ショップ一覧に追加する</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=2" target="_blank">ショップ一覧からショップを削除する</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=3" target="_blank">最近売上がアップしているショップを見つけ出し、ショップ一覧に追加する</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=4" target="_blank">売上アップに貢献している商品を見つけ出すには？</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=5" target="_blank">アフィリエイト広告の高料率を調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=6" target="_blank">商品のCPC広告キーワードを調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=7" target="_blank">商品の広告ICONとPR内容を調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=8" target="_blank">ショップのメルマガを調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=9" target="_blank">優良ショップの全ての広告状況を調べる</a></dd>
                                                                        <dd><a class="underline fz-14" href="/site/guide?page=4&intro_id=10" target="_blank">ある商品の全ての広告状況を調べる</a></dd>
                                                                    </dl>
                                                    </li> 
                    </ul>

                </div>
            </div>
                                
        </div>