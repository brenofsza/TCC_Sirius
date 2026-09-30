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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.conteudo: ~8 rows (aproximadamente)
INSERT INTO `conteudo` (`ID_CONTEUDO`, `COD_DISCI`, `NOME_CONTEUDO`) VALUES
	(1, 1, 'Revolução Francesa'),
	(2, 1, 'Ditadura Militar'),
	(3, 1, 'Primeira Guera Mundial'),
	(4, 1, 'Guerra da Bastilha'),
	(5, 3, 'Trigonometria'),
	(6, 3, 'Análise Combinatória'),
	(7, 3, 'Matrizes'),
	(8, 3, 'Equação de 2º grau');

-- Copiando estrutura para tabela bd_sirius.disciplina
CREATE TABLE IF NOT EXISTS `disciplina` (
  `ID_DISCI` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_DISCI` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_DISCI`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.disciplina: ~0 rows (aproximadamente)
INSERT INTO `disciplina` (`ID_DISCI`, `NOME_DISCI`) VALUES
	(1, 'História'),
	(2, 'Geografia'),
	(3, 'Matemática'),
	(4, 'Biologia'),
	(5, 'Física'),
	(6, 'Língua Portuguesa'),
	(7, 'Língua Inglesa');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.ligacao: ~0 rows (aproximadamente)
INSERT INTO `ligacao` (`ID_LIGACAO`, `COD_USU`, `COD_USU_DESTINO`, `STATUS_LIGACAO`, `DATA_LIGACAO`) VALUES
	(1, 1, 2, 'ACEITA', '2026-09-30'),
	(2, 2, 3, 'ACEITA', '2026-09-30'),
	(3, 3, 1, 'ACEITA', '2026-09-30');

-- Copiando estrutura para tabela bd_sirius.material
CREATE TABLE IF NOT EXISTS `material` (
  `ID_MATERIAL` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_CONTEUDO` int(11) NOT NULL,
  `COD_NIVEL` int(11) NOT NULL,
  `TITULO_MATERIA` varchar(100) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.material: ~0 rows (aproximadamente)
INSERT INTO `material` (`ID_MATERIAL`, `COD_USU`, `COD_CONTEUDO`, `COD_NIVEL`, `TITULO_MATERIA`, `CAMINHO_ARQUIVO`, `NOME_ARQUIVO`, `DATA_CAD`, `STATUS_MATERIA`, `DESCRICAO_MATERIA`) VALUES
	(1, 1, 5, 3, 'Trigonometria - resumo', 'uploads/materiais/material_6abc7b140c94a3.90586806.webp', 'trig.webp', '2026-09-30 04:59:32', 'PUBLICO', 'Resumo de trigonometria para auxiliar alunos'),
	(2, 1, 7, 3, 'Exercícios de Matrizes', 'uploads/materiais/material_6abc7b6cc9efa8.61123451.jpg', 'matriz.jpg', '2026-09-30 05:01:00', 'CONEXOES', 'Exercícios para introdução da conteúdo de matrizes'),
	(3, 1, 6, 3, 'Mapa mental de análise combinatória', 'uploads/materiais/material_6abc7cbd18a196.90477247.webp', 'analise.webp', '2026-09-30 05:06:37', 'PUBLICO', ''),
	(4, 1, 8, 2, 'Equação de 2º grau - formula', 'uploads/materiais/material_6abc7d6bad2ae8.50596707.webp', 'equa.webp', '2026-09-30 05:09:31', 'PUBLICO', ''),
	(5, 2, 1, 2, 'Revolução Francesa - Mapa Mental', 'uploads/materiais/material_6abc81a4ec0e25.03334561.webp', 'mapamentalrevolucaofrancesa-cke.webp', '2026-09-30 05:27:32', 'PUBLICO', ''),
	(6, 2, 2, 2, 'Linha do tempo - Ditadura', 'uploads/materiais/material_6abc81d08b14b1.19755632.jpg', 'presidentes_e_periodos_2-scaled.jpg', '2026-09-30 05:28:16', 'PUBLICO', '');

-- Copiando estrutura para tabela bd_sirius.material_salvo
CREATE TABLE IF NOT EXISTS `material_salvo` (
  `ID_SALVO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_MATERIAL` int(11) NOT NULL,
  `COD_PASTA` int(11) NOT NULL,
  `DATA_SALVO` date NOT NULL,
  PRIMARY KEY (`ID_SALVO`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_MATERIAL` (`COD_MATERIAL`),
  KEY `COD_PASTA` (`COD_PASTA`),
  CONSTRAINT `material_salvo_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `material_salvo_ibfk_2` FOREIGN KEY (`COD_MATERIAL`) REFERENCES `material` (`ID_MATERIAL`) ON DELETE CASCADE,
  CONSTRAINT `material_salvo_ibfk_3` FOREIGN KEY (`COD_PASTA`) REFERENCES `pasta` (`ID_PASTA`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.material_salvo: ~0 rows (aproximadamente)
INSERT INTO `material_salvo` (`ID_SALVO`, `COD_USU`, `COD_MATERIAL`, `COD_PASTA`, `DATA_SALVO`) VALUES
	(1, 1, 3, 4, '2026-09-30');

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

-- Copiando dados para a tabela bd_sirius.pasta: ~0 rows (aproximadamente)
INSERT INTO `pasta` (`ID_PASTA`, `COD_USU`, `NOME_PASTA`) VALUES
	(1, 1, 'Favoritos'),
	(2, 2, 'Favoritos'),
	(3, 3, 'Favoritos'),
	(4, 1, 'Ensino Médio');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.planejamento: ~0 rows (aproximadamente)
INSERT INTO `planejamento` (`ID_PLANEJAMENTO`, `COD_USU`, `TITULO_PLAN`, `ASSUNTO`, `DATA_AULA`, `HORA_INICIO`, `HORA_FIM`, `SALA`, `STATUS_PLAN`) VALUES
	(1, 1, 'Trigonometria - resumo', '', '2026-09-30', '14:40:00', '15:30:00', '9º A - Liceu', 'PLANEJADA'),
	(2, 1, 'Análise Combinatória - teoria', '', '2026-09-30', '15:45:00', '16:35:00', '9º C - Liceu', 'PLANEJADA'),
	(3, 1, 'Matrizes - Introdução', '', '2026-10-01', '07:00:00', '07:50:00', '1º DSA - Phila', 'PLANEJADA'),
	(4, 2, 'Revolução Francesa - Mapa Mental', '', '2026-10-01', '07:00:00', '07:50:00', '1º Meca - Phila', 'PLANEJADA');

-- Copiando estrutura para tabela bd_sirius.planejamento_material
CREATE TABLE IF NOT EXISTS `planejamento_material` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `COD_PLANEJAMENTO` int(11) NOT NULL,
  `COD_MATERIAL` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `COD_PLANEJAMENTO` (`COD_PLANEJAMENTO`),
  KEY `COD_MATERIAL` (`COD_MATERIAL`),
  CONSTRAINT `planejamento_material_ibfk_1` FOREIGN KEY (`COD_PLANEJAMENTO`) REFERENCES `planejamento` (`ID_PLANEJAMENTO`),
  CONSTRAINT `planejamento_material_ibfk_2` FOREIGN KEY (`COD_MATERIAL`) REFERENCES `material` (`ID_MATERIAL`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.planejamento_material: ~0 rows (aproximadamente)
INSERT INTO `planejamento_material` (`ID`, `COD_PLANEJAMENTO`, `COD_MATERIAL`) VALUES
	(1, 1, 1),
	(2, 2, 3),
	(3, 3, 2),
	(4, 4, 5);

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

-- Copiando dados para a tabela bd_sirius.usuario: ~0 rows (aproximadamente)
INSERT INTO `usuario` (`ID_USU`, `NOME_USU`, `EMAIL_USU`, `SENHA_USU`, `USERNAME`, `DESCRICAO_USU`, `FOTO_USU`) VALUES
	(1, 'Breno', 'breno@gmail.com', '$2y$10$WC.a6nqdKKLCdkximSx.W.7rze4pNMlqQj11iabb68qx2.J9izUAO', 'breno_souza', NULL, NULL),
	(2, 'Anna Karla', 'anna@gmail.com', '$2y$10$iTuBJAihtoEDEpwMDFuGTOmIaU4sqqR1K6mj20iPUZxWtvrmqvT6S', 'anna_mp', 'Professora de História - Etec Phila', NULL),
	(3, 'Henrique', 'henrique@gmail.com', '$2y$10$8cSLmLyLk2u7nCOtAUKqaOFnM/jTr5HU3FF9G40niIPh.KL3z6bqK', 'martinelli', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
