<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form=ActiveForm::begin(); ?>

<?= $form->field($model,'username')->textInput(['maxlength' => true])?>

<?= $form->field($model,'password')->passwordInput()?>

<div class="row col-lg-12">
<input type="checkbox" name="formDoor[]" value="A" />Acorn Building
<input type="checkbox" name="formDoor[]" value="B" />Brown Hall
<input type="checkbox" name="formDoor[]" value="C" />Carnegie Complex
<input type="checkbox" name="formDoor[]" value="D" />Drake Commons
<input type="checkbox" name="formDoor[]" value="E" />Elliot House
</div>
</br></br>

<?= Html::submitButton('Submit',['class'=>'btn btn-success']);?>	

<?php ActiveForm::end(); ?>