<?php



$serverName = "webflix.ck3tnk8inyuk.us-east-1.rds.amazonaws.com";
$dBUsername = "root";
$dBPassword = "p%tpN^m%8v9sK&";
$dBName = "webflix";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3306); // 3306 is the default port for MySQL and not required to be specified

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}












?>