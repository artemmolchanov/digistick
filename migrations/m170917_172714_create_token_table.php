<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 */
class m170917_172714_create_token_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('token', [
            'id' => $this->primaryKey(),

            'token' => $this->string()->notNull()->unique(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
}

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('token');
    }
}
