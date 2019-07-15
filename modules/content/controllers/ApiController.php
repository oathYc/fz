<?php


namespace app\modules\content\controllers;


use app\modules\content\models\Business;
use yii\web\Controller;
use Yii;

class ApiController extends  Controller
{
    public $enableCsrfValidation = false;
    public function actionLogin(){
        $phone = Yii::$app->request->post('phone');
        $password = Yii::$app->request->post('pwd');
        $pwd = md5($password);
        $re = Business::find()->where("phone = '{$phone}' and password = '{$pwd}'")->one();
        if($re){
            $data = ['success'=>1,'msg'=>'登录成功'];
            Yii::$app->session->set('adminId',$phone);
        }else{
            $data = ['success'=>0,'msg'=>'账号或密码不正确'];
        }
        die(json_encode($data));
    }
    public function actionRegister(){
        $nickname = Yii::$app->request->post('nickname');
        $qq = Yii::$app->request->post('qq');
        $phone = Yii::$app->request->post('phone');
        $code = Yii::$app->request->post('msgCode');
        $pwd = Yii::$app->request->post('pwd');
        $rCode = Yii::$app->request->post('rCode');
        $re = Business::find()->where("phone = '{$phone}'")->one();
        if($re){
            $data = ['success'=>0,'msg'=>'该手机已经注册'];
        }else{
            if($code != 6666){
                $data = ['success'=>0,'msg'=>'验证码不正确'];
            }else{
                $model = new Business();
                $model->nickname = $nickname;
                $model->qq = $qq;
                $model->phone = $phone;
                $model->password = md5($pwd);
                $model->realPass = $pwd;
                $model->rCode = $rCode;
                $model->createTime = time();
                $res = $model->save();
                if($res){
                    $data = ['success'=>1,'msg'=>'注册成功'];
                }else{
                    $data = ['success'=>0,'msg'=>'注册失败，请重试'];
                }
            }
        }
        die(json_encode($data));
    }
}