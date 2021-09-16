<?php

/* @var $this yii\web\View */

//use Yii;
use common\models\Subdomen;
use frontend\modules\pmnbd\models\ElasticItems;
use common\models\elastic\ItemsFilterElastic;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div>
        <?php

            $subdomen_model = Subdomen::find()->all();
            $elastic_model = new ElasticItems;
            $category_list = [
                2  => 'Банкетные залы',
                1  => 'Рестораны',                
                3  => 'Кафе',
                5  => 'Бары',
                4  => 'Клубы',                
            ];
            $table = [];
            $sort_table = [];

            foreach ($subdomen_model as $key => $subdomen) {
                $restaurants = $items = new ItemsFilterElastic([], 1, 1, false, 'restaurants', $elastic_model, false, false, $subdomen->city_id);
                if($restaurants->total > 9){
                    $sort_table[$subdomen->name] = $restaurants->total;
                    foreach ($category_list as $key => $value) {
                        $restaurants = $items = new ItemsFilterElastic(['mesto' => [$key]], 1, 1, false, 'restaurants', $elastic_model, false, false, $subdomen->city_id);
                        $table[$subdomen->name][$value] = $restaurants->total;
                    }
                }
            }

            arsort($sort_table);


        ?>

        <div style="display: flex;">
            <div style="width: 200px;">Город</div>
            <div style="width: 100px;">Общее кол-во</div>
            <div style="width: 100px;">Банкетные залы</div>
            <div style="width: 100px;">Рестораны</div>
            <div style="width: 100px;">Кафе</div>
            <div style="width: 100px;">Бары</div>
            <div style="width: 100px;">Клубы</div>
        </div>

        <?php foreach ($sort_table as $key => $value): ?> 
            <div style="display: flex;">
                    <div style="width: 200px;"><?=$key?></div>
                    <div style="width: 100px;"><?=$value?></div>
                <?php foreach ($table[$key] as $key2 => $value2): ?> 
                    <div style="width: 100px;"><?=$value2?></div>
                <?php endforeach; ?>  
            </div>
        <?php endforeach; ?>   
    </div>
    
</div>
