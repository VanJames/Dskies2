<!-- table -->
<div class="grid-view">
    <table class="items">
    	<thead>
    		<tr>
    					<?php $tips_num = 132; ?>
                        <?php foreach ($table_head as $v) :?>
                        <th><?php echo $v; ?><?php echo '<span class="question-mark"'.($tips[$tips_num]==''?'style="display:none;"':'').' data-pop="' . $tips[$tips_num] . '"></span>' ?></th>
    					<?php $tips_num += 1; ?>
                        <?php endforeach;?>
    		</tr>
    	</thead>
    	<tbody>
    	    <?php if ($data): ?>
    	    <?php foreach ($data as $date => $value): ?>
    	    <?php
    	    $className = ($key++%2==0) ? 'odd' : 'even';
    	    ?>
    		<tr class="<?php echo $className; ?>">
    			<td><?php echo $date; ?></td>
                        <td><?php echo Util::myNumberFormat($value); ?></td>
    		</tr>
    		<?php endforeach; ?>
    		<?php else: ?>
    		<tr><td colspan="<?php echo count($table_head);?>"><?php echo Util::t('No Data'); ?></td></tr>
    		<?php endif; ?>
    	</tbody>
    </table>
</div>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/question-mark.js"></script>