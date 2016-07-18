<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

echo "<b><h1>Your account details</h1></b>";


?>

 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'username',
            'password',
            'email',
            	[
    		'attribute'=>'photo',
    		'value'=>$model->profile_pic,
    		'format' => ['image',['width'=>'100','height'=>'100']],
				],
        ],
    ]) ?>


