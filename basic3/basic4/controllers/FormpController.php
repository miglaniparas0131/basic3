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
	$tables = Yii::$app->db->createCommand($sql)->queryAll();
	$size=sizeof($tables);
	for($i=0;$i<$size;$i++)
	{
		$tbl[$i]=$tables[$i]['TABLE_NAME'];
	}
	return $this->render('index',['tbl'=>$tbl,'size'=>$size]);
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

		if($size==$index)
		{
			return $this->render('thanks');
		}
		else
		{
			echo $tble."</br>".$index;

			$tble=Json::decode($tble);

			$sql = 'SHOW FULL COLUMNS FROM ' . $this->quoteSimpleTableName($tble[$index]);

			$tble=Json::encode($tble);

    		$columns = Yii::$app->db->createCommand($sql)->queryAll();
    		$data = sizeof($columns);
    		$form=ActiveForm::begin(['method' => 'get','id'=>'formID']);
    		// $form = ActiveForm::begin(['action' =>['formp/process_tables','tble'=>$tble,'size'=>$size,'index'=>$index+1], 'method' => 'post']);
    		for($i=0;$i<sizeof($columns);$i++) 
    		{
    			$col[$i]=$columns[$i]['Field'];
    			$checkbox="checkbox{$i}";
    			echo '<input id="'.$checkbox.'" type="checkbox" name="check_lists[]" value="'.$columns[$i]["Field"].'"><label>'.$columns[$i]['Field'].'</label>';
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

    		//echo Html::submitButton('Submit',['class'=>'btn btn-success','id'=>'paras','onClick'=>'foo('.$tble.','.$index.','.$col.','.$data.');']);	

    		// echo '<button id="paras" onClick="bar('.$tble.','.($index+1).','.$col.','.$data.','.$size.')">go</button>';

    		// echo '<button id="paras" onClick="bar()">go</button>';

			ActiveForm::end();	

			//echo '<button id="paras" onClick="bar('.$tble.','.($index+1).','.$col.','.$data.','.$size.')">go</button>';
			echo $tble;	
			//$h="hellooooo";
			//$tble=Json::encode($tble);

			echo '<button id="paras" onClick=bar(['.$tble.'],['.$col.'],"'.($index+1).'","'.$data.'","'.$size.'")>go</button>';

			print_r($tble);


		}

	}




    public function quoteSimpleTableName($name)
    {
         return strpos($name, '`') !== false ? $name : "`$name`";
    }

        public function quoteSimpleColumnName($name)
    {
        return strpos($name, '`') !== false || $name === '*' ? $name : "`$name`";
    }
 	
 	public function beforeAction($action){
 		$this->enableCsrfValidation=false;
 		return parent::beforeAction($action);	
 	}

    public function actionSavedata($field,$validation,$tablename)
    {
    	echo $field."</br>";
    	echo $validation."</br>".$tablename;
    	//$this->enableCsrfValidation=false;
    	
    	// echo $param;
    	// $connection=Yii::$app->db;
    	// $detail="[["."details"."]],[["."is_status"."]]";
    	// $fieldvalue="'".$ar."','"."true"."'";

    	// $tbname="makercheckerConfig";
    	// $sql="INSERT INTO {{".$tbname."}} (".$detail.") VALUES (".$fieldvalue.")";

    	// // $sql="INSERT INTO {{makercheckerConfig}} (".$detail.",".$status") VALUES ('".$ar."',".$x.")";
    	// $connection->createCommand($sql)->execute();
    	// echo "saved";
    }

}


?>

<div id="shukla"></div>





 <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
function bar(table,col,index,data,size)
{
		var i=0,c=0;
		var field=[],validation=[];
		for(i=1;i<=data;i++)
		{
			var check="checkbox".concat((i-1).toString());
			var valid="validation_dropdown".concat((i-1).toString());
			var x=document.getElementById(check).checked;
			if(x){
				field[c]=document.getElementById(check).value;
				validation[c]=document.getElementById(valid).value;
				c++;
			}
			else{

			}	

		}

		var tablename=table[0][index-1];
		//alert(tablename);
		//index=index+1;
      	$.ajax({
                type: 'GET',
                url: 'index.php?r=formp/savedata',
                data:{'field':JSON.stringify(field),'validation':JSON.stringify(validation),'tablename':tablename},
                success: function (datas){
                alert('index.php?r=formp/process_tables&tble=['+table[0]+']&size='+size+'&index='+index);
                $('form').attr('action','index.php?r=formp/process_tables&tble=['+table[0]+']&size='+size+'&index='+index);
                //$('form').append('<input type="hidden" name="tble" value="'+table[0]+'" />');
                //$('form').attr('tble',table[0]);
                $('form').submit();
                $('#shukla').html(datas);
                 alert('successfully invoked function!');
                },
				error: function() { 
 				alert("data");
  				}


            });
            
}


      	//alert("hellos");
      	//	$.get('index.php?r=formp/savedata',{name:"name"},function(data){
      	//	alert("hi");
      		//console.log("hi");	
      //  });
    //});
    //}); 
    </script>


<script  type="text/javascript">

function foo(tble,index,col,data){
	var i=0,c=0;
	var field=[],validation=[];
	for(i=1;i<=data;i++)
	{
		var check="checkbox".concat((i-1).toString());
		var valid="validation_dropdown".concat((i-1).toString());
		var x=document.getElementById(check).checked;
		if(x){
			field[c]=document.getElementById(check).value;
			validation[c]=document.getElementById(valid).value;
			c++;
		}
		else{

		}	

	}

}




	// $.ajax({
 //   		type: 'GET',
 //    	url: location.origin + '/basic4/web/index.php?r=formp/savedata',
 //   			 data: 
 //   			 {
 //   			 	'param': 'haan bhai'

 //   			// 	// _csrf:'<?= Yii::$app->request->getCsrfToken()?>'
 //   			 },
 //   			// dataType: 'json',
	// 		success:function(data){

 //                //alert("dbata");
 //                console.log("data");

 //              },
 //   			error: function() { // if error occured
 //         //alert(location.origin);
 //         //alert(data);
 //         console.log("error occured");
 //    },
 
 //  //dataType:'html'
 //  });


	//var tablename=tble[index];
	//alert(validation);

	// $.get('index.php?r=formp/savedata',{field:field},function(data){
	// alert(data);
	//var data=$.parseJSON(data);
	//$('#shukla').html(data);
	//$('#customers-province').attr('value',data.province);
	//alert(data);
	// });

	//alert(field);


	


</script>

