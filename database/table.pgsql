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

-- cria a tabela somente se ela ainda nao existir
CREATE TABLE IF NOT EXISTS cursos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    carga_horaria INTEGER NOT NULL
);

-- cria a tabela de inscricoes cria a tabela somente se ela ainda nao existir
CREATE TABLE IF NOT EXISTS inscricoes (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER NOT NULL,
    curso_id INTEGER NOT NULL,

    -- relaciona a inscricao com o usuario
    CONSTRAINT fk_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id),

    -- relaciona a inscricao com o curso
    CONSTRAINT fk_curso
        FOREIGN KEY (curso_id)
        REFERENCES cursos(id),

    -- impede inscricao duplicada no mesmo curso
    CONSTRAINT inscricao_unica
        UNIQUE (usuario_id, curso_id)
);
