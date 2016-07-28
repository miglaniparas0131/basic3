<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Users;

class UsersController extends Controller{

	public function actionIndex(){
		//go to users table and get all the values from here
		$users=Users::find()->all();
		//print_r($users);
		return $this->render('index',['users'=>$users]);
	} 
}
?>