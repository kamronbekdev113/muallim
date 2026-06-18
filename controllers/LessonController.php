<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\MuallimiChapter;
use app\models\MuallimiLesson;
use app\models\ArabicLetter;
use app\models\UserProgress;

class LessonController extends Controller
{
    public function actionIndex()
    {
        $chapters = MuallimiChapter::getAllActive();
        $completed = [];
        if (!Yii::$app->user->isGuest) {
            $rows = UserProgress::find()
                ->where(['user_id' => Yii::$app->user->id, 'content_type' => 'lesson', 'completed' => 1])
                ->select('content_id')->column();
            $completed = array_flip($rows);
        }
        // Harflar bosqichi progressi
        $letterTotal = (int)ArabicLetter::find()->count();
        $letterDone = 0;
        if (!Yii::$app->user->isGuest) {
            $letterDone = (int)UserProgress::find()
                ->where(['user_id' => Yii::$app->user->id, 'content_type' => 'letter', 'completed' => 1])
                ->count();
        }
        return $this->render('index', compact('chapters', 'completed', 'letterTotal', 'letterDone'));
    }

    public function actionChapter($chapter)
    {
        $ch = MuallimiChapter::findOne(['number' => $chapter, 'active' => 1]);
        if (!$ch) throw new NotFoundHttpException();
        $lessons = MuallimiLesson::find()->where(['chapter_id' => $ch->id, 'active' => 1])->orderBy('sort_order ASC')->all();
        $completed = [];
        if (!Yii::$app->user->isGuest) {
            $rows = UserProgress::find()
                ->where(['user_id' => Yii::$app->user->id, 'content_type' => 'lesson', 'completed' => 1])
                ->select('content_id')->column();
            $completed = array_flip($rows);
        }
        return $this->render('chapter', compact('ch', 'lessons', 'completed'));
    }

    public function actionView($id)
    {
        $lesson = MuallimiLesson::findOne(['id' => $id, 'active' => 1]);
        if (!$lesson) throw new NotFoundHttpException();

        $prev = $lesson->getPrevLesson();
        $next = $lesson->getNextLesson();
        $isNew = false;

        if (!Yii::$app->user->isGuest) {
            $isNew = UserProgress::markComplete(Yii::$app->user->id, $id, 'lesson');
            if ($isNew) {
                Yii::$app->user->identity->updateXp($lesson->xp_reward);
            }
        }

        return $this->render('view', compact('lesson', 'prev', 'next', 'isNew'));
    }
}
