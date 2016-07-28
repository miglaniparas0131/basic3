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
        //echo "field$x";
        $field="field{$x}";
        echo '<input id="'.$field.'" type="text" name="result[]" value="">';
        echo "</td>";
        echo "<td>";
        $validation_dropdown="validation_dropdown{$x}";
        echo '<select id="'.$validation_dropdown.'" onchange="jsFunction(this.id,this.value)";>';
        echo "<option value='select variant'>select variant</option>";
        echo "<option value='email'>email</option>";
        echo "<option value='phone_number'>phone_number</option>";
        echo "<option value='password'>password</option>";
        echo "<option value='null'>null</option>";
        echo "</select>";
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


<script type="text/javascript">
var main_count=0;
function jsFunction(id,value)
{
    var validation_id=id.substr(19);
    var concerned_field="field"+validation_id;
    var field_value = document.getElementById(concerned_field).value;
    var field_validation = document.getElementById(id).value;
    alert(validation(field_value,field_validation));
    // if(validation(field_value,field_validation)===true)
    // {
    //   main_count++;
    // }
    // else
    // {
    //   main_count--;
    // }
    // alert(main_count);
}

function validation(field_value,field_validation)
{
  if(field_validation=="select variant"){

  }

  else if(field_validation=="email"){
   var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(field_value);
  }else if(field_validation=="phone_number"){
      var re = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
      return re.test(field_value);
  }else if(field_validation=="password"){
    var re = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
    return re.test(field_value);
    //(?=.*[0-9]) - Assert a string has at least one number;
    //(?=.*[!@#$%^&*]) - Assert a string has at least one special character.
  }else if(field_validation=="null"){
      if(field_value===""){
        return true;
      }else{
        return false;
      }
  }

}
</script>
