<?php
namespace backend\modules\pmnbd\controllers;

use backend\controllers\BaseBackendController;
use Yii;
use common\models\Restaurants;
use common\models\RestaurantsModule;
use common\models\RestaurantsModuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RestaurantsController implements the CRUD actions for Restaurants model.
 */
class GorkoidController extends BaseBackendController
{
    public function actionIndex()
    {
        $current_connection = Yii::$app->get('db');
        $connection = new \yii\db\Connection([
            'dsn'       => 'mysql:host=localhost;dbname=pmn',
            'username' => 'root',
            'password' => 'GxU25UseYmeVcsn5Xhzy',
            'charset' => 'utf8mb4',
        ]);
        $connection->open();
        Yii::$app->set('db', $connection);
        $restaurants = Restaurants::find()->all();
        $data = [];
        foreach ($restaurants as $key => $restaurant) {
            $data[$restaurant->gorko_id] = $restaurant->name.' - '.$restaurant->address;
        }

        Yii::$app->set('db', $current_connection);        

        return $this->render('index', [
            'data' => $data
        ]);
    }
}