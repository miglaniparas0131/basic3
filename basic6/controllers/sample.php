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
use app\models\MakerCheckerConfig;
use app\models\Posts;
use app\models\UserForm;
use yii\web\CookieCollection;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

class FormpController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','preview','checker','process_tables','success'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                // 'actions' => [
                //     'logout' => ['post'],
                // ],
            ],
        ];
    }


public function actionChecker()
{
	$this->layout='checkerLayout';	
	if(Yii::$app->user->identity->user_type=="checker")
	{
	$checkername = Yii::$app->user->identity->name;
	$sql="SELECT * FROM information_schema.tables WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA='doingITeasy'";
	$tables = Yii::$app->db->createCommand($sql)->queryAll();
	$size=sizeof($tables);
	for($i=0;$i<$size;$i++)
	{
		$tbl[$i]=$tables[$i]['TABLE_NAME'];
	}
	return $this->render('checker',['tbl'=>$tbl,'size'=>$size,'checkername'=>$checkername]);
	}
	else
	{
		throw new ForbiddenHttpException;
	}
	
}

public function actionProcess_checker($name,$checkername)
{
	$this->layout='checkerLayout';	

	//echo "hello";
	$sql='SELECT * from {{'.$name.'}} WHERE [[status]]="pending"';
	$records = Yii::$app->db->createCommand($sql)->queryAll();
	$length = sizeof($records);
	return $this->render('process_checker',['name'=>$name,'records'=>$records,'length'=>$length,'checkername'=>$checkername]);
}

public function actionApprove($id,$table_name,$checkername)
{
	$this->layout='checkerLayout';	

	$date=date("Y/m/d");
    date_default_timezone_set('Asia/Kolkata');
    $date_array = getdate();
    $hours=$date_array['hours'];
    $minutes=$date_array['minutes'];
    $seconds=$date_array['seconds'];	
	$time =($hours.":".$minutes.":".$seconds);

	$sql='UPDATE {{'.$table_name.'}} SET [[status]]="approve",[[checkername]]="'.$checkername.'",[[checker_date]]="'.$date.'",[[checker_time]]="'.$time.'" where [[id]]="'.$id.'"';
	$result=Yii::$app->db->createCommand($sql)->execute();
	if($result){
		return $this->render('result',['output'=>'Approved']);
	}else{
		return $this->render('result',['output'=>'Don"t refresh this page again']);
	}
}

public function actionDisapprove($id,$table_name,$checkername)
{
	$this->layout='checkerLayout';	

	$date=date("Y/m/d");
    date_default_timezone_set('Asia/Kolkata');
    $date_array = getdate();
    $hours=$date_array['hours'];
    $minutes=$date_array['minutes'];
    $seconds=$date_array['seconds'];	
	$time =($hours.":".$minutes.":".$seconds);

	$sql='UPDATE {{'.$table_name.'}} SET [[status]]="disapprove",[[checkername]]="'.$checkername.'",[[checker_date]]="'.$date.'",[[checker_time]]="'.$time.'" where [[id]]="'.$id.'"';

	//$sql='UPDATE {{'.$table_name.'}} SET [[status]]="disapprove",[[checkername]]="'.$checkername.'" where [[id]]="'.$id.'"';
	$result=Yii::$app->db->createCommand($sql)->execute();
	if($result){
		return $this->render('result',['output'=>'Disapproved']);
	}else{
		return $this->render('result',['output'=>'Don"t refresh this page again']);
	}
}

public function actionPreview()
{
		$this->layout='makerLayout';
		if(Yii::$app->user->identity->user_type=="maker")
		{
		$makername=Yii::$app->user->identity->name;
		//echo "</br></br></br></br>".$makername;	
		$sql='SELECT [[table_name]] from {{maker_checker_config}} WHERE [[is_active]]="active"';
		$tables = Yii::$app->db->createCommand($sql)->queryAll();
		$length = sizeof($tables);
		return $this->render('preview',['tables'=>$tables,'len'=>$length,'makername'=>$makername]);
		}
		else
		{
			throw new ForbiddenHttpException;
		}
	

}

public function actionPreviewmaker($name,$makername)
{
	$this->layout='makerLayout';
   	$sql='SELECT [[allowed_attribute_config]] from {{maker_checker_config}} WHERE [[is_active]]="active" AND [[table_name]]="'.$name.'"';
	$data=Yii::$app->db->createCommand($sql)->queryAll();
	$detail = $data[0]['allowed_attribute_config'];
	$detail = str_replace("{","",$detail);
	$detail = str_replace("}","",$detail);
	
	$myArray = explode(',', $detail);

	$length=sizeof($myArray);
	return $this->render('maker',['myArray'=>$myArray,'length'=>$length,'tablename'=>$name,'makername'=>$makername]);
}


public function actionMaker()
{
	//$this->layout='makerLayout';
	$tablename="company";
	$sql='SELECT [[allowed_attribute_config]] from {{maker_checker_config}} WHERE [[is_active]]="active" AND [[table_name]]="'.$tablename.'"';
	$data=Yii::$app->db->createCommand($sql)->queryAll();
	$detail = $data[0]['allowed_attribute_config'];
	$detail = str_replace("{","",$detail);
	$detail = str_replace("}","",$detail);
	$myArray = explode(',', $detail);
	$length=sizeof($myArray);
	return $this->render('maker',['myArray'=>$myArray,'length'=>$length,'tablename'=>$tablename]);
}

public function actionSubmit_maker($length,$myArray,$tablename)
{

	$this->layout='makerLayout';

	$myArray=Json::decode($myArray);
	$fieldname="";
    $fieldvalue="";
    $connection=Yii::$app->db;
	for($i=0;$i<$length;$i++)
	{
		$myArray2=$myArray[$i];
		$keyValue = explode(':', $myArray2);
		$id="id{$i}";
		echo $keyValue[0]."--".$_POST[$id]."</br>";
		$fieldname.="[[".$keyValue[0]."]]";
        $fieldvalue.="'".$_POST[$id]."'";
        if($i==($length-1)){

        }else{
        	$fieldname.=',';
        	$fieldvalue.=",";	
        }
	}
	echo $fieldname."--".$fieldvalue;
	$makername=$_POST['makername'];

	$date=date("Y/m/d");
    date_default_timezone_set('Asia/Kolkata');
    $date_array = getdate();
    $hours=$date_array['hours'];
    $minutes=$date_array['minutes'];
    $seconds=$date_array['seconds'];
		
	$time =($hours.":".$minutes.":".$seconds);

	$sql="INSERT INTO {{".$tablename."}} (".$fieldname.",[[makername]],[[date]],[[time]]) VALUES (".$fieldvalue.",'".$makername."','".$date."','".$time."')";

	$connection->createCommand($sql)->execute();

	return $this->redirect(['success']);
}

public function actionSuccess()
{
	$this->layout='makerLayout';
	if(Yii::$app->request->referrer=="http://localhost/basic5/web/index.php?r=site%2Flogin")
	{
		return $this->redirect(['preview']);
	}

	return $this->render('success');
}


public function actionIndex()
{
	$this->layout='adminLayout';
	if(Yii::$app->user->identity->user_type=="admin"){
	$sql="SELECT * FROM information_schema.tables WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA='doingITeasy'";
	$tables = Yii::$app->db->createCommand($sql)->queryAll();
	$size=sizeof($tables);
	for($i=0;$i<$size;$i++)
	{
		$tbl[$i]=$tables[$i]['TABLE_NAME'];
	}
	return $this->render('index',['tbl'=>$tbl,'size'=>$size]);		
	}
	else
	{
		throw new ForbiddenHttpException;
	}

}

public function actionSubmit_tables()
{
	//$this->layout='adminLayout';	
	if(!empty($_POST['check_list'])) 
	{
		$size=sizeof($_POST['check_list']);

		for($i=0;$i<$size;$i++){
			$tble[$i]=$_POST['check_list'][$i];
		}
		$tble=Json::encode($tble);

		return Yii::$app->response->redirect(['formp/process_tables','tble'=>$tble,'size'=>$size,'index'=>0]);
	}
	else
	{
	echo "u did not select any";
	}
}

	
	public function actionProcess_tables($tble,$size,$index)
	{
		$this->layout='adminLayout';
		//get the previous url 
		if(Yii::$app->request->referrer=="http://localhost/basic5/web/index.php?r=site%2Flogin")
		{
			return $this->redirect(['index']);
		}

		if(Yii::$app->user->identity->user_type=="admin")
		{

			echo '</br></br></br>';
			echo Yii::$app->request->referrer."</br>";
			echo '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';
			echo '<nav id="w1" class="navbar-inverse navbar-fixed-top navbar" role="navigation"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w1-collapse"><span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span></button><a class="navbar-brand" href="/basic5/web/index.php?r=formp%2Findex">Admin Page</a></div><div id="w1-collapse" class="collapse navbar-collapse"><ul id="w2" class="navbar-nav navbar-right nav">
			<li><form class="navbar-form" action="/basic5/web/index.php?r=site%2Flogout" method="post"><button type="submit" class="btn btn-link">Logout(<span id="login_id">'.Yii::$app->user->identity->name.'</span>)</button></form></li></ul></div></div></nav>
			';
		//echo Yii::$app->basePath;
		//require_once Yii::$app->basePath . '/views/layouts/main.php';
			//$this->layout='adminLayout';
		if($size==$index)
		{
			return $this->render('thanks');
		}
		else
		{

			// echo $tble."</br>".$index;

			$tble=Json::decode($tble);

			$sql = 'SHOW FULL COLUMNS FROM ' . $this->quoteSimpleTableName($tble[$index]);

			// array_shift($tble);
			$tble=Json::encode($tble);

    		$columns = Yii::$app->db->createCommand($sql)->queryAll();
    		$data = sizeof($columns);
    		$form=ActiveForm::begin(['method' => 'get','id'=>'formID']);
    		//new addition
    		echo '<input id="new_param" type="hidden" name="index" value="'.$index.'";>';
    		// $form = ActiveForm::begin(['action' =>['formp/process_tables','tble'=>$tble,'size'=>$size,'index'=>$index+1], 'method' => 'post']);
    		
    		$new_index=0;
    		for($i=0;$i<sizeof($columns);$i++) 
    		{
    			if($columns[$i]['Field']=="makername")
    			{

    			}
    			else
    			{
    			$col[$new_index]=$columns[$i]['Field'];
    			$checkbox="checkbox{$i}";
    			echo '<table><tr>';

    			echo '<td>';
    			echo '<input id="'.$checkbox.'" type="checkbox" name="check_lists[]" value="'.$columns[$i]["Field"].'"><label>'.$columns[$i]['Field'].'</label>';
    			echo '</td>';
				$validation_dropdown="validation_dropdown{$i}";
				//echo '<div class="form-control">';
				echo '<td>';
    			echo '<select id="'.$validation_dropdown.'" ;>';
    			echo "<option value='select variant'>select variant</option>";
    			echo "<option value='email'>email</option>";
    			echo "<option value='phone_number'>phone_number</option>";
    			echo "<option value='password'>password</option>";
    			echo "<option value='null'>null</option>";
    			echo "</select>";
    			echo '</td>';
    			echo '</tr></table>';
    		 	//echo '</div>';
    			echo "</br>";
    			echo "</br>";
    			$new_index=$new_index+1;		
    			}

    		}
    		echo '</table>';
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
	else
	{
		throw new ForbiddenHttpException;
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

 	public function actionSavedata($field,$validation,$tablename,$admin_name)
    {	
    $myfields = json_decode($field);
    $myvalidations = json_decode($validation);
    $mysize = sizeof($myfields);
    $myfinal_json='{';
   	for($u=0;$u<$mysize;$u++)
   	{
  		$myfinal_json.=$myfields[$u];
  		$myfinal_json.=':';
  		$myfinal_json.=$myvalidations[$u];
  		if($u==($mysize-1)){

  		}else{
     	$myfinal_json.=',';
  		}
 	}
 	$myfinal_json.='}';
 	$model = MakerCheckerConfig::find()->where(['table_name'=>$tablename,'is_active'=>"active"])->one();

 	if($model)
 	{
   	    $model->is_active ="deactive";
   	    $model->save(); 
    }
     	$model_insert = new MakerCheckerConfig();	
    	$model_insert->allowed_attribute_config  = $myfinal_json;
    	$model_insert->table_name = $tablename;
    	$model_insert->admin_name = $admin_name;
    	$model_insert->date=date("Y/m/d");
    	date_default_timezone_set('Asia/Kolkata');
    	$date_array = getdate();
    	$hours=$date_array['hours'];
    	$minutes=$date_array['minutes'];
    	$seconds=$date_array['seconds'];
		
		$model_insert->time =($hours.":".$minutes.":".$seconds);
    	 
    	// $model_insert->time=date("h:i:sa");
    	$model_insert->is_active ="active";
    	$model_insert->save();
    }


    // public function actionSavedata($field,$validation,$tablename)
    // {	
    // 	echo $field."</br>";
    // 	echo $validation."</br>".$tablename;
    // 	//$this->enableCsrfValidation=false;
    	
    // 	// echo $param;
    // 	// $connection=Yii::$app->db;
    // 	// $detail="[["."details"."]],[["."is_status"."]]";
    // 	// $fieldvalue="'".$ar."','"."true"."'";

    // 	// $tbname="makercheckerConfig";
    // 	// $sql="INSERT INTO {{".$tbname."}} (".$detail.") VALUES (".$fieldvalue.")";

    // 	// // $sql="INSERT INTO {{makercheckerConfig}} (".$detail.",".$status") VALUES ('".$ar."',".$x.")";
    // 	// $connection->createCommand($sql)->execute();
    // 	// echo "saved";
    // }

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

		var admin_name=document.getElementById("login_id").innerHTML;
		alert(admin_name);

		var tablename=table[0][index-1];
		//array_shift(table[0]);
		//alert(tablename);
		//index=index+1;
		// table[0].shift();
		

      	$.ajax({
                type: 'GET',
                url: 'index.php?r=formp/savedata',
                data:{'field':JSON.stringify(field),'validation':JSON.stringify(validation),'tablename':tablename,'admin_name':admin_name},
                success: function (datas){
                //table[0].shift();
                //alert(table[0]);
                $('form').attr('action','index.php?r=formp/process_tables&tble=['+table[0]+']&size='+size+'&index='+index);	
                //alert('index.php?r=formp/process_tables&tble=["'+'goods","'+'images"]&size='+size+'&index='+index);
                //$('form').attr('action','index.php?r=formp/process_tables&tble=["'+'goods","'+'images"]&size='+size+'&index='+index);
                //$('form').append('<input type="hidden" name="tble" value="'+table[0]+'" />');
                //$('form').attr('tble',table[0]);
                document.getElementById("new_param").value = index;
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

