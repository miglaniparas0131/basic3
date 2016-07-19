<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Locations;
//use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>



<div >

    
   <?php
  $form = ActiveForm::begin(['action' =>['formpage/submitdetail'], 'method' => 'post']); 
 // $form = ActiveForm::begin(['action' =>['formpage/submitdetail'], 'method' => 'post',]);
 	  //$data=[];
      //echo "Table_name=>".$name."</br>";
     echo "<table>"; 
      echo "<input type='hidden' name='table_name' value=".$name.">";

    for($x=0;$x<$data;$x++) 
    {
  	  //$datafields[$x]=0; 
      echo "<tr>";
      $datafields[$x]=$columns[$x]['Field'];
      echo "<td>";
      echo $datafields[$x];
      echo "</td>";
      //echo $datafields[];
        // echo '<input type="hidden" name="result[]" value="'. $value. '">';
        echo "<td>";
        echo "<input type='hidden' name='fields[]' value=".$columns[$x]['Field'].">";
        echo '<input type="text" name="result[]" value="">';
        echo "</td>";

        echo "</tr>"; 
    	//echo $columns[$x]['Field'].":<input type='text' name=".$columns[$x]['Field']."></br>";
      
  	}
    echo "</table>";
    //var_dump($datafields);
    //echo Json::encode($datafields);   

   	//echo "<input type='submit' value='Submit'>";
    echo Html::submitButton('Submit',['formpage/submitdetail'],['class'=>'btn btn-success']);	

	ActiveForm::end();
	?>


    

</div>


  