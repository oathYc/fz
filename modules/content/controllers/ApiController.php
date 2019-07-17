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
            Yii::$app->session->set('adminPhone',$phone);
            Yii::$app->session->set('adminId',$re->id);
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
//        $name = Yii::$app->request->post('name');
        $src = Yii::$app->request->post('src');
        $imgdata = substr($src,strpos($src,",") + 1);
        $decodedData = base64_decode($imgdata);
        $date = date('Y-m-d');
        $name = time().'png';
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
            $data = $this->getQrcodeUrl($file);
            $data['file'] = $file;
            $data['name'] = $name;
        }else{
            $data = ['code'=>0,'msg'=>'图片上传失败：图片保存失败'];
        }
        die(json_encode($data));
    }
    /**
     * 获取二维码图片中的链接内容
     * 阿里云
     */
    public function getQrcodeUrl($imageUrl){
        $imageUrl = 'http://59.110.156.117/files/2019-07-16/www.png';
        $host = "http://qrapi.market.alicloudapi.com";
        $path = "/yunapi/qrdecode.html";
        $method = "POST";
        $appcode = "b5b3c343d7a5404b9a41dfc9b33fc034";
        $appcode = " ";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."text/x-www-form-urlencoded; charset=UTF-8");
        $querys = "";
        $imageUrl = urlencode($imageUrl);
        $bodys = "imgurl=$imageUrl&version=1.1";
//        $bodys = "imgurl=http%3A%2F%2Fwww.wwei.cn%2Fstatic%2Fimages%2Fqrcode.jpg&imgdata=data%3Aimage%2Fjpeg%3Bbase64%2C%2F9j%2F...%E7%9C%81%E7%95%A5N%E4%B8%AA%E5%AD%97%E7%AC%A6...V%2F2Q%3D%3D&version=1.1";
        $url = $host . $path;
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
        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
        $result = curl_exec($curl);
        preg_match("/{\"status(.*)+\"msg\"(.*)+\"}/i",$result,$res);
        $result = isset($res[0])?$res[0]:'{"status":204}';
        $result = stripslashes($result);
        $result = json_decode($result,true);
        if($result['status'] ==1){
            $data = ['code'=>1,'msg'=>'解析成功','qrcode'=>$result['data']['raw_text']];
        }elseif($result['status'] ==501){
            $data = ['code'=>0,'msg'=>'服务器响应失败，请稍后重试'];
        }elseif($result['status'] ==204){
            $data = ['code'=>0,'msg'=>'该图片无法解析出二维码'];
        }else{
            $data = ['code'=>0,'msg'=>'解析失败，请重试'];
        }
        return $data;
    }
    public function actionSubmitOrder(){
        $pay = Yii::$app->request->post('pay');
        $remark = Yii::$app->request->post('remark');
        $imageUrl = Yii::$app->request->post('image');
        $qrcode = Yii::$app->request->post('qrcode');
        $adminId = Yii::$app->session->get('adminId');
        $time = time();
        $orderNumber = 'CY'.date('Ymd').$time;
        $business = Business::findOne($adminId);
        $money = $business->money;
        if($money-$pay){
            $data = ['code'=>0,'msg'=>'余额不足'];
            die(json_encode($data));
        }
        $model = new Business();
        $model->businessId = $adminId;
        $model->orderNumber = $orderNumber;
        $model->link = $qrcode;
        $model->qrcode = $imageUrl;
        $model->remark = $remark;
        $model->status = 0;//0-发布中 1-已接单 2-已完成
        $model->createTime = $time;
        $re = $model->save();
        if($re){
            $data = ['code'=>1,'msg'=>'任务发布成功'];
            $business->money = $money-$pay;
            $business->save();
        }else{
            $data = ['code'=>0,'msg'=>'任务发布失败，请重试'];
        }
        die(json_encode($data));
    }
}