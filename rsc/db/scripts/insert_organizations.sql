/*
-- Query: SELECT * FROM synapse.organization
LIMIT 0, 1000

-- Date: 2013-05-13 10:33
*/
INSERT INTO `organization` (`ID`,`acronym`,`name`,`fatherID`,`orgLevel`,`degreeID`,`autochild`) VALUES (1,'Sec','Secretaria de Educação',0,1,0,0);
INSERT INTO `organization` (`ID`,`acronym`,`name`,`fatherID`,`orgLevel`,`degreeID`,`autochild`) VALUES (2,'Esc','Escola',1,2,0,0);
INSERT INTO `organization` (`ID`,`acronym`,`name`,`fatherID`,`orgLevel`,`degreeID`,`autochild`) VALUES (3,'EnFM','Ensino Fundamental Menor',2,3,0,0);
INSERT INTO `organization` (`ID`,`acronym`,`name`,`fatherID`,`orgLevel`,`degreeID`,`autochild`) VALUES (4,'1º Ano EnFM','1ª Ano Ensino Fundamental Menor',3,-1,0,0);
