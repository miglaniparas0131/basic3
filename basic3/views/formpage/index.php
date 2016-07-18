<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

echo "<select id='populated_field'>";
foreach ($model as $x) {
	echo "<option value='".$x->table_name."'>".$x->table_name."</option>";
	
}
echo "<select>";

?>

<?php

$script = <<< JS
//here write all your JS stuff
$('#populated_field').change(function(){
	var name=$(this).val();
	
	$.get('index.php?r=formpage/getdetails',{name:name},function(data){
		//var data=$.parseJSON(data);
		//$('#customers-city').attr('value',data.city);
		//$('#customers-province').attr('value',data.province);
		alert(data);
	});
		

});

JS;
$this->registerJS($script);

?>
