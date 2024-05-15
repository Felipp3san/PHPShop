CREATE TABLE `cliente` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome_completo` varchar(100) not null,
  `email` varchar(50) not null,
  `senha` varchar(255) not null,
  `morada` varchar(100) not null,
  `cidade` varchar(50) not null,
  `telefone` varchar(50),
  `ativo` tinyint not null,
  `personal_url` varchar(50),
  `created_at` datetime default now(),
  `updated_at` datetime default now() on update now(),
  `deleted_at` datetime default null
);

CREATE TABLE `morada_faturacao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(50) not null,
  `apelido` varchar(50) not null,
  `morada` varchar(50) not null,
  `cidade` varchar(50) not null,
  `cod_postal` varchar(25) not null,
  `telefone` varchar(50),
  `nif` varchar(50) not null,
  `cliente_id` int not null
)

ALTER TABLE `morada_faturacao` ADD FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

CREATE TABLE `gestor` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `utilizador` varchar(100) not null,
  `senha` varchar(255) not null,
  `ativo` tinyint not null,
  `created_at` datetime default now(),
  `updated_at` datetime default now() on update now(),
  `deleted_at` datetime default null
);

CREATE TABLE `produto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) not null,
  `descricao` varchar(255),
  `fabricante_id` int not null,
  `preco` decimal(6,2) not null,
  `quantidade` int not null,
  `categoria_id` int not null,
  `imagem` varchar(255),
  `ativo` tinyint not null,
  `created_at` datetime default now(),
  `updated_at` datetime default now() on update now(),
  `deleted_at` datetime default null
);

CREATE TABLE `favorito` (
  `item_id` int not null,
  `cliente_id` int not null 
);

ALTER TABLE `favorito` ADD FOREIGN KEY (`item_id`) REFERENCES `produto` (`id`);
ALTER TABLE `favorito` ADD FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

CREATE TABLE `fabricante` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) not null,
);



INSERT INTO `fabricante` (`nome`) VALUES
('Asus'),
('Intel'),
('AMD'),
('Seagate'),
('Corsair');

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Processador Intel Core i7-10700KF 8-Core 3.8GHz c/ Turbo 5.1GHz 16MB Skt1200', '8 Núcleos | 16 Threads | 3.8GHz Clock Base | 5.1GHz Clock Turbo | 16MB Cache | TDP 95W', 399.99, 30, 1, 'Processadores/Intel_Core_i7_10700k.png', 1);

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Processador Intel Core i7-13700K (13ª Geração) "Raptor Lake" 16-Core 2.5GHz c/Turbo 5.4GHz 30MB Cache Skt1700', 'UHD Graphics 770 | 16 Núcleos | 24 Threads | 2.5GHz Clock Base | 5.4GHz Clock Turbo | 30MB Cache | TDP 253W', 459.90, 10, 1, 'Processadores/Intel_i7_13700k.png', 1);

INSERT INTO produto (nome, descricao, fabricante, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Processador Intel Core i7-14700KF (14ª Geração) "Raptor Lake Refresh" 20-Core 2.5GHz c/Turbo 5.6GHz 33MB Cache Skt1700', '20 Núcleos | 28 Threads | 2.5GHz Clock Base | 5.6GHz Clock Turbo | 33MB Cache | TDP 125W', 'Intel' ,439.90, 0, 1, 'Processadores/Intel_Core_i7_14700KF.png', 1);

INSERT INTO produto (nome, descricao, fabricante, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Processador AMD Ryzen 9 7950X3D "Zen 4" 16-Core 4.2GHz c/ Turbo 5.7GHz 144MB Cache SktAM5', 'Radeon Graphics | 16 Núcleos | 32 Threads | 4.2GHz Clock Base | 5.7GHz Clock Turbo | 144MB Cache | TDP 120W', 'AMD' ,649.90, 4, 1, 'processadores/AMD_Ryzen_9_7950X3D.png', 1);

INSERT INTO produto (nome, descricao, fabricante, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Processador AMD Ryzen 7 7800X3D "Zen 4" 8-Core 4.2GHz c/ Turbo 5.0GHz 104MB Cache SktAM5', 'Radeon Graphics | 8 Núcleos | 16 Threads | 4.4GHz Clock Base | 5.0GHz Clock Turbo | 104MB Cache | TDP 120W', 3 ,394.90, 15, 1, 'processadores/AMD_Ryzen_7_7800X3D.png', 1);

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('NVIDIA GeForce RTX 3080', 'Placa de vídeo poderosa para jogos e renderização.', 799.99, 20, 2, 'rtx_3080.jpg', 1);

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Corsair Vengeance LPX 16GB', 'Módulo de memória RAM DDR4 de 16GB.', 89.99, 50, 3, 'ram_16gb.jpg', 1);

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('ASUS ROG Strix Z490-E Gaming', 'Placa-mãe ATX com suporte a processadores Intel.', 299.99, 15, 4, 'rog_strix_z490.jpg', 1);

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Seagate Barracuda 2TB', 'Disco rígido de 2TB para armazenamento de dados.', 79.99, 40, 5, 'barracuda_2tb.jpg', 1);

INSERT INTO produto (nome, descricao, preco, quantidade, categoria_id, imagem, ativo) 
VALUES ('Processador AMD Ryzen 7 5800X "Zen 3" 8-Core 3.8GHz c/ Turbo 4.7GHz 36MB Cache SktAM4', '6 Núcleos | 12 Threads | 3.7GHz Clock Base | 4.6GHz Clock Turbo | 35MB Cache | TDP 65W', 149.90, 20, 1, 'Processadores/AMD_Ryzen_7_5800X.jpeg', 1);


CREATE TABLE `categoria` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) not null,
  `descricao` varchar(255)
);

INSERT INTO categoria (nome, descricao) VALUES ('Processadores', 'Unidades centrais de processamento (CPUs).');
INSERT INTO categoria (nome, descricao) VALUES ('Placas de Vídeo', 'Placas gráficas para processamento de vídeo.');
INSERT INTO categoria (nome, descricao) VALUES ('Memórias RAM', 'Módulos de memória para armazenamento temporário de dados.');
INSERT INTO categoria (nome, descricao) VALUES ('Placas-Mãe', 'Placas de circuito principal para montagem de componentes de hardware.');
INSERT INTO categoria (nome, descricao) VALUES ('Discos Rígidos', 'Dispositivos de armazenamento de dados magnéticos.');

CREATE TABLE `pedido` (
  `num_pedido` int PRIMARY KEY,
  `data_pedido` datetime default now(),
  `morada_entrega` varchar(100) not null,
  `observacoes` varchar(255),
  `cliente_id` int not null,
  `metodo_pagamento_id` int not null,
  `estado_pagamento_id` int not null,
  `estado_entrega_id` int not null,
  `cod_rastreamento` varchar(50),
  `ativo` tinyint not null,
  `created_at` datetime default now(),
  `updated_at` datetime default now() on update now(),
  `deleted_at` datetime default null
);

CREATE TABLE `estado_entrega` (
  `id` int PRIMARY KEY,
  `estado` varchar(100) not null,
  `descrição` varchar(255) 
);

INSERT INTO estado_entrega (id, estado, descrição) VALUES (1, 'Pendente', 'A entrega ainda não foi realizada.');
INSERT INTO estado_entrega (id, estado, descrição) VALUES (2, 'Em trânsito', 'A entrega está em processo de transporte.');
INSERT INTO estado_entrega (id, estado, descrição) VALUES (3, 'Entregue', 'A entrega foi concluída com sucesso.');
INSERT INTO estado_entrega (id, estado, descrição) VALUES (4, 'Devolvida', 'A entrega foi devolvida ao remetente ou ao ponto de origem.');

CREATE TABLE `estado_pagamento` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `estado` varchar(100) not null,
  `descrição` varchar(255) 
);

INSERT INTO estado_pagamento (estado, descrição) VALUES ('Pendente', 'Pagamento ainda não realizado.');
INSERT INTO estado_pagamento (estado, descrição) VALUES ('Concluído', 'Pagamento realizado com sucesso.');
INSERT INTO estado_pagamento (estado, descrição) VALUES ('Cancelado', 'Pagamento cancelado pelo cliente ou sistema.');
INSERT INTO estado_pagamento (estado, descrição) VALUES ('Reembolsado', 'Pagamento reembolsado ao cliente.');

CREATE TABLE `item_pedido` (
  `num_pedido` int PRIMARY KEY,
  `item_id` int not null,
  `quantidade` int not null,
  `preco` decimal(6,2) not null
);

CREATE TABLE `item_carrinho` (
  `item_id` int not null,
  `quantidade` int not null,
  `preco` decimal(6,2) not null,
  `data_adicao` datetime not null default now(),
  `cliente_id` int,
  `session_id` varchar(255)
);

CREATE TABLE `review` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `cliente_id` int not null,
  `produto_id` int not null,
  `avaliacao` tinyint not null,
  `texto` varchar(255),
  `data_adicao` datetime not null default now()
);

INSERT INTO review (cliente_id, produto_id, avaliacao, texto)
VALUES (3, 4, 5, 'Excelente placa-mãe com ótimo suporte para processadores Intel.');
INSERT INTO review (cliente_id, produto_id, avaliacao, texto)
VALUES (4, 4, 3, 'Boa placa-mãe, mas poderia ter mais recursos de conectividade.');

CREATE TABLE `item_historico_pedido` (
  `num_pedido` int not null,
  `cliente_id` int not null
);

CREATE TABLE `metodo_pagamento` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tipo` varchar(50) not null
);

INSERT INTO metodo_pagamento (tipo) VALUES ('Cartão de crédito');
INSERT INTO metodo_pagamento (tipo) VALUES ('Cartão de débito');
INSERT INTO metodo_pagamento (tipo) VALUES ('Transferência bancária');
INSERT INTO metodo_pagamento (tipo) VALUES ('PayPal');

ALTER TABLE `pedido` ADD FOREIGN KEY (`estado_entrega_id`) REFERENCES `estado_entrega` (`id`);

ALTER TABLE `pedido` ADD FOREIGN KEY (`estado_pagamento_id`) REFERENCES `estado_pagamento` (`id`);

ALTER TABLE `produto` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `item_pedido` ADD FOREIGN KEY (`num_pedido`) REFERENCES `pedido` (`num_pedido`);

ALTER TABLE `item_pedido` ADD FOREIGN KEY (`item_id`) REFERENCES `produto` (`id`);

ALTER TABLE `item_carrinho` ADD FOREIGN KEY (`item_id`) REFERENCES `produto` (`id`);

ALTER TABLE `item_carrinho` ADD FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

ALTER TABLE `review` ADD FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

ALTER TABLE `review` ADD FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

ALTER TABLE `item_historico_pedido` ADD FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

ALTER TABLE `pedido` ADD FOREIGN KEY (`num_pedido`) REFERENCES `item_historico_pedido` (`num_pedido`);

ALTER TABLE `pedido` ADD FOREIGN KEY (`metodo_pagamento_id`) REFERENCES `metodo_pagamento` (`id`);

ALTER TABLE `produto` ADD FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`);

            SELECT produto.*, AVG(review.avaliacao) AS 'avaliacao_media', COUNT(review.id) AS 'total_avaliacoes' 
            FROM produto 
            LEFT JOIN review ON produto.id = review.produto_id 
            GROUP BY produto.id;