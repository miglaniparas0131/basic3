<?php
namespace app\controllers;
session_start();
use Yii;
use app\models\Signup;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Session;
use yii\web\UploadedFile;
use app\models\Images;

class SignupController extends Controller
{

    //public $hello="he";
    // public $session = new Session;

    
	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionCreate()
	{
        $this->layout='makercheckerLayout';

        $_SESSION["favcolor"]=null;

		$model=new Signup();

		$model->scenario = 'create';

		$model->creation_date=date('Y:m:d');
		$model->creation_time=time();
   

		if ($model->load(Yii::$app->request->post()) && $model->validate() ) 
		{    

            $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $model->password=$hash;
            $model->confirm_password=$hash;

            $imageName=$model->username;
            //get the instance of uploaded file
            $model->file=UploadedFile::getInstance($model,'file');
            $model->file->saveAs('uploads/'.$imageName.'.'.$model->file->extension);

            //save the path in db column
            $model->profile_pic='uploads/'.$imageName.'.'.$model->file->extension;

            $coverName=$model->username;

            $model->file2=UploadedFile::getInstance($model,'file2');
            $model->file2->saveAs('cover/'.$coverName.'.'.$model->file->extension);

            $model->cover_pic='cover/'.$coverName.'.'.$model->file->extension;

            $_SESSION["favcolor"]="green"; 

            $model->save();
            
            return $this->redirect(['view','id'=>$model->user_id]);
            
        }
        else 
        {
            $_SESSION["favcolor"]=null;
            return $this->render('create', [
                'model' => $model,
                
            ]);
        }
		
	}

	public function actionLogin()
	{
        // $x=session_start();

        $_SESSION["favcolor"]=null;

        
        // Start the session
        // session_start();
            // $session->open();
        if($_SESSION)
        {
        $model=new Signup();
        
        $model->scenario = 'login';

        if($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            $username=$model->username;
            //echo $username;
            $password=$model->password;
            //echo $password;
            $DataInDb = Signup::find()
                        ->where(['username' => $username])
                        ->one();

            // $hash=$DataInDb->password;           
                        

            if ($DataInDb!=NULL && Yii::$app->getSecurity()->validatePassword($password, $DataInDb->password)) 
            {
                        // $DataInDbcount = Signup::find()
                        // ->where(['username' => $username,'password'=>$hash])
                        // ->count();

                        // $DataInDb = Signup::find()
                        // ->where(['username' => $username,'password'=>$hash])
                        // ->one();

                        //              if($DataInDbcount>0)
                        //            {










                                        $hash=$DataInDb->password;
                                        $model->password=$hash;
                                        $model->email=$DataInDb->email;
                                        $model->user_id=$DataInDb->user_id;

                                        // Set session variables
                                        $_SESSION["favcolor"] = "green";
                                        return $this->redirect(['view','id'=>$model->user_id]);
                                    // }
                                    // else
                                    // {
                                    //     return $this->render('login',[
                                    //     'model' => $model,
                                    //     ]);             
                                    // }
           
   
            }
            else
            {
                                    $_SESSION["favcolor"]=null;
                                    return $this->render('login',[
                                     'model' => $model,
                                         ]);                
            }
        }
        else
        {   
            $_SESSION["favcolor"]=null;

            return $this->render('login',[
                    'model' => $model,
                ]);
        }

        }


	}

	public function actionView($id)
	{

        if ($_SESSION["favcolor"]!==NULL){
                return $this->render('view',
                ['model'=>$this->findModel($id),
                ]);

        }
        else{
            return $this->render('guest');
        }

		// return $this->render('view',
		// 	['model'=>$this->findModel($id),
  //           ]);
	}

    protected function findModel($id)
    {
        if(($model = Signup::findOne($id))!==null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist');
        }
    }



    //image show
    public function actionShowImages($page=1)
    {
        $model=new Images;
        $offset=(($page-1)*3);
        $limit=3;
        $model = Images::find()
            ->limit($limit)
            ->offset($offset)
            ->all();
        //$model=Images::find()->all();
        $count=Images::find()->count();
       return $this->render('showimage',['model'=>$model,'count'=>$count,'pageno'=>$page]);
    }



}