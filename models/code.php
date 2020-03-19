<?php
include "class/code.class.php";
session_start();
$code= new Code(4,1,30,80);
$_SESSION['code']= $code->getCode();
$code->outImage();