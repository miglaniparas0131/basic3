<?php

namespace app\models;

use Yii;


class AddMakerChecker extends \yii\db\ActiveRecord
{

    public $user_id;

    public $name;

    public $password;

    public $user_type;

    public function rules()
    {
        return [
            [['user_id', 'name', 'password', 'user_type'], 'required'],
            [['user_id', 'password','name', 'user_type'], 'string', 'max' => 255],
            [['user_id'],'match','pattern'=>'/^[A-Za-z0-9_]+$/u','message'=> 'Username can contain only [a-zA-Z0-9_].'],
            ['user_id', 'string', 'length' => [5, 24]],
        ];
    }

}


