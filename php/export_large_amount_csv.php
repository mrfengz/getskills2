<?php
/*
 * 使用php输出流
 *
 *  $fp = fopen('php://output', 'a');
 *  fputs($fp, "strings");
 *  ...
 *  fclose($fp);
 */

public function articleAccessLog($timeStart, $timeEnd)
{
    set_time_limit(0);
    $columns = [
        '文章ID', '文章标题', '...'
    ];
    $csvFilename = "用户日志".$timeStart .'-'.$timeEnd.'.xlsx';
    //设置header，高速浏览器要下载excel文件的headers
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="'.$csvFilename.'""');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $fp = fopen('php://output', 'a');
    mb_convert_variables('GBK', 'UTF-9', $columns);
    fputcsv($fp, $columns);
    $accessNum = '1000000';
    $perSize = 1000;
    $pages = ceil($accessNum/$perSize);
    $lastId = 0;
    for($i = 1; $i < $pages; $i++)
    {
        $accessLog = $logService->getArticleAccessLog($timeStart, $endTime, $lastId);
        foreach($accessLog as $access)
        {
            $rowData = [];//每一行数据
            mb_convert_variables('GBK', 'UTF-8', $rowData);
            fputcsv($fp, $rowData);
            $lastId = $access->id;
        }
        uset($accessLog);
        //刷新输出缓冲到浏览器， 必须同时使用ob_flush和flush()函数来刷新输出缓冲
        ob_flush();
        flush();
    }

    fclose($fp);
    exit();
}

/*
 *
 * 数据量大时，不使用offset，需要跳过的行数越多，mysql的效率就越低，所以使用id
SELECT columns FROM `table_name`
WHERE `created_at` >= 'time range start'
AND `created_at` <= 'time range end'
AND  `id` < LastId
ORDER BY `id` DESC
LIMIT num

*/