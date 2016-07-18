<?php

namespace app\controllers;

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


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        //separate layout ofor login
        //$this->layout='loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    //work begins here

    public function actionHello()
    {
        $this->layout='helloLayout';
        $name="Paras Miglani";
        return $this->render('hello',array('name'=>$name));
    }

    public function actionUser()
    {
        $model=new UserForm;
        //check if the user has submiited the model and validate it
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            Yii::$app->session->setFlash('success','You have entered the data correctly');
        }
        
        return $this->render('userForm',['model'=>$model]);
            
    }

    public function actionSetCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
        'name' => 'paro1',
        'value' => 'paro microtime',
        ]));
    }

    public function actionShowCookie()
    {
        if(Yii::$app->getRequest()->getCookies()->has('paro1')){
            print_r(Yii::$app->getRequest()->getCookies()->getValue('paro1'));
        }else{
            print_r("Sorry the cookie named paro1 is not set");
        }
    }

    public function actionMaker()
    {
        $this->layout='makercheckerLayout';
        return $this->render('maker');
    }

    
    public function actionChecker()
    {
        $model=Makerchecker::find()->where(['action'=>'False'])->all();
        return $this->render('testing',['model'=>$model]);
        //print_r($model);
        // $tablename="";
        // if($modelname=="Customers"){
        //     $data=Customers::findOne($id);
        //     // $tablename="customers";
        // }else if($modelname=="Posts"){
        //     $data=Posts::findOne($id);
        //     // $tablename="posts";
        // }
        // $this->layout='makercheckerLayout';
        // return $this->render('checker',['model'=>$data,'modelname'=>$modelname]);
    }

    protected function findData($id,$modelname)
    {
        $data=$modelname::findOne($id);
        return $data;
    }

    public function actionApproval($modelname,$id)
    {
        $this->layout='makercheckerLayout';
        if($modelname=="Posts")
        $model=Posts::findOne($id);
        else if($modelname=="Customers")
        $model=Customers::findOne($id);
        $model->approve="True";
        $model->rejected="False";
        $model->save();

    }

    public function actionDisapproval($modelname,$id)
    {
        $this->layout='makercheckerLayout';
        if($modelname=="Posts")
        $model=Posts::findOne($id);
        else if($modelname=="Customers")
        $model=Customers::findOne($id);

        $model->approve="False";
        $model->rejected="True";
        $model->save();
    }

    // public function actionFinale($id,$table_name){
    //     if($table_name=="customers"){
    //         $model=Customers::findOne($id);
    //         $model->approve="True";
    //         $model->rejected="False";
    //         //var_dump($model);
    //         $model2=Makerchecker::find()->where(['concerned_id'=>$id,'table_name'=>$table_name])->one();
    //         $model2->approve="True";
    //         $model2->save();    
    //     }
    // }

    public function actionFinale($id,$table_name){
        return $this->redirect(['final','id'=>$id,'table_name'=>$table_name]);
        }

    public function actionFinal($id,$table_name){
        if($table_name=="customers"){
            $model=Customers::findOne($id);
        }else if($table_name=="posts"){
            $model=Posts::findOne($id);
        }
        return $this->render('final',['table_name'=>$table_name,'model'=>$model]);
    }

    public function actionApprove($id,$table_name){
        if($table_name=='customers'){
            $model=Customers::findOne($id);
            $model->approve="True";
            $model->rejected="False";
            $model->save();
        }else if($table_name=='posts'){
            $model=Posts::findOne($id);
            $model->approve="True";
            $model->rejected="False";
            $model->save();
        }
        $model2=Makerchecker::find()->where(['concerned_id'=>$id,'table_name'=>$table_name])->one();
        $model2->action="True";
        $model2->save();
    }    

        public function actionDisapprove($id,$table_name){
        if($table_name=='customers'){
            $model=Customers::findOne($id);
            $model->approve="False";
            $model->rejected="True";
            $model->save();
        }
        else if($table_name=='posts'){
            $model=Posts::findOne($id);
            $model->approve="False";
            $model->rejected="True";
            $model->save();
        }
        $model2=Makerchecker::find()->where(['concerned_id'=>$id,'table_name'=>$table_name])->one();
        $model2->action="True";
        $model2->save();
    }

}
