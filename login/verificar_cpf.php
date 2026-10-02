<?php
require_once __DIR__ . '/../includes/functions.php'; // carrega a validação matemática compartilhada
function verificar_cpf($cpf)
{
    if (!is_string($cpf)) return false;
    $cpf = preg_replace('/\D/', '', $cpf); // normaliza o valor recebido pelo formulário
    return validar_cpf($cpf) ? $cpf : false; // devolve o cpf limpo apenas se os dígitos verificadores forem válidos
}
