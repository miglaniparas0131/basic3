<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['action' =>['formp/submit_tables'], 'method' => 'post']);
for($i=0;$i<$size;$i++){
	echo '<input type="checkbox" name="check_list[]" value="'.$tbl[$i].'"><label>'.$tbl[$i].'</label>';
	echo '</br>';	
}

echo Html::submitButton('Submit',['class'=>'btn btn-success']);	

ActiveForm::end();



?>