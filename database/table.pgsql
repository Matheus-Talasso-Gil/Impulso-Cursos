CREATE TABLE alunos(
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    turma VARCHAR(255),
    nasc DATE,
    ativo BOOLEAN
);

CREATE TABLE usuarios(
    id SERIAL PRIMARY KEY,
    email VARCHAR(255),
    senha VARCHAR(255)
);

INSERT INTO usuarios (email, senha) VALUES('matheus@gmail.com','matheus2010');
