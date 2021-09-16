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
    if (!$model) die();
?>
<div  class="post-block post-block-slider post-block_color_<?=$setting_color?> post-block_margin_<?=$setting_margin?>">
  <div class="wrapper wrapper_size_<?=$setting_size?>">
    <?/*<div class="listing_widget_arrow _prev"></div>
    <div class="listing_widget_arrow _next"></div>*/?>
    <div class="swiper-container" data-gallery-post-swiper data-gallery-swiper>
        <div class="swiper-wrapper" data-gallery-list>
            <?foreach ($model['restaurant_images'] as $image) {?>
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
    <div class="swiper-container" data-gallery-post-thumb-swiper>
        <div class="swiper-wrapper" data-gallery-list>
            <?foreach ($model['restaurant_images'] as $image) {?>
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