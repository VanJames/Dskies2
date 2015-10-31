<!-- csv 下载 -->
<script type="text/javascript">
function csvDownload(form_id){
    if(form_id){
        $('#is_csv').val(1);
        $('#'+form_id).submit();
        $('#is_csv').val(0);
        return;
    }
}
</script>

<?php
	//csv下载
	$request = Yii::app()->request;
	$isCsv = $request->getParam('is_csv', 0);
	if ($isCsv) {
		$fields = array(
			'shop_name' => 'shop_name',
			'shop_title' => 'shop_title',
			'item_name' => '类目',
			'sales_index_total' => '最近30天销售额',
		);
		$head = array_map('strip_tags', $fields);
		$body = array();
		if ($data) {
			foreach ($data as $value) {
				$row = array();
				$row['shop_name'] = $value['shop_name'];
				$row['shop_title'] = $value['shop_title'];
				$row['item_name'] = $value['item_name'];
				$row['sales_index_total'] = $value['sales_index_total'];

				$body[] = $row;
			}
		}
		CSV::download($fields, $body);
		Yii::app()->end();
	}
?>

<?= CHtml::beginForm(array(''), 'GET',array('id' => 'f1')) ?>
<?= CHtml::hiddenField('is_csv', 0, array('id' => 'is_csv')) ?>
<?= CHtml::endForm() ?>
<p class="text-right button-group">
	<button type="button" class="btn csv-dl-button" onclick="csvDownload('f1')"></button>
</p>


<!-- gridview -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        array(
			'name' => 'shop_name',
			'type' => 'raw',
			'value' => 'CHtml::link($data["shop_name"], Yii::app()->request->baseUrl."/admin/client/detail?clientId=".$data["client_id"])',
		),
		array(
			'name' => 'shop_title',
			'type' => 'raw',
			'value' => 'CHtml::link($data["shop_title"], Yii::app()->request->baseUrl."/admin/client/detail?clientId=".$data["client_id"])',
		),
        array(           
            'name'=>'类目',
            'value'=>'$data["item_name"]',
        ),
        array(
			'name'=>'最近30天销售额',
            'value'=>'$data["sales_index_total"]',
        ),
    ),
));

?>