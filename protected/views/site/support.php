<p>この度はNintをご利用頂き、誠にありがとうございます。</p>
<p style="margin-bottom:50px;">Nintへのお問い合せは、下記の項目をご入力後に内容を確認頂き、送信して下さい。</p>

<?php
$fields = array(
    'shop_name' => array(
        'isRequired' => TRUE,
        'component' => 'activeTextField',
        'needCheck' => TRUE,
    ),
    'company_name' => array(
        'isRequired' => FALSE,
        'component' => 'activeTextField',
        'needCheck' => FALSE,
    ),
    'department_name' => array(
        'isRequired' => FALSE,
        'component' => 'activeTextField',
        'needCheck' => FALSE,
    ),
    'name' => array(
        'isRequired' => TRUE,
        'component' => 'activeTextField',
        'needCheck' => TRUE,
    ),
    'email' => array(
        'isRequired' => TRUE,
        'component' => 'activeEmailField',
        'needCheck' => TRUE,
    ),
    'description' => array(
        'isRequired' => TRUE,
        'component' => 'activeTextArea',
        'needCheck' => TRUE,
    ),
);
?>

<?= CHtml::beginForm(Yii::app()->request->baseUrl . '/site/support', 'POST', array('class' => 'support-form form-inline', 'id' => 'support-form')); ?>
<p class="fz-14"><?= HtmlSnippet::makeRequiredSpan(); ?> <b>楽天に出店してない方、会社名が必須です。</b></p>
<table>
    <tbody>
    <?= HtmlSnippet::makeSupportTr($support, 'shop_name', $fields['shop_name']); ?>
    <tr>
        <td></td>
        <td><span class="error" id='username_check'> </span>

            <div class="shop-id-example">
                <例>　ショップURL:　<br/>
                    <span style="color:#4588ba">http://www.rakuten.co.jp/<i style="text-decoration: underline"
                                                                            class="red">koregashopiddesu</i>/index.htm</span><br/>
                    <i span class="red">koregashopiddesu</i></span> 　こちらがショップIDになります
            </div>
        </td>
    </tr>
    <?= HtmlSnippet::makeSupportTr($support, 'company_name', $fields['company_name']); ?>
    <?= HtmlSnippet::makeSupportTr($support, 'department_name', $fields['department_name']); ?>
    <?= HtmlSnippet::makeSupportTr($support, 'name', $fields['name']); ?>
    <?= HtmlSnippet::makeSupportTr($support, 'email', $fields['email']); ?>
    <tr>
        <td> ■　
            <?= CHtml::activeLabel($support, 'support_type') . HtmlSnippet::makeRequiredSpan(); ?>
        </td>
        <td>
            <?= CHtml::activeDropDownList($support, 'support_type', Support::getDropDownListArray('support'), array('class' => 'form-control')) ?>
            <span class="error ml-10" id='support_type_error'> </span>
        </td>
    </tr>
    <tr>
        <td> ■　
            <?= CHtml::activeLabel($support, 'description') . HtmlSnippet::makeRequiredSpan(); ?>
        </td>
        <td>
            <?= CHtml::activeTextArea($support, 'description', array('class' => 'form-control', 'rows' => 10)) . HtmlSnippet::makeErrorArea('description_error'); ?></td>
    </tr>
    </tbody>
</table>
<p class="text-center" style="margin-top:40px">
    <?= CHtml::submitButton(Yii::t('Site', 'Send'), array('class' => 'btn seo-tiny-up-button fz-14', 'style' => 'margin-left: 45px;')) ?>
</p>
<?= CHtml::endForm(); ?>

<p class="fz-15 red">※注意</p>
<p>■　お問い合せには、弊社サポート時間内に対応させていただきます。</p>
<p style="padding-left:2em;">営業時間：10:00～19:00 (土・日・祝日・年末年始・夏季休暇を除きます)</p>
<p>■　お問合せの内容によっては、お返事を差し上げるまでにお時間がかかることがあります。あらかじめご了承下さい。</p>
<p>■　お客様からいただいたメールアドレスが正しいものでない場合や、システム障害などによりお返事できない場合がございます。</p>
<p>■　Nintでよくあるご質問(FAQ)は、こちらでご確認下さい。　<a href="<?= Yii::app()->baseUrl; ?>/site/faq" class="more-link">FAQへ行く</a>
</p>
<p style="margin-bottom:30px;">■　パスワードを忘れた方は、こちらからご確認下さい。　<a href="<?= Yii::app()->baseUrl; ?>/site/findPassword"
                                                             class="more-link">パスワード確認へ行く</a></p>

<script src="<?= Yii::app()->baseUrl; ?>/js/site/support.js"></script>