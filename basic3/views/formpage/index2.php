<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Locations;
//use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>



<div >

    
    <?php
    for($x=0;$x<$data;$x++) echo $columns[$x]['Field'].":<input type='text' name=".$columns[$x]['Field']."></br>";
     
    ?>
   

    

</div>


  