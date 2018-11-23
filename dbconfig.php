<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_test";
//$locations=array();

    $con=mysqli_connect($host,$user,$pass,$db);
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }



?>