<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Restaurants */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurants-find-form">

    <?php $this->beginBlock('main'); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= Select2::widget([
        'name' => 'gorko_id',
        'data' => $data,
        'options' => [
            'placeholder' => 'Выберите ресторан',
            'multiple' => false
        ],
    ]);?>

    <?php ActiveForm::end(); ?>
    <?php $this->endBlock() ?>

    <?php echo
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'content' => $this->blocks['main'],
                        'label'   => '<small>Ресторан<span class="badge badge-default"></span></small>',
                        'active'  => true,
                    ]
                ]
            ]
        );
    ?>

</div>