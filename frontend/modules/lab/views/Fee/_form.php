<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\lab\Lab;
use common\models\lab\Fee;
use common\models\services\Testcategory;
use common\models\services\Sampletype;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use common\models\services\Test;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Fee */
/* @var $form yii\widgets\ActiveForm */


$namelist= ArrayHelper::map(Fee::find()->all(),'name','name');

?>

<div class="fee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        //'filterModel' => $samplesearchmodel,
        'pjax'=>true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive'=>false,
        'containerOptions'=>[
            'style'=>'overflow:auto; height:180px',
        ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'columns' => [
               [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
            'samplename',
            [
                'attribute'=>'description',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($data){
                    return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".$data->sampling_date."</b></span>,&nbsp;".$data->description : $data->description;
                },
                'contentOptions' => ['style' => 'width:70%; white-space: normal;'],
            ],
        ],
    ]); ?>

        <?= $form->field($model, 'fee_id')->hiddenInput()->label(false) ?>

   
    <div class="row">
        <div class="col-sm-6">

        <?= $form->field($model, 'name')->widget(Select2::classname(), [
                        'data' => $namelist,
                        'language' => 'en',
                         'options' => ['placeholder' => 'Select Name'],
                         'pluginOptions' => [
                         'allowClear' => true
                        ],
                ])->label("Name"); ?>

        <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>


        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'code')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model, 'unit_cost')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-sm-6">
      
        </div>
    </div>
    
    <?= $form->field($model, 'tests')->textarea(['rows' => 4, 'readonly' => true]) ?>
    <div class="row" style="float: right;padding-right: 30px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if($model->isNewRecord){ ?>
        <?php } ?>
    <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>