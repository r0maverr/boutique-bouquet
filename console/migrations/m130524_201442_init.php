<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /*
         * USERS
         * */

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'registration_type' => $this->smallInteger(1)->notNull(),
            'name' => $this->string(31)->notNull(),
            'phone' => $this->integer()->unique(),
            'email' => $this->string(31)->unique(),
            'socialID' => $this->string(31)->unique(),
            'password_hash' => $this->string(),
            'status' => $this->smallInteger(1),
        ], $tableOptions);

        /*
         * TOKENS
         * */

        $this->createTable('tokens', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger(1),
            'value' => $this->string(63)->notNull(),
        ], $tableOptions);
        $this->addForeignKey('FK_users_tokens', 'tokens', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        /*
         * SETTINGS
         * */

        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'alias' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->string()->notNull()
        ]);

        /*
         * REQUESTS LOGS
         * */

        $this->createTable('requests_logs', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'controller' => $this->string()->notNull(),
            'action' => $this->string()->notNull(),
            'method' => $this->string()->null(),
            'request' => $this->text()->null(),
            'response' => $this->text()->null(),
            'error' => $this->text()->null(),
            'device' => $this->text()->null(),
            'timestamp' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('tokens');
        $this->dropTable('users');

        $this->dropTable('settings');
        $this->dropTable('requests_logs');
    }
}
