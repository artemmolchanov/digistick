<?php

namespace app\models;

use Yii;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "stickers".
 *
 * @property integer $id
 * @property integer $stickerpack_id
 * @property string $filename
 * @property integer $position
 *
 * @property Sticker-pack $stickerpack
 */
class Sticker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stickers';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'position',
                'groupAttributes' => [
                    'stickerpack_id' // multiple lists varying by 'categoryId'
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stickerpack_id', 'position'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['stickerpack_id'], 'exist', 'skipOnError' => true, 'targetClass' => StickerPack::className(), 'targetAttribute' => ['stickerpack_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stickerpack_id' => 'Stickerpack ID',
            'filename' => 'Filename',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStickerpack()
    {
        return $this->hasOne(StickerPack::className(), ['id' => 'stickerpack_id']);
    }
}
