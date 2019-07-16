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

class OrderController extends yii\web\Controller {
    public $enableCsrfValidation = false;

    /**
     * 首页
     * cy
     */
    public function actionIndex(){
        return $this->renderPartial("user-data");
    }
    /**
     * 订单详情
     */
    public function actionDetail(){
        return $this->renderPartial('detail');
    }
}