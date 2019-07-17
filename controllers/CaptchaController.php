<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class CaptchaController extends Controller
{
    public $this;
    public function actionCaptcha(){

        $c = Yii::createObject('yii\captcha\CaptchaAction', ['__captcha', $this]);
        $c->getVerifyCode(true);
        Yii::$app->session->set('imgCode',$c->getVerifyCode());
        var_dump($c->run());die;
        return $c->run();
    }
    //验证验证码
    public static  function checkCaptcha($code){
        $cod = Yii::$app->session->get('msgCode');
        if($cod == $code){
            return true;
        }else{
            return false;
        }
    }
}
