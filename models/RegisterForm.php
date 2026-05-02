<?php
namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $full_name;
    public $email;
    public $password;
    public $password_confirm;

    public function rules()
    {
        return [
            [['username', 'password', 'password_confirm'], 'required', 'message' => 'Bu maydon majburiy.'],
            ['username', 'string', 'min' => 3, 'max' => 50],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Faqat harf, raqam va _ belgisi.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Bu nom band.'],
            ['email', 'email', 'message' => 'Email noto\'g\'ri.'],
            ['password', 'string', 'min' => 6, 'message' => 'Parol kamida 6 belgi.'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Parollar mos emas.'],
            [['full_name', 'email'], 'string', 'max' => 200],
            [['full_name', 'email'], 'default', 'value' => ''],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Foydalanuvchi nomi',
            'full_name' => 'To\'liq ism',
            'email' => 'Email',
            'password' => 'Parol',
            'password_confirm' => 'Parolni tasdiqlang',
        ];
    }

    public function register()
    {
        if (!$this->validate()) return false;

        $user = new User();
        $user->username = $this->username;
        $user->full_name = $this->full_name;
        $user->email = $this->email;
        $user->role = 'student';
        $user->xp = 0;
        $user->streak = 0;
        $user->active = 1;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->created_at = time();
        $user->updated_at = time();

        if ($user->save()) {
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return true;
        }
        return false;
    }
}
