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
                        <input type="text" class="font-red" id="money" readonly type="text" value="<?php echo isset($money)?$money:'0.00'?>" width="60%">
                    </div>
                </div>
                <input  class="aui-btn aui-btn-success aui-btn-block aui-btn-sm sendcodebtn" id="btn" value="充值"  style="width: 100px;text-align: center; outline: none;border: none;" readonly="readonly" onclick="message();"/>

            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon">
                        任务佣金
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="pay"  value="6" name="pay">
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon font-red">
                        备注
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="remark" name="remark"  placeholder="可输入手机号或字母，方便区分多个订单" width="60%">
                    </div>
                </div>
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon ">
                        图片
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="imageName" name="imageName" readonly >
                    </div>
                </div>
                <input type="file" class="aui-btn aui-btn-success2 aui-btn-block aui-btn-sm sendcodebtn" capture="camera" accept="image/*" id="imgcamera" name="imgcamera"
                       onchange="ImgChange(this)" value="上传图片">
            </li>
            <li class="aui-list-item login-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label-icon ">
                        链接
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="qrCode" name="qrCode" readonly >
                    </div>
                </div>
            </li>
            <div  class="mt60 aui-btn aui-btn-info2 aui-btn-block aui-btn-sm" onclick="submitOrder()" >上传任务</div>
        </ul>
    </div>
</body>
<script type="text/javascript" src="/js/api.js" ></script>
<script type="text/javascript" src="/js/aui-toast.js" ></script>
<script type="text/javascript" src="/js/vue.js" ></script>
<!--<script src="https://cdn.jsdelivr.net/npm/vue"></script>-->
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/jquery-3.3.1.js" ></script>
<script src="/js/md5.js"></script>
<script src="/js/exif.js"></script>
<script src="/js/cvi_busy_lib.js"></script>

<script>
    function message(){
        alert('请加ok4304abc微信客服，进行充值');
    }
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
    function ImgChange(imgdata) {
        var _this = imgdata,
            _file = _this.files[0],
            fileType = _file.type;
        // console.log(_file);
        var name = _file.name;
        // console.log(name);
        //图片方向角 added by lzk
        var Orientation = "";
        if (/image\/\w+/.test(fileType)) {
            EXIF.getData(_file, function () {
                EXIF.getAllTags(this);
                Orientation = EXIF.getTag(this, 'Orientation');
            });
            var fileReader = new FileReader();
            fileReader.readAsDataURL(_file);
            fileReader.onload = function (event) {
                var result = event.target.result;   //返回的dataURL
                var image = new Image();
                image.src = result;
                image.onload = function () {  //创建一个image对象，给canvas绘制使用
                    var cvs = document.createElement('canvas');
                    var scale = 1;
                    if (this.width > 1080 || this.height > 1080) {  //1080只是示例，可以根据具体的要求去设定缩放图片大小
                        if (this.width > this.height) {
                            scale = 1080 / this.width;
                        } else {
                            scale = 1080 / this.height;
                        }
                    }
                    cvs.width = this.width * scale;
                    cvs.height = this.height * scale;     //计算等比缩小后图片宽高
                    var ctx = cvs.getContext('2d');
                    ctx.drawImage(this, 0, 0, cvs.width, cvs.height);
                    var imgtmp = new Image();
                    imgtmp.src = cvs.toDataURL(fileType, 0.8);
                    console.log(imgtmp);
                    imgtmp.onload = function () {
                        var cvstmp = document.createElement('canvas');
                        var isori = false;
                        if (Orientation != "" && Orientation != 1) {
                            //alert('旋转处理' + Orientation);
                            switch (Orientation) {
                                case 6://需要顺时针（向左）90度旋转
                                    //alert('需要顺时针（向左）90度旋转');
                                    isori = true;
                                    rotateImg(this, 'left', cvstmp);
                                    break;
                                case 8://需要逆时针（向右）90度旋转
                                    //alert('需要顺时针（向右）90度旋转');
                                    rotateImg(this, 'right', cvstmp);
                                    isori = true;
                                    break;
                                case 3://需要180度旋转
                                    //alert('需要180度旋转');
                                    rotateImg(this, 'right', cvstmp);//转两次
                                    rotateImg(this, 'right', cvstmp);
                                    isori = true;
                                    break;
                            }
                        }
                        var newImageData;
                        if (isori)
                            newImageData = cvstmp.toDataURL(fileType, 0.8);   //重新生成图片，fileType为用户选择的图片类型
                        else
                            newImageData = imgtmp.src;
                        var sendData = newImageData.replace("data:" + fileType + ";base64,", '');
                        console.log(newImageData);
                        // $("#imgSrc" ).attr("src", newImageData); //显示图片
                        var md5str = hex_md5(sendData); //MD5校验
                        uploadImages(name,newImageData);
                    }
                }
            }
        } else {
            alert("图片类型不正确");
        }
    }
    function rotateImg(img, direction, canvas) {
        //alert(img);
        //最小与最大旋转方向，图片旋转4次后回到原方向
        var min_step = 0;
        var max_step = 3;
        //var img = document.getElementById(pid);
        if (img == undefined) return;
        //img的高度和宽度不能在img元素隐藏后获取，否则会出错
        var height = img.height;
        var width = img.width;
        var step = 2;

        if (direction == 'right') {
            step++;
            //旋转到原位置，即超过最大值
            step > max_step && (step = min_step);
        } else {
            step--;
            step < min_step && (step = max_step);
        }
        var ctx = canvas.getContext('2d');
        //旋转角度以弧度值为参数
        var degree = step * 90 * Math.PI / 180;
        switch (step) {
            case 0:
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0);
                break;
            case 1:
                canvas.width = height;
                canvas.height = width;
                ctx.rotate(degree);
                ctx.drawImage(img, 0, -height);
                break;
            case 2:
                canvas.width = width;
                canvas.height = height;
                ctx.rotate(degree);
                ctx.drawImage(img, -width, -height);
                break;
            case 3:
                canvas.width = height;
                canvas.height = width;
                ctx.rotate(degree);
                ctx.drawImage(img, -width, 0);
                break;
        }
        return ctx;
    }
    //将图片上传的服务器本地
    function uploadImages(name,src) {
        $.ajax({
            type: "POST",
            url: "/content/api/image-post",

            data: {
                name: name,
                src:src
            },
            dataType: "json",
            timeout: 120000, //超时时间：120秒
            success: function (data) {
                if (data.code == 1) {
                    alert(data.msg);
                    $('#imageName').val(data.name);
                    $('#qrCode').val(data.qrcode);
                } else {
                    alert(data.msg);
                }
            }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("上传失败");
            }
        },'json');
    }
    //拍照
    function cameraImg() {
        document.getElementById("imgcamera").value = ""; //上传文件时先把file类型input清空下
        $("input[id='imgcamera']").click();
    }
    function submitOrder(){
        var money = $('#money').val();
        var pay = $('#pay').val();
        var remark = $('#remark').val();
        var image = $('#imageName').val();
        var qrcode = $('#qrCode').val();
        if(money < pay){
            Toast('月不足，请先充值');return false;
        }
        if(!pay){
            Toast('请输入任务佣金');return false;
        }
        if(!image || !qrcode){
            Toast('请上传任务二维码');return false;
        }
        $.post('/content/api/submit-order',{
            pay:pay,
            remark:remark,
            image:image,
            qrcode:qrcode,
        },function(data){
            Toast(data.msg);
            if(data.msg ==1){
                window.location.reload();
            }
        },'json');
    }
</script>

</html>


