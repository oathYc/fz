<?php
/**
 * 登录管理
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-6-17
 * Time: 下午2:37
 */
namespace app\modules\content\controllers;

use yii;
use yii\web\Controller;

class CreateOrderController extends  Controller{
    public $enableCsrfValidation = false;

    public function actionIndex(){
        return $this->renderPartial('create-order');
    }

}