<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>发布微信任务</title>
    <link rel="stylesheet" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/iconfont.css" />
    <link rel="stylesheet" href="/css/style.css" />
</head>
<body style="background: #fff;">
<div class="login-con">
    <!--<div class="page-head-con">
        <span class="iconfont icon-jiantouzuo aui-font-size-20"></span> <span>FZ登录</span>
    </div>-->
    <header class="aui-bar aui-bar-nav2" id="aui-header" style="background-image: '/image/center.png';background-size: 100% 100%;">
        <div class="aui-title" id="head">发布微信任务</div>
    </header>
    <div class="page-form-con aui-padded-t-10 mthead">
        <ul class="aui-list aui-form-list">
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        当前余额
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" class="font-red" id="money" type="text" value="<?php echo isset($money)?$money:'0.00'?>" width="60%">
                    </div>
                </div>
                <input  class="aui-btn aui-btn-success aui-btn-block aui-btn-sm sendcodebtn" id="btn" value="充值"  style="width: 100px;text-align: center; outline: none;border: none;" readonly="readonly"/>

            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        任务佣金
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="pay"  value="6">
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon font-red">
                        备注
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="remark"  placeholder="可输入手机号或字母，方便区分多个订单">
                    </div>
                </div>
            </li>
        </ul>
        <div  class="mt60 aui-btn aui-btn-info2 aui-btn-block aui-btn-sm" id="confirmbtn">扫码上传</div>
    </div>
</body>
<script type="text/javascript" src="/js/api.js" ></script>
<script type="text/javascript" src="/js/aui-toast.js" ></script>
<script type="text/javascript" src="/js/vue.js" ></script>
<!--<script src="https://cdn.jsdelivr.net/npm/vue"></script>-->
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/jquery-3.3.1.js" ></script>
<script>
    $("#confirmbtn").click(function() {
        var nickname = $('#nickname').val();
        var qq = $('#qq').val();
        var phone = $('#phone').val();
        var code = $('#code').val();
        var pwd = $('#pwd').val();
        var repwd = $('#repwd').val();
        var rCode = $('#rCode').val();
        if(!nickname){ Toast('请输入昵称');return;};
        if(!qq){ Toast('请输入qq');return;};
        if(!phone){ Toast('请输入手机号');return;};
        if(!code){ Toast('请输入验证码');return;};
        if(!pwd){ Toast('请输入密码');return;};
        if(!repwd){ Toast('请输入确认密码');return;};
        if(pwd !== repwd){ Toast('密码不一致');return;};
//				if(!rCode){ $.toptip('请输入推荐码');return;};
        $.post(paramUrl+"content/api/register",{
            'nickname': nickname,
            'qq':qq,
            'phone':phone,
            'msgCode':code,
            'pwd': pwd,
            'rCode': rCode,
        },function(ret){
            if(ret.success){
                Toast('注册成功');
                setTimeout(function() {
                    window.location.href = 'admin.html';
                },1000)
            }else{
                Toast(ret.msg);
            }
        },'json');

    });
</script>

</html>


