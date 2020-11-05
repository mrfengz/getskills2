<?php
/**
 * prepare
 * 工作原理：
 *  创建一个查询模板并发送给mysql服务器，然后mysql服务器对模板进行格式验证和语意解析，最后存储在一个特殊的缓冲区中、
 *  然后返回一个特殊的句柄，用来在家下来的操作中指向该预备语句。
 *
 * 绑定变量
 *  绑定输入变量 mysqli_stmt_bind_param()
 *      select * from city where city = ?       ?占位符
 *  绑定输出变量 mysqli_stmt_bind_result()
 */

//输入绑定
$conn = mysqli_connect("localhost", "root", "123456", "discuz");

// $conn->query("CREATE TABLE alfas(year int, model varchar(50), accel decimal(8,2))");
$stmt = $conn->prepare("insert into alfas values(?, ?, ?)");
// $stmt->bind_param("isd", $year, $model, $accel);

$year = 2001;
$model = "147 2.0 selespeed";
$accel = 9.3;
// $stmt->execute();

$year = 2004;
$model = "156 GTA Sportwagon";
$accel = 6.6;
$stmt->execute();


//输出绑定
$stmt = $conn->prepare("select * from alfas order by year");
$stmt->execute();

$stmt->bind_result($year, $model, $accel);

while($stmt->fetch()){
    echo "Year: $year\t Model:$model:$model\t Accel:$accel\n";
}
