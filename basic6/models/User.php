<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $password
 * @property string $user_type
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public $username;
    
    // public $password;
   
   // public $id;
    public $authKey;
    public $accessToken;

    // public $user_id;
    // public $password;
    // public $name;
    // public $user_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    // public function rules()
    // {
    //     return [
    //         [['user_id'], 'required'],
    //         [['user_id'],'match','pattern'=>'/^[A-Za-z0-9_]+$/u','message'=> 'Username can contain only [a-zA-Z0-9_].'],
    //         [['name', 'password', 'user_type'], 'string', 'max' => 50],
    //     ];
    // }

    /**
     * @inheritdoc
     */
    // public function rules()
    // {
    //     return [
    //         [['user_id'], 'required'],
    //         [['user_id'], 'integer'],
    //         [['name', 'password', 'user_type'], 'string', 'max' => 50],
    //     ];
    // }

    /**
     * @inheritdoc
     */
    // public function attributeLabels()
    // {
    //     return [
    //         'user_id' => 'User ID',
    //         'name' => 'Name',
    //         'password' => 'Password',
    //         'user_type' => 'User Type',
    //     ];
    // }
    public static function findIdentity($id) {
    $dbUser = User::find()
            ->where([
                "id" => $id
            ])
            ->one();
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

/**
 * @inheritdoc
 */
public static function findIdentityByAccessToken($token, $userType = null) {

    $dbUser = User::find()
            ->where(["accessToken" => $token])
            ->one();
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

/**
 * Finds user by username
 *
 * @param  string      $username
 * @return static|null
 */
public static function findByUsername($username) {

    $dbUser = User::find()
            ->where([
                "user_id" => $username
            ])
            ->one();
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

/**
 * @inheritdoc
 */
public function getId() {
    return $this->id;
}

/**
 * @inheritdoc
 */
public function getAuthKey() {
    return $this->authKey;
}

/**
 * @inheritdoc
 */
public function validateAuthKey($authKey) {
    return $this->authKey === $authKey;
}

/**
 * Validates password
 *
 * @param  string  $password password to validate
 * @return boolean if password provided is valid for current user
 */
public function validatePassword($password) {
    return $this->password === $password;
}

}
