
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>登录</title>
    <link rel="stylesheet" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/iconfont.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <script type="text/javascript" src="/js/api.js" ></script>
    <script type="text/javascript" src="/js/aui-toast.js" ></script>
<!--    <script type="text/javascript" src="/js/vue.js" ></script>-->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js" ></script>
</head>
<body style="background: #fff;">
<div class="login-con" style="margin-top: 30px;" id="content">
    <div class="page-head-con" style="position: relative;">
        <span class="iconfont icon-jiantouzuo aui-font-size-20"></span> <span>FZ登录</span>
        <div onclick="url('reg.html')" style="position: absolute;top: 0;right: 20px;font-size: 19px;" class="aui-text-danger">立即注册</div>
    </div>
    <div class="page-form-con">
        <ul class="aui-list aui-form-list">
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-shouji1 aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" placeholder="请输入账号" v-model="acc">
                    </div>
                    <div class="aui-list-item-label-icon">
                        <i class="iconfont icon-shanchu" style="color: #bbb;font-size: 22px;" tapmode v-on:click="acc=''"></i>
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        <span class="icon iconfont icon-suozi aui-text-info login-icon-con"></span>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" placeholder="请输入密码" v-model="pwd">
                    </div>
                    <div class="aui-list-item-label-icon">
                        <i class="iconfont icon-shanchu" style="color: #bbb;font-size: 22px;" tapmode v-on:click="pwd=''"></i>
                    </div>
                </div>
            </li>
            <div class="aui-list-item-inner aui-padded-l-10" >
                <div class="aui-list-item-input aui-font-size-14">
                    <label><input class="aui-radio rem-pwd-con" type="radio" name="demo1" checked>&nbsp;<span class="rem-ped-text">记住密码</span></label>
                    <span id="" class="for-pwd-text" tapmode onclick="openWin('fw','忘记密码','false');">
	                        	忘记密码
	                        </span>
                </div>
            </div>
        </ul>
        <div  class="mt60 aui-btn aui-btn-info aui-btn-block aui-btn-sm" tapmode  v-on:click="login">登录</div>
    </div>
    <div class="aui-text-info now-reg-btn" >

        <div>APP下载地址：<a href="https://www.pgyer.com/fzpt">https://www.pgyer.com/fzpt</a></div></div>
</div>


</div>
</body>
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/login.js" ></script>
</html>
