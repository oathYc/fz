apiready = function() {
			init();
		};
		var vm=new Vue({
			el:'#content',
			data:{
				acc:'',
				pwd:'',
				axflag:true,
			},
			filters:{
			},
			created:function(){
				this.acc=localStorage.acc;
				this.pwd=localStorage.pwd;
			},
			methods:{
				login:function(){
					that=this;
					if(!that.acc){
						Toast('请输入账号');
						return;
					}
					if(!that.pwd){
						Toast('请输入密码');
						return;
					}
					load();
					if(that.axflag){
						that.axflag=false;
						$.post(paramUrl+"cn/api/login",{
							acc:that.acc, 
							pwd: that.pwd
						},function(ret){
							that.axflag=true;
							hideload();
			           		if(ret.success){
				           		localStorage.acc=ret.acc;
				           		localStorage.pwd=that.pwd;
				           		localStorage.token=ret.token;
				           		Toast('登录成功');
				           		setTimeout(function(){
				           			openWin('page1')
				           		},200)
							}else{
								Toast(ret.msg);
							}
					   	},'json');
					}
					
				}
				
			}
		})