<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    $session = Yii::$app->session;
    $hideMenu= $session->get("hideMenu");
    if(!isset($hideMenu)){
        $hideMenu=false; 
    }
    if($hideMenu){
        $sidebarclass='sidebar-collapse';
    }else{
        $sidebarclass='';
    }
    frontend\assets\AppAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>EULIMS | <?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <?php $this->head() ?>
        <?php echo PHP_EOL; ?>
        <script type="text/javascript">
            function ToggleLeftMenu(){
                $.post("/ajax/togglemenu", {}, function(result){
                    if(result){
                        //
                    }
                });
            }
            function PreviewReport(PDFUrl){
                /*
                * This Function will preview Generated PDF
                * With the given URL of PDF Action
                */
                //alert(PDFUrl);
                var url="/reports/preview?url="+PDFUrl;
                window.open(url, '_blank');
            }
                        function CurrencyFormat(number,decimalplaces){
               if (typeof decimalplaces === 'undefined'){ 
                   decimalplaces = 2; 
               }
               var decimalcharacter = ".";
               var thousandseparater = ",";
               number = parseFloat(number);
               var sign = number < 0 ? "-" : "";
               var formatted = new String(number.toFixed(decimalplaces));
               if( decimalcharacter.length && decimalcharacter != "." ) { formatted = formatted.replace(/\./,decimalcharacter); }
               var integer = "";
               var fraction = "";
               var strnumber = new String(formatted);
               var dotpos = decimalcharacter.length ? strnumber.indexOf(decimalcharacter) : -1;
               if( dotpos > -1 )
               {
                  if( dotpos ) { integer = strnumber.substr(0,dotpos); }
                  fraction = strnumber.substr(dotpos+1);
               }
               else { integer = strnumber; }
               if( integer ) { integer = String(Math.abs(integer)); }
               while( fraction.length < decimalplaces ) { fraction += "0"; }
               temparray = new Array();
               while( integer.length > 3 )
               {
                  temparray.unshift(integer.substr(-3));
                  integer = integer.substr(0,integer.length-3);
               }
               temparray.unshift(integer);
               integer = temparray.join(thousandseparater);
               return sign + integer + decimalcharacter + fraction;
            }
            function StringToFloat(str, decimalForm){
                    //This function will convert string value into Float valid values
                    if (typeof decimalForm === 'undefined'){ 
                            decimalForm = 2; 
                    }
                    var v=str.replace(',','').replace(' ','');
                    v=v.replace(',','').replace(' ','');
                    v=parseFloat(v);
                    //console.log(v);
                    var v=v.toFixed(decimalForm);
                    return v;
            }
        </script>
    </head>
    <body class="hold-transition skin-blue <?= $sidebarclass ?>">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
    </div>
    <div id="ProgressSpinner">
        <div class="animationload">
            <div class="osahanloading"></div>
        </div>
    </div>
    <?php $this->endBody() ?>
    <script type="text/javascript">
        function ShowProgressSpinner(df){
            if(df){
                $("#ProgressSpinner").show();
            }else{
                $("#ProgressSpinner").hide();
            }
        }  
    </script>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
