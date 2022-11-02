<?php
	use frontend\modules\pmnbd\models\ElasticItems;
	use frontend\components\Declension;
	$rest = ElasticItems::find()->query([
            'nested' => ['path' => 'rooms','query' => ['bool' => ['must' => ['match' => ['rooms.gorko_id' => $text_id]]]]]
        ])->one();
    if (!$rest) return '';
    foreach ($rest['rooms'] as $rest_room) {
        if ($rest_room['gorko_id'] == $text_id) {
            $model = $rest_room;
            break;
        }
    }
    if (!$model) return '';
?>
<div  class="post-block post-block-slider post-block_color_<?=$setting_color?> post-block_margin_<?=$setting_margin?>">
  <div class="wrapper wrapper_size_<?=$setting_size?>">
    <?/*<div class="listing_widget_arrow _prev"></div>
    <div class="listing_widget_arrow _next"></div>*/?>
    <div class="swiper-container" data-gallery-post-swiper data-gallery-swiper>
        <div class="swiper-wrapper" data-gallery-list>
            <?foreach ($model['images'] as $image) {?>
                <div class="swiper-slide">
                    <div class="post-block__img object_img">
                       <img loading="lazy" src="<?=Declension::get_image_src($image['waterpath'])?>" data-gallery-img-view/>
                   </div>
                </div>
            <? } ?>
        </div>
        <div class="listing_widget_controll">
            <div class="listing_widget_pagination"></div>
        </div> 
    </div>
    <div class="swiper-container" data-gallery-post-thumb-swiper style="">
        <div class="swiper-wrapper" data-gallery-list>
            <?foreach ($model['images'] as $image) {?>
                <div class="swiper-slide">
                    <div class="post-block__img">
                       <img loading="lazy" src="<?=Declension::get_image_src($image['waterpath'].'=w150-h90-l80')?>"/>
                   </div>
                </div>
            <? } ?>
        </div>
    </div>
  </div>
</div>