<?php
/**
 * 登录管理
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-6-17
 * Time: 下午2:37
 */
namespace app\modules\content\controllers;

use app\modules\content\models\LoginLog;
use app\modules\content\models\Business;
use app\modules\content\models\User;
use yii;
use yii\web\Controller;

class LoginController extends  Controller{
    public $enableCsrfValidation = false;
    /**
     * 后台登录
     *
     */
    public function actionLogin(){
        return $this->renderPartial('login');
    }

    public function actionRegister(){
        return $this->renderPartial('register');
    }
}