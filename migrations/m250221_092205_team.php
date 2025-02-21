<?php

use yii\db\Migration;

class m250221_092205_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team}}', [
            'id' => $this->string(16),
            'domain' => $this->string(64)->unique()->notNull(),
            'token' => $this->string(60)->unique()->notNull(),
            'bot_token' => $this->string(60)->unique()->notNull(),
            'PRIMARY KEY(`id`)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%team}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250221_092205_team cannot be reverted.\n";

        return false;
    }
    */
}
