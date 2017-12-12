<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purchase`.
 */
class m171003_084126_create_purchase_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('purchase', [
            'id' => $this->primaryKey(),
            'token' => $this->string(),
            'itemId' => $this->integer(),
            'bought' => $this->boolean(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('purchase');
    }
}
