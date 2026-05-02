<?php
namespace app\models;

use yii\db\ActiveRecord;

class MuallimiChapter extends ActiveRecord
{
    public static function tableName() { return '{{%muallimi_chapter}}'; }

    public function getLessons()
    {
        return $this->hasMany(MuallimiLesson::class, ['chapter_id' => 'id'])->orderBy('sort_order ASC');
    }

    public static function getAllActive()
    {
        return static::find()->where(['active' => 1])->orderBy('sort_order ASC')->all();
    }

    public function getLessonCount()
    {
        return MuallimiLesson::find()->where(['chapter_id' => $this->id, 'active' => 1])->count();
    }
}
