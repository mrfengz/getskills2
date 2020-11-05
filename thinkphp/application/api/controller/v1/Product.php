<?php
/**
 * Created by PhpStorm.
 * User: fz
 * Date: 2019/3/1
 * Time: 11:06
 */

namespace app\api\controller\v1;

use app\lib\exception\ProductException;
use think\Controller;

class Product extends Controller
{
    public function index()
    {
        try {
            $a = mt_rand(0, 10);
            if ($a > 6) {
                throw new ProductException();
            } else {
                return json(['id' => 1, 'price' => 88]);
            }
        } catch(\Exception $e) {
            return [];
        }
    }
}
