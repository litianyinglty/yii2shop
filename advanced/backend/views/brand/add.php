<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,'name')->textInput();
echo $form->field($brand,'intro')->textarea();
echo $form->field($brand,'logo')->widget('manks\FileInput');
//echo \yii\bootstrap\Html::img([$brand->logo],['height'=>'50px','width'=>'50px','class'=>"img-circle"]);
echo $form->field($brand,'sort')->textInput();
echo $form->field($brand,'status')->inline()->radioList(\backend\models\Brand::$statusArray);
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();