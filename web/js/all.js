/**
 *从url中获取请求参数 
 * @param {String} name
 */
var paramUrl='http://www.tvnxl.com/';
//var paramUrl='http://192.168.0.104:8080/fz/';

function openindex() {
	var delay = 0;
	if(api.systemType != 'ios'){
	    delay = 300;
	}
	api.openWin({
		name : 'index',
		url : 'index.html',
		bounces : false,
		delay : delay,
		slidBackEnabled:false,
		vScrollBarEnabled : false
	});
}
function init(){
    $api.setStorage('SYSTEMTYPE',api.systemType);
    $api.setStorage('SYSTEMVERSION',api.systemVersion);
    $api.setStorage('FULLSCREEN',api.fullScreen);
    $api.setStorage('IOS7STATUSBARAPPEARANCE',api.iOS7StatusBarAppearance);
}
function url(Url) {
    window.location.href = Url;
}
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); 
    var r = window.location.search.substr(1).match(reg); 
    if (r != null) return unescape(r[2]);
    return null;
}
function getQueryString(name) {    //中文的参数用这个取
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");   
    var r = window.location.search.substr(1).match(reg);   
}
//function Toast(msg){
//	api.toast({
//	    msg: msg,
//	    duration: 2000,
//	    location: 'bottom'
//	});
//}
function Toast(msg,duration){
  duration=isNaN(duration)?3000:duration;
  var m = document.createElement('div');
  m.innerHTML = msg;
  m.style.cssText="max-width:60%;min-width: 150px;padding:0 14px;height: 40px;color: rgb(255, 255, 255);line-height: 40px;text-align: center;border-radius: 4px;position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 999999;background: rgba(0, 0, 0,.7);font-size: 16px;";
  document.body.appendChild(m);
  setTimeout(function() {
    var d = 0.5;
    m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
    m.style.opacity = '0';
    setTimeout(function() { document.body.removeChild(m) }, d * 1000);
  }, duration);
}

//app
function closeWin(){
    //api.closeWin({});
    history.go('-1');
}


function openWin(fn,tit,bv) {
	window.location.href = fn+'.html';
//	var delay = 0;
//	if(api.systemType != 'ios'){
//	    delay = 300;
//	}
//	api.openWin({
//		name : fn+'_win',
//		url : 'mainhead.html',
//		bounces : bv,
//		delay : delay,
//		slidBackEnabled : true,
//		vScrollBarEnabled : false,
//      pageParam:{
//      	frameName:fn,
//          title:tit,   
//          bounceVal:bv,
//      }
//	});
}
function load(msg){
	var str = "<div id='loadingMask' style='text-align: center;border-radius:5px;color: #ffffff;position: fixed;z-index: 3;top: 45%;left: 50%;width: 6em;min-height: 6em;margin-left: -3em;margin-top: -3rem;display: block;'><img src='load.gif'/></div>";
	if($("body #loadingMask")){
		$("body #loadingMask").remove();
	}  
	$("body").append(str);
}
function hideload(){
	$("body #loadingMask").remove();
}
function fixStatusBar(el,color){
        var strDM = api.systemType;
        if (strDM == 'ios') {
            var strSV = api.systemVersion;
            var numSV = parseInt(strSV,10);
            var fullScreen = api.fullScreen;
            var iOS7StatusBarAppearance = api.iOS7StatusBarAppearance;
            if (numSV >= 7 && !fullScreen && iOS7StatusBarAppearance) {
             //   el.style.paddingTop = '20px';
             el.css('padding-top','20px');
             el.css('background',color);
            }
        }else if(strDM == 'android'){
            var ver = api.systemVersion;
            ver = parseFloat(ver);
            if(ver >= 4.4){
            //    el.style.paddingTop = '25px';
             el.css('padding-top','25px');
              el.css('background',color);
            }
        }
    }
function fixStatusBar_API(el){
    if(!$api.isElement(el)){
        console.warn('$api.fixStatusBar Function need el param, el param must be DOM Element');
        return;
    }
    var sysType = $api.getStorage('SYSTEMTYPE');
    if(sysType == 'ios'){
        fixIos7Bar_API(el);
    }else if(sysType == 'android'){
        var ver = $api.getStorage('SYSTEMVERSION');
        ver = parseFloat(ver);
        if(ver >= 4.4){
            el.style.paddingTop = '25px';
        }
    }
};	
function fixIos7Bar_API(el){
    if(!$api.isElement(el)){
        console.warn('$api.fixIos7Bar Function need el param, el param must be DOM Element');
        return;
    }
    var strDM = $api.getStorage('SYSTEMTYPE');
    if (strDM == 'ios') {
        var strSV = $api.getStorage('SYSTEMVERSION');
        var numSV = parseInt(strSV,10);
        var fullScreen = $api.getStorage('FULLSCREEN');
        var iOS7StatusBarAppearance = $api.getStorage('IOS7STATUSBARAPPEARANCE');
        if (numSV >= 7 && fullScreen == 'false' && iOS7StatusBarAppearance) {
            el.style.paddingTop = '20px';
        }
    }
}



function closeToWin(){
	api.closeToWin({name:'root'});
}


function getParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return null;
}

function getDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;
    return currentdate;
}

