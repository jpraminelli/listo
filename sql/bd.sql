SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `ativo` TINYINT(1) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `senha` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`usuarios` (
  `id` INT NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `ativo` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`apresentacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`apresentacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data_cadastro` DATETIME NOT NULL,
  `url` VARCHAR(200) NOT NULL,
  `largura` INT NOT NULL,
  `altura` INT NOT NULL,
  `background` VARCHAR(7) NULL DEFAULT '#FFFFFF',
  `sequencia` INT NOT NULL,
  `clientes_id` INT NOT NULL,
  `usuarios_id` INT NOT NULL,
  PRIMARY KEY (`id`, `clientes_id`, `usuarios_id`),
  INDEX `fk_apresentacoes_clientes_idx` (`clientes_id` ASC),
  INDEX `fk_apresentacao_usuarios1_idx` (`usuarios_id` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`apresentacao_arquivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`apresentacao_arquivos` (
  `id` INT NOT NULL,
  `extensao` VARCHAR(3) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `ordem` INT NOT NULL,
  `nome` VARCHAR(150) NOT NULL,
  `tempo` FLOAT NOT NULL,
  `apresentacao_id` INT NOT NULL,
  PRIMARY KEY (`id`, `apresentacao_id`),
  INDEX `fk_apresentacao_arquivos_apresentacao1_idx` (`apresentacao_id` ASC),
  CONSTRAINT `fk_apresentacao_arquivos_apresentacao1`
    FOREIGN KEY (`apresentacao_id`)
    REFERENCES `mydb`.`apresentacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`apresentacao_layout`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`apresentacao_layout` (
  `id` INT NOT NULL,
  `ordem` INT NOT NULL,
  `apresentacao_id` INT NOT NULL,
  PRIMARY KEY (`id`, `apresentacao_id`),
  INDEX `fk_apresentacao_layout_apresentacao1_idx` (`apresentacao_id` ASC),
  CONSTRAINT `fk_apresentacao_layout_apresentacao1`
    FOREIGN KEY (`apresentacao_id`)
    REFERENCES `mydb`.`apresentacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

