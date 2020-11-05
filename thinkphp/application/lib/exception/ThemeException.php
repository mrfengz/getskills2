<?php
namespace app\lib\exception;

class ProductException extends BaseException
{
    //http状态码
    public $code = 404;
    //错误信息
    public $msg = '请求的主题不存在';
    //自定义错误码
    public $errorCode = 30000;
}
