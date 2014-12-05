SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `yii2basic` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `yii2basic` ;

-- -----------------------------------------------------
-- Table `yii2basic`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yii2basic`.`categories` (
  `cat_id` INT NOT NULL AUTO_INCREMENT ,
  `cat_name` VARCHAR(45) NOT NULL ,
  `cat_parent_id` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`cat_id`) ,
  INDEX `parent_id` (`cat_parent_id` ASC) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`cat_parent_id` )
    REFERENCES `yii2basic`.`categories` (`cat_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `yii2basic`.`posts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yii2basic`.`posts` (
  `posts_id` INT NOT NULL AUTO_INCREMENT ,
  `posts_name` VARCHAR(45) NOT NULL ,
  `posts_cat_id` INT NOT NULL ,
  `posts_text` VARCHAR(500) NOT NULL ,
  `posts_author` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`posts_id`) ,
  INDEX `cat_id` (`posts_cat_id` ASC) ,
  CONSTRAINT `cat_id`
    FOREIGN KEY (`posts_cat_id` )
    REFERENCES `yii2basic`.`categories` (`cat_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `yii2basic`.`comments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yii2basic`.`comments` (
  `com_id` INT NOT NULL AUTO_INCREMENT ,
  `com_author` VARCHAR(45) NOT NULL ,
  `com_text` VARCHAR(500) NOT NULL ,
  `com_posts_id` INT NOT NULL ,
  `com_com_id` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`com_id`) ,
  INDEX `posts_d` (`com_posts_id` ASC) ,
  INDEX `com_id` (`com_com_id` ASC) ,
  CONSTRAINT `posts_d`
    FOREIGN KEY (`com_posts_id` )
    REFERENCES `yii2basic`.`posts` (`posts_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `com_id`
    FOREIGN KEY (`com_com_id` )
    REFERENCES `yii2basic`.`comments` (`com_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
