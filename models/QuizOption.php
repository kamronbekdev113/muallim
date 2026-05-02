<?php
namespace app\models;

use yii\db\ActiveRecord;

class QuizOption extends ActiveRecord
{
    public static function tableName() { return '{{%quiz_option}}'; }

    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }
}
