<?php
	use frontend\components\Declension;
	use frontend\modules\pmnbd\models\ElasticItems;
	use common\models\Subdomen;
	$model = ElasticItems::find()->query([
			'bool' => [
				'must' => [
					['match' => ['restaurant_gorko_id' => $text_id]],
					//['match' => ['restaurant_city_id' => \Yii::$app->params['subdomen_id']]],
				],
			]
		])->one();
	if (!$model) return '';
	$rooms = $model['rooms'];
	$rooms_price_arr = [];

	foreach ($rooms as $key => $value) {
		array_push($rooms_price_arr, $value['price']);
	}
	$min_price = ($filtered = array_filter($rooms_price_arr)) ? min($filtered) : 0;

	$subdomen = Subdomen::findOne(['city_id' => $model['restaurant_city_id']]);
	$alias = $subdomen->alias == 'msk' ? 'https://birthday-place.ru' : ('https://'.$subdomen->alias.'.birthday-place.ru');
?>
<div  class="post-block post-block-rest post-block_color_<?=$setting_color?> post-block_margin_<?=$setting_margin?>">
  <div class="wrapper wrapper_size_<?=$setting_size?>">
    <div class="post-block-rest-item">
    	<div class="item_image">
        	<img loading="lazy" class="item_present" src="/upload/img/bron.png" atl="Подарок за бронирование в ресторане «<?=$model['restaurant_name']?>»">
	        <a href="<?=$alias?>/catalog/restoran-<?=$model['restaurant_slug']?>/" data-target="rest_blog">
	            <div class="item_img">
	                <img loading="lazy" src="<?= $model['restaurant_images'] ? Declension::get_image_src($model['restaurant_images'][0]['subpath']) : '/upload/img/bd/no_photo.png'?>" alt="Ресторан <?=$model['restaurant_name']?>">
	            </div>
	        </a>
	    </div>
        <div class="item_info">
            <div class="item_info_top">
                <a href="<?=$alias?>/catalog/restoran-<?=$model['restaurant_slug']?>/" data-target="rest_blog" >
                    <p class="item_name"><?=$model['restaurant_name']?></p>
                </a>
                <p class="item_address"><?=$model['restaurant_address']?></p>
			</div> 
            <div class="item_meta">
                <div class="item_meta_items">
                    <div class="item_meta_item">
	                    <p class="item_meta_item_title">Вместимость:</p>
	                    <p class="item_meta_item_value"><?=$model['restaurant_min_capacity']?> - <?=$model['restaurant_max_capacity']?> человек<?=Declension::get_num_ending($model['restaurant_max_capacity'], ['','а',''])?></p>
	                </div>                     
                    <div class="item_meta_item">
                    	<p class="item_meta_item_title">Стоимость аренды без еды:</p>

	                    <p class="item_meta_item_value">от <?=number_format($min_price*$model['restaurant_min_capacity'], 0, '', ' ')?> ₽</p>
                    </div>
                </div>
                <div class="item_meta_items">
                    <div class="item_meta_item">
                    	<p class="item_meta_item_title">Свой алкоголь:</p>
	                    <p class="item_meta_item_value"><?=in_array($model['restaurant_alcohol'], [1,2]) ? 'да' : 'нет'?></p>
                    </div>
                    <div class="item_meta_item">
                    	<p class="item_meta_item_title">Парковка:</p>
	                    <p class="item_meta_item_value"><?=!empty($model['restaurant_parking']) ? ($model['restaurant_parking'].' мест'.Declension::get_num_ending($model['restaurant_parking'], ['о','а',''])) : 'нет'?></p>
                    </div>
                </div>   
            </div>             
            <button data-rest-name="<?=$model['restaurant_name']?>" data-rest-type="<?=$model['restaurant_main_type']?>" data-open-popup-form-blog="" data-target="bron_1" class="rent_button">Забронировать</p>      
        </div>
    </div>
  </div>
</div>