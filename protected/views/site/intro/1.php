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
広告分析 ? <span>ショップ一覧</span></div>                        <div class="marketing clearfix" id="content">
                <!-- form -->
<form method="GET" action="/marketing/list" class="form-inline"><div class="form-set">
    <div class="clearfix">
        <div class="col-lg-4">
            <label for="shop-title">追跡中から検索</label>
            <div class="input-group">
                <input type="text" value="" placeholder="ショップ名を入力" name="shop-title" id="shop-title" class="form-control" autocomplete="off">
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
                <input type="hidden" value="既に&lt;span class='red'&gt;3&lt;/span&gt;店舗が登録されており、&lt;br/&gt;残り&lt;span class='red'&gt;147&lt;/span&gt;店舗を追加することができます。&lt;br/&gt;を広告分析に追加登録しますか？&lt;br/&gt;(追加後&lt;span class='red'&gt;30&lt;/span&gt;日間は一覧から削除できません。)" id="pop_msg">
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
</form><!-- table -->
<p class="text-right button-group">
    <span class="pull-left">追加済みショップ(3/150)</span>
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
                            <td><a href="http://www.rakuten.co.jp/netstar/" target="_blank">NETSTAR&#12288;ネットスター</a></td>
                            <td><span class="color-blue">3.07</span></td>
                            <td>95,874</td>
                            <td>888</td>
                            <td>27</td>
                            <td>76</td>
                            <td>0</td>
                            <td>0</td>
                            <td>3</td>
                            <td>31</td>
                            <td>0%</td>
                            <td>1,222</td>
                            <td>243</td>
                            <td>131</td>
                            <td>
                                                                    
                                    <a href="/marketing/topItemList/227116" title="商品一覧"><img alt="" src="/images/icon/op-item.png"></a>                                   
                                    <a href="/marketing/topItemList/227116" onclick="goToNext(event)" title="広告解析"><img id="intro-step-1" data-step="1" alt="" src="/images/icon/op-ad.png"></a>                                                                                            </td>
                            <td><input type="checkbox" name="myNoticeShop[]" title="" value="227116" class="chk-one">                            </td>
                        </tr>
                                                                    <tr class="odd">
                            <td><a href="http://www.rakuten.co.jp/shizennoyakata/" target="_blank">美味しさは元気の源 【自然の館】</a></td>
                            <td><span class="color-orange">6.69</span></td>
                            <td>87,678</td>
                            <td>257</td>
                            <td>36</td>
                            <td>222</td>
                            <td>0</td>
                            <td>2,003</td>
                            <td>11</td>
                            <td>67</td>
                            <td>0%</td>
                            <td>370</td>
                            <td>274</td>
                            <td>33</td>
                            <td>
                                                                    
                                    <a href="/marketing/topItemList/207342" title="商品一覧"><img alt="" src="/images/icon/op-item.png"></a>                                    <a href="/marketing/analysis/207342" title="広告解析"><img alt="" src="/images/icon/op-ad.png"></a>                                                                                            </td>
                            <td><input type="checkbox" name="myNoticeShop[]" title="" value="207342" class="chk-one">                            </td>
                        </tr>
                                                                    <tr class="even">
                            <td><a href="http://www.rakuten.co.jp/kaneni/" target="_blank">函館朝市&#12288;函館カネニ</a></td>
                            <td><span class="color-blue">3.21</span></td>
                            <td>1,128</td>
                            <td>107</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>166</td>
                            <td>0</td>
                            <td>178</td>
                            <td>0%</td>
                            <td>29</td>
                            <td>4</td>
                            <td>11</td>
                            <td>
                                                                    
                                    <a href="/marketing/topItemList/100042" title="商品一覧"><img alt="" src="/images/icon/op-item.png"></a>                                    <a href="/marketing/analysis/100042" title="広告解析"><img alt="" src="/images/icon/op-ad.png"></a>                                                                                            </td>
                            <td><input type="checkbox" name="myNoticeShop[]" title="" value="100042" class="chk-one">                            </td>
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
                                        <dd><div class="lbox"><a data-url="https://www.youtube.com/embed/oPpyz6FK25M?autoplay=1&amp;wmode=opaque" class="vidio-trigger red underline fz-14" href="#">初心者必見ビデオ</a></div></dd> 
                                    </dl>
                                                                                            <dl>
                                        <dt>画面説明</dt>
                                        <dd><a target="_blank" href="/site/guide?page=8&amp;intro_id=1" class="underline fz-14">画面詳細説明</a></dd> 
                                    </dl>
                            
                                                            
                        </li> 
                        <li class="col-lg-6">
                                                            <dl>
                                    <dt>利用ガイド</dt>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=1" class="underline fz-14">気になるショップを直接ショップ一覧に追加する</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=2" class="underline fz-14">ショップ一覧からショップを削除する</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=3" class="underline fz-14">最近売上がアップしているショップを見つけ出し、ショップ一覧に追加する</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=4" class="underline fz-14">売上アップに貢献している商品を見つけ出すには？</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=5" class="underline fz-14">アフィリエイト広告の高料率を調べる</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=6" class="underline fz-14">商品のCPC広告キーワードを調べる</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=7" class="underline fz-14">商品の広告ICONとPR内容を調べる</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=8" class="underline fz-14">ショップのメルマガを調べる</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=9" class="underline fz-14">優良ショップの全ての広告状況を調べる</a></dd>
                                                                        <dd><a target="_blank" href="/site/guide?page=4&amp;intro_id=10" class="underline fz-14">ある商品の全ての広告状況を調べる</a></dd>
                                                                    </dl>
                                                    </li> 
                    </ul>

                </div>
            </div>
                                
        </div>