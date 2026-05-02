<?php
use yii\db\Migration;

class m260316_100008_create_progress_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_progress}}', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer()->notNull(),
            'content_id'   => $this->integer()->notNull(),
            'content_type' => "ENUM('lesson','letter','tajweed') NOT NULL DEFAULT 'lesson'",
            'completed'    => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'completed_at' => $this->integer()->null(),
        ]);
        $this->addForeignKey('fk_progress_user', '{{%user_progress}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->createIndex('idx_progress_unique', '{{%user_progress}}', ['user_id', 'content_id', 'content_type'], true);
    }

    public function down()
    {
        $this->dropForeignKey('fk_progress_user', '{{%user_progress}}');
        $this->dropTable('{{%user_progress}}');
    }
}
