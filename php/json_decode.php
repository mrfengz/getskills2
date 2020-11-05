<?php

$str = '{"status":"4","info":"\u5f88\u9057\u61be\uff0c\u60a8\u7684\u6d3b\u52a8\u53c2\u4e0e\u6b21\u6570\u5df2\u7528\u5b8c\uff01","subscribe":"00","message":"\u7ec8\u4e8e\u7b49\u5230\u60a8\uff0c\u606d\u559c\u60a8\u83b7\u5956\u8bf7\u626b\u7801\u8fdb\u5165\u516c\u4f17\u53f7\u9886\u5956","qrcode":"\/uploads\/24\/app\/24_wechat_barcode_thumb.jpg"}';
$res = json_decode($str);
var_dump($res);
