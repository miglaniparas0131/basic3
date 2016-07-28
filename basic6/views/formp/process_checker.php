<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

//$this->layout='makercheckerLayout';	

if($length)
{
echo '<table rules="all" cellpadding="10px" cellspacing="10px" border="10px">';

//new code
foreach($records[0] as $key=>$value)
{
	echo '<th>'.$key.'</th>';
}

	
for($i=0;$i<$length;$i++)
{
	echo '<tr>';
	$id=0;

	foreach($records[$i] as $key=>$value)
	{
		if($key=="id"){
			$id=$value;
		}
		echo '<td>'.$value.'</td>';
		//echo '<td>'.$key.'='.$value.'</td>';
	}
	echo '<td>';
	echo Html::a('Approve', ['/formp/approve','id'=>$id,'table_name'=>$name,'checkername'=>$checkername]);
	echo '</td>';
	echo '<td>';
	echo Html::a('Disapprove', ['/formp/disapprove','id'=>$id,'table_name'=>$name,'checkername'=>$checkername]);
	echo '</td>';
	echo '</tr>';		
}
echo '</table>';
}
else
{
	echo "<marquee><h4>There are no pending records in this table</h4><marquee>";
}

?>
