<?php


// Error reporting for development
ini_set('display_errors','On');
error_reporting(E_ALL);

//  دالة PHP لتغيير إعدادات PHP مؤقتًا أثناء تنفيذ السكربت.   // 
// Connection
include 'config.php';

$css="design/css-design/";
$js="design/js-design/";


include 'include/function/functions.php';


include 'include/template/header.php';



    if(!isset($navBar)){
        include 'include/template/navbar.php';
    }

?>