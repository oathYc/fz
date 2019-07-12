<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>提现</title>
    <link rel="stylesheet" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/iconfont.css" />
    <link rel="stylesheet" href="/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/css/kinerDatePicker.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <style>
        .balancenum{text-align: center;color: #fff;font-weight: 700;padding-top: 40px; font-size: 36px;}
        .daccount{text-align: center;padding-bottom: 50px;color: #fff;}
        .alldrawbtn{position: absolute;left: 50%;background: #fff;width:150px;line-height: 40px;text-align: center;font-size: 16px;border-radius: 20px;margin-left: -75px;margin-top: -20px;box-shadow: 3px 3px 20px rgba(253,117,103,0.3);font-weight: 700;}
        .tasktotaltit{font-weight: 800;margin:15px 0;}
        .tasktotalcon{border-radius: 10px;box-shadow: 3px 3px 20px rgba(253,117,103,0.3);}
    </style>
</head>
<body class="aui-bg-white">
<!--<header class="aui-bar aui-bar-nav">收益</header>-->
<div id="content" v-cloak>
    <div class="aui-content aui-bg-info">
        <div class="balancenum"><span style="font-size: 22px;">￥</span><span id="mon">0</span></div>
        <div class="daccount" id="daccount">
            未设置
        </div>
        <div class="aui-text-info alldrawbtn" onclick="alld()">
            全部提现
        </div>
    </div>
    <div class="aui-padded-15">
        <h3 class="tasktotaltit">任务统计</h3>
        <div class="tasktotalcon">
            <section class="aui-grid">
                <div class="aui-row">
                    <div class="aui-content">
                        <ul class="aui-list aui-form-list">
                            <li class="aui-list-item" style="border: none;">
                                <div class="aui-list-item-inner">
                                    <div class="aui-list-item-label">
                                        <div style="height: 18px;border-radius: 2px; width: 5px;background: #D0C078;margin-right: 5px;"></div>选择日期
                                    </div>
                                    <div class="aui-list-item-input">
                                        <!-- <input type="text" value="2019-05-23" readonly="readonly"/>-->
                                        <div class="kinerDatePickerInput" id="kinerDatePickerInput1" title="请选择日期" startYear="2019" default-val="2999-1-1">请选择日期</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="aui-row">
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="total">0</span>
                        <div class="aui-grid-label" style="color: #888;">日总接单</div>
                    </div>
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="success">0</span>
                        <div class="aui-grid-label"  style="color: #888;">日成功单</div>
                    </div>
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="rate">0</span>
                        <div class="aui-grid-label"  style="color: #888;">日成功率</div>
                    </div>
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="subTotal">0</span>
                        <div class="aui-grid-label" style="color: #888;">下级日总接单</div>
                    </div>
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="subSuccess">0</span>
                        <div class="aui-grid-label"  style="color: #888;">下级总成功单</div>
                    </div>
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="subRate">0</span>
                        <div class="aui-grid-label"  style="color: #888;">下级总成功率</div>
                    </div>
                    <div class="aui-col-xs-4">
                        <span style="font-size: 20px;font-weight: 700;" id="back">0</span>
                        <div class="aui-grid-label" style="color: #888;">日放弃数</div>
                    </div>
                </div>

            </section>

        </div>

    </div>

</div>
<footer class="aui-bar aui-bar-tab aui-border-t" id="footer" style="position: fixed;bottom: 0;left: 0;right: 0;z-index: 10;">
    <div class="aui-bar-tab-item" tapmode onclick="javascript:location.href='page1.html'">
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
    <div class="aui-bar-tab-item  aui-active" tapmode onclick="javascript:location.href='page3.html'">
        <i class="iconfont icon-tongji" style="font-size: 25px;"></i>
        <div class="aui-bar-tab-label" style="margin-top: -4px;margin-bottom: 2px;">
            统计
        </div>
    </div>
    <div class="aui-bar-tab-item"  tapmode>
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
<script type="text/javascript" src="/js/vue.js" ></script>
<!--<script src="css\10_flexible.debug.js"></script>-->
<!--<script src="css\11_flexible_css.debug.js"></script>-->
<script src="/js/mobileFix.js"></script>
<script src="/js/swiper.min.js"></script>
<script src="/js/kinerDatePicker.js"></script>
<script type="text/javascript" src="/js/all.js" ></script>
<script type="text/javascript" src="/js/page3.js" ></script>
</html>
