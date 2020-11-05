<?php
error_reporting(-1);
ini_set('display_errors', 1);
function p(){
    // echo '<pre>';
    foreach(func_get_args() as $param) {
        print_r($param);
        echo PHP_EOL;
    }
}
// 1 array_keys()
$array = [
    'age' => '19',
    'name' => 'Jack',
    'sex'=> 'M'
];

p(array_keys($array));

// 2 array_key_exists($key, $arr)

p(array_key_exists('name', $array));

// 3 array_search($val, $arr)
p(array_search(19, $array));

// 4 array_map($call, $arr1, ... )
$arr = [1, 2, 4];
$arr2 = [3,4,5];
$brr = array_map(function($n){
    return pow($n, 3);
}, $arr);

//$arr1, $arr2 元素个数应该一致
$brr2 = array_map(function($a, $b){
    return $a * $b;
}, $arr, $arr2);

p($brr);
p($brr2);

// 5 array_merge()
$arr = [
    'age' => 123,
    'name' => 'jack',
    1 => 'joe'
];

$arr2 = [
    'name' => 'jack',
    'sex' => 'MALE',
    1 => 'Jcy',
    'Gan',
    'WSEH'
];
//数字键名会重新排序，而字符串键名会替换
p(array_merge($arr, $arr2));
//相同的键名，不会替换，而是生成一个数组，存储不同的值
p(array_merge_recursive($arr, $arr2));

//将保留第一个数组的值，新值会被追加到第一个数组中
p($arr + $arr2);

// 6 array_multisort()
$arr1 = [10, 100, 100, 0];
$arr2 = [1, 3, 2, 4];
array_multisort($arr2, $arr1);
p($arr1, $arr2);

$ar = [
    ["10", 11, 100, 100, "a"],
    [1, 2, "2", 3, 1]
];

array_multisort($ar[0], SORT_ASC, SORT_STRING, $ar[1], SORT_NUMERIC, SORT_DESC);
p($ar);

//排序数据库结果集，二维数组，按照volume降序，edition升序
$data = [
    ['volume' => 67, 'edition' => 2],
    ['volume' => 86, 'edition' => 1],
    ['volume' => 85, 'edition' => 6],
    ['volume' => 98, 'edition' => 2],
    ['volume' => 86, 'edition' => 6],
    ['volume' => 67, 'edition' => 7],
];

foreach($data as $key => $row) {
    $volume[$key] = $row['volume'];
    $edition[$key] = $row['edition'];
}



array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $data);

foreach($data as $v){
    echo $v['volume'].'--'.$v['edition'].PHP_EOL;
}


// 7 array_rand()

$arr = [
    'name' => 'jack',
    'age' => '19',
    'sex' => '女',
    'skin' => 'black',
    'fucked' => 'no',
    'school' => 'yes',
    'country' => 'Afraica'
];
var_dump(array_rand($arr, mt_rand(1,4)));

// 8 array_reduce()

$arr = [1,2,5,7];
p(array_reduce($arr, function($res, $val){
    return $res += $val;
}));
p('--------------------'.PHP_EOL);
p(array_reduce($arr, function($res, $val){
    return $res *= $val;
}, 10));