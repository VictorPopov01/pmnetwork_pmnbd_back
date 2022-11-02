<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">


	<?php $this->beginBlock('Main');

	$form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'gorko_id')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'name')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'address')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'rev_ya_id')->textInput() ?>
	<?= $form->field($model, 'rev_ya_rate')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'rev_ya_count')->textInput(['disabled' => true]) ?>

	<br />


	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end();

	$this->endBlock(); ?>


	
	<?php echo
	Tabs::widget(
		[
			'encodeLabels' => false,
			'items' => [
				[
					'content' => $this->blocks['Main'],
					'label'   => '<small>Pages<span class="badge badge-default"></span></small>',
					'active'  => true,
				],
			]
		]
	);
	?>

</div>