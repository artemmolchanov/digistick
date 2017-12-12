<?php

use yii\db\Migration;

class m171009_090333_add_new_images_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('stickers', [
            'id' => $this->primaryKey(),
            'stickerpack_id' => $this->integer(),
            'filename' => $this->string(),
            'position' => $this->integer(),
        ]);

        $this->addForeignKey(
            'sticker__stickerpack_fk',
            'stickers',
            'stickerpack_id',
            'sticker-pack',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('stickers');
    }
}
