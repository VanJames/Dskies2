<!-- table -->
<div class="grid-view">
    <table class="items">
    	<thead>
    		<tr>
    			<th><?php echo Util::t('Time'). '<span class="question-mark" '.($tips[62]==''?'style="display:none;"':'').' data-pop="' . $tips[62] . '"></span>'; ?></th>
                        <th>総合ランキング <?php echo '<span class="question-mark" '.($tips[63]==''?'style="display:none;"':'').' data-pop="' . $tips[63] . '"></span>'; ?></th>
    					<?php $tips_num = 64; ?>
                        <?php foreach ($cids_name as $value) : ?>
                            <th><?php echo $value.'ランキング'. '<span class="question-mark" data-pop="' . $tips[$tips_num] . '"></span>'; ?></th>
    						<?php $tips_num = $tips_num + 1;?>
                        <?php endforeach;?>

    		</tr>
    	</thead>
    	<tbody>
    	    <?php if ($data_info): ?>
    	    <?php foreach ($data_info as $date => $value): ?>
    	    <?php
    	    $className = ($key++%2==0) ? 'odd' : 'even';
    	    ?>
    		<tr class="<?php echo $className; ?>">
    			<td><?php echo $date; ?></td>
                        <?php foreach ($value as $rank) :?>
                        <td><?php echo Util::zeroIsLine($rank); ?></td>
                        <?php endforeach;?>
    		</tr>
    		<?php endforeach; ?>
    		<?php else: ?>
    		<tr><td colspan="<?php echo count($cids_name)+2;?>"><?php echo Util::t('No Data'); ?></td></tr>
    		<?php endif; ?>
    	</tbody>
    </table>
</div>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/question-mark.js"></script>