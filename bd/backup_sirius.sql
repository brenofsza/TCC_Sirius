-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para bd_sirius
CREATE DATABASE IF NOT EXISTS `bd_sirius` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bd_sirius`;

-- Copiando estrutura para tabela bd_sirius.conteudo
CREATE TABLE IF NOT EXISTS `conteudo` (
  `ID_CONTEUDO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_DISCI` int(11) NOT NULL,
  `NOME_CONTEUDO` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_CONTEUDO`),
  KEY `COD_DISCI` (`COD_DISCI`),
  CONSTRAINT `conteudo_ibfk_1` FOREIGN KEY (`COD_DISCI`) REFERENCES `disciplina` (`ID_DISCI`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.conteudo: ~1 rows (aproximadamente)
INSERT INTO `conteudo` (`ID_CONTEUDO`, `COD_DISCI`, `NOME_CONTEUDO`) VALUES
	(1, 1, 'Revolução Francesa'),
	(2, 2, 'Trigonometria');

-- Copiando estrutura para tabela bd_sirius.disciplina
CREATE TABLE IF NOT EXISTS `disciplina` (
  `ID_DISCI` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_DISCI` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_DISCI`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.disciplina: ~1 rows (aproximadamente)
INSERT INTO `disciplina` (`ID_DISCI`, `NOME_DISCI`) VALUES
	(1, 'História'),
	(2, 'Matemática');

-- Copiando estrutura para tabela bd_sirius.ligacao
CREATE TABLE IF NOT EXISTS `ligacao` (
  `ID_LIGACAO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_USU_DESTINO` int(11) NOT NULL,
  `STATUS_LIGACAO` varchar(10) NOT NULL,
  `DATA_LIGACAO` date NOT NULL,
  PRIMARY KEY (`ID_LIGACAO`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_USU_DESTINO` (`COD_USU_DESTINO`),
  CONSTRAINT `ligacao_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `ligacao_ibfk_2` FOREIGN KEY (`COD_USU_DESTINO`) REFERENCES `usuario` (`ID_USU`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.ligacao: ~1 rows (aproximadamente)
INSERT INTO `ligacao` (`ID_LIGACAO`, `COD_USU`, `COD_USU_DESTINO`, `STATUS_LIGACAO`, `DATA_LIGACAO`) VALUES
	(6, 1, 2, 'ACEITA', '2026-09-29');

-- Copiando estrutura para tabela bd_sirius.material
CREATE TABLE IF NOT EXISTS `material` (
  `ID_MATERIAL` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_CONTEUDO` int(11) NOT NULL,
  `COD_NIVEL` int(11) NOT NULL,
  `TITULO_MATERIA` varchar(50) NOT NULL,
  `CAMINHO_ARQUIVO` varchar(255) NOT NULL,
  `NOME_ARQUIVO` varchar(255) NOT NULL,
  `DATA_CAD` datetime NOT NULL,
  `STATUS_MATERIA` varchar(10) NOT NULL,
  `DESCRICAO_MATERIA` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_MATERIAL`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_CONTEUDO` (`COD_CONTEUDO`),
  KEY `COD_NIVEL` (`COD_NIVEL`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `material_ibfk_2` FOREIGN KEY (`COD_CONTEUDO`) REFERENCES `conteudo` (`ID_CONTEUDO`),
  CONSTRAINT `material_ibfk_3` FOREIGN KEY (`COD_NIVEL`) REFERENCES `nivel_ensino` (`ID_NIVEL`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.material: ~3 rows (aproximadamente)
INSERT INTO `material` (`ID_MATERIAL`, `COD_USU`, `COD_CONTEUDO`, `COD_NIVEL`, `TITULO_MATERIA`, `CAMINHO_ARQUIVO`, `NOME_ARQUIVO`, `DATA_CAD`, `STATUS_MATERIA`, `DESCRICAO_MATERIA`) VALUES
	(1, 1, 1, 4, 'Rev Francesa slides', 'uploads/materiais/material_6aab3b0a0d9b48.71411581.pdf', '4216.Bruno Henrique Federici de Souza (1).pdf', '2026-09-17 00:00:00', 'PUBLICO', ''),
	(3, 1, 1, 2, 'ds', 'uploads/materiais/material_6ab98eab177432.15301607.webp', 'linhadotempo.webp', '2026-09-27 00:00:00', 'CONEXOES', 'ds'),
	(5, 1, 1, 1, 'ds', 'uploads/materiais/material_6abb1568e55b72.26993190.webp', 'img-curbix2_wide.webp', '2026-09-29 00:00:00', 'PUBLICO', 'ds'),
	(6, 1, 1, 1, 'ds', 'uploads/materiais/material_6abb157eb9a8f6.29177812.jpg', 'images.jpg', '2026-09-29 00:00:00', 'PRIVADO', 'ds'),
	(7, 1, 1, 1, 'dsdsds', 'uploads/materiais/material_6abb16d86183e2.69366630.jpg', 'images.jpg', '2026-09-29 00:00:00', 'CONEXOES', 'ds'),
	(8, 1, 1, 1, 'Rev Francesaaaaaaaaaaaaa', 'uploads/materiais/material_6abb1ff1b08989.00571086.jpg', 'images.jpg', '2026-09-29 04:18:25', 'PUBLICO', '');

-- Copiando estrutura para tabela bd_sirius.material_salvo
CREATE TABLE IF NOT EXISTS `material_salvo` (
  `ID_SALVO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_MATERIAL` int(11) NOT NULL,
  `COD_PASTA` int(11) NOT NULL,
  `DATA_SALVO` date NOT NULL,
  PRIMARY KEY (`ID_SALVO`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_PASTA` (`COD_PASTA`),
  KEY `fk_material_salvo` (`COD_MATERIAL`),
  CONSTRAINT `fk_material_salvo` FOREIGN KEY (`COD_MATERIAL`) REFERENCES `material` (`ID_MATERIAL`) ON DELETE CASCADE,
  CONSTRAINT `material_salvo_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `material_salvo_ibfk_3` FOREIGN KEY (`COD_PASTA`) REFERENCES `pasta` (`ID_PASTA`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.material_salvo: ~0 rows (aproximadamente)
INSERT INTO `material_salvo` (`ID_SALVO`, `COD_USU`, `COD_MATERIAL`, `COD_PASTA`, `DATA_SALVO`) VALUES
	(1, 1, 1, 1, '2026-09-19'),
	(2, 2, 3, 2, '2026-09-27'),
	(3, 2, 1, 2, '2026-09-28'),
	(4, 2, 7, 2, '2026-09-28');

-- Copiando estrutura para tabela bd_sirius.nivel_ensino
CREATE TABLE IF NOT EXISTS `nivel_ensino` (
  `ID_NIVEL` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_NIVEL` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_NIVEL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.nivel_ensino: ~4 rows (aproximadamente)
INSERT INTO `nivel_ensino` (`ID_NIVEL`, `NOME_NIVEL`) VALUES
	(1, 'Ens. Fundamental I'),
	(2, 'Ens. Fundamental II'),
	(3, 'Ens. Médio'),
	(4, 'Ens. Superior');

-- Copiando estrutura para tabela bd_sirius.pasta
CREATE TABLE IF NOT EXISTS `pasta` (
  `ID_PASTA` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `NOME_PASTA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_PASTA`),
  KEY `COD_USU` (`COD_USU`),
  CONSTRAINT `pasta_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.pasta: ~3 rows (aproximadamente)
INSERT INTO `pasta` (`ID_PASTA`, `COD_USU`, `NOME_PASTA`) VALUES
	(1, 1, 'Favoritos'),
	(2, 2, 'Favoritos'),
	(3, 3, 'Favoritos'),
	(4, 1, 'Matemática');

-- Copiando estrutura para tabela bd_sirius.planejamento
CREATE TABLE IF NOT EXISTS `planejamento` (
  `ID_PLANEJAMENTO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `TITULO_PLAN` varchar(50) NOT NULL,
  `ASSUNTO` varchar(100) NOT NULL,
  `DATA_AULA` date NOT NULL,
  `HORA_INICIO` time NOT NULL,
  `HORA_FIM` time NOT NULL,
  `SALA` varchar(50) NOT NULL,
  `STATUS_PLAN` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_PLANEJAMENTO`),
  KEY `COD_USU` (`COD_USU`),
  CONSTRAINT `planejamento_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.planejamento: ~4 rows (aproximadamente)
INSERT INTO `planejamento` (`ID_PLANEJAMENTO`, `COD_USU`, `TITULO_PLAN`, `ASSUNTO`, `DATA_AULA`, `HORA_INICIO`, `HORA_FIM`, `SALA`, `STATUS_PLAN`) VALUES
	(9, 1, 'Rev Francesa slides', 'assssssssssss', '2026-09-08', '19:15:00', '20:15:00', '3meca', 'PLANEJADA'),
	(10, 1, 'Rev Francssssssssssssssssssss', 'sa', '2026-09-08', '20:30:00', '21:26:00', 'ds', 'PLANEJADA'),
	(13, 1, 'sda', 'sadad', '2026-09-26', '18:02:00', '19:03:00', 'dsa', 'PLANEJADA'),
	(14, 1, 'gffgfg', 'fggh', '2026-09-30', '15:05:00', '17:07:00', 'sa', 'PLANEJADA'),
	(15, 2, 'dsa', 'dsa', '2026-09-30', '20:32:00', '22:34:00', 'dsa', 'PLANEJADA'),
	(16, 1, 'ds', 'ds', '2026-09-30', '11:36:00', '13:37:00', 'ds', 'PLANEJADA');

-- Copiando estrutura para tabela bd_sirius.planejamento_material
CREATE TABLE IF NOT EXISTS `planejamento_material` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `COD_PLANEJAMENTO` int(11) NOT NULL,
  `COD_MATERIAL` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `COD_PLANEJAMENTO` (`COD_PLANEJAMENTO`),
  KEY `fk_planejamento_material` (`COD_MATERIAL`),
  CONSTRAINT `fk_planejamento_material` FOREIGN KEY (`COD_MATERIAL`) REFERENCES `material` (`ID_MATERIAL`) ON DELETE CASCADE,
  CONSTRAINT `planejamento_material_ibfk_1` FOREIGN KEY (`COD_PLANEJAMENTO`) REFERENCES `planejamento` (`ID_PLANEJAMENTO`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.planejamento_material: ~1 rows (aproximadamente)
INSERT INTO `planejamento_material` (`ID`, `COD_PLANEJAMENTO`, `COD_MATERIAL`) VALUES
	(9, 10, 1);

-- Copiando estrutura para tabela bd_sirius.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `ID_USU` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_USU` varchar(50) NOT NULL,
  `EMAIL_USU` varchar(60) NOT NULL,
  `SENHA_USU` varchar(255) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `DESCRICAO_USU` varchar(200) DEFAULT NULL,
  `FOTO_USU` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_USU`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.usuario: ~3 rows (aproximadamente)
INSERT INTO `usuario` (`ID_USU`, `NOME_USU`, `EMAIL_USU`, `SENHA_USU`, `USERNAME`, `DESCRICAO_USU`, `FOTO_USU`) VALUES
	(1, 'Breno', 'breno@gmail.com', '$2y$10$qIVN8BY0CslziQZQzfOQUOdBXr0AqzrxDKNpPRgTKGFvxfYqN44OG', 'Souza', NULL, NULL),
	(2, 'Anna', 'nakarla@gmail.com', '$2y$10$noECyQ3aZAQkfTVrSFiFzOTOBtatK2h9XmMlklGssvBBcz52rxIG6', 'nakarla', NULL, NULL),
	(3, 'jose', 'jose@gmail.com', '$2y$10$5egUquuc1iLvScpuc3.eTuKIJ0dHfng1fhdmm7/sxktMJu.1ffMqu', 'jose', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
