-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Maio-2023 às 16:00
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sief`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `Matricula`
--

CREATE TABLE `Matricula`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Nome` varchar(100) NOT NULL,
  `Sexo` varchar(9) NOT NULL,
  `CPF` varchar(12) NOT NULL UNIQUE,
  `RG` varchar(9) NOT NULL,
  `Data_nascimento` date NOT NULL,
  `Cidade` VARCHAR(100) NOT NULl,
  `Bairro` VARCHAR(100) NOT NULl,
  `Rua` VARCHAR(100) NOT NULl,
  `Numero` VARCHAR(12) NOT NULl,
  `Celular` varchar(11),
  `E-Mail`VARCHAR(100),
  `Tipo` int(1) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

=======
INSERT INTO `Matricula` VALUES (1, 'Luiz Henrique Gomes Mendes', 'Masculino', '49410706823', '595782693', '2003-04-09', 'Tatui-SP', 'Vila Esperança', 'Antônio Henrique da Silva', '984', '15996519988', 'luizmendesgomes@hotmail.com', 1);
-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `Usuario`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Usuario` varchar(100) NOT NULL UNIQUE,
  `Senha` varchar(255) NOT NULL,
  `FK_Matricula` INT,
  FOREIGN KEY(`FK_Matricula`) REFERENCES `Matricula`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--


INSERT INTO `Usuario` VALUES  (1, 'Luiz Henrique Gomes Mendes', '49410706823' , '789621453', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Administrador`
--

CREATE TABLE `Admin`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `FK_Usuario` INT,
  FOREIGN KEY(`FK_Usuario`) REFERENCES `usuario`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Admin`(`id`,`FK_Usuario`) VALUES(1,1);


-- --------------------------------------------------------

--
-- Estrutura da tabela `Turma`
--

CREATE TABLE `Turma`
(
  `id` INT(255) PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Nome_turma` varchar(100) NOT NULL,
  `Ano` date NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `Turma` (`id`,`Nome_turma`,`Ano`) VALUES(1, '3B', '2023-01-01');


-- --------------------------------------------------------

--
-- Estrutura da tabela `diciplina`
--

CREATE TABLE `Diciplina`
(
  `id` INT(255) PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Nome_Diciplina` varchar(30) NOT NULL UNIQUE,
  `FK_Turma` INT,
  FOREIGN KEY(`FK_Turma`) REFERENCES `Turma`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `diciplina`
--

INSERT INTO `Diciplina` (`id`,`Nome_Diciplina`, `Fk_Turma`) VALUES (1, "Matematica", 1);


-- --------------------------------------------------------

--
-- Estrutura da tabela `Avaliação`
--

CREATE TABLE `Avaliacao`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Notas` Numeric(2),
  `FK_Diciplina` INT,
  `FK_Turma` INT,
  FOREIGN KEY(`FK_Diciplina`) REFERENCES `diciplina`(`id`),  
  FOREIGN KEY(`FK_Turma`) REFERENCES `Turma`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Avaliacao` VALUES (1, 10, 1, 1);
-- --------------------------------------------------------

--
-- Estrutura da tabela `Professor`
--

CREATE TABLE `Professor`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `FK_Usuario` INT,
  FOREIGN KEY
(`FK_Usuario`) REFERENCES `usuario`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Professor`(`id`,`FK_Usuario`) VALUES(1,1);
-- --------------------------------------------------------

--
-- Estrutura da tabela `Aluno`
--

CREATE TABLE `Aluno`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Status` VARCHAR(11) NOT NULL,
  `FK_Usuario` INT,
  `FK_Avaliacao` INT,
  `FK_Diciplina` INT,
  FOREIGN KEY(`FK_Usuario`) REFERENCES `usuario`(`id`),
  FOREIGN KEY(`FK_Avaliacao`) REFERENCES `Avaliacao`(`id`),
  FOREIGN KEY(`FK_Diciplina`) REFERENCES `Diciplina`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Aluno` VALUES  (1, "Aprovado", 1, 1, 1);


--
-- Estrutura da tabela `Calendario_aula`
--

CREATE TABLE `Calendario_aula`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Data` DATETIME NOT NULL,
  `Nome_aula` VARCHAR(25) NOT NULL,
  `Chamada` Boolean NOT NULL,
  `FK_Aluno` INT,
  `FK_Diciplina` INT,
  FOREIGN KEY(`FK_Diciplina`) REFERENCES `Diciplina`(`id`),
  FOREIGN KEY(`FK_Aluno`) REFERENCES `Aluno`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Calendario_aula`(`id`,`Data`,`Nome_aula`, `Chamada`, `FK_Aluno`, `FK_Diciplina`) VALUES (1, '2023-06-07',"Aula Experimental", 1, 1, 1);

