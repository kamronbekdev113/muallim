<?php
use yii\db\Migration;

class m260316_100002_create_letter_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%arabic_letter}}', [
            'id'              => $this->primaryKey(),
            'letter'          => $this->string(10)->notNull(),
            'name_uz'         => $this->string(50)->notNull(),
            'transliteration' => $this->string(20)->notNull()->defaultValue(''),
            'isolated'        => $this->string(10)->notNull()->defaultValue(''),
            'initial'         => $this->string(10)->notNull()->defaultValue(''),
            'medial'          => $this->string(10)->notNull()->defaultValue(''),
            'final'           => $this->string(10)->notNull()->defaultValue(''),
            'pronunciation_note' => $this->text()->null(),
            'examples_json'   => $this->text()->null(),
            'audio_url'       => $this->string(255)->defaultValue(''),
            'sort_order'      => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createTable('{{%letter_combination}}', [
            'id'               => $this->primaryKey(),
            'letter_ids'       => $this->string(50)->notNull()->defaultValue(''),
            'combo_text'       => $this->string(20)->notNull(),
            'pronunciation'    => $this->string(100)->notNull()->defaultValue(''),
            'example_word'     => $this->string(50)->notNull()->defaultValue(''),
            'example_meaning'  => $this->string(100)->notNull()->defaultValue(''),
            'sort_order'       => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%letter_combination}}');
        $this->dropTable('{{%arabic_letter}}');
    }
}
