<?php
/* @var $this ExampleController */
/* @var $model Example */

$this->breadcrumbs=array(
	'Examples'=>array('index'),
	$model->country_id=>array('view','id'=>$model->country_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Example', 'url'=>array('index')),
	array('label'=>'Create Example', 'url'=>array('create')),
	array('label'=>'View Example', 'url'=>array('view', 'id'=>$model->country_id)),
	array('label'=>'Manage Example', 'url'=>array('admin')),
);
?>

<h1>Update Example <?php echo $model->country_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>