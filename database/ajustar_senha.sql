-- Execute no banco antes de cadastrar senhas com hash.
-- Amplia o campo para armazenar os hashes gerados por PASSWORD_DEFAULT.
ALTER TABLE usuarios ALTER COLUMN senha TYPE VARCHAR(255);

-- Este comando não converte as senhas antigas para hash.
-- Contas antigas precisam ter suas senhas convertidas por um script PHP
-- com password_hash() ou redefinidas antes de usar o novo login.
