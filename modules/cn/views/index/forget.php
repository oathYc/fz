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
<header class="aui-bar aui-bar-nav" id="aui-header" style="background-image: '/image/center.png';background-size: 100% 100%;">
    <a class="aui-btn aui-pull-left" tapmode onclick="closeWin()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
    <div class="aui-title" id="head">忘记密码</div>
</header>
<div class="login-con mthead">
    <!--<div class="page-head-con">
        <span class="iconfont icon-jiantouzuo aui-font-size-20"></span> <span>FZ登录</span>
    </div>-->
    <div class="page-form-con aui-padded-t-10">
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
                <div class="tpimg"><img src='/captcha/captcha' height="32" id="tpyzm"/></div>
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
                        <input type="password"  id="pwd" placeholder="请输入新密码">
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-suozi aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" id="repwd" placeholder="请再次输入密码">
                    </div>
                </div>
            </li>
        </ul>
        <div  class="mt60 aui-btn aui-btn-info aui-btn-block aui-btn-sm" id="confirmbtn">立即找回</div>
    </div>
    <div class="aui-text-info now-reg-btn">立即登录</div>
</div>
</body>
<script type="text/javascript" src="/js/api.js" ></script>
<script type="text/javascript" src="/js/jquery-3.3.1.js" ></script>
<script type="text/javascript" src="/js/aui-toast.js" ></script>
<script type="text/javascript" src="/js/vue.js" ></script>
<!--<script src="https://cdn.jsdelivr.net/npm/vue"></script>-->
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/fw.js" ></script>
</html>
