<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subdomens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdomen-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Subdomen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'city_id',
            'alias:ntext',
            'name:ntext',
            //'name_dec:ntext',
            //'name_rod:ntext',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
