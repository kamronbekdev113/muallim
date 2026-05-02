<?php
namespace app\models;

use yii\db\ActiveRecord;

class ArabicLetter extends ActiveRecord
{
    public static function tableName() { return '{{%arabic_letter}}'; }

    public function getExamples()
    {
        if (!$this->examples_json) return [];
        return json_decode($this->examples_json, true) ?? [];
    }

    public static function getAllOrdered()
    {
        return static::find()->orderBy('sort_order ASC')->all();
    }
}
