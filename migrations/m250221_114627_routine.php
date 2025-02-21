<?php

use yii\db\Migration;

class m250221_114627_routine extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%routine}}', [
            'id' => $this->primaryKey(),
            'team_id' => $this->string(16)->notNull(),
            'channel' => $this->string(32)->notNull(),
            'class' => $this->string(128)->notNull(),
            'timezone' => $this->string(32)->notNull(),
            'expression' => $this->string(32)->notNull(),
            'config' => $this->text()->notNull(),
            'UNIQUE KEY(`team_id`, `channel`, `class`, `timezone`, `expression`)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%routine}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250221_114627_schedule cannot be reverted.\n";

        return false;
    }
    */
}
