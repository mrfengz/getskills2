<?php
function setHeaders($file, $type, $name = null)
{
    if (empty($name))
    {
        $name = basename($file);
    }
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="'.$name.'";');
    header('Content-Type: ' . $type);
    header('Content-Length: ' . filesize($file));
}

/**
 * 小文件下载
 */

function simple_download($file)
{
    if (is_file($file)) {
        setHeaders($file, 'image/jpeg', 'My picture.jpg');
        $str = @file_get_contents($file);
        if ($str !== false) {
            echo $str;
        }
        exit();
    }
}

// Using the readfile() will not present any memory issues, even when sending large files, on its own.
// If you encounter an out of memory error ensure that output buffering is off with ob_get_level().
function advanced_download($file)
{
    if (is_file($file)) {
        setHeaders($file, 'images/jpeg', 'My picture.jpg');
        ob_clean();
        flush();
        @readfile($file);
        exit();
    }
}


function chunked_download($file)
{
    if (is_file($file)) {
        setHeaders($file, 'image/jpeg', 'My picture.jpg');
        $size = 1024 * 1024;
        $handler = fopen($file, 'rb');
        if (!feof($handler)) {
            $buffer = fread($handler, $size);
            echo $buffer;
            ob_flush();
            flush();
        }
        fclose($handler);
        exit();
    }
}
