-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Abr-2019 às 22:18
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wegia`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cadentrada` (IN `id_origem` INT, IN `id_almoxarifado` INT, IN `id_tipo` INT, IN `id_responsavel` INT, IN `data` DATE, IN `hora` TIME, IN `valor_total` DECIMAL(10,2), IN `id_entrada` INT, IN `id_produto` INT, IN `qtd` INT, IN `valor_unitario` DECIMAL(10,2))  begin

declare idE int;

insert into entrada (id_origem, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total)
	values(id_origem, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total);

SELECT 
	MAX(id_entrada)
INTO idE FROM entrada;

insert into ientrada(id_entrada, id_produto, qtd, valor_unitario)
	values(idE, id_produto, qtd, valor_unitario);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadfuncionario` (IN `nome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(100), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(100), IN `estado` VARCHAR(50), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(100), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(50), IN `vale_transporte` VARCHAR(160), IN `data_admissao` DATE, IN `pis` VARCHAR(140), IN `ctps` VARCHAR(150), IN `uf_ctps` VARCHAR(200), IN `numero_titulo` VARCHAR(150), IN `zona` VARCHAR(300), IN `secao` VARCHAR(400), IN `certificado_reservista_numero` VARCHAR(100), IN `certificado_reservista_serie` VARCHAR(100), IN `calcado` VARCHAR(200), IN `calca` VARCHAR(200), IN `jaleco` VARCHAR(20), IN `camisa` VARCHAR(200), IN `usa_vtp` VARCHAR(300), IN `cesta_basica` VARCHAR(300), IN `situacao` VARCHAR(100), IN `cargo` VARCHAR(30))  begin

declare idP int;
declare idF int;

insert into pessoa( cpf, senha, nome, sexo, telefone,data_nascimento,imagem, cep ,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo)
values(cpf, senha, nome, sexo, telefone,data_nascimento,imagem, cep ,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo);

select max(id_pessoa) into idP FROM pessoa;

insert into funcionario(id_pessoa, vale_transporte,data_admissao,pis,ctps,
uf_ctps,numero_titulo,zona,secao,certificado_reservista_numero,certificado_reservista_serie,calcado,calca,jaleco,camisa,
usa_vtp,cesta_basica,situacao,cargo)
values(idP,vale_transporte,data_admissao,pis,ctps,
uf_ctps,numero_titulo,zona,secao,certificado_reservista_numero,certificado_reservista_serie,calcado,calca,jaleco,camisa,
usa_vtp,cesta_basica,situacao,cargo);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadhorario` (IN `escala` VARCHAR(200), IN `tipo` VARCHAR(200), IN `carga_horaria` VARCHAR(200), IN `entrada1` VARCHAR(200), IN `saida1` VARCHAR(200), IN `entrada2` VARCHAR(200), IN `saida2` VARCHAR(200), IN `total` VARCHAR(200), IN `dias_trabalhados` VARCHAR(200), IN `folga` VARCHAR(200))  NO SQL
begin
declare idF int;

SELECT MAX(id_funcionario) into idF FROM funcionario;

insert into quadro_horario(id_funcionario,escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga) VALUES (idF, escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadimagem` (IN `id_pessoa` INT, IN `imagem` LONGTEXT, IN `imagem_extensao` VARCHAR(10), IN `descricao` VARCHAR(40))  begin
declare idD int;
insert into documento(id_pessoa,imgdoc,imagem_extensao,descricao) VALUES (id_pessoa,imagem,imagem_extensao,descricao);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadinterno` (IN `nome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(25), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(20), IN `estado` VARCHAR(5), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(11), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(5), IN `nome_contato_urgente` VARCHAR(60), IN `telefone_contato_urgente_1` VARCHAR(33), IN `telefone_contato_urgente_2` VARCHAR(33), IN `telefone_contato_urgente_3` VARCHAR(33), IN `certidao_nascimento` VARCHAR(60), IN `curatela` VARCHAR(60), IN `inss` VARCHAR(60), IN `loas` VARCHAR(60), IN `bpc` VARCHAR(60), IN `funrural` VARCHAR(60), IN `saf` VARCHAR(60), IN `sus` VARCHAR(60), IN `certidao_casamento` VARCHAR(123), IN `ctps` VARCHAR(123), IN `titulo` VARCHAR(123))  begin

declare idP int;
declare idB int;

insert into pessoa(nome,cpf,senha,sexo,telefone,data_nascimento,imagem,cep,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo)
values(nome,cpf, senha, sexo, telefone,data_nascimento,imagem,cep,estado,cidade,bairro,logradouro,numero_endereco,complemento,ibge,registro_geral,orgao_emissor,data_expedicao,nome_pai,nome_mae,tipo_sanguineo);
select max(id_pessoa) into idP FROM pessoa;

insert into interno(id_pessoa,nome_contato_urgente,telefone_contato_urgente_1,telefone_contato_urgente_2,telefone_contato_urgente_3,certidao_nascimento,curatela,inss,loas,bpc,funrural,saf,sus,certidao_casamento,ctps,titulo) 
values(idP,nome_contato_urgente,telefone_contato_urgente_1,telefone_contato_urgente_2,telefone_contato_urgente_3,certidao_nascimento,curatela,inss,loas,bpc,funrural,saf,sus,certidao_casamento,ctps,titulo);
SELECT MAX(id_pessoa) from pessoa;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadsaida` (IN `id_destino` INT, IN `id_almoxarifado` INT, IN `id_tipo` INT, IN `id_responsavel` INT, IN `data` DATE, IN `hora` TIME, IN `valor_total` DECIMAL(10,2), IN `id_saida` INT, IN `id_produto` INT, IN `qtd` INT, IN `valor_unitario` DECIMAL(10,2))  begin

declare idS int;

insert into saida (id_destino, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total)
	values(id_destino, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total);

SELECT 
	MAX(id_saida)
INTO idS FROM saida;

insert into isaida(id_saida, id_produto, qtd, valor_unitario)
	values(idS, id_produto, qtd, valor_unitario);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `excluirfuncionario` (IN `idf` INT)  BEGIN


delete from quadro_horario where id_funcionario=idf;

delete f,p from funcionario as f inner join pessoa as p on p.id_pessoa=f.id_pessoa where f.id_funcionario=idf;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `excluirinterno` (IN `idi` INT)  BEGIN
DECLARE idp int;

select id_pessoa into idp from interno where id_interno=idi;

delete from documento where id_pessoa=idp;

delete i,p from interno as i inner join pessoa as p on p.id_pessoa=i.id_pessoa where i.id_interno=idi;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `acao`
--

CREATE TABLE `acao` (
  `id_acao` int(11) NOT NULL,
  `descricao` varchar(240) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `almoxarifado`
--

CREATE TABLE `almoxarifado` (
  `id_almoxarifado` int(11) NOT NULL,
  `descricao_almoxarifado` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `anexo`
--

CREATE TABLE `anexo` (
  `id_anexo` int(11) NOT NULL,
  `id_despacho` int(11) NOT NULL,
  `anexo` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `calca`
--

CREATE TABLE `calca` (
  `id_calcado` int(11) NOT NULL,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `calcado`
--

CREATE TABLE `calcado` (
  `id_calcado` int(11) NOT NULL,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `camisa`
--

CREATE TABLE `camisa` (
  `id_calcado` int(11) NOT NULL,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `cargo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_produto`
--

CREATE TABLE `categoria_produto` (
  `id_categoria_produto` int(11) NOT NULL,
  `descricao_categoria` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `despacho`
--

CREATE TABLE `despacho` (
  `id_despacho` int(11) NOT NULL,
  `id_memorando` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `data` datetime DEFAULT NULL,
  `texto` text,
  `id_destino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destino`
--

CREATE TABLE `destino` (
  `id_destino` int(11) NOT NULL,
  `nome_destino` varchar(100) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `documento`
--

CREATE TABLE `documento` (
  `id_documento` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `imgdoc` longtext,
  `imagem_extensao` varchar(10) DEFAULT NULL,
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada`
--

CREATE TABLE `entrada` (
  `id_entrada` int(11) NOT NULL,
  `id_origem` int(11) NOT NULL,
  `id_almoxarifado` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_responsavel` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_produto` int(11) NOT NULL,
  `id_almoxarifado` int(11) NOT NULL,
  `qtd` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `vale_transporte` varchar(160) DEFAULT NULL,
  `data_admissao` date NOT NULL,
  `pis` varchar(140) DEFAULT NULL,
  `ctps` varchar(150) NOT NULL,
  `uf_ctps` varchar(20) DEFAULT NULL,
  `numero_titulo` varchar(150) DEFAULT NULL,
  `zona` varchar(30) DEFAULT NULL,
  `secao` varchar(40) DEFAULT NULL,
  `certificado_reservista_numero` varchar(100) DEFAULT NULL,
  `certificado_reservista_serie` varchar(100) DEFAULT NULL,
  `calcado` varchar(20) DEFAULT NULL,
  `calca` varchar(20) DEFAULT NULL,
  `jaleco` varchar(20) DEFAULT NULL,
  `camisa` varchar(20) DEFAULT NULL,
  `usa_vtp` varchar(30) DEFAULT NULL,
  `cesta_basica` varchar(30) DEFAULT NULL,
  `situacao` varchar(100) DEFAULT NULL,
  `cargo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ientrada`
--

CREATE TABLE `ientrada` (
  `id_ientrada` int(11) NOT NULL,
  `id_entrada` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Acionadores `ientrada`
--
DELIMITER $$
CREATE TRIGGER `tgr_ientrada_delete` AFTER DELETE ON `ientrada` FOR EACH ROW BEGIN
	
    UPDATE estoque SET qtd = qtd - OLD.qtd WHERE id_produto = OLD.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM entrada WHERE id_entrada = OLD.id_entrada);
	
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tgr_ientrada_insert` AFTER INSERT ON `ientrada` FOR EACH ROW BEGIN

	INSERT IGNORE INTO estoque(id_produto, id_almoxarifado, qtd) values(NEW.id_produto, (SELECT id_almoxarifado FROM entrada WHERE id_entrada = NEW.id_entrada), 0);
	
    UPDATE estoque SET qtd = qtd+NEW.qtd WHERE id_produto = NEW.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM entrada WHERE id_entrada = NEW.id_entrada);
	
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `interno`
--

CREATE TABLE `interno` (
  `id_interno` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `nome_contato_urgente` varchar(60) DEFAULT NULL,
  `telefone_contato_urgente_1` varchar(33) DEFAULT NULL,
  `telefone_contato_urgente_2` varchar(33) DEFAULT NULL,
  `telefone_contato_urgente_3` varchar(33) DEFAULT NULL,
  `observacao` varchar(2000) DEFAULT NULL,
  `certidao_nascimento` varchar(60) DEFAULT NULL,
  `curatela` varchar(60) DEFAULT NULL,
  `inss` varchar(60) DEFAULT NULL,
  `loas` varchar(60) DEFAULT NULL,
  `bpc` varchar(60) DEFAULT NULL,
  `funrural` varchar(60) DEFAULT NULL,
  `saf` varchar(60) DEFAULT NULL,
  `sus` varchar(60) DEFAULT NULL,
  `certidao_casamento` varchar(123) NOT NULL,
  `ctps` varchar(123) NOT NULL,
  `titulo` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `isaida`
--

CREATE TABLE `isaida` (
  `id_isaida` int(11) NOT NULL,
  `id_saida` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Acionadores `isaida`
--
DELIMITER $$
CREATE TRIGGER `tgr_isaida_delete` AFTER DELETE ON `isaida` FOR EACH ROW BEGIN
	
    UPDATE estoque SET qtd = qtd+OLD.qtd WHERE id_produto = OLD.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM saida WHERE id_saida = OLD.id_saida);
	
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tgr_isaida_insert` AFTER INSERT ON `isaida` FOR EACH ROW BEGIN
	
    UPDATE estoque SET qtd = qtd-NEW.qtd WHERE id_produto = NEW.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM saida WHERE id_saida = NEW.id_saida);
	
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jaleco`
--

CREATE TABLE `jaleco` (
  `id_calcado` int(11) NOT NULL,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `memorando`
--

CREATE TABLE `memorando` (
  `id` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `titulo` text,
  `data` datetime DEFAULT NULL,
  `status_memorando` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao_funcionario`
--

CREATE TABLE `movimentacao_funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `id_situacao_funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao_interno`
--

CREATE TABLE `movimentacao_interno` (
  `id_interno` int(11) NOT NULL,
  `id_situacao_interno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `origem`
--

CREATE TABLE `origem` (
  `id_origem` int(11) NOT NULL,
  `nome_origem` varchar(100) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id_cargo` int(11) NOT NULL,
  `id_acao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id_pessoa` int(11) NOT NULL,
  `cpf` varchar(120) DEFAULT NULL,
  `senha` varchar(70) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `imagem` longtext,
  `cep` varchar(10) DEFAULT NULL,
  `estado` varchar(5) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `bairro` varchar(40) DEFAULT NULL,
  `logradouro` varchar(40) DEFAULT NULL,
  `numero_endereco` varchar(10) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `ibge` varchar(20) DEFAULT NULL,
  `registro_geral` varchar(120) DEFAULT NULL,
  `orgao_emissor` varchar(120) DEFAULT NULL,
  `data_expedicao` date DEFAULT NULL,
  `nome_mae` varchar(100) DEFAULT NULL,
  `nome_pai` varchar(100) DEFAULT NULL,
  `tipo_sanguineo` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `cpf`, `senha`, `nome`, `sexo`, `telefone`, `data_nascimento`, `imagem`, `cep`, `estado`, `cidade`, `bairro`, `logradouro`, `numero_endereco`, `complemento`, `ibge`, `registro_geral`, `orgao_emissor`, `data_expedicao`, `nome_mae`, `nome_pai`, `tipo_sanguineo`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', 'a', 'telefone', '2018-12-16', 'null', 'cep', 'estad', 'cidade', 'bairro', 'logradouro', 'numero_end', 'complemento', 'ibge', 'registro_geral', 'orgao_emissor', '0000-00-00', 'nome_mae', 'nome_pai', 'tipo_');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_categoria_produto` int(11) NOT NULL,
  `id_unidade` int(11) NOT NULL,
  `descricao` varchar(240) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quadro_horario`
--

CREATE TABLE `quadro_horario` (
  `id_quadro_horario` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `escala` varchar(200) DEFAULT NULL,
  `tipo` varchar(200) DEFAULT NULL,
  `carga_horaria` varchar(200) DEFAULT NULL,
  `entrada1` varchar(200) DEFAULT NULL,
  `saida1` varchar(200) DEFAULT NULL,
  `entrada2` varchar(200) DEFAULT NULL,
  `saida2` varchar(200) DEFAULT NULL,
  `total` varchar(200) DEFAULT NULL,
  `dias_trabalhados` varchar(200) DEFAULT NULL,
  `folga` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saida`
--

CREATE TABLE `saida` (
  `id_saida` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `id_almoxarifado` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_responsavel` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE `situacao` (
  `id_calcado` int(11) NOT NULL,
  `situacoes` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao_funcionario`
--

CREATE TABLE `situacao_funcionario` (
  `id_situacao_funcionario` int(11) NOT NULL,
  `data_hora` datetime DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `imagem` longtext,
  `imagem_extensao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao_interno`
--

CREATE TABLE `situacao_interno` (
  `id_situacao_interno` int(11) NOT NULL,
  `data_hora` datetime DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `imagem` longtext,
  `imagem_extensao` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_memorando`
--

CREATE TABLE `status_memorando` (
  `id_status` int(11) NOT NULL,
  `status_atual` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_entrada`
--

CREATE TABLE `tipo_entrada` (
  `id_tipo` int(11) NOT NULL,
  `descricao` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_saida`
--

CREATE TABLE `tipo_saida` (
  `id_tipo` int(11) NOT NULL,
  `descricao` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade`
--

CREATE TABLE `unidade` (
  `id_unidade` int(11) NOT NULL,
  `descricao_unidade` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `voluntario`
--

CREATE TABLE `voluntario` (
  `id_voluntario` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `voluntario_cargo`
--

CREATE TABLE `voluntario_cargo` (
  `id_cargo` int(11) NOT NULL,
  `id_voluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `voluntario_judicial`
--

CREATE TABLE `voluntario_judicial` (
  `id_voluntario_judicial` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `documento_judicial` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `voluntario_judicial_cargo`
--

CREATE TABLE `voluntario_judicial_cargo` (
  `id_cargo` int(11) NOT NULL,
  `id_voluntarioJ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acao`
--
ALTER TABLE `acao`
  ADD PRIMARY KEY (`id_acao`);

--
-- Indexes for table `almoxarifado`
--
ALTER TABLE `almoxarifado`
  ADD PRIMARY KEY (`id_almoxarifado`);

--
-- Indexes for table `anexo`
--
ALTER TABLE `anexo`
  ADD PRIMARY KEY (`id_anexo`),
  ADD KEY `fk_despacho` (`id_despacho`);

--
-- Indexes for table `calca`
--
ALTER TABLE `calca`
  ADD PRIMARY KEY (`id_calcado`);

--
-- Indexes for table `calcado`
--
ALTER TABLE `calcado`
  ADD PRIMARY KEY (`id_calcado`);

--
-- Indexes for table `camisa`
--
ALTER TABLE `camisa`
  ADD PRIMARY KEY (`id_calcado`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `categoria_produto`
--
ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`id_categoria_produto`);

--
-- Indexes for table `despacho`
--
ALTER TABLE `despacho`
  ADD PRIMARY KEY (`id_despacho`),
  ADD KEY `fk_memorando` (`id_memorando`),
  ADD KEY `fk_pessoa` (`id_pessoa`),
  ADD KEY `fk_despacho_destino` (`id_destino`);

--
-- Indexes for table `destino`
--
ALTER TABLE `destino`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indexes for table `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `id_origem` (`id_origem`),
  ADD KEY `id_almoxarifado` (`id_almoxarifado`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_responsavel` (`id_responsavel`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_produto`,`id_almoxarifado`),
  ADD KEY `id_almoxarifado` (`id_almoxarifado`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `ientrada`
--
ALTER TABLE `ientrada`
  ADD PRIMARY KEY (`id_ientrada`),
  ADD KEY `id_entrada` (`id_entrada`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `interno`
--
ALTER TABLE `interno`
  ADD PRIMARY KEY (`id_interno`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `isaida`
--
ALTER TABLE `isaida`
  ADD PRIMARY KEY (`id_isaida`),
  ADD KEY `id_saida` (`id_saida`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `jaleco`
--
ALTER TABLE `jaleco`
  ADD PRIMARY KEY (`id_calcado`);

--
-- Indexes for table `memorando`
--
ALTER TABLE `memorando`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_origem` (`id_pessoa`),
  ADD KEY `fk_status_memorando` (`status_memorando`);

--
-- Indexes for table `movimentacao_funcionario`
--
ALTER TABLE `movimentacao_funcionario`
  ADD PRIMARY KEY (`id_funcionario`,`id_situacao_funcionario`),
  ADD KEY `id_situacao_funcionario` (`id_situacao_funcionario`);

--
-- Indexes for table `movimentacao_interno`
--
ALTER TABLE `movimentacao_interno`
  ADD PRIMARY KEY (`id_interno`,`id_situacao_interno`),
  ADD KEY `id_situacao_interno` (`id_situacao_interno`);

--
-- Indexes for table `origem`
--
ALTER TABLE `origem`
  ADD PRIMARY KEY (`id_origem`);

--
-- Indexes for table `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id_cargo`),
  ADD KEY `id_acao` (`id_acao`);

--
-- Indexes for table `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id_pessoa`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_categoria_produto` (`id_categoria_produto`),
  ADD KEY `id_unidade` (`id_unidade`);

--
-- Indexes for table `quadro_horario`
--
ALTER TABLE `quadro_horario`
  ADD PRIMARY KEY (`id_quadro_horario`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `saida`
--
ALTER TABLE `saida`
  ADD PRIMARY KEY (`id_saida`),
  ADD KEY `id_destino` (`id_destino`),
  ADD KEY `id_almoxarifado` (`id_almoxarifado`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_responsavel` (`id_responsavel`);

--
-- Indexes for table `situacao`
--
ALTER TABLE `situacao`
  ADD PRIMARY KEY (`id_calcado`);

--
-- Indexes for table `situacao_funcionario`
--
ALTER TABLE `situacao_funcionario`
  ADD PRIMARY KEY (`id_situacao_funcionario`);

--
-- Indexes for table `situacao_interno`
--
ALTER TABLE `situacao_interno`
  ADD PRIMARY KEY (`id_situacao_interno`);

--
-- Indexes for table `status_memorando`
--
ALTER TABLE `status_memorando`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `tipo_entrada`
--
ALTER TABLE `tipo_entrada`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `tipo_saida`
--
ALTER TABLE `tipo_saida`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `unidade`
--
ALTER TABLE `unidade`
  ADD PRIMARY KEY (`id_unidade`);

--
-- Indexes for table `voluntario`
--
ALTER TABLE `voluntario`
  ADD PRIMARY KEY (`id_voluntario`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `voluntario_cargo`
--
ALTER TABLE `voluntario_cargo`
  ADD PRIMARY KEY (`id_cargo`,`id_voluntario`),
  ADD KEY `id_voluntario` (`id_voluntario`);

--
-- Indexes for table `voluntario_judicial`
--
ALTER TABLE `voluntario_judicial`
  ADD PRIMARY KEY (`id_voluntario_judicial`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `voluntario_judicial_cargo`
--
ALTER TABLE `voluntario_judicial_cargo`
  ADD PRIMARY KEY (`id_cargo`,`id_voluntarioJ`),
  ADD KEY `id_voluntarioJ` (`id_voluntarioJ`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acao`
--
ALTER TABLE `acao`
  MODIFY `id_acao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `almoxarifado`
--
ALTER TABLE `almoxarifado`
  MODIFY `id_almoxarifado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anexo`
--
ALTER TABLE `anexo`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calca`
--
ALTER TABLE `calca`
  MODIFY `id_calcado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calcado`
--
ALTER TABLE `calcado`
  MODIFY `id_calcado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `camisa`
--
ALTER TABLE `camisa`
  MODIFY `id_calcado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categoria_produto`
--
ALTER TABLE `categoria_produto`
  MODIFY `id_categoria_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `despacho`
--
ALTER TABLE `despacho`
  MODIFY `id_despacho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destino`
--
ALTER TABLE `destino`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documento`
--
ALTER TABLE `documento`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ientrada`
--
ALTER TABLE `ientrada`
  MODIFY `id_ientrada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interno`
--
ALTER TABLE `interno`
  MODIFY `id_interno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `isaida`
--
ALTER TABLE `isaida`
  MODIFY `id_isaida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jaleco`
--
ALTER TABLE `jaleco`
  MODIFY `id_calcado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memorando`
--
ALTER TABLE `memorando`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `origem`
--
ALTER TABLE `origem`
  MODIFY `id_origem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quadro_horario`
--
ALTER TABLE `quadro_horario`
  MODIFY `id_quadro_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saida`
--
ALTER TABLE `saida`
  MODIFY `id_saida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id_calcado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `situacao_funcionario`
--
ALTER TABLE `situacao_funcionario`
  MODIFY `id_situacao_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `situacao_interno`
--
ALTER TABLE `situacao_interno`
  MODIFY `id_situacao_interno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_memorando`
--
ALTER TABLE `status_memorando`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_entrada`
--
ALTER TABLE `tipo_entrada`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_saida`
--
ALTER TABLE `tipo_saida`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidade`
--
ALTER TABLE `unidade`
  MODIFY `id_unidade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voluntario`
--
ALTER TABLE `voluntario`
  MODIFY `id_voluntario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voluntario_judicial`
--
ALTER TABLE `voluntario_judicial`
  MODIFY `id_voluntario_judicial` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `anexo`
--
ALTER TABLE `anexo`
  ADD CONSTRAINT `fk_despacho` FOREIGN KEY (`id_despacho`) REFERENCES `despacho` (`id_despacho`);

--
-- Limitadores para a tabela `despacho`
--
ALTER TABLE `despacho`
  ADD CONSTRAINT `fk_despacho_destino` FOREIGN KEY (`id_destino`) REFERENCES `pessoa` (`id_pessoa`),
  ADD CONSTRAINT `fk_memorando` FOREIGN KEY (`id_memorando`) REFERENCES `memorando` (`id`),
  ADD CONSTRAINT `fk_pessoa` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`id_origem`) REFERENCES `origem` (`id_origem`),
  ADD CONSTRAINT `entrada_ibfk_2` FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`),
  ADD CONSTRAINT `entrada_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_entrada` (`id_tipo`),
  ADD CONSTRAINT `entrada_ibfk_4` FOREIGN KEY (`id_responsavel`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  ADD CONSTRAINT `estoque_ibfk_2` FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`);

--
-- Limitadores para a tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `ientrada`
--
ALTER TABLE `ientrada`
  ADD CONSTRAINT `ientrada_ibfk_1` FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`),
  ADD CONSTRAINT `ientrada_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Limitadores para a tabela `interno`
--
ALTER TABLE `interno`
  ADD CONSTRAINT `interno_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `isaida`
--
ALTER TABLE `isaida`
  ADD CONSTRAINT `isaida_ibfk_1` FOREIGN KEY (`id_saida`) REFERENCES `saida` (`id_saida`),
  ADD CONSTRAINT `isaida_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Limitadores para a tabela `memorando`
--
ALTER TABLE `memorando`
  ADD CONSTRAINT `fk_origem` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`),
  ADD CONSTRAINT `fk_status_memorando` FOREIGN KEY (`status_memorando`) REFERENCES `status_memorando` (`id_status`);

--
-- Limitadores para a tabela `movimentacao_funcionario`
--
ALTER TABLE `movimentacao_funcionario`
  ADD CONSTRAINT `movimentacao_funcionario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`),
  ADD CONSTRAINT `movimentacao_funcionario_ibfk_2` FOREIGN KEY (`id_situacao_funcionario`) REFERENCES `situacao_funcionario` (`id_situacao_funcionario`);

--
-- Limitadores para a tabela `movimentacao_interno`
--
ALTER TABLE `movimentacao_interno`
  ADD CONSTRAINT `movimentacao_interno_ibfk_1` FOREIGN KEY (`id_interno`) REFERENCES `interno` (`id_interno`),
  ADD CONSTRAINT `movimentacao_interno_ibfk_2` FOREIGN KEY (`id_situacao_interno`) REFERENCES `situacao_interno` (`id_situacao_interno`);

--
-- Limitadores para a tabela `permissao`
--
ALTER TABLE `permissao`
  ADD CONSTRAINT `permissao_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  ADD CONSTRAINT `permissao_ibfk_2` FOREIGN KEY (`id_acao`) REFERENCES `acao` (`id_acao`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_categoria_produto`) REFERENCES `categoria_produto` (`id_categoria_produto`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`id_unidade`) REFERENCES `unidade` (`id_unidade`);

--
-- Limitadores para a tabela `quadro_horario`
--
ALTER TABLE `quadro_horario`
  ADD CONSTRAINT `quadro_horario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Limitadores para a tabela `saida`
--
ALTER TABLE `saida`
  ADD CONSTRAINT `saida_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `destino` (`id_destino`),
  ADD CONSTRAINT `saida_ibfk_2` FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`),
  ADD CONSTRAINT `saida_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_saida` (`id_tipo`),
  ADD CONSTRAINT `saida_ibfk_4` FOREIGN KEY (`id_responsavel`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `voluntario`
--
ALTER TABLE `voluntario`
  ADD CONSTRAINT `voluntario_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `voluntario_cargo`
--
ALTER TABLE `voluntario_cargo`
  ADD CONSTRAINT `voluntario_cargo_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  ADD CONSTRAINT `voluntario_cargo_ibfk_2` FOREIGN KEY (`id_voluntario`) REFERENCES `voluntario` (`id_voluntario`);

--
-- Limitadores para a tabela `voluntario_judicial`
--
ALTER TABLE `voluntario_judicial`
  ADD CONSTRAINT `voluntario_judicial_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `voluntario_judicial_cargo`
--
ALTER TABLE `voluntario_judicial_cargo`
  ADD CONSTRAINT `voluntario_judicial_cargo_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  ADD CONSTRAINT `voluntario_judicial_cargo_ibfk_2` FOREIGN KEY (`id_voluntarioJ`) REFERENCES `voluntario_judicial` (`id_voluntario_judicial`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
