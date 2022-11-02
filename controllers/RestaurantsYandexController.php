<?php

namespace backend\modules\pmnbd\controllers;

use Yii;
use common\models\RestaurantsYandex;
use common\models\RestaurantsYandexSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RestaurantsYandexController implements the CRUD actions for RestaurantsYandex model.
 */
class RestaurantsYandexController extends BaseBackendController
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

	public function beforeAction($action)
	{
		$connection = new \yii\db\Connection([
			'username' => 'root',
			'password' => 'GxU25UseYmeVcsn5Xhzy',
			'charset'  => 'utf8mb4',
			'dsn' => 'mysql:host=localhost;dbname=pmn'
		]);
		$connection->open();
		Yii::$app->set('db', $connection);

		return parent::beforeAction($action);
	}

	/**
	 * Lists all RestaurantsYandex models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new RestaurantsYandexSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single RestaurantsYandex model.
	 * @param integer $id
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
	 * Creates a new RestaurantsYandex model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new RestaurantsYandex();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing RestaurantsYandex model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{

		$model = $this->findModel($id);

		/* // if ($model->load(Yii::$app->request->post()) && $model->save()) {
		// 	return $this->redirect(['index']);
		// }
		if ($model->load(Yii::$app->request->post())) {
			return $this->redirect(['update', 'id' => $id]);
		} */

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
	  }

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing RestaurantsYandex model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the RestaurantsYandex model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return RestaurantsYandex the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = RestaurantsYandex::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
