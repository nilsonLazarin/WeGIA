use wegia;

-- -------------------------------------------------------
-- Table `wegia`.`pet_foto`
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_foto` (
    `id_pet_foto` INT NOT NULL AUTO_INCREMENT,
    `arquivo_foto_pet` LONGBLOB NULL,
    `arquivo_foto_pet_nome` varchar(200) NULL,
    `arquivo_foto_pet_extensao` varchar(50) NULL, 
    PRIMARY KEY (`id_pet_foto`)
)ENGINE = InnoDB;

-- -------------------------------------------------------
-- Table `wegia`.`pet_especie`
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_especie` (
    `id_pet_especie` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`id_pet_especie`)) 
ENGINE = InnoDB;

-- --------------------------------------------------------
-- Table `wegia`.`pet_raca`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_raca` (
    `id_pet_raca` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_pet_raca`))
ENGINE = InnoDB;

-- ---------------------------------------------------------
-- Table `wegia`.`pet_cor`
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_cor` (
    `id_pet_cor` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_pet_cor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`pet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet` (
    `id_pet` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(200) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `data_acolhimento` DATE NOT NULL,
    `sexo` CHAR(1) NOT NULL,
    `caracteristicas_especificas` VARCHAR(250) NULL,
    `id_pet_foto` INT NULL,
    `id_pet_especie` INT NOT NULL,
    `id_pet_raca` INT NOT NULL,
    `id_pet_cor` INT NOT NULL, 
    PRIMARY KEY (`id_pet`),
    CONSTRAINT `fk_pet_especie`
     FOREIGN KEY (`id_pet_especie`) 
     REFERENCES `wegia`.`pet_especie` (`id_pet_especie`),
    CONSTRAINT `fk_pet_raca`
     FOREIGN KEY (`id_pet_raca`)
     REFERENCES `wegia`.`pet_raca` (`id_pet_raca`),
    CONSTRAINT `fk_pet_cor` 
     FOREIGN KEY (`id_pet_cor`)
     REFERENCES `wegia`.`pet_cor` (`id_pet_cor`),
    CONSTRAINT `fk_pet_foto`
     FOREIGN KEY (`id_pet_foto`)
     REFERENCES `wegia`.`pet_foto`(`id_pet_foto`)
)
ENGINE = InnoDB;

-- ----------------------------------------------------------
-- Table `wegia`.`adocao`
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`adocao` (
    `id_adocao` INT NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT(11) NOT NULL,
    `id_pet` INT(11) NOT NULL,
    `data_adocao` DATE NOT NULL,
    PRIMARY KEY (`id_adocao`),
    CONSTRAINT `fk_pessoa`
     FOREIGN KEY (`id_pessoa`)
     REFERENCES `wegia`.`pessoa` (`id_pessoa`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet`
     FOREIGN KEY (`id_pet`)
     REFERENCES `wegia`.`pet` (`id_pet`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table `wegia`.`pet_ficha_medica`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_ficha_medica` (
    `id_ficha_medica` INT NOT NULL AUTO_INCREMENT,
    `id_pet` INT(11) NOT NULL,
    `castrado` CHAR(1) NOT NULL,
    `necessidades_especiais` VARCHAR(255) NULL,
    PRIMARY KEY (`id_ficha_medica`),
    CONSTRAINT `fk_id_pet`
     FOREIGN KEY (`id_pet`)
     REFERENCES `wegia`.`pet`(`id_pet`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- ----------------------------------------------------------------
-- Table `wegia`.`pet_tipo_exame`
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_tipo_exame`(
    `id_tipo_exame` INT NOT NULL AUTO_INCREMENT,
    `descricao_exame` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_tipo_exame`)
)ENGINE = InnoDB;

-- ---------------------------------------------------------------
-- Table  `wegia`.`pet_exame`
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_exame` (
    `id_exame` INT NOT NULL AUTO_INCREMENT,
    `id_ficha_medica` INT NOT NULL,
    `id_tipo_exame` INT NOT NULL,
    `data_exame` DATE NOT NULL,
    `arquivo_exame` LONGBLOB NOT NULL,
    `arquivo_nome` VARCHAR(200) NOT NULL,
    `arquivo_extensao` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_exame`),
    CONSTRAINT `fk_pet_ficha_medica`
     FOREIGN KEY (`id_ficha_medica`)
     REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet_tipo_exame`
     FOREIGN KEY (`id_tipo_exame`)
     REFERENCES `wegia`.`pet_tipo_exame` (`id_tipo_exame`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION
)ENGINE = InnoDB;


-- ------------------------------------------------------------------
-- Table `wegia`.`pet_vacina`
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_vacina`(
    `id_vacina` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(200) NOT NULL,
    `validade` DATE NOT NULL,
    PRIMARY KEY (`id_vacina`)
)ENGINE = InnoDB;

-- -----------------------------------------------------------------
-- Table `wegia`.`pet_vacinacao`
-- -----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_vacinacao`(
    `id_vacinacao` INT NOT NULL AUTO_INCREMENT,
    `id_vacina` INT NOT NULL,
    `id_ficha_medica` INT NOT NULL,
    `data_vacinacao` DATE NOT NULL,
    PRIMARY KEY (`id_vacinacao`),
    CONSTRAINT `fk_vacina_pet`
     FOREIGN KEY (`id_vacina`)
     REFERENCES `wegia`.`pet_vacina` (`id_vacina`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION,
    CONSTRAINT `fk_ficha_medica_pet`
     FOREIGN KEY (`id_ficha_medica`)
     REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION
)ENGINE = InnoDB;


-- -------------------------------------------------------------------
-- Table `wegia`.`pet_atendimento`
-- -------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_atendimento`(
    `id_pet_atendimento` INT NOT NULL AUTO_INCREMENT,
    `id_ficha_medica` INT NOT NULL,
    `data_atendimento` DATE NOT NULL,
    `descricao` BLOB NOT NULL,
    PRIMARY KEY (`id_pet_atendimento`),
    CONSTRAINT `fk_ficha_pet_medica`
     FOREIGN KEY (`id_ficha_medica`)
     REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- ----------------------------------------------------------------------
-- Table `wegia`.`pet_medicamento`
-- ----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_medicamento`(
    `id_medicamento` INT NOT NULL AUTO_INCREMENT,
    `nome_medicamento` VARCHAR(200) NOT NULL,
    `descricao_medicamento` VARCHAR(200) NOT NULL,
    `aplicacao` VARCHAR(250) NOT NULL,
    PRIMARY KEY (`id_medicamento`))
ENGINE = InnoDB;


-- --------------------------------------------------------------------
-- Table `wegia`.`pet_medicacao`
-- --------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_medicacao` (
    `id_medicacao` INT NOT NULL AUTO_INCREMENT, 
    `id_medicamento` INT NOT NULL,
    `id_pet_atendimento` INT NOT NULL,
    `data_medicacao` DATE NOT NULL,
    `dosagem` VARCHAR(100) NULL,
    `horario` VARCHAR(100) NULL,
    `duracao` VARCHAR(100) NULL,
    PRIMARY KEY (`id_medicacao`),
    CONSTRAINT `fk_pet_medicamento` 
     FOREIGN KEY (`id_medicamento`) 
     REFERENCES `wegia`.`pet_medicamento` (`id_medicamento`) 
     ON DELETE NO ACTION
     ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet_atendimento`
     FOREIGN KEY (`id_pet_atendimento`) 
     REFERENCES  `wegia`.`pet_atendimento` (`id_pet_atendimento`) 
     ON DELETE NO ACTION
     ON UPDATE NO ACTION
)ENGINE = InnoDB;


-- -------------------------------------------------------------------------
-- Table `wegia`.`pet_tipo_enfermidade`
-- -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_tipo_enfermidade`(
    `id_tipo_enfermidade` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id_tipo_enfermidade`))
ENGINE = InnoDB;

-- -----------------------------------------------------------------------
-- Table `wegia`.`pet_enfermidade`
-- -----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_enfermidade`(
    `id_enfermidade` INT NOT NULL AUTO_INCREMENT,
    `id_ficha_medica` INT NOT NULL,
    `id_tipo_enfermidade` INT NOT NULL,
    `data_diagnostico` DATE NOT NULL,
    `ativo` CHAR(1) NOT NULL,
    PRIMARY KEY (`id_enfermidade`),
    CONSTRAINT `fk_ficha_medica_pet_`
     FOREIGN KEY (`id_ficha_medica`)
     REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet_tipo_enfermidade_` 
     FOREIGN KEY (`id_tipo_enfermidade`)
     REFERENCES `wegia`.`pet_tipo_enfermidade` (`id_tipo_enfermidade`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -------------------------------------------------------------------------
-- Table `wegia`.`pet_medida`
-- -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_medida`(
    `id_pet_medida` INT NOT NULL AUTO_INCREMENT,
    `id_ficha_medica` INT NOT NULL,
    `peso` FLOAT NOT NULL,
    `data_medicao` DATE NOT NULL,
    PRIMARY KEY(`id_pet_medida`),
    CONSTRAINT `fk_ficha_pet_medica_`
     FOREIGN KEY (`id_ficha_medica`)
     REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
     ON DELETE NO ACTION
     ON UPDATE NO ACTION)
ENGINE = InnoDB;