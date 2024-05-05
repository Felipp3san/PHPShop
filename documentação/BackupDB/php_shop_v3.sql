-- MySQL dump 10.13  Distrib 8.3.0, for macos14 (arm64)
--
-- Host: 62.28.39.135    Database: php_shop
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`id`, `nome`, `descricao`) VALUES (1,'Processadores','Unidades centrais de processamento (CPUs).'),(2,'Placas de Vídeo','Placas gráficas para processamento de vídeo.'),(3,'Memórias RAM','Módulos de memória para armazenamento temporário de dados.'),(4,'Placas-Mãe','Placas de circuito principal para montagem de componentes de hardware.'),(5,'Discos Rígidos','Dispositivos de armazenamento de dados magnéticos.');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `morada` varchar(100) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `personal_url` varchar(50) DEFAULT NULL,
  `ativo` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id`, `nome_completo`, `email`, `senha`, `morada`, `cidade`, `telefone`, `personal_url`, `ativo`, `created_at`, `updated_at`, `deleted_at`) VALUES (3,'felippe de almeida santana','f-elipp-3@hotmail.com','$2y$10$D98dk67xgzrpRsUcf/juy.Wu6DTawfZHEFAHR18sQbkAd60DiZJKq','rua gabriel pereira de castro 18, 1º','braga','914046960','',1,'2024-05-02 12:45:04','2024-05-02 22:20:35',NULL),(4,'teste','teste@gmail.com','$2y$10$ciu9EUx.xkWyPaS1TGuxJebPq5V0drZEO4DLSDE.sNKiCuRQdc66G','teste','teste','','',1,'2024-05-02 12:46:16','2024-05-02 22:20:35',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_entrega`
--

DROP TABLE IF EXISTS `estado_entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_entrega` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) NOT NULL,
  `descrição` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_entrega`
--

LOCK TABLES `estado_entrega` WRITE;
/*!40000 ALTER TABLE `estado_entrega` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado_entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_pagamento`
--

DROP TABLE IF EXISTS `estado_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) NOT NULL,
  `descrição` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_pagamento`
--

LOCK TABLES `estado_pagamento` WRITE;
/*!40000 ALTER TABLE `estado_pagamento` DISABLE KEYS */;
INSERT INTO `estado_pagamento` (`id`, `estado`, `descrição`) VALUES (1,'Pendente','Pagamento ainda não realizado.'),(2,'Concluído','Pagamento realizado com sucesso.'),(3,'Cancelado','Pagamento cancelado pelo cliente ou sistema.'),(4,'Reembolsado','Pagamento reembolsado ao cliente.');
/*!40000 ALTER TABLE `estado_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fabricante`
--

DROP TABLE IF EXISTS `fabricante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fabricante` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fabricante`
--

LOCK TABLES `fabricante` WRITE;
/*!40000 ALTER TABLE `fabricante` DISABLE KEYS */;
INSERT INTO `fabricante` (`id`, `nome`) VALUES (1,'Asus'),(2,'Intel'),(3,'AMD'),(4,'Seagate'),(5,'Corsair');
/*!40000 ALTER TABLE `fabricante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestor`
--

DROP TABLE IF EXISTS `gestor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestor`
--

LOCK TABLES `gestor` WRITE;
/*!40000 ALTER TABLE `gestor` DISABLE KEYS */;
INSERT INTO `gestor` (`id`, `utilizador`, `senha`, `ativo`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'admin','123',1,'2024-05-02 22:13:56','2024-05-02 22:13:56',NULL);
/*!40000 ALTER TABLE `gestor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_carrinho`
--

DROP TABLE IF EXISTS `item_carrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_carrinho` (
  `item_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `preco` decimal(6,2) DEFAULT NULL,
  `data_adicao` datetime DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  KEY `item_id` (`item_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `item_carrinho_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `produto` (`id`),
  CONSTRAINT `item_carrinho_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_carrinho`
--

LOCK TABLES `item_carrinho` WRITE;
/*!40000 ALTER TABLE `item_carrinho` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_carrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_historico_pedido`
--

DROP TABLE IF EXISTS `item_historico_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_historico_pedido` (
  `num_pedido` int DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  KEY `cliente_id` (`cliente_id`),
  KEY `num_pedido` (`num_pedido`),
  CONSTRAINT `item_historico_pedido_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `item_historico_pedido_ibfk_2` FOREIGN KEY (`num_pedido`) REFERENCES `pedido` (`num_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_historico_pedido`
--

LOCK TABLES `item_historico_pedido` WRITE;
/*!40000 ALTER TABLE `item_historico_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_historico_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_pedido`
--

DROP TABLE IF EXISTS `item_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_pedido` (
  `num_pedido` int NOT NULL,
  `item_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `preco` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`num_pedido`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_pedido_ibfk_1` FOREIGN KEY (`num_pedido`) REFERENCES `pedido` (`num_pedido`),
  CONSTRAINT `item_pedido_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `produto` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_pedido`
--

LOCK TABLES `item_pedido` WRITE;
/*!40000 ALTER TABLE `item_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodo_pagamento`
--

DROP TABLE IF EXISTS `metodo_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodo_pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodo_pagamento`
--

LOCK TABLES `metodo_pagamento` WRITE;
/*!40000 ALTER TABLE `metodo_pagamento` DISABLE KEYS */;
INSERT INTO `metodo_pagamento` (`id`, `tipo`) VALUES (1,'Cartão de crédito'),(2,'Cartão de débito'),(3,'Transferência bancária'),(4,'PayPal');
/*!40000 ALTER TABLE `metodo_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `num_pedido` int NOT NULL AUTO_INCREMENT,
  `data_pedido` datetime DEFAULT NULL,
  `morada_entrega` varchar(100) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  `metodo_pagamento_id` int DEFAULT NULL,
  `estado_pagamento_id` int DEFAULT NULL,
  `estado_entrega_id` int DEFAULT NULL,
  `cod_rastreamento` varchar(50) DEFAULT NULL,
  `ativo` tinyint DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`num_pedido`),
  KEY `estado_entrega_id` (`estado_entrega_id`),
  KEY `estado_pagamento_id` (`estado_pagamento_id`),
  KEY `metodo_pagamento_id` (`metodo_pagamento_id`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`estado_entrega_id`) REFERENCES `estado_entrega` (`id`),
  CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`estado_pagamento_id`) REFERENCES `estado_pagamento` (`id`),
  CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`metodo_pagamento_id`) REFERENCES `metodo_pagamento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `fabricante_id` int NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `quantidade` int NOT NULL,
  `categoria_id` int NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `ativo` tinyint NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `fabricante_id` (`fabricante_id`),
  CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`id`, `nome`, `descricao`, `fabricante_id`, `preco`, `quantidade`, `categoria_id`, `imagem`, `ativo`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'Processador Intel Core i7-10700KF 8-Core 3.8GHz c/ Turbo 5.1GHz 16MB Skt1200','8 Núcleos | 16 Threads | 3.8GHz Clock Base | 5.1GHz Clock Turbo | 16MB Cache | TDP 95W',2,399.99,30,1,'processadores/Intel_Core_i7_10700K.png',1,'2024-05-02 10:38:23','2024-05-02 21:52:05',NULL),(2,'Placa Gráfica ASUS ROG Strix NVIDIA GeForce RTX 3080 OC Edition','Placa de vídeo poderosa para jogos e renderização.',1,799.99,20,2,'Produtos/ASUS_ROG_Strix_NVIDIA_GeForce_RTX_3080_OC_Edition.png',1,'2024-05-02 10:38:23','2024-05-02 21:52:11',NULL),(3,'Memória RAM Corsair Vengeance LPX 16GB (1x16GB) DDR4-3200MHz CL16','Módulo de memória RAM DDR4 de 16GB.',5,89.99,0,3,'Produtos/Corsair_Vengeance_LPX_16GB.png',1,'2024-05-02 10:38:23','2024-05-02 21:52:18',NULL),(4,'Motherboard ASUS ROG Strix Z490-E Gaming','Placa-mãe ATX com suporte a processadores Intel.',1,299.99,15,4,'Produtos/ASUS_ROG_Strix_Z490E_Gaming.png',1,'2024-05-02 10:38:23','2024-05-02 21:52:26',NULL),(5,'Disco Seagate Barracuda 2TB 7200rpm 256MB SATA III','Disco rígido de 2TB para armazenamento de dados.',4,79.99,40,5,'Produtos/Seagate_Barracuda_2TB_7200rpm_256MB_SATA_III.png',1,'2024-05-02 10:38:23','2024-05-02 21:52:32',NULL),(6,'Processador AMD Ryzen 7 5800X \"Zen 3\" 8-Core 3.8GHz c/ Turbo 4.7GHz 36MB Cache SktAM4','6 Núcleos | 12 Threads | 3.7GHz Clock Base | 4.6GHz Clock Turbo | 35MB Cache | TDP 65W',3,149.90,20,1,'processadores/AMD_Ryzen_7_5800X.png',1,'2024-05-02 14:14:04','2024-05-02 21:52:38',NULL),(7,'Processador Intel Core i7-13700K (13ª Geração) \"Raptor Lake\" 16-Core 2.5GHz c/Turbo 5.4GHz 30MB Cache Skt1700','UHD Graphics 770 | 16 Núcleos | 24 Threads | 2.5GHz Clock Base | 5.4GHz Clock Turbo | 30MB Cache | TDP 253W',2,459.90,10,1,'processadores/Intel_Core_i7_13700K.png',1,'2024-05-02 21:26:59','2024-05-02 21:52:45',NULL),(8,'Processador Intel Core i7-14700KF (14ª Geração) \"Raptor Lake Refresh\" 20-Core 2.5GHz c/Turbo 5.6GHz 33MB Cache Skt1700','20 Núcleos | 28 Threads | 2.5GHz Clock Base | 5.6GHz Clock Turbo | 33MB Cache | TDP 125W',2,439.90,0,1,'Processadores/Intel_Core_i7_14700KF.png',1,'2024-05-02 21:38:46','2024-05-02 21:52:52',NULL),(9,'Processador AMD Ryzen 9 7950X3D \"Zen 4\" 16-Core 4.2GHz c/ Turbo 5.7GHz 144MB Cache SktAM5','Radeon Graphics | 16 Núcleos | 32 Threads | 4.2GHz Clock Base | 5.7GHz Clock Turbo | 144MB Cache | TDP 120W',3,649.90,4,1,'processadores/AMD_Ryzen_9_7950X3D.png',1,'2024-05-02 21:43:45','2024-05-02 21:52:59',NULL),(10,'Processador AMD Ryzen 7 7800X3D \"Zen 4\" 8-Core 4.2GHz c/ Turbo 5.0GHz 104MB Cache SktAM5','Radeon Graphics | 8 Núcleos | 16 Threads | 4.4GHz Clock Base | 5.0GHz Clock Turbo | 104MB Cache | TDP 120W',3,394.90,15,1,'processadores/AMD_Ryzen_7_7800X3D.png',1,'2024-05-02 21:58:47','2024-05-02 21:58:47',NULL);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `avaliacao` tinyint DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `data_adicao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` (`id`, `cliente_id`, `produto_id`, `avaliacao`, `texto`, `data_adicao`) VALUES (3,3,4,5,'Excelente placa-mãe com ótimo suporte para processadores Intel.',NULL),(4,4,4,3,'Boa placa-mãe, mas poderia ter mais recursos de conectividade.',NULL);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-02 23:33:33
