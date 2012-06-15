<?php

class DefaultController extends Controller {

    public function actionIndex() {
        //$sql = "SELECT * FROM discipline";
        //$sql = "SELECT * FROM activitytemplate";
        //$sql = "SELECT * FROM semantic";
        //$sql = "SELECT * FROM activityhability";
        //$sql = "select  (description||' - '||b.name||' ANO') AS name,b.id,b.grade AS year,c.grade AS stage from degreeblock b join degreestage c on(b.degreestage_id=c.id)";
        $sql = "select  (description||' - '||b.name||' ANO'||'/'||a.name) AS name,a.id,b.id as parentID,b.grade AS year,c.grade AS stage,a.grade AS grade from degreegrade a
	join degreeblock b on(a.degreeblock_id=b.id)
	join degreestage c on(b.degreestage_id=c.id)
order by b.id";
        $command = Yii::app()->db2->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        
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
        /**foreach ($reader as $row) {
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
            $tmp->name = $row['name'];
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
        
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
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name'];
            $tmp->code = wordwrap($row['name'], 5);
            if (!$tmp->save()) {
                var_dump($tmp->errors);
            }
        }
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