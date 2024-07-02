<?php
$servername = "QMS";
$username = "root"; // substitua pelo seu nome de usuário do MySQL
$password = ""; // substitua pela sua senha do MySQL
$dbname = "qms-ubs";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
