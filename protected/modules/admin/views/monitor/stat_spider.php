<div class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th>ID</th>
            <th>项目</th>
            <th>优先级</th>
            <?php for ($i = 0; $i < 7; $i++): ?>
            <th><?php echo date('Y-m-d', strtotime("-$i days")); ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody id="task_info">
    <?php foreach ($data as $key => $value): ?>
        <?php $className = ($key % 2 == 0) ? 'odd' : 'even'; ?>
        <?php $hasHidden = false; ?>
        <tr class="<?php echo $className; ?>" <?php if (empty($value['sent0'])): ?><?php $hasHidden = true; ?>hidden="hidden"<?php endif; ?>>
        <td style="text-align: center"><?php echo $value['id']; ?></td>
        <td><?php echo CHtml::encode($value['full_name']); ?></td>
        <td style="text-align: right"><?php echo $value['priority']; ?></td>
        <?php for ($i = 0; $i < 7; $i++): ?>
        <td style="text-align: right"><span style="color: #ff8040"><?php echo $value["check$i"] ?></span><br /><?php echo $value["sent$i"] ?></th>
        <?php endfor; ?>
        </tr>
    <?php endforeach; ?>
        <tr style="color: white; background-color: #3E3E3E">
            <td colspan="3" style="text-align: left">总计</td>
            <?php for ($i = 0; $i < 7; $i++): ?>
            <td style="text-align: right"><span style="color: #ff8040"><?php echo $sum["check$i"] ?></span><br /><?php echo $sum["sent$i"] ?></th>
            <?php endfor; ?>
        </tr>
    </tbody>
</table>
</div>
<?php if ($hasHidden): ?>
<script type="text/javascript">
    function show_task_row() {
       $("#task_info tr").show();
       $("#task_info tr:first").remove()
    }

    $(document).ready(function() {
        $('#task_info').prepend('<tr><td colspan="10"><span class="btn btn-primary" onclick="show_task_row()">显示所有</span></td></tr>')
    });
</script>
<?php endif; ?>
