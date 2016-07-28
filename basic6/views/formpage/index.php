<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

echo "<select id='populated_field'>";
foreach ($model as $x) {
	echo "<option value='".$x->table_name."'>".$x->table_name."</option>";
	
}
echo "</select>";

?>

<?php

$script = <<< JS
//here write all your JS stuff
$('#populated_field').change(function(){
	var name=$(this).val();
	
	$.get('index.php?r=formpage/gotoform',{name:name},function(data){
		//alert(data);
		//var data=$.parseJSON(data);
		$('#shukla').html(data);
		//$('#customers-province').attr('value',data.province);
		//alert(data);
	});
		

});

JS;
$this->registerJS($script);

?>



<div id="shukla">

</div>