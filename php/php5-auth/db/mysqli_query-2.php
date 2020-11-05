<?php
//这个结果默认是缓冲的，就是所有的结果查出来之后才能使用。需要额外的内存来存储这些结果集
$conn = mysqli_connect("localhost", 'root', '123456', 'discuz');
$result = $conn->query("SELECT * FROM `pre_common_cron`");
while($row = $result->fetch_row()){
    print $row[0] . "\n";
}
$result->free();
$conn->close();

//无缓冲查询
/**
 * 会限制你通过严格的顺序访问查询结果。(无法排序)
 * 不需要额外的内存来存储整个结果集。
 * 你可以在mysql服务器开始返回值的时候就开始获取而处理或者显示数据航。
 *  你必须用mysqli_fetch_row()获取所有的数据行 或者在给服务器发送其他任何命令前用mysqli_free_result()关闭结果集
 */

$conn = mysqli_connect("localhost", 'root', '123456', 'discuz');
$result = $conn->query("SELECT * FROM `pre_common_cron`", MYSQLI_USE_RESULT); //无缓冲，直接使用结果
while($row = $result->fetch_row()){
    print $row[0] . "\n";
}
$result->free();
$conn->close();

echo "---------- 多重查询 ------------\n";

//多重查询
$conn = mysqli_connect("localhost", "root", "123456", "discuz");
$query = "select id from pre_common_cron;";
$query .= "select id from pre_common_credit_rule_log;";
if($conn->multi_query($query)) {
    do{
        if($result = $mysqli->store_result()) {
            while($row = $result->fetch_row()) {
                printf("Cols: %s\n", $row[0]);
            }
            $result->close();
        }
    } while($conn->next_result());
}

$conn->close();
