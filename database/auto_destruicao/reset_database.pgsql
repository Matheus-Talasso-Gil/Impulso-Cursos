-- atencao: destrutivo apaga todos os alunos e usuarios antes de recriar as tabelas
-- use somente para reiniciar um banco de desenvolvimento apos confirmar o banco e fazer backup
BEGIN;
DROP TABLE IF EXISTS alunos;
DROP TABLE IF EXISTS usuarios;
CREATE TABLE alunos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    turma VARCHAR(255) NOT NULL,
    nasc DATE NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    email VARCHAR(255) NOT NULL
);
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
COMMIT;
