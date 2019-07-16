<?php
/**
 * 内容接口类
 * @return string
 * @cy
 */
namespace app\modules\cn\controllers;



use app\modules\cn\models\User;
use yii\web\Controller;
use Yii;

class ApiController extends Controller {
    public $enableCsrfValidation = false;

    /**
     * 注册
     */
    public function actionRegister(){
        $phone = Yii::$app->request->post('acc');
        $msgCode = Yii::$app->request->post('msgCode');//验证码
        $rCode = Yii::$app->request->post('rCode');//推荐码
        $password = Yii::$app->request->post('pwd');
        if(!$phone){
            die(json_encode(['success'=>0,'msg'=>'电话号码不能为空']));
        }
        if(!$msgCode){
            die(json_encode(['success'=>0,'msg'=>'验证码不能为空']));
        }
        if(!$password){
            die(json_encode(['success'=>0,'msg'=>'密码不能为空']));
        }
        $res = User::find()->where("phone=$phone")->one();
        if($res){
            $data = ['success'=>0,'msg'=>'电话已注册'];
        }else{
            $mCode = Yii::$app->session->get('msgCode');
            $msgTime = Yii::$app->session->get('msgTime');
            $now = time();
            $reduce = $msgTime - $now ;
            if($reduce >600){
                die(json_encode(['success'=>0,'msg'=>'验证码已失效，请重新发送验证码']));
            }
            if($msgCode == $mCode){
                $pwd = md5($password);
                $model = new User();
                $model->phone = $phone;
                $model->password = $pwd;
                $model->realPass = $password;
                $model->code = $rCode;
                $model->createTime = time();
                $re = $model->save();
                if($re){
                    $data = ['success'=>1,'acc'=>$phone,'pwd'=>$pwd,'token'=>'token'.$pwd];
                }else{
                    $data = ['success'=>0,'msg'=>'注册失败，请重试'];
                }
            }else{
                $data = ['success'=>0,'msg'=>'验证码错误'];
            }
        }
        die(json_encode($data));
    }
    /**
     * 登录
     */
    public function actionLogin(){
        $phone = Yii::$app->request->post('acc');
        $password = Yii::$app->request->post('pwd');
        $pwd = md5($password);
        $re = User::find()->where("phone = '{$phone}' and password = '{$pwd}'")->one();
        if($re){
            $data = ['success'=>1,'msg'=>'登录成功'];
        }else{
            $data = ['success'=>0,'msg'=>'账号或密码不正确'];
        }
        die(json_encode($data));
    }
    /**
     * 发送验证码
     */
    public function actionSendCode(){
        $phone = Yii::$app->request->post('phone');
        $host = "http://yzxyzm.market.alicloudapi.com";
        $path = "/yzx/verifySms";
        $method = "POST";
        $appcode = "b5b3c343d7a5404b9a41dfc9b33fc034";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $code = rand(1000,9999);
        $time = time();
        $querys = "phone=$phone&templateId=TP18040314&variable=code%3A$code";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result =json_decode(curl_exec($curl));
        if($result['return_code'] == 0000){
            Yii::$app->session->set('msgCode',$code);
            Yii::$app->session->set('msgTime',$time);
            $data = ['success'=>1,'msg'=>'验证码发送成功'];
        }else{
            $data = ['success'=>0,'msg'=>'验证码发送失败，请重试'];
        }
        die(json_encode($data));
    }
    //验证图片验证码
    public function actionCheckImgCode(){
        $code = Yii::$app->request->post('imgCode');
        $imgCode = Yii::$app->session->get('imgCode');
        if($code == $imgCode){
            die(json_encode(['code'=>1]));
        }else{
            die(json_encode(['code'=>0,'code'=>$code,'img'=>$imgCode]));
        }
    }
    //忘记密码 修改密码
    public function actionForgetPassword(){
        $phone = Yii::$app->request->post('acc');
        $msgCode = Yii::$app->request->post('msgCode');
        $password = Yii::$app->request->post('pwd');
        if(!$phone){
            die(json_encode(['success'=>0,'msg'=>'电话号码不能为空']));
        }
        if(!$msgCode){
            die(json_encode(['success'=>0,'msg'=>'验证码不能为空']));
        }
        if(!$password){
            die(json_encode(['success'=>0,'msg'=>'密码不能为空']));
        }
        $msgCode = Yii::$app->session->get('msgCode');
        $msgTime = Yii::$app->session->get('msgTime');
        $now = time();
        $reduce = $msgTime - $now ;
        if($reduce >600){
            die(json_encode(['success'=>0,'msg'=>'验证码已失效，请重新发送验证码']));
        }
        if($msgCode != $msgCode){
            die(json_encode(['success'=>0,'msg'=>'验证码不正确']));
        }
        $re = User::find()->where("phone = $phone")->one();
        if($re){
            $re->phone = $phone;
            $re->password = md5($password);
            $re->realPass = $password;
            $re->createTime = time();
            $res = $re->save();
            if($res){
                $data = ['success'=>1,'msg'=>'修改成功'];
            }else{
                $data = ['success'=>0,'msg'=>'修改失败'];
            }
        }else{
            $data = ['success'=>0,'msg'=>'该电话还未注册'];
        }
        die(json_encode($data));
    }
}