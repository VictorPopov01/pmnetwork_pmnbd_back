<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php $this->beginBlock('Media');

    echo $this->render('/media_tab.php', ['model' => $model]);

    $this->endBlock() ?>

    <?php $this->beginBlock('Seo');

    echo $this->render('/seo_tab.php', ['model' => $model]);

    $this->endBlock() ?>

    <?php echo Tabs::widget(
        [
            'id' => 'relation-tabs',
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

</div>