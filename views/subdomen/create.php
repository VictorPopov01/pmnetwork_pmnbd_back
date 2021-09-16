<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Subdomen */

$this->title = 'Create Subdomen';
$this->params['breadcrumbs'][] = ['label' => 'Subdomens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdomen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
