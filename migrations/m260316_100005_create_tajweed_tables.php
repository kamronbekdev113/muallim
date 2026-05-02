<?php
use yii\db\Migration;

class m260316_100005_create_tajweed_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%tajweed_rule}}', [
            'id'              => $this->primaryKey(),
            'name_uz'         => $this->string(100)->notNull(),
            'name_ar'         => $this->string(100)->notNull()->defaultValue(''),
            'description_uz'  => $this->text()->notNull(),
            'color_code'      => $this->string(10)->notNull()->defaultValue('#FFD700'),
            'css_class'       => $this->string(30)->notNull()->defaultValue(''),
            'symbol'          => $this->string(40)->defaultValue(''),
            'example_ar'      => $this->text()->null(),
            'example_translation' => $this->text()->null(),
            'category'        => "ENUM('madd','ghunna','qalqala','ikhfa','idgham','iqlab','izhar','other') NOT NULL DEFAULT 'other'",
            'sort_order'      => $this->integer()->notNull()->defaultValue(0),
            'active'          => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%tajweed_rule}}');
    }
}
