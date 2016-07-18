<?php

namespace app\controllers;

use yii\rest\ActiveController;

class UsController extends ActiveController
{
	public $modelClass='app\models\Us';

	public function actionIndex()
	{
		echo "Welcome here";
	}
}

?>