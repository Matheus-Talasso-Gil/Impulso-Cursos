<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // Inicia a sessão apenas se ainda não estiver ativa.
$_SESSION = array(); // Limpa os dados da sessão atual.
session_destroy(); // Encerra a sessão no servidor.
header('Location: /mini_sistema/index.php'); exit(); // Retorna à página inicial após sair.