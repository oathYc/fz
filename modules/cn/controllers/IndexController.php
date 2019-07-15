<?php
/**
 * 首页
 * Created by PhpStorm.
 * User: obelisk
 */
namespace app\modules\cn\controllers;
use app\libs\Method;
use app\modules\cn\models\LoginLog;
use app\modules\cn\models\User;
use yii;

class IndexController extends yii\web\Controller {
    public $enableCsrfValidation = false;

    /**
     * 登录
     * cy
     */
    public function actionIndex(){
        return $this->renderPartial("login");
    }
    /**
     * 注册
     */
    public function actionRegister(){
        return $this->renderPartial('register');
    }
    /**
     * 忘记密码
     */
    public function actionForgetPass(){
        return $this->renderPartial('forget');
    }
    /**
     * 退出
     * cy
     */
    public function actionLoginOut(){
        Yii::$app->session->removeAll();
        return $this->redirect('/cn/index/index');
    }
}