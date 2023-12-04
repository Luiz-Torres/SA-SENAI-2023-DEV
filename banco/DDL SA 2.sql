-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_epi_control
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_epi_control
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_epi_control` DEFAULT CHARACTER SET utf8 ;
USE `db_epi_control` ;

-- -----------------------------------------------------
-- Table `db_epi_control`.`EPI_CADASTROS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`EPI_CADASTROS` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`EPI_CADASTROS` (
  `id_produto` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(6) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `data_cadastro` DATE NULL,
  `qtd` DOUBLE NULL,
  `controla_serie` TINYINT NULL,
  `controla_lote` TINYINT NULL,
  `observacoes` TEXT(512) NULL,
  `imagem` VARCHAR(45) NULL,
  PRIMARY KEY (`id_produto`),
  UNIQUE INDEX `id_produto_UNIQUE` (`id_produto` ASC) ,
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`EPI_LOTES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`EPI_LOTES` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`EPI_LOTES` (
  `id_lote` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_epi` INT UNSIGNED NOT NULL,
  `numero_lote` VARCHAR(45) NOT NULL,
  `data_cadastro` DATE NULL,
  `data_validade` DATE NULL,
  `qtd_total` DOUBLE NULL,
  `qtd_disponivel` DOUBLE NULL,
  PRIMARY KEY (`id_lote`),
  UNIQUE INDEX `id_lote_UNIQUE` (`id_lote` ASC) ,
  INDEX `fk_EPI_LOTES_EPI_CADASTROS1_idx` (`id_epi` ASC) ,
  CONSTRAINT `fk_EPI_LOTES_EPI_CADASTROS1`
    FOREIGN KEY (`id_epi`)
    REFERENCES `db_epi_control`.`EPI_CADASTROS` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`EPI_NUM_SERIE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`EPI_NUM_SERIE` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`EPI_NUM_SERIE` (
  `id_num_serie` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `serie` VARCHAR(45) NOT NULL,
  `id_produto` INT UNSIGNED NOT NULL,
  `disponivel` TINYINT NULL,
  PRIMARY KEY (`id_num_serie`),
  INDEX `FK_EPI_idx` (`id_produto` ASC) ,
  UNIQUE INDEX `id_num_serie_UNIQUE` (`id_num_serie` ASC) ,
  CONSTRAINT `FK_EPI_NUM_SERIE`
    FOREIGN KEY (`id_produto`)
    REFERENCES `db_epi_control`.`EPI_CADASTROS` (`id_produto`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`USUARIOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`USUARIOS` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`USUARIOS` (
  `id_usuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(6) NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `imagem` VARCHAR(45) NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `id_usuario_UNIQUE` (`id_usuario` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`COLABORADORES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`COLABORADORES` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`COLABORADORES` (
  `id_colaborador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(6) NULL,
  `nome` VARCHAR(255) NOT NULL,
  `funcao` VARCHAR(45) NOT NULL,
  `setor` VARCHAR(45) NOT NULL,
  `turno` VARCHAR(10) NOT NULL,
  `data_admissao` DATE NOT NULL,
  `observacoes` TEXT(512) NULL,
  `imagem` VARCHAR(45) NULL,
  PRIMARY KEY (`id_colaborador`),
  UNIQUE INDEX `id_colaborador_UNIQUE` (`id_colaborador` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`EMPRESTIMOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`EMPRESTIMOS` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`EMPRESTIMOS` (
  `id_emprestimo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(6) NOT NULL,
  `status_emprestimo` VARCHAR(12) NULL,
  `id_colaborador` INT UNSIGNED NOT NULL,
  `id_usuario` INT UNSIGNED NOT NULL,
  `data_emprestimo` VARCHAR(45) NOT NULL,
  `observacoes` TEXT(512) NULL,
  PRIMARY KEY (`id_emprestimo`),
  INDEX `FK_USUARIO_idx` (`id_usuario` ASC) ,
  INDEX `FK_COLABORADOR_idx` (`id_colaborador` ASC) ,
  UNIQUE INDEX `id_emprestimo_UNIQUE` (`id_emprestimo` ASC) ,
  CONSTRAINT `FK_USUARIO`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_epi_control`.`USUARIOS` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_COLABORADOR`
    FOREIGN KEY (`id_colaborador`)
    REFERENCES `db_epi_control`.`COLABORADORES` (`id_colaborador`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`CA_EPI`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`CA_EPI` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`CA_EPI` (
  `id_ca` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_epi` INT UNSIGNED NOT NULL,
  `numero_ca` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_ca`),
  INDEX `FK_CA_EPI_idx` (`id_epi` ASC) ,
  CONSTRAINT `FK_CA_EPI`
    FOREIGN KEY (`id_epi`)
    REFERENCES `db_epi_control`.`EPI_CADASTROS` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_epi_control`.`EMPRESTIMOS_ITENS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_epi_control`.`EMPRESTIMOS_ITENS` ;

CREATE TABLE IF NOT EXISTS `db_epi_control`.`EMPRESTIMOS_ITENS` (
  `id_emprestimo_item` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_emprestimo` INT UNSIGNED NOT NULL,
  `id_epi` INT UNSIGNED NOT NULL,
  `id_ca_epi` INT UNSIGNED NOT NULL,
  `qtd` DOUBLE NOT NULL,
  `id_num_serie` INT UNSIGNED NULL,
  `id_lote_epi` INT UNSIGNED NULL,
  PRIMARY KEY (`id_emprestimo_item`),
  INDEX `FK_EPI_ITEM_idx` (`id_epi` ASC) ,
  INDEX `FK_NUM_SERIE_idx` (`id_num_serie` ASC) ,
  INDEX `FK_EMPRESTIMO_idx` (`id_emprestimo` ASC) ,
  UNIQUE INDEX `id_emprestimo_item_UNIQUE` (`id_emprestimo_item` ASC) ,
  INDEX `FK_CA_idx` (`id_ca_epi` ASC) ,
  INDEX `FK_NUM_LOTE_CADASTRO_idx` (`id_lote_epi` ASC) ,
  CONSTRAINT `FK_EPI_ITEM`
    FOREIGN KEY (`id_epi`)
    REFERENCES `db_epi_control`.`EPI_CADASTROS` (`id_produto`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_EMPRESTIMO`
    FOREIGN KEY (`id_emprestimo`)
    REFERENCES `db_epi_control`.`EMPRESTIMOS` (`id_emprestimo`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_NUM_SERIE`
    FOREIGN KEY (`id_num_serie`)
    REFERENCES `db_epi_control`.`EPI_NUM_SERIE` (`id_num_serie`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_NUM_LOTE_CADASTRO`
    FOREIGN KEY (`id_lote_epi`)
    REFERENCES `db_epi_control`.`EPI_LOTES` (`id_lote`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_CA`
    FOREIGN KEY (`id_ca_epi`)
    REFERENCES `db_epi_control`.`CA_EPI` (`id_ca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `db_epi_control`;

DELIMITER $$

USE `db_epi_control`$$
DROP TRIGGER IF EXISTS `db_epi_control`.`EMPRESTIMOS_ITENS_AFTER_INSERT` $$
USE `db_epi_control`$$
DROP TRIGGER IF EXISTS `db_epi_control`.`EMPRESTIMOS_ITENS_AFTER_INSERT`$$
CREATE DEFINER = CURRENT_USER TRIGGER `db_epi_control`.`EMPRESTIMOS_ITENS_AFTER_INSERT` AFTER INSERT ON `EMPRESTIMOS_ITENS` FOR EACH ROW
BEGIN
	update EPI_CADASTROS
    set qtd = qtd-new.qtd
    where id_produto = new.id_epi;
    
    SET @checkLote = new.id_lote_epi;
    IF(@checkLote is not null) THEN
		update EPI_LOTES
        set qtd_disponivel = qtd_disponivel - new.qtd
        where id_lote = new.id_lote_epi;
    END IF;
    
    SET @checkSerie = new.id_num_serie;
    IF(@checkSerie is not null) THEN
		update EPI_NUM_SERIE
        set disponivel = 0
        where id_num_serie = new.id_num_serie;
    END IF;
END$$


USE `db_epi_control`$$
DROP TRIGGER IF EXISTS `db_epi_control`.`EMPRESTIMOS_ITENS_AFTER_DELETE` $$
USE `db_epi_control`$$
DROP TRIGGER IF EXISTS `db_epi_control`.`EMPRESTIMOS_ITENS_AFTER_DELETE`$$
CREATE DEFINER = CURRENT_USER TRIGGER `db_epi_control`.`EMPRESTIMOS_ITENS_AFTER_DELETE` AFTER DELETE ON `EMPRESTIMOS_ITENS` FOR EACH ROW
BEGIN
    -- Update EPI_CADASTROS quantity
    UPDATE EPI_CADASTROS
    SET qtd = qtd + old.qtd
    WHERE id_produto = old.id_epi;

    -- Check if there's a linked lot
    SET @checkLote = old.id_lote_epi;
    IF (@checkLote IS NOT NULL) THEN
        -- Update EPI_LOTES quantity
        UPDATE EPI_LOTES
        SET qtd_disponivel = qtd_disponivel + old.qtd
        WHERE id_lote = old.id_lote_epi;
    END IF;

    -- Check if there's a linked serial number
    SET @checkSerie = old.id_num_serie;
    IF (@checkSerie IS NOT NULL) THEN
        -- Update EPI_NUM_SERIE availability
        UPDATE EPI_NUM_SERIE
        SET disponivel = 1
        WHERE id_num_serie = old.id_num_serie;
    END IF;
END;$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
