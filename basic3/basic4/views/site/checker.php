<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//$this->title = $model->post_id;
//$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div >


<?php
    foreach($model as $name=>$value)
    {
        echo "<h1><b>".$name. "-->".$value."</b></h1></br>";
    }
  	echo $modelname;  
?>

<?= Html::a('Approve', ['/site/approval','modelname'=>$modelname,'id'=>$model->id], ['class'=>'btn btn-primary']) ?>

<?= Html::a('Disapprove', ['/site/disapproval','modelname'=>$modelname,'id'=>$model->id], ['class'=>'btn btn-primary']) ?>

</div>
