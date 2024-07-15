<?php
$servername = "127.0.0.1";
$username ="root";
$password = "";
$dbname = "opencart";
//create conection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if($conn->connect_error){
die("Conection failed:" . $conn->connect_error);

}

date_default_timezone_set("Asia/Bangkok");

?>
