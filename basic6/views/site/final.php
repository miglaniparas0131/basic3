<?php
use yii\helpers\Html;

foreach ($model as $x=>$y) {
	echo "<div class='row'>".$x."==>".$y."</div></br>";
}

?>

<?= Html::a('Approve', ['/site/approve','id'=>$model->id,'table_name'=>$table_name], ['class'=>'btn btn-primary']) ?>
<?= Html::a('Disapprove', ['/site/disapprove','id'=>$model->id,'table_name'=>$table_name], ['class'=>'btn btn-primary']) ?>

