<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Customers;
use app\models\Makerchecker;
use app\models\Posts;
use app\models\UserForm;
use yii\web\CookieCollection;
use yii\helpers\Json;

class FormpController extends Controller
{

public function actionIndex()
{
	$sql="SELECT * FROM information_schema.tables WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA='doingITeasy'";
	//echo "hello";
	// $sql="SELECT *
	// FROM INFORMATION_SCHEMA.TABLES
	// WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='doingITeasy'";	
	 //$sql="SELECT * FROM sys.Tables";
	$tables = Yii::$app->db->createCommand($sql)->queryAll();
	$size=sizeof($tables);
	for($i=0;$i<$size;$i++){
		$tbl[$i]=$tables[$i]['TABLE_NAME'];
		//echo $tables[$i]['TABLE_NAME']."</br>";
	}
	return $this->render('index',['tbl'=>$tbl,'size'=>$size]);
	// echo $size;
	//var_dump($tables[0]['TABLE_NAME']);
}

public function actionSubmit_tables()
{	
	if(!empty($_POST['check_list'])) 
	{
		$size=sizeof($_POST['check_list']);
		//echo $size;
		// foreach($_POST['check_list'] as $selected) 
		// {
		// echo "<p>".$selected ."</p>";
		// }
		for($i=0;$i<$size;$i++){
			$tble[$i]=$_POST['check_list'][$i];

			// $sql = 'SHOW FULL COLUMNS FROM ' . $this->quoteSimpleTableName($tbl[$i]);
			// $columns[$i] = Yii::$app->db->createCommand($sql)->queryAll();

			//echo $tbl[$i]."</br>";
		}
		$tble=Json::encode($tble);

		return Yii::$app->response->redirect(['formp/process_tables','tble'=>$tble,'size'=>$size,'index'=>0]);



		//return $this->redirect(['']);
	}
	else
	{
	echo "u did not select any";
	}
	

}

	
	public function actionProcess_tables($tble,$size,$index){



		$tble=Json::decode($tble);
		//echo $tble[1];
		//var_dump($tble);
		$sql = 'SHOW FULL COLUMNS FROM ' . $this->quoteSimpleTableName($tble[$index]);

		$tble=Json::encode($tble);

        $columns = Yii::$app->db->createCommand($sql)->queryAll();
        $data = sizeof($columns);
        $form = ActiveForm::begin(['action' =>['formp/process_tables','tble'=>$tble,'size'=>$size,'index'=>$index+1], 'method' => 'post']);
        for($i=0;$i<sizeof($columns);$i++) 
        {
        	$col[$i]=$columns[$i]['Field'];
        	echo '<input id="po" type="checkbox" name="check_lists[]" value="'.$columns[$i]["Field"].'"><label>'.$columns[$i]['Field'].'</label>';
			$validation_dropdown="validation_dropdown{$i}";
        	echo '<select id="'.$validation_dropdown.'" ;>';
        	echo "<option value='select variant'>select variant</option>";
        	echo "<option value='email'>email</option>";
        	echo "<option value='phone_number'>phone_number</option>";
        	echo "<option value='password'>password</option>";
        	echo "<option value='null'>null</option>";
        	echo "</select>";
        	echo "</br>";
        }
        $col=Json::encode($col);

        

        echo Html::submitButton('Submit',['class'=>'btn btn-success','onClick'=>'foo('.$tble.','.$index.','.$col.');']);	

		ActiveForm::end();		

	}




    public function quoteSimpleTableName($name)
    {
         return strpos($name, '`') !== false ? $name : "`$name`";
    }

        public function quoteSimpleColumnName($name)
    {
        return strpos($name, '`') !== false || $name === '*' ? $name : "`$name`";
    }

}


?>

<script>
function bar()
{
var y = $('.msgCheckbox:checked').val();
alert(y);
}
function foo(tble,index,col){
  var x = document.getElementById("po").checked;
  if(x)
  alert(document.getElementById("po").value);
  else
  alert(x);	

//alert('hello');


// $.get('index.php?r=formp/gotoform',{name:name},function(data){

// 	});

	
}

</script>

