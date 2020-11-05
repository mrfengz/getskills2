<?php
$rowAry = new \RegexIterator(new \SplFileObject('input.csv'), '/\n/', RegexIterator::SPLIT);
$header = "";
foreach ($rowAry as $i => $row) {
    // IF the input CSV has header (column_name) row
    if ($i == 0) {
        $header = $row[0];
    } else {
        $filename = "output_$i.csv";
        $myfile = fopen($filename, "w");
        $target = new \SplFileObject($filename, 'w');
        if (! empty($header)) {
            $target->fwrite($header . "\n");
        }
        $target->fwrite($row[0]);
    }
}
?>