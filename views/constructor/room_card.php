<?php

use frontend\components\Declension;
use frontend\modules\pmnbd\models\ElasticItems;
use common\models\Subdomen;
use backend\modules\pmnbd\models\blog\BlogPost;

$rest = ElasticItems::find()->query([
    'nested' => ['path' => 'rooms', 'query' => ['bool' => ['must' => ['match' => ['rooms.gorko_id' => $text_id]]]]]
])->one();
if (!$rest) return '';
foreach ($rest['rooms'] as $rest_room) {
    if ($rest_room['gorko_id'] == $text_id) {
        $model = $rest_room;
        break;
    }
}
if (!$model) return '';

$subdomen = Subdomen::findOne(['city_id' => $rest['restaurant_city_id']]);
$alias = $subdomen->alias == 'msk' ? 'https://birthday-place.ru' : ('https://' . $subdomen->alias . '.birthday-place.ru');

$controller = Yii::$app->controller->id;
$blog_alias = Yii::$app->request->url;
$blog_alias = str_replace($controller, '', $blog_alias);
$blog_alias = str_replace('/', '', $blog_alias);
$post = BlogPost::findOne(['alias' => trim($blog_alias)]);

//    echo '<pre>';
//    print_r($model);
//    die();
?>
<div class="post-block post-block-room post-block_color_<?= $setting_color ?> post-block_margin_<?= $setting_margin ?>">
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
                <a href="<?= $alias ?>/catalog/restoran-<?= $model['restaurant_slug'] ?>/<?= $model['slug'] ?>/">
                    <div class="item_img swiper" data-item-gallery>
                        <div class="swiper-wrapper">
                            <?php if ($model['images']): ?>
                                <?php foreach ($model['images'] as $image_src): ?>
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
                    <a href="<?= $alias ?>/catalog/restoran-<?= $model['restaurant_slug'] ?>/"
                       class="item_rest_name"><?= $rest['restaurant_main_type'] ?> <?= $rest['restaurant_name'] ?></a>
                    <a href="<?= $alias ?>/catalog/restoran-<?= $model['restaurant_slug'] ?>/<?= $model['slug'] ?>/">
                        <p class="item_name"><?= $model['name'] ?></p>
                    </a>
                    <div class="item_address"
                         data-single-map=""
                         data-map_img="<?= $rest['restaurant_images'] ? Declension::get_image_src($rest['restaurant_images'][0]['subpath']) : '/upload/img/bd/no_photo.png' ?>"
                         data-map_rest_name="<?= $rest['restaurant_name'] ?>"
                         data-map_rest_href="/catalog/restoran-<?= $rest['restaurant_slug'] ?>/"
                         data-map_rest_address="<?= $rest['restaurant_address'] ?>"
                         data-map_dot_x="<?= $rest['restaurant_latitude'] ?>"
                         data-map_dot_y="<?= $rest['restaurant_longitude'] ?>">
                        <img loading="lazy" src="/upload/img/item_geo.svg" alt="Адрес Наполеон">
                        <p class="item_meta-item_address"><?= $rest['restaurant_address'] ?></p>
                    </div>
                </div>
                <?php if ($model['price']): ?>
                    <div class="item_price">
                        <span class="item_price-title">Средний чек:</span>от <?= $model['price'] ?> ₽/чел.
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
                            <p class="item_meta_item_value"><?= $model['capacity'] ?>
                                человек<?= Declension::get_num_ending($model['capacity'], ['', 'а', '']) ?></p>
                        </div>
                        <div class="item_meta_item">
                            <p class="item_meta_item_title">
                                <img loading="lazy" src="/upload/img/item_price.svg"
                                     alt="Стоймость аренды в <?= $model['restaurant_name'] ?>">
                                <span>Стоимость аренды без еды:</span>
                            </p>
                            <p class="item_meta_item_value"><?= number_format($model['price'] * $model['capacity'], 0, '', ' ') ?>
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
                            <p class="item_meta_item_value"><?= in_array($rest['restaurant_alcohol'], [1, 2]) ? 'да' : 'нет' ?></p>
                        </div>

                        <div class="item_meta_item">
                            <p class="item_meta_item_title">
                                <img loading="lazy" src="/upload/img/item_car.svg"
                                     alt="Парковка в <?= $model['restaurant_name'] ?>">
                                <span>Парковка:</span>
                            </p>
                            <p class="item_meta_item_value"><?= !empty($rest['restaurant_parking']) ? ($rest['restaurant_parking'] . ' мест' . Declension::get_num_ending($rest['restaurant_parking'], ['о', 'а', ''])) : 'нет' ?></p>
                        </div>
                    </div>
                    <div class="item_meta_items">
                        <?php if ($rest['restaurant_cuisine']): ?>
                            <div class="item_meta_item">
                                <p class="item_meta_item_title">
                                    <img loading="lazy" src="/upload/img/item_kitchen.svg"
                                         alt="Кухня в <?= $model['restaurant_name'] ?>">
                                    <span>Кухня:</span>
                                </p>
                                <p class="item_meta_item_value"><?= $rest['restaurant_cuisine'] ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

<!--                <div class="item_meta">-->
<!--                    <div class="item_meta_items">-->
<!--                        <div class="item_meta_item">-->
<!--                            <p class="item_meta_item_title">Вместимость:</p>-->
<!--                            <p class="item_meta_item_value">--><?//= $model['capacity'] ?>
<!--                                человек--><?//= Declension::get_num_ending($model['capacity'], ['', 'а', '']) ?><!--</p>-->
<!--                        </div>-->
<!--                        <div class="item_meta_item">-->
<!--                            <p class="item_meta_item_title">Стоимость аренды без еды:</p>-->
<!--                            <p class="item_meta_item_value">--><?//= number_format($model['price'] * $model['capacity'], 0, '', ' ') ?>
<!--                                ₽</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="item_meta_items">-->
<!--                        <div class="item_meta_item">-->
<!--                            <p class="item_meta_item_title">Свой алкоголь:</p>-->
<!--                            <p class="item_meta_item_value">--><?//= in_array($rest['restaurant_alcohol'], [1, 2]) ? 'да' : 'нет' ?><!--</p>-->
<!--                        </div>-->
<!--                        <div class="item_meta_item">-->
<!--                            <p class="item_meta_item_title">Парковка:</p>-->
<!--                            <p class="item_meta_item_value">--><?//= !empty($rest['restaurant_parking']) ? ($rest['restaurant_parking'] . ' мест' . Declension::get_num_ending($rest['restaurant_parking'], ['о', 'а', ''])) : 'нет' ?><!--</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!--                <button data-rest-name="--><? //= $model['restaurant_name'] ?><!--"-->
                <!--                        data-rest-type="-->
                <? //= $model['restaurant_main_type'] ?><!--" data-open-popup-form-blog=""-->
                <!--                        class="rent_button">Забронировать</p>-->
            </div>
        </div>
    </div>
</div>