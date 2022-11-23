<?php

use frontend\components\Declension;
use frontend\modules\pmnbd\models\ElasticItems;
use common\models\Subdomen;
use backend\modules\pmnbd\models\blog\BlogPost;

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
$alias = $subdomen->alias == 'msk' ? 'https://birthday-place.ru' : ('https://' . $subdomen->alias . '.birthday-place.ru');

$controller = Yii::$app->controller->id;
$blog_alias = Yii::$app->request->url;
$blog_alias = str_replace($controller, '', $blog_alias);
$blog_alias = str_replace('/', '', $blog_alias);
$post = BlogPost::findOne(['alias' => trim($blog_alias)]);

//    $vars = get_defined_vars();
//    echo '<pre>';
//    print_r($blog_alias);
//    die();
?>

<div class="post-block post-block-rest post-block_color_<?= $setting_color ?> post-block_margin_<?= $setting_margin ?>">
    <div class="wrapper wrapper_size_<?= $setting_size ?>">
        <div class="post-block-rest-item">
            <div class="item_image">
                <div class="item_badges">
                    <div class="item_present">
                        <img loading="lazy" src="/upload/img/Gift_icon.svg"
                             atl="Подарок за бронирование в ресторане «<?= $model['restaurant_name'] ?>»">за
                        бронирование
                    </div>
                    <?php if (!empty($post->badge_items)) echo $post->badge_items; ?>
                </div>
                <a href="<?= $alias ?>/catalog/restoran-<?= $model['restaurant_slug'] ?>/" data-target="rest_blog">
                    <!--	            <div class="item_img">-->
                    <!--	                <img loading="lazy" src="-->
                    <? //= $model['restaurant_images'] ? Declension::get_image_src($model['restaurant_images'][0]['subpath']) : '/upload/img/bd/no_photo.png'?><!--" alt="Ресторан -->
                    <? //=$model['restaurant_name']?><!--">-->
                    <!--	            </div>-->
                    <div class="item_img swiper" data-item-gallery>
                        <div class="swiper-wrapper">
                            <?php if ($model['restaurant_images']): ?>
                                <?php foreach ($model['restaurant_images'] as $image_src): ?>
                                    <div class="swiper-slide">
                                        <img src="<?= $image_src['subpath'] . '=w360-l100-rw' ?>"
                                             alt="<?= !empty($img_alt) ? str_replace('{название}', $model['restaurant_name'], $img_alt) : "Ресторан " . $model['restaurant_name'] ?>"/>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="swiper-slide">
                                    <img src="/upload/img/bd/no_photo.png"
                                         alt="<?= !empty($img_alt) ? str_replace('{название}', $model['restaurant_name'], $img_alt) : "Ресторан " . $model['restaurant_name'] ?>"/>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="swiper-pagination item-gallery-pagination"></div>
                    </div>
                </a>
            </div>
            <div class="item_info">
                <div class="item_info_top">
                    <a href="<?= $alias ?>/catalog/restoran-<?= $model['restaurant_slug'] ?>/" data-target="rest_blog">
                        <p class="item_name"><?= $model['restaurant_name'] ?></p>
                    </a>

                    <div class="item_address"
                         data-single-map=""
                         data-map_img="<?= $model['restaurant_images'] ? Declension::get_image_src($model['restaurant_images'][0]['subpath']) : '/upload/img/bd/no_photo.png' ?>"
                         data-map_rest_name="<?= $model['restaurant_name'] ?>"
                         data-map_rest_href="/catalog/restoran-<?= $model['restaurant_slug'] ?>/"
                         data-map_rest_address="<?= $model['restaurant_address'] ?>"
                         data-map_dot_x="<?= $model['restaurant_latitude'] ?>"
                         data-map_dot_y="<?= $model['restaurant_longitude'] ?>">
                        <img loading="lazy" src="/upload/img/item_geo.svg" alt="Адрес Наполеон">
                        <p class="item_meta-item_address"><?= $model['restaurant_address'] ?></p>
                    </div>
                </div>
                <?php if ($model['restaurant_avg_check'] and $model['restaurant_avg_check'] != 0): ?>
                    <div class="item_price">
                        <span class="item_price-title">Средний чек:</span>от <?= $model['restaurant_avg_check'] ?>
                        ₽/чел.
                    </div>
                <?php endif; ?>
                <div class="item_meta">
                    <div class="item_meta_items">
                        <div class="item_meta_item">
                            <p class="item_meta_item_title">
                                <img loading="lazy" src="/upload/img/item_people.svg"
                                     alt="Вместимость <?= $model['restaurant_name'] ?>">
                                <span>Вместимость:</span>
                            </p>
                            <p class="item_meta_item_value"><?= $model['restaurant_min_capacity'] ?>
                                - <?= $model['restaurant_max_capacity'] ?>
                                человек<?= Declension::get_num_ending($model['restaurant_max_capacity'], ['', 'а', '']) ?></p>
                        </div>
                        <div class="item_meta_item">
                            <p class="item_meta_item_title">
                                <img loading="lazy" src="/upload/img/item_price.svg"
                                     alt="Стоймость аренды в <?= $model['restaurant_name'] ?>">
                                <span>Стоимость аренды без еды:</span>
                            </p>

                            <p class="item_meta_item_value">
                                от <?= number_format($min_price * $model['restaurant_min_capacity'], 0, '', ' ') ?>
                                ₽</p>
                        </div>
                    </div>
                    <div class="item_meta_items">
                        <div class="item_meta_item">
                            <p class="item_meta_item_title">
                                <img loading="lazy" src="/upload/img/item_alko.svg"
                                     alt="Свой алкоголь в <?= $model['restaurant_name'] ?>">
                                <span>Свой алкоголь:</span>
                            </p>
                            <p class="item_meta_item_value"><?= in_array($model['restaurant_alcohol'], [1, 2]) ? 'да' : 'нет' ?></p>
                        </div>

                        <div class="item_meta_item">
                            <p class="item_meta_item_title">
                                <img loading="lazy" src="/upload/img/item_car.svg"
                                     alt="Парковка в <?= $model['restaurant_name'] ?>">
                                <span>Парковка:</span>
                            </p>
                            <p class="item_meta_item_value">
                                <?= !empty($model['restaurant_parking']) ? ($model['restaurant_parking'] . ' мест' . Declension::get_num_ending($model['restaurant_parking'], ['о', 'а', ''])) : 'нет' ?>
                            </p>
                        </div>
                    </div>
                    <div class="item_meta_items">
                        <?php if ($model['restaurant_cuisine']): ?>
                            <div class="item_meta_item">
                                <p class="item_meta_item_title">
                                    <img loading="lazy" src="/upload/img/item_kitchen.svg"
                                         alt="Кухня в <?= $model['restaurant_name'] ?>">
                                    <span>Кухня:</span>
                                </p>
                                <p class="item_meta_item_value"><?= $model['restaurant_cuisine'] ?></p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <!--            <button data-rest-name="--><? //=$model['restaurant_name']?><!--" data-rest-type="-->
                <? //=$model['restaurant_main_type']?><!--" data-open-popup-form-blog="" data-target="bron_1" class="rent_button">Забронировать</p>-->
            </div>
        </div>
    </div>
</div>