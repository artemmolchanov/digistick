<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sticker-pack`.
 * Has foreign keys to the tables:
 *
 * - `stickerPack`
 */
class m170831_060811_create_sticker_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sticker-pack', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
            'price' => $this->float()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sticker-pack');
    }
}
