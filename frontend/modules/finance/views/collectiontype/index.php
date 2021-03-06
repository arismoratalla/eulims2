<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\CollectiontypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collection Type';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collectiontype-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Collection Type', ['value'=>'/finance/collectiontype/create', 'class' => 'btn btn-success btn-modal','name' => Yii::t('app', "Create New Collection Type")]); ?>
      
    </p>
    <div class="table-responsive">
        <?php 
        $Buttontemplate='{update}{delete}'; 
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ]
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'natureofcollection',
                [
                    'class' => kartik\grid\ActionColumn::className(),
                    'template' => $Buttontemplate,
                    'buttons'=>[
                    'update'=>function ($url, $model) {
                        $t = '/finance/collectiontype/update?id='.$model->collectiontype_id;
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success btn-modal']);
                    },
                    
                ],
                ],
            ],
        ]); ?>
    </div>
</div>
