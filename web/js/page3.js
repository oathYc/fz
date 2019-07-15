var mon=0;
	$('#kinerDatePickerInput1').kinerDatePicker({
          clickMaskHide: true,
          showHandler: function (ctx) {
            //  console.log("显示时间选择器:",ctx);
          },
          hideHandler: function (ctx) {
              //console.log("隐藏时间选择器:",ctx);
          },
          changeHandler: function (vals,ctx) {
            //  console.log("时间改变:",vals,ctx);
          },
          okHandler: function (vals, ctx) {
              console.log("确定选择:",vals,ctx);
              jddata(vals[0]+'-'+vals[1]+'-'+vals[2]);
          },
          cancelHandler: function (ctx) {
             // console.log("取消选择:",ctx);
          }
    });
      
    function getinfo(){
		$.post(paramUrl+"buy/user/query",{
     		token:localStorage.token,
		},function(ret){
       		if(ret.success){
       			if(ret.data.payAccount==null||ret.data.name==null){
       				$("#daccount").html('未设置');
       			}else{
       				$("#daccount").html('支付宝：'+ret.data.payAccount+'&nbsp;|&nbsp;'+ret.data.name);
       			}
			}else{
				Toast(ret.msg);
			}
	   	});
	}
    function getmoney(){
		$.post(paramUrl+"buy/user/money/acc",{
     		token:localStorage.token,
		},function(ret){
       		if(ret.success){
       			$("#mon").html(ret.data);
       			mon=ret.data;
			}else{
				Toast(ret.msg);
				if(ret.code='token-invalid'){
					setTimeout(function(){
						url('login.html');
					},1000)
				}
			}
	   	});
	}
    function alld(){
		
		if(mon<10){
			Toast('提现金额不能小于10');
			return;
		}
		load();
		$.post(paramUrl+"buy/user/money/doWithdraw",{
			money:mon,
     		token:localStorage.token,
		},function(ret){
			hideload();
       		if(ret.success){
       			$("#mon").val(0);
       			openWin('suc','提现提交','false');
//     			Toast('提现成功')
			}else{
				Toast(ret.msg);
			}
	   	});
		
		
	}
    
    
//  function xjdata(){
//  	$.post(paramUrl+"buy/order/sts",{
//   		date:date,
//   		token:localStorage.token,
//		},function(ret){
//     		if(ret.success){
//     			$("#total").html(ret.data.total);
//     			$("#success").html(ret.data.success);
//     			$("#rate").html(ret.data.total==0?0:((ret.data.success/ret.data.total)*100).toFixed(2)+'%');
//			}else{
//				Toast(ret.msg);
//			}
//	   	});
//  }
    
    function jddata(date){
    	$.post(paramUrl+"buy/order/sts",{
     		date:date,
     		token:localStorage.token,
		},function(ret){
       		if(ret.success){
       			$("#back").html(ret.data.back==null?0:ret.data.back);
       			$("#total").html(ret.data.total);
       			$("#success").html(ret.data.success);
       			$("#rate").html(ret.data.total==0?0:((ret.data.success/ret.data.total)*100).toFixed(2)+'%');
       			
       			
       			$("#subTotal").html(ret.data.subTotal);
       			$("#subSuccess").html(ret.data.subSuccess);
       			$("#subRate").html(ret.data.subTotal==0?0:((ret.data.subSuccess/ret.data.subTotal)*100).toFixed(2)+'%');
       			
			}else{
				Toast(ret.msg);
			}
	   	});
    }
    $(function(){
    	$("#kinerDatePickerInput1").html(getDate());
    	jddata(getDate());
    	getmoney();
    	getinfo();
    })