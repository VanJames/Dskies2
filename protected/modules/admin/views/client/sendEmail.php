<a href="mailto:<?php echo $info['email']; ?>?subject=【楽天データ分析ツール】ご案内">发邮件</a>
<a href="<?php echo CHtml::normalizeUrl(array('client/getEmail', 'clientId' => $info['id'])) ?>" target="_blank">邮件内容</a>
<br/>
<a href="mailto:<?php echo $info['email']; ?>?subject=<?= Yii::t('Mail', 'payRemind2')?>">催付邮件</a>
<a href="<?php echo CHtml::normalizeUrl(array('client/getEmail', 'clientId' => $info['id'], 'type' => 2)) ?>" target="_blank">催付邮件内容</a>