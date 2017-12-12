<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class BuildForm
 *
 * @package app\models
 */
class EmailForm extends ActiveRecord
{
    public static function tableName()
    {
        return 'email';
    }

    public function attributeLabels()
    {
        return [
          'email' => 'email'
        ];
    }

    public function rules()
    {
        return [
            [['email'], 'email'],
        ];
    }
}
