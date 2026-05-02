<?php
use yii\db\Migration;

class m260316_100007_create_quiz_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%quiz}}', [
            'id'          => $this->primaryKey(),
            'lesson_id'   => $this->integer()->null(),
            'type'        => "ENUM('multiple','translate','audio','fill') NOT NULL DEFAULT 'multiple'",
            'question_uz' => $this->text()->notNull(),
            'question_ar' => $this->text()->null(),
            'xp_reward'   => $this->integer()->notNull()->defaultValue(10),
            'difficulty'  => $this->tinyInteger()->notNull()->defaultValue(1),
            'active'      => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ]);

        $this->createTable('{{%quiz_option}}', [
            'id'         => $this->primaryKey(),
            'quiz_id'    => $this->integer()->notNull(),
            'text_uz'    => $this->string(200)->notNull()->defaultValue(''),
            'text_ar'    => $this->string(200)->notNull()->defaultValue(''),
            'is_correct' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
        ]);
        $this->addForeignKey('fk_option_quiz', '{{%quiz_option}}', 'quiz_id', '{{%quiz}}', 'id', 'CASCADE');

        $this->createTable('{{%quiz_result}}', [
            'id'          => $this->primaryKey(),
            'user_id'     => $this->integer()->notNull(),
            'quiz_id'     => $this->integer()->notNull(),
            'is_correct'  => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'user_answer' => $this->string(200)->defaultValue(''),
            'xp_earned'   => $this->integer()->notNull()->defaultValue(0),
            'answered_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_result_user', '{{%quiz_result}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_result_quiz', '{{%quiz_result}}', 'quiz_id', '{{%quiz}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_result_quiz', '{{%quiz_result}}');
        $this->dropForeignKey('fk_result_user', '{{%quiz_result}}');
        $this->dropTable('{{%quiz_result}}');
        $this->dropForeignKey('fk_option_quiz', '{{%quiz_option}}');
        $this->dropTable('{{%quiz_option}}');
        $this->dropTable('{{%quiz}}');
    }
}
