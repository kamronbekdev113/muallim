<?php
namespace app\models;

use yii\db\ActiveRecord;

class Vocabulary extends ActiveRecord
{
    public static function tableName() { return '{{%vocabulary}}'; }

    public function getExamples()
    {
        if (!$this->examples_json) return [];
        return json_decode($this->examples_json, true) ?? [];
    }

    public static function getByCategory($category)
    {
        return static::find()->where(['category' => $category])->orderBy('id ASC')->all();
    }
}
