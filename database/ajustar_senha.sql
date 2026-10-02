-- execute no banco antes de cadastrar senhas com hash
-- amplia o campo para armazenar os hashes gerados por password_default
ALTER TABLE usuarios ALTER COLUMN senha TYPE VARCHAR(255);

-- este comando não converte as senhas antigas para hash
-- contas antigas precisam ter suas senhas convertidas por um script php
-- com password_hash() ou redefinidas antes de usar o novo login
