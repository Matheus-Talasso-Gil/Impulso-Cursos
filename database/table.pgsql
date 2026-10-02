-- cria as tabelas somente quando ainda nao existem; nao apaga dados existentes
CREATE TABLE IF NOT EXISTS alunos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    turma VARCHAR(255) NOT NULL,
    nasc DATE NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    email VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);