<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Surah;
use app\models\Ayah;

class QuranController extends Controller
{
    public function actionIndex()
    {
        $surahs = Surah::getAllOrdered();
        return $this->render('index', compact('surahs'));
    }

    public function actionSurah($surah)
    {
        $s = Surah::findOne(['number' => $surah]);
        if (!$s) throw new NotFoundHttpException();
        $ayahs = Ayah::find()->where(['surah_id' => $s->id])->orderBy('number ASC')->all();
        $prev = Surah::find()->where(['<', 'number', $surah])->orderBy('number DESC')->one();
        $next = Surah::find()->where(['>', 'number', $surah])->orderBy('number ASC')->one();
        return $this->render('surah', compact('s', 'ayahs', 'prev', 'next'));
    }
}
