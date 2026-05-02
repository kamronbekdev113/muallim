<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Surah;

class SurahController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Suralar';
        $models = Surah::find()->orderBy('number ASC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Sura qo\'shish';
        $model = new Surah();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sura saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = Surah::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Sura tahrirlash';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionDelete($id)
    {
        $m = Surah::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
