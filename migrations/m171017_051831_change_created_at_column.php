<?php

use yii\db\Migration;

class m171017_051831_change_created_at_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('token', 'created_at', 'datetime');
    }
}
