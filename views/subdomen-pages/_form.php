<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubdomenPages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subdomen-pages-form">

    <?php $this->beginBlock('Seo');

    echo $this->render('/seo_tab_form.php', ['model' => $model, 'premadeSeoObject' => true]);

    $this->endBlock() ?>
    <?php $this->beginBlock('Media');

    echo $this->render('/media_tab_form.php', ['model' => $model]);

    $this->endBlock() ?>
    <?php echo
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'content' => $this->blocks['Seo'],
                        'label'   => '<small>SEO<span class="badge badge-default"></span></small>',
                        'active'  => true,
                    ],
                    [
                        'content' => $this->blocks['Media'],
                        'label'   => '<small>Файлы <span class="badge badge-default">' . $model->getMediaTargets()->count() . '</span></small>',
                        'active'  => false,
                    ],
                    
                ]
            ]
        );
    ?>
    <br>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить?',
                'method' => 'post',
            ],
    ]) ?>

</div>