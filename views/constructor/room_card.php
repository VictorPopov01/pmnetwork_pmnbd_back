<?php
	use frontend\components\Declension;
	use frontend\modules\pmnbd\models\ElasticItems;
	use common\models\Subdomen;
	
	$rest = ElasticItems::find()->query([
			'nested' => ['path' => 'rooms','query' => ['bool' => ['must' => ['match' => ['rooms.gorko_id' => $text_id]]]]]
		])->one();
	if (!$rest) die();
	foreach ($rest['rooms'] as $rest_room) {
		if ($rest_room['gorko_id'] == $text_id) {
			$model = $rest_room;
			break;
		}
	}

	$subdomen = Subdomen::findOne(['city_id' => $rest['restaurant_city_id']]);
	$alias = $subdomen->alias == 'msk' ? 'https://birthday-place.ru' : ('https://'.$subdomen->alias.'.birthday-place.ru');
?>
<div  class="post-block post-block-room post-block_color_<?=$setting_color?> post-block_margin_<?=$setting_margin?>">
  <div class="wrapper wrapper_size_<?=$setting_size?>">
    <div class="post-block-rest-item">
    	<div class="item_image">
        	<img loading="lazy" class="item_present" src="/upload/img/bron.png" atl="Подарок за бронирование в зала «<?=$model['name']?>» в ресторане «<?=$rest['restaurant_name']?>»">
	        <a href="<?=$alias?>/catalog/restoran-<?=$model['restaurant_slug']?>/<?=$model['slug']?>/">
	            <div class="item_img">
	                <img loading="lazy" src="<?=Declension::get_image_src($model['images'][0]['subpath'])?>" alt="Зал «<?=$model['name']?>» в ресторане «<?=$rest['restaurant_name']?>»">
	            </div>
	        </a>
	    </div>
        <div class="item_info">
            <div class="item_info_top">
            	<p class="item_rest_name"><?=$rest['restaurant_main_type']?> <?=$rest['restaurant_name']?></p>
                <a href="<?=$alias?>/catalog/restoran-<?=$model['restaurant_slug']?>/<?=$model['slug']?>/">
                    <p class="item_name"><?=$model['name']?></p>
                </a>
                <p class="item_address"><?=$rest['restaurant_address']?></p>
			</div> 
            <div class="item_meta">
                <div class="item_meta_items">
                    <div class="item_meta_item">
	                    <p class="item_meta_item_title">Вместимость:</p>
	                    <p class="item_meta_item_value"><?=$model['capacity']?> человек<?=Declension::get_num_ending($model['capacity'], ['','а',''])?></p>
	                </div>                     
                    <div class="item_meta_item">
                    	<p class="item_meta_item_title">Стоимость аренды без еды:</p>
	                    <p class="item_meta_item_value"><?=number_format($model['price']*$model['capacity'], 0, '', ' ')?> ₽</p>
                    </div>
                </div>
                <div class="item_meta_items">
                    <div class="item_meta_item">
                    	<p class="item_meta_item_title">Свой алкоголь:</p>
	                    <p class="item_meta_item_value"><?=in_array($rest['restaurant_alcohol'], [1,2]) ? 'да' : 'нет'?></p>
                    </div>
                    <div class="item_meta_item">
                    	<p class="item_meta_item_title">Парковка:</p>
	                    <p class="item_meta_item_value"><?=!empty($rest['restaurant_parking']) ? ($rest['restaurant_parking'].' мест'.Declension::get_num_ending($rest['restaurant_parking'], ['о','а',''])) : 'нет'?></p>
                    </div>
                </div>    
            </div> 
            <button data-rest-name="<?=$model['restaurant_name']?>" data-rest-type="<?=$model['restaurant_main_type']?>" data-open-popup-form="" class="rent_button">Забронировать</p>                   
        </div>
    </div>
  </div>
</div>