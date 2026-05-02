<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\UserProgress;
use app\models\QuizResult;
use app\models\MuallimiChapter;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return ['access' => ['class' => AccessControl::class, 'rules' => [
            ['allow' => true, 'roles' => ['@']],
        ]]];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $chapters = MuallimiChapter::getAllActive();

        $completedLessons = UserProgress::find()
            ->where(['user_id' => $user->id, 'content_type' => 'lesson', 'completed' => 1])
            ->count();
        $completedLetters = UserProgress::find()
            ->where(['user_id' => $user->id, 'content_type' => 'letter', 'completed' => 1])
            ->count();
        $totalQuizzes = QuizResult::find()->where(['user_id' => $user->id])->count();
        $correctQuizzes = QuizResult::find()->where(['user_id' => $user->id, 'is_correct' => 1])->count();

        return $this->render('index', compact('user', 'chapters', 'completedLessons', 'completedLetters', 'totalQuizzes', 'correctQuizzes'));
    }
}
