<?php

use yii\db\Migration;

class m250221_111341_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->string(16),
            'name' => $this->string(64)->unique()->notNull(),
            'first_name' => $this->string(32)->notNull(),
            'last_name' => $this->string(32)->notNull(),
            'team_id' => $this->string(16)->notNull(),
            'birthdate' => $this->date(),
            'PRIMARY KEY(`id`)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');

        return false;
    }
}
