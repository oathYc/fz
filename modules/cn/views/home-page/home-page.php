<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>首页</title>
    <link rel="stylesheet" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/iconfont.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <style>
        .aui-list .aui-list-item {
            background-image:none;
            background-image: none;
            border-bottom: 1px solid #dfdfdf;
        }
        .gradient-warn {
            background-image: linear-gradient(15deg, #FCDE4D 0%, #DD719 100%);
        }
        .noticemask{position: fixed;top: 0;right: 0;bottom: 0;left: 0;background: rgba(0,0,0,0.6);}
        .noticecon{position: absolute;top:10%;
            left:15%;
            width: 70%;background: #fff;border-radius: 5px;padding: 20px;}
        .iknowbtn{background: #FF5642!important;border-radius: 20px;}
        .noticeinner{color: #6B6B6B;margin-top: 5px;}
        .getjc{position: fixed;left: 0;bottom: 30%;}
        .getjcbtn{background: #FDD719; width: 95px;height: 40px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;line-height: 40px;padding-left: 12px;font-size: 16px; }
        .fw7{font-weight: 700;}
    </style>
</head>
<body>
<div id="content" v-cloak>
    <div class="aui-bg-info">
        <div class="aui-tab" id="tab" >
            <div class="aui-tab-item" taomode v-on:click="tabclick(0)">
                <span>待抢订单</span>
            </div>
            <div class="aui-tab-item" taomode v-on:click="tabclick(1)"><span v-cloak>待完成/待确认订单({{ingnum}})</span></div>
        </div>
    </div>
    <div class="index-head">
        <div style="position: absolute;margin-top: -8px;"  v-show="jdpriceflag==true">
            <span class="index-num" >{{waitnum}}</span><span> 单待抢</span><br />
            <span style="font-size: 14px;" v-show="jdpriceflag"> 预计接单价</span> <span class="index-num"  style="font-size: 18px;" v-show="jdpriceflag">{{basemoney}}</span>
        </div>
        <div  v-show="jdpriceflag==false" style="position: absolute;">
            <span class="index-num" >{{waitnum}}</span><span> 单待抢</span><br />
        </div>
        <div class="aui-pull-right">
            <button class="aui-btn aui-btn-info qdbtn"  id="getonebtn"  style="border: none;outline: none;" v-on:click="getone">点击抢单</button>
        </div>
        <div class="aui-pull-right aui-margin-r-15">
            <div class="aui-btn aui-btn-success"  id="refresh" v-on:click="refresh">刷新</div>
        </div>
    </div>

    <div class="aui-content aui-margin-t-10" v-if="showflag==0">
        <!--<div class="index-title">
            <span>已抢到待完成/待确认订单</span>
        </div>-->
        <ul class="aui-list aui-media-list">
            <li class="aui-list-item aui-list-item-middle index-list" v-for="item in waitlist" >
                <div class="aui-media-list-item-inner">
                    <div class="aui-list-item-inner"> <!-- aui-list-item-arrow-->
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14" >单号：{{item.no}}</div>
                            <div class="aui-list-item-title aui-text-danger" style="font-size: 18px;font-weight: 600;" v-if="jdpriceflag">+{{item.money}}</div>
                        </div>
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14" >手机号：{{item.tel}}</div>

                            <div class="aui-list-item-title" ><div class="aui-btn aui-btn-success" tapmode v-on:click="taskqiang(item.oId)" >点击接单</div></div>
                        </div>
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14" >过期：<!--{{item.endTime|minus}}--><span class="setdowntime aui-text-danger" :endTime="item.endTime" style="font-size: 16px;"></span></div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="aui-content" v-if="showflag==1">
        <ul class="aui-list aui-media-list">
            <li class="aui-list-item aui-list-item-middle index-list" v-for="item in inglist">
                <div class="aui-media-list-item-inner">
                    <div class="aui-list-item-inner"> <!-- aui-list-item-arrow-->
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14">单号：{{item.no}}</div><div class="aui-list-item-title aui-text-danger" style="font-size: 18px;font-weight: 700;">+{{item.money}}</div>
                        </div>
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14">手机号：{{item.tel}}</div>
                            <div class="aui-list-item-title" ><div class="aui-btn aui-btn-success"  v-on:click="look(item.id)">查看</div></div>
                        </div>
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14">过期时间：{{item.endTime}}</div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div style="text-align: center;margin-top: 20%;display: none;" id="datanull">
        <img src="/image/load.gif" style="width: 110px;"/>
        <!--<div>订单即将来袭，请勿走开</div>-->
        <div v-html="indextip"></div>
    </div>
    <div class="getjc">
        <div class="getjcbtn"  onclick="javascript:location.href='/jd.html';">
            接单教程
        </div>
    </div>
    <div class="noticemask" v-if="noticeshow" v-cloak>
        <div class="noticecon">
            <div class="aui-text-center">
                <img src="/image/new.png" style="width: 70px;"/>
                <h3 class="fw7"> FZ最新公告</h3>
                <div style="position: absolute;top: 10px;right: 10px;color: #aaa;">
                    <span class="iconfont icon-shanchu" style="font-size: 24px;" v-on:click="getknow"></span>
                </div>
            </div>
            <div class="aui-margin-t-15">
                <h3 class="fw7">公告内容<br>(先找到人再接单，如果误抢单或者在订单放弃有效期内不能操作完成，请放弃订单，成功率低于40%会被永久禁止接单。成功率提起来)</h3>
                <div class="noticeinner" v-html="noticecon">
                </div>
            </div>
            <div tapmode v-on:click="getknow" style="margin-top: 20px;" class=" aui-btn aui-btn-info aui-btn-block aui-btn-sm iknowbtn" >我知道了</div>
        </div>
    </div>
</div>
<footer class="aui-bar aui-bar-tab aui-border-t" id="footer" style="position: fixed;bottom: 0;left: 0;right: 0;z-index: 10;">
    <div class="aui-bar-tab-item aui-active" tapmode onclick="javascript:location.href='page1.html'">
        <i class="iconfont icon-shouye" style="font-size: 25px;"></i>
        <div class="aui-bar-tab-label" id="page1" style="margin-top: -4px;margin-bottom: 2px;">
            首页
        </div>
    </div>
    <div class="aui-bar-tab-item" tapmode >
        <i class="iconfont icon-cankaoziliao" style="font-size: 25px;"></i>
        <div class="aui-bar-tab-label" style="margin-top: -4px;margin-bottom: 2px;">
            订单
        </div>
    </div>
    <div class="aui-bar-tab-item" tapmode onclick="javascript:location.href='page3.html'">
        <i class="iconfont icon-tongji" style="font-size: 25px;"></i>
        <div class="aui-bar-tab-label" style="margin-top: -4px;margin-bottom: 2px;">
            统计
        </div>
    </div>
    <div class="aui-bar-tab-item"  tapmode >
        <!--<div class="aui-dot"></div>-->
        <i class="iconfont icon-yonghuming" style="font-size: 25px;"></i>
        <div class="aui-bar-tab-label" style="margin-top: -4px;margin-bottom: 2px;">
            个人中心
        </div>
    </div>
</footer>
</body>
<script type="text/javascript" src="/js/api.js" ></script>
<script type="text/javascript" src="/js/jquery-3.3.1.js" ></script>
<script type="text/javascript" src="/js/aui-toast.js" ></script>
<script type="text/javascript" src="/js/fastclick.js" ></script>
<script type="text/javascript" src="/js/vue.js" ></script>
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/page1.js?v=2" ></script>
</html>
