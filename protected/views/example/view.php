<?php
/* @var $this ExampleController */
/* @var $model Example */

$this->breadcrumbs=array(
	'Examples'=>array('index'),
	$model->country_id,
);

$this->menu=array(
	array('label'=>'List Example', 'url'=>array('index')),
	array('label'=>'Create Example', 'url'=>array('create')),
	array('label'=>'Update Example', 'url'=>array('update', 'id'=>$model->country_id)),
	array('label'=>'Delete Example', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->country_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Example', 'url'=>array('admin')),
);
?>

<h1>View Example #<?php echo $model->country_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'country_id',
		'country_finance',
		'country_name',
		'country_president_id',
	),
)); ?>
