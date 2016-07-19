<?php

namespace app\controllers;

//namespace yii\db\mysql;
//use yii\db\Expression;
use Yii;
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
use app\models\TableType;
//use yii\db\TableSchema;
//use yii\db\TableSchema;
//use yii\db\ColumnSchema;

class FormpageController extends Controller
{
    public function actionIndex()
    {
        $model=TableType::find()->all();

        return $this->render('index',['model'=>$model]);

    }

    public function getRawTableName($name)
    {
        if (strpos($name, '{{') !== false) {
            $name = preg_replace('/\\{\\{(.*?)\\}\\}/', '\1', $name);
            return str_replace('%', $this->db->tablePrefix, $name);
        } else {
            return $name;
        }
    }


    public function actionGetdetails()
    {


        $db = Yii::$app->db;
        $realName = $this->getRawTableName('person');

        echo $realName;
                //$sql = 'SHOW FULL COLUMNS FROM ' .'company';
                $sql = 'SHOW FULL COLUMNS FROM ' . $this->quoteSimpleTableName('person');

                $columns = Yii::$app->db->createCommand($sql)->queryAll();
                $data = sizeof($columns);
                // for($x=0;$x<$data;$x++){
                //     echo $columns[$x]['Field']." ".$columns[$x]['Type']."</br>";
                // }
                return $this->render('index2',['columns'=>$columns,'data'=>$data]);
                //print_r($columns[0]['Field']);
                //$datas=(Json::encode($columns));
                //echo var_dump($datas);
                //print_r($datas);
                // foreach($datas as $x) {
                //     echo $x['Field'];
                // }
                //var_dump($columns);
                //echo($columns);
        // $cxn = mysql_connect('localhost','root','mysqlserver');
        // $q = mysql_query('SHOW FULL COLUMNS FROM posts;');
        // if($q){
        //     echo "sahi";
        // }else{
        //     echo "galat";
        // }
        // while($row = mysql_fetch_array($q)) {
        // echo "{$row['Field']} - {$row['Type']}\n";
        // }
    }

    public function actionGotoform($name)
    {
        $sql = 'SHOW FULL COLUMNS FROM ' . $this->quoteSimpleTableName($name);

        $columns = Yii::$app->db->createCommand($sql)->queryAll();
        $data = sizeof($columns);

       // $columns=Json::encode($columns);
                // for($x=0;$x<$data;$x++){
                //     echo $columns[$x]['Field']." ".$columns[$x]['Type']."</br>";
                // }
        return $this->render('index2',['columns'=>$columns,'data'=>$data,'name'=>$name]);
        //echo $columns[0]['Field'];
       // return $columns;
    }

    public function actionSubmitdetail()
    {
        $fieldname="";
        $fieldvalue="";
        $connection=Yii::$app->db;
        for($x=0;$x<sizeof($_POST['result'])-1;$x++){
            $fieldname.="[[".$_POST['fields'][$x]."]]";
            $fieldname.=',';
            $fieldvalue.="'".$_POST['result'][$x]."'";
            $fieldvalue.=",";
        }
        $fieldname.="[[".$_POST['fields'][$x]."]]";
        $fieldvalue.="'".$_POST['result'][$x]."'";
        $sql="INSERT INTO {{".$_POST['table_name']."}} (".$fieldname.") VALUES (".$fieldvalue.")";

        //echo $sql; 
        $connection->createCommand($sql)->execute();
        ///var_dump($_POST['result']);
        return $this->render('submitdetail',['data'=>$_POST['result'],'fields'=>$_POST['fields'],'table_name'=>$_POST['table_name'],'string'=>$sql]);
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


