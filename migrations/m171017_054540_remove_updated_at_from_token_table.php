<?php

use yii\db\Migration;

class m171017_054540_remove_updated_at_from_token_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('token', 'updated_at');
    }

    public function safeDown()
    {
        $this->addColumn('token', 'updated_at', 'datetime');
    }
}
