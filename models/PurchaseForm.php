<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 03.10.2017
 * Time: 13:32
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property array|mixed itemId
 * @property array|mixed token
 */
class PurchaseForm extends ActiveRecord
{
    public static function tableName()
    {
        return 'purchase';
    }

    public function attributeLabels()
    {
        return [
            'token' => 'token',
            'itemId' => 'itemId',
        ];
    }

    public function rules()
    {
        return [
            [['token', 'itemId'], 'required'],
        ];
    }
}