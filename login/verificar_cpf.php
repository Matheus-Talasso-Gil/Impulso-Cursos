<?php
require_once __DIR__ . '/../includes/functions.php'; // Carrega a validação matemática compartilhada.
function verificar_cpf($cpf)
{
    if (!is_string($cpf)) return false;
    $cpf = preg_replace('/\D/', '', $cpf); // Normaliza o valor recebido pelo formulário.
    return validar_cpf($cpf) ? $cpf : false; // Devolve o CPF limpo apenas se os dígitos verificadores forem válidos.
}
