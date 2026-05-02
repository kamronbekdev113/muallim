<?php
namespace app\models;

use yii\db\ActiveRecord;

class Surah extends ActiveRecord
{
    public static function tableName() { return '{{%surah}}'; }

    public function getAyahs()
    {
        return $this->hasMany(Ayah::class, ['surah_id' => 'id'])->orderBy('number ASC');
    }

    public static function getAllOrdered()
    {
        return static::find()->orderBy('number ASC')->all();
    }
}
