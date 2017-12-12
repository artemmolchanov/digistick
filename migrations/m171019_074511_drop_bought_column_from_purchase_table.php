<?php

use yii\db\Migration;

/**
 * Handles dropping bought from table `purchase`.
 */
class m171019_074511_drop_bought_column_from_purchase_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('purchase', 'bought');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('purchase', 'bought', $this->integer());
    }
}
