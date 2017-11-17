<?php

use yii\db\Migration;

/**
 * Class m171118_044111_media
 */
class m171118_044112_create_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $table = file_get_contents(dirname(__FILE__) . '/media.sql');
        return $this->db->createCommand($table)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return $this->dropTable('media');
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $table = file_get_contents(dirname(__FILE__) . '/media.sql');
        return $this->db->createCommand($table)->execute();
    }

    public function down()
    {
        return $this->dropTable('media');
    }

}
