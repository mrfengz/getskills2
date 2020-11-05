<?php
//截取字符串长度
function strLimits($str, $length)
{
    //mb_substr($str, 0, $length);
    // return mbstrlen($str) > ($length - 3) ? mb_substr($str, 0, $length - 3) . '...' : $str;
    $width = mb_strwidth($str) / mb_strlen($str);
    return mb_strimwidth($str, 0, $length * $width) . '...';
}

/**
 * 净化输入
 * @param $vars       $_GET/$_POST等数据
 * @param $signatures 指定数据条件
 * @param null $redirect_url
 * @author fz
 * @time   2018/11/7 下午5:16
 *                    usage
 *                    $sigs = array(
 *                    'pro_id' => ['required' => true, 'type' => 'int'],
 *                    'desc'=> ['required' => true, 'type' => 'string', 'function' => 'addslashed']
 *                    )
 *                    santize_vars(&$_GET, $isgs, "http://example.com/error.php?cause=vars")
 */
function santize_vars(&$vars, $signatures, $redirect_url = null)
{
    $tmp = [];
    foreach ($signatures as $key => $sig) {
        //是否存在
        if (!isset($vars[$key])
            && isset($sig['required']) && $sig['required']) {
            if ($redirect_url) {
                header("Location: $redirect_url");
            } else {
                echo "变量不存在下标为{$key}的元素";
            }
            exit;
        }

        $tmp[$key] = &$vars[$key];

        //类型转换
        if (isset($sig['type'])) {
            settype($tmp[$key], $sig['type']);
        }
        //指定变量处理函数
        if (isset($sig['function'])) {
            $tmp[$key] = ($sig['function'])($tmp[$key]);
        }
    }

    $vars = $tmp;
}

//签名数据，防止别人随意篡改。这个还不够安全
function create_parameters($array)
{
    $data = '';
    $ret = [];

    //处理参数，生成一个$key=$value的字符串，添加到$ret中
    foreach ($array as $key => $value) {
        $data .= $key . $value;
        $ret[] = "$key=$value";
    }
    //将数据的md5sum()输出作为一个元素添加到$ret数组中
    $hash = md5($data);
    $ret[] = "hash=$hash";

    return join('&amp;', $ret);
}

//这个安全很多
// H(K XOR opad, H(K XOR ipad, text))
/*
 H: 用到的散列函数
 K: 用0(0x0)扩展到64字节的键值
 opad: 64字节长的长度0x5Cs
 ipad: 64字节长的长度0x36s
 text: 计算散列的明文
 */

/**
 * Class Crypt_HMAC
 */
class Crypt_HMAC
{
    /**
     * Crypt_HMAC constructor.
     * @param $key  加密的密钥key
     * @param string $method 使用的加密方法 md5|sha1
     */
    function __construct($key, $method = 'md5')
    {
        if (!in_array($method, array('sha1', 'md5'))) {
            die("不支持该算法");
        }
        $this->_func = $method;

        //如果键值长度不够64字节(大部分散列算法使用的块长度)，使用\0把它扩展到64字节
        if (strlen($key) > 64) {
            $key = str_pad($key, 64, chr(0));
        }
        //ipad: 0x36异或的64字节的键值
        $this->_ipad = substr($key, 0, 64) ^ str_repeat(chr(0x36), 64);
        //opad: 0x5C异或的64字节的键值
        $this->_opad = substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64);
    }

    /**
     * @param $data 要加密的明文数据
     * @return mixed
     * @author fz
     * @time   2018/11/7 下午5:41
     */
    public function hash($data)
    {
        $func = $this->_func;
        $inner = pack("H32", $func($this->_ipad . $data)); //内部结果
        $digest = $func($this->_opad . $inner); //摘要

        return $digest;
    }
}

/**
 * 使用crypt_hmam签名数据，防止别人随意篡改。
 * @param $array
 * @return string
 * @author fz
 * @time   2018/11/7 下午5:44
 * @usage
 *  1. $hashParams= create_hmac_parameters($params);
 *  2. verfiyParams:
 *      if (false === verify_hmac_paramters($params)) {//数据被篡改
 *      }
 */
function create_hmac_parameters($array)
{
    $data = '';
    $ret = [];

    //处理参数，生成一个$key=$value的字符串，添加到$ret中
    foreach ($array as $key => $value) {
        $data .= $key . $value;
        $ret[] = "$key=$value";
    }
    //将数据的md5sum()输出作为一个元素添加到$ret数组中
    $h = new Crypt_HMAC("thisl343477*jJSSL");
    $hash = $h->hash($data);
    $ret[] = "hash=$hash";

    return join('&amp;', $ret);
}

function verify_hmac_paramters($array)
{
    $hash = $array['hash'];
    unset($array['hash']);
    if($hash != create_hmac_parameters($array)) {
        return false;
    } else {
        return true;
    }
}
