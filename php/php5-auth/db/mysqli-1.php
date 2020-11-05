<?php
error_reporting(E_ALL & E_STRICT);
ini_set('display_errors', 1);
// ******** 过程化风格 ********
// $conn = mysqli_connect("localhost", "root", "123456", "discuz");
//
// if(empty($conn))
//     die("mysqli_connected failed: " . mysqli_connect_error());
//
// print "1: connectet to " . mysqli_get_host_info($conn) . "\n";
//
// mysqli_close($conn);

// ******* 面向对象风格 *******
$mysqli = new mysqli("localhost", "root", "123456", "discuz");
if(mysqli_connect_errno())
    die("mysqli_connect failed: " . mysqli_connect_error());

print "2: Connect to " . $mysqli->host_info . "\n";
$mysqli->close();


// ********* mysqli_init **********
$mysqli = mysqli_init();
/*
 MYSQLI_OPT_LOCAL_INFILES   启用或关闭使用LOAD_LOCAL_INFILES命令
 MYSQLI_INIT_CMD
 MYSQLI_READ_DEFAULT_FILE   从my.cnf读取命名为组的选项(或者从mysqli_read_default_file指定的文件)
 MYSQLI_READ_DEFAULT_GROUP
 */
$mysqli->options(MYSQLI_INIT_CMD, "SET AUTOCOMMIT=0");
$mysqli->options(MYSQLI_READ_DEFAULT_FILE, "SSL_CLIENT");
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

$mysqli->real_connect("localhost", "root", "123456", "discuz");
if (mysqli_connect_errno())
    die("mysqli_connect failed: " . mysqli_connect_error());

print "3: Connect to " . $mysqli->host_info . "\n";
$mysqli->close();
