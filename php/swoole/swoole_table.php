<?php
use Swoole\Table;
//创建内存表，$size(最大行数)必须为2的整数次幂，并决定table的总行数，建立在共享内存上，无法扩容
$table = new Table(1024);

$table->column('data', Table::TYPE_STRING, 1); //添加一列，data，字符串类型，长度为1
$table->column('pad', Table::TYPE_STRING, 4);

$table->create();
//必须为关联数据，键为列名.如果长度太长，会自动进行截取
$table->set(1, ['data' => "joke", 'pad' => "love"]);

var_dump($table->get(1));

//实际占用大小，单位为字节
echo "usage mem: " . $table->memorySize . PHP_EOL;

$table->del(1);


//swoole_table使用共享内存表来保存数据，在创建子进程之前，务必要执行 $table->create()
$worker = new swoole_process('child1', false, false);
$worker->start();

// echo "usage mem: " . $table->memorySize . PHP_EOL;
