<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Subdomen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subdomen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /* echo $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'city_id')->textInput() */?>

    <?= $form->field($model, 'alias')->textInput()  ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'name_dec')->textInput() ?>

    <?= $form->field($model, 'name_rod')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
