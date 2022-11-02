<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

	<h1>
		Рестораны (яндекс отзывы)
		<small>
			Список
		</small>
	</h1>

	<p>
		<!-- <?= Html::a('Create RestaurantYandex', ['create'], ['class' => 'btn btn-success']) ?> -->
	</p>

	<?php // echo $this->render('_search', ['model' => $searchModel]); 
	?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id:ntext',
			'gorko_id:ntext',
			'name:ntext',
			'address:ntext',
			'rev_ya_id:ntext',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>


</div>