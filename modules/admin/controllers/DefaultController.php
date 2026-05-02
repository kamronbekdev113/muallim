<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\User;
use app\models\ArabicLetter;
use app\models\MuallimiLesson;
use app\models\TajweedRule;
use app\models\Surah;
use app\models\Quiz;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Dashboard';
        $stats = [
            'users'    => User::find()->count(),
            'letters'  => ArabicLetter::find()->count(),
            'lessons'  => MuallimiLesson::find()->count(),
            'tajweed'  => TajweedRule::find()->count(),
            'surahs'   => Surah::find()->count(),
            'quizzes'  => Quiz::find()->count(),
        ];
        $recentUsers = User::find()->orderBy('created_at DESC')->limit(5)->all();
        return $this->render('index', compact('stats', 'recentUsers'));
    }
}
