<?php
$arr2 = Array
(
    [0] => Array
        (
            [NUMBER] => 67
            [TYPE] => Other
            [DATE] => 3/31/2011
        )
     [1] => Array
          (
            [NUMBER] => 87
            [TYPE] => something
            [DATE] => 3/28/2011


          )
     [2] => Array
          (
            [NUMBER] => 67
            [TYPE] => Other
            [DATE] => 3/2/2011


          )

) 
$fp1 = fopen('file.csv', 'w');

foreach ($arr2 as $fields) 
{
    fputcsv($fp1, $fields);
}

fclose($fp1);
?>