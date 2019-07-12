apiready = function() {
};
var vm=new Vue({
	el:'#content',
	data:{
		axflag:true,
		waitlist:{},
		waitnum:0,
		inglist:{},
		ingnum:0,
		showflag:0,
		noticecon:'',
		noticetime:'',
		msgId:'',
		noticeshow:false,

		btndis:true,
		reflag:true,

		jdjclink:'',

		jdpriceflag:false,

		info:{},

		basemoney:0,
		basemoneyshow:true,

		indextip:'',//首页提示

		remind:1,
	},
	filters:{
		minus:function(numdate){
			var date1=new Date(numdate.replace(/-/g, "/"));
			var date2 = new Date('2019/05/26 19:35:21');
			var s1 = date1.getTime(),s2 = date2.getTime();
			var total = ( s1-s2)/1000;

			return total;
//					var day = parseInt(total / (24*60*60));//计算整数天数
//					var afterDay = total - day*24*60*60;//取得算出天数后剩余的秒数
//					var hour = parseInt(afterDay/(60*60));//计算整数小时数
//					var afterHour = total - day*24*60*60 - hour*60*60;//取得算出小时数后剩余的秒数
//					var min = parseInt(afterHour/60);//计算整数分
//					var afterMin = total - day*24*60*60 - hour*60*60 - min*60;//取得算出分后剩余的秒数
//					return min+':'+afterMin;
		}
	},
	created:function(){
		this.getnotice();
		this.gettask();
		this.jdpriceshow();
		this.myinfo();

		this.waitlistset();

		this.getlink();
		$("#tab .aui-tab-item").eq(0).addClass('aui-active');


	},
	methods:{
		waitSts:function(){
			$.post(paramUrl+"buy/order/waitSts",{
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					vm.waitnum=ret.data.total;
//			       			if(vm.waitnum>0){
//			       				if(vm.remind==2){
//				       				bdTTS.speak({
//									    text:'大量任务，请及时处理'
//									},function(ret){
//									    alert(JSON.stringify(ret));
//									});
//				       			}
//			       			}
				}else{
					Toast(ret.msg);
				}
			});
		},
		getbaseprice:function(){
			$.post(paramUrl+"buy/user/price",{
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					vm.basemoney=ret.data.money;
				}else{
					Toast(ret.msg);
				}
			});
		},
		taskqiang:function(oId){
			$.post(paramUrl+"buy/order/receive",{
				oId:oId,
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					Toast('成功接单');
					var orderid=oId;
					url('jdxq.html?orderid='+orderid);

				}else{
					Toast(ret.msg)
				}
			});

		},
		myinfo:function(){
			$.post(paramUrl+"buy/user/query",{
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					vm.info=ret.data;

					localStorage.acc=ret.data.acc;
					localStorage.name=ret.data.name;
					localStorage.doOrder=ret.data.doOrder;
					localStorage.rCode=ret.data.rCode;
					localStorage.success=ret.data.success;
					localStorage.total=ret.data.total;
					vm.remind=ret.data.remind;
					vm.waitSts();
					setInterval(function(){
						vm.waitSts();
					},90000);
					//remind 1关闭   2开启

					if(vm.info.incomeRate==null){
						openWin('setrate','设置抽佣百分比','false');
					}
				}else{
					Toast(ret.msg);
					if(ret.code='token-invalid'){
						setTimeout(function(){
							url('login.html');
						},1000)
					}
				}
			});
		},
		num: function (n) {
			return n < 10 ? '0' + n : '' + n
		},
		timeToData:function ( maxtime ) {
			second = Math.floor( maxtime % 60);       //计算秒
			minite = Math.floor((maxtime / 60) % 60); //计算分
			hour = Math.floor((maxtime / 3600) % 24 ); //计算小时
			day = Math.floor((maxtime / 3600) / 24);//计算天
			return day+'天'+this.num(hour)+':'+this.num(minite)+':'+this.num(second);
		},
		jdpriceshow:function(){
			$.get(paramUrl+"front/config",{
				code:'jd_price_flag',//接单价格
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					if(ret.data!=null){
						if(ret.data.num==1){
							vm.getbaseprice();
							vm.jdpriceflag=true;
						}else{
							vm.jdpriceflag=false;
						}
					}
				}else{
					Toast(ret.msg);
				}
			});
		},
		getlink:function(){
			$.get(paramUrl+"front/config",{
				code:'buy_jc',//接单教程
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					if(ret.data!=null){	vm.jdjclink=ret.data.value;}
					vm.indextip=ret.data.desc;

				}else{
					Toast(ret.msg);
				}
			});
		},
		jdjcclick:function(){
			openWin(this.jdjclink,'接单教程','false');
		},
		look:function(id){
			url('jdxq.html?orderid='+id);
//					var delay = 0;
//					if(api.systemType != 'ios'){
//					    delay = 300;
//					}
//         			api.openWin({
//						name :'jdxq_win',
//						url : 'mainhead.html',
//						bounces : true,
//						delay : delay,
//						slidBackEnabled : true,
//						vScrollBarEnabled : false,
//				        pageParam:{
//				        	frameName:'jdxq',
//				            title:'订单详情',   
//				            bounceVal:true,
//				            orderid:id
//				        }
//					});

		},
		getone:function(){///buy/order/receiveOne 取一单
			if(vm.btndis){
				vm.btndis=false;
				var ts=3;
				$("#getonebtn").html(ts+'s后可抢');
				var tt=setInterval(function (){
					ts>1?ts-- :clearInterval(tt);
					$("#getonebtn").html(ts+'s后可抢');
				},1000);
				var timet=setTimeout(function (){
					vm.btndis=true;
					$("#getonebtn").html('点击抢单');
					ts--;
					if(ts==0){
						clearTimeout(timet);
					}
				},3000);




				$.post(paramUrl+"buy/order/receiveOne",{
					token:localStorage.token,
				},function(ret){
					if(ret.success){
						Toast('成功接单');

						var orderid=ret.data.oId;
						url('jdxq.html?orderid='+orderid);
//			           			 var delay = 0;
//								if(api.systemType != 'ios'){
//								    delay = 300;
//								}
//			           			api.openWin({
//									name :'jdxq_win',
//									url : 'mainhead.html',
//									bounces : true,
//									delay : delay,
//									slidBackEnabled : true,
//									vScrollBarEnabled : false,
//							        pageParam:{
//							        	frameName:'jdxq',
//							            title:'订单详情',   
//							            bounceVal:true,
//							            orderid:orderid
//							        }
//								});

					}else{
						Toast(ret.msg)
					}
				});


			}

		},


		tabclick:function(num){
			$("#tab .aui-tab-item").eq(num).addClass('aui-active').siblings().removeClass('aui-active');
			vm.showflag=num;
			if(num==0){
				//vm.getwaitlist();
			}else if(num==1){
				vm.gettask();
			}
		},

		refresh:function(){
			if(vm.reflag){
				vm.reflag=false;
				var ts=2;
				$("#refresh").html(ts+'s后可刷新');
				var tt=setInterval(function (){
					ts>1?ts-- :clearInterval(tt);
					$("#refresh").html(ts+'s后可刷新');
				},1000);
				var timet=setTimeout(function (){
					vm.reflag=true;
					ts--;
					if(ts==0){
						console.log(ts)
						$("#refresh").html('刷新');
						clearTimeout(timet);
					}
				},2000);
				vm.getwaitlist();
				vm.gettask();

			}
//					if(vm.reflag){
//						vm.reflag=false;
//						var ts=3;
//						$("#refresh").html(ts+'s后可刷新');
//						var tt=setInterval(function (){
//							ts>1?ts-- :clearInterval(tt);
//							$("#refresh").html(ts+'s后可刷新');
//				        },1000);
//	           			var timet=setTimeout(function (){
//				            vm.reflag=true;
//				            ts--;
//				            if(ts==0){
//				            console.log(ts)
//				            	$("#refresh").html('刷新');	
//				            	clearTimeout(timet);
//				            }
//				        },3000);
//				        vm.getList();
//				        vm.getListIng();
//						
//					}

		},

		getwaitlist:function(){
			$.post(paramUrl+"buy/order/list",{
				token:localStorage.token,
			},function(ret){
				hideload();
				if(ret.success){
					vm.waitlist=ret.data;
					vm.waitnum=ret.data.length;
					if(vm.waitnum>0){
						$("#datanull").hide();
					}else{
						$("#datanull").show();
					}
				}else{
					Toast(ret.msg);
				}
			});
		},
		gettask:function(){
			//	load();
			$.post(paramUrl+"buy/order/myList",{ ////sts 1 fzz， 2 fzcg， 3 fzyc 4fangqi
				offset:0,
				limit:10,
				sts:1,
				token:localStorage.token,
			},function(ret){
				hideload();
				if(ret.success){
					vm.inglist=ret.rows;
					vm.ingnum=ret.total;
					if(vm.ingnum>0){
						$("#datanull").hide();
					}else{
						$("#datanull").show();
					}
				}else{
					Toast(ret.msg);
				}
			});
		},
		waitlistset:function(){
			$.get(paramUrl+"front/config",{
				code:'buy_waitlist_set',//接单教程
				token:localStorage.token,
			},function(ret){
				if(ret.success){
					if(ret.data.value=='1'){
						setInterval(function(){
							vm.getwaitlist();
						},Number(ret.data.num+'000'));
					}
				}else{
					Toast(ret.msg);
				}
			});
		},
		getnotice:function(){
			$.post(paramUrl+"buy/user/msg",{
				token:localStorage.token,

			},function(ret){
				if(ret.success){
					if(ret.data!=null){
						vm.noticecon=ret.data.body;
						vm.noticetime=ret.data.time;
						vm.msgId=ret.data.msgId;
					}
					if(vm.noticecon!=""){
						vm.noticeshow=true;
					}

				}else{
					Toast(ret.msg);
				}
			});
		},
		getknow:function(){
			$.post(paramUrl+"buy/user/setRead",{
				token:localStorage.token,
				msgId:vm.msgId
			},function(ret){
				if(ret.success){
					vm.noticeshow=false;
				}else{
					Toast(ret.msg);
				}
			});
		},

	}
})

$(function(){
	FastClick.attach(document.body);
	downtime();
});

function downtime(){
	var NowTime = new Date();
	var time = NowTime.getTime();
	$(".setdowntime").each(function(I){
		var endDate =this.getAttribute("endTime");
		var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function (a) { return parseInt(a, 10) - 1; }).match(/\d+/g) + ')');
		var endTime = endDate1.getTime();
		var lag =Math.floor((endTime - time) / 1000);
		if(lag > 0){var h = Math.floor(lag / 3600);var d = Math.floor(h/24);
			var m = Math.floor(lag/60%60);
			m=m<10?'0'+m:m;
			var s = lag%60;
			s=s<10?'0'+s:s;
			$(this).html(m+":"+s);
		}else{
			$(this).html("00:00");
		}});
	setTimeout("downtime()",1000);
}