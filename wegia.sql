create database wegia;

use wegia;

DELIMITER $$
--
-- Procedimentos
--
CREATE PROCEDURE `cadentrada` (IN `id_origem` INT, IN `id_almoxarifado` INT, IN `id_tipo` INT, IN `id_responsavel` INT, IN `data` DATE, IN `hora` TIME, IN `valor_total` DECIMAL(10,2), IN `id_entrada` INT, IN `id_produto` INT, IN `qtd` INT, IN `valor_unitario` DECIMAL(10,2))  begin

declare idE int;

insert into entrada (id_origem, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total)
	values(id_origem, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total);

SELECT 
	MAX(id_entrada)
INTO idE FROM entrada;

insert into ientrada(id_entrada, id_produto, qtd, valor_unitario)
	values(idE, id_produto, qtd, valor_unitario);
end$$

CREATE PROCEDURE `cadfuncionario`(IN `nome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(100), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(100), IN `estado` VARCHAR(50), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(100), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(50), IN `vale_transporte` VARCHAR(160), IN `data_admissao` DATE, IN `pis` VARCHAR(140), IN `ctps` VARCHAR(150), IN `uf_ctps` VARCHAR(200), IN `numero_titulo` VARCHAR(150), IN `zona` VARCHAR(300), IN `secao` VARCHAR(400), IN `certificado_reservista_numero` VARCHAR(100), IN `certificado_reservista_serie` VARCHAR(100), IN `calcado` VARCHAR(200), IN `calca` VARCHAR(200), IN `jaleco` VARCHAR(20), IN `camisa` VARCHAR(200), IN `usa_vtp` VARCHAR(300), IN `cesta_basica` VARCHAR(300), IN `situacao` VARCHAR(100), IN `cargo` VARCHAR(30))
begin

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

CREATE PROCEDURE `cadhorario` (IN `escala` VARCHAR(200), IN `tipo` VARCHAR(200), IN `carga_horaria` VARCHAR(200), IN `entrada1` VARCHAR(200), IN `saida1` VARCHAR(200), IN `entrada2` VARCHAR(200), IN `saida2` VARCHAR(200), IN `total` VARCHAR(200), IN `dias_trabalhados` VARCHAR(200), IN `folga` VARCHAR(200))  NO SQL
begin
declare idF int;

SELECT MAX(id_funcionario) into idF FROM funcionario;

insert into quadro_horario(id_funcionario,escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga) VALUES (idF, escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga);

END$$

CREATE PROCEDURE `excluirinterno`(IN `idi` INT)
BEGIN
DECLARE idp int;

select id_pessoa into idp from interno where id_interno=idi;

delete from documento where id_pessoa=idp;

delete i,p from interno as i inner join pessoa as p on p.id_pessoa=i.id_pessoa where i.id_interno=idi;
END$$

CREATE PROCEDURE `excluirfuncionario`(IN `idf` INT)
BEGIN


delete from quadro_horario where id_funcionario=idf;

delete f,p from funcionario as f inner join pessoa as p on p.id_pessoa=f.id_pessoa where f.id_funcionario=idf;
END$$

CREATE PROCEDURE `cadimagem` (IN `id_pessoa` INT, IN `imagem` LONGTEXT, IN `imagem_extensao` VARCHAR(10), IN `descricao` VARCHAR(40))  begin
declare idD int;
insert into documento(id_pessoa,imgdoc,imagem_extensao,descricao) VALUES (id_pessoa,imagem,imagem_extensao,descricao);
END$$

CREATE PROCEDURE `cadinterno` (IN `nome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(25), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(20), IN `estado` VARCHAR(5), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(11), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(5), IN `nome_contato_urgente` VARCHAR(60), IN `telefone_contato_urgente_1` VARCHAR(33), IN `telefone_contato_urgente_2` VARCHAR(33), IN `telefone_contato_urgente_3` VARCHAR(33), IN `certidao_nascimento` VARCHAR(60), IN `curatela` VARCHAR(60), IN `inss` VARCHAR(60), IN `loas` VARCHAR(60), IN `bpc` VARCHAR(60), IN `funrural` VARCHAR(60), IN `saf` VARCHAR(60), IN `sus` VARCHAR(60), IN `certidao_casamento` VARCHAR(123), IN `ctps` VARCHAR(123), IN `titulo` VARCHAR(123))  begin

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

CREATE PROCEDURE `cadsaida` (IN `id_destino` INT, IN `id_almoxarifado` INT, IN `id_tipo` INT, IN `id_responsavel` INT, IN `data` DATE, IN `hora` TIME, IN `valor_total` DECIMAL(10,2), IN `id_saida` INT, IN `id_produto` INT, IN `qtd` INT, IN `valor_unitario` DECIMAL(10,2))  begin

declare idS int;

insert into saida (id_destino, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total)
	values(id_destino, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total);

SELECT 
	MAX(id_saida)
INTO idS FROM saida;

insert into isaida(id_saida, id_produto, qtd, valor_unitario)
	values(idS, id_produto, qtd, valor_unitario);
end$$

DELIMITER ;

CREATE TABLE `acao` (
  `id_acao` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(240) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `almoxarifado` (
  `id_almoxarifado` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao_almoxarifado` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `calca` (
  `id_calcado` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `calcado` (
  `id_calcado` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `camisa` (
  `id_calcado` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cargo` (
  `id_cargo` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cargo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categoria_produto` (
  `id_categoria_produto` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao_categoria` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `destino` (
  `id_destino` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome_destino` varchar(100) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `unidade` (
  `id_unidade` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao_unidade` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `produto` (
  `id_produto` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_categoria_produto` int NOT NULL,
  `id_unidade` int NOT NULL,
  `descricao` varchar(240) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  FOREIGN KEY (`id_categoria_produto`) REFERENCES `categoria_produto` (`id_categoria_produto`),
  FOREIGN KEY (`id_unidade`) REFERENCES `unidade` (`id_unidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `origem` (
  `id_origem` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome_origem` varchar(100) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pessoa` (
  `id_pessoa` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
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

CREATE TABLE `tipo_entrada` (
  `id_tipo` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `entrada` (
  `id_entrada` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_origem` int NOT NULL,
  `id_almoxarifado` int NOT NULL,
  `id_tipo` int NOT NULL,
  `id_responsavel` int NOT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  FOREIGN KEY (`id_origem`) REFERENCES `origem` (`id_origem`),
  FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`),
  FOREIGN KEY (`id_tipo`) REFERENCES `tipo_entrada` (`id_tipo`),
  FOREIGN KEY (`id_responsavel`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `estoque` (
  `id_produto` int NOT NULL,
  `id_almoxarifado` int(11) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produto`,`id_almoxarifado`),
  FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `funcionario` (
  `id_funcionario` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_pessoa` int DEFAULT NULL,
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
  `cargo` varchar(30) DEFAULT NULL,
  FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ientrada` (
  `id_ientrada` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_entrada` int NOT NULL,
  `id_produto` int NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`),
  FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gatilhos `ientrada`
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

CREATE TABLE `interno` (
  `id_interno` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_pessoa` int DEFAULT NULL,
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
  `titulo` varchar(123) NOT NULL,
  FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tipo_saida` (
  `id_tipo` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `saida` (
  `id_saida` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_destino` int NOT NULL,
  `id_almoxarifado` int NOT NULL,
  `id_tipo` int NOT NULL,
  `id_responsavel` int NOT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  FOREIGN KEY (`id_destino`) REFERENCES `destino` (`id_destino`),
  FOREIGN KEY (`id_almoxarifado`) REFERENCES `almoxarifado` (`id_almoxarifado`),
  FOREIGN KEY (`id_tipo`) REFERENCES `tipo_saida` (`id_tipo`),
  FOREIGN KEY (`id_responsavel`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `isaida` (
  `id_isaida` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_saida` int NOT NULL,
  `id_produto` int NOT NULL,
  `qtd` int DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  FOREIGN KEY (`id_saida`) REFERENCES `saida` (`id_saida`),
  FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gatilhos `isaida`
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

CREATE TABLE `jaleco` (
  `id_calcado` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tamanhos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `situacao_funcionario` (
  `id_situacao_funcionario` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `data_hora` datetime DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `imagem` longtext,
  `imagem_extensao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `movimentacao_funcionario` (
  `id_funcionario` int NOT NULL,
  `id_situacao_funcionario` int NOT NULL,
  PRIMARY KEY (`id_funcionario`,`id_situacao_funcionario`),
  FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`),
  FOREIGN KEY (`id_situacao_funcionario`) REFERENCES `situacao_funcionario` (`id_situacao_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `situacao_interno` (
  `id_situacao_interno` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `data_hora` datetime DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `imagem` longtext,
  `imagem_extensao` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `movimentacao_interno` (
  `id_interno` int NOT NULL,
  `id_situacao_interno` int NOT NULL,
  PRIMARY KEY (`id_interno`,`id_situacao_interno`),
  FOREIGN KEY (`id_interno`) REFERENCES `interno` (`id_interno`),
  FOREIGN KEY (`id_situacao_interno`) REFERENCES `situacao_interno` (`id_situacao_interno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `permissao` (
  `id_cargo` int NOT NULL PRIMARY KEY,
  `id_acao` int NOT NULL,
  FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  FOREIGN KEY (`id_acao`) REFERENCES `acao` (`id_acao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `quadro_horario` (
  `id_quadro_horario` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_funcionario` int NOT NULL,
  `escala` varchar(200) DEFAULT NULL,
  `tipo` varchar(200) DEFAULT NULL,
  `carga_horaria` varchar(200) DEFAULT NULL,
  `entrada1` varchar(200) DEFAULT NULL,
  `saida1` varchar(200) DEFAULT NULL,
  `entrada2` varchar(200) DEFAULT NULL,
  `saida2` varchar(200) DEFAULT NULL,
  `total` varchar(200) DEFAULT NULL,
  `dias_trabalhados` varchar(200) DEFAULT NULL,
  `folga` varchar(200) DEFAULT NULL,
   FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `situacao` (
  `id_calcado` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `situacoes` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `voluntario` (
  `id_voluntario` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_pessoa` int DEFAULT NULL,
  FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `voluntario_cargo` (
  `id_cargo` int NOT NULL,
  `id_voluntario` int NOT NULL,
  PRIMARY KEY (`id_cargo`,`id_voluntario`),
  FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  FOREIGN KEY (`id_voluntario`) REFERENCES `voluntario` (`id_voluntario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `voluntario_judicial` (
  `id_voluntario_judicial` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_pessoa` int DEFAULT NULL,
  `documento_judicial` varchar(40) DEFAULT NULL,
  FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `voluntario_judicial_cargo` (
  `id_cargo` int NOT NULL,
  `id_voluntarioJ` int NOT NULL,
  PRIMARY KEY (`id_cargo`,`id_voluntarioJ`),
  FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  FOREIGN KEY (`id_voluntarioJ`) REFERENCES `voluntario_judicial` (`id_voluntario_judicial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `documento` (
  `id_documento` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_pessoa` int NOT NULL,
  `imgdoc` longtext,
  `imagem_extensao` varchar(10) DEFAULT NULL,
  `descricao` varchar(40) DEFAULT NULL,
   FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into pessoa( cpf, senha, nome, sexo, telefone,data_nascimento,imagem, cep ,estado,cidade, bairro, logradouro, numero_endereco, complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo) values('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', 'a', 'telefone','2018-12-16','null', 'cep' ,'estado','cidade', 'bairro', 'logradouro', 'numero_endereco', 'complemento','ibge','registro_geral','orgao_emissor','data_expedicao', 'nome_pai', 'nome_mae', 'tipo_sanguineo')
