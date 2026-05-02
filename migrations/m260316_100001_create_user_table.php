<?php
use yii\db\Migration;

class m260316_100001_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id'            => $this->primaryKey(),
            'username'      => $this->string(50)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'auth_key'      => $this->string(32)->notNull(),
            'access_token'  => $this->string(40)->notNull()->unique(),
            'full_name'     => $this->string(100)->notNull()->defaultValue(''),
            'email'         => $this->string(100)->defaultValue(''),
            'role'          => "ENUM('student','admin') NOT NULL DEFAULT 'student'",
            'xp'            => $this->integer()->notNull()->defaultValue(0),
            'streak'        => $this->integer()->notNull()->defaultValue(0),
            'last_active'   => $this->date()->null(),
            'active'        => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_user_username', '{{%user}}', 'username');
        $this->createIndex('idx_user_role', '{{%user}}', 'role');
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
