<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ArabicLetter;
use app\models\UserProgress;

class LetterController extends Controller
{
    public function actionIndex()
    {
        $letters = ArabicLetter::getAllOrdered();
        $completed = [];
        if (!Yii::$app->user->isGuest) {
            $rows = UserProgress::find()
                ->where(['user_id' => Yii::$app->user->id, 'content_type' => 'letter', 'completed' => 1])
                ->select('content_id')->column();
            $completed = array_flip($rows);
        }
        return $this->render('index', compact('letters', 'completed'));
    }

    public function actionView($id)
    {
        $letter = ArabicLetter::findOne($id);
        if (!$letter) throw new NotFoundHttpException();

        $prev = ArabicLetter::find()->where(['<', 'sort_order', $letter->sort_order])->orderBy('sort_order DESC')->one();
        $next = ArabicLetter::find()->where(['>', 'sort_order', $letter->sort_order])->orderBy('sort_order ASC')->one();

        // Mark complete + give XP
        if (!Yii::$app->user->isGuest) {
            $isNew = UserProgress::markComplete(Yii::$app->user->id, $id, 'letter');
            if ($isNew) {
                Yii::$app->user->identity->updateXp(Yii::$app->params['xpPerLetterPractice']);
            }
        }

        return $this->render('view', compact('letter', 'prev', 'next'));
    }
}
