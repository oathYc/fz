<?php
/**
 * 首页
 * Created by PhpStorm.
 * User: obelisk
 */
namespace app\modules\cn\controllers;

use yii;

class UserDataController extends yii\web\Controller {
    public $enableCsrfValidation = false;

    /**
     * 首页
     * cy
     */
    public function actionIndex(){
        return $this->renderPartial("user-data");
    }
}