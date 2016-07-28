

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$next=(string)($pageno+1);
$previous=(string)($pageno-1);
echo "<h>count is :".$count. "</h></br>";

foreach($model as $vivek){
echo $vivek->image_path;echo"</br>";	
echo "<img src='".$vivek->image_path."'>";



}

?>
<?= Html::a('Previous', ['/signup/show-images','page'=>$previous], ['class'=>'btn btn-primary']) ?>

<?= Html::a('Next', ['/signup/show-images','page'=>$next], ['class'=>'btn btn-primary']) ?>
