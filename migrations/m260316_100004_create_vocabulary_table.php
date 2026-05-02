<?php
use yii\db\Migration;

class m260316_100004_create_vocabulary_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%vocabulary}}', [
            'id'             => $this->primaryKey(),
            'word_ar'        => $this->string(100)->notNull(),
            'root'           => $this->string(20)->defaultValue(''),
            'transliteration' => $this->string(100)->defaultValue(''),
            'translation_uz' => $this->string(200)->notNull(),
            'category'       => $this->string(50)->defaultValue('general'),
            'difficulty'     => $this->tinyInteger()->notNull()->defaultValue(1),
            'lesson_id'      => $this->integer()->null(),
            'examples_json'  => $this->text()->null(),
            'audio_url'      => $this->string(255)->defaultValue(''),
        ]);
        $this->createIndex('idx_vocab_category', '{{%vocabulary}}', 'category');
    }

    public function down()
    {
        $this->dropTable('{{%vocabulary}}');
    }
}
