<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Restaurants */

$this->title = 'Найти ресторан';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-create">
	<?= $this->render('_form', [
        'data' => $data
    ]) ?>
</div>