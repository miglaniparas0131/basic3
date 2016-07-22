<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "table_type".
 *
 * @property integer $id
 * @property string $table_name
 */
class TableType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'table_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name'], 'required'],
            [['table_name'], 'string', 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
        ];
    }
}
