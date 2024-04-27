CREATE TABLE cliente (
    id INT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);


-- ALTER TABLE cliente
-- MODIFY COLUMN id INT AUTO_INCREMENT; 

INSERT INTO cliente(nome) VALUES ("Felippe");
INSERT INTO cliente(nome) VALUES ("Rhuanna");
INSERT INTO cliente(nome) VALUES ("Fausto");


ALTER TABLE cliente
ADD COLUMN email VARCHAR(50) NOT NULL,
ADD COLUMN senha VARCHAR(250) NOT NULL,
ADD COLUMN morada VARCHAR(100),
ADD COLUMN cidade VARCHAR(50),
ADD COLUMN telefone VARCHAR(50),
ADD COLUMN personal_url VARCHAR(50),
ADD COLUMN ativo TINYINT NOT NULL DEFAULT 0,
ADD COLUMN created_at DATETIME NOT NULL DEFAULT NOW(),
ADD COLUMN updated_at DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW(),
ADD COLUMN deleted_at DATETIME;

CLIENTE:
--------------
id
nome_completo
email
senha
morada
cidade
telefone
personal_url
ativo
created_at
updated_at
deleted_at