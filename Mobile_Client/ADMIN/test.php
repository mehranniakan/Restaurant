<?php
$array = array(
    'cart_id'=>1,
    'cart_name'=>2,
);
$array2 = array(
    'cart_id'=>3,
    'cart_name'=>4,
);
$arr[] = $array;

$arr[1]=$array2;

print_r($arr);
sfwfd
