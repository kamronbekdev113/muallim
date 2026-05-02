<?php
namespace app\models;

use yii\db\ActiveRecord;

class MuallimiLesson extends ActiveRecord
{
    public static function tableName() { return '{{%muallimi_lesson}}'; }

    public function getChapter()
    {
        return $this->hasOne(MuallimiChapter::class, ['id' => 'chapter_id']);
    }

    public function getQuizzes()
    {
        return $this->hasMany(Quiz::class, ['lesson_id' => 'id']);
    }

    public function getPrevLesson()
    {
        return static::find()
            ->where(['chapter_id' => $this->chapter_id, 'active' => 1])
            ->andWhere(['<', 'sort_order', $this->sort_order])
            ->orderBy('sort_order DESC')
            ->one();
    }

    public function getNextLesson()
    {
        return static::find()
            ->where(['chapter_id' => $this->chapter_id, 'active' => 1])
            ->andWhere(['>', 'sort_order', $this->sort_order])
            ->orderBy('sort_order ASC')
            ->one();
    }
}
