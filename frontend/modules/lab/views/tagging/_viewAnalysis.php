<?php
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use common\models\lab\Tagging;
use common\models\lab\Analysis;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\components\Functions;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;

$this->registerJsFile("/js/services/services.js");
?>

<div id="divSpinner" style="text-align:center;display:none;font-size:30px">
     <div class="animationload">
            <div class="osahanloading"></div>
     </div>
</div>

<?= GridView::widget([
        'dataProvider' => $sampleDataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-analysis']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  Sample' ,
            ],
        'columns' => [
            [
                'header'=>'Sample Name',
                'format' => 'raw',
                'enableSorting' => false,
                'attribute'=>'samplename',
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'], 
            ],
            [
                'header'=>'Description',
                'format' => 'raw',
                'enableSorting' => false,
                'attribute'=>'description',
                'contentOptions' => ['style' => 'width:40px; white-space: normal;'],   
            ],
            
        ],
    ]); ?>
<script type='text/javascript'>


setTimeout(function(){
    ShowProgressSpinner(false);
},1000);

 
</script>

<?php

//$doc = new DomDocument;

// We need to validate our document before refering to the id
// $doc->validateOnParse = true;
// $doc->loadHtml(file_get_contents('index.php'));

// $test= $doc->getElementById('divSpinner');
// $test->setAttribute('style','display:none');
?>

<?php


////////////////////////////

// echo "<pre>";
// print_r($sampleDataProvider);
// echo "</pre>";
// exit;

//             echo DetailView::widget([
//             'model'=>$sampleDataProvider,
//             'responsive'=>true,
//             'hover'=>true,
//             'mode'=>DetailView::MODE_VIEW,
//             'panel'=>[
//                 'heading'=>'<i class="glyphicon glyphicon-book"></i> Request # ',
//                 'type'=>DetailView::TYPE_PRIMARY,
//             ],
//             'buttons1' => '',
//             'attributes'=>[
//                 [
//                     'group'=>true,
//                     'label'=>'Request Details ',
//                     'rowOptions'=>['class'=>'info']
//                 ],
//                 [
//                     'columns' => [
//                         [
//                             'label'=>'Customer / Agency',
//                             'format'=>'raw',
//                             'displayOnly'=>true,
//                             'valueColOptions'=>['style'=>'width:30%']
//                         ],
//                         [
//                             'label'=>'Customer / Agency',
//                             'format'=>'raw',
//                            // 'value'=>$model->customer->customer_name,
//                             'valueColOptions'=>['style'=>'width:30%'], 
//                             'displayOnly'=>true
//                         ],
                    
//                     ],
//                 ],
             
                
//                 [
//                     'group'=>true,
//                     'label'=>'Transaction Details',
//                     'rowOptions'=>['class'=>'info']
//                 ],
              
//             ],

//         ]);
// // 
        //////////////////////////
        ?>

 <?php
            $gridColumns = [
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                     return $this->render('_workflow', [
                         'model'=>$model,
                     ]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
                    [
                        'header'=>'Test Name',
                        'hAlign'=>'center',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->testname;
                        },
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                 
                    ],
                    [
                        'header'=>'Method',
                        'hAlign'=>'center',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->method;
                        },
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                      
                    ],
                    [
                        'header'=>'Analyst',
                        'hAlign'=>'center',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                   
                    ],
                    [
                        'header'=>'ISO accredited',
                        'hAlign'=>'center',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],                 
                    ],
                    [
                          'header'=>'Status',
                          'hAlign'=>'center',
                          'format'=>'raw',
                          'value' => function($model) {
                                  return "<button class='btn btn-default btn-block'>Pending</button>";
                          },
                          'enableSorting' => false,
                          'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
                      ],
                    [
                        'header'=>'Remarks',
                       // 'hAlign'=>'center',
                        'format' => 'raw',
                        'value' => function($model) {
                            return "<b>Start Date:<br>End Date:</b>";
                    },
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                ],
                
                
            ];     
        ?>

<?php echo GridView::widget([
                'id' => 'analysis-grid',
                'dataProvider'=> $analysisdataprovider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'striped'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i>Analysis</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,
                'toolbar' => [
                    
                   // '{toggleData}',
                ],    
            ]);
?>




    
