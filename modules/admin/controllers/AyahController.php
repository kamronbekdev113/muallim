<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Ayah;
use app\models\Surah;

class AyahController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Oyatlar';
        $surahId = Yii::$app->request->get('surah_id');
        $query = Ayah::find()->with('surah')->orderBy('surah_id ASC, number ASC');
        if ($surahId) $query->where(['surah_id' => $surahId]);
        $models = $query->limit(100)->all();
        $surahs = Surah::find()->orderBy('number ASC')->all();
        return $this->render('index', compact('models', 'surahs', 'surahId'));
    }

    public function actionCreate()
    {
        $this->view->title = 'Oyat qo\'shish';
        $model = new Ayah();
        $surahs = Surah::find()->orderBy('number ASC')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Oyat saqlandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model', 'surahs'));
    }

    public function actionUpdate($id)
    {
        $model = Ayah::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = 'Oyat tahrirlash';
        $surahs = Surah::find()->orderBy('number ASC')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Yangilandi.');
            return $this->redirect(['index']);
        }
        return $this->render('form', compact('model', 'surahs'));
    }

    public function actionDelete($id)
    {
        $m = Ayah::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
