<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // inicia a sessão apenas se ainda não estiver ativa
$_SESSION = array(); // limpa os dados da sessão atual
session_destroy(); // encerra a sessão no servidor
header('Location: /mini_sistema/index.php'); exit(); // retorna à página inicial após sair