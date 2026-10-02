<?php
$host = "192.168.10.143";
$dbname = "escola";
$user = "escola";
$pass = "escola";

try {
    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $pass
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar com o PostgreSQL: " . $e->getMessage());
}
?>