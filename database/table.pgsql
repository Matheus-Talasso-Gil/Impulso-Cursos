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
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL DEFAULT 'usuario',
    CONSTRAINT usuarios_tipo_check CHECK (tipo IN ('usuario', 'admin')),
    CONSTRAINT usuarios_admin_email_check CHECK (tipo <> 'admin' OR lower(email) = 'matheus321@gmail.com')
);