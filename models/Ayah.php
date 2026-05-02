<?php
namespace app\models;

use yii\db\ActiveRecord;

class Ayah extends ActiveRecord
{
    public static function tableName() { return '{{%ayah}}'; }

    public function getSurah()
    {
        return $this->hasOne(Surah::class, ['id' => 'surah_id']);
    }
}
