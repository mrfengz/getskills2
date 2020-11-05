<?php
$data['extra_data'] = [];
$playTimes = $data['extra_data']['play_times'] ?? 1; //1
var_dump($playTimes);

$data['extra_data']['first'] = 0;
$first = $data['extra_data']['first'] ?? 1;
var_dump($first);