-- Posteriormente adicionar as tabelas desse arquivo ao banco de dados central do sistema
CREATE TABLE IF NOT EXISTS `wegia`.`contribuicao_log` (
  `id` INT NULL DEFAULT NULL AUTO_INCREMENT,
  `id_socio` INT(11) NOT NULL,
  `id_gateway` INT(11) NOT NULL,
  `id_meio_pagamento` INT(11) NOT NULL,
  `codigo` VARCHAR(255) NOT NULL UNIQUE,
  `valor` DECIMAL(10,2) NOT NULL,
  `data_geracao` DATE NOT NULL,
  `data_vencimento` DATE NOT NULL,
  `data_pagamento` DATE,
  `status_pagamento` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_id_socios`
    FOREIGN KEY (`id_socio`)
    REFERENCES `wegia`.`socio` (`id_socio`),
  CONSTRAINT `FK_id_gateways`
    FOREIGN KEY (`id_gateway`)
    REFERENCES `wegia`.`contribuicao_gatewayPagamento` (`id`),
  CONSTRAINT `FK_id_meio_pagamentos`
    FOREIGN KEY (`id_meio_pagamento`)
    REFERENCES `wegia`.`contribuicao_meioPagamento` (`id`)
)
ENGINE = InnoDB;