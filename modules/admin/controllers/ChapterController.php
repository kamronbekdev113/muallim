<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\MuallimiChapter;

class ChapterController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Muallimi Boblar';
        $models = MuallimiChapter::find()->orderBy('sort_order ASC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Bob qo\'shish';
        $model = new MuallimiChapter();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Bob saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = MuallimiChapter::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Bob tahrirlash';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Bob yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionDelete($id)
    {
        $m = MuallimiChapter::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
