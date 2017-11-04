<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name')->textInput();
echo $form->field($article,'author')->textInput();
echo $form->field($article,'up_author')->textInput();
echo $form->field($article,'intro')->textInput();
echo $form->field($article,'cate_id')->dropDownList($options);
echo $form->field($article,'sort')->textInput();
echo $form->field($article,'status')->inline()->radioList(\backend\models\Article::$statusArray);
echo $form->field($article,'content')->textarea();
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();