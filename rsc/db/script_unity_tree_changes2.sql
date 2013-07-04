SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `synapse`.`cobject_metadata` DROP FOREIGN KEY `fk_cobjectMetadata4typeID` ;

ALTER TABLE `synapse`.`cobject_metadata` 
  ADD CONSTRAINT `fk_cobjectMetadata4typeID`
  FOREIGN KEY (`typeID` )
  REFERENCES `synapse`.`common_type` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`editor_screen_pieceset` DROP FOREIGN KEY `fk_editorScreenPieceset4screenID` ;

ALTER TABLE `synapse`.`editor_screen_pieceset` 
  ADD CONSTRAINT `fk_editorScreenPieceset4screenID`
  FOREIGN KEY (`screenID` )
  REFERENCES `synapse`.`editor_screen` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`library_property` DROP FOREIGN KEY `fk_libraryID` ;

ALTER TABLE `synapse`.`library_property` 
  ADD CONSTRAINT `fk_libraryID`
  FOREIGN KEY (`libraryID` )
  REFERENCES `synapse`.`library` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`cobject_cobjectblock` DROP FOREIGN KEY `fk_cobjectBlock4cobjectID` ;

ALTER TABLE `synapse`.`cobject_cobjectblock` 
  ADD CONSTRAINT `fk_cobjectBlock4cobjectID`
  FOREIGN KEY (`cobjectID` )
  REFERENCES `synapse`.`cobject` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`performance_pieceset_cache` DROP FOREIGN KEY `fk_peformancePieceset4piecesetID` ;

ALTER TABLE `synapse`.`performance_pieceset_cache` 
  ADD CONSTRAINT `fk_peformancePieceset4piecesetID`
  FOREIGN KEY (`piecesetID` )
  REFERENCES `synapse`.`editor_pieceset` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`act_matrix` DROP FOREIGN KEY `fk_actMatrix4disciplineID` ;

ALTER TABLE `synapse`.`act_matrix` 
  ADD CONSTRAINT `fk_actMatrix4disciplineID`
  FOREIGN KEY (`disciplineID` )
  REFERENCES `synapse`.`act_discipline` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`actor` DROP FOREIGN KEY `fk_actor4unityID` ;

ALTER TABLE `synapse`.`actor` 
  ADD CONSTRAINT `fk_actor4unityID`
  FOREIGN KEY (`unityID` )
  REFERENCES `synapse`.`unity` (`ID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `synapse`.`unity_tree` ADD COLUMN `organizationID` INT(11) NOT NULL  AFTER `unity` , ADD COLUMN `unityOrganizationID` INT(11) NULL DEFAULT NULL  AFTER `organizationID` , CHANGE COLUMN `unity` `unity` INT(11) NOT NULL  
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`ID`, `unity`) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
