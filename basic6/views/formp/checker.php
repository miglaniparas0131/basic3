<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

//$this->layout='makercheckerLayout';	

echo "<select id='populated_field'>";
 for($index=0;$index<$size;$index++){
 	echo "<option value='".$tbl[$index]."'>".$tbl[$index]."</option>";	
 }
echo "</select>";
echo '<input type="hidden" name="checkername" id="checkername" value="'.$checkername.'">';

?>

<?php

$script = <<< JS
//here write all your JS stuff
$('#populated_field').change(function(){
	var checkername = document.getElementById("checkername").value;
	var name=$(this).val();
	alert(name);
	$('#paras').html("");
	$.get('index.php?r=formp/process_checker',{name:name,checkername:checkername},function(data){
		alert(data);
		$('#paras').html(data);
	});
		

});

JS;
$this->registerJS($script);

?>
<div id="paras"></div>