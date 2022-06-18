<?php
class Connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "personel_management";
    private $connOpen;

    function __construct() {
        try {
            $connection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
            (!$connection) 
            ? die("Connection failed: " . mysqli_connect_error()) 
            : $this->connOpen = $connection;
        }
        catch(Exception $e){ 
            print "<h1 style='color:red; font-size:46px; text-align:center'> Connection to database failed due Error!!!</h1>";
            die;

        }
    }

    function getConnection() { 
        return $this ->connOpen;
    }
    function __destruct() {
        $this->connOpen->close();
    }
    
}

?>