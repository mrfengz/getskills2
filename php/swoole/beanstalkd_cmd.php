#!/Applications/MAMP/bin/php/php7.0.15/bin/php

<?php
include '../../vendor/autoload.php';

function tubeStats($tubeName)
{
    $beanstalkd = new \Pheanstalk\Pheanstalk('0.0.0.0', 11300);
    return $beanstalkd->statsTube($tubeName);
}

function jobStats($job)
{
    $beanstalkd = new \Pheanstalk\Pheanstalk('0.0.0.0', 11300);
    return $beanstalkd->statsJob($job);
}

function serverStatus()
{
    $beanstalkd = new \Pheanstalk\Pheanstalk('0.0.0.0', 11300);
    return $beanstalkd->stats();
}

function help(){
    echo "最少需要两个参数。 php beanstalkd_cmd.php 参数1(命令) 参数2()";
}

function run(...$params)
{
    $args = $params[0];
    array_shift($args);
    $command = array_shift($args);
    switch($command) {
        case 'tubeStats':
            $result = tubeStats(...$args);
            break;
        case 'jobStats':
            $result = jobStats(...$args);
            break;
        case 'serverStats':
            $result = serverStatus(...$args);
            break;
        default:
            exit('command not supported' . PHP_EOL);

    }
    echo 'yes';
    print_r($result);
}

if ($argc < 3) {
    help();
}

run($argv);
