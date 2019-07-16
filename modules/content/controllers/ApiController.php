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
    public function actionImagePost(){
        $name = Yii::$app->request->post('name');
        $src = Yii::$app->request->post('src');
        $imgdata = substr($src,strpos($src,",") + 1);
        $decodedData = base64_decode($imgdata);
        $date = date('Y-m-d');
        $file = $_SERVER['DOCUMENT_ROOT']."/files/$date/$name";
        $dir = $_SERVER['DOCUMENT_ROOT']."/files/$date";
        if(!is_dir($dir)){
            $res=mkdir(iconv("UTF-8", "GBK", $dir),0777,true);
            if (!$res){
                die(json_encode(['code'=>0,'msg'=>'图片上传失败:文件夹创建失败']));
            }
        }
        file_put_contents($file,$decodedData);
        if(file_exists($file)){
            $data = ['code'=>1,'file'=>$file,'msg'=>'上传成功','name'=>$name];
        }else{
            $data = ['code'=>0,'msg'=>'图片上传失败：图片保存失败'];
        }
        die(json_encode($data));
    }
}