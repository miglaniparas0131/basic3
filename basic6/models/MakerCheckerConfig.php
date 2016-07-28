<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maker_checker_config".
 *
 * @property integer $id
 * @property string $allowed_attribute_config
 * @property string $table_name
 * @property string $is_active
 * @property string $admin_name
 * @property string $date
 * @property string $time
 */
class MakerCheckerConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maker_checker_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allowed_attribute_config', 'table_name', 'is_active', 'admin_name', 'date', 'time'], 'required'],
            [['allowed_attribute_config', 'is_active'], 'string'],
            [['date'], 'safe'],
            [['table_name', 'admin_name', 'time'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'allowed_attribute_config' => 'Allowed Attribute Config',
            'table_name' => 'Table Name',
            'is_active' => 'Is Active',
            'admin_name' => 'Admin Name',
            'date' => 'Date',
            'time' => 'Time',
        ];
    }
}
