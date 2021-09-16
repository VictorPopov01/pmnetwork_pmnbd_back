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

<div class="restaurants-form">

    <?php $this->beginBlock('main'); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php if(!isset($create)):?>

        <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
        <?= $form->field($model, 'name')->textInput(['disabled' => true]) ?>
        <?= $form->field($model, 'address')->textInput(['disabled' => true]) ?>

    <?php else:?>

        <?= $form->field($model, 'id')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Выберите ресторан'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Ресторан');
        ?>

    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php $this->endBlock() ?>


    <?php $this->beginBlock('Seo');

    echo $this->render('/seo_tab_form.php', ['model' => $model]);

    $this->endBlock() ?>

    <?php echo
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'content' => $this->blocks['main'],
                        'label'   => '<small>Ресторан<span class="badge badge-default"></span></small>',
                        'active'  => true,
                    ],
                    [
                        'content' => $this->blocks['Seo'],
                        'label'   => '<small>SEO<span class="badge badge-default"></span></small>',
                        'active'  => false,
                    ],
                    /* [
                        'content' => $this->blocks['Media'],
                        'label'   => '<small>Файлы <span class="badge badge-default">' . $model->getMediaTargets()->count() . '</span></small>',
                        'active'  => false,
                    ], */

                ]
            ]
        );
    ?>

</div>