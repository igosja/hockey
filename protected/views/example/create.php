<?php
/* @var $this ExampleController */
/* @var $model Example */

$this->breadcrumbs=array(
	'Examples'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Example', 'url'=>array('index')),
	array('label'=>'Manage Example', 'url'=>array('admin')),
);
?>

<h1>Create Example</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>