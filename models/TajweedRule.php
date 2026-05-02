<?php
namespace app\models;

use yii\db\ActiveRecord;

class TajweedRule extends ActiveRecord
{
    public static function tableName() { return '{{%tajweed_rule}}'; }

    public static function getAllActive()
    {
        return static::find()->where(['active' => 1])->orderBy('sort_order ASC')->all();
    }

    public static function getByCategory($category)
    {
        return static::find()->where(['category' => $category, 'active' => 1])->orderBy('sort_order ASC')->all();
    }

    public function getCategoryLabel()
    {
        $labels = [
            'madd' => 'Madd (Cho\'zilish)',
            'ghunna' => 'Ghunna (Burun tovushi)',
            'qalqala' => 'Qalqala (Titroq)',
            'ikhfa' => 'Ikhfa (Yashirish)',
            'idgham' => 'Idgham (Singdirish)',
            'iqlab' => 'Iqlab (Almashtirish)',
            'izhar' => 'Izhar (Aniq o\'qish)',
            'other' => 'Boshqa qoidalar',
        ];
        return $labels[$this->category] ?? $this->category;
    }
}
