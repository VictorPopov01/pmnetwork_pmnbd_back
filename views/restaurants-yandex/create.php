<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'RestaurantsYandex', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">

	<h1>Страница</h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>