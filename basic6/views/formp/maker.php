<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

$json_array=Json::decode($detail,true);
$length=sizeof($json_array);

// echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
// echo '<script type="text/javascript" src="js/emailvalidation.js"></script>';

// $form = ActiveForm::begin(['action' =>['formp/submit_maker','length'=>$length,'myArray'=>Json::encode($myArray),'tablename'=>$tablename], 'method' => 'post']);
$form = ActiveForm::begin(['action' =>['formp/submit_maker','length'=>$length,'myArray'=>$detail,'tablename'=>$tablename], 'method' => 'post']);

echo '<table style="height:50%">';
$id="id";
echo '<tr colspan="2"><td><input type="hidden" name="makername" id="makername" value="'.$makername.'"></td></tr>';

echo '<tr colspan="2"><td><input type="hidden" id="length" value="'.$length.'"></td></tr>';
$i=0;
foreach($json_array as $key=>$value)
{
  $id="id{$i}";
  $validation_id="validation_id{$i}";
  echo '<tr>';
  echo '<td><label>'.$key.'</label></td>';
  if($value=="varchar" or $value=="email" or $value=="phone_number" or $value=="int"){
  echo '<td><input type="text" name="'.$id.'" id="'.$id.'" value=""></td>';
  echo '<td><input type="hidden" id="'.$validation_id.'" value="'.$value.'"></td>';
  }
  else if($value=="password"){
  echo '<td><input type="password" name="'.$id.'" id="'.$id.'"value=""></td>';
  echo '<td><input type="hidden" id="'.$validation_id.'" value="'.$value.'"></td>'; 
  }
  else if($value=="file"){ 
  echo '<td><input type="file" name="'.$id.'" id="'.$id.'" value=""></td>';
  echo '<td><input type="hidden" id="'.$validation_id.'" value="'.$value.'"></td>';
  }
  echo '</tr>';
  $i=$i+1; 
}

// for($i=0;$i<$length;$i++)
// {
// 	$id="id{$i}";
// 	$validation_id="validation_id{$i}";
// 	$myArray2=$myArray[$i];
// 	$keyValue = explode(':', $myArray2);
//   //new code
//   $length_of_explode=sizeof($keyValue);
// 	echo '<tr>';
// 	echo '<td><label>'.$keyValue[0].'</label></td>';
// 	if($keyValue[1]=="varchar" or $keyValue[1]=="email" or $keyValue[1]=="phone_number"){
// 	echo '<td><input type="text" name="'.$id.'" id="'.$id.'" value=""></td>';
// 	echo '<td><input type="hidden" id="'.$validation_id.'" value="'.$keyValue[1].'"></td>';
// 	}
// 	else if($keyValue[1]=="password"){
// 	echo '<td><input type="password" name="'.$id.'" id="'.$id.'"value=""></td>';
// 	echo '<td><input type="hidden" id="'.$validation_id.'" value="'.$keyValue[1].'"></td>';	
// 	}
// 	else{	
// 	echo '<td><input type="file" name="'.$id.'" id="'.$id.'" value=""></td>';
// 	echo '<td><input type="hidden" id="'.$validation_id.'" value="'.$keyValue[1].'"></td>';
// 	}
// 	echo '</tr>';	
// }
echo '</table>';
if($length)
echo Html::submitButton('Submit',['class'=>'btn btn-success','id'=>'submit']);	

ActiveForm::end();



?>

<?php

$script = <<< JS
$("#submit").click(function(event){
   var len = $("#length").val();
   var i=0;
   var counter=0;
   for(i=0;i<len;i++)
   {
   	var ida="id".concat(i.toString());
   	var validation_id="validation_id".concat(i.toString());
   	var field_value=$('#'+ida).val();
   	var validation_value=$('#'+validation_id).val();
   	//alert(field_value);
   	//alert(validation_value);
   	if(validation_value=="varchar" || validation_value=="password"){
   		counter++;
   	}
   	else if(validation_value=="email"){
   		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	var result=re.test(field_value);
    	//alert(result);
    	if(result)
    	counter++;
   	}else if(validation_value=="phone_number"){
   	    var re = /^[0-9-+]+$/;
   	    var result=(re.test(field_value) && field_value.length==10);
   	   // alert(result);
   	    if(result)
   	    counter++;
   	}else if(validation_value=="file"){
   		counter++;
   	}else if(validation_value=="int"){
      var re = /^[0-9]+$/;
      var result=re.test(field_value);
      if(result)
        counter++;
      alert(result);
    }

   }
   //var email = $("#email").val();
   if(counter==len){
     //event.preventDefault();
     alert("Your data was successfully inserted");
     //alert("Please fill all the feilds");
    }else{
    	event.preventDefault();
    	alert("Fill all the fields in proper format");
    }
});

JS;
$this->registerJS($script);

?>

