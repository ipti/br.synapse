
ALTER TABLE `synapse`.`unity_tree` 

CHANGE COLUMN `ID` `ID` INT(11) NOT NULL  , 

CHANGE COLUMN `unity` `unity` INT(11) NOT NULL  , 

ADD COLUMN `organizationID` INT(11) NULL  AFTER `unity` , 

ADD COLUMN `unityOrganizationID` INT(11) NULL DEFAULT NULL AFTER `organizationID` , 
DROP PRIMARY KEY 
, 
ADD PRIMARY KEY (`ID`, `unity`) ;