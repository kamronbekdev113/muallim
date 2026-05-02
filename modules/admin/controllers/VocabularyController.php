<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Vocabulary;

class VocabularyController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = "Lug'at";
        $models = Vocabulary::find()->orderBy('id DESC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = "So'z qo'shish";
        $model = new Vocabulary();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "So'z saqlandi.");
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = Vocabulary::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = "So'z tahrirlash";
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionDelete($id)
    {
        $m = Vocabulary::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
