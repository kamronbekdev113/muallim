<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\User;

class UserController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Foydalanuvchilar';
        $models = User::find()->orderBy('created_at DESC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionView($id)
    {
        $model = User::findOne($id) ?? throw new NotFoundHttpException();
        $this->view->title = $model->username;
        return $this->render('view', compact('model'));
    }

    public function actionToggleRole($id)
    {
        $model = User::findOne($id) ?? throw new NotFoundHttpException();
        $model->role = $model->role === 'admin' ? 'student' : 'admin';
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Rol o\'zgartirildi.');
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'O\'zingizni o\'chira olmaysiz.');
            return $this->redirect(['index']);
        }
        $m = User::findOne($id);
        if ($m) $m->delete();
        return $this->redirect(['index']);
    }
}
