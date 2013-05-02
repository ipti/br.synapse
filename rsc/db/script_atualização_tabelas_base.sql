SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `synapse`.`actor` DROP FOREIGN KEY `fk_actor4unityID` , DROP FOREIGN KEY `fk_actor4personageID` , DROP FOREIGN KEY `fk_actor4personID` ;

ALTER TABLE `synapse`.`unity` DROP FOREIGN KEY `fk_unity4locationID` , DROP FOREIGN KEY `fk_unity4organizationID` ;

ALTER TABLE `synapse`.`person` CHANGE COLUMN `login` `login` INT(11) NOT NULL  ;

ALTER TABLE `synapse`.`actor` ADD COLUMN `activatedDate` INT(11) NULL DEFAULT NULL  AFTER `personageID` , ADD COLUMN `desactivatedDate` INT(11) NULL DEFAULT NULL  AFTER `activatedDate` , CHANGE COLUMN `unityID` `unityID` INT(11) NOT NULL  , CHANGE COLUMN `personID` `personID` INT(11) NOT NULL  , CHANGE COLUMN `personageID` `personageID` INT(11) NOT NULL  , 
  ADD CONSTRAINT `fk_actor4unityID`
  FOREIGN KEY (`unityID` )
  REFERENCES `synapse`.`unity` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_actor4personageID`
  FOREIGN KEY (`personageID` )
  REFERENCES `synapse`.`personage` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_actor4personID`
  FOREIGN KEY (`personID` )
  REFERENCES `synapse`.`person` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`organization` CHANGE COLUMN `acronym` `acronym` VARCHAR(30) NULL DEFAULT NULL  , CHANGE COLUMN `name` `name` VARCHAR(60) NOT NULL  ;

ALTER TABLE `synapse`.`unity` ADD COLUMN `capacity` INT(11) NULL DEFAULT NULL  AFTER `desDate` , CHANGE COLUMN `name` `name` VARCHAR(45) NOT NULL  , CHANGE COLUMN `organizationID` `organizationID` INT(11) NOT NULL  , CHANGE COLUMN `locationID` `locationID` INT(11) NOT NULL  , CHANGE COLUMN `autochild` `autochild` INT(11) NOT NULL DEFAULT 0  , 
  ADD CONSTRAINT `fk_unity4locationID`
  FOREIGN KEY (`locationID` )
  REFERENCES `synapse`.`location` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_unity4organizationID`
  FOREIGN KEY (`organizationID` )
  REFERENCES `synapse`.`organization` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`location` CHANGE COLUMN `typeLocation` `typeLocation` ENUM('CITY','STATE','COUNTRY') NOT NULL DEFAULT CITY  , CHANGE COLUMN `name` `name` VARCHAR(60) NOT NULL  , CHANGE COLUMN `acronym` `acronym` VARCHAR(30) NULL DEFAULT NULL  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
