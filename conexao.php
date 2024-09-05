<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "CRUD";
$port = 3306;

try {
    // Conexão com a porta específica
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    // Configurar o modo de erro do PDO para exceção
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    echo "Erro: Conexão com o banco de dados não foi bem-sucedida. Erro gerado: " . $err->getMessage();
}
?>
