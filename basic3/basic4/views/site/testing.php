<?php
use yii\helpers\Html;
foreach ($model as $x) {
	// echo $x->concerned_id."</br>";
	echo "<div class='row'>";
	echo Html::a($x->table_name, ['/site/finale','id'=>$x->concerned_id,'table_name'=>$x->table_name], ['class'=>'btn btn-primary']);
	echo "</div>";
}
?>
