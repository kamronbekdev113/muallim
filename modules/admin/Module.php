<?php
namespace app\modules\admin;

use Yii;
use yii\web\ForbiddenHttpException;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = 'admin';

    public function init()
    {
        parent::init();
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['/kirish'])->send();
            exit;
        }
        if (Yii::$app->user->identity->role !== 'admin') {
            throw new ForbiddenHttpException("Admin paneliga kirish huquqi yo'q.");
        }
    }
}
