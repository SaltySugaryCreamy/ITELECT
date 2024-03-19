<?php
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "itelec");

//connect sa server
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//kung ma fail
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
?>