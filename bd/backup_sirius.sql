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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.conteudo: ~5 rows (aproximadamente)
INSERT INTO `conteudo` (`ID_CONTEUDO`, `COD_DISCI`, `NOME_CONTEUDO`) VALUES
	(1, 1, 'Ditadura Militar'),
	(2, 2, 'Crase'),
	(3, 4, 'Big Stick'),
	(4, 1, 'Jacobinos e Girondinos'),
	(5, 1, 'História');

-- Copiando estrutura para tabela bd_sirius.disciplina
CREATE TABLE IF NOT EXISTS `disciplina` (
  `ID_DISCI` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_DISCI` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_DISCI`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.disciplina: ~12 rows (aproximadamente)
INSERT INTO `disciplina` (`ID_DISCI`, `NOME_DISCI`) VALUES
	(1, 'História'),
	(2, 'Língua Portuguesa'),
	(3, 'Matemática'),
	(4, 'Geografia'),
	(5, 'Biologia'),
	(6, 'Química'),
	(7, 'Física'),
	(8, 'Língua Inglesa'),
	(9, 'Arte'),
	(10, 'Educação Física'),
	(11, 'Sociologia'),
	(12, 'Filosofia');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.ligacao: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela bd_sirius.material
CREATE TABLE IF NOT EXISTS `material` (
  `ID_MATERIAL` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_CONTEUDO` int(11) NOT NULL,
  `COD_NIVEL` int(11) NOT NULL,
  `TITULO_MATERIA` varchar(100) NOT NULL,
  `CAMINHO_ARQUIVO` varchar(255) NOT NULL,
  `NOME_ARQUIVO` varchar(255) NOT NULL,
  `DATA_CAD` date NOT NULL,
  `STATUS_MATERIA` varchar(10) NOT NULL,
  `DESCRICAO_MATERIA` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_MATERIAL`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_CONTEUDO` (`COD_CONTEUDO`),
  KEY `COD_NIVEL` (`COD_NIVEL`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `material_ibfk_2` FOREIGN KEY (`COD_CONTEUDO`) REFERENCES `conteudo` (`ID_CONTEUDO`),
  CONSTRAINT `material_ibfk_3` FOREIGN KEY (`COD_NIVEL`) REFERENCES `nivel_ensino` (`ID_NIVEL`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.material: ~5 rows (aproximadamente)
INSERT INTO `material` (`ID_MATERIAL`, `COD_USU`, `COD_CONTEUDO`, `COD_NIVEL`, `TITULO_MATERIA`, `CAMINHO_ARQUIVO`, `NOME_ARQUIVO`, `DATA_CAD`, `STATUS_MATERIA`, `DESCRICAO_MATERIA`) VALUES
	(1, 1, 1, 2, 'Plano Marshall', 'uploads/materiais/material_6ab282f1d61734.66086623.jpg', 'ditadura.jpg', '2026-09-22', 'PUBLICO', 'Mapa mental sobre os presidentes da ditadura civil militar brasileira'),
	(2, 2, 2, 2, 'Utilização da Crase', 'uploads/materiais/material_6ab28394784479.14221995.jpg', 'crase.jpg', '2026-09-22', 'PUBLICO', 'Mapa mental sobre o uso da crase'),
	(3, 2, 3, 3, 'A política do Big Stick', 'uploads/materiais/material_6ab28456b53637.79234663.jpg', 'bigStick.jpg', '2026-09-22', 'PUBLICO', 'Charge sobre a política do big stick'),
	(4, 1, 4, 1, 'Jacobinos e girondinos - Esquerda e Direita na pol', 'uploads/materiais/material_6ab28564896086.69618299.jpg', 'jacobinosGirondinos.jpg', '2026-09-22', 'PUBLICO', 'Charge representando os jacobinos e os girondinos da revolução francesa'),
	(5, 3, 5, 3, 'Reforma Protestante', 'uploads/materiais/material_6ab287d842cc12.20061878.jpg', 'bigStick.jpg', '2026-09-22', 'PUBLICO', 'Surgimento da Reforma Protestante e como ocorreu o rompimento com a Igreja Católica / 95 Teses de  Martinho Lutero');

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
  CONSTRAINT `material_salvo_ibfk_2` FOREIGN KEY (`COD_MATERIAL`) REFERENCES `material` (`ID_MATERIAL`),
  CONSTRAINT `material_salvo_ibfk_3` FOREIGN KEY (`COD_PASTA`) REFERENCES `pasta` (`ID_PASTA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.material_salvo: ~0 rows (aproximadamente)

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.pasta: ~3 rows (aproximadamente)
INSERT INTO `pasta` (`ID_PASTA`, `COD_USU`, `NOME_PASTA`) VALUES
	(1, 1, 'Favoritos'),
	(2, 2, 'Favoritos'),
	(3, 3, 'Favoritos');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.planejamento: ~2 rows (aproximadamente)
INSERT INTO `planejamento` (`ID_PLANEJAMENTO`, `COD_USU`, `TITULO_PLAN`, `ASSUNTO`, `DATA_AULA`, `HORA_INICIO`, `HORA_FIM`, `SALA`, `STATUS_PLAN`) VALUES
	(1, 2, 'Utilização da Crase', 'Aula sobre a crase e suas regras', '2026-09-24', '11:25:00', '12:15:00', '3º DSA', 'PLANEJADA'),
	(2, 1, 'Esquerda e Direita na política', 'Compreender a influência dos jacobinos e dos girondinos', '2026-09-30', '07:15:00', '08:25:00', '6º Ano', 'PLANEJADA');

-- Copiando estrutura para tabela bd_sirius.planejamento_material
CREATE TABLE IF NOT EXISTS `planejamento_material` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `COD_PLANEJAMENTO` int(11) NOT NULL,
  `COD_MATERIAL` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `COD_PLANEJAMENTO` (`COD_PLANEJAMENTO`),
  KEY `COD_MATERIAL` (`COD_MATERIAL`),
  CONSTRAINT `planejamento_material_ibfk_1` FOREIGN KEY (`COD_PLANEJAMENTO`) REFERENCES `planejamento` (`ID_PLANEJAMENTO`),
  CONSTRAINT `planejamento_material_ibfk_2` FOREIGN KEY (`COD_MATERIAL`) REFERENCES `material` (`ID_MATERIAL`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela bd_sirius.planejamento_material: ~2 rows (aproximadamente)
INSERT INTO `planejamento_material` (`ID`, `COD_PLANEJAMENTO`, `COD_MATERIAL`) VALUES
	(1, 1, 2),
	(2, 2, 4);

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
	(1, 'Anna', 'nakarla@gmail.com', '$2y$10$j2NtKcJ4XgKJTvJoG4YmaOSkF0fECIuslVOHqzarP6SYa0C/MICg6', 'nakarla', NULL, NULL),
	(2, 'Breno', 'breno@gmail.com', '$2y$10$OgVUcY8guQR1Me3hRE7wCe76hf3QSvhCMRFiKcfuibll17UX.Dzh.', 'breno123', NULL, NULL),
	(3, 'Matheus', 'matheusaug027@gmail.com', '$2y$10$pAziOQxSGoauelCh3QYgl.e9IAfqFxYrqVcRwdweOSOznPJxYUEhm', 'matheus123', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
