<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class BaseController extends Controller
{
    protected function response($params, $template = '', $config = [])
    {
        // $request = new Request();
        $request = app('request'); //容器中调用过的类会自动使用单例， 第二个参数为true表示重新实例化
        if ($request->isAjax() || $request->isPjax()) {
            return json($params);
        } else {
            if (is_array($params)) {
                foreach ($params as $k => $v) {
                    $this->assign($k, $v);
                }
            }

            return $this->fetch($template, $params, $config);
        }
    }
}
