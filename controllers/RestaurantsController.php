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
class RestaurantsController extends BaseBackendController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Restaurants models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RestaurantsModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Restaurants model.
     * @param integer $id
     * @param integer $gorko_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Restaurants model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RestaurantsModule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

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

        return $this->render('create', [
            'model' => $model,
            'data' => $data
        ]);
    }

    /**
     * Updates an existing Restaurants model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $gorko_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Restaurants model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $gorko_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Restaurants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $gorko_id
     * @return Restaurants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantsModule::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
