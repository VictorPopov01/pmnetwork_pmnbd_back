<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = 'SEO для страницы: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pages-update">

	<h1><?= Html::encode($this->title) ?></h1>
	<p>**city_dec** | Москве</p>
	<p>**city_rod** | Москвы</p>
	<p>**city** | Москва</p>
	<p>**dec=шат** | шатров | шат,зал,площад,отел,лофт,баз,саун,бан,бар,веранд,террас,коттедж,ресторан</p>
	<p>**count_dec=шат** | 2 шатра</p>
	<?php if (in_array($model->id, [8, 52])) : ?>
		**count**
		**year**
		**room_name**
		**price**
		**rest_type**
		**rest_address**
		**capacity**
		**min_capacity**
		**max_capacity**
		**rest_name**
	<?php endif; ?>
	<div class="subdomen_list">
		<?php foreach ($subdomen_pages as $subdomen_page) : ?>
			<a class="update_subdomen_page" href="/subdomen-pages/update/?id=<?= $subdomen_page->id ?>"><?= $subdomen_page->subdomen->name ?></a>
		<?php endforeach; ?>
		<div class="create_subdomen_page btn btn-success" data-page-id="<?= $model->id ?>">Создать SEO для поддомена</div>
		<div class="page_subdomen_list" id="page_subdomen_list">
			<?php foreach ($subdomens as $subdomen) : ?>
				<a href="/subdomen-pages/create/?page_id=<?= $model->id ?>&subdomen_id=<?= $subdomen->id ?>"><?= $subdomen->name ?></a>
			<?php endforeach; ?>
		</div>
	</div>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>