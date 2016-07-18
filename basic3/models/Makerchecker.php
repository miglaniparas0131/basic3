<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "makerchecker".
 *
 * @property integer $id
 * @property integer $concerned_id
 * @property string $table_name
 * @property string $action
 */
class Makerchecker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'makerchecker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['concerned_id', 'table_name'], 'required'],
            [['concerned_id'], 'integer'],
            [['table_name'], 'string', 'max' => 200],
            [['action'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'concerned_id' => 'Concerned ID',
            'table_name' => 'Table Name',
            'action' => 'Action',
        ];
    }
}
