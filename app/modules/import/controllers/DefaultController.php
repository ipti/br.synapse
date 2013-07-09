<?php

class DefaultController extends Controller {

    public function search($sql) {
        $command = @Yii::app()->db2->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        return $reader;
    }

    public function elog($stage, $text, $erro = false) {
        if (!$erro) {
            echo "<strong>$stage</strong>: <font color=green>$text</font></br>";
        } else {
            echo "<strong>$stage</strong>: <font color=red>$text(" . print_r($erro) . ")</font></br>";
        }
        flush();
        ob_flush();
    }

    public function actionIndex() {
        /*
        //1) IMPORTAR AS DISCIPLINAS;
        set_time_limit(0);
        header('Content-type: text/html; charset=utf-8');
        $reader = $this->search("SELECT * FROM discipline");
        foreach ($reader as $row) {
            $d = new ActDiscipline();
            $d->oldID = $row['id'];
            $d->name = $row['name'];
            $d->save();
            $this->elog('DISCIPLINA', $d->name);
        }

        //2) IMPORTAR OS TEMPLATES;
        $stemplate = "select (d.name||' - '||b.name||' - '||c.name) as name,d.id as dOld,b.id as fOld,c.id iOld from activity a join activityformat b on(a.activityformat_id=b.id) join activityinteratividade c on(a.activityinteratividade_id=c.id) join activitytemplate d on(a.activitytemplate_id=d.id) where a.activitytype_id = '2' group by d.name,b.name,c.name,d.id,b.id,c.id";
        $reader = $this->search($stemplate);

        //MODIFICAR  a tabela e incluir ids para formato e interatividade.
        foreach ($reader as $row) {
            $tmp = new CobjectTemplate();
            $tmp->oldID = $row['dold'];
            $tmp->oldIDFormat = $row['fold'];
            $tmp->oldIDInterative = $row['iold'];
            $tmp->name = $row['name'];
            $tmp->code = wordwrap($row['name'], 2);
            if (!$tmp->save()) {
                $this->elog('Template', $row['name'], $tmp->errors);
            } else {
                $this->elog('Template', $tmp->name);
            }
        }

        //3)IMPORTAR OS THEMAS
        $reader = $this->search("SELECT * FROM semantic");
        foreach ($reader as $row) {
            $tmp = new CobjectTheme();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            if (!$tmp->save()) {
                $this->elog('Temas', $row['name_varchar'], $tmp->errors);
            } else {
                $this->elog('Temas', $tmp->name);
            }
        }



        //4)IMPORTAR AS HABILIDADES
        $skills = "select * from activitycontent where type_id = '1' and father_id < '20'"; //"SELECT * FROM activityhability";
        $reader = $this->search($skills);
        foreach ($reader as $row) {
            $tmp = new ActSkill();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            if (!$tmp->save()) {
                $this->elog('Habilidade', $row['name_varchar'], $tmp->errors);
            } else {
                $this->elog('Habilidade', $tmp->name);
            }
        }

        //5)IMPORTAR OS NIVEIS
        $sdegree = "select  (description||' - '||b.name||' ANO') AS name,b.id,0 as parentID,b.grade AS year,c.grade AS stage,0 as grade from degreeblock b join degreestage c on(b.degreestage_id=c.id)
          UNION
          select  (description||' - '||b.name||' ANO'||'/'||a.name) AS name,a.id,b.id as parentID,b.grade AS year,c.grade AS stage,a.grade AS grade from degreegrade a join degreeblock b on(a.degreeblock_id=b.id) join degreestage c on(b.degreestage_id=c.id)
          order by parentid,stage,year,grade";
        $reader = $this->search($sdegree);
        foreach ($reader as $row) {
            $tmp = new ActDegree();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name'];
            if ($row['parentid'] != 0) {
                $parent = ActDegree::model()->findByAttributes(array('oldID' => $row['parentid']));
                $tmp->degreeParent = $parent->ID;
            }
            $tmp->year = $row['year'];
            $tmp->stage = $row['stage'];
            $tmp->grade = $row['grade'];
            if (!$tmp->save()) {
                $this->elog('Nivel', $row['name'], $tmp->errors);
            } else {
                $this->elog('Nivel', $tmp->name);
            }
        }

        //6)IMPORTAR AS MODALIDADES.
        $smodality = "select name_varchar,id,father_id,0 as seq from activitycontent where father_id='20'
          UNION
          select name_varchar,id,father_id,1 as seq from activitycontent where father_id in(select id from activitycontent where father_id='20')
          UNION
          select name_varchar,id,father_id,2 as seq  from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id='20'))
          UNION
          select name_varchar,id,father_id,3 as seq  from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id in(select id from activitycontent where father_id='20')))
          order by seq";
        $reader = $this->search($smodality);
        foreach ($reader as $row) {
            $tmp = new ActModality();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['name_varchar'];
            if ($row['seq'] != 0) {
                $parent = ActModality::model()->findByAttributes(array('oldID' => $row['father_id']));
                $tmp->modalityParent = $parent->ID;
            }
            if (!$tmp->save()) {
                $this->elog('Modalidade', $row['name_varchar'], $tmp->errors);
            } else {
                $this->elog('Modalidade', $tmp->name);
            }
        }

        //7)IMPORTAR OS CONTEÚDOS.
        $scontent = "select * from activitycontent a where type_id = '2' order by (coalesce(father_id,0))";
        $reader = $this->search($scontent);
        foreach ($reader as $row) {
            $tmp = new ActContent();
            $tmp->oldID = $row['id'];
            $tmp->description = $row['name_varchar'];
            $disc = ActDiscipline::model()->findByAttributes(array('oldID' => $row['discipline_id']));
            $tmp->disciplineID = $disc->ID;
            if ($row['father_id'] != "NULL") {
                $parent = ActContent::model()->findByAttributes(array('oldID' => $row['father_id']));
                if (isset($parent)) {
                    $tmp->contentParent = $parent->ID;
                }
            }
            if (!$tmp->save()) {
                $this->elog('Conteúdo', $row['id'], $tmp->errors);
            } else {
                $this->elog('Conteúdo', $tmp->description);
            }
        }

        //8) IMPORTAR OS OBJETIVOS.
        $sgoal = "select * from goal";
        $reader = $this->search($sgoal);
        foreach ($reader as $row) {
            $tmp = new ActGoal();
            $tmp->oldID = $row['id'];
            $tmp->name = $row['description'] . $row['description2'];
            $disc = ActDiscipline::model()->findByAttributes(array('oldID' => $row['discipline_id']));
            $tmp->disciplineID = $disc->ID;
            $degree = ActDegree::model()->findByAttributes(array('oldID' => $row['degreegrade_id']), 'grade <> 0');
            $tmp->degreeID = $degree->ID;
            $array1 = explode("#", $row['content_id']);
            $array2 = explode("#", $row['hability_id']);
            $array3 = explode("#", $row['contenthability_id']);
            $ids = array_merge_recursive($array1, $array2, $array3);
            $ids = array_unique($ids);
            if (!$tmp->save()) {
                $this->elog('Objetivo:', $row['id'], $tmp->errors);
            } else {
                $this->elog('Objetivo:', $tmp->name);
            }
            foreach ($ids as $id) {
                $content = ActContent::model()->findByAttributes(array('oldID' => $id));
                $modality = ActModality::model()->findByAttributes(array('oldID' => $id));
                $skill = ActSkill::model()->findByAttributes(array('oldID' => $id));
                if (isset($content)) {
                    $scontent = new ActGoalContent();
                    $scontent->contentID = $content->ID;
                    $scontent->goalID = $tmp->ID;
                    $scontent->save();
                    $this->elog('Conteúdo/Objetivo:', $scontent->contentID . '/' . $scontent->goalID);
                }
                if (isset($modality)) {
                    $smodality = new ActGoalModality();
                    $smodality->modalityID = $modality->ID;
                    $smodality->goalID = $tmp->ID;
                    $smodality->save();
                    $this->elog('Modalidade/Objetivo:', $smodality->modalityID . '/' . $scontent->goalID);
                }
                if (isset($skill)) {
                    $sskill = new ActGoalSkill();
                    $sskill->skillID = $skill->ID;
                    $sskill->goalID = $tmp->ID;
                    $sskill->save();
                    $this->elog('Habilidade/Objetivo:', $sskill->skillID . '/' . $sskill->goalID);
                }
            }
        }*/
        //9) IMPORTAR AS ATIVIDADES;
        $sqlacts = "select * from activity where activitytype_id = 2 and status = 1";
        $reader = $this->search($sqlacts);
        foreach ($reader as $row) {
            $tmp = new Cobject();
            $tmp->oldID = $row['id'];
            $tmp->typeID = 1;
            $theme = CobjectTheme::model()->findByAttributes(array('oldID' => $row['semantic_id']));
            if(!isset($theme)){
                $tmp->themeID = 916;
            }else{
                $tmp->themeID = $theme->ID;
            }
            if (!isset($row['activityinteratividade_id'])) {
                $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id'], 'oldIDFormat' => $row['activityformat_id']));
            } else {
                $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id'], 'oldIDFormat' => $row['activityformat_id'], 'oldIDInterative' => $row['activityinteratividade_id']));
            }
            $tmp->templateID = $template->ID;
            if (!$tmp->save()) {
                $this->elog('Atividade:', $row['id'], $tmp->errors);
            } else {
                $this->elog('Atividade:', $tmp->ID);
            }
            $c = new CobjectData();
            $c->cobjectID = $tmp->ID;
            $goal = ActGoal::model()->findByAttributes(array('oldID' => $row['goal_id']));
            if (!isset($goal)) {
                $c->goalID = "0";
            } else {
                $c->goalID = $goal->ID;
            }
        }


        //10) IMPORTAR AS SCREEN
        $sscreens = "select d.id,a.screen from layer_property a join piece c on(a.piece_id=c.id) join activity d on(c.activity_id=d.id) group by d.id,a.screen order by d.id";
        $reader = $this->search($sscreens);
        foreach ($reader as $row) {
            $tmp = new EditorScreen();
            $cobject = Cobject::model()->findByAttributes(array('oldID' => $row['id']));
            if (isset($cobject)) {
                $tmp->cobjectID = $cobject->ID;
                $tmp->number = $row['screen'];
                $tmp->order = $row['screen'];
                $tmp->width = '960';
                $tmp->height = '500';
                $tmp->oldID = '0';
                $tmp->save();
                $this->elog('Screen/Atividade:', $tmp->ID . '/' . $tmp->cobjectID);
            }
        }

        //11) IMPORTAR OS PIECESETS
        $spiecesets = "select a.id,activity_id,description,a.seq,screen,a.name_varchar from piece a join layer_property b on(a.id=b.piece_id) group by a.id,screen,activity_id,description,a.seq,a.name_varchar order by activity_id,screen";
        $reader = $this->search($spiecesets);
        foreach ($reader as $row) {
            $tmp = new EditorPieceset();
            $tmp->oldID = $row['id'];
            $tmp->typeID = 7;
            $tmp->desc = $row['description'];
            $tmp->save();
            $this->elog('Pieceset:', $tmp->ID);

            $cobject = Cobject::model()->findByAttributes(array('oldID' => $row['activity_id']));
            if (isset($cobject)) {
                $screen = EditorScreen::model()->findByAttributes(array('cobjectID' => $cobject->ID, 'order' => $row['screen']));
                $piecescreen = new EditorScreenPieceset();
                $piecescreen->piecesetID = $tmp->ID;
                $piecescreen->screenID = $screen->ID;
                $piecescreen->position = $row['seq'];
                
                $piecescreen->templateID = 26;
                $piecescreen->save();
                $this->elog('Pieceset/Screen:', $piecescreen->piecesetID . '/' . $piecescreen->screenID);
            }
        }

        //12) IMPORTAR OS PIECES
        $spiece = "select a.id,activity_id,description,a.seq,screen,a.name_varchar from piece a join layer_property b on(a.id=b.piece_id) group by a.id,screen,activity_id,description,a.seq,a.name_varchar order by activity_id,screen";
        $reader = $this->search($spiece);
        foreach ($reader as $row) {
            $tmp = new EditorPiece();
            $tmp->oldID = $row['id'];
            $tmp->typeID = 7;
            $tmp->name = $row['name_varchar'];
            $tmp->description = $row['description'];
            $tmp->save();
            $this->elog('Piece:', $tmp->ID);

            $pieceset = EditorPieceset::model()->findByAttributes(array('oldID' => $row['id']));
            if (isset($pieceset)) {
                $piecesetpiece = new EditorPiecesetPiece();
                $piecesetpiece->piecesetID = $pieceset->ID;
                $piecesetpiece->pieceID = $tmp->ID;
                $piecesetpiece->order = $row['seq'];
                $piecesetpiece->save();
                $this->elog('Pieceset/Piece:', $piecesetpiece->piecesetID . '/' . $piecesetpiece->pieceID);
            }
        }
        $sqlpiecelements = "select a.id,a.screen,a.piece_id,a.pos_x,a.pos_y,a.dim_x,a.dim_y,a.align,c.name as layertype,a.element_id as table_ref,a.piece_element_id,b.seq,(CASE WHEN b.media IS NULL OR b.media = '' THEN d.name ELSE b.media END) as table_source,b.media,d.name, 
          (CASE WHEN b.media IS NULL OR b.media = '' THEN (CASE WHEN d.name = 'image' THEN (select ('extension:'||extension||';'||dim_x||';'||b.name) from image a2 join style b on(b.id=a2.style) where a2.id=a.element_id) ELSE '2' END) ELSE (CASE WHEN b.media = 'image' THEN '1' ELSE '2' END) END)
          from layer_property a
          join piece_element b on(a.piece_element_id=b.id)
          join layertype c on(c.id=a.layertype_id)
          join elementtype d on(d.id=b.elementtype_id) order by table_source";
        $reader = $this->search($sqlpiecelements);
        foreach ($reader as $row) {
            $src = $row['table_source'];
            try {
                //@TODO definir com fabio e ver corretamente os agrupamentos
                $this->elog('Tipo:', $src . '(' . $row['table_source'] . ')');
                if ($src == 'morpheme') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'morpheme'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $subsql = "SELECT a.name,b.name as idiom FROM morpheme a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'text'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['name'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'language'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['idiom'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = 'morpheme';
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');
                    }
                } else if ($src == 'phrase') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'phrase'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $subsql = "SELECT a.name,b.name as idiom FROM phrase a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'text'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['name'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'language'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['idiom'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = 'phrase';
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');
                    }
                } else if ($src == 'paragraph') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'paragraph'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $subsql = "SELECT a.name,b.name as idiom FROM paragraph a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'text'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['name'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'language'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['idiom'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = 'paragraph';
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');
                    }
                } else if ($src == 'speech' || $src == 'word' || $src == 'compound') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'word'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $subsql = "SELECT a.name,b.name as idiom FROM word a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'text'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['name'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'language'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['idiom'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $src;
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');
                    }
                } else if ($src == 'number' || $src == 'equation') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'number'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $subsql = "SELECT * FROM number where id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'text'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $item['name'];
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $src;
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');
                    }
                } else if ($src == 'sound' || $src == 'phrase_sound' || $src == 'word_sound' || $src == 'number_sound' || $src == 'morpheme_sound' || $src == 'paragraph_sound') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'sound'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $property->ID;
                        $elementProperty->value = $src;
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $typeLib = CommonType::model()->findByAttributes(array('context' => 'library', 'name' => 'sound'));
                        $library = new Library();
                        $library->typeID = $typeLib->ID;
                        $library->save();

                        $propertyLibraryID = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'libraryID'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $propertyLibraryID->ID;
                        $elementProperty->value = $library->ID;
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');


                        $subsql = "SELECT * FROM sound where id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();


                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'extension'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['extension'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'src'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['id'] . '.' . $item['extension'];
                        $libraryProperty->save();
                    }
                } else if ($src == 'image') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'image'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $typeLib = CommonType::model()->findByAttributes(array('context' => 'library', 'name' => 'image'));
                        $library = new Library();
                        $library->typeID = $typeLib->ID;
                        $library->save();

                        $propertyLibraryID = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'libraryID'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $propertyLibraryID->ID;
                        $elementProperty->value = $library->ID;
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');

                        $subsql = "SELECT a.*,b.name as nstyle FROM image a left join style b on(b.id=a.style) where a.id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'extension'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['extension'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'width'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['dim_x'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'height'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['dim_y'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'color'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['color'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'content'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['content'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'nstyle'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['nstyle'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'src'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['id'] . '.' . $item['extension'];
                        $libraryProperty->save();
                    }
                } else if ($src == 'movie') {
                    $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => 'movie'));
                    $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'typeID' => $type->ID));
                    if (!isset($element)) {
                        $element = new EditorElement();
                        $element->typeID = $type->ID;
                        $element->oldID = $row['table_ref'];
                        $element->save();

                        $typeLib = CommonType::model()->findByAttributes(array('context' => 'library', 'name' => 'movie'));
                        $library = new Library();
                        $library->typeID = $typeLib->ID;
                        $library->save();

                        $propertyLibraryID = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'libraryID'));
                        $elementProperty = new EditorElementProperty();
                        $elementProperty->elementID = $element->ID;
                        $elementProperty->propertyID = $propertyLibraryID->ID;
                        $elementProperty->value = $library->ID;
                        $elementProperty->save();
                        $this->elog('ElementProperty:', $elementProperty->elementID . '[' . $elementProperty->propertyID . '/' . $elementProperty->value . ']');


                        $subsql = "SELECT * FROM movie where id='$row[table_ref]'";
                        $command = Yii::app()->db2->createCommand($subsql);
                        $command->execute();
                        $item = $command->queryRow();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'extension'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['extension'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'width'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['dim_x'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'height'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['dim_y'];
                        $libraryProperty->save();

                        $libraryProperty = new LibraryProperty();
                        $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'src'));
                        $libraryProperty->libraryID = $library->ID;
                        $libraryProperty->propertyID = $libproperty->ID;
                        $libraryProperty->value = $item['id'] . '.' . $item['extension'];
                        $libraryProperty->save();
                    }
                }

                $piece = EditorPiece::model()->findByAttributes(array('oldID' => $row['piece_id']));
                $piecelement = new EditorPieceElement();
                $piecelement->pieceID = @$piece->ID;
                $piecelement->elementID = @$element->ID;
                $piecelement->oldID = @$row['piece_element_id'];
                $piecelement->position = @$row['seq'];
                $piecelement->save();

                $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'posx'));
                $pceproperty = new EditorPieceelementProperty();
                $pceproperty->propertyID = $property->ID;
                $pceproperty->pieceElementID = $piecelement->ID;
                $pceproperty->value = $row['pos_x'];
                $pceproperty->save();

                $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'posy'));
                $pceproperty = new EditorPieceelementProperty();
                $pceproperty->propertyID = $property->ID;
                $pceproperty->pieceElementID = $piecelement->ID;
                $pceproperty->value = $row['pos_y'];
                $pceproperty->save();

                $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'width'));
                $pceproperty = new EditorPieceelementProperty();
                $pceproperty->propertyID = $property->ID;
                $pceproperty->pieceElementID = $piecelement->ID;
                $pceproperty->value = $row['dim_x'];
                $pceproperty->save();

                $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'height'));
                $pceproperty = new EditorPieceelementProperty();
                $pceproperty->propertyID = $property->ID;
                $pceproperty->pieceElementID = $piecelement->ID;
                $pceproperty->value = $row['dim_y'];
                $pceproperty->save();

                $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'align'));
                $pceproperty = new EditorPieceelementProperty();
                $pceproperty->propertyID = $property->ID;
                $pceproperty->pieceElementID = $piecelement->ID;
                $pceproperty->value = $row['align'];
                $pceproperty->save();

                $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'layertype'));
                $pceproperty = new EditorPieceelementProperty();
                $pceproperty->propertyID = $property->ID;
                $pceproperty->pieceElementID = $piecelement->ID;
                $pceproperty->value = $row['layertype'];
                $pceproperty->save();
            } catch (Exception $exc) {
                echo $exc->getMessage();
                exit();
            }
        }
        /* FIX SEQ
          $sql = "select a.piece_id,a.piece_element_id,a.activity_seq,b.seq from layer_property a
          join piece_element b on(a.piece_element_id=b.id)
          order by
          a.piece_id,b.seq,a.activity_seq";
          foreach ($reader as $row) {
          $row['piece_element_id'];
          $row['seq'];
          $element = EditorElement::model()->findByAttributes(array('oldID' => $row['piece_element_id']));
          $piece = EditorPiece::model()->findByAttributes(array('oldID' => $row['piece_id']));

          if (isset($piece) && isset($element)) {
          var_dump($piece->ID);var_dump($element->ID);var_dump($row['piece_element_id']);
          $piecelement = EditorPieceElement::model()->findByAttributes(array('pieceID' => $piece->ID, 'elementID' => $element->ID));
          if (isset($piecelement)) {
          try {
          $piecelement->order = $row['seq'];
          $piecelement->update(array('order'));
          } catch (Exception $exc) {
          echo $exc->getMessage();exit;
          }
          }
          }
          } */
        /* SELECT * FROM cobject_cobjectblock a
          join cobject b on(a.cobjectID=b.ID)
          join cobject_metadata c on(c.cobjectID=b.ID and c.typeID=6)
          join act_goal d on(d.ID=c.value)
          join act_goal_content e on(d.ID=e.goalID)
          join act_content f on(f.ID=e.contentID)
         */
        /* SELECT a.cobjectID,c.value as goalID,e.contentID FROM cobject_cobjectblock a
          join cobject_metadata c on(c.cobjectID=a.cobjectID and c.typeID=6)
          join act_goal_content e on(e.goalID=c.value)
          /*DELETE FROM `library_property`;
          DELETE FROM `library`;
          DELETE FROM `editor_pieceelement_property`;
          DELETE FROM `peformance_user`;
          DELETE FROM `editor_piece_element`;
          DELETE FROM `editor_element_property`;
          DELETE FROM `editor_element`; */
        //lavar mamadeira

        exit;
        //$this->render('index');
    }

}