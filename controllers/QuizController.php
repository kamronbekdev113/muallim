<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Quiz;
use app\models\QuizResult;
use app\models\MuallimiLesson;
use app\models\UserProgress;

class QuizController extends Controller
{
    public function actionLesson($id)
    {
        $lesson = MuallimiLesson::findOne(['id' => $id, 'active' => 1]);
        if (!$lesson) throw new NotFoundHttpException();
        $quizzes = Quiz::getForLesson($id);
        if (empty($quizzes)) {
            Yii::$app->session->setFlash('info', 'Bu dars uchun hali test mavjud emas.');
            return $this->redirect(['/dars/' . $id]);
        }
        return $this->render('lesson', compact('lesson', 'quizzes'));
    }

    public function actionSubmit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) return ['success' => false, 'message' => 'Kirish kerak'];

        $quizId  = (int)Yii::$app->request->post('quiz_id');
        $answer  = (string)Yii::$app->request->post('answer');
        $quiz    = Quiz::findOne($quizId);
        if (!$quiz) return ['success' => false];

        $correct = false;
        foreach ($quiz->options as $opt) {
            if ($opt->is_correct && (string)$opt->id === $answer) {
                $correct = true;
                break;
            }
        }

        $xp = $correct ? $quiz->xp_reward : 0;
        if ($correct) Yii::$app->user->identity->updateXp($xp);

        $result = new QuizResult();
        $result->user_id = Yii::$app->user->id;
        $result->quiz_id = $quizId;
        $result->is_correct = $correct ? 1 : 0;
        $result->user_answer = $answer;
        $result->xp_earned = $xp;
        $result->answered_at = time();
        $result->save(false);

        return ['success' => true, 'correct' => $correct, 'xp' => $xp];
    }
}
