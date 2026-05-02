<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\MuallimiLesson;
use app\models\MuallimiChapter;

class LessonController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Darslar';
        $models = MuallimiLesson::find()->with('chapter')->orderBy('chapter_id ASC, sort_order ASC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Dars qo\'shish';
        $model = new MuallimiLesson();
        $chapters = MuallimiChapter::find()->orderBy('sort_order ASC')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Dars saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model', 'chapters'));
    }

    public function actionUpdate($id)
    {
        $model = MuallimiLesson::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Dars tahrirlash';
        $chapters = MuallimiChapter::find()->orderBy('sort_order ASC')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Dars yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model', 'chapters'));
    }

    public function actionDelete($id)
    {
        $m = MuallimiLesson::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
