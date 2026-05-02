<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ArabicLetter;

class LetterController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Arab Harflari';
        $models = ArabicLetter::find()->orderBy('sort_order ASC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Harf qo\'shish';
        $model = new ArabicLetter();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Harf saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = ArabicLetter::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Harf tahrirlash';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Harf yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model'));
    }

    public function actionDelete($id)
    {
        $model = ArabicLetter::findOne($id);
        if ($model) $model->delete();
        Yii::$app->session->setFlash('success', 'O\'chirildi.');
        return $this->redirect(['index']);
    }
}
