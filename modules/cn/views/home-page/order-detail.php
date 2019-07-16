<!--<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>接单详情</title>
		<link rel="stylesheet" href="css\1_aui.css" />
		<link rel="stylesheet" href="css\2_iconfont.css" />
		<link rel="stylesheet" href="css\3_style.css" />
		<style>
			.jdxq-head{font-size: 16px;text-align: center;padding: 2px;}
			.jdxq-head ul li{padding: 8px 0; border-right: 2px solid #fff;border-bottom: 4px solid #fff;}
			.jdxq-head ul li.aui-col-xs-4{border-right: 4px solid #fff;}
			.bg_eee{background: #eee;}
			#output canvas{width: 180px;}
			.outputqr{text-align: center;padding:25px;}
			.jdtip{color: #000;padding: 10px;text-align: left; font-size: 14px;}
		</style>
	</head>
	<body class="aui-bg-white">
		<header class="aui-bar aui-bar-nav" id="aui-header" style="background-image: url(picture\1_center.png);background-size: 100% 100%;">
        <a class="aui-btn aui-pull-left" tapmode onclick="closeWin()">
            <span class="aui-iconfont aui-icon-left"></span>
        </a>
        <div class="aui-title" id="head">接单详情</div>
    	</header>
		<div id="content" v-cloak class="mthead">
			<div class="aui-content jdxq-head">
	        	<ul class="aui-content bg_eee">
	        		<li class="aui-col-xs-4 aui-ellipsis-1">任务NO</li>
		        	<li class="aui-col-xs-8" id="FZno">{{orderDet.no}}</li>
		        	<li class="aui-col-xs-4 aui-ellipsis-1">注册手机号</li>
		        	<li class="aui-col-xs-8" id="tel">{{orderDet.tel}}</li>
		        	<li class="aui-col-xs-4 aui-ellipsis-1">码失效倒计时</li>
		        	<li class="aui-col-xs-8 aui-text-danger" ><span id="second" class="aui-text-danger">0</span></li>
		        	<li class="aui-col-xs-4 aui-ellipsis-1" style="height: 60px;">辅助链接</li>
		        	<li class="aui-col-xs-8 aui-ellipsis-1" style="height: 60px;padding: 0 10px;" id="wxUrl">{{orderDet.wxUrl}}</li>
	        	</ul>


		    </div>
	    	<div  id="output" class="outputqr"></div>
	    	<div class="jdtip"><span class="aui-text-danger">提示：</span><br>①用微信APP扫一扫/识别上面二维码进行辅助，微信页面出现辅助成功即可.<br>②若不是辅助成功图，请换下一个人扫此码。<br>③二维码失效时长5分钟，恶意接单将会被永久封号！</div>
	    	<div style="padding: 30px 12%;">
	    		<div  class="aui-btn aui-btn-success aui-btn-block aui-btn-sm aui-margin-b-15" onclick="closeWin()">返回上一页</div>
	    		<div  class="aui-btn aui-btn-info aui-btn-block aui-btn-sm" id="fqbtn" style="display: none;">放弃订单</div>
	    	</div>

	    	<div class="aui-mask aui-mask-in" v-if="maskflag" id="fqmask">
		    	<div class="aui-dialog aui-dialog-in" style="margin-top: -65px;">
		    		<div class="aui-dialog-header">确定要放弃？</div>
		    		<div class="aui-dialog-body">多次放弃，增加禁止接单可能性</div>
		    		<div class="aui-dialog-footer">
		    			<div class="aui-dialog-btn" tapmode="" button-index="1" id="onefq" v-on:click="onefq">确定</div><div class="aui-dialog-btn" v-on:click="maskflag=false"  button-index="0"  id="cancelmask">取消</div>
		    		</div>
		    	</div>
		    </div>

      		<div class="aui-mask aui-mask-in" v-if="twofqmask" >
		    	<div class="aui-dialog aui-dialog-in" style="margin-top: -65px;">
		    		<div class="aui-dialog-header">再次确定要放弃？</div>
		    		<div class="aui-dialog-body">多次放弃，增加禁止接单可能性</div>
		    		<div class="aui-dialog-footer">
		    			<div class="aui-dialog-btn" tapmode="" button-index="1" id="onefq" v-on:click="fq">确定</div>
		    		</div>
		    	</div>
		    </div>

		</div>
	</body>

	<script type="text/javascript" src="css\4_jquery-3.2.1.min.js" ></script>
	<script type="text/javascript" src="css\5_api.js" ></script>
	<script type="text/javascript" src="css\6_clipboard.min.js" ></script>
	<script type="text/javascript" src="css\7_jquery.qrcode.min.js" ></script>
	<script type="text/javascript" src="css\8_aui-toast.js" ></script>
	<script type="text/javascript" src="css\9_fastclick.js" ></script>
	<script type="text/javascript" src="css\10_vue.js" ></script>
	<script type="text/javascript" src="css\11_all.js" ></script>
	<script>

		 var t;
		var second;
		var orderid;
	  $(function() {
	  //   vm.orderid=getUrlParam('orderid');

	      FastClick.attach(document.body);
	      orderid=getUrlParam('orderid');
		getcon(orderid);
	  });

    function getcon(oId){
    	$.post({
         	url: paramUrl+"buy/order/detail",
         	data: {
         		oId:oId,
         		token:localStorage.token,
         	},
         	dataType: "json",
         	success: function(ret){
         		vm.flag=true;
       		if(ret.success){
       			Toast('数据读取成功')
       			vm.orderDet=ret.data;
       			if(ret.data.sts==1){
       				$("#fqbtn").show();
       			}
       			vm.wxUrl=vm.orderDet.wxUrl;
       			jQuery('#output').qrcode(vm.wxUrl);
			    vm.endTime=vm.orderDet.endTime;
				var date2=new Date(vm.endTime.replace(/\-/g, '/'));
				var date1=new Date(vm.fwqtime.replace(/\-/g, '/'));
				console.log(date2.getTime()-date1.getTime())
				second=(date2.getTime()-date1.getTime())/1000;
				time();
				}else{
					Toast(ret.msg);
				}
         	},
        	xhrFields: {
	      		withCredentials: true
	   		}
		});
    }
	  var vm=new Vue({
		el:'#content',
		data:{
			flag:true,
			orderid:'',
			wxUrl:'',
			endTime:'',
			second:0,
			fwqtime:'',
			orderDet:{
				wxUrl:0,
				no:0,
				tel:0,
			},
			curTimeShow:true,
			fqmask:false,
			maskflag:false,
			twofqmask:false,
		},
		created:function(){
			this.getNow();

		},
		mounted:function(){
		//	this.getorder();
		},
		methods:{
			onefq:function(){
				vm.twofqmask=true;
				vm.maskflag=false;
			},
			fq:function(){
				$.ajax({
	         	type: "POST",
	         	url: paramUrl+"buy/order/recycle",
	         	data: {
	         		oId:orderid,
	         		token:localStorage.token,
	         	},
	         	dataType: "json",
	         	success: function(ret){
           		if(ret.success){
           			vm.twofqmask=false;
					vm.maskflag=false;
           			Toast("单子已成功放弃，进入任务池继续循环!");
           			setTimeout(function(){
           				closeWin();
           			},2000)
					}else{
						Toast(ret.msg);
						vm.twofqmask=false;
						vm.maskflag=false;
					}
	         	},
	        	xhrFields: {
		      		withCredentials: true
		   		}
				});
			},
			getNow:function(){
				$.ajax({
		         	type: "GET",
		         	url: paramUrl+"front/time",
		         	data: {
		         	},
		         	dataType: "json",
		         	success: function(ret){
		           		if(ret.success){
		           			vm.fwqtime=ret.data;
						}else{
							Toast(ret.msg);
						}
		         	},
		        	xhrFields: {
			      		withCredentials: true
			   		}
				});
			},
		},
	});
	function time() {
        if (second == 0) {
           // second = 60;
        } else {
        	$("#second").html(second);
            second--;
            setTimeout(function() {
                time();
            },1000)
        }
  		if(second<0){
        	vm.curTimeShow=false;
        }
    }
	$("#fqbtn").click(function(){
		vm.maskflag=true;
	})
	$("#cancelmask").click(function(){
		vm.maskflag=false;
	});

    </script>
</html>-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>接单详情</title>
    <link rel="stylesheet" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/iconfont.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <style>
        .jdxq-head{font-size: 16px;text-align: center;padding: 2px;}
        .jdxq-head ul li{padding: 8px 0; border-right: 2px solid #fff;border-bottom: 4px solid #fff;}
        .jdxq-head ul li.aui-col-xs-4{border-right: 4px solid #fff;}
        .bg_eee{background: #eee;}
        #output canvas{width: 180px;}
        .outputqr{text-align: center;padding:25px;}
        .jdtip{color: #000;padding: 10px;text-align: left; font-size: 14px;}
    </style>
</head>
<body class="aui-bg-white">
<div id="content" v-cloak style="padding-bottom: 160px;">
    <div class="aui-content jdxq-head">
        <ul class="aui-content bg_eee aui-font-size-12">
            <li class="aui-col-xs-4 aui-ellipsis-1">任务NO</li>
            <li class="aui-col-xs-8" id="FZno">{{orderDet.no}}</li>
            <li class="aui-col-xs-4 aui-ellipsis-1">注册手机号</li>
            <li class="aui-col-xs-8" id="tel">{{orderDet.tel==null?0:orderDet.tel}}</li>
            <li class="aui-col-xs-4 aui-ellipsis-1">码失效倒计时</li>
            <li class="aui-col-xs-8 aui-text-danger" ><span id="second" class="aui-text-danger">0</span></li>
            <li class="aui-col-xs-4 aui-ellipsis-1" style="height: 50px;">辅助链接</li>
            <li class="aui-col-xs-8" style="height: 50px;padding: 0 10px;" id="wxUrl">{{orderDet.wxUrl}}</li>
        </ul>
    </div>
    <div  id="output" class="outputqr"></div>

    <div class="jdtip"><span class="aui-text-danger">提示：</span><br>①用微信APP扫一扫/识别上面二维码进行辅助，微信页面出现辅助成功即可.<br>②若不是辅助成功图，请换下一个人扫此码。<br>③二维码失效时长5分钟，恶意接单将会被永久封号！<br/>④辅助的微信号必须满半年实名号，一个月能辅助一次，一年能辅助三次</div>
    <div style="padding: 30px 12%;">

        <div  class="aui-btn aui-btn-info aui-btn-block aui-btn-sm aui-margin-b-15" id="fqbtn" style="display: none;">放弃订单</div>
        <div  class="aui-btn aui-btn-success aui-btn-block aui-btn-sm " onclick="closeWin()">返回上一页</div>
    </div>
    <div class="aui-mask aui-mask-in" v-if="maskflag" id="fqmask">
        <div class="aui-dialog aui-dialog-in" style="margin-top: -65px;">
            <div class="aui-dialog-header">确定要放弃？</div>
            <div class="aui-dialog-body">多次放弃，增加禁止接单可能性</div>
            <div class="aui-dialog-footer">
                <div class="aui-dialog-btn" tapmode="" button-index="1" id="onefq" v-on:click="onefq">确定</div><div class="aui-dialog-btn" v-on:click="maskflag=false"  button-index="0"  id="cancelmask">取消</div>
            </div>
        </div>
    </div>

    <div class="aui-mask aui-mask-in" v-if="twofqmask" >
        <div class="aui-dialog aui-dialog-in" style="margin-top: -65px;">
            <div class="aui-dialog-header">再次确定要放弃？</div>
            <div class="aui-dialog-body">多次放弃，增加禁止接单可能性</div>
            <div class="aui-dialog-footer">
                <div class="aui-dialog-btn" tapmode button-index="1" id="onefq" v-on:click="fq">确定</div>
            </div>
        </div>
    </div>
    <div style=" position: fixed;bottom: 110px;z-index: 10000; margin-left: 15px;width: 80px;height: 80px;background:#FFDB01;border-radius: 50%;padding-top: 10px;text-align: center;"  tapmode   class="ewmClick" >
        <img :src="shensuimg" id="shensuimg"  style="width: 25px;height: 25px;display: inline-block;"/>
        <p style="color: #333;font-size: 12px;">上传成功图</p>
    </div>

    <div style="width: 100%;border-top-left-radius: 80px;border-top-right-radius: 80px;background: #eee;position: fixed;bottom: 0;left: 0;right: 0;padding:15px 20px;z-index: 1000;padding-top: 10px;" >
        <div style="padding:10px 20px;text-align: center;">
            <div class="aui-margin-b-10">
                快速记录订单是否辅助成功<br/>实事求是，便于申诉<br/>
            </div>
            <div>
                <button class="aui-btn aui-btn-success" style="border: none;outline: none;" v-on:click="mark('我确定辅助成功','辅助成功')">我已辅助成功</button>
                <button class="aui-btn aui-btn-info aui-margin-l-10"  id="getonebtn"  style="border: none;outline: none;"  v-on:click="mark('没有成功','做单失败')">未辅助成功</button>
            </div>
        </div>
    </div>
    <input style="display: none;" id="SelPhotoInput" name="SelPhotoInput"  class="aui-hide"  accept="image/*" type="file"  onchange="SelectImg()"/>
</div>
</body>

<script type="text/javascript" src="/js/jquery-3.3.1..js" ></script>
<script type="text/javascript" src="/js/api.js" ></script>
<script type="text/javascript" src="/js/clipboard.min.js" ></script>
<script type="text/javascript" src="/js/jquery.qrcode.min.js" ></script>
<script type="text/javascript" src="/js/aui-toast.js" ></script>
<script type="text/javascript" src="/js/fastclick.js" ></script>
<script type="text/javascript" src="/js/vue.js" ></script>
<script type="text/javascript" src="/js/all.js" ></script>
<script>

    var t;
    var second;
    var orderid;
    $(function() {
        //   vm.orderid=getUrlParam('orderid');
        orderid=getUrlParam('orderid');
        getcon(orderid);
    });
    function getcon(oId){
        $.post({
            url: paramUrl+"buy/order/detail",
            data: {
                oId:oId,
                token:localStorage.token,
            },
            dataType: "json",
            success: function(ret){
                vm.flag=true;
                if(ret.success){
                    Toast('数据读取成功')
                    vm.orderDet=ret.data;
                    if(ret.data.sts==1){
                        $("#fqbtn").show();
                    }
                    vm.wxUrl=vm.orderDet.wxUrl;
                    jQuery('#output').qrcode(vm.wxUrl);
                    vm.endTime=vm.orderDet.endTime;
                    var date2=new Date(vm.endTime.replace(/\-/g, '/'));
                    var date1=new Date(vm.fwqtime.replace(/\-/g, '/'));
                    console.log(date2.getTime()-date1.getTime())
                    second=(date2.getTime()-date1.getTime())/1000;
                    time();
                }else{
                    Toast(ret.msg);
                }
            },
            xhrFields: {
                withCredentials: true
            }
        });
    }
    var vm=new Vue({
        el:'#content',
        data:{
            flag:true,
            orderid:'',
            wxUrl:'',
            endTime:'',
            second:0,
            fwqtime:'',
            orderDet:{
                wxUrl:0,
                no:0,
                tel:0,
            },
            curTimeShow:true,
            fqmask:false,
            maskflag:false,
            twofqmask:false,
            shensuimg:'picture\2_add.png',
        },
        created:function(){
            this.getNow();

        },
        mounted:function(){
            //	this.getorder();
        },
        methods:{
            submitsucimg:function(){
                if($("#shensuimg").attr("src")=='picture\3_add.png'){
                    Toast('请上传辅助成功图');
                    return false;
                }
                load();
                $.post(paramUrl+"buy/order/mark",{
                    oId:orderid,
                    img:($("#shensuimg").attr("src")).replace(/^data:image\/\w+;base64,/, ""),
                    token:localStorage.token,
                },function(ret){
                    hideload();
                    if(ret.success){
                        Toast('成功图片提交成功');
                    }else{
                        Toast(ret.msg);
                    }
                });

            },
            mark:function(mark2,mark){
                $.get(paramUrl+"buy/order/mark",{
                    oId:orderid,
                    mark2:mark2,//备注
                    //img:'',//扫码成功图
                    token:localStorage.token,
                },function(ret){
                    if(ret.success){
                        Toast('标记'+mark+'，方便后续查询比对');
                    }else{
                        Toast(ret.msg);
                    }
                });
            },
            onefq:function(){
                vm.twofqmask=true;
                vm.maskflag=false;
            },
            fq:function(){
                $.ajax({
                    type: "POST",
                    url: paramUrl+"buy/order/recycle",
                    data: {
                        oId:orderid,
                        token:localStorage.token,
                    },
                    dataType: "json",
                    success: function(ret){
                        if(ret.success){
                            vm.twofqmask=false;
                            vm.maskflag=false;
                            Toast("单子已成功放弃，进入任务池继续循环!");
                            setTimeout(function(){
                                closeWin();
                            },2000)
                        }else{
                            Toast(ret.msg);
                            vm.twofqmask=false;
                            vm.maskflag=false;
                        }
                    },
                    xhrFields: {
                        withCredentials: true
                    }
                });
            },
            getNow:function(){
                $.ajax({
                    type: "GET",
                    url: paramUrl+"front/time",
                    data: {
                    },
                    dataType: "json",
                    success: function(ret){
                        if(ret.success){
                            vm.fwqtime=ret.data;
                        }else{
                            Toast(ret.msg);
                        }
                    },
                    xhrFields: {
                        withCredentials: true
                    }
                });
            },
        },
    });
    function time() {
        if (second == 0) {
            // second = 60;
        } else {
            $("#second").html(second);
            second--;
            setTimeout(function() {
                time();
            },1000)
        }
        if(second<0){
            vm.curTimeShow=false;
        }
    }
    $("#fqbtn").click(function(){
        vm.maskflag=true;
    })
    $("#cancelmask").click(function(){
        vm.maskflag=false;
    });


    var ImageId = "";
    $(".ewmClick").click(function () {
        ImageId = $(this).find('img').attr("id");
        return $("#SelPhotoInput").click();
    });


    $("#SelPhotoInput").on("change", function () {
        SelectImg();
    })
    function SelectImg() {
        // showLoading();
        var input = document.getElementById('SelPhotoInput');
        if (input.files && input.files[0]) {

            var reader = new FileReader(),
                img = new Image();
            reader.onload = function (e) {
                var id = "#" + ImageId;
                if(input.files[0].size>102400){//图片大于1M则压缩
                    img.src = e.target.result;
                    img.onload=function(){
                        $(id).attr("src",  compress(img));
                        vm.submitsucimg();
                    }
                }else{
                    $(id).attr('src', e.target.result);
                    vm.submitsucimg();
                }
                //  hideLoading();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    //压缩图片函数
    function compress(img) {
        var initSize = img.src.length;
        var width = img.width;
        var height = img.height;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
        var ratio;
        if ((ratio = width * height / 4000000) > 1) {
            ratio = Math.sqrt(ratio);
            width /= ratio;
            height /= ratio;
        } else {
            ratio = 1;
        }
        canvas.width = width;
        canvas.height = height;
        //铺底色
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, width, height);
        //进行最小压缩
        var ndata = canvas.toDataURL("image/jpeg", 0.1);
        console.log(ndata.length)
        canvas.width = canvas.height = 0;
        return ndata;
    }

    function getBase64Image(img) {
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, img.width, img.height);
        var ext = img.src.substring(img.src.lastIndexOf(".")+1).toLowerCase();
        var dataURL = canvas.toDataURL("image/jpeg", 0.1);
        return dataURL;
    }

</script>
</html>
