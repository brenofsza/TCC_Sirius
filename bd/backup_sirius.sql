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
CREATE DATABASE IF NOT EXISTS `bd_sirius` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `bd_sirius`;


-- Copiando estrutura para tabela bd_sirius.conteudo
CREATE TABLE IF NOT EXISTS `conteudo` (
  `ID_CONTEUDO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_DISCI` int(11) NOT NULL,
  `NOME_CONTEUDO` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_CONTEUDO`),
  KEY `COD_DISCI` (`COD_DISCI`),
  CONSTRAINT `conteudo_ibfk_1` FOREIGN KEY (`COD_DISCI`) REFERENCES `disciplina` (`ID_DISCI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.conteudo: ~0 rows (aproximadamente)


-- Copiando estrutura para tabela bd_sirius.disciplina
CREATE TABLE IF NOT EXISTS `disciplina` (
  `ID_DISCI` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_DISCI` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_DISCI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.disciplina: ~0 rows (aproximadamente)


-- Copiando estrutura para tabela bd_sirius.nivel_ensino
CREATE TABLE IF NOT EXISTS `nivel_ensino` (
  `ID_NIVEL` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_NIVEL` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_NIVEL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando estrutura para tabela bd_sirius.material
CREATE TABLE IF NOT EXISTS `material` (
  `ID_MATERIAL` int(11) NOT NULL AUTO_INCREMENT,
  `COD_USU` int(11) NOT NULL,
  `COD_CONTEUDO` int(11) NOT NULL,
  `COD_NIVEL` int(11) NOT NULL,
  `TITULO_MATERIA` varchar(50) NOT NULL,
  `CAMINHO_ARQUIVO` varchar(255) NOT NULL,
  `NOME_ARQUIVO` varchar(255) NOT NULL,
  `DATA_CAD` date NOT NULL,
  `STATUS_MATERIA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_MATERIAL`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_CONTEUDO` (`COD_CONTEUDO`),
  KEY `COD_NIVEL` (`COD_NIVEL`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `material_ibfk_2` FOREIGN KEY (`COD_CONTEUDO`) REFERENCES `conteudo` (`ID_CONTEUDO`),
  CONSTRAINT `material_ibfk_3` FOREIGN KEY (`COD_NIVEL`) REFERENCES `nivel_ensino` (`ID_NIVEL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.material: ~0 rows (aproximadamente)


-- Copiando estrutura para tabela bd_sirius.planejamento
CREATE TABLE IF NOT EXISTS `planejamento` (
  `ID_PLANEJAMENTO` int(11) NOT NULL AUTO_INCREMENT,
  `TITULO_PLAN` varchar(30) NOT NULL,
  `ASSUNTO` varchar(100) NOT NULL,
  `DATA_AULA` date NOT NULL,
  `SALA` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_PLANEJAMENTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.planejamento: ~0 rows (aproximadamente)


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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.usuario: ~3 rows (aproximadamente)
INSERT INTO `usuario` (`ID_USU`, `NOME_USU`, `EMAIL_USU`, `SENHA_USU`, `USERNAME`, `DESCRICAO_USU`, `FOTO_USU`) VALUES
	(1, 'Breno Souza', 'rick@gmail.com', '$2y$10$6EX6f8eWSCs8PbOHuxmue.AGHsFnSCyYJ5baay2U82LGnBINI7pbu', 'brenofsouza', NULL, NULL),
	(2, 'Bruno', 'rick@gmail', '$2y$10$4T03zCC8575rtyp/pMS75.JDU2aOyaTAR0Gb.q61ZwReK1fucXe5O', 'brunohenrique', NULL, NULL),
	(3, 'Pedro', 'ped@gmail', '$2y$10$9UqdMh4lef3q9ypWzgo7Uu3wKKbnOxx6tzTAm0OJNxV5mt9WPO4QS', 'pedrinho', NULL, 'uploads/fotos_usu/usu_6a826aa5a43ff1.52132756.jpg');


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;