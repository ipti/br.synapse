<?php

class DefaultController extends Controller {

    public function actionIndex() {
        //$sql = "SELECT * FROM discipline";
        //$sql = "select (d.name||' - '||b.name||' - '||c.name) as name,d.id as dOld,b.id as fOld,c.id iOld from activity a join activityformat b on(a.activityformat_id=b.id) join activityinteratividade c on(a.activityinteratividade_id=c.id) join activitytemplate d on(a.activitytemplate_id=d.id) where a.activitytype_id = '2' group by d.name,b.name,c.name,d.id,b.id,c.id";
        //$sql = "SELECT * FROM semantic";
        //$sql = "select * from activitycontent where type_id = '1' and father_id < '20'"; //"SELECT * FROM activityhability";
        //$sql = "select  (description||' - '||b.name||' ANO') AS name,b.id,b.grade AS year,c.grade AS stage from degreeblock b join degreestage c on(b.degreestage_id=c.id)";
        //$sql = "select  (description||' - '||b.name||' ANO'||'/'||a.name) AS name,a.id,b.id as parentID,b.grade AS year,c.grade AS stage,a.grade AS grade from degreegrade a join degreeblock b on(a.degreeblock_id=b.id) join degreestage c on(b.degreestage_id=c.id) order by b.id";
        //$sql = "select name_varchar,id from activitycontent where father_id = '20'";
        //$sql = "select name_varchar,id,father_id from activitycontent where father_id in(select id from activitycontent where father_id='20')";
        //$sql = "select name_varchar,id,father_id  from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id='20'))";
        //$sql = "select name_varchar,id,father_id  from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id='20')))";
        //$sql = "select * from activitycontent where type_id = '2' and father_id is null";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null)";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null))";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null)))";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null))))";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null)))))";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null))))))";
        //$sql = "select * from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where type_id = '2' and father_id is null)))))))";
        //$sql = "select * from goal";
        //$sql = "select * from activity where activitytype_id = 2 and status = 1";
        //$sql = "select d.id,a.screen from layer_property a join piece c on(a.piece_id=c.id) join activity d on(c.activity_id=d.id) group by d.id,a.screen order by d.id";
        //IMPORT PIECESET GERAR UM REGISTRO E AMARAR TODAS AS PEÇAS POSTERIORES NELE.
        //AO IMPORTAR PIECE LEMBRAR DO ORDER
        //$sql = "select * from piece";
        $sql = "select a.id,a.screen,a.piece_id,c.name,a.element_id as table_ref,(CASE WHEN b.media IS NULL OR b.media = '' THEN d.name ELSE b.media END) as table_source,b.media,d.name, 
(CASE WHEN b.media IS NULL OR b.media = '' THEN (CASE WHEN d.name = 'image' THEN (select ('extension:'||extension||';'||dim_x||';'||b.name) from image a2 join style b on(b.id=a2.style) where a2.id=a.element_id) ELSE '2' END) ELSE (CASE WHEN b.media = 'image' THEN '1' ELSE '2' END) END) 
from layer_property a
join piece_element b on(a.piece_element_id=b.id)
join layertype c on(c.id=a.layertype_id)
join elementtype d on(d.id=b.elementtype_id)";
        
        $command = Yii::app()->db2->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        set_time_limit(0);
        
        foreach ($reader as $row) {
            $tmp = new Cobject();
            $tmp->oldID = $row['id'];
            $tmp->typeID = 1;
            $theme = CobjectTheme::model()->findByAttributes(array('oldID'=>$row['semantic_id']));
            $tmp->themeID = $theme->ID;
            if(!isset($row['activityinteratividade_id'])){
              $template = CobjectTemplate::model()->findByAttributes(array('oldID'=>$row['activitytemplate_id'],'oldIDFormat'=>$row['activityformat_id']));
            }else{
              $template = CobjectTemplate::model()->findByAttributes(array('oldID'=>$row['activitytemplate_id'],'oldIDFormat'=>$row['activityformat_id'],'oldIDInterative'=>$row['activityinteratividade_id']));
            }
            $tmp->templateID = $template->ID;
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
            $c = new CobjectData();
            $c->cobjectID = $tmp->ID;
            $goal = ActGoal::model()->findByAttributes(array('oldID'=>$row['goal_id']));
            if(!isset($goal)){
                $c->goalID = "0";
            }else{
                $c->goalID = $goal->ID;
            }
        }
        /**
        foreach ($reader as $row) {
            $tmp = new ActGoal();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['description'].$row['description2'];
            $disc = ActDiscipline::model()->findByAttributes(array('oldID'=>$row['discipline_id']));
            $tmp->disciplineID = $disc->ID;
            $degree = ActDegree::model()->findByAttributes(array('oldID'=>$row['degreegrade_id']),'grade <> 0');
            $tmp->degreeID = $degree->ID;
            $array1 = explode("#", $row['content_id']);
            $array2 = explode("#",$row['hability_id']);
            $array3 = explode("#",$row['contenthability_id']);
            $ids = array_merge_recursive($array1, $array2,$array3);
            $ids = array_unique($ids);
            if (!$tmp->save()) {
                var_dump($tmp->errors);exit;
            }
            foreach ($ids as $id) {
                $content = ActContent::model()->findByAttributes(array('oldID'=>$id));
                $modality = ActModality::model()->findByAttributes(array('oldID'=>$id));
                $skill = ActSkill::model()->findByAttributes(array('oldID'=>$id));
                if(isset($content)){
                    $scontent = new ActGoalContent();
                    $scontent->contentID = $content->ID;
                    $scontent->goalID = $tmp->ID;
                    $scontent->save();
                }
                if(isset($modality)){
                    $smodality = new ActGoalModality();
                    $smodality->modalityID = $modality->ID;
                    $smodality->goalID = $tmp->ID;
                    $smodality->save();
                }
                if(isset($skill)){
                    $sskill = new ActGoalSkill();
                    $sskill->skillID = $skill->ID;
                    $sskill->goalID = $tmp->ID;
                    $sskill->save();
                }
            }
        }
        
        
        foreach ($reader as $row) {
            $tmp = new ActContent();
            $tmp->oldID = $row['id'];
            $tmp->description = $row['name_varchar'];
            $disc = ActDiscipline::model()->findByAttributes(array('oldID'=>$row['discipline_id']));
            $tmp->disciplineID = $disc->ID;
            $parent = ActContent::model()->findByAttributes(array('oldID'=>$row['father_id']));
            if(!isset($parent)){
               var_dump($row['father_id']);exit; 
            }
            $tmp->contentParent = $parent->ID; 
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        
         foreach ($reader as $row) {
            $tmp = new ActContent();
            $tmp->oldID = $row['id'];
            $tmp->description = $row['name_varchar'];
            $disc = ActDiscipline::model()->findByAttributes(array('oldID'=>$row['discipline_id']));
            $tmp->disciplineID = $disc->ID;
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        
       
        foreach ($reader as $row) {
            $tmp = new ActModality();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            $parent = ActModality::model()->findByAttributes(array('oldID'=>$row['father_id']));
            $tmp->modalityParent = $parent->ID;
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        
        foreach ($reader as $row) {
            $tmp = new ActModality();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        
        foreach ($reader as $row) {
            $tmp = new ActDegree();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name'];
            $parent = ActDegree::model()->findByAttributes(array('oldID'=>$row['parentid']));
            $tmp->degreeParent = $parent->ID;
            $tmp->year = $row['year'];
            $tmp->stage = $row['stage'];
            $tmp->grade = $row['grade'];
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        foreach ($reader as $row) {
            $tmp = new ActDegree();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name'];
            $tmp->year = $row['year'];
            $tmp->stage = $row['stage'];
            $tmp->grade = 0;
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
       
        foreach ($reader as $row) {
            $tmp = new ActSkill();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        /**
        foreach ($reader as $row) {
            $tmp = new CobjectTheme();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        foreach ($reader as $row) {
            $tmp = new CobjectTemplate();
            $tmp->oldID = $row['dold'];
            $tmp->oldIDFormat = $row['fold'];
            $tmp->oldIDInterative = $row['iold'];
            $tmp->name = $row['name'];
            $tmp->code = wordwrap($row['name'], 2);
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }/**
        foreach ($reader as $row) {
            $d = new ActDiscipline();
            $d->oldID = $row['id'];
            $d->name = $row['name'];
            $d->save();
        }**/
        exit;
        //$this->render('index');
    }

}