<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "sticker-pack".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $image
 * @property mixed   stickers
 */
class StickerPack extends \yii\db\ActiveRecord
{
    public $image;
    public $gallery;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'position',
            ],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'price',
            'stickers' => function()
            {
                return $this->stickers5;

            },
            'quantity' => function()
            {
                return count($this->stickers);
            },
            'position'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sticker-pack';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',  'price'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'required'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg, gif', 'maxFiles' => 50],

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
            'price' => 'Price',
            'description' => 'Description',
            'image' => 'Main Sticker',
            'gallery' => 'Stickers',
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $path = 'uploads/store/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function uploadGallery()
    {
        if ($this->validate()) {
            foreach ($this->gallery as $file) {
                if (!file_exists("uploads/store/{$this->id}/")) {
                    mkdir("uploads/store/{$this->id}/", "755");
                }

                $path = "uploads/store/{$this->id}/" . $file->name ;
                $file->saveAs($path);

                $sticker = new Sticker();
                $sticker->stickerpack_id = $this->id;
                $sticker->filename = $path;
                $sticker->save();
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStickers5()
    {
        return $this->hasMany(Sticker::className(), ['stickerpack_id' => 'id'])
                    ->orderBy('position')
                    ->limit(5);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStickers()
    {
        return $this->hasMany(Sticker::className(), ['stickerpack_id' => 'id'])
            ->orderBy('position');
    }
}
