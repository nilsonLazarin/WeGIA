create database if not exists wegia;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cadbeneficiados` (IN `id_beneficios` INT, IN `data_inicio` DATETIME, IN `data_fim` DATETIME, IN `beneficios_status` VARCHAR(100), IN `valor` DECIMAL(10,2))  begin

declare idP int;

select max(id_pessoa) into idP FROM pessoa;

insert into beneficiados(id_pessoa,id_beneficios,data_inicio,data_fim,beneficios_status,valor)
values(idP,id_beneficios,data_inicio,data_fim,beneficios_status,valor);



END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadepi` (IN `id_epi` INT, IN `data` DATE, IN `epi_status` VARCHAR(100))  begin

declare idP int;

select max(id_pessoa) into idP FROM pessoa;

insert into pessoa_epi(id_pessoa,id_epi,data,epi_status)
values(idP,id_epi,data,epi_status);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadfuncionario` (IN `nome` VARCHAR(100), IN `sobrenome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(100), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(100), IN `estado` VARCHAR(50), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(100), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(50), IN `data_admissao` DATE, IN `pis` VARCHAR(140), IN `ctps` VARCHAR(150), IN `uf_ctps` VARCHAR(200), IN `numero_titulo` VARCHAR(150), IN `zona` VARCHAR(300), IN `secao` VARCHAR(400), IN `certificado_reservista_numero` VARCHAR(100), IN `certificado_reservista_serie` VARCHAR(100), IN `id_situacao` INT, IN `id_cargo` INT)  begin

declare idP int;
declare idF int;

insert into pessoa(cpf, senha, nome, sobrenome, sexo, telefone,data_nascimento,imagem,cep ,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo)
values(cpf, senha, nome, sobrenome, sexo, telefone,data_nascimento,imagem, cep ,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo);

select max(id_pessoa) into idP FROM pessoa;

insert into funcionario(id_pessoa,id_cargo,id_situacao,data_admissao,pis,ctps,
uf_ctps,numero_titulo,zona,secao,certificado_reservista_numero,certificado_reservista_serie)
values(idP,id_cargo,id_situacao,data_admissao,pis,ctps,uf_ctps,numero_titulo,zona,secao,certificado_reservista_numero,certificado_reservista_serie);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadhorariofunc` (IN `escala` VARCHAR(200), IN `tipo` VARCHAR(200), IN `carga_horaria` VARCHAR(200), IN `entrada1` VARCHAR(200), IN `saida1` VARCHAR(200), IN `entrada2` VARCHAR(200), IN `saida2` VARCHAR(200), IN `total` VARCHAR(200), IN `dias_trabalhados` VARCHAR(200), IN `folga` VARCHAR(200))  NO SQL
begin
declare idF int;

SELECT MAX(id_funcionario) into idF FROM funcionario;

insert into quadro_horario_funcionario(id_funcionario,escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga) 
VALUES (idF, escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadhorariovolunt` (IN `escala` VARCHAR(200), IN `tipo` VARCHAR(200), IN `carga_horaria` VARCHAR(200), IN `entrada1` VARCHAR(200), IN `saida1` VARCHAR(200), IN `entrada2` VARCHAR(200), IN `saida2` VARCHAR(200), IN `total` VARCHAR(200), IN `dias_trabalhados` VARCHAR(200), IN `folga` VARCHAR(200))  NO SQL
begin
declare idV int;

SELECT MAX(id_voluntario) into idV FROM voluntario;

insert into quadro_horario_voluntario(id_voluntario,escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga) 
VALUES (idF, escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadimagem` (IN `id_pessoa` INT, IN `imagem` LONGTEXT, IN `imagem_extensao` VARCHAR(10), IN `descricao` VARCHAR(40))  begin
declare idD int;
insert into documento(id_pessoa,imgdoc,imagem_extensao,descricao) VALUES (id_pessoa,imagem,imagem_extensao,descricao);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadinterno` (IN `nome` VARCHAR(100), IN `sobrenome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(25), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(20), IN `estado` VARCHAR(5), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(11), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(5), IN `nome_contato_urgente` VARCHAR(60), IN `telefone_contato_urgente_1` VARCHAR(33), IN `telefone_contato_urgente_2` VARCHAR(33), IN `telefone_contato_urgente_3` VARCHAR(33), IN `observacao` VARCHAR(240), IN `certidao_nascimento` VARCHAR(60), IN `curatela` VARCHAR(60), IN `inss` VARCHAR(60), IN `loas` VARCHAR(60), IN `bpc` VARCHAR(60), IN `funrural` VARCHAR(60), IN `saf` VARCHAR(60), IN `sus` VARCHAR(60), IN `certidao_casamento` VARCHAR(123), IN `ctps` VARCHAR(123), IN `titulo` VARCHAR(123))  begin

declare idP int;

insert into pessoa(nome,sobrenome,cpf,senha,sexo,telefone,data_nascimento,imagem,cep,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo)
values(nome, sobrenome, cpf, senha, sexo, telefone,data_nascimento,imagem,cep,estado,cidade,bairro,logradouro,numero_endereco,complemento,ibge,registro_geral,orgao_emissor,data_expedicao,nome_pai,nome_mae,tipo_sanguineo);
select max(id_pessoa) into idP FROM pessoa;

insert into interno(id_pessoa,nome_contato_urgente,telefone_contato_urgente_1,telefone_contato_urgente_2,telefone_contato_urgente_3,observacao,certidao_nascimento,curatela,inss,loas,bpc,funrural,saf,sus,certidao_casamento,ctps,titulo) 
values(idP,nome_contato_urgente,telefone_contato_urgente_1,telefone_contato_urgente_2,telefone_contato_urgente_3,observacao,certidao_nascimento,curatela,inss,loas,bpc,funrural,saf,sus,certidao_casamento,ctps,titulo);
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
DECLARE idp int;

delete from quadro_horario_funcionario where id_funcionario=idf;

select id_pessoa into idp from funcionario where id_funcionario=idf;

delete from beneficiados where id_pessoa=idp;

delete from pessoa_epi where id_pessoa=idp;

delete f,p from funcionario as f inner join pessoa as p on p.id_pessoa=f.id_pessoa where f.id_funcionario=idf;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `excluirinterno` (IN `idi` INT)  BEGIN
DECLARE idp int;

select id_pessoa into idp from interno where id_interno=idi;

delete from documento where id_pessoa=idp;

delete i,p from interno as i inner join pessoa as p on p.id_pessoa=i.id_pessoa where i.id_interno=idi;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insanexo`(IN `id_despacho` INT, IN `anexo` LONGTEXT, IN `extensao` VARCHAR(11), IN `nome` VARCHAR(11))
BEGIN
declare idA int;
       INSERT INTO anexo(id_despacho, anexo, extensao, nome)
       values (id_despacho, anexo, extensao, nome);
       
       SELECT max(id_anexo) into idA from anexo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insdespacho` (IN `id_memorando` INT, IN `id_remetente` INT, IN `id_destinatario` INT, IN `texto` LONGTEXT, IN `data` TIMESTAMP)  BEGIN 
		declare idD int;
        INSERT INTO despacho(id_memorando, id_remetente, id_destinatario, texto, data)
        values (id_memorando, id_remetente, id_destinatario, texto, data);
        
        SELECT max(id_despacho) into idD from despacho;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insmemorando` (IN `id_pessoa` INT, IN `id_status_memorando` INT, IN `titulo` TEXT, IN `data` VARCHAR(255))  BEGIN 
		declare idM int;
        INSERT INTO memorando(id_pessoa, id_status_memorando, titulo, data)
        values (id_pessoa, id_status_memorando, titulo, data);
        
        SELECT max(id_memorando) into idM from memorando;
        
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `beneficiados`
--

CREATE TABLE `beneficiados` (
  `id_beneficiados` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `id_beneficios` int(11) NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `beneficios_status` varchar(100) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `beneficios`
--

CREATE TABLE `beneficios` (
  `id_beneficios` int(11) NOT NULL,
  `descricao_beneficios` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `campo_imagem`
--

CREATE TABLE `campo_imagem` (
  `id_campo` int(11) NOT NULL,
  `nome_campo` varchar(40) NOT NULL,
  `tipo` enum('img','car') NOT NULL
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
  `descricao_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `despacho`
--

CREATE TABLE `despacho` (
  `id_despacho` int(11) NOT NULL,
  `id_memorando` int(11) NOT NULL,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `id_status_despacho` int(11) NOT NULL,
  `texto` longtext,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Estrutura da tabela `epi`
--

CREATE TABLE `epi` (
  `id_epi` int(11) NOT NULL,
  `descricao_epi` varchar(100) DEFAULT NULL
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
  `id_cargo` int(11) DEFAULT NULL,
  `id_situacao` int(11) DEFAULT NULL,
  `data_admissao` date NOT NULL,
  `pis` varchar(140) DEFAULT NULL,
  `ctps` varchar(150) NOT NULL,
  `uf_ctps` varchar(20) DEFAULT NULL,
  `numero_titulo` varchar(150) DEFAULT NULL,
  `zona` varchar(30) DEFAULT NULL,
  `secao` varchar(40) DEFAULT NULL,
  `certificado_reservista_numero` varchar(100) DEFAULT NULL,
  `certificado_reservista_serie` varchar(100) DEFAULT NULL
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
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `id_imagem` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `imagem` longblob NOT NULL,
  `tipo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `observacao` varchar(240) DEFAULT NULL,
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
-- Estrutura da tabela `memorando`
--

CREATE TABLE `memorando` (
  `id_memorando` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `id_status_memorando` int(11) DEFAULT NULL,
  `titulo` text,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `sobrenome` varchar(100) DEFAULT NULL,
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
  `tipo_sanguineo` varchar(5) DEFAULT NULL,
  `nivel_acesso` tinyint(4) DEFAULT '0',
  `adm_configurado` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `cpf`, `senha`, `nome`, `sobrenome`, `sexo`, `telefone`, `data_nascimento`, `imagem`, `cep`, `estado`, `cidade`, `bairro`, `logradouro`, `numero_endereco`, `complemento`, `ibge`, `registro_geral`, `orgao_emissor`, `data_expedicao`, `nome_mae`, `nome_pai`, `tipo_sanguineo`, `nivel_acesso`, `adm_configurado`) VALUES
(1, 'admin', '835d6dc88b708bc646d6db82c853ef4182fabbd4a8de59c213f2b5ab3ae7d9be', 'admin', 'admin', 'a', 'telefone', '2018-12-16', 'null', 'cep', 'estad', 'cidade', 'bairro', 'logradouro', 'numero_end', 'complemento', 'ibge', 'registro_geral', 'orgao_emissor', '0000-00-00', 'nome_mae', 'nome_pai', 'tipo_', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_epi`
--

CREATE TABLE `pessoa_epi` (
  `id_pessoa_epi` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `id_epi` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `epi_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_categoria_produto` int(11) NOT NULL,
  `id_unidade` int(11) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quadro_horario_funcionario`
--

CREATE TABLE `quadro_horario_funcionario` (
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
-- Estrutura da tabela `quadro_horario_voluntario`
--

CREATE TABLE `quadro_horario_voluntario` (
  `id_quadro_horario` int(11) NOT NULL,
  `id_voluntario` int(11) NOT NULL,
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
-- Estrutura da tabela `selecao_paragrafo`
--

CREATE TABLE `selecao_paragrafo` (
  `id_selecao` int(11) NOT NULL,
  `nome_campo` varchar(40) NOT NULL,
  `paragrafo` text NOT NULL,
  `original` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL,
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
  `id_status_memorando` int(11) NOT NULL,
  `status_atual` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_imagem_campo`
--

CREATE TABLE `tabela_imagem_campo` (
  `id_relacao` int(11) NOT NULL,
  `id_campo` int(11) NOT NULL,
  `id_imagem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `descricao_unidade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `voluntario`
--

CREATE TABLE `voluntario` (
  `id_voluntario` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `descricao_atividade` varchar(100) DEFAULT NULL,
  `data_admissao` date NOT NULL,
  `situacao` varchar(100) DEFAULT NULL,
  `cargo` varchar(30) DEFAULT NULL
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
  ADD KEY `id_despacho` (`id_despacho`);

--
-- Indexes for table `beneficiados`
--
ALTER TABLE `beneficiados`
  ADD PRIMARY KEY (`id_beneficiados`),
  ADD KEY `id_beneficios` (`id_beneficios`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `beneficios`
--
ALTER TABLE `beneficios`
  ADD PRIMARY KEY (`id_beneficios`),
  ADD UNIQUE KEY `descricao_beneficios` (`descricao_beneficios`);

--
-- Indexes for table `campo_imagem`
--
ALTER TABLE `campo_imagem`
  ADD PRIMARY KEY (`id_campo`),
  ADD UNIQUE KEY `nome_campo` (`nome_campo`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`),
  ADD UNIQUE KEY `cargo` (`cargo`);

--
-- Indexes for table `categoria_produto`
--
ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`id_categoria_produto`),
  ADD UNIQUE KEY `descricao_categoria` (`descricao_categoria`);

--
-- Indexes for table `despacho`
--
ALTER TABLE `despacho`
  ADD PRIMARY KEY (`id_despacho`),
  ADD KEY `id_memorando` (`id_memorando`),
  ADD KEY `id_remetente` (`id_remetente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

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
-- Indexes for table `epi`
--
ALTER TABLE `epi`
  ADD PRIMARY KEY (`id_epi`),
  ADD UNIQUE KEY `descricao_epi` (`descricao_epi`);

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
-- Indexes for table `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`id_imagem`),
  ADD UNIQUE KEY `nome` (`nome`);

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
-- Indexes for table `memorando`
--
ALTER TABLE `memorando`
  ADD PRIMARY KEY (`id_memorando`),
  ADD KEY `id_pessoa` (`id_pessoa`),
  ADD KEY `id_status_memorando` (`id_status_memorando`);

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
-- Indexes for table `pessoa_epi`
--
ALTER TABLE `pessoa_epi`
  ADD PRIMARY KEY (`id_pessoa_epi`),
  ADD KEY `id_pessoa` (`id_pessoa`),
  ADD KEY `id_epi` (`id_epi`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD UNIQUE KEY `descricao` (`descricao`),
  ADD KEY `id_categoria_produto` (`id_categoria_produto`),
  ADD KEY `id_unidade` (`id_unidade`);

--
-- Indexes for table `quadro_horario_funcionario`
--
ALTER TABLE `quadro_horario_funcionario`
  ADD PRIMARY KEY (`id_quadro_horario`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `quadro_horario_voluntario`
--
ALTER TABLE `quadro_horario_voluntario`
  ADD PRIMARY KEY (`id_quadro_horario`),
  ADD KEY `id_voluntario` (`id_voluntario`);

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
-- Indexes for table `selecao_paragrafo`
--
ALTER TABLE `selecao_paragrafo`
  ADD PRIMARY KEY (`id_selecao`);

--
-- Indexes for table `situacao`
--
ALTER TABLE `situacao`
  ADD PRIMARY KEY (`id_situacao`),
  ADD UNIQUE KEY `situacoes` (`situacoes`);

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
  ADD PRIMARY KEY (`id_status_memorando`);

--
-- Indexes for table `tabela_imagem_campo`
--
ALTER TABLE `tabela_imagem_campo`
  ADD PRIMARY KEY (`id_relacao`),
  ADD KEY `id_campo` (`id_campo`),
  ADD KEY `id_imagem` (`id_imagem`);

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
  ADD PRIMARY KEY (`id_unidade`),
  ADD UNIQUE KEY `descricao_unidade` (`descricao_unidade`);

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
-- AUTO_INCREMENT for table `beneficiados`
--
ALTER TABLE `beneficiados`
  MODIFY `id_beneficiados` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `beneficios`
--
ALTER TABLE `beneficios`
  MODIFY `id_beneficios` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `campo_imagem`
--
ALTER TABLE `campo_imagem`
  MODIFY `id_campo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categoria_produto`
--
ALTER TABLE `categoria_produto`
  MODIFY `id_categoria_produto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `despacho`
--
ALTER TABLE `despacho`
  MODIFY `id_despacho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
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
-- AUTO_INCREMENT for table `epi`
--
ALTER TABLE `epi`
  MODIFY `id_epi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ientrada`
--
ALTER TABLE `ientrada`
  MODIFY `id_ientrada` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `imagem`
--
ALTER TABLE `imagem`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
-- AUTO_INCREMENT for table `memorando`
--
ALTER TABLE `memorando`
  MODIFY `id_memorando` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
--
-- AUTO_INCREMENT for table `origem`
--
ALTER TABLE `origem`
  MODIFY `id_origem` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pessoa_epi`
--
ALTER TABLE `pessoa_epi`
  MODIFY `id_pessoa_epi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quadro_horario_funcionario`
--
ALTER TABLE `quadro_horario_funcionario`
  MODIFY `id_quadro_horario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quadro_horario_voluntario`
--
ALTER TABLE `quadro_horario_voluntario`
  MODIFY `id_quadro_horario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saida`
--
ALTER TABLE `saida`
  MODIFY `id_saida` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `selecao_paragrafo`
--
ALTER TABLE `selecao_paragrafo`
  MODIFY `id_selecao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id_situacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id_status_memorando` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tabela_imagem_campo`
--
ALTER TABLE `tabela_imagem_campo`
  MODIFY `id_relacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
  ADD CONSTRAINT `anexo_ibfk_1` FOREIGN KEY (`id_despacho`) REFERENCES `despacho` (`id_despacho`);

--
-- Limitadores para a tabela `beneficiados`
--
ALTER TABLE `beneficiados`
  ADD CONSTRAINT `beneficiados_ibfk_1` FOREIGN KEY (`id_beneficios`) REFERENCES `beneficios` (`id_beneficios`),
  ADD CONSTRAINT `beneficiados_ibfk_2` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `despacho`
--
ALTER TABLE `despacho`
  ADD CONSTRAINT `despacho_ibfk_1` FOREIGN KEY (`id_memorando`) REFERENCES `memorando` (`id_memorando`),
  ADD CONSTRAINT `despacho_ibfk_2` FOREIGN KEY (`id_remetente`) REFERENCES `pessoa` (`id_pessoa`),
  ADD CONSTRAINT `despacho_ibfk_3` FOREIGN KEY (`id_destinatario`) REFERENCES `pessoa` (`id_pessoa`);

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
  ADD CONSTRAINT `memorando_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`),
  ADD CONSTRAINT `memorando_ibfk_2` FOREIGN KEY (`id_status_memorando`) REFERENCES `status_memorando` (`id_status_memorando`);

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
-- Limitadores para a tabela `pessoa_epi`
--
ALTER TABLE `pessoa_epi`
  ADD CONSTRAINT `pessoa_epi_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`),
  ADD CONSTRAINT `pessoa_epi_ibfk_2` FOREIGN KEY (`id_epi`) REFERENCES `epi` (`id_epi`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_categoria_produto`) REFERENCES `categoria_produto` (`id_categoria_produto`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`id_unidade`) REFERENCES `unidade` (`id_unidade`);

--
-- Limitadores para a tabela `quadro_horario_funcionario`
--
ALTER TABLE `quadro_horario_funcionario`
  ADD CONSTRAINT `quadro_horario_funcionario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Limitadores para a tabela `quadro_horario_voluntario`
--
ALTER TABLE `quadro_horario_voluntario`
  ADD CONSTRAINT `quadro_horario_voluntario_ibfk_1` FOREIGN KEY (`id_voluntario`) REFERENCES `voluntario` (`id_voluntario`);

--
-- Limitadores para a tabela `saida`
--
ALTER TABLE `saida`
  ADD CONSTRAINT `saida_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `destino` (`id_destino`),
  ADD CONSTRAINT `saida_ibfk_2` FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`),
  ADD CONSTRAINT `saida_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_saida` (`id_tipo`),
  ADD CONSTRAINT `saida_ibfk_4` FOREIGN KEY (`id_responsavel`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Limitadores para a tabela `tabela_imagem_campo`
--
ALTER TABLE `tabela_imagem_campo`
  ADD CONSTRAINT `tabela_imagem_campo_ibfk_1` FOREIGN KEY (`id_campo`) REFERENCES `campo_imagem` (`id_campo`),
  ADD CONSTRAINT `tabela_imagem_campo_ibfk_2` FOREIGN KEY (`id_imagem`) REFERENCES `imagem` (`id_imagem`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
