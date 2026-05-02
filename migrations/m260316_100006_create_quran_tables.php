<?php
use yii\db\Migration;

class m260316_100006_create_quran_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%surah}}', [
            'id'              => $this->primaryKey(),
            'number'          => $this->integer()->notNull()->unique(),
            'name_ar'         => $this->string(50)->notNull(),
            'name_uz'         => $this->string(100)->notNull(),
            'name_en'         => $this->string(100)->notNull()->defaultValue(''),
            'ayah_count'      => $this->integer()->notNull(),
            'revelation_type' => "ENUM('makki','madani') NOT NULL DEFAULT 'makki'",
            'bismillah_pre'   => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'description_uz'  => $this->text()->null(),
        ]);

        $this->createTable('{{%ayah}}', [
            'id'           => $this->primaryKey(),
            'surah_id'     => $this->integer()->notNull(),
            'number'       => $this->integer()->notNull(),
            'text_uthmani' => $this->text()->notNull(),
            'text_tajweed' => $this->text()->null(),
            'translation_uz' => $this->text()->null(),
            'juz'          => $this->tinyInteger()->notNull()->defaultValue(1),
            'page'         => $this->smallInteger()->notNull()->defaultValue(1),
        ]);
        $this->addForeignKey('fk_ayah_surah', '{{%ayah}}', 'surah_id', '{{%surah}}', 'id', 'CASCADE');
        $this->createIndex('idx_ayah_surah', '{{%ayah}}', ['surah_id', 'number']);
    }

    public function down()
    {
        $this->dropForeignKey('fk_ayah_surah', '{{%ayah}}');
        $this->dropTable('{{%ayah}}');
        $this->dropTable('{{%surah}}');
    }
}
