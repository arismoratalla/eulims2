<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Tagging;
use common\models\lab\Analysis;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\TaggingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * TaggingController implements the CRUD actions for Tagging model.
 */
class TaggingController extends Controller
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
     * Lists all Tagging models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaggingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Sample();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Tagging model.
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
     * Creates a new Tagging model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tagging();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tagging_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tagging model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tagging_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tagging model.
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
     * Finds the Tagging model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tagging the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tagging::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetsamplecode($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('sample_id as id, sample_code AS text')
                    ->from('tbl_sample')
                    ->where(['like', 'sample_code', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $command->db= \Yii::$app->labdb;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>Sample::find()->where(['sample_id'=>$id])->sample_code];
        }
        return $out;
    }

    public function actionGetanalysis()
	{

        $id = $_GET['id'];
        $model = new Tagging();
         $samplesQuery = Sample::find()->where(['sample_id' => $id]);
         $sampleDataProvider = new ActiveDataProvider([
                 'query' => $samplesQuery,
                 'pagination' => [
                     'pageSize' => 10,
                 ],
              
         ]);
         $analysisQuery = Analysis::find()->where(['sample_id' => $id]);
         $request = Request::find()->where(['request_id' =>42]);
         $analysisdataprovider = new ActiveDataProvider([
                 'query' => $analysisQuery,
                 'pagination' => [
                     'pageSize' => 10,
                 ],
              
         ]);
         
         return $this->renderPartial('_viewAnalysis', [
          //  'model' => $this->findModel(1),
           //  'searchModel' => $searchModel,
           //  'dataProvider' => $dataProvider,
                'request'=>$request,
               'model'=>$model,
             'sampleDataProvider' => $sampleDataProvider,
             'analysisdataprovider'=> $analysisdataprovider,
           //  'trsamples'=>$sampledataProvider,
         ]);
	// 	$barcode_data = explode(" ", $sample_code);
	// 	$sample_id = $barcode_data[0];
	// 	$analysiscount = Analysis::model()->findByAttributes(
	// 					array('sampleCode'=>$barcode_data[2], 'sample_id'=>$barcode_data[0], 'analysisYear'=>$barcode_data[1])
	// 					);
	// 	$profile = Profiles::model()->findByAttributes(
	// 				array('user_id'=>Yii::app()->user->id)
	// 				);
	// 	$lab= Lab::model()->findByPk($profile->labId);
	// 	$s= Sample::model()->findByPk($barcode_data[0]);
	// 	$request_id = $s->request_id;
	// 			$sample=new CActiveDataProvider('Sample', 
	// 					array(
	// 						'criteria'=>array(
	// 						'condition'=>"sampleCode='" .$barcode_data[2]."' 
	// 						AND id='" .$barcode_data[0]."' AND sampleCode LIKE '".$lab->labCode."-%' ",	
	// 					),
	// 						)
	// 					);		
	// 			$analysis=new CActiveDataProvider('Analysis', 
	// 				array(
	// 					'criteria'=>array(
	// 					'condition'=>"sampleCode='" .$barcode_data[2]."' AND sample_id='" .$barcode_data[0]."' AND package IN (1,0) AND sampleCode LIKE '".$lab->labCode."-%'",
	// 						),
    //                                              'pagination'=>false,
	// 					)
	// 				);
	// 			$taggingcount = Tagging::model()->findAllByAttributes(
	// 					array('status'=>2)
	// 					);

	// 			if ($analysis){
	// 						$completed = count($taggingcount);

	// 						echo    $this->renderPartial('_viewAnalysis', 
	// 						array('analysis'=>$analysis, 'sample'=>$sample, 'sample_code'=>$sample_code, 'completed'=>$completed, 'sample_code'=>$sample_code, 'sample_id'=>$sample_id, 'request_id'=>$request_id)  ,true , true);
					
	// 			}else {
	// 					echo "<div style='text-align:center;' class='alert alert-error'><i class='icon icon-warning-sign'>
	// 					</i><font style='font-size:14px;'> Sample code not found. </font><br \>";
	// 				  }
	 }
}
