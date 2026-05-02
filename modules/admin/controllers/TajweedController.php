<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\TajweedRule;

class TajweedController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Tajvid Qoidalari';
        $models = TajweedRule::find()->orderBy('sort_order ASC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Qoida qo\'shish';
        $model = new TajweedRule();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Qoida saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = TajweedRule::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Qoida tahrirlash';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionDelete($id)
    {
        $m = TajweedRule::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
