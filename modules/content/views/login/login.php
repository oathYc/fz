
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
    <script type="text/javascript" src="/js/jquery-3.3.1.js" ></script>
</head>
<body style="background: #fff;">
<div class="login-con" style="margin-top: 30px;" id="content">
    <header class="aui-bar aui-bar-nav2" id="aui-header" >
        <div class="aui-title" id="head">登录</div>
    </header>
    <div class="page-form-con">
        <ul class="aui-list aui-form-list">
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" placeholder="请输入账号" v-model="acc" id="phone">
                    </div>
                    <div class="aui-list-item-label-icon">
                        <i class="iconfont icon-shanchu" style="color: #bbb;font-size: 22px;" onclick="emptyPhone()"></i>
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="password" placeholder="请输入密码" v-model="pwd" id="password">
                        <input type="hidden" value="1" id="passShow" />
                    </div>
                    <div class="aui-list-item-label-icon">
                        <i class="iconfont icon-shanchu" style="color: #bbb;font-size: 22px;" onclick="emptyPass()"></i>&nbsp;&nbsp;
                        <i onclick="modifyInput()"> <img  class='pngIcon' src="/image/closed.png"/></i>
                    </div>
                </div>
            </li>
            <div class="aui-list-item-inner aui-padded-l-10" >
                <div class="aui-list-item-input aui-font-size-14">
<!--                    <label><input class="aui-radio rem-pwd-con" type="radio" name="demo1" checked>&nbsp;<span class="rem-ped-text">记住密码</span></label>-->
<!--                    <span id="" class="for-pwd-text" tapmode onclick="openWin('fw','忘记密码','false');">-->
<!--	                        	忘记密码-->
<!--	                        </span>-->
                </div>
            </div>
        </ul>
        <div  class="mt60 aui-btn aui-btn-info2 aui-btn-block aui-btn-sm"  onclick="adminLogin()">登录</div>
        <div  class="mt10 aui-btn  aui-btn-block aui-btn-sm"   onclick="toRegister()">注册</div>
    </div>
    <div class="aui-text-info now-reg-btn" >
</div>


</div>
</body>
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/admin.js" ></script>
</html>
