<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\MuallimiChapter;
use app\models\ArabicLetter;
use app\models\TajweedRule;
use app\models\Surah;
use app\models\MuallimiLesson;
use app\models\UserProgress;
use app\models\Ayah;

class SiteController extends Controller
{
    public function actions()
    {
        return ['error' => ['class' => 'yii\web\ErrorAction']];
    }

    public function actionIndex()
    {
        $chapters = MuallimiChapter::getAllActive();
        $letters = ArabicLetter::find()->orderBy('sort_order ASC')->limit(10)->all();
        $tajweedRules = TajweedRule::find()->where(['active' => 1])->limit(4)->orderBy('sort_order ASC')->all();
        $surahs = Surah::find()->orderBy('number ASC')->limit(10)->all();

        // User progress stats
        $completedLessons = 0;
        $lastLesson = null;
        if (!Yii::$app->user->isGuest) {
            $uid = Yii::$app->user->id;
            $completedLessons = UserProgress::find()
                ->where(['user_id' => $uid, 'content_type' => 'lesson', 'completed' => 1])
                ->count();
            $lastProgress = UserProgress::find()
                ->where(['user_id' => $uid, 'content_type' => 'lesson', 'completed' => 1])
                ->orderBy('completed_at DESC')->one();
            if ($lastProgress) {
                $lastLesson = MuallimiLesson::findOne($lastProgress->content_id);
            }
        }

        // Daily Ayah (changes each day based on day of year)
        $dailyAyah = null;
        try {
            $dayOfYear = (int)date('z') + 1;
            $totalAyahs = Ayah::find()->count();
            if ($totalAyahs > 0) {
                $ayahOffset = $dayOfYear % $totalAyahs;
                $dailyAyah = Ayah::find()
                    ->with('surah')
                    ->orderBy('id ASC')
                    ->offset($ayahOffset)
                    ->one();
            }
        } catch (\Exception $e) {
            $dailyAyah = null;
        }

        // Platform stats
        $totalLetters = ArabicLetter::find()->count();
        $totalSurahs  = Surah::find()->count();
        $totalLessons = \app\models\MuallimiLesson::find()->count();

        return $this->render('index', compact(
            'chapters', 'letters', 'tajweedRules', 'surahs',
            'completedLessons', 'lastLesson',
            'dailyAyah', 'totalLetters', 'totalSurahs', 'totalLessons'
        ));
    }

    public function actionSearch()
    {
        $q = Yii::$app->request->get('q', '');
        $lessons = $surahs = [];
        if (strlen($q) >= 2) {
            $lessons = MuallimiLesson::find()
                ->where(['like', 'title_uz', $q])
                ->orWhere(['like', 'arabic_text', $q])
                ->limit(10)->all();
            $surahs = Surah::find()
                ->where(['like', 'name_uz', $q])
                ->orWhere(['like', 'name_ar', $q])
                ->limit(10)->all();
        }
        return $this->render('search', compact('q', 'lessons', 'surahs'));
    }
}
