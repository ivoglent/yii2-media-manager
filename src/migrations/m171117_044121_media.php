<?php

use yii\db\Migration;

/**
 * Class m171117_044121_media
 */
class m171117_044121_media extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $table = file_get_contents(dirname(__FILE__) . '/media.sql');
        $this->db->createCommand()->execute($table);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('media');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171117_044121_media cannot be reverted.\n";

        return false;
    }
    */
}
