<?php
$servername = "localhost";
$username = "root";
$password = "0104";
$dbname = "blog_db";

try {
    $pdo = new PDO("mysql:host=localhost;port=3308;dbname=blog_db;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Conexão falhou: " . $e->getMessage());
}
?>