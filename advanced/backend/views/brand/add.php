<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,'name')->textInput();
echo $form->field($brand,'intro')->textarea();
echo $form->field($brand,'image')->fileInput();
echo \yii\bootstrap\Html::img([$brand->img],['height'=>'50px','width'=>'50px','class'=>"img-circle"]);

////外部TAG
//echo Html::fileInput('test',['id' => 'test']);
//echo Uploadify::widget([
//    'url' => yii\helpers\Url::to(['s-upload']),
//    'id' => 'test',
//    'csrf' => true,
//    'renderTag' => false,
//    'jsOptions' => [
//        'width' => 120,
//        'height' => 40,
//        'onUploadError' => new JsExpression(<<<EOF
//function(file, errorCode, errorMsg, errorString) {
//    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
//}
//EOF
//        ),
//        'onUploadSuccess' => new JsExpression(<<<EOF
//function(file, data, response) {
//    data = JSON.parse(data);
//    if (data.error) {
//        console.log(data.msg);
//    } else {
//        console.log(data.fileUrl);
//    }
//}
//EOF
//        ),
//    ]
//]);
echo $form->field($brand,'sort')->textInput();
echo $form->field($brand,'status')->inline()->radioList(\backend\models\Brand::$statusArray);
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();