<?php
namespace app\models;

use yii\db\ActiveRecord;

class Quiz extends ActiveRecord
{
    public static function tableName() { return '{{%quiz}}'; }

    public function getOptions()
    {
        return $this->hasMany(QuizOption::class, ['quiz_id' => 'id'])->orderBy('sort_order ASC');
    }

    public function getCorrectOption()
    {
        return $this->hasOne(QuizOption::class, ['quiz_id' => 'id'])->where(['is_correct' => 1]);
    }

    public static function getForLesson($lessonId)
    {
        return static::find()->where(['lesson_id' => $lessonId, 'active' => 1])->with('options')->all();
    }
}
