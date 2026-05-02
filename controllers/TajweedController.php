<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\TajweedRule;

class TajweedController extends Controller
{
    public function actionIndex()
    {
        $rules = TajweedRule::getAllActive();
        $grouped = [];
        foreach ($rules as $rule) {
            $grouped[$rule->getCategoryLabel()][] = $rule;
        }
        return $this->render('index', compact('rules', 'grouped'));
    }

    public function actionView($id)
    {
        $rule = TajweedRule::findOne(['id' => $id, 'active' => 1]);
        if (!$rule) throw new NotFoundHttpException();
        $prev = TajweedRule::find()->where(['<', 'sort_order', $rule->sort_order, 'active' => 1])->orderBy('sort_order DESC')->one();
        $next = TajweedRule::find()->where(['>', 'sort_order', $rule->sort_order, 'active' => 1])->orderBy('sort_order ASC')->one();
        return $this->render('view', compact('rule', 'prev', 'next'));
    }
}
