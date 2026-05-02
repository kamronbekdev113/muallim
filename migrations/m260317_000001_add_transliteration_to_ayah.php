<?php

use yii\db\Migration;

class m260317_000001_add_transliteration_to_ayah extends Migration
{
    public function up()
    {
        $this->addColumn('{{%ayah}}', 'transliteration', $this->text()->null()->after('text_tajweed'));
        // Move existing transliteration data (stored in text_tajweed) to new column
        $this->execute("UPDATE {{%ayah}} SET transliteration = text_tajweed, text_tajweed = NULL WHERE text_tajweed IS NOT NULL");
    }

    public function down()
    {
        $this->execute("UPDATE {{%ayah}} SET text_tajweed = transliteration WHERE transliteration IS NOT NULL");
        $this->dropColumn('{{%ayah}}', 'transliteration');
    }
}
