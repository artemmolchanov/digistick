<?php

use yii\db\Migration;

class m170831_177754_change_price_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('sticker-pack', 'price', 'float');
    }
}
