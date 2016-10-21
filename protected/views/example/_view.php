<?php
/* @var $this ExampleController */
/* @var $data Example */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->country_id), array('view', 'id'=>$data->country_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_finance')); ?>:</b>
	<?php echo CHtml::encode($data->country_finance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_name')); ?>:</b>
	<?php echo CHtml::encode($data->country_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_president_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_president_id); ?>
	<br />


</div>