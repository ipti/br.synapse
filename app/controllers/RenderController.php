<?php

class RenderController extends Controller {

    public $layout = 'cbjrender';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function elog($text) {
        $this->http_response_code(200);
        echo json_encode($text);
        flush();
        ob_flush();
    }

    public function actionListcobjects() {
        $content_parent = 19;
        $contentsIn = "282,281";
        $contentOut = "277,275";
        $join = "";
        $sql = "select distinct(id) from cobject where status='on'";
        /* $sql = "select  distinct(a2.cobject_id)
          from cobject a1
          join cobject_metadata a2 on(a1.id=a2.cobject_id and a2.type_id=13)
          join act_goal a3 on(a3.id=a2.value)
          join act_goal_content a4 on(a3.id=a4.goal_id)
          join act_content a6 on(a6.id=a4.content_id)";
          $where = " where a6.content_parent=19 and (a6.id in($contentsIn) or a6.id not in($contentOut));";
          if (isset($modality)) {
          $join.= " left join act_goal_modality a5 on(a3.id=a5.goal_id)";
          $where.="";
          }
          if (isset($degree)) {
          $join .= " left join act_degree a14 on(a14.id=a3.degree_id)";
          $where .="";
          }
          if (isset($content)) {
          $where .="";
          } */
        $command = Yii::app()->db->createCommand($sql . $join . $where);
        $command->execute();
        $reader = $command->queryAll();
        echo json_encode($reader);
        exit;
    }

    public function actionLoadcobject() {
        $cobject_id = $_REQUEST['ID'];
        $sql = "SELECT * from render_cobjects where cobject_id = $cobject_id;";
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $row = $command->queryRow();
        $json = $row;
        $cobject = Cobject::model()->findByPk($row['cobject_id']);
        $a5 = $a2 = $a3 = -1;
        if (isset($cobject->editorScreens)) {
            foreach ($cobject->editorScreens as $screen) {
                $a2++;
                $json['screens'][$a2] = $screen->attributes;
                $a3 = -1;
                foreach ($screen->editorScreenPiecesets as $pieceset) {
                    if ($cobject->template->code != 'AEL') {
                        $a3++;
                    }
                    $json['screens'][$a2]['piecesets'][$a3]['id'] = $pieceset->pieceset->id;
                    $json['screens'][$a2]['piecesets'][$a3]['template_code'] = $pieceset->pieceset->template->code;
                    $a4 = -1;
                    foreach ($pieceset->pieceset->editorPiecesetPieces as $piece) {
                        $a4++;
                        $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['id'] = $piece->piece->id;
                        $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['name'] = $piece->piece->name;
                        $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['description'] = $piece->piece->description;
                        if ($cobject->template->code != 'AEL') {
                            $a5 = -1;
                        }
                        foreach ($piece->piece->editorPieceElements as $element) {
                            $a5++;
                            $properties = $events = $gproperties = array();
                            foreach ($element->editorPieceelementProperties as $property) {
                                $properties[] = array('name' => $property->property->name, 'value' => $property->value);
                            }
                            if ($cobject->template->code == 'AEL') {
                                $properties[] = array('name' => 'group', 'value' => $piece->piece->id);
                            }
                            foreach ($element->editorEvents as $event) {
                                $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
                            }
                            foreach ($element->element->editorElementProperties as $gproperty) {
                                $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
                                if ($gproperty->property->name == 'library_id') {
                                    $libid = $gproperty->value;
                                }
                            }
                            if ($element->element->type->name == 'multimidia') {
                                $lib = Library::model()->findByAttributes(array('id' => $libid));
                                foreach ($lib->libraryProperties as $libproperty) {
                                    $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                                };
                                $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['typemulti'] = $lib->type->name;
                            }

                            foreach ($element->element->editorElementAliases as $alias) {
                                $gproperties[] = array('type' => $alias->type->name, 'value' => $gproperty->value);
                            }

                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['code'] = 'EP' . $element->id;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['elementProperties'] = $properties;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['elementProperties'] = $properties;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['events'] = $events;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['generalProperties'] = $gproperties;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['elements'][$a5]['type'] = $element->element->type->name;
                        }
                    }
                }
            }
            echo json_encode($json);
        } else {
            $json['cobject'] = $cobject_id;
            echo json_encode($json);
        }
        exit;
    }

    public function actionLoadcobjects() {
        set_time_limit(0);
        //header('Content-type: application/json');
        //header('Content-type: text/html; charset=utf-8');
        //header('Cache-Control: no-cache, must-revalidate');
        // header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        //header('Content-type: application/json');

        ;
        $reader = $command->query();
        $ocobject_id = -1;
        $json = array();
        $a1 = -1;
        foreach ($reader as $row) {
            if ($ocobject_id != $row['cobject_id']) {
                
            }
            $ocobject_id = $row['cobject_id'];
        }

        exit;
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('listcobjects', 'compute', 'loadcobject', 'stage', 'index', 'view', 'create', 'update', 'json', 'mount', 'login', 'logout', 'filter', 'loadcobjects', 'canvas', 'testepreview'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        if (Yii::app()->session['personage'] == "Tutor") {
            $this->redirect("/render/filter");
        } else {
            $this->redirect("/render/canvas");
        }
    }

    public function actionTestepreview() {
        $this->render("testepreview");
    }

//    public function actionLogout() {
//        Yii::app()->user->clearStates();
//        Yii::app()->user->logout();
//        $this->redirect("/render/login");
//    }
//    public function actionAuthentic() {
////$this->render('login');
//        if (isset($_POST['Person'])) {
//            $model->attributes = $_POST['Person'];
//            if ($model->save())
//                $this->redirect(array('view', 'id' => $model->ID));
//        }
//    }


    public function actionFilter() {
        $this->render('filter');
    }

    public function actionCanvas() {
        $this->render('canvas');
    }

    public function actionCompute() {
        $perf = new PeformanceActor();
        $data['piece_id'] = $_REQUEST['pieceID'];
        $data['piece_element_id'] = $_REQUEST['elementID'];
        $data['actor_id'] = $_REQUEST['actorID'];
        $data['final_time'] = $_REQUEST['finalTime'];
        $data['start_time'] = $_REQUEST['startTime'];
        $data['value'] = $_REQUEST['value'];
        $data['iscorrect'] = $_REQUEST['isCorrect'];
        $perf->setAttributes($data);
        $perf->save();
    }

    public function actionStage() {
        $cobject_id = @$_REQUEST['id'];
        $script = @$_REQUEST['scriptID'];
        $modality = @$_REQUEST['modality'];
        $degree = @$_REQUEST['degree'];
        $content = @$_REQUEST['content'];
        $actor = @$_REQUEST['actor'];
        $script = ActScript::model()->findByPk($script);
        $content_parent = $script->father_content;
        foreach ($script->actScriptContents as $content) {
            if ($content->status == 'in') {
                $contentsIn[] = $content->content_id;
            } else {
                $contentOut[] = $content->content_id;
            }
        }
        if (isset($contentsIn)) {
            $contentsIn = implode(",", $contentsIn);
        }
        if (isset($contentOut)) {
            $contentOut = implode(",", $contentOut);
        }
        $join = "";
        //$sql = "select distinct(cobject_id) as id from render_cobjects where template_code = 'PRE' and status='on'";
        $sql = "select  distinct(a1.id)
          from cobject a1
          join cobject_metadata a2 on(a1.id=a2.cobject_id and a2.type_id=13)
          join act_goal a3 on(a3.id=a2.value)
          join act_goal_content a4 on(a3.id=a4.goal_id)
          join act_content a6 on(a6.id=a4.content_id)";
        $where = " where a6.id=$content_parent";
        if (isset($contentsIn) && isset($contentOut)) {
            $where.= " and (a6.id in($contentsIn) or a6.id not in($contentOut))";
        } else if (isset($contentsIn) && !isset($contentOut)) {
            $where.= " and (a6.id in($contentsIn))";
        } else if (isset($contentOut) && !isset($contentsIn)) {
            $where.= " and (a6.id not in($contentOut))";
        }

        if (isset($modality)) {
            $join.= " left join act_goal_modality a5 on(a3.id=a5.goal_id)";
            $where.="";
        }
        if (isset($degree)) {
            $join .= " left join act_degree a14 on(a14.id=a3.degree_id)";
            $where .="";
        }
        if (isset($content)) {
            $where .="";
        }
        $fsql = $sql . $join . $where . "";
        $command = Yii::app()->db->createCommand($fsql);
        $command->execute();
        $reader = $command->queryAll();
        $json['ids'] = $reader;
        $json['size'] = count($reader);
        $json['pctitem'] = round(100 / count($reader), 1);
        $json = json_encode($json);
        $this->render('stage', array('json' => $json));
    }

    public function actionJson() {
        set_time_limit(0);
        if (isset($_POST['op']) &&
                ( $_POST['op'] == 'select' || $_POST['op'] == 'classes')) {
            $json = array();

            $id = isset($_POST["id"]) ? (int) $_POST["id"] : die('ERRO: id não recebido');

            $sql = "SELECT ut.primary_unity_id, ut.secondary_unity_id, u.name, ut.primary_organization_id, 
                            ut.secondary_organization_id, ou.orglevel 
                    from unity_tree ut
                    inner join organization ou
                    on ou.id = ut.secondary_organization_id
                    inner join organization o
                    on o.id = ut.primary_organization_id
                    inner join unity u
                    on u.id = ut.secondary_unity_id
                    where ut.primary_unity_id = $id ";
            $sql .= $_POST['op'] == 'select' ? "AND ou.orglevel = o.orglevel+1;" : "AND ou.orglevel = -1;";
            $unitys = Yii::app()->db->createCommand($sql)->queryAll();
            $json['sql'] = $sql;
            $_POST['op'] == 'select' ? $json['unitys'] = $unitys : $json['classes'] = $unitys;
            $json['fatherID'] = $id;
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
            exit;
        } elseif (isset($_POST['op']) and $_POST['op'] == 'actors') {
            $json = array();
            $id = isset($_POST["id"]) ? (int) $_POST["id"] : die('ERRO: id não recebido');

            $sql = "SELECT a.id actor_id, p.name 
                    FROM synapse.actor a
                    inner join person p
                    on p.id = a.person_id
                    where a.unity_id = $id;";
            $actors = Yii::app()->db->createCommand($sql)->queryAll();

            $json['actors'] = $actors;

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
            exit;
        } elseif (isset($_POST['op']) && $_POST['op'] == 'start') {
            $json = array();
            $disciplines = ActDiscipline::model()->findAll();
//$classes = Userclass::model()->findAll();
            $themes = CobjectTheme::model()->findAll();
            $levels = ActDegree::model()->findAllByAttributes(array(), "grade !=0");

            $a = -1;
            foreach ($disciplines as $discipline) {
                $a++;
                $json['disciplines'][$a] = $discipline->attributes;
                $scripts = ActScript::model()->findAllByAttributes(array('discipline_id' => $discipline->id));
                $blocks = Cobjectblock::model()->findAllByAttributes(array('discipline_id' => $discipline->id));
                $rscript = $rblock = array();
                $b = $c = -1;
                foreach ($scripts as $script) {
                    $b++;
                    $rscript[$b] = $script->attributes;
                    $rscript[$b]['name'] = $script->fatherContent->description;
                }
                foreach ($blocks as $block) {
                    $c++;
                    $rblock[$c] = $block->attributes;
                }
                $json['disciplines'][$a]['scripts'] = @$rscript;
                $json['disciplines'][$a]['blocks'] = @$rblock;
            }
            $aa = -1;
            /* foreach ($classes as $class) {
              $students = UserUserclass::model()->findAllByAttributes(array('classID' => $class->ID));
              $rstudents = array();
              foreach ($students as $student) {
              $rstudents[] = $student->user->attributes;
              }
              $aa++;
              $tutors[1]['name'] = 'Fabio Theoto Rocha';
              $tutors[1]['ID'] = 1;
              $json['classes'][$aa] = $class->attributes;
              $json['classes'][$aa]['students'] = @$rstudents;
              $json['classes'][$aa]['tutors'] = @$tutors;
              } */
            foreach ($themes as $theme) {
                $json['themes'][] = $theme->attributes;
            }
            foreach ($levels as $level) {
                $json['levels'][] = $level->attributes;
            }
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
            exit;
        } elseif (isset($_POST['op']) && $_POST['op'] == 'answer') {
            $pieceID = str_replace("PIECE", '', $_POST['pieceID']);
            $elementID = str_replace("EP", '', $_POST['elementID']);
            $userID = $_POST['userID'];
            $value = $_POST['value'];
            $peformance = new PeformanceUser();
            $peformance->userID = $userID;
            $peformance->pieceElementID = $elementID;
            $peformance->pieceID = $pieceID;
            $peformance->value = $value;
            $peformance->iscorrect = 1;
            $peformance->save();
            exit();
        } elseif (!isset($_POST['op'])) {
            die("ERRO: op nulo.");
        }
        $json = array();
        $actorID = $_POST['actorID'];
        $classID = $_POST['classID'];
        //$typeID = $_POST['typeID'];
        $typeID = "rscript";
        $actor = Actor::model()->findByPk($actorID);
        $json['actorID'] = $actorID;
        $json['userName'] = $actor->person->name;
        $json['classID'] = $classID;
        if ($typeID == 'rscript') {

            $script = ActScript::model()->findByAttributes(array('ID' => $_POST['script']));
            $contents = ActContent::model()->findAllByAttributes(array('contentParent' => $script->contentParentID));
            //$contents = ActContent::model()->findAll();
//@todo lembra de excluir os conteudos exclude e include    
            $x = -1;
            foreach ($contents as $content) {
                $x++;
                $json['contents'][$x] = $content->attributes;
                $type = CommonType::model()->findByAttributes(array('name' => 'goalID'));
                $y = -1;
                foreach ($content->actGoalContents as $goal) {
                    $y++;
                    $json['contents'][$x]['goals'][$y] = $goal->goal->attributes;
                    $json['contents'][$x]['goals'][$y]['discipline'] = $goal->goal->discipline->name;
                    $cobjects = CobjectMetadata::model()->findAllByAttributes(array('typeID' => $type->ID, 'value' => $goal->goal->ID));
                    $z = -1;
                    foreach ($cobjects as $cobject) {
                        //@todo com base no tema filtrar
                        $z++;
                        $json['contents'][$x]['goals'][$y]['cobjects'][$z] = $cobject->cobject->attributes;
                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['template'] = $cobject->cobject->template->name;
                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['template_code'] = $cobject->cobject->template->code;
                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['theme'] = $cobject->cobject->theme->name;
                        $b = $w = -1;
                        foreach ($cobject->cobject->editorScreens as $screen) {
                            $w++;
                            $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w] = $screen->attributes;
                            $v = -1;
                            foreach ($screen->editorScreenPiecesets as $pieceset) {
                                if ($cobject->cobject->template->code != 'AEHC') {
                                    $v++;
                                }
                                $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['ID'] = $pieceset->pieceset->ID;
                                $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['template'] = $pieceset->template->name;
                                $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['template_code'] = $pieceset->template->code;
                                $a = -1;
                                foreach ($pieceset->pieceset->editorPiecesetPieces as $piece) {
                                    if ($cobject->cobject->template->code != 'AEHC') {
                                        $a++;
                                    }
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['ID'] = $piece->piece->ID;
                                    $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['type'] = $piece->piece->type->name;
                                    if ($cobject->cobject->template->code != 'AEHC') {
                                        $b = -1;
                                    }
                                    foreach ($piece->piece->editorPieceElements as $element) {
                                        $b++;
                                        $properties = $events = $gproperties = array();
                                        foreach ($element->editorPieceelementProperties as $property) {
                                            $properties[] = array('name' => $property->property->name, 'value' => $property->value);
                                        }
                                        if ($cobject->cobject->template->code == 'AEHC') {
                                            $properties[] = array('name' => 'group', 'value' => $piece->piece->ID);
                                        }
                                        foreach ($element->editorEvents as $event) {
                                            $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
                                        }
                                        foreach ($element->element->editorElementProperties as $gproperty) {
                                            if ($gproperty->property->name == 'libraryID') {
                                                $lib = Library::model()->findByAttributes(array('ID' => $gproperty->value));
                                                foreach ($lib->libraryProperties as $libproperty) {
                                                    $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                                                };
                                            } else {
                                                $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
                                            }
                                        }

                                        foreach ($element->element->editorElementAliases as $alias) {
                                            $gproperties[] = array('type' => $alias->type->name, 'value' => $gproperty->value);
                                        }
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['code'] = 'EP' . $element->ID;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['elementProperties'] = $properties;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['events'] = $events;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['generalProperties'] = $gproperties;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['type'] = $element->element->type->name;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $blockID = $_REQUEST['blockID'];
            $sql = "SELECT a.cobjectID,c.value as goalID,e.contentID FROM cobject_cobjectblock a
                join cobject_metadata c on(c.cobjectID=a.cobjectID and c.typeID=6)
                join act_goal_content e on(e.goalID=c.value) where a.blockID = '$blockID' group by a.cobjectID,goalID";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
            $reader = $command->query();
            foreach ($reader as $row) {
                $content = ActContent::model()->findByPk($row['contentID']);
                $goal = ActGoal::model()->findByPk($row['goalID']);
                $cobject = Cobject::model()->findByPk($row['cobjectID']);
                $json['contents'][$row['contentID']] = $content->attributes;
                $json['contents'][$row['contentID']]['goals'][$row['goalID']] = $goal->attributes;
                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['discipline'] = $goal->discipline->name;
                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']] = $cobject->attributes;
                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['template'] = $cobject->template->name;
                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['template_code'] = $cobject->template->code;
                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['theme'] = $cobject->theme->name;
                $b = $w = -1;
                foreach ($cobject->editorScreens as $screen) {
                    $w++;
                    $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w] = $screen->attributes;
                    $v = -1;
                    foreach ($screen->editorScreenPiecesets as $pieceset) {
                        if ($cobject->template->code != 'AEHC') {
                            $v++;
                        }
                        $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['typeID'] = $pieceset->pieceset->typeID;
                        $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['ID'] = $pieceset->pieceset->ID;
                        $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['desc'] = $pieceset->pieceset->desc;
                        $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['template'] = $pieceset->template->name;
                        $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['template_code'] = $pieceset->template->code;
                        $a = -1;
                        foreach ($pieceset->pieceset->editorPiecesetPieces as $piece) {
                            if ($cobject->template->code != 'AEHC') {
                                $a++;
                            }
                            $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['description'] = $piece->piece->description;
                            $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['ID'] = $piece->piece->ID;
                            $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['name'] = $piece->piece->name;
                            $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['type'] = $piece->piece->type->name;
                            if ($cobject->template->code != 'AEHC') {
                                $b = -1;
                            }
                            foreach ($piece->piece->editorPieceElements as $element) {
                                $b++;
                                $properties = $events = $gproperties = array();
                                foreach ($element->editorPieceelementProperties as $property) {
                                    $properties[] = array('name' => $property->property->name, 'value' => $property->value);
                                }
                                if ($cobject->template->code == 'AEHC') {
                                    $properties[] = array('name' => 'group', 'value' => $piece->piece->ID);
                                }
                                foreach ($element->editorEvents as $event) {
                                    $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
                                }
                                foreach ($element->element->editorElementProperties as $gproperty) {
                                    if ($gproperty->property->name == 'libraryID') {
                                        $lib = Library::model()->findByAttributes(array('ID' => $gproperty->value));
                                        foreach ($lib->libraryProperties as $libproperty) {
                                            $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                                        };
                                    } else {
                                        $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
                                    }
                                }
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['code'] = 'EP' . $element->ID;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['elementProperties'] = $properties;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['events'] = $events;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['generalProperties'] = $gproperties;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['type'] = $element->element->type->name;
                            }
                        }
                    }
                }
            }
        }
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
        exit;
    }

}
