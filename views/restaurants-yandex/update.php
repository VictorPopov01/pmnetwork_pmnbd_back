<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'RestaurantsYandex', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pages-update">

	<h1>
		id ресторана: №<?php echo Html::encode($model->id) ?>
	</h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>