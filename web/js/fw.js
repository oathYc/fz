var countdown=60;
var picval;
function settime(val) {
	var tel = $('#account').val();
	picval= $('#picval').val();
	if(!picval){
		Toast('图片验证码不能为空');
		return false;
	}
	$.post(paramUrl+"/cn/api/check-img-code",{
		imgCode:picval,
	},function(re){
		if(re.code !=1){
			Toast('图片验证码不正确');
		}
	},'json');
	if(!tel){
		Toast('手机号不能为空');
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
				'type': 's-pwd',//接单
				'verifyCode':picval,
			},function(ret){
           		if(ret.success){
           			Toast('发送成功');
				}else{
					Toast(ret.msg);
				}
		   	});
//					var params = {
//						'phone': tel,
//						'type': 's-pwd',//接单
//					}
//					fetch('front/sendCode',params,'post').then(res =>{
//						Toast('发送成功', 'success');
//						//localocalStorage.setItem('token', res.data.token);
//						//window.location.href = 'index.html';
//					}).catch(err => {
//						
//					})
    	}
        val.setAttribute("disabled", true);
        val.value="发送(" + countdown + ")";
            countdown--;
            setTimeout(function() {
                settime(val);
            },1000);
        }
 
    }
		$("#tpyzm").click(function(){
  		$("#tpyzm").attr('src',paramUrl+'captcha/captcha?timestamp=' + (new Date()).valueOf());
  })
  $("#confirmbtn").click(function() {
  	var tel = $('#account').val();
  	var vcode = $('#vcode').val();
  	var repwd = $('#repwd').val();
  	var pwd = $('#pwd').val();
  	var priceId='';
		if(!tel){ Toast('请输入手机号');return;};
		if(tel.length !== 11){Toast('请输入正确的手机号码');return;}
		if(!vcode){ Toast('请输入验证码');return;};
		if(!pwd){ Toast('请输入密码');return;};
		if(!repwd){ Toast('请输入密码');return;};
		if(pwd!==repwd){Toast('密码不一致');return;}
		
		$.post(paramUrl+"/cn/api/forget-password",{
			"acc": tel,
			'msgCode':vcode,
			'pwd': pwd,
		},function(ret){
       		if(ret.success){
       			Toast('找回成功');
       			closeWin();
			}else{
				Toast(ret.msg);
			}
	   	},'json');
  });