<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName() { return '{{%user}}'; }

    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_key', 'access_token'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['full_name', 'email'], 'string', 'max' => 200],
            [['role'], 'in', 'range' => ['student', 'admin']],
            [['xp', 'streak'], 'integer', 'min' => 0],
        ];
    }

    // IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'active' => 1]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'active' => 1]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'active' => 1]);
    }

    public function getId() { return $this->id; }
    public function getAuthKey() { return $this->auth_key; }
    public function validateAuthKey($authKey) { return $this->auth_key === $authKey; }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString(40);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // XP & Levels
    public function getLevelInfo()
    {
        $levels = Yii::$app->params['levels'];
        $current = $levels[0];
        foreach ($levels as $level) {
            if ($this->xp >= $level['min_xp']) {
                $current = $level;
            }
        }
        return $current;
    }

    public function getNextLevel()
    {
        $levels = Yii::$app->params['levels'];
        $found = false;
        foreach ($levels as $level) {
            if ($found) return $level;
            if ($this->xp >= $level['min_xp']) $found = true;
        }
        return null;
    }

    public function getLevelProgress()
    {
        $current = $this->getLevelInfo();
        $next = $this->getNextLevel();
        if (!$next) return 100;
        $range = $next['min_xp'] - $current['min_xp'];
        if ($range <= 0) return 0;
        $earned = $this->xp - $current['min_xp'];
        return min(100, (int)($earned / $range * 100));
    }

    public function updateXp($amount)
    {
        $this->xp += $amount;
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        if ($this->last_active === $today) {
            // already counted today
        } elseif ($this->last_active === $yesterday) {
            $this->streak += 1;
        } else {
            $this->streak = 1;
        }
        $this->last_active = $today;
        $this->save(false);
    }

    // Relations
    public function getProgresses()
    {
        return $this->hasMany(UserProgress::class, ['user_id' => 'id']);
    }

    public function hasCompleted($contentId, $contentType)
    {
        return UserProgress::find()
            ->where(['user_id' => $this->id, 'content_id' => $contentId, 'content_type' => $contentType, 'completed' => 1])
            ->exists();
    }
}
