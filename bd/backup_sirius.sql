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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.conteudo: ~1 rows (aproximadamente)
INSERT INTO `conteudo` (`ID_CONTEUDO`, `COD_DISCI`, `NOME_CONTEUDO`) VALUES
	(1, 1, 'RevoluÃ§Ã£o Francesa'),
	(2, 1, 'Primeira Guera Mundial');

-- Copiando estrutura para tabela bd_sirius.disciplina
CREATE TABLE IF NOT EXISTS `disciplina` (
  `ID_DISCI` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_DISCI` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_DISCI`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.disciplina: ~1 rows (aproximadamente)
INSERT INTO `disciplina` (`ID_DISCI`, `NOME_DISCI`) VALUES
	(1, 'HistÃ³ria'),
	(2, 'Geografia');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.ligacao: ~1 rows (aproximadamente)
INSERT INTO `ligacao` (`ID_LIGACAO`, `COD_USU`, `COD_USU_DESTINO`, `STATUS_LIGACAO`, `DATA_LIGACAO`) VALUES
	(4, 1, 2, 'ACEITA', '2026-08-31');

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
  `DESCRICAO_MATERIA` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_MATERIAL`),
  KEY `COD_USU` (`COD_USU`),
  KEY `COD_CONTEUDO` (`COD_CONTEUDO`),
  KEY `COD_NIVEL` (`COD_NIVEL`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`COD_USU`) REFERENCES `usuario` (`ID_USU`),
  CONSTRAINT `material_ibfk_2` FOREIGN KEY (`COD_CONTEUDO`) REFERENCES `conteudo` (`ID_CONTEUDO`),
  CONSTRAINT `material_ibfk_3` FOREIGN KEY (`COD_NIVEL`) REFERENCES `nivel_ensino` (`ID_NIVEL`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.material: ~2 rows (aproximadamente)
INSERT INTO `material` (`ID_MATERIAL`, `COD_USU`, `COD_CONTEUDO`, `COD_NIVEL`, `TITULO_MATERIA`, `CAMINHO_ARQUIVO`, `NOME_ARQUIVO`, `DATA_CAD`, `STATUS_MATERIA`, `DESCRICAO_MATERIA`) VALUES
	(1, 1, 1, 2, 'Mapa mental Rev Francesa', 'uploads/materiais/material_6a9338a19a1220.35158110.jpg', 'rev_fran.jpg', '2026-08-29', 'PUBLICO', 'Mapa mental sobre a revoluÃ§Ã£o francesa para complemento de aula e estudo dos alunos'),
	(2, 1, 2, 2, 'Linha do Tempo 1Âª guerra', 'uploads/materiais/material_6a9489aa696252.54948010.webp', 'linhadotempo.webp', '2026-08-30', 'PRIVADO', 'Linha do tempo da Primeira Guerra Mundial - RevisÃ£o da Prova');

-- Copiando estrutura para tabela bd_sirius.nivel_ensino
CREATE TABLE IF NOT EXISTS `nivel_ensino` (
  `ID_NIVEL` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_NIVEL` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_NIVEL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.nivel_ensino: ~4 rows (aproximadamente)
INSERT INTO `nivel_ensino` (`ID_NIVEL`, `NOME_NIVEL`) VALUES
	(1, 'Ens. Fundamental I'),
	(2, 'Ens. Fundamental II'),
	(3, 'Ens. Médio'),
	(4, 'Ens. Superior');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela bd_sirius.usuario: ~2 rows (aproximadamente)
INSERT INTO `usuario` (`ID_USU`, `NOME_USU`, `EMAIL_USU`, `SENHA_USU`, `USERNAME`, `DESCRICAO_USU`, `FOTO_USU`) VALUES
	(1, 'Breno', 'breno@gmail.com', '$2y$10$bXh84LXVKhgkmhys8EWDK.Wf.FlOATZBc7fRLALNThdEjkcDiVKPm', 'brenofs', 'Professor de PortuguÃªs \nApaixonado em Literatura', NULL),
	(2, 'Anna Karla', 'anna@hotmail.com', '$2y$10$pEofZdPf9sN7xwVzDkfe1Oc3zihMfL1SIeG.8fGDCxFuJY52z.Opa', 'annakpm', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
