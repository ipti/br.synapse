<?php

class RenderController extends Controller {

    public $layout = 'render';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'json', 'login', 'logout', 'filter', 'canvas'),
                'users' => array('@'),
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
        $this->render('login');
    }

    public function actionLogin() {
        $loginmodel = new LoginForm;
        if (isset($_POST["act"])) {
            // Autor Selecionado
            $actor = Actor::model()->findByAttributes(array('ID' => $_POST["act"]));
            $idActor = $actor->ID;
            $nome_personage = $actor->personage->name;
//$personageIdActor = $actor->personageID;
            $unityIdActor = $actor->unityID;
//$activatedDateActor = $actor->activatedDate;
//$desactivatedDateActor = $actor->desactivatedDate;                  
// $personage = Personage::model()->findByAttributes(array('ID'=>$personageIdActor));
//$namePersonage = $personage->name;     
          if(isset($nome_personage) && $nome_personage == "Tutor" ) {
              Yii::app()->session['unityIdActor'] = $unityIdActor;
              $this->redirect("/render/filter");
           }else{
               Yii::app()->session['idActor'] = $idActor;
              $this->redirect("/render/canvas");
           }
        } else if (isset($_POST['LoginForm'])) {
            $loginmodel->attributes = $_POST['LoginForm'];
            $autenticar = $loginmodel->authenticate();
            $identity = $loginmodel->get_identity(); //$itentity = variável local
            if ($autenticar) {
                $idPerson = $identity->getId();
//Somente atores Ativos
                $actor = Actor::model()->findAllByAttributes(array('personID' => $idPerson), "desactivatedDate >" . time() . " OR " . "desactivatedDate is NULL");
                if (count($actor) > 0) {
//Método login() do CWebUser
                    Yii::app()->user->login($identity);

                    $html = "
                   <html>
                      <head>
                      <title> Selecionar Personagem </title>
                       
                     </head>
                   <body>
                   <form method=\"post\" action=\"/render/login\">
                   <select id=\"act\" name=\"act\">";
                    echo "Bem Vindo : " . $identity->getState('name');
//Seleciona um dos personagem de um Person
                    for ($i = 0; count($actor) > $i; $i++) {
                        $tempPersonage = Personage::model()->findByAttributes(array('ID' => $actor[$i]->personageID));
                        $html .= "<option value='".$actor[$i]->ID."'>$tempPersonage->name</option>";
                    }
                    $html .= "</select>
                     <input type='submit' value='Next' id='selectActor'/>
                    </form>";
                    $html.= " </body>
                              </html>";
                    echo $html;
                } else {
                    echo "Não há Atores Ativos para este Usuário !";
                }
            } else {
                echo $identity->errorMessage;
            }

            exit;
        }

//            $name_person = Yii::app()->user->getState('name');
//         if( (!Yii::app()->user->isGuest) && isset($name_person) ) {
//             //Está logado no Render-Login --> To be continued
//             echo "Bem Vindo : " . $name_person;
//             echo "<br> <a href=\"/render/logout\"> Click aqui para fazer logout</a> ";
//         }else{
//             //Não está logado no Render-Login
//             $this->render('login', array('model'=>$loginmodel)); 
//         }

        $this->render('login', array('model' => $loginmodel));
    }

    public function actionLogout() {
        Yii::app()->user->clearStates();
        Yii::app()->user->logout();
        $this->redirect("/render/login");
    }

    public function actionAuthentic() {
//$this->render('login');
        if (isset($_POST['Person'])) {
            $model->attributes = $_POST['Person'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->ID));
        }
    }


    public function actionFilter() {
        $this->render('filter');
    }

    public function actionCanvas() {
        $this->render('canvas');
    }

    public function actionJson() {
        if ( isset($_POST['op']) && 
                ( $_POST['op'] == 'select' || $_POST['op'] == 'classes')) {
            $json = array();
            
            $id = isset($_POST["id"]) ? (int) $_POST["id"] : die('ERRO: id não recebido');

            $sql = "SELECT ut.ID, ut.unity, u.name, ut.organizationID, 
                            ut.unityOrganizationID, ou.orgLevel 
                    from unity_tree ut
                    inner join organization ou
                    on ou.ID = ut.unityOrganizationID
                    inner join organization o
                    on o.ID = ut.OrganizationID
                    inner join unity u
                    on u.ID = ut.unity
                    where ut.id = $id ";
            $sql .= $_POST['op'] == 'select' ? "AND ou.orgLevel = o.orgLevel+1;" : "AND ou.orgLevel = -1;";
            $unitys = Yii::app()->db->createCommand($sql)->queryAll();

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

            $sql = "SELECT a.id actorID, p.name 
                    FROM synapse.actor a
                    inner join person p
                    on p.ID = a.personID
                    where a.unityID = $id;";
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
                $scripts = ActScript::model()->findAllByAttributes(array('disciplineID' => $discipline->ID));
                $blocks = Cobjectblock::model()->findAllByAttributes(array('disciplineID' => $discipline->ID));
                $rscript = $rblock = array();
                $b = $c = -1;
                foreach ($scripts as $script) {
                    $b++;
                    $rscript[$b] = $script->attributes;
                    $rscript[$b]['name'] = $script->contentParent->description;
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
        $userID = $_POST['userID'];
        $classID = $_POST['classID'];
        $typeID = $_POST['typeID'];
        $user = User::model()->findByPk($userID);
        $json['userID'] = $userID;
        $json['userName'] = $user->name;
        $json['classID'] = $classID;
        if ($typeID == 'rscript') {
            $script = ActScript::model()->findByAttributes(array('ID' => $_POST['script']));
            $contents = ActContent::model()->findAllByAttributes(array('contentParent' => $script->contentParentID));
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
