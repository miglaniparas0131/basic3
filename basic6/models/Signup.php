<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "signup".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $confirm_password
 * @property string $email
 * @property string $creation_date
 * @property string $creation_time
 */
class Signup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //for login
    public $pasword;

    public $file;

    public $file2;



    public static function tableName()
    {
        return 'signup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirm_password', 'email'], 'required','on'=>'create'],
            [['creation_date', 'creation_time'], 'safe','on'=>'create'],
            [['username', 'password', 'confirm_password'], 'string', 'max' => 255,'on'=>'create'],
            [['email'], 'string', 'max' => 100,'on'=>'create'],
            [['username'], 'unique','on'=>'create'],
            [['email'],'email','on'=>'create'],
            [['file'],'file','on'=>'create'],
            [['profile_pic'],'string','max'=>500,'on'=>'create'],
            [['file2'],'file','on'=>'create'],
            [['cover_pic'],'string','max'=>500,'on'=>'create'],
            ['password','compare','compareAttribute'=>'confirm_password','on'=>'create'],
            [['username', 'password'], 'required','on'=>'login'],
            [['username', 'password'], 'string', 'max' => 255,'on'=>'login'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'email' => 'Email',
            'creation_date' => 'Creation Date',
            'creation_time' => 'Creation Time',
            'file' =>'Profile Pic',
            'file2'=>'Cover Pic',
        ];
    }
}
