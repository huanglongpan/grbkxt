<?php
include"yzm.php";
$_vc=new ValidateCode();
$_vc->dyimg();
$_SESSION['code']=$_vc->getCode();
?>