<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<?php $form=ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>


<?= $form->field($model,'username')->textInput(['maxlength' => true])?>


<?= $form->field($model,'email')->textInput()?>

<?= $form->field($model,'password')->passwordInput()?>

<?= $form->field($model, 'confirm_password')->passwordInput() ?>

<?= $form->field($model,'file')->fileInput() ?>

<?= $form->field($model,'file2')->fileInput() ?>


<?= Html::submitButton('Submit',['class'=>'btn btn-success']);?>	

<?php ActiveForm::end(); ?>