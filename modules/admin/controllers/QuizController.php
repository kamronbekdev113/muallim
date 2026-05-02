<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Quiz;
use app\models\QuizOption;
use app\models\MuallimiLesson;

class QuizController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Testlar';
        $models = Quiz::find()->with('options')->orderBy('id DESC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Test qo\'shish';
        $model = new Quiz();
        $lessons = MuallimiLesson::find()->orderBy('chapter_id ASC, sort_order ASC')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveOptions($model->id);
            Yii::$app->session->setFlash('success', 'Test saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model', 'lessons'));
    }

    public function actionUpdate($id)
    {
        $model = Quiz::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Test tahrirlash';
        $lessons = MuallimiLesson::find()->orderBy('chapter_id ASC, sort_order ASC')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            QuizOption::deleteAll(['quiz_id' => $id]);
            $this->saveOptions($id);
            Yii::$app->session->setFlash('success', 'Yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model', 'lessons'));
    }

    private function saveOptions($quizId)
    {
        $options = Yii::$app->request->post('options', []);
        $correct = Yii::$app->request->post('correct_option', 0);
        foreach ($options as $i => $opt) {
            if (empty(trim($opt['text_uz'] ?? ''))) continue;
            $o = new QuizOption();
            $o->quiz_id = $quizId;
            $o->text_uz = $opt['text_uz'] ?? '';
            $o->text_ar = $opt['text_ar'] ?? '';
            $o->is_correct = ($i == $correct) ? 1 : 0;
            $o->sort_order = $i;
            $o->save(false);
        }
    }

    public function actionDelete($id)
    {
        $m = Quiz::findOne($id);
        if ($m) { QuizOption::deleteAll(['quiz_id' => $id]); $m->delete(); }
        return $this->redirect(['index']);
    }
}
