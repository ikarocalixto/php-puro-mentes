<?php
$host = '127.0.0.1';  // Usar IP pode evitar problemas de nome de host
$username = 'root';
$password = '';       // Senha padrão no XAMPP é vazia para 'root'
$dbname = 'api_database';
$port = 3307;         // A porta que você confirmou que o MySQL está usando

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>
