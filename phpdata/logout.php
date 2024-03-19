<?php
session_start();

//i uliton tong na declare na sets
$_SESSION = array();

//end
session_destroy();

//adto balik sa log in
echo "<script>" . "window.location.href='./login.php';" . "</script>";
exit;
