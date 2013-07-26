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
        set_time_limit(0);
        header('Content-type: text/html; charset=utf-8');
        $this->import('disciplines');
        $this->import('templates');
        $this->import('themes');
        $this->import('skills');
        $this->import('degrees');
        $this->import('modalitys');
        $this->import('contents');
        $this->import('goals');
        $this->import('activities');
        $this->import('screens');
        $this->import('piecesets');
        $this->import('pieces');
        $this->import('elements');
        exit();
    }

    public function import($place = 'ALL') {
        switch ($place) {
            case 'disciplines':
                $reader = $this->search("SELECT * FROM discipline");
                foreach ($reader as $row) {
                    $d = new ActDiscipline();
                    $d->oldID = $row['id'];
                    $d->name = $row['name'];
                    $d->save();
                    $this->elog('DISCIPLINA', $d->name);
                }
                break;
            case 'templates':
                $stemplate = "select d.name,d.id as dOld,b.id as fOld,c.id iOld from activity a 
                            join activityformat b on(a.activityformat_id=b.id) 
                            join activityinteratividade c on(a.activityinteratividade_id=c.id) 
                            right join activitytemplate d on(a.activitytemplate_id=d.id) group by d.name,b.name,c.name,d.id,b.id,c.id
                            order by dold,fold,iold";
                $reader = $this->search($stemplate);
                foreach ($reader as $row) {
                    $interative = CommonType::model()->findByAttributes(array('oldID' => $row['iold'], 'context' => 'interative'));
                    $format = CommonType::model()->findByAttributes(array('oldID' => $row['fold'], 'context' => 'format'));
                    $tmp = new CobjectTemplate();
                    if (isset($format)) {
                        $tmp->format_type_id = $format->id;
                    }
                    if (isset($interative)) {
                        $tmp->interative_type_id = $interative->id;
                    }
                    $tmp->oldID = $row['dold'];
                    $tmp->oldIDFormat = $row['fold'];
                    $tmp->oldIDInterative = $row['iold'];
                    $tmp->name = $row['name'];
                    switch ($row['name']) {
                        case 'Multipla Escolha':
                            $tmp->code = 'MTE';
                            break;
                        case 'Texto':
                            $tmp->code = 'TXT';
                            break;
                        case 'Pergunta Resposta':
                            $tmp->code = 'PRE';
                            break;
                        case 'Associar Elementos':
                            $tmp->code = 'AEL';
                            break;
                        case 'Palavra Cruzada':
                            $tmp->code = 'PLC';
                            break;
                        case 'Diagrama':
                            $tmp->code = 'DIG';
                            break;
                        case 'Livre':
                            $tmp->code = 'LVR';
                            break;
                        case 'Questionario':
                            $tmp->code = 'FRM';
                            break;
                        case 'Produção':
                            $tmp->code = 'PDC';
                            break;
                        case 'Drag and Drop':
                            $tmp->code = 'DDROP';
                            break;
                        default:
                            break;
                    }
                    if (!$tmp->save()) {
                        $this->elog('Template', $row['name'], $tmp->errors);
                    } else {
                        $this->elog('Template', $tmp->name);
                    }
                }
                break;
            case 'themes':
                $reader = $this->search("SELECT * FROM semantic order by id");
                foreach ($reader as $row) {
                    $tmp = new CobjectTheme();
                    $tmp->oldID = $row['id'];
                    $tmp->name = $row['name_varchar'];
                    if (isset($row['father_id'])) {
                        $themef = CobjectTheme::model()->findByAttributes(array('oldID' => $row['father_id']));
                        if (isset($themef))
                            $tmp->parent_id = $themef->id;
                    }
                    if (!$tmp->save()) {
                        $this->elog('Temas', $row['name_varchar'], $tmp->errors);
                    } else {
                        $this->elog('Temas', $tmp->name);
                    }
                }
                break;
            case 'skills':
                $skills = "select * from activitycontent where type_id = '1' and (father_id = '11' or father_id ='16') and id <> '20' order by id";
                $reader = $this->search($skills);
                foreach ($reader as $row) {
                    $tmp = new ActSkill();
                    $tmp->oldID = $row['id'];
                    $tmp->name = $row['name_varchar'];
                    if ($row['father_id'] == '16') {
                        $father = ActSkill::model()->findByAttributes(array('oldID' => $row['father_id']));
                        $tmp->skill_parent = $father->id;
                    }
                    if (!$tmp->save()) {
                        $this->elog('Habilidade', $row['name_varchar'], $tmp->errors);
                    } else {
                        $this->elog('Habilidade', $tmp->name);
                    }
                }
                break;
            case 'degrees':
                $sdegree = "select  (c.name||' - '||b.name||' ANO') AS name,b.id,0 as parentID,b.grade AS year,c.grade AS stage,0 as grade from degreeblock b join degreestage c on(b.degreestage_id=c.id)
                UNION
                select  (c.name||' - '||b.name||' ANO'||'/'||a.name) AS name,a.id,b.id as parentID,b.grade AS year,c.grade AS stage,a.grade AS grade from degreegrade a join degreeblock b on(a.degreeblock_id=b.id) join degreestage c on(b.degreestage_id=c.id)
                order by parentid,stage,year,grade";
                $reader = $this->search($sdegree);
                foreach ($reader as $row) {
                    $tmp = new ActDegree();
                    $tmp->oldID = $row['id'];
                    $tmp->name = $row['name'];
                    if ($row['parentid'] != 0) {
                        $parent = ActDegree::model()->findByAttributes(array('oldID' => $row['parentid']));
                        $tmp->degree_parent = $parent->id;
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
                break;
            case 'modalitys':
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
                        $tmp->modality_parent = $parent->id;
                    }
                    if (!$tmp->save()) {
                        $this->elog('Modalidade', $row['name_varchar'], $tmp->errors);
                    } else {
                        $this->elog('Modalidade', $tmp->name);
                    }
                }
                break;
            case 'contents':
                $scontent = "select * from activitycontent a where type_id = '2' order by (coalesce(father_id,0))";
                $reader = $this->search($scontent);
                foreach ($reader as $row) {
                    $tmp = new ActContent();
                    $tmp->oldID = $row['id'];
                    $tmp->description = $row['name_varchar'];
                    $disc = ActDiscipline::model()->findByAttributes(array('oldID' => $row['discipline_id']));
                    $tmp->discipline_id = $disc->id;
                    if ($row['father_id'] != "NULL") {
                        $parent = ActContent::model()->findByAttributes(array('oldID' => $row['father_id']));
                        if (isset($parent)) {
                            $tmp->content_parent = $parent->id;
                        }
                    }
                    if (!$tmp->save()) {
                        $this->elog('Conteúdo', $row['id'], $tmp->errors);
                    } else {
                        $this->elog('Conteúdo', $tmp->description);
                    }
                }
                break;
            case 'goals':
                $sgoal = "select * from goal";
                $reader = $this->search($sgoal);
                foreach ($reader as $row) {
                    $disc = ActDiscipline::model()->findByAttributes(array('oldID' => $row['discipline_id']));
                    $degree = ActDegree::model()->findByAttributes(array('oldID' => $row['degreegrade_id']), 'grade <> 0');
                    $tmp = new ActGoal();
                    $tmp->oldID = $row['id'];
                    $tmp->name = $row['description'] . $row['description2'];
                    $tmp->discipline_id = $disc->id;
                    $tmp->degree_id = $degree->id;
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
                            $scontent->content_id = $content->id;
                            $scontent->goal_id = $tmp->id;
                            $scontent->save();
                            $this->elog('Conteúdo/Objetivo:', $scontent->content_id . '/' . $scontent->goal_id);
                        }
                        if (isset($modality)) {
                            $smodality = new ActGoalModality();
                            $smodality->modality_id = $modality->id;
                            $smodality->goal_id = $tmp->id;
                            $smodality->save();
                            $this->elog('Modalidade/Objetivo:', $smodality->modality_id . '/' . $scontent->goal_id);
                        }
                        if (isset($skill)) {
                            $sskill = new ActGoalSkill();
                            $sskill->skill_id = $skill->id;
                            $sskill->goal_id = $tmp->id;
                            $sskill->save();
                            $this->elog('Habilidade/Objetivo:', $sskill->skill_id . '/' . $sskill->goal_id);
                        }
                    }
                }
                break;
            case 'activities':
                $sqlacts = "select * from activity";
                $reader = $this->search($sqlacts);
                foreach ($reader as $row) {
                    if (!isset($row['activitytype_id'])) {
                        $row['activitytype_id'] = 4;
                    }
                    $type = CommonType::model()->findByAttributes(array('oldID' => $row['activitytype_id'], 'context' => 'Cobject'));
                    $tmp = new Cobject();
                    $tmp->oldID = $row['id'];
                    $tmp->type_id = $type->id;
                    if ($row['status'] == '1') {
                        $tmp->status = 'on';
                    }
                    $theme = CobjectTheme::model()->findByAttributes(array('oldID' => $row['semantic_id']));
                    if (!isset($theme)) {
                        $theme = CobjectTheme::model()->findByAttributes(array('oldID' => 1));
                    }
                    $tmp->theme_id = $theme->id;

                    if (!isset($row['activitytemplate_id'])) {
                        $template = CobjectTemplate::model()->findByAttributes(array('code' => 'NONE'));
                    } else {
                        if (!isset($row['activityformat_id']) && isset($row['activityinteratividade_id'])) {
                            $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id'], 'oldIDInterative' => $row['activityinteratividade_id']));
                        } else if (!isset($row['activityinteratividade_id']) && isset($row['activityformat_id'])) {
                            $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id'], 'oldIDFormat' => $row['activityformat_id']));
                        } else if (!isset($row['activityinteratividade_id']) && !isset($row['activityformat_id'])) {
                            $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id']));
                        } else {
                            $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id'], 'oldIDFormat' => $row['activityformat_id'], 'oldIDInterative' => $row['activityinteratividade_id']));
                        }
                    }
                    if (!isset($template)) {
                        $template = CobjectTemplate::model()->findByAttributes(array('oldID' => $row['activitytemplate_id']));
                    }
                    $tmp->template_id = $template->id;
                    if (!$tmp->save()) {
                        $this->elog('Atividade:', $row['id'], $tmp->errors);
                        exit;
                    } else {
                        $this->elog('Atividade:', $tmp->id);
                    }
                    $c = new CobjectData();
                    $c->cobject_id = $tmp->id;
                    $goal = ActGoal::model()->findByAttributes(array('oldID' => $row['goal_id']));
                    if (isset($goal)) {
                        $c->goal_id = $goal->id;
                        $this->elog('Goal/Atividade:', $goal->id . '/' . $tmp->id);
                    }
                }
                break;
            case 'screens':
                $sscreens = "select d.id,a.screen from layer_property a join piece c on(a.piece_id=c.id) join activity d on(c.activity_id=d.id) group by d.id,a.screen order by d.id";
                $reader = $this->search($sscreens);
                foreach ($reader as $row) {
                    $tmp = new EditorScreen();
                    $cobject = Cobject::model()->findByAttributes(array('oldID' => $row['id']));
                    if (isset($cobject)) {
                        $tmp->cobject_id = $cobject->id;
                        $tmp->order = $row['screen'];
                        $tmp->oldID = '0';
                        $tmp->save();
                        $this->elog('Screen/Atividade:', $tmp->id . '/' . $tmp->cobject_id);
                    }
                }
                break;
            case 'piecesets':
                $spiecesets = "select a.id,activity_id,description,a.seq,screen,a.name_varchar from piece a join layer_property b on(a.id=b.piece_id) group by a.id,screen,activity_id,description,a.seq,a.name_varchar order by activity_id,screen";
                $reader = $this->search($spiecesets);
                foreach ($reader as $row) {
                    $cobject = Cobject::model()->findByAttributes(array('oldID' => $row['activity_id']));
                    $tmp = new EditorPieceset();
                    $tmp->oldID = $row['id'];
                    $tmp->template_id = $cobject->template_id;
                    $tmp->description = $row['description'];
                    $tmp->save();
                    $this->elog('Pieceset:', $tmp->id);


                    if (isset($cobject)) {
                        $screen = EditorScreen::model()->findByAttributes(array('cobject_id' => $cobject->id, 'order' => $row['screen']));
                        $piecescreen = new EditorScreenPieceset();
                        $piecescreen->pieceset_id = $tmp->id;
                        $piecescreen->screen_id = $screen->id;
                        $piecescreen->order = $row['seq'];
                        $piecescreen->save();
                        $this->elog('Pieceset/Screen:', $piecescreen->pieceset_id . '/' . $piecescreen->screen_id);
                    }
                }
                break;
            case 'pieces':
                $spiece = "select a.id,activity_id,description,a.seq,screen,a.name_varchar from piece a join layer_property b on(a.id=b.piece_id) group by a.id,screen,activity_id,description,a.seq,a.name_varchar order by activity_id,screen";
                $reader = $this->search($spiece);
                foreach ($reader as $row) {
                    $tmp = new EditorPiece();
                    $tmp->oldID = $row['id'];
                    $tmp->name = $row['name_varchar'];
                    $tmp->description = $row['description'];
                    $tmp->save();
                    $this->elog('Piece:', $tmp->id);

                    $pieceset = EditorPieceset::model()->findByAttributes(array('oldID' => $row['id']));
                    if (isset($pieceset)) {
                        $piecesetpiece = new EditorPiecesetPiece();
                        $piecesetpiece->pieceset_id = $pieceset->id;
                        $piecesetpiece->piece_id = $tmp->id;
                        $piecesetpiece->order = $row['seq'];
                        $piecesetpiece->save();
                        $this->elog('Pieceset/Piece:', $piecesetpiece->pieceset_id . '/' . $piecesetpiece->piece_id);
                    }
                }
                break;
            case 'elements':
                $sqlpiecelements = "select a.grouping,a.activity_seq,a.option_seq,a.value,d.name as classification,a.id,a.screen,a.piece_id,a.pos_x,a.pos_y,a.dim_x,a.dim_y,a.align,c.name as layertype,a.element_id as table_ref,a.piece_element_id,b.seq,(CASE WHEN b.media IS NULL OR b.media = '' THEN d.name ELSE b.media END) as table_source,b.media,d.name,
                                    (CASE WHEN b.media IS NULL OR b.media = '' THEN (CASE WHEN d.name = 'image' THEN (select ('extension:'||extension||';'||dim_x||';'||b.name) from image a2 join style b on(b.id=a2.style) where a2.id=a.element_id) ELSE '2' END) ELSE (CASE WHEN b.media = 'image' THEN '1' ELSE '2' END) END)
                                    from layer_property a
                                    join piece_element b on(a.piece_element_id=b.id)
                                    join layertype c on(c.id=a.layertype_id)
                                    join elementtype d on(d.id=b.elementtype_id) order by table_source";
                $reader = $this->search($sqlpiecelements);
                foreach ($reader as $row) {
                    $src = $row['table_source'];
                    try {
                        if ($src == 'sound' || $src == 'phrase_sound' || $src == 'word_sound' || $src == 'number_sound' || $src == 'morpheme_sound' || $src == 'paragraph_sound') {
                            $src = 'sound';
                        }
                        if ($src == 'sound' || $src == 'movie' || $src == 'image') {
                            $type_element = 'multimidia';
                        } else {
                            $type_element = $src;
                        }
                        $this->elog('Tipo:', $src . '(' . $row['table_source'] . ')');
                        $type = CommonType::model()->findByAttributes(array('context' => 'element', 'name' => $type_element));
                        $element = EditorElement::model()->findByAttributes(array('oldID' => $row['table_ref'], 'type_id' => $type->id));
                        if (!isset($element)) {
                            $element = new EditorElement();
                            $element->type_id = $type->id;
                            $element->oldID = $row['table_ref'];
                            $element->save();
                        }
                        switch ($src) {
                            case 'morpheme':
                                $subsql = "SELECT a.name,b.name as idiom FROM morpheme a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                                break;
                            case 'phrase':
                                $subsql = "SELECT a.*,b.name as idiom FROM phrase a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();
                                if (isset($item['function_id'])) {
                                    $content = ActContent::model()->findByAttributes(array('oldID' => $item['function_id']));
                                    if (isset($content)) {
                                        $property = CommonProperty::model()->findByAttributes(array('context' => 'phrase', 'name' => 'content'));
                                        $elementProperty = new EditorElementProperty();
                                        $elementProperty->element_id = $element->id;
                                        $elementProperty->property_id = $property->id;
                                        $elementProperty->value = $content->id;
                                        $elementProperty->save();
                                    }
                                }
                                if (isset($item['semantic_id'])) {
                                    $theme = CobjectTheme::model()->findByAttributes(array('oldID' => $item['semantic_id']));
                                    if (isset($theme)) {
                                        $property = CommonProperty::model()->findByAttributes(array('context' => 'phrase', 'name' => 'theme'));
                                        $elementProperty = new EditorElementProperty();
                                        $elementProperty->element_id = $element->id;
                                        $elementProperty->property_id = $property->id;
                                        $elementProperty->value = $theme->id;
                                        $elementProperty->save();
                                    }
                                }
                                break;
                            case 'paragraph':
                                $subsql = "SELECT a.*,b.name as idiom FROM paragraph a left join idiom b on(a.idiom_id=b.id) where a.id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();
                                if (isset($item['semantic_id'])) {
                                    $theme = CobjectTheme::model()->findByAttributes(array('oldID' => $item['semantic_id']));
                                    if (isset($theme)) {
                                        $property = CommonProperty::model()->findByAttributes(array('context' => 'paragraph', 'name' => 'theme'));
                                        $elementProperty = new EditorElementProperty();
                                        $elementProperty->element_id = $element->id;
                                        $elementProperty->property_id = $property->id;
                                        $elementProperty->value = $theme->id;
                                        $elementProperty->save();
                                    }
                                }
                                break;
                            case 'speech':
                                $subsql = "SELECT a.*,c.name as wordrootname,b.name as idiom FROM word a left join idiom b on(a.idiom_id=b.id) left join wordroot c on(a.wordroot1_id=c.id) where a.id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();

                                if (isset($item['content_id'])) {
                                    $content = ActContent::model()->findByAttributes(array('oldID' => $item['content_id']));
                                    if (isset($content)) {
                                        $property = CommonProperty::model()->findByAttributes(array('context' => 'speech', 'name' => 'content'));
                                        $elementProperty = new EditorElementProperty();
                                        $elementProperty->element_id = $element->id;
                                        $elementProperty->property_id = $property->id;
                                        $elementProperty->value = $theme->id;
                                        $elementProperty->save();
                                    }
                                }

                                if (isset($item['description'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'speech', 'name' => 'description'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['description'];
                                    $elementProperty->save();
                                }

                                if (isset($item['rootdescription'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'speech', 'name' => 'rootdescription'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['rootdescription'];
                                    $elementProperty->save();
                                }

                                if (isset($item['wordrootname'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'speech', 'name' => 'wordroot'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['wordrootname'];
                                    $elementProperty->save();
                                }
                                break;
                            case 'word':
                                $subsql = "SELECT a.*,c.name as wordrootname,b.name as idiom FROM word a left join idiom b on(a.idiom_id=b.id) left join wordroot c on(a.wordroot1_id=c.id) where a.id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();

                                if (isset($item['content_id'])) {
                                    $content = ActContent::model()->findByAttributes(array('oldID' => $item['content_id']));
                                    if (isset($content)) {
                                        $property = CommonProperty::model()->findByAttributes(array('context' => 'word', 'name' => 'content'));
                                        $elementProperty = new EditorElementProperty();
                                        $elementProperty->element_id = $element->id;
                                        $elementProperty->property_id = $property->id;
                                        $elementProperty->value = $theme->id;
                                        $elementProperty->save();
                                    }
                                }

                                if (isset($item['description'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'word', 'name' => 'description'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['description'];
                                    $elementProperty->save();
                                }

                                if (isset($item['rootdescription'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'word', 'name' => 'rootdescription'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['rootdescription'];
                                    $elementProperty->save();
                                }

                                if (isset($item['wordrootname'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'word', 'name' => 'wordroot'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['wordrootname'];
                                    $elementProperty->save();
                                }
                                break;
                            case 'compound':
                                $subsql = "SELECT a.*,c.name as wordrootname,b.name as idiom FROM word a left join idiom b on(a.idiom_id=b.id) left join wordroot c on(a.wordroot1_id=c.id) where a.id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();

                                if (isset($item['content_id'])) {
                                    $content = ActContent::model()->findByAttributes(array('oldID' => $item['content_id']));
                                    if (isset($content)) {
                                        $property = CommonProperty::model()->findByAttributes(array('context' => 'compound', 'name' => 'content'));
                                        $elementProperty = new EditorElementProperty();
                                        $elementProperty->element_id = $element->id;
                                        $elementProperty->property_id = $property->id;
                                        $elementProperty->value = $content->id;
                                        $elementProperty->save();
                                    }
                                }

                                if (isset($item['description'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'compound', 'name' => 'description'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['description'];
                                    $elementProperty->save();
                                }

                                if (isset($item['rootdescription'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'compound', 'name' => 'rootdescription'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['rootdescription'];
                                    $elementProperty->save();
                                }

                                if (isset($item['wordrootname'])) {
                                    $property = CommonProperty::model()->findByAttributes(array('context' => 'compound', 'name' => 'wordroot'));
                                    $elementProperty = new EditorElementProperty();
                                    $elementProperty->element_id = $element->id;
                                    $elementProperty->property_id = $property->id;
                                    $elementProperty->value = $item['wordrootname'];
                                    $elementProperty->save();
                                }
                                break;
                            case 'number':
                                $subsql = "SELECT * FROM number where id='$row[table_ref]'";
                                break;
                            case 'equation':
                                $subsql = "SELECT * FROM number where id='$row[table_ref]'";
                                break;
                            case 'sound':
                                $subsql = "SELECT * FROM sound where id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();

                                $typeLib = CommonType::model()->findByAttributes(array('context' => 'library', 'name' => 'sound'));
                                $library = new Library();
                                $library->type_id = $typeLib->id;
                                $library->save();
                                break;
                            case 'image':
                                $typeLib = CommonType::model()->findByAttributes(array('context' => 'library', 'name' => 'image'));
                                $library = new Library();
                                $library->type_id = $typeLib->id;
                                $library->save();

                                $subsql = "SELECT a.*,b.name as nstyle FROM image a left join style b on(b.id=a.style) where a.id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'image', 'name' => 'width'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['dim_x'];
                                $libraryProperty->save();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'image', 'name' => 'height'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['dim_y'];
                                $libraryProperty->save();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'image', 'name' => 'color'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['color'];
                                $libraryProperty->save();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'image', 'name' => 'content'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['content'];
                                $libraryProperty->save();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'image', 'name' => 'nstyle'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['nstyle'];
                                $libraryProperty->save();

                                break;
                            case 'movie':
                                $typeLib = CommonType::model()->findByAttributes(array('context' => 'library', 'name' => 'movie'));
                                $library = new Library();
                                $library->type_id = $typeLib->id;
                                $library->save();

                                $subsql = "SELECT * FROM movie where id='$row[table_ref]'";
                                $command = Yii::app()->db2->createCommand($subsql);
                                $command->execute();
                                $item = $command->queryRow();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'movie', 'name' => 'width'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['dim_x'];
                                $libraryProperty->save();

                                $libraryProperty = new LibraryProperty();
                                $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'movie', 'name' => 'height'));
                                $libraryProperty->library_id = $library->id;
                                $libraryProperty->property_id = $libproperty->id;
                                $libraryProperty->value = $item['dim_y'];
                                $libraryProperty->save();
                                break;

                            default:
                                break;
                        }
                        if ($row['classification'] != 'NULL') {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'classification'));
                            $elementProperty = new EditorElementProperty();
                            $elementProperty->element_id = $element->id;
                            $elementProperty->property_id = $property->id;
                            $elementProperty->value = $row['classification'];
                            $elementProperty->save();
                        }
                        if ($type_element != 'multimidia') {
                            $command = Yii::app()->db2->createCommand($subsql);
                            $command->execute();
                            $item = $command->queryRow();

                            $property = CommonProperty::model()->findByAttributes(array('context' => $src, 'name' => 'text'));
                            $elementProperty = new EditorElementProperty();
                            $elementProperty->element_id = $element->id;
                            $elementProperty->property_id = $property->id;
                            $elementProperty->value = $item['name'];
                            $elementProperty->save();
                        } else {
                            $propertyLibraryID = CommonProperty::model()->findByAttributes(array('context' => 'multimidia', 'name' => 'library_id'));
                            $elementProperty = new EditorElementProperty();
                            $elementProperty->element_id = $element->id;
                            $elementProperty->property_id = $propertyLibraryID->id;
                            $elementProperty->value = $library->id;
                            $elementProperty->save();

                            $libraryProperty = new LibraryProperty();
                            $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'extension'));
                            $libraryProperty->library_id = $library->id;
                            $libraryProperty->property_id = $libproperty->id;
                            $libraryProperty->value = $item['extension'];
                            $libraryProperty->save();

                            $libraryProperty = new LibraryProperty();
                            $libproperty = CommonProperty::model()->findByAttributes(array('context' => 'library', 'name' => 'src'));
                            $libraryProperty->library_id = $library->id;
                            $libraryProperty->property_id = $libproperty->id;
                            $libraryProperty->value = $item['id'] . '.' . $item['extension'];
                            $libraryProperty->save();
                        }
                        if (isset($item['idiom'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'element', 'name' => 'language'));
                            $elementProperty = new EditorElementProperty();
                            $elementProperty->element_id = $element->id;
                            $elementProperty->property_id = $property->id;
                            $elementProperty->value = $item['idiom'];
                            $elementProperty->save();
                        }
                        $piece = EditorPiece::model()->findByAttributes(array('oldID' => $row['piece_id']));
                        $piecelement = new EditorPieceElement();
                        $piecelement->piece_id = @$piece->id;
                        $piecelement->element_id = @$element->id;
                        $piecelement->oldID = @$row['piece_element_id'];
                        $piecelement->order = @$row['seq'];
                        $piecelement->save();

                        if (isset($row['pos_x'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'posx'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['pos_x'];
                            $pceproperty->save();
                        }
                        if (isset($row['pos_y'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'posy'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['pos_y'];
                            $pceproperty->save();
                        }
                        if (isset($row['dim_x'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'width'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['dim_x'];
                            $pceproperty->save();
                        }
                        if (isset($row['dim_y'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'height'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['dim_y'];
                            $pceproperty->save();
                        }
                        if (isset($row['align'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'align'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['align'];
                            $pceproperty->save();
                        }
                        if (isset($row['layertype'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'layertype'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['layertype'];
                            $pceproperty->save();
                        }
                        if (isset($row['grouping'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'grouping'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['grouping'];
                            $pceproperty->save();
                        }
                        if (isset($row['option_seq'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'option_seq'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['option_seq'];
                            $pceproperty->save();
                        }
                        if (isset($row['activity_seq'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'activity_seq'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['activity_seq'];
                            $pceproperty->save();
                        }
                        if (isset($row['value'])) {
                            $property = CommonProperty::model()->findByAttributes(array('context' => 'piecelement', 'name' => 'value'));
                            $pceproperty = new EditorPieceelementProperty();
                            $pceproperty->property_id = $property->id;
                            $pceproperty->piece_element_id = $piecelement->id;
                            $pceproperty->value = $row['value'];
                            $pceproperty->save();
                        }
                    } catch (Exception $exc) {
                        echo $exc->getMessage();
                        exit();
                    }
                }
                break;
            default:
                break;
        }
    }

    //exit();
    //7)IMPORTAR OS CONTEÚDOS.
    //8) IMPORTAR OS OBJETIVOS.
    //9) IMPORTAR AS ATIVIDADES;
    //10) IMPORTAR AS SCREEN
    //@TODO INCLUIR CAMPO DE SCREEN NA PIECE.
    //11) IMPORTAR OS PIECESETS
    //12) IMPORTAR OS PIECES


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
      }
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
    // exit;
    //$this->render('index');
    //}
}