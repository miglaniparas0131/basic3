<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;


//echo $tables[0]["table_name"];
 echo "<select id='populated_field'>";
 for($index=0;$index<$len;$index++){
 	echo "<option value='".$tables[$index]["table_name"]."'>".$tables[$index]["table_name"]."</option>";	
 }
 echo "</select>";
echo '<input id="makername" type="hidden" name="index" value="'.$makername.'";>';

?>

<?php

$script = <<< JS
//here write all your JS stuff
$('#populated_field').change(function(){
	makername=document.getElementById('makername').value;
	$('#paras').html("");
	var name=$(this).val();
	//alert(name);
	
	$.get('index.php?r=formp/previewmaker',{name:name,makername:makername},function(data){
		//alert(data);
		//var data=$.parseJSON(data);
		$('#paras').html(data);
		//$('#customers-province').attr('value',data.province);
		//alert(data);
	});
		

});

JS;
$this->registerJS($script);

?>
<div id="paras"></div>