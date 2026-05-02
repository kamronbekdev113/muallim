<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserProgress extends ActiveRecord
{
    public static function tableName() { return '{{%user_progress}}'; }

    public static function markComplete($userId, $contentId, $contentType)
    {
        $existing = static::findOne(['user_id' => $userId, 'content_id' => $contentId, 'content_type' => $contentType]);
        if ($existing) {
            if (!$existing->completed) {
                $existing->completed = 1;
                $existing->completed_at = time();
                $existing->save(false);
            }
            return false; // already existed
        }
        $p = new static();
        $p->user_id = $userId;
        $p->content_id = $contentId;
        $p->content_type = $contentType;
        $p->completed = 1;
        $p->completed_at = time();
        $p->save(false);
        return true; // newly completed
    }
}
