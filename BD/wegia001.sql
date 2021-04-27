SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema wegia
-- -----------------------------------------------------
DROP DATABASE IF EXISTS wegia;

CREATE SCHEMA IF NOT EXISTS `wegia` DEFAULT CHARACTER SET utf8mb4 ;

USE `wegia` ;

-- -----------------------------------------------------
-- Table `wegia`.`acao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`acao` (
  `id_acao` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(240) NULL DEFAULT NULL,
  PRIMARY KEY (`id_acao`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`almoxarifado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`almoxarifado` (
  `id_almoxarifado` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao_almoxarifado` VARCHAR(240) NOT NULL,
  PRIMARY KEY (`id_almoxarifado`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`almoxarife`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`almoxarife` (
  `id_almoxarife` INT(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` INT(11) NOT NULL,
  `id_almoxarifado` INT NOT NULL,
  `data_registro` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_almoxarife`),
  INDEX `id_almoxarife` (`id_almoxarife` ASC),
  CONSTRAINT `almoxarife_ibfk_1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`),
  CONSTRAINT `almoxarife_ibfk_2`
    FOREIGN KEY (`id_almoxarifado`)
    REFERENCES `wegia`.`almoxarifado` (`id_almoxarifado`)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pessoa` (
  `id_pessoa` INT(11) NOT NULL AUTO_INCREMENT,
  `cpf` VARCHAR(120) NOT NULL UNIQUE,
  `senha` VARCHAR(70) NULL DEFAULT NULL,
  `nome` VARCHAR(100) NULL DEFAULT NULL,
  `sobrenome` VARCHAR(100) NULL DEFAULT NULL,
  `sexo` CHAR(1) NULL DEFAULT NULL,
  `telefone` VARCHAR(25) NULL DEFAULT NULL,
  `data_nascimento` DATE NULL DEFAULT NULL,
  `imagem` LONGTEXT NULL DEFAULT NULL,
  `cep` VARCHAR(10) NULL DEFAULT NULL,
  `estado` VARCHAR(5) NULL DEFAULT NULL,
  `cidade` VARCHAR(40) NULL DEFAULT NULL,
  `bairro` VARCHAR(40) NULL DEFAULT NULL,
  `logradouro` VARCHAR(40) NULL DEFAULT NULL,
  `numero_endereco` VARCHAR(80) NULL DEFAULT NULL,
  `complemento` VARCHAR(50) NULL DEFAULT NULL,
  `ibge` VARCHAR(20) NULL DEFAULT NULL,
  `registro_geral` VARCHAR(120) NULL DEFAULT NULL,
  `orgao_emissor` VARCHAR(120) NULL DEFAULT NULL,
  `data_expedicao` DATE NULL DEFAULT NULL,
  `nome_mae` VARCHAR(100) NULL DEFAULT NULL,
  `nome_pai` VARCHAR(100) NULL DEFAULT NULL,
  `tipo_sanguineo` VARCHAR(5) NULL DEFAULT NULL,
  `nivel_acesso` TINYINT(4) NULL DEFAULT '0',
  `adm_configurado` TINYINT(4) NULL DEFAULT '0',
  PRIMARY KEY (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`status_memorando`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`status_memorando` (
  `id_status_memorando` INT(11) NOT NULL AUTO_INCREMENT,
  `status_atual` VARCHAR(60) NULL DEFAULT NULL,
  PRIMARY KEY (`id_status_memorando`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`memorando`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`memorando` (
  `id_memorando` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL,
  `id_status_memorando` INT(11) NULL DEFAULT NULL,
  `titulo` TEXT NULL DEFAULT NULL,
  `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_memorando`),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  INDEX `id_status_memorando` (`id_status_memorando` ASC),
  CONSTRAINT `memorando_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
  CONSTRAINT `memorando_ibfk_2`
    FOREIGN KEY (`id_status_memorando`)
    REFERENCES `wegia`.`status_memorando` (`id_status_memorando`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`despacho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`despacho` (
  `id_despacho` INT(11) NOT NULL AUTO_INCREMENT,
  `id_memorando` INT(11) NOT NULL,
  `id_remetente` INT(11) NOT NULL,
  `id_destinatario` INT(11) NOT NULL,
  `texto` LONGTEXT NULL DEFAULT NULL,
  `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_despacho`),
  INDEX `id_memorando` (`id_memorando` ASC),
  INDEX `id_remetente` (`id_remetente` ASC),
  INDEX `id_destinatario` (`id_destinatario` ASC),
  CONSTRAINT `despacho_ibfk_1`
    FOREIGN KEY (`id_memorando`)
    REFERENCES `wegia`.`memorando` (`id_memorando`),
  CONSTRAINT `despacho_ibfk_2`
    FOREIGN KEY (`id_remetente`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
  CONSTRAINT `despacho_ibfk_3`
    FOREIGN KEY (`id_destinatario`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`anexo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`anexo` (
  `id_anexo` INT(11) NOT NULL AUTO_INCREMENT,
  `id_despacho` INT(11) NOT NULL,
  `anexo` LONGBLOB NULL DEFAULT NULL,
  `extensao` VARCHAR(256) NOT NULL,
  `nome` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id_anexo`),
  INDEX `id_despacho` (`id_despacho` ASC),
  CONSTRAINT `anexo_ibfk_1`
    FOREIGN KEY (`id_despacho`)
    REFERENCES `wegia`.`despacho` (`id_despacho`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`beneficios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`beneficios` (
  `id_beneficios` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao_beneficios` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_beneficios`),
  UNIQUE INDEX `descricao_beneficios` (`descricao_beneficios` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`beneficiados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`beneficiados` (
  `id_beneficiados` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL,
  `id_beneficios` INT(11) NOT NULL,
  `data_inicio` DATE NULL DEFAULT NULL,
  `data_fim` DATE NULL DEFAULT NULL,
  `beneficios_status` VARCHAR(100) NULL DEFAULT NULL,
  `valor` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_beneficiados`),
  INDEX `id_beneficios` (`id_beneficios` ASC),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  CONSTRAINT `beneficiados_ibfk_1`
    FOREIGN KEY (`id_beneficios`)
    REFERENCES `wegia`.`beneficios` (`id_beneficios`),
  CONSTRAINT `beneficiados_ibfk_2`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`campo_imagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`campo_imagem` (
  `id_campo` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_campo` VARCHAR(40) NOT NULL,
  `tipo` ENUM('img', 'car') NOT NULL,
  PRIMARY KEY (`id_campo`),
  UNIQUE INDEX `nome_campo` (`nome_campo` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`cargo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`cargo` (
  `id_cargo` INT(11) NOT NULL AUTO_INCREMENT,
  `cargo` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id_cargo`),
  UNIQUE INDEX `cargo` (`cargo` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`categoria_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`categoria_produto` (
  `id_categoria_produto` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao_categoria` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_categoria_produto`),
  UNIQUE INDEX `descricao_categoria` (`descricao_categoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`destino`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`destino` (
  `id_destino` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_destino` VARCHAR(100) NOT NULL,
  `cnpj` VARCHAR(20) NULL DEFAULT NULL,
  `cpf` VARCHAR(20) NULL DEFAULT NULL,
  `telefone` VARCHAR(33) NULL DEFAULT NULL,
  PRIMARY KEY (`id_destino`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`documento` (
  `id_documento` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL,
  `imgdoc` LONGBLOB NULL DEFAULT NULL,
  `imagem_extensao` VARCHAR(10) NULL DEFAULT NULL,
  `descricao` VARCHAR(40) NULL DEFAULT NULL,
  PRIMARY KEY (`id_documento`),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  CONSTRAINT `documento_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`origem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`origem` (
  `id_origem` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_origem` VARCHAR(100) NOT NULL,
  `cnpj` VARCHAR(20) NULL DEFAULT NULL,
  `cpf` VARCHAR(20) NULL DEFAULT NULL,
  `telefone` VARCHAR(33) NULL DEFAULT NULL,
  PRIMARY KEY (`id_origem`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`tipo_entrada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`tipo_entrada` (
  `id_tipo` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`id_tipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`entrada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`entrada` (
  `id_entrada` INT(11) NOT NULL AUTO_INCREMENT,
  `id_origem` INT(11) NOT NULL,
  `id_almoxarifado` INT(11) NOT NULL,
  `id_tipo` INT(11) NOT NULL,
  `id_responsavel` INT(11) NOT NULL,
  `data` DATE NULL DEFAULT NULL,
  `hora` TIME NULL DEFAULT NULL,
  `valor_total` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_entrada`),
  INDEX `id_origem` (`id_origem` ASC),
  INDEX `id_almoxarifado` (`id_almoxarifado` ASC),
  INDEX `id_tipo` (`id_tipo` ASC),
  INDEX `id_responsavel` (`id_responsavel` ASC),
  CONSTRAINT `entrada_ibfk_1`
    FOREIGN KEY (`id_origem`)
    REFERENCES `wegia`.`origem` (`id_origem`),
  CONSTRAINT `entrada_ibfk_2`
    FOREIGN KEY (`id_almoxarifado`)
    REFERENCES `wegia`.`almoxarifado` (`id_almoxarifado`),
  CONSTRAINT `entrada_ibfk_3`
    FOREIGN KEY (`id_tipo`)
    REFERENCES `wegia`.`tipo_entrada` (`id_tipo`),
  CONSTRAINT `entrada_ibfk_4`
    FOREIGN KEY (`id_responsavel`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`epi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`epi` (
  `id_epi` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao_epi` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_epi`),
  UNIQUE INDEX `descricao_epi` (`descricao_epi` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`unidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`unidade` (
  `id_unidade` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao_unidade` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_unidade`),
  UNIQUE INDEX `descricao_unidade` (`descricao_unidade` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`produto` (
  `id_produto` INT(11) NOT NULL AUTO_INCREMENT,
  `id_categoria_produto` INT(11) NOT NULL,
  `id_unidade` INT(11) NOT NULL,
  `descricao` VARCHAR(150) NULL DEFAULT NULL,
  `codigo` VARCHAR(15) NULL DEFAULT NULL,
  `preco` DECIMAL(10,2) NULL DEFAULT NULL,
  `oculto` BOOLEAN NULL DEFAULT FALSE,
  PRIMARY KEY (`id_produto`),
  UNIQUE INDEX `descricao` (`descricao` ASC),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  INDEX `id_categoria_produto` (`id_categoria_produto` ASC),
  INDEX `id_unidade` (`id_unidade` ASC),
  CONSTRAINT `produto_ibfk_1`
    FOREIGN KEY (`id_categoria_produto`)
    REFERENCES `wegia`.`categoria_produto` (`id_categoria_produto`),
  CONSTRAINT `produto_ibfk_2`
    FOREIGN KEY (`id_unidade`)
    REFERENCES `wegia`.`unidade` (`id_unidade`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`estoque`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`estoque` (
  `id_produto` INT(11) NOT NULL,
  `id_almoxarifado` INT(11) NOT NULL,
  `qtd` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_produto`, `id_almoxarifado`),
  INDEX `id_almoxarifado` (`id_almoxarifado` ASC),
  CONSTRAINT `estoque_ibfk_1`
    FOREIGN KEY (`id_produto`)
    REFERENCES `wegia`.`produto` (`id_produto`),
  CONSTRAINT `estoque_ibfk_2`
    FOREIGN KEY (`id_almoxarifado`)
    REFERENCES `wegia`.`almoxarifado` (`id_almoxarifado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario` (
  `id_funcionario` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL,
  `id_cargo` INT(11) NOT NULL,
  `id_situacao` INT(11) NOT NULL,
  `data_admissao` DATE NOT NULL,
  `pis` VARCHAR(140) NULL DEFAULT NULL,
  `ctps` VARCHAR(150) NOT NULL,
  `uf_ctps` VARCHAR(20) NULL DEFAULT NULL,
  `numero_titulo` VARCHAR(150) NULL DEFAULT NULL,
  `zona` VARCHAR(30) NULL DEFAULT NULL,
  `secao` VARCHAR(40) NULL DEFAULT NULL,
  `certificado_reservista_numero` VARCHAR(100) NULL DEFAULT NULL,
  `certificado_reservista_serie` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_funcionario`),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  INDEX `fk_funcionario_cargo1_idx` (`id_cargo` ASC),
  INDEX `fk_funcionario_situacao1_idx` (`id_situacao` ASC),
  CONSTRAINT `funcionario_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
  CONSTRAINT `fk_funcionario_cargo1`
    FOREIGN KEY (`id_cargo`)
    REFERENCES `wegia`.`cargo` (`id_cargo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_funcionario_situacao1`
    FOREIGN KEY (`id_situacao`)
    REFERENCES `wegia`.`situacao` (`id_situacao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;
				       
-- -----------------------------------------------------
-- Table `wegia`.`funcionario_docfuncional`
-- -----------------------------------------------------
CREATE TABLE `wegia`.`funcionario_docfuncional`(
 `id_docfuncional` INT NOT NULL AUTO_INCREMENT,
 `nome_docfuncional` VARCHAR(50) NOT NULL,
 `descricao_docfuncional` VARCHAR(256) NULL DEFAULT NULL,
 PRIMARY KEY (`id_docfuncional`)
) ENGINE = InnoDB; 

-- -----------------------------------------------------
-- Table `wegia`.`funcionario_docs`
-- -----------------------------------------------------
CREATE TABLE `wegia`.`funcionario_docs` (
`id_fundocs` INT NOT NULL AUTO_INCREMENT,
`id_funcionario` INT NOT NULL, 
`id_docfuncional` INT NOT NULL,
`data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`extensao_arquivo` VARCHAR(50) NOT NULL,
`nome_arquivo` VARCHAR(256) NOT NULL,
`arquivo` LONGBLOB NOT NULL,
PRIMARY KEY (`id_fundocs`),
CONSTRAINT `funcionariodocs_ibfk_1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`),
CONSTRAINT `funcionariodocs_ibfk_2`
    FOREIGN KEY (`id_docfuncional`)
    REFERENCES `wegia`.`funcionario_docfuncional` (`id_docfuncional`)
) ENGINE = InnoDB; 

-- -----------------------------------------------------
-- Table `wegia`.`funcionario_dependente_parentesco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_dependente_parentesco` (
  `id_parentesco` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_parentesco`),
  UNIQUE INDEX `id_parentesco_UNIQUE` (`id_parentesco` ASC),
  UNIQUE INDEX `descricao_UNIQUE` (`descricao` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_docdependentes` (
  `id_docdependentes` INT NOT NULL AUTO_INCREMENT,
  `nome_docdependente` VARCHAR(50) NOT NULL,
  `descricao_docdependente` VARCHAR(256) NULL,
  PRIMARY KEY (`id_docdependentes`),
  UNIQUE INDEX `id_docdependentes_UNIQUE` (`id_docdependentes` ASC),
  UNIQUE INDEX `nome_docdependente_UNIQUE` (`nome_docdependente` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`funcionario_dependentes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_dependentes` (
  `id_dependente` INT NOT NULL AUTO_INCREMENT,
  `id_funcionario` INT(11) NOT NULL,
  `id_pessoa` INT(11) NOT NULL,
  `id_parentesco` INT NOT NULL,
  PRIMARY KEY (`id_dependente`),
  INDEX `fk_funcionario_dependente_funcionario1_idx` (`id_funcionario` ASC),
  INDEX `fk_funcionario_dependente_pessoa1_idx` (`id_pessoa` ASC),
  INDEX `fk_funcionario_dependente_funcionario_dependente_parentesco_idx` (`id_parentesco` ASC),
  CONSTRAINT `fk_funcionario_dependente_funcionario1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_dependente_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_dependente_funcionario_dependente_parentesco1`
    FOREIGN KEY (`id_parentesco`)
    REFERENCES `wegia`.`funcionario_dependente_parentesco` (`id_parentesco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_dependentes_docs` (
  `id_doc` INT NOT NULL AUTO_INCREMENT,
  `id_dependente` INT NOT NULL,
  `id_docdependentes` INT NOT NULL,
  `data` TIMESTAMP NOT NULL,
  `extensao_arquivo` VARCHAR(50) NOT NULL,
  `nome_arquivo` VARCHAR(256) NOT NULL,
  `arquivo` LONGBLOB NOT NULL,
  PRIMARY KEY (`id_doc`),
  UNIQUE INDEX `id_doc_UNIQUE` (`id_doc` ASC),
  INDEX `fk_funcionario_dependente_documentos_funcionario_dependente_idx` (`id_dependente` ASC),
  INDEX `fk_funcionario_dependente_docs_funcionario_docdependentes1_idx` (`id_docdependentes` ASC),
  CONSTRAINT `fk_funcionario_dependente_documentos_funcionario_dependentes1`
    FOREIGN KEY (`id_dependente`)
    REFERENCES `wegia`.`funcionario_dependentes` (`id_dependente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_dependente_docs_funcionario_docdependentes1`
    FOREIGN KEY (`id_docdependentes`)
    REFERENCES `wegia`.`funcionario_docdependentes` (`id_docdependentes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`ientrada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`ientrada` (
  `id_ientrada` INT(11) NOT NULL AUTO_INCREMENT,
  `id_entrada` INT(11) NOT NULL,
  `id_produto` INT(11) NOT NULL,
  `qtd` INT(11) NULL DEFAULT NULL,
  `valor_unitario` DECIMAL(10,2) NULL DEFAULT NULL,
  `oculto` BOOLEAN NULL DEFAULT FALSE,
  PRIMARY KEY (`id_ientrada`),
  INDEX `id_entrada` (`id_entrada` ASC),
  INDEX `id_produto` (`id_produto` ASC),
  CONSTRAINT `ientrada_ibfk_1`
    FOREIGN KEY (`id_entrada`)
    REFERENCES `wegia`.`entrada` (`id_entrada`),
  CONSTRAINT `ientrada_ibfk_2`
    FOREIGN KEY (`id_produto`)
    REFERENCES `wegia`.`produto` (`id_produto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`imagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`imagem` (
  `id_imagem` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `imagem` LONGBLOB NOT NULL,
  `tipo` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id_imagem`),
  UNIQUE INDEX `nome` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`interno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`interno` (
  `id_interno` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NULL DEFAULT NULL,
  `nome_contato_urgente` VARCHAR(60) NULL DEFAULT NULL,
  `telefone_contato_urgente_1` VARCHAR(33) NULL DEFAULT NULL,
  `telefone_contato_urgente_2` VARCHAR(33) NULL DEFAULT NULL,
  `telefone_contato_urgente_3` VARCHAR(33) NULL DEFAULT NULL,
  `observacao` VARCHAR(240) NULL DEFAULT NULL,
  `certidao_nascimento` VARCHAR(60) NULL DEFAULT NULL,
  `curatela` VARCHAR(60) NULL DEFAULT NULL,
  `inss` VARCHAR(60) NULL DEFAULT NULL,
  `loas` VARCHAR(60) NULL DEFAULT NULL,
  `bpc` VARCHAR(60) NULL DEFAULT NULL,
  `funrural` VARCHAR(60) NULL DEFAULT NULL,
  `saf` VARCHAR(60) NULL DEFAULT NULL,
  `sus` VARCHAR(60) NULL DEFAULT NULL,
  `certidao_casamento` VARCHAR(123) NOT NULL,
  `ctps` VARCHAR(123) NOT NULL,
  `titulo` VARCHAR(123) NOT NULL,
  PRIMARY KEY (`id_interno`),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  CONSTRAINT `interno_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`tipo_saida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`tipo_saida` (
  `id_tipo` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`id_tipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`saida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saida` (
  `id_saida` INT(11) NOT NULL AUTO_INCREMENT,
  `id_destino` INT(11) NOT NULL,
  `id_almoxarifado` INT(11) NOT NULL,
  `id_tipo` INT(11) NOT NULL,
  `id_responsavel` INT(11) NOT NULL,
  `data` DATE NULL DEFAULT NULL,
  `hora` TIME NULL DEFAULT NULL,
  `valor_total` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_saida`),
  INDEX `id_destino` (`id_destino` ASC),
  INDEX `id_almoxarifado` (`id_almoxarifado` ASC),
  INDEX `id_tipo` (`id_tipo` ASC),
  INDEX `id_responsavel` (`id_responsavel` ASC),
  CONSTRAINT `saida_ibfk_1`
    FOREIGN KEY (`id_destino`)
    REFERENCES `wegia`.`destino` (`id_destino`),
  CONSTRAINT `saida_ibfk_2`
    FOREIGN KEY (`id_almoxarifado`)
    REFERENCES `wegia`.`almoxarifado` (`id_almoxarifado`),
  CONSTRAINT `saida_ibfk_3`
    FOREIGN KEY (`id_tipo`)
    REFERENCES `wegia`.`tipo_saida` (`id_tipo`),
  CONSTRAINT `saida_ibfk_4`
    FOREIGN KEY (`id_responsavel`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`isaida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`isaida` (
  `id_isaida` INT(11) NOT NULL AUTO_INCREMENT,
  `id_saida` INT(11) NOT NULL,
  `id_produto` INT(11) NOT NULL,
  `qtd` INT(11) NULL DEFAULT NULL,
  `valor_unitario` DECIMAL(10,2) NULL DEFAULT NULL,
  `oculto` BOOLEAN NULL DEFAULT FALSE,
  PRIMARY KEY (`id_isaida`),
  INDEX `id_saida` (`id_saida` ASC),
  INDEX `id_produto` (`id_produto` ASC),
  CONSTRAINT `isaida_ibfk_1`
    FOREIGN KEY (`id_saida`)
    REFERENCES `wegia`.`saida` (`id_saida`),
  CONSTRAINT `isaida_ibfk_2`
    FOREIGN KEY (`id_produto`)
    REFERENCES `wegia`.`produto` (`id_produto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`situacao_funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`situacao_funcionario` (
  `id_situacao_funcionario` INT(11) NOT NULL AUTO_INCREMENT,
  `data_hora` DATETIME NULL DEFAULT NULL,
  `descricao` VARCHAR(50) NULL DEFAULT NULL,
  `imagem` LONGTEXT NULL DEFAULT NULL,
  `imagem_extensao` VARCHAR(40) NULL DEFAULT NULL,
  PRIMARY KEY (`id_situacao_funcionario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`movimentacao_funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`movimentacao_funcionario` (
  `id_funcionario` INT(11) NOT NULL,
  `id_situacao_funcionario` INT(11) NOT NULL,
  PRIMARY KEY (`id_funcionario`, `id_situacao_funcionario`),
  INDEX `id_situacao_funcionario` (`id_situacao_funcionario` ASC),
  CONSTRAINT `movimentacao_funcionario_ibfk_1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`),
  CONSTRAINT `movimentacao_funcionario_ibfk_2`
    FOREIGN KEY (`id_situacao_funcionario`)
    REFERENCES `wegia`.`situacao_funcionario` (`id_situacao_funcionario`))
ENGINE = InnoDB
;


-- -----------------------------------------------------
-- Table `wegia`.`situacao_interno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`situacao_interno` (
  `id_situacao_interno` INT(11) NOT NULL AUTO_INCREMENT,
  `data_hora` DATETIME NULL DEFAULT NULL,
  `descricao` VARCHAR(50) NULL DEFAULT NULL,
  `imagem` LONGTEXT NULL DEFAULT NULL,
  `imagem_extensao` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id_situacao_interno`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`movimentacao_interno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`movimentacao_interno` (
  `id_interno` INT(11) NOT NULL,
  `id_situacao_interno` INT(11) NOT NULL,
  PRIMARY KEY (`id_interno`, `id_situacao_interno`),
  INDEX `id_situacao_interno` (`id_situacao_interno` ASC),
  CONSTRAINT `movimentacao_interno_ibfk_1`
    FOREIGN KEY (`id_interno`)
    REFERENCES `wegia`.`interno` (`id_interno`),
  CONSTRAINT `movimentacao_interno_ibfk_2`
    FOREIGN KEY (`id_situacao_interno`)
    REFERENCES `wegia`.`situacao_interno` (`id_situacao_interno`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`recurso` (
  `id_recurso` INT NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_recurso`))
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `wegia`.`permissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`permissao` (
  `id_cargo` INT(11) NOT NULL,
  `id_acao` INT(11) NOT NULL,
  `id_recurso` INT NOT NULL,
  PRIMARY KEY (`id_cargo`, `id_recurso`),
  INDEX `id_acao` (`id_acao` ASC),
  INDEX `fk_permissao_recurso1_idx` (`id_recurso` ASC),
  CONSTRAINT `permissao_ibfk_1`
    FOREIGN KEY (`id_cargo`)
    REFERENCES `wegia`.`cargo` (`id_cargo`),
  CONSTRAINT `permissao_ibfk_2`
    FOREIGN KEY (`id_acao`)
    REFERENCES `wegia`.`acao` (`id_acao`),
  CONSTRAINT `fk_permissao_recurso1`
    FOREIGN KEY (`id_recurso`)
    REFERENCES `wegia`.`recurso` (`id_recurso`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`pessoa_epi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pessoa_epi` (
  `id_pessoa_epi` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL,
  `id_epi` INT(11) NOT NULL,
  `data` DATE NULL DEFAULT NULL,
  `epi_status` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_pessoa_epi`),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  INDEX `id_epi` (`id_epi` ASC),
  CONSTRAINT `pessoa_epi_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
  CONSTRAINT `pessoa_epi_ibfk_2`
    FOREIGN KEY (`id_epi`)
    REFERENCES `wegia`.`epi` (`id_epi`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`quadro_horario_funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`quadro_horario_funcionario` (
  `id_quadro_horario` INT(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` INT(11) NOT NULL,
  `escala` INT(11) NOT NULL,
  `tipo` INT(11) NOT NULL,
  `carga_horaria` VARCHAR(200) NULL DEFAULT NULL,
  `entrada1` VARCHAR(200) NULL DEFAULT NULL,
  `saida1` VARCHAR(200) NULL DEFAULT NULL,
  `entrada2` VARCHAR(200) NULL DEFAULT NULL,
  `saida2` VARCHAR(200) NULL DEFAULT NULL,
  `total` VARCHAR(200) NULL DEFAULT NULL,
  `dias_trabalhados` VARCHAR(200) NULL DEFAULT NULL,
  `folga` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`id_quadro_horario`),
  INDEX `id_funcionario` (`id_funcionario` ASC),
  CONSTRAINT `quadro_horario_funcionario_ibfk_1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`),
  CONSTRAINT `quadro_horario_funcionario_ibfk_2` 
    FOREIGN KEY (`escala`)
    REFERENCES `wegia`.`escala_quadro_horario` (`id_escala`),
  CONSTRAINT `quadro_horario_funcionario_ibfk_3` 
    FOREIGN KEY (`tipo`)
    REFERENCES `wegia`.`tipo_quadro_horario` (`id_tipo`))
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `wegia`.`escala_quadro_horario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `escala_quadro_horario`;
CREATE TABLE IF NOT EXISTS `escala_quadro_horario` (
  `id_escala` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`id_escala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- -----------------------------------------------------
-- Table `wegia`.`tipo_quadro_horario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipo_quadro_horario`;
CREATE TABLE IF NOT EXISTS `tipo_quadro_horario` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;


-- -----------------------------------------------------
-- Table `wegia`.`voluntario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`voluntario` (
  `id_voluntario` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL,
  `id_situacao` INT(11) NOT NULL,
  `id_cargo` INT(11) NOT NULL,
  `descricao_atividade` VARCHAR(100) NULL DEFAULT NULL,
  `data_admissao` DATE NOT NULL,
  PRIMARY KEY (`id_voluntario`),
  INDEX `id_pessoa` (`id_pessoa` ASC),
  INDEX `fk_voluntario_situacao1_idx` (`id_situacao` ASC),
  INDEX `fk_voluntario_cargo1_idx` (`id_cargo` ASC),
  CONSTRAINT `voluntario_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
  CONSTRAINT `fk_voluntario_situacao1`
    FOREIGN KEY (`id_situacao`)
    REFERENCES `wegia`.`situacao` (`id_situacao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_voluntario_cargo1`
    FOREIGN KEY (`id_cargo`)
    REFERENCES `wegia`.`cargo` (`id_cargo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `wegia`.`quadro_horario_voluntario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`quadro_horario_voluntario` (
  `id_quadro_horario` INT(11) NOT NULL AUTO_INCREMENT,
  `id_voluntario` INT(11) NOT NULL,
  `escala` VARCHAR(200) NULL DEFAULT NULL,
  `tipo` VARCHAR(200) NULL DEFAULT NULL,
  `carga_horaria` VARCHAR(200) NULL DEFAULT NULL,
  `entrada1` VARCHAR(200) NULL DEFAULT NULL,
  `saida1` VARCHAR(200) NULL DEFAULT NULL,
  `entrada2` VARCHAR(200) NULL DEFAULT NULL,
  `saida2` VARCHAR(200) NULL DEFAULT NULL,
  `total` VARCHAR(200) NULL DEFAULT NULL,
  `dias_trabalhados` VARCHAR(200) NULL DEFAULT NULL,
  `folga` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`id_quadro_horario`),
  INDEX `id_voluntario` (`id_voluntario` ASC),
  CONSTRAINT `quadro_horario_voluntario_ibfk_1`
    FOREIGN KEY (`id_voluntario`)
    REFERENCES `wegia`.`voluntario` (`id_voluntario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`selecao_paragrafo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`selecao_paragrafo` (
  `id_selecao` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_campo` VARCHAR(40) NOT NULL,
  `paragrafo` TEXT NOT NULL,
  `original` TINYINT(4) NULL DEFAULT '1',
  PRIMARY KEY (`id_selecao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`situacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`situacao` (
  `id_situacao` INT(11) NOT NULL AUTO_INCREMENT,
  `situacoes` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id_situacao`),
  UNIQUE INDEX `situacoes` (`situacoes` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`tabela_imagem_campo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`tabela_imagem_campo` (
  `id_relacao` INT(11) NOT NULL AUTO_INCREMENT,
  `id_campo` INT(11) NOT NULL,
  `id_imagem` INT(11) NOT NULL,
  PRIMARY KEY (`id_relacao`),
  INDEX `id_campo` (`id_campo` ASC),
  INDEX `id_imagem` (`id_imagem` ASC),
  CONSTRAINT `tabela_imagem_campo_ibfk_1`
    FOREIGN KEY (`id_campo`)
    REFERENCES `wegia`.`campo_imagem` (`id_campo`),
  CONSTRAINT `tabela_imagem_campo_ibfk_2`
    FOREIGN KEY (`id_imagem`)
    REFERENCES `wegia`.`imagem` (`id_imagem`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`sistema_pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`sistema_pagamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_sistema` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`doacao_boleto_regras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`doacao_boleto_regras` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `min_boleto_uni` DECIMAL(10,2) NOT NULL,
  `max_dias_venc` INT(11) NOT NULL,
  `juros` DECIMAL(10,2) NOT NULL,
  `multa` DECIMAL(10,2) NOT NULL,
  `max_parcela` DECIMAL(10,2) NOT NULL,
  `min_parcela` DECIMAL(10,2) NOT NULL,
  `agradecimento` LONGTEXT NOT NULL,
  `dias_boleto_a_vista` INT(11) NOT NULL,
  `dias_venc_carne_op1` INT(11) NOT NULL,
  `dias_venc_carne_op2` INT(11) NOT NULL,
  `dias_venc_carne_op3` INT(11) NOT NULL,
  `dias_venc_carne_op4` INT(11) NOT NULL,
  `dias_venc_carne_op5` INT(11) NOT NULL,
  `dias_venc_carne_op6` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`doacao_boleto_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`doacao_boleto_info` (
  `id` INT(11) NOT NULL,
  `api` VARCHAR(256) NOT NULL,
  `token_api` VARCHAR(256) NOT NULL,
  `sandbox` VARCHAR(256) NOT NULL,
  `token_sandbox` VARCHAR(256) NOT NULL,
  `id_sistema` INT(11) NOT NULL,
  `id_regras` INT(11) NOT NULL,
  INDEX `id_sistema` (`id_sistema` ASC),
  INDEX `id_regras` (`id_regras` ASC),
  CONSTRAINT `doacao_boleto_info_ibfk_1`
    FOREIGN KEY (`id_sistema`)
    REFERENCES `wegia`.`sistema_pagamento` (`id`),
  CONSTRAINT `doacao_boleto_info_ibfk_2`
    FOREIGN KEY (`id_regras`)
    REFERENCES `wegia`.`doacao_boleto_regras` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`doacao_cartao_avulso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`doacao_cartao_avulso` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(256) NOT NULL,
  `id_sistema` INT(11) NOT NULL,
  INDEX `id_sistema` (`id_sistema` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `doacao_cartao_avulso_ibfk_1`
    FOREIGN KEY (`id_sistema`)
    REFERENCES `wegia`.`sistema_pagamento` (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`doacao_cartao_mensal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`doacao_cartao_mensal` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `link` VARCHAR(256) NOT NULL,
  `valor` DECIMAL(10,2) NULL DEFAULT NULL,
  `id_sistema` INT(11) NOT NULL,
  INDEX `id_sistema` (`id_sistema` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `doacao_cartao_mensal_ibfk_1`
    FOREIGN KEY (`id_sistema`)
    REFERENCES `wegia`.`sistema_pagamento` (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`socio_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio_status` (
  `id_sociostatus` INT NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_sociostatus`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`socio_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio_tipo` (
  `id_sociotipo` INT NOT NULL,
  `tipo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_sociotipo`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `wegia`.`socio_tag` (
  `id_sociotag` INT NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(255) NOT NULL UNIQUE,
  PRIMARY KEY (`id_sociotag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`socio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio` (
  `id_socio` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT(11) NOT NULL UNIQUE,
  `id_sociostatus` INT NOT NULL,
  `id_sociotipo` INT NOT NULL,
  `id_sociotag` INT NULL,
  `email` VARCHAR(256) NULL,
  `valor_periodo` DECIMAL(10,2) NULL,
  `data_referencia` DATE NULL,
  PRIMARY KEY (`id_socio`),
  INDEX `fk_socio_socio_status1_idx` (`id_sociostatus` ASC),
  INDEX `fk_socio_pessoa1_idx` (`id_pessoa` ASC),
  INDEX `fk_socio_socio_tipo1_idx` (`id_sociotipo` ASC),
  INDEX `fk_socio_socio_tag1_idx` (`id_sociotag` ASC),
  CONSTRAINT `fk_socio_socio_status1`
    FOREIGN KEY (`id_sociostatus`)
    REFERENCES `wegia`.`socio_status` (`id_sociostatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_socio_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_socio_socio_tipo1`
    FOREIGN KEY (`id_sociotipo`)
    REFERENCES `wegia`.`socio_tipo` (`id_sociotipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_socio_socio_tag1`
    FOREIGN KEY (`id_sociotag`)
    REFERENCES `wegia`.`socio_tag` (`id_sociotag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`log_contribuicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`log_contribuicao` (
  `id_log` INT AUTO_INCREMENT PRIMARY KEY,
  `id_socio` INT(11) NOT NULL,
  `ip` VARCHAR(256) NOT NULL,
  `data` DATE NOT NULL,
  `hora` TIME NOT NULL,
  `id_sistema` INT(11) NOT NULL,
  `valor_boleto` DECIMAL(10,2) NOT NULL,
  `data_venc_boleto` DATE NOT NULL,
  `id_sociotipo` INT NOT NULL,
  `referencia` VARCHAR(255) UNIQUE KEY,
  `status` VARCHAR(255) NOT NULL,
  INDEX `id_sistema` (`id_sistema` ASC),
  INDEX `FK_socio_log` (`id_socio` ASC),
  CONSTRAINT `FK_socio_log`
    FOREIGN KEY (`id_socio`)
    REFERENCES `wegia`.`socio` (`id_socio`),
  CONSTRAINT `FK_sociotipo_log`
    FOREIGN KEY (`id_sociotipo`)
    REFERENCES `wegia`.`socio_tipo` (`id_sociotipo`),
  CONSTRAINT `log_ibfk_1`
    FOREIGN KEY (`id_sistema`)
    REFERENCES `wegia`.`sistema_pagamento` (`id`))
ENGINE = InnoDB;

					    
-- -----------------------------------------------------
-- Table `wegia`.`endereco_instituicao`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `wegia`.`endereco_instituicao`(
    id_inst INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(256) NOT NULL,
    numero_endereco VARCHAR(256) NOT NULL,
    logradouro VARCHAR(256) NOT NULL,
    bairro VARCHAR(256),
    cidade VARCHAR(256) NOT NULL,
    estado VARCHAR(256) NOT NULL,
    cep VARCHAR(256) NOT NULL,
    complemento VARCHAR(256),
    ibge VARCHAR(256) NOT NULL,
    PRIMARY KEY (id_inst)
) ENGINE= InnoDB;

CREATE TABLE IF NOT EXISTS `wegia`.`cobrancas` 
(   `id` INT NOT NULL AUTO_INCREMENT ,  
    `codigo` INT NULL ,  
    `descricao` VARCHAR(255) NULL ,  
    `data_emissao` DATE NULL ,  
    `data_vencimento` DATE NULL ,  
    `data_pagamento` DATE NULL ,  
    `valor` DECIMAL(10,2) NULL ,  
    `valor_pago` DECIMAL(10,2) NULL ,  
    `status` VARCHAR(255) NULL ,  
    `link_cobranca` VARCHAR(255) NULL ,  
    `link_boleto` VARCHAR(255) NULL ,  
    `linha_digitavel` VARCHAR(255) NULL ,  
    `id_socio` INT NULL ,    
    PRIMARY KEY  (`id`),    
    UNIQUE  (`codigo`)
  ) ENGINE = InnoDB;

ALTER TABLE `cobrancas` 
ADD CONSTRAINT `fk_cobranca_socio` 
FOREIGN KEY (`id_socio`) REFERENCES `socio`(`id_socio`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;

USE `wegia` ;

-- -----------------------------------------------------
-- procedure cadbeneficiados
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadbeneficiados`(IN `id_pessoa` INT, IN `id_beneficios` INT, IN `data_inicio` DATETIME, IN `data_fim` DATETIME, IN `beneficios_status` VARCHAR(100), IN `valor` DECIMAL(10,2))
begin

insert into beneficiados(id_pessoa,id_beneficios,data_inicio,data_fim,beneficios_status,valor)
values(id_pessoa,id_beneficios,data_inicio,data_fim,beneficios_status,valor);



END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadentrada
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadentrada`(IN `id_origem` INT, IN `id_almoxarifado` INT, IN `id_tipo` INT, IN `id_responsavel` INT, IN `data` DATE, IN `hora` TIME, IN `valor_total` DECIMAL(10,2), IN `id_entrada` INT, IN `id_produto` INT, IN `qtd` INT, IN `valor_unitario` DECIMAL(10,2))
begin

declare idE int;

insert into entrada (id_origem, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total)
  values(id_origem, id_almoxarifado, id_tipo, id_responsavel, data, hora, valor_total);

SELECT 
  MAX(id_entrada)
INTO idE FROM entrada;

insert into ientrada(id_entrada, id_produto, qtd, valor_unitario)
  values(idE, id_produto, qtd, valor_unitario);
end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadepi
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadepi`(IN `id_pessoa` INT, IN `id_epi` INT, IN `data` DATE, IN `epi_status` VARCHAR(100))
begin

insert into pessoa_epi(id_pessoa,id_epi,data,epi_status)
values(id_pessoa,id_epi,data,epi_status);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadfuncionario
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadfuncionario`(IN `nome` VARCHAR(100), IN `sobrenome` VARCHAR(100), IN `cpf` VARCHAR(40), 
  IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(100), 
  IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(100), 
  IN `estado` VARCHAR(50), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), 
  IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(100), IN `complemento` VARCHAR(50), 
  IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), 
  IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), 
  IN `tipo_sanguineo` VARCHAR(50), IN `data_admissao` DATE, IN `pis` VARCHAR(140), 
  IN `ctps` VARCHAR(150), IN `uf_ctps` VARCHAR(200), IN `numero_titulo` VARCHAR(150), 
  IN `zona` VARCHAR(300), IN `secao` VARCHAR(400), IN `certificado_reservista_numero` VARCHAR(100), 
  IN `certificado_reservista_serie` VARCHAR(100), IN `id_situacao` INT,IN `id_cargo` INT)
begin

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

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadhorariofunc
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadhorariofunc`(IN `escala` VARCHAR(200), IN `tipo` VARCHAR(200), IN `carga_horaria` VARCHAR(200), IN `entrada1` VARCHAR(200), IN `saida1` VARCHAR(200), IN `entrada2` VARCHAR(200), IN `saida2` VARCHAR(200), IN `total` VARCHAR(200), IN `dias_trabalhados` VARCHAR(200), IN `folga` VARCHAR(200))
    NO SQL
begin
declare idF int;

SELECT MAX(id_funcionario) into idF FROM funcionario;

insert into quadro_horario_funcionario(id_funcionario,escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga) 
VALUES (idF, escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadhorariovolunt
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadhorariovolunt`(IN `escala` VARCHAR(200), IN `tipo` VARCHAR(200), IN `carga_horaria` VARCHAR(200), IN `entrada1` VARCHAR(200), IN `saida1` VARCHAR(200), IN `entrada2` VARCHAR(200), IN `saida2` VARCHAR(200), IN `total` VARCHAR(200), IN `dias_trabalhados` VARCHAR(200), IN `folga` VARCHAR(200))
    NO SQL
begin
declare idV int;

SELECT MAX(id_voluntario) into idV FROM voluntario;

insert into quadro_horario_voluntario(id_voluntario,escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga) 
VALUES (idF, escala, tipo, carga_horaria, entrada1, saida1, entrada2, saida2, total, dias_trabalhados, folga);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadimagem
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadimagem`(IN `id_pessoa` INT, IN `imagem` LONGBLOB, IN `imagem_extensao` VARCHAR(10), IN `descricao` VARCHAR(40))
begin
declare idD int;
insert into documento(id_pessoa,imgdoc,imagem_extensao,descricao) VALUES (id_pessoa,imagem,imagem_extensao,descricao);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadinterno
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadinterno`(IN `nome` VARCHAR(100), IN `sobrenome` VARCHAR(100), IN `cpf` VARCHAR(40), IN `senha` VARCHAR(70), IN `sexo` CHAR(1), IN `telefone` VARCHAR(25), IN `data_nascimento` DATE, IN `imagem` LONGTEXT, IN `cep` VARCHAR(20), IN `estado` VARCHAR(5), IN `cidade` VARCHAR(40), IN `bairro` VARCHAR(40), IN `logradouro` VARCHAR(40), IN `numero_endereco` VARCHAR(11), IN `complemento` VARCHAR(50), IN `ibge` VARCHAR(20), IN `registro_geral` VARCHAR(20), IN `orgao_emissor` VARCHAR(20), IN `data_expedicao` DATE, IN `nome_pai` VARCHAR(100), IN `nome_mae` VARCHAR(100), IN `tipo_sanguineo` VARCHAR(5), IN `nome_contato_urgente` VARCHAR(60), IN `telefone_contato_urgente_1` VARCHAR(33), IN `telefone_contato_urgente_2` VARCHAR(33), IN `telefone_contato_urgente_3` VARCHAR(33), IN `observacao` VARCHAR(240), IN `certidao_nascimento` VARCHAR(60), IN `curatela` VARCHAR(60), IN `inss` VARCHAR(60), IN `loas` VARCHAR(60), IN `bpc` VARCHAR(60), IN `funrural` VARCHAR(60), IN `saf` VARCHAR(60), IN `sus` VARCHAR(60), IN `certidao_casamento` VARCHAR(123), IN `ctps` VARCHAR(123), IN `titulo` VARCHAR(123))
begin

declare idP int;

insert into pessoa(nome,sobrenome,cpf,senha,sexo,telefone,data_nascimento,imagem,cep,estado,cidade, bairro, logradouro, numero_endereco,
complemento,ibge,registro_geral,orgao_emissor,data_expedicao, nome_pai, nome_mae, tipo_sanguineo)
values(nome, sobrenome, cpf, senha, sexo, telefone,data_nascimento,imagem,cep,estado,cidade,bairro,logradouro,numero_endereco,complemento,ibge,registro_geral,orgao_emissor,data_expedicao,nome_pai,nome_mae,tipo_sanguineo);
select max(id_pessoa) into idP FROM pessoa;

insert into interno(id_pessoa,nome_contato_urgente,telefone_contato_urgente_1,telefone_contato_urgente_2,telefone_contato_urgente_3,observacao,certidao_nascimento,curatela,inss,loas,bpc,funrural,saf,sus,certidao_casamento,ctps,titulo) 
values(idP,nome_contato_urgente,telefone_contato_urgente_1,telefone_contato_urgente_2,telefone_contato_urgente_3,observacao,certidao_nascimento,curatela,inss,loas,bpc,funrural,saf,sus,certidao_casamento,ctps,titulo);
SELECT MAX(id_pessoa) from pessoa;
end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadsaida
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadsaida`(IN `id_destino` INT, IN `id_almoxarifado` INT, IN `id_tipo` INT, IN `id_responsavel` INT, IN `data` DATE, IN `hora` TIME, IN `valor_total` DECIMAL(10,2), IN `id_saida` INT, IN `id_produto` INT, IN `qtd` INT, IN `valor_unitario` DECIMAL(10,2))
begin

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

-- -----------------------------------------------------
-- procedure excluirfuncionario
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `excluirfuncionario`(IN `idf` INT)
BEGIN
DECLARE idp int;

delete from quadro_horario_funcionario where id_funcionario=idf;

select id_pessoa into idp from funcionario where id_funcionario=idf;

delete from beneficiados where id_pessoa=idp;

delete from pessoa_epi where id_pessoa=idp;

delete f,p from funcionario as f inner join pessoa as p on p.id_pessoa=f.id_pessoa where f.id_funcionario=idf;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure excluirinterno
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `excluirinterno`(IN `idi` INT)
BEGIN
DECLARE idp int;

select id_pessoa into idp from interno where id_interno=idi;

delete from documento where id_pessoa=idp;

delete i,p from interno as i inner join pessoa as p on p.id_pessoa=i.id_pessoa where i.id_interno=idi;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insanexo
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `insanexo`(IN `id_despacho` INT, IN `anexo` LONGBLOB, IN `extensao` VARCHAR(11), IN `nome` VARCHAR(255))
BEGIN
		declare idA int;
        INSERT INTO anexo(id_despacho, anexo, extensao, nome)
        values (id_despacho, anexo, extensao, nome);
        
        SELECT max(id_anexo) into idA from anexo;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insdespacho
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `insdespacho`(IN `id_memorando` INT, IN `id_remetente` INT, IN `id_destinatario` INT, IN `texto` LONGTEXT, IN `data` TIMESTAMP)
BEGIN 
		declare idD int;
        INSERT INTO despacho(id_memorando, id_remetente, id_destinatario, texto, data)
        values (id_memorando, id_remetente, id_destinatario, texto, data);
	
        SELECT max(id_despacho) into idD from despacho;
        
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insmemorando
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `insmemorando`(IN `id_pessoa` INT, IN `id_status_memorando` INT, IN `titulo` TEXT, IN `data` VARCHAR(255))
BEGIN 
		declare idM int;
        INSERT INTO memorando(id_pessoa, id_status_memorando, titulo, data)
        values (id_pessoa, id_status_memorando, titulo, data);
        
        SELECT max(id_memorando) into idM from memorando;
        
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure cadsocio
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `cadsocio`(IN `cpf_cnpj` VARCHAR(256), IN `data_nascimento` VARCHAR(256), IN `nome` VARCHAR(256), IN `email` VARCHAR(256), IN `telefone` VARCHAR(256), IN `tipo` VARCHAR(256), IN `logradouro` VARCHAR(256), IN `numero` INT(11), IN `complemento` VARCHAR(256), IN `cep` VARCHAR(256), IN `bairro` VARCHAR(256), IN `cidade` VARCHAR(256), IN `estado` VARCHAR(256))
begin

declare idSJ int;

INSERT INTO socio(cpf_cnpj, nome, email, telefone, tipo, data_nascimento)
	values (cpf_cnpj, nome, email, telefone, tipo, data_nascimento);
    
select max(id) into idSJ from socio;

INSERT INTO endereco(idsocio, logradouro, numero, complemento, cep, bairro, cidade, estado)
	values (idSJ, logradouro, numero, complemento, cep, bairro, cidade, estado);
    
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure registradoacao
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `registradoacao`(
	IN `nome` VARCHAR(100), 
    IN `sobrenome` VARCHAR(100), 
    IN `cpf` VARCHAR(40), 
    IN `telefone` VARCHAR(25), 
    IN `data_nascimento` DATE, 
    IN `cep` VARCHAR(20), 
    IN `estado` VARCHAR(5), 
    IN `cidade` VARCHAR(40), 
    IN `bairro` VARCHAR(40), 
    IN `logradouro` VARCHAR(40), 
    IN `numero_endereco` VARCHAR(11), 
    IN `complemento` VARCHAR(50),
    IN `id_sociostatus` INT(11),
    IN `id_sociotipo` INT(11),
    IN `email` VARCHAR(256),
    IN `ip` VARCHAR(256),
    IN `data` DATE,
    IN `hora` TIME,
    IN `id_sistema` INT(11),
    IN `valor_boleto` DECIMAL(10,2),
    IN `data_venc_boleto` DATE
)
begin

insert ignore into pessoa(nome,sobrenome,cpf,telefone,data_nascimento,cep,estado,cidade, bairro, logradouro, numero_endereco,
complemento)
values(nome, sobrenome, cpf, telefone,data_nascimento,cep,estado,cidade,bairro,logradouro,numero_endereco,complemento);

insert ignore into socio(id_pessoa, id_sociostatus, id_sociotipo, email)
values ((SELECT id_pessoa FROM pessoa WHERE pessoa.cpf=cpf limit 1), id_sociostatus, id_sociotipo, email);

insert into log_contribuicao(id_socio, ip, data, hora, id_sistema, valor_boleto, data_venc_boleto)
values((SELECT id_socio FROM socio, pessoa WHERE pessoa.id_pessoa=socio.id_pessoa AND pessoa.cpf=cpf limit 1), ip, data, hora, id_sistema, valor_boleto, data_venc_boleto);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insregras
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `insregras`(
	IN `min_boleto_uni` decimal(10,2), 
    IN `max_dias_venc` int(11), 
    IN `juros` decimal(10,2), 
    IN `multa` decimal(10,2), 
    IN `max_parcela` decimal(10,2), 
    IN `min_parcela` decimal(10,2), 
    IN `agradecimento` longtext, 
    IN `dias_boleto_a_vista` int(11), 
    IN `dias_venc_carne_op1` int(11), 
    IN `dias_venc_carne_op2` int(11), 
    IN `dias_venc_carne_op3` int(11), 
    IN `dias_venc_carne_op4` int(11),
    IN `dias_venc_carne_op5` int(11),
    IN `dias_venc_carne_op6` int(11)
)
begin

insert doacao_boleto_regras (min_boleto_uni, max_dias_venc, juros, multa, max_parcela, min_parcela, agradecimento, dias_boleto_a_vista, dias_venc_carne_op1, dias_venc_carne_op2, dias_venc_carne_op3, dias_venc_carne_op4, dias_venc_carne_op5, dias_venc_carne_op6)
values (min_boleto_uni, max_dias_venc, juros, multa, max_parcela, min_parcela, agradecimento, dias_boleto_a_vista, dias_venc_carne_op1, dias_venc_carne_op2, dias_venc_carne_op3, dias_venc_carne_op4, dias_venc_carne_op5, dias_venc_carne_op6);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure registra_cartao_avulso
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `registra_cartao_avulso`(
	IN `url` varchar(256),
    IN `id_sistema` int(11)
)
begin

insert doacao_cartao_avulso (url, id_sistema)
values (url, id_sistema);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure registra_cartao_mensal
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `registra_cartao_mensal`(
	IN `valor` varchar(256),
    IN `link` decimal(10,2),
    IN `id_sistema` int(11)
)
begin

insert doacao_cartao_mensal (valor, link, id_sistema)
values (valor, link, id_sistema);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure corrige_estoque
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `corrige_estoque`()
BEGIN
	DECLARE QtdAtual INT(11);
    SELECT ie.qtd- isa.qtd INTO QtdAtual FROM ientrada AS ie INNER JOIN produto AS p USING(id_produto) INNER JOIN estoque AS es USING(id_produto) INNER JOIN isaida AS isa USING(id_produto);
	UPDATE estoque SET qtd= QtdAtual where QtdAtual <> qtd;
END$$

DELIMITER ;
														    

-- -----------------------------------------------------
-- procedure insendereco_inst
-- -----------------------------------------------------

DELIMITER $$
USE `wegia`$$
CREATE PROCEDURE `insendereco_inst`(
    IN `nome` VARCHAR(256), 
    IN `numero_endereco` VARCHAR(256), 
    IN `logradouro` VARCHAR(256), 
    IN `bairro` VARCHAR(256), 
    IN `cidade` VARCHAR(256), 
    IN `estado` VARCHAR(256), 
    IN `cep` VARCHAR(256), 
    IN `complemento` VARCHAR(256), 
    IN `ibge` VARCHAR(256))    
begin

	insert into endereco_instituicao (nome, numero_endereco, logradouro, bairro, cidade, estado, cep, complemento, ibge)
    values (nome, numero_endereco, logradouro, bairro, cidade, estado, cep, complemento, ibge);
   
END$$
														    

USE `wegia`;

DELIMITER $$
USE `wegia`$$
CREATE
TRIGGER `wegia`.`tgr_ientrada_delete`
AFTER DELETE ON `wegia`.`ientrada`
FOR EACH ROW
BEGIN
  
    UPDATE estoque SET qtd = qtd - OLD.qtd WHERE id_produto = OLD.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM entrada WHERE id_entrada = OLD.id_entrada);
  
END$$

USE `wegia`$$
CREATE
TRIGGER `wegia`.`tgr_ientrada_insert`
AFTER INSERT ON `wegia`.`ientrada`
FOR EACH ROW
BEGIN

  INSERT IGNORE INTO estoque(id_produto, id_almoxarifado, qtd) values(NEW.id_produto, (SELECT id_almoxarifado FROM entrada WHERE id_entrada = NEW.id_entrada), 0);
  
    UPDATE estoque SET qtd = qtd+NEW.qtd WHERE id_produto = NEW.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM entrada WHERE id_entrada = NEW.id_entrada);
  
END$$

USE `wegia`$$
CREATE
TRIGGER `wegia`.`tgr_isaida_delete`
AFTER DELETE ON `wegia`.`isaida`
FOR EACH ROW
BEGIN
  
    UPDATE estoque SET qtd = qtd+OLD.qtd WHERE id_produto = OLD.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM saida WHERE id_saida = OLD.id_saida);
  
END$$

USE `wegia`$$
CREATE
TRIGGER `wegia`.`tgr_isaida_insert`
AFTER INSERT ON `wegia`.`isaida`
FOR EACH ROW
BEGIN
  
    UPDATE estoque SET qtd = qtd-NEW.qtd WHERE id_produto = NEW.id_produto AND id_almoxarifado = (SELECT id_almoxarifado FROM saida WHERE id_saida = NEW.id_saida);
  
END$$

USE `wegia`$$
DROP TRIGGER IF EXISTS `wegia`.`tgr_ientrada_atualiza_preco` $$

USE `wegia`$$
CREATE
TRIGGER `wegia`.`tgr_ientrada_atualiza_preco`
AFTER INSERT ON `wegia`.`ientrada`
FOR EACH ROW
BEGIN
	DECLARE preco_total FLOAT;
  DECLARE tmp_preco_total FLOAT;
  DECLARE id_media INT(11);
  DECLARE qtd_total FLOAT;
  DECLARE done INT;
  DECLARE cur CURSOR FOR SELECT id_ientrada FROM ientrada WHERE id_produto = NEW.id_produto;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
  
  SET @qtd_total := (SELECT sum(qtd) FROM ientrada WHERE id_produto = NEW.id_produto);
  SET @preco_total := 0.00;
  
  OPEN cur;
      ins_loop: LOOP
          FETCH cur INTO id_media;
          IF done = 1 THEN
              LEAVE ins_loop;
          END IF;
          SET @tmp_preco_total := (SELECT qtd * valor_unitario FROM ientrada WHERE id_ientrada = id_media);
          IF @tmp_preco_total = NULL THEN
      SET @tmp_preco_total := 0;
          END IF;
          SET @preco_total := (@tmp_preco_total + @preco_total);
      END LOOP;
  CLOSE cur;
	
    UPDATE produto SET preco = (@preco_total / @qtd_total) WHERE id_produto = NEW.id_produto;
END$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



