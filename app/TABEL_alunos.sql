CREATE TABLE alunos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    nasc DATE,
    turma VARCHAR(50)
    ativo BOOLEAN
    email VARCHAR(100)
)

SELECT * FROM alunos;