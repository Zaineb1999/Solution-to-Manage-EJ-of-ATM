<?php

session_start();
        if(isset($_SESSION['user'])){


$file=isset($_GET['file'])?$_GET['file']:"";
$filename=isset($_GET['filenameF'])?$_GET['filenameF']:"";
header("Content-length:" .strlen($file));
header("Content-Transfer-Encoding: Binary");
header("Content-Type: application/JRN");
header("Content-disposition: download; filename=$filename");
echo ($file);

}else {
           header('location:login.php');
        } 
        
?>;