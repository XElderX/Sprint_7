
<?php
function connOpen(){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personel_management";

error_reporting(E_ALL ^ E_WARNING);
$conn = mysqli_connect($servername, $username, $password, $dbname); // Create connection
return $conn;
}

?>