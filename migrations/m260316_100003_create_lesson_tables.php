<?php
use yii\db\Migration;

class m260316_100003_create_lesson_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%muallimi_chapter}}', [
            'id'          => $this->primaryKey(),
            'number'      => $this->integer()->notNull(),
            'title_uz'    => $this->string(150)->notNull(),
            'description_uz' => $this->text()->null(),
            'icon'        => $this->string(50)->defaultValue('book'),
            'sort_order'  => $this->integer()->notNull()->defaultValue(0),
            'active'      => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ]);

        $this->createTable('{{%muallimi_lesson}}', [
            'id'             => $this->primaryKey(),
            'chapter_id'     => $this->integer()->notNull(),
            'number'         => $this->integer()->notNull(),
            'title_uz'       => $this->string(200)->notNull(),
            'content_uz'     => $this->text()->null(),
            'arabic_text'    => $this->text()->null(),
            'transliteration' => $this->text()->null(),
            'translation_uz' => $this->text()->null(),
            'audio_url'      => $this->string(255)->defaultValue(''),
            'xp_reward'      => $this->integer()->notNull()->defaultValue(20),
            'sort_order'     => $this->integer()->notNull()->defaultValue(0),
            'active'         => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ]);
        $this->addForeignKey('fk_lesson_chapter', '{{%muallimi_lesson}}', 'chapter_id', '{{%muallimi_chapter}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_lesson_chapter', '{{%muallimi_lesson}}');
        $this->dropTable('{{%muallimi_lesson}}');
        $this->dropTable('{{%muallimi_chapter}}');
    }
}
