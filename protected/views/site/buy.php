<div class="user-buy">
    <div class="tiny-box">
        <div class="head">製品購入フォーム</div>
        <div class="body fz-13">
            <?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/site/buy', 'POST', array('class' => 'buy-form form-inline')); ?>
            <div class="clearfix">
                <?php
                echo CHtml::activeRadioButtonList($buy, 'package', Buy::getPackages(), array(
                    'class' => 'form-control', 'template' => '<span class="col-lg-3 text-center">{input}{label}</span>', 'separator' => ''));
                ?>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td style="vertical-align: top;"><?php echo CHtml::activeLabel($buy, 'category_num') ?>
                            <div class="fz-12">(<span id="category-show" class="category-show">クリックでジャンル表示</span>)</div></td>
                        <td>
                            <div  class="form-control category-select" style="width:90%;">
                                <ul>
                                    <?php if ($child_categorys): ?>
                                        <?php foreach ($child_categorys as $child_category): ?>
                                            <li>
                                                <?php echo CHtml::checkBox("category_num[]", in_array($child_category->cid, $selectedCids), array("class" => "chk-one", "id" => 'category-' . $child_category->cid, "value" => $child_category->cid))
                                                ?>
                                                <label for="category-<?php echo $child_category->cid; ?>">
                                                    <?php echo CHtml::encode($child_category->name); ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                        <td style="width: 130px;vertical-align: top;">
                            <span class="text-like-button" id="category_fee">
                                <?php echo ($buy->category_fee) ? $buy->category_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'category_fee', array('id' => 'category_fee_hidden')) ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo CHtml::activeLabel($buy, 'shop_num') ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($buy, 'shop_num', Buy::getDropDownListArray('shop'), array('class' => 'form-control', 'style' => 'width:90%')) ?>
                        </td>
                        <td style="width: 130px;">
                            <span class="text-like-button" id="shop_fee">
                                <?php echo ($buy->shop_fee) ? $buy->shop_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'shop_fee', array('id' => 'shop_fee_hidden')) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($buy, 'item_num') ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($buy, 'item_num', Buy::getDropDownListArray('item'), array('class' => 'form-control', 'style' => 'width:90%')) ?>
                        </td>
                        <td style="width: 130px;">
                            <span class="text-like-button" id="item_fee">
                                <?php echo ($buy->item_fee) ? $buy->item_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'item_fee', array('id' => 'item_fee_hidden')) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($buy, 'marketing_num') ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($buy, 'marketing_num', Buy::getDropDownListArray('marketing'), array('class' => 'form-control', 'style' => 'width:90%')) ?>
                        </td>
                        <td style="width: 130px;">
                            <span class="text-like-button" id="marketing_fee">
                                <?php echo ($buy->marketing_fee) ? $buy->marketing_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'marketing_fee', array('id' => 'marketing_fee_hidden')) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($buy, 'search_num') ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($buy, 'search_num', Buy::getDropDownListArray('search'), array('class' => 'form-control', 'style' => 'width:90%')) ?>
                        </td>
                        <td style="width: 130px;">
                            <span class="text-like-button" id="search_fee">
                                <?php echo ($buy->search_fee) ? $buy->search_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'search_fee', array('id' => 'search_fee_hidden')) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($buy, 'seo_num') ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($buy, 'seo_num', Buy::getDropDownListArray('seo'), array('class' => 'form-control', 'style' => 'width:90%')) ?>
                        </td>
                        <td style="width: 130px;">
                            <span class="text-like-button" id="seo_fee">
                                <?php echo ($buy->seo_fee) ? $buy->seo_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'seo_fee', array('id' => 'seo_fee_hidden')) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($buy, 'month_num') ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($buy, 'month_num', Buy::getDropDownListArray('month'), array('class' => 'form-control', 'style' => 'width:90%')) ?>
                            <?php echo CHtml::activeHiddenField($buy, 'month_num', array('id' => 'multi_type_hidden')) ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo CHtml::activeLabel($buy, 'total_fee') ?></td>
                        <td style="width: 130px;">
                            <span class="text-like-button" id="total_fee">
                                <?php echo ($buy->total_fee) ? $buy->total_fee : 0; ?>
                            </span>
                            <?php echo CHtml::activeHiddenField($buy, 'total_fee', array('id' => 'total_fee_hidden')) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="text-center" style="margin-top:40px">
                <?php echo CHtml::resetButton(Yii::t('Site', 'Delete'), array('class' => 'btn seo-tiny-up-button fz-14')) ?>
                <?php echo CHtml::submitButton(Yii::t('Site', 'Save'), array('class' => 'btn seo-tiny-down-button fz-14', 'style' => 'margin-left: 45px;')) ?>
            </p>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo Yii::app()->baseUrl; ?>/js/site/buy.js"></script>