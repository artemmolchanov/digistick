<?php

use yii\db\Migration;

/**
 * Handles the creation of table `email`.
 */
class m171003_083729_create_email_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('email', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('email');
    }
}
