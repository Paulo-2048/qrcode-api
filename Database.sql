-- -----------------------------------------------------
-- Schema qrcode_api
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `qrcode_api` DEFAULT CHARACTER SET utf8 ;
USE `qrcode_api` ;

-- -----------------------------------------------------
-- Table `qrcode_api`.`qrcode`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `qrcode_api`.`qrcode` (
  `idqrcode` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(90) NOT NULL,
  `description` VARCHAR(145) NULL DEFAULT NULL,
  `link` VARCHAR(145) NOT NULL,
  `reference` VARCHAR(45) NOT NULL,
  `userToken` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idqrcode`),
  UNIQUE INDEX `uniqid_UNIQUE` (`idqrcode` ASC) VISIBLE,
  UNIQUE INDEX `reference_UNIQUE` (`reference` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `qrcode_api`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `qrcode_api`.`users` (
  `idusers` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `acess` VARCHAR(1) NOT NULL DEFAULT '3',
  `token` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idusers`),
  UNIQUE INDEX `token_UNIQUE` (`token` ASC) VISIBLE,
  UNIQUE INDEX `idusers_UNIQUE` (`idusers` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8mb3;