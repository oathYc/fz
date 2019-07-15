<!DOCTYPE html>
<html><head>
    <title>HTML5 code Reader</title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<style type="text/css">
    html, body { height: 100%; width: 100%; text-align:center; }
</style>
<script src="/js/jquery-3.3.1.js"></script>
<body>

<div id="support"></div>
<div id="contentHolder">
    <video id="video" width="320" height="320" autoplay>
    </video>
    <canvas style="display:none; background-color:#F00;" id="canvas" width="320" height="320">
    </canvas> <br/>
    <a href="http://sao315.com/w/api/saoyisao?redirect_uri=">扫一扫</a>
    <button id="snap" style="display:none; height:50px; width:120px;">开始扫描</button>
</div>



</body></html>