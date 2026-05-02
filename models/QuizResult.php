<?php
namespace app\models;

use yii\db\ActiveRecord;

class QuizResult extends ActiveRecord
{
    public static function tableName() { return '{{%quiz_result}}'; }
}
