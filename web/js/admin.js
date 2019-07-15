
function modifyInput(){
	var showed = $('#passShow').val();//1-加密 0-不加密
	if(showed ==  1){
		$('#password').attr('type','text');
		$('#passShow').val(0);
		$('.pngIcon').attr('src','/image/open.png');
	}else{
		$('#password').attr('type','password');
		$('#passShow').val(1);
		$('.pngIcon').attr('src','/image/closed.png');
	}
}
function emptyPass(){
	$('#password').val('');
}
function emptyPhone(){
	$('#phone').val('');
}
function adminLogin(){
	var phone = $('#phone').val();
	var pwd = $('#password').val();
	if(!phone){
		Toast('请输入电话');return false;
	}
	if(phone.length !== 11){
		Toast('请输入正确的电话号码');return false;
	}
	if(!pwd){
		Toast('请输入密码');return false;
	}
	$.post('/content/api/login',{
		phone:phone,
		pwd:pwd,
	},function(re){
		if(re.success){
			localStorage.phone=phone;
			Toast('登录成功');
			setTimeout(function(){
				openWin('admin1');
			},200);
		}else{
			Toast(re.msg);
		}
	},'json');
}
function toRegister(){
	location.href='adminRegister.html';
}