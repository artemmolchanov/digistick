<?php

use yii\db\Migration;

class m170919_053135_add_stickerpack_position extends Migration
{
    public function safeUp()
    {
        $this->addColumn('sticker-pack', 'position', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('sticker-pack', 'position');
    }
}
