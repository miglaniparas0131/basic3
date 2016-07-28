<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $location
 * @property string $company_type
 * @property string $phone_number
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'location', 'company_type', 'phone_number'], 'required'],
            [['name', 'email', 'company_type'], 'string', 'max' => 400],
            [['location'], 'string', 'max' => 500],
            [['phone_number'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'location' => 'Location',
            'company_type' => 'Company Type',
            'phone_number' => 'Phone Number',
        ];
    }
}
