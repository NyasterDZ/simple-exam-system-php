<?php
$servername = "localhost";
$userdb = "root";
$passdb = "";
$dbname ="mp11";

try {
    $conn = new mysqli($servername,$userdb,$passdb,$dbname);
    $conn->set_charset("utf8mb4");
}
catch(Exception $e)
{
    echo $e->getMessage();
}


?>