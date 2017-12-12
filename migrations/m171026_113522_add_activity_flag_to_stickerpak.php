<?php

use yii\db\Migration;

class m171026_113522_add_activity_flag_to_stickerpak extends Migration
{
    public function safeUp()
    {
        $this->addColumn('sticker-pack', 'is_active', $this->boolean() . " DEFAULT 0");
    }

    public function safeDown()
    {
        $this->dropColumn('sticker_pack', 'is_active');
    }
}
