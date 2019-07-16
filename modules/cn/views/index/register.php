<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>注册</title>
    <link rel="stylesheet" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/iconfont.css" />
    <link rel="stylesheet" href="/css/style.css" />
</head>
<body style="background: #fff;">
<div class="login-con">
    <!--<div class="page-head-con">
        <span class="iconfont icon-jiantouzuo aui-font-size-20"></span> <span>FZ登录</span>
    </div>-->
    <header class="aui-bar aui-bar-nav" id="aui-header" style="background-image: '/image/center.png';background-size: 100% 100%;">
        <a class="aui-btn aui-pull-left" tapmode onclick="closeWin()">
            <span class="aui-iconfont aui-icon-left"></span>
        </a>
        <div class="aui-title" id="head">注册</div>
    </header>
    <div class="page-form-con aui-padded-t-10 mthead">
        <ul class="aui-list aui-form-list">
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-xinxi aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="picval" placeholder="请输入图片验证码" width="60%"/>
                    </div>
                </div>
                <div class="tpimg">
                    <img src='/captcha/captcha' height="32" id="tpyzm"/>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-shouji1 aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="tel" id="account" type="text" placeholder="请输入手机号" width="80%">
                    </div>
                </div>
                <input  class="aui-btn aui-btn-success aui-btn-block aui-btn-sm sendcodebtn" id="btn" value="获取验证码" onclick="settime(this)" style="width: 100px;text-align: center; outline: none;border: none;" readonly="readonly"/>

            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-xinxi aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="vcode"  placeholder="请输入短信验证码">
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-suozi aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password"  id="pwd" placeholder="请输入密码">
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        推荐码
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" placeholder="请输入推荐码"  id="rCode">
                    </div>
                </div>
            </li>
        </ul>
        <div  class="mt60 aui-btn aui-btn-info aui-btn-block aui-btn-sm" id="confirmbtn">立即注册</div>
    </div>
    <div class="aui-text-info now-reg-btn" >
        <div onclick="url('login.html')">立即登录</div>
<!--        <div>APP下载地址：www.pgyer.com/fzpt</div></div>-->
</div>
</body>
<script type="text/javascript" src="/js/api.js" ></script>
<script type="text/javascript" src="/js/aui-toast.js" ></script>
<!--<script type="text/javascript" src="/js/vue.js" ></script>-->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/jquery-3.3.1.js" ></script>
<script>
    var rCode;
    $(function() {
        $("#rCode").val(getParam('rCode'));
        rCode=getParam('rCode');
    });
    var countdown=60;
    var picval;
    function settime(val) {
        var tel = $('#account').val();
        picval= $('#picval').val();
        if(!picval){
            Toast('图片验证码不能为空');
            return false;
        }else{
            if(countdown == 60){
                $.post(paramUrl+"/cn/api/check-img-code",{
                    imgCode:picval,
                },function(re){
                    if(re.code !=1){
                        Toast('图片验证码不正确');
                    }
                },'json');
            }
        }

        if(!tel){
            Toast('手机号不能为空');
            return false;
        }

        if(tel.length !== 11){
            Toast('请输入正确的手机号码');
            return false;
        }
        if (countdown == 0) {
            val.removeAttribute("disabled");
            val.value="发送验证码";
            countdown = 60;
        } else {
            if(countdown==60){
                $.post(paramUrl+"cn/api/send-code",{
                    'phone': tel,
                    'type': 's-reg',//接单注册
                    'verifyCode':picval,
                },function(ret){
                    if(ret.success){
                        Toast('发送成功');
                    }else{
                        Toast(ret.msg);
                    }
                },'json');
            }
            val.setAttribute("disabled", true);
            val.value="发送(" + countdown + ")";
            countdown--;
            setTimeout(function() {
                settime(val)
            },1000)
        }

    }
    $("#tpyzm").click(function(){
        $("#tpyzm").attr('src',paramUrl+'/captcha/captcha?timestamp=' + (new Date()).valueOf());
    })


    $("#confirmbtn").click(function() {
        var tel = $('#account').val();
        var vcode = $('#vcode').val();
        var repwd = $('#repwd').val();
        var pwd = $('#pwd').val();
        var priceId='';
        if(!tel){ $.toptip('请输入手机号');return;};
        if(!vcode){ $.toptip('请输入验证码');return;};
        if(!pwd){ $.toptip('请输入密码');return;};
//				if(!rCode){ $.toptip('请输入推荐码');return;};
        $.post(paramUrl+"cn/api/register",{
            'acc': tel,
            'msgCode':vcode,
            'pwd': pwd,
            'rCode': rCode,
        },function(ret){
            if(ret.success){
                Toast('注册成功');
                setTimeout(function() {
                    window.location.href = 'login.html';
                },1000)
            }else{
                Toast(ret.msg);
            }
        },'json');

    });
</script>

</html>


