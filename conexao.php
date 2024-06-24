<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdAdocao";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    echo "<h2 style='color:red'>Erro:<br>" . $e->getMessage()."</h2>";
}
?>
