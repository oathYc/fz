<!DOCTYPE html>
<html><head>
    <title>HTML5 code Reader</title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<style type="text/css">
    html, body { height: 100%; width: 100%; text-align:center; }
</style>
<script src="/js/jquery-3.3.1.js"></script>
<!--<script src="js/jQuery.min.js"></script>-->
<script src="/js/qrcode.min.js"></script>
<script src="/js/qrcode.js"></script>

<body>
<div class="right-three" onclick="saoYisao()">
    扫一扫
    <input type="file" capture="camera" style="position:absolute;top: 12px;width: 24px;opacity: 0;right:3px;z-index: 0;" class="upload-pic-input"/>
</div>
<script>
    function saoYisao(){
        alert(1);
        var dom = document.getElementsByClassName('upload-pic-input');
        Array.from(dom).forEach(item=>{
            item.onchange = function(){
                $(this).parent().find('p').hide();
                $(this).parent().find('.iconfont').hide();
                var src = getObjectURL(this.files[0]);
                qrcode.decode(src);
                qrcode.callback = function(src){
                    alert(src);//转码出来的信息
                }
            }
        });
        function getObjectURL(file) {
            var url = null;
            if (window.createObjectURL!=undefined) {
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
        }
    }
</script>

</body></html>