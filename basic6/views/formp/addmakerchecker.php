<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<?php $form=ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>


<?= $form->field($model,'user_id')->textInput()?>


<?= $form->field($model,'name')->textInput()?>

<?= $form->field($model,'password')->passwordInput()?>

<?= $form->field($model,'user_type')->dropDownList(
   	["maker"=>"maker","checker"=>"checker"],
 	['prompt'=>'Select user type']
    );
?>

<?= Html::submitButton('Submit',['class'=>'btn btn-success']);?>	

<?php ActiveForm::end(); ?>