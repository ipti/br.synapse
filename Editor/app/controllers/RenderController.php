<?php

class RenderController extends Controller
{

    public $layout = 'fullmenu';
    //MSG for Translate
    public $INVALID_ATTRIBUTES = "Atributes Inválidos";
    //
    private $tempArchiveZipMultiMedia = null;
    private $dir_library = "/library/";

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function elog($text)
    {
        $this->http_response_code(200);
        echo json_encode($text);
        flush();
        ob_flush();
    }

    public function actionListcobjects()
    {
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

    public function cobjectbyid($cobject_id, $buildZipMultimedia)
    {
        $buildZipMultimedia = isset($buildZipMultimedia) && $buildZipMultimedia;

        $sql = "SELECT * FROM render_cobjects WHERE cobject_id = $cobject_id;";
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $row = $command->queryRow();

        //Verifica se existe algum resultado da pesquisa feito no 'render_view'
        if (ISSET($row['cobject_id'])) {
            $json = $row;
            $cobject = Cobject::model()->findByPk($row['cobject_id']);
            if (isset($cobject->father)) {
                $json['father'] = $cobject->father->id;
            }

            //Obter os elementos desse Cobject
            $CobjectElements = CobjectElement::model()->findAllByAttributes(array('cobject_id' => $cobject->id));
            $contElement = -1;
            foreach ($CobjectElements as $CobjectElement):
                $contElement++;
                $this->buildJsonElement(true, false, $CobjectElement, $json, ['a5' => $contElement], $buildZipMultimedia);
            endforeach;

            $a5 = $a2 = $a3 = -1;

            if (isset($cobject->editorScreens)) {
                foreach ($cobject->editorScreens as $screen) {
                    $a2++;
                    $json['screens'][$a2] = $screen->attributes;
                    $a3 = -1;
                    foreach ($screen->editorScreenPiecesets as $screen_pieceset) {
                        $a3++;
                        $json['screens'][$a2]['piecesets'][$a3]['id'] = $screen_pieceset->pieceset->id;
                        $json['screens'][$a2]['piecesets'][$a3]['template_code'] = $screen_pieceset->pieceset->template->code;
                        $json['screens'][$a2]['piecesets'][$a3]['description'] = $screen_pieceset->pieceset->description;
                        //=======================================
                        //For each elements in this pieceset
                        $a5 = -1;
                        foreach ($screen_pieceset->pieceset->editorPiecesetElements as $pieceset_element) {
                            //build elements of the PieceSet
                            $a5++;
                            $this->buildJsonElement(false, true, $pieceset_element, $json, ['a2' => $a2, 'a3' => $a3, 'a5' => $a5], $buildZipMultimedia);
                        }

                        $a4 = -1;
                        foreach ($screen_pieceset->pieceset->editorPiecesetPieces as $pieceset_piece) {
                            $a4++;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['id'] = $pieceset_piece->piece->id;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['name'] = $pieceset_piece->piece->name;
                            $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['description'] = $pieceset_piece->piece->description;

                            if (isset($pieceset_piece->piece->type_id)) {
                                $typeName = CommonType::getTypeNameByID($pieceset_piece->piece->type_id);
                                $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['type_name'] = $typeName;

                                if ($typeName === "shape") {
                                    //O template é Desenho. Possue então a propriedade type_shape
                                    $pieceProperty = EditorPieceProperty::model()->findByAttributes(array('piece_id' => $pieceset_piece->piece->id));
                                    $json['screens'][$a2]['piecesets'][$a3]['pieces'][$a4]['shape'] = $pieceProperty->value;
                                }
                            }

                            $a5 = (int)-1;
                            foreach ($pieceset_piece->piece->editorPieceElements as $piece_element) {
                                $a5++;
                                $this->buildJsonElement(false, false, $piece_element, $json, ['a2' => $a2, 'a3' => $a3, 'a4' => $a4, 'a5' => $a5], $buildZipMultimedia);
                            }
                        }
                    }
                }
                return $json;
            } else {
                $json['cobject'] = $cobject_id;
                return $json;
            }
        } else {
            return null;
        }
    }

    private function buildJsonElement($isCobjectElement, $isPiecesetElement, $father, &$json, $as, $buildZipMultimedia)
    {
        //Begin Function Element =======================================
        // $gproperties = ELEMENT_PROPERTY + LIBRARY_PROPERTY

        $pe_properties = $events = $gproperties = array();

        if (!$isPiecesetElement && !$isCobjectElement) {
            foreach ($father->editorPieceelementProperties as $property) {
                $propertyName = $property->property->name;

                if (isset($pe_properties[$propertyName])) {
                    if (!is_array($pe_properties[$propertyName])) {
                        $tmp = $pe_properties[$propertyName];
                        $pe_properties[$propertyName] = array();
                        array_push($pe_properties[$propertyName], $tmp);
                        array_push($pe_properties[$propertyName], $property->value);
                    } else {
                        array_push($pe_properties[$propertyName], $property->value);
                    }
                } else {
                    $pe_properties[$propertyName] = $property->value;
                }
            }

            //===== Agrupar os elementos no Json 
            //if($json['screens'][$as['a2']]['piecesets'][$as['a3']]['template_code'] == 'MTE' ||
            //    $json['screens'][$as['a2']]['piecesets'][$as['a3']]['template_code'] == 'AEL'){
            //Grouping
            $sizeGrouping = count(explode('_', $pe_properties["grouping"]));
            $grouping = $pe_properties["grouping"];
            if ($sizeGrouping == 1) {
                $type_group = $grouping;
            } else if ($sizeGrouping == 2) {
                $type_group = $grouping;
            }

            // }
            //===================================
            //$properties[] = array('name' => 'pieceset', 'value' => $screen_pieceset->pieceset->id);
            // match é somente do AEL
            /* if ($cobject->template->code == 'AEL') {
              $properties[] = array('name' => 'match', 'value' => $pieceset_piece->piece->id);
              }
              //group é do AEL e MTE
              if($cobject->template->code == 'AEL' || $cobject->template->code == 'MTE'){
              $properties[] = array('name' => 'group', 'value' => $pieceset_piece->piece->id);
              } */

            foreach ($father->editorEvents as $event) {
                $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
            }
        }

        foreach ($father->element->editorElementProperties as $gproperty) {
            $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
            if ($gproperty->property->name == 'library_id') {
                $libid = $gproperty->value;
            }
        }
        if ($father->element->type->name == 'multimidia') {
            $lib = Library::model()->findByAttributes(array('id' => $libid));
            foreach ($lib->libraryProperties as $libproperty) {
                $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                if ($buildZipMultimedia && $libproperty->property->name == 'src') {
                    $dir_uploadType = $lib->type->name;
                    $src = Yii::app()->basePath . "/.." . $this->dir_library . $dir_uploadType . '/' . $libproperty->value;
                    $this->tempArchiveZipMultiMedia->addFile($src, 'library/' . $dir_uploadType . '/' . $libproperty->value);
                    //Array de tipos que este grupo possui
                    if (!$isPiecesetElement && !$isCobjectElement) {
                        if (isset($json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'])) {
                            $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'][$lib->type->name] = $lib->type->name;
                        } else {
                            $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'] = array();
                            $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'][$lib->type->name] = $lib->type->name;
                        }
                    }
                }
            }
            $gproperties[] = array('name' => 'library_type', 'value' => $lib->type->name);
        } else {
            //Array de tipos que este grupo possui
            if (!$isPiecesetElement && !$isCobjectElement) {
                if (isset($json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'])) {
                    $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'][$father->element->type->name] = $father->element->type->name;
                } else {
                    $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'] = array();
                    $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['types_elements'][$father->element->type->name] = $father->element->type->name;
                }
            }
        }

        foreach ($father->element->editorElementAliases as $alias) {
            $gproperties[] = array('type' => $alias->type->name, 'value' => $gproperty->value);
        }

        //$json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['groups'][$type_group]['elements'] = array();
        //$json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['groups'][$type_group]['elements'][$as['a5']] = array();
        $aTemp = array();

        if (!$isPiecesetElement && !$isCobjectElement) {
            $aTemp["id"] = $father->element->id;
            $aTemp["pieceElementID"] = $father->id;
            $aTemp['pieceElement_Properties'] = $pe_properties;
            $aTemp['events'] = $events;
            $aTemp['generalProperties'] = $gproperties;
            $aTemp['type'] = (string)$father->element->type->name;
            if (!isset($json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['groups'][$type_group]['elements'])) {
                $json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['groups'][$type_group]['elements'] = array();
            }
            array_push($json['screens'][$as['a2']]['piecesets'][$as['a3']]['pieces'][$as['a4']]['groups'][$type_group]['elements'], $aTemp);
        } else if ($isPiecesetElement) {
            $aTemp['id'] = $father->element->id;
            $aTemp['generalProperties'] = $gproperties;
            $aTemp['type'] = $father->element->type->name;
            if (!isset($json['screens'][$as['a2']]['piecesets'][$as['a3']]['elements'])) {
                $json['screens'][$as['a2']]['piecesets'][$as['a3']]['elements'] = array();
            }

            $json['screens'][$as['a2']]['piecesets'][$as['a3']]['elements'][$as['a5']] = $aTemp;
        } else {
            //É Cobject_Element
            $aTemp['id'] = $father->element->id;
            $aTemp['generalProperties'] = $gproperties;
            $aTemp['type'] = $father->element->type->name;
            if (!isset($json['elements'])) {
                $json['elements'] = array();
            }

            $json['elements'][$as['a5']] = $aTemp;
        }
        // End Function Element=========================================
    }

    public function actionLoadcobject()
    {
        $cobject_id = $_REQUEST['ID'];
        $json = $this->cobjectbyid($cobject_id, false);
        if (isset($_GET['callback']))
            echo $_GET['callback'] . '(' . json_encode($json) . ')';
        else
            echo json_encode($json);
        exit;
    }

    /**
     *
     * @param
     */
    public function actionLoadtext()
    {
        $cobject_id = $_REQUEST['ID'];
        $json = $this->cobjectbyid($cobject_id);
        $json = json_encode($json);
        $this->render('text', array('json' => $json));
    }

    public function actionLoadcobjects()
    {
        set_time_limit(0);
        //header('Content-type: application/json');
        //header('Content-type: text/html; charset=utf-8');
        //header('Cache-Control: no-cache, must-revalidate');
        // header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        //header('Content-type: application/json');

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
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('listcobjects', 'loadtext', 'compute', 'loadcobject', 'stage',
                    'index', 'view', 'create', 'update', 'json', 'mount', 'login', 'logout',
                    'filter', 'loadcobjects', 'canvas', 'testepreview', 'meet', 'exportToOffline',
                    'importPeformance', 'importFromEduCenso', 'importFromSiga', 'getSchool', 'getAllSchools', 'getCobject_blocks', 'getDisciplines',
                    'SynapseRender', 'login',
                    'preview','getLevels'),
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

    public function actionMeet()
    {
        if (isset($_POST["actor"])) {
            $this->render("meet");
        } else {
            $this->redirect("/render/filter");
        }
    }

    public function actionExportToOffline()
    {
        if (isset($_REQUEST['school']) || isset($_REQUEST['cobject_block'])) {
            $array_actorsInClassroom = [];
            if (isset($_REQUEST['school']) && $_REQUEST['school'] != "null") {
                $school = School::model()->findByPk($_REQUEST['school']);
                //Obtendo a escola agora pesquisa seus filhos, as suas turmas e seleciona todos os actores dessa turma
                $query = "SELECT $school->id AS school_id, '$school->name' AS school_name, class.id AS classroom_id, class.name AS classroom_name,
                    act.id, person.name, personage.name AS personage, person.login, person.password 
                    FROM classroom AS class
                    INNER JOIN actor AS act ON(act.classroom_fk = class.id)
                    INNER JOIN person ON(act.person_id = person.id)
                    INNER JOIN personage ON(act.personage_id = personage.id)
                    WHERE class.school_fk = " . $school->id;

                //Criar Objeto user => actor_id, name, name_personage, login, senha
                $array_actorsInClassroom = Yii::app()->db->createCommand($query)->queryAll();
            } else {
                //Escola Não selecionada
                $array_actorsInClassroom = [];
            }

            $nameDisciplineSelected = "";
            //Obter as disciplinas
            $disciplines = ActDiscipline::model()->findAll();
            $array_disciplines = array();
            foreach ($disciplines as $idx => $discipline):
                $array_disciplines[$idx]['id'] = $discipline->id;
                $array_disciplines[$idx]['name'] = $discipline->name;

                if ($_POST['discipline'] == $discipline->id) {
                    $nameDisciplineSelected = substr($discipline->name, 0, 3);
                }
            endforeach;

            //Obter o CobjectBloco Selecionado
            $cobjectBlock = Cobjectblock::model()->findByPk($_REQUEST['cobject_block']);
            $array_cobjectBlock = array();
            $array_cobjectBlock[0]['id'] = $cobjectBlock->id;
            $array_cobjectBlock[0]['name'] = $cobjectBlock->name;
            $array_cobjectBlock[0]['discipline_id'] = $cobjectBlock->discipline_id;

            //Obter os Cobject_cobjectBlock do CobjectBlock acima
            //Somente obterá Cobjects(atividades) únicos em cada bloco, ou seja não haverá repetição de atividades num mesmo bloco.
            $cobject_cobjectBlocks = CobjectCobjectblock::model()->findAllByAttributes(
                array('cobject_block_id' => $array_cobjectBlock[0]['id']), array('group' => "cobject_id"));

            $array_cobject_cobjectBlocks = array();

            foreach ($cobject_cobjectBlocks as $idx => $cobject_cobjectBlock):
                $array_cobject_cobjectBlocks[$idx]['id'] = $cobject_cobjectBlock->id;
                $array_cobject_cobjectBlocks[$idx]['cobject_id'] = $cobject_cobjectBlock->cobject_id;
                $array_cobject_cobjectBlocks[$idx]['cobject_block_id'] = $cobject_cobjectBlock->cobject_block_id;
            endforeach;

            //Obter o Cobject id e json
            if (isset($_REQUEST['cobject_block'])) {
                //Para cada Cobject do bloco armazenar sua "view"
                $cobject_block_id = $_REQUEST['cobject_block'];
                $cobjectCobjectblocks = CobjectCobjectblock::model()->findAllByAttributes(array('cobject_block_id' => $cobject_block_id));
                $json_cobjects = array();
                //Arquivo ZIP ALL
                $zipname = 'importRender_' . date('d_m_Y_H_i_s') . '.zip';
                $this->tempArchiveZipMultiMedia = new ZipArchive;
                $this->tempArchiveZipMultiMedia->open('exports/' . $zipname, ZipArchive::CREATE);
                $this->tempArchiveZipMultiMedia->addEmptyDir("library/image/");
                $this->tempArchiveZipMultiMedia->addEmptyDir("library/sound/");
                $this->tempArchiveZipMultiMedia->addEmptyDir("json/");

                foreach ($cobjectCobjectblocks as $cobjectCobjectblock):
                    $jsonRenderView = $this->cobjectbyid($cobjectCobjectblock->cobject_id, true);
                    if (ISSET($jsonRenderView)) {
                        //Só dá o push no array, sse o jsonRenderView for diferente de NULL
                        array_push($json_cobjects, $jsonRenderView);
                    }
                endforeach;

                // Fazer Download no Final
                //Arquivo Json para adcionar no ZIP
                $json = array();
                //Tratar Separação no JS
                $json['ActorsInClassroom'] = $array_actorsInClassroom;
                $json['Disciplines'] = $array_disciplines;
                $json['CobjectBlock'] = $array_cobjectBlock;
                $json['Cobject_cobjectBlocks'] = $array_cobject_cobjectBlocks;
                $json['Cobjects'] = $json_cobjects;
                $json_encode = "var dataJson$nameDisciplineSelected = ";
                $json_encode .= json_encode($json);
                $json_encode .= ";";

                $this->tempArchiveZipMultiMedia->addFromString("json/renderData$nameDisciplineSelected.js", $json_encode);

                //Salva as alterações no zip
                $this->tempArchiveZipMultiMedia->close();

                if (file_exists('exports/' . $zipname)) {
                    header('location: ../exports/' . $zipname);
                }
            }
        } else {
            //Carrega a página para exportar para o render Offline
            $this->render("exportToOffline");
        }
    }

    public function actionImportFromSiga()
    {
        if (isset($_POST['import'])) {
            $imported = false;

            $ch = curl_init();
            $schools = $this->connectToSiga($ch, 'http://192.168.0.116:8080/API-Restful-Emulador/api/EmuladorService/getEscolas');
            $classrooms = $this->connectToSiga($ch, 'http://192.168.0.116:8080/API-Restful-Emulador/api/EmuladorService/getTurmas');
            $students = $this->connectToSiga($ch, 'http://192.168.0.116:8080/API-Restful-Emulador/api/EmuladorService/getAlunos');
            $enrollments = $this->connectToSiga($ch, 'http://192.168.0.116:8080/API-Restful-Emulador/api/EmuladorService/getMatriculas');
            curl_close($ch);



            $schools = json_decode($schools);
            foreach ($schools as $sch) {
                $school = School::model()->findByAttributes(array('inep_id' => $sch->inep_id));
                if (!isset($school)) {
                    $school = new School();
                }
                $school->inep_id = $sch->inep_id;
                $school->name = $sch->name;
                $school->fk_id = $sch->id;
                $school->source = 'SIGA';
                if (!$school->save()) {
                    $imported = false;
                    $msg = $school->getErrors();
                }
            }

            /*---*/

            $classrooms = json_decode($classrooms);
            foreach ($classrooms as $cl) {
                $classroom = Classroom::model()->findByAttributes(array('inep_id' => $cl->inep_id));
                if (!isset($classroom)) {
                    $classroom = new Classroom();
                }
                $classroom->inep_id = $cl->inep_id;
                $classroom->name = $cl->name;
                $classroom->school_fk = School::model()->findByAttributes(array('fk_id' => $cl->school_fk, 'source' => "SIGA"))->id;
                $classroom->stage_fk = EdcensoStageVsModality::model()->findByAttributes(array('stage_code' => $cl->stage_fk))->id;
                $classroom->year = date("Y");
                $classroom->fk_id = $cl->id;
                $classroom->source = 'SIGA';
                if (!$classroom->save()) {
                    $imported = false;
                    $msg .= $classroom->getErrors();
                }
            }

            /*---*/

            $students = json_decode($students);
            foreach ($students as $stu) {
                $array_name = explode(" ", $stu->name);
                $login = strtolower(trim($array_name[0] . substr($stu->inep_id, strlen($stu->inep_id) - 3, 3)));

                $person = Person::model()->findByAttributes(array("login" => $login));
                if (!isset($person)) {
                    $person = new Person();
                }

                $person->name = $stu->name;
                $person->login = $login;
                $person->email = $person->login . "@email.com";
                $person->password = $person->login;

                $person->mother_name = $stu->mother_name;
                $person->father_name = $stu->father_name;
                $person->birthday = $stu->birthday;

                if ($person->save()) {
                    $actor = Actor::model()->findByAttributes(array('inep_id' => $stu->inep_id));
                    if (!isset($actor)) {
                        $actor = new Actor();
                    }
                    $actor->person_id = $person->id;
                    $actor->personage_id = 2;
                    $actor->classroom_fk = Classroom::model()->findByAttributes(array('fk_id' => $stu->classroom_fk, 'source' => "SIGA"))->id;
                    $actor->inep_id = $stu->inep_id;
                    $actor->fk_id = $stu->id;
                    $actor->source = 'SIGA';
                    if (!$actor->save()) {
                        $imported = false;
                        $msg .= $classroom->getErrors();
                    }
                }
            }

            /*---*/

            $enrollments = json_decode($enrollments);
            foreach ($enrollments as $enr) {
                $classroom = Classroom::model()->findByAttributes(array("fk_id" => $enr->classroom_fk));
                $actor = Actor::model()->findByAttributes(array("fk_id" => $enr->student_fk, "classroom_fk" => $classroom->id));
                if (isset($actor)) {
                    $actor->student_enrollment = $enr->student_enrollment;
                    if (!$actor->save()) {
                        $imported = false;
                        $msg .= $classroom->getErrors();
                    } else {
                        $imported = true;
                    }

                }
            }

            if ($imported) {
                $this->render("importFromSiga", array('msg' => 'success'));
            } else {
                $this->render("importFromSiga", array('msg' => $msg));
            }
        } else {
            $this->render("importFromSiga");
        }
    }

    public function connectToSiga($ch, $url) {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return curl_exec($ch);
    }

    public function actionImportFromEduCenso()
    {
        if (isset($_FILES['fileTxt'])) {
            $tempName = $_FILES['fileTxt']['tmp_name'];
            $fileTxt = fopen($tempName, "r") or die("Unable to open file!");
            $matchesSchools = array(); //00
            $matchesClassroom = array(); //20
            $matchesStudents = array(); //60
            $matchesEnrollment = array(); //80

            while (!feof($fileTxt)) {
                $line = fgets($fileTxt);
                $typeReg = substr($line, 0, 2);
                if ($typeReg == '00') {
                    //Escola
                    array_push($matchesSchools, $line);
                }
                if ($typeReg == '20') {
                    //Turma
                    array_push($matchesClassroom, $line);
                }
                if ($typeReg == '60') {
                    //Estudante
                    array_push($matchesStudents, $line);
                }
                if ($typeReg == '80') {
                    //Matrícula
                    array_push($matchesEnrollment, $line);
                }

            }
            //Fecha o Arquivo
            fclose($fileTxt);
            $imported = false;
            if (count($matchesSchools) > 0) {
                //School Data
                $explSchool = explode("|", $matchesSchools[0]);
                $schoolInepID = $explSchool[1];
                $schoolName = $explSchool[9];

                //Antes de salvar uma nova escola, verifica se ela já não existe.
                $school = School::model()->findByAttributes(array('inep_id' => $schoolInepID));
                if (!isset($school)) {
                    //É a primeira inserção dessa escola no DB
                    $school = new School();
                }
                //Carrega os atributos da escola
                $school->name = $schoolName;
                $school->inep_id = $schoolInepID;
                $school->source = "EDUCACENSO";
                $school->fk_id = $schoolInepID;
                if ($school->save()) {
                    //Classroom Data
                    //Deverá tratar turmas multiseriadas !!!!!!!!!!!!!!!!!!!!!!!!!!!
                    foreach ($matchesClassroom AS $eachClassroom):
                        $explClassroom = explode("|", $eachClassroom);
                        $classroomInepID = $explClassroom[2];
                        $classroomName = $explClassroom[4];
                        $classroomStage_id = $explClassroom[37];
                        //Verificar no banco de dados se o stage_id possui o campo stage = 2 ou 3
                        $edCensoStage = EdcensoStageVsModality::model()->findByAttributes(array('stage_code' => $classroomStage_id));
                        if ($edCensoStage->stage_code >= 4 && $edCensoStage->stage_code <= 24) {
                            //Selecionar o nome do Stage no Banco do Synapse
                            //Antes de salvar uma nova Turma, verifica se ela já não existe.
                            $classroom = Classroom::model()->findByAttributes(array('inep_id' => $classroomInepID));
                            if (!isset($classroom)) {
                                //É a primeira inserção dessa Turma no DB
                                $classroom = new Classroom();
                            }
                            //Carrega os atributos da Turma
                            $classroom->name = $classroomName;
                            $classroom->inep_id = $classroomInepID;
                            $classroom->school_fk = $school->id;
                            $classroom->stage_fk = $edCensoStage->id;
                            $classroom->year = date("Y");
                            $classroom->source = "EDUCACENSO";
                            $classroom->fk_id = $classroomInepID;
                            // var_dump($classroom);exit();
                            //Inseri no DB a Turma corrente
                            $classroom->save();
                        }
                    endforeach;
                    //=============================
                    //Student Data
                    foreach ($matchesStudents AS $eachStudent):
                        $explStudent = explode("|", $eachStudent);
                        $studentSchoolInepID = $explStudent[1];

                        $studentInepID = $explStudent[2];
                        $studentName = $explStudent[4];
                        $studentBirthday = $explStudent[5];
                        $studentMotherName = $explStudent[9];
                        $studentFatherName = $explStudent[10];
                        //Verificar Qual turma o Aluno Corrente está matriculado
                        foreach ($matchesEnrollment AS $eachEnrollment):
                            $explEnrollment = explode("|", $eachEnrollment);
                            $enrollmentStudentInepID = $explEnrollment[2];
                            $enrollmentClassroomInepID = $explEnrollment[4];
                            $enrollmentID = $explEnrollment[6];
                            //Busca a classe do Aluno por meio do inep_id da classe que foi matriculado
                            $studentClassroom = Classroom::model()->findByAttributes(array('inep_id' => $enrollmentClassroomInepID));
                            //Ante do cadastro ou atualização referente ao estudante, verifica se a classe
                            //Foi cadastrada no banco do Synapse, não não houver registro, então o aluno não deve ser inserido
                            if (isset($studentClassroom)) {
                                if ($enrollmentStudentInepID == $studentInepID) {
                                    //Encontrou a matrícula do Estudante corrente
                                    //Antes de salvar um novo usuário, verifica se ele já não existe.
                                    $actor = Actor::model()->findByAttributes(array('inep_id' => $studentInepID));
                                    if (!isset($actor)) {
                                        //É a primeira inserção desse estudante no DB
                                        //Inicia um novo Person e Actor
                                        $person = new Person();
                                        $actor = new Actor();
                                    } else {
                                        //Busca o Person associado ao Actor encontrado
                                        $person = Person::model()->findByAttributes(array('id' => $actor->person_id));
                                    }
                                    //Set nos atributos do Person
                                    $person->name = $studentName;
                                    $array_name = explode(" ", $studentName);
                                    //login é o primeiro nome + as três primeiras letras do segundo nome
                                    $person->login = strtolower(trim($array_name[0] . substr($studentInepID, strlen($studentInepID) - 3, 3)));
                                    $person->email = $person->login . "@email.com";
                                    $person->password = $person->login;

                                    $person->mother_name = $studentMotherName;
                                    $person->father_name = $studentFatherName;
                                    $person->birthday = $studentBirthday;

                                    if ($person->save()) {
                                        //Set dos atributos do Actor
                                        $actor->person_id = $person->id;
                                        //Personage é Aluno =
                                        $actor->personage_id = 2;
                                        $actor->classroom_fk = $studentClassroom->id;
                                        $actor->inep_id = $studentInepID;
                                        $actor->student_enrollment = $enrollmentID;
                                        $actor->source = "EDUCACENSO";
                                        $actor->fk_id = $studentInepID;
                                        $actor->save();
                                    }
                                    //Ecnontrou a turma que o aluno está matriculado
                                    break;
                                }
                            }

                        endforeach;
                    endforeach;
                    //=============================

                }
                //======================================
                $imported = true;
            }

            if ($imported) {
                $this->render("importFromEduCenso", array('msg' => 'success'));
            } else {
                $this->render("importFromEduCenso", array('msg' => 'error'));
            }
        } else {
            $this->render("importFromEduCenso");
        }
    }

    public function actionImportPeformance()
    {
        if (isset($_FILES['fileTxt'])) {
            $tempName = $_FILES['fileTxt']['tmp_name'];
            // move_uploaded_file($tempNamename, Yii::app()->theme->basePath . '/backups/backup_peformances/');
            $fileTxt = fopen($tempName, "r") or die("Unable to open file!");
            $peformancesJson = fread($fileTxt, filesize($tempName));
            $peformances = json_decode($peformancesJson);
            //Fecha o Arquivo
            fclose($fileTxt);
            $imported = false;
            if (isset($peformances)) {
                $strSqlPerformInserts = "INSERT INTO `peformance_actor`"
                    . "(`actor_id`, `piece_id`, `group_id`, `final_time`, `iscorrect`, `value` ) VALUES";
                $totalPeformances = count($peformances);
                foreach ($peformances as $idx => $peform):
                    $strSqlPerformInserts .= '( "';
                    $strSqlPerformInserts .= $peform->actor_id . '", "' . $peform->piece_id
                        . '", "' . $peform->group_id . '", "' . $peform->final_time
                        . '", "' . $peform->iscorrect . '", "' . $peform->value;
                    $strSqlPerformInserts .= '" )';
                    if ($idx < $totalPeformances - 1) {
                        $strSqlPerformInserts .= ", ";
                    }

                endforeach;

                //Executa a Query
                Yii::app()->db->createCommand($strSqlPerformInserts)->query();
                $imported = true;
            }

            if ($imported) {
                $this->render("importPeformance", array('msg' => 'success'));
            } else {
                $this->render("importPeformance", array('msg' => 'error'));
            }
        } else {
            $this->render("importPeformance");
        }
    }

    /*
     *  public function actionGetSchool() {
         $allSchool = Unity::model()->findAllByAttributes(array('organization_id' => '2'));
         $json = array();
         foreach ($allSchool as $school):
             $json[$school->id] = $school->name;
         endforeach;
         header('Cache-Control: no-cache, must-revalidate');
         header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
         header('Content-type: application/json');
         echo json_encode($json);
     }
    */

    public function actionGetAllSchools()
    {
        $allSchool = School::model()->findAll();
        $json = array();
        foreach ($allSchool as $school):
            $json[$school->id] = $school->name;
        endforeach;
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
    }

    public function actionGetDisciplines()
    {
        $allDisciplines = ActDiscipline::model()->findAll();
        $json = array();
        foreach ($allDisciplines as $discipline):
            $json[$discipline->id] = $discipline->name;
        endforeach;
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
    }

    public function actionGetLevels()
    {
        if(ISSET($_POST['school_id']) && $_POST['school_id'] != 'null') {
            $school_id = $_POST['school_id'];
            //Buscar todas os levels(anos) dessa escola
            //Para isso precisa encontrar todas as turmas e agrupá-las de acordo com o nível
            $levels = Classroom::model()->findAllByAttributes(array('school_fk'=>$school_id), array('group'=>'stage_fk'));

            var_dump($levels);exit(); //STOP HERE - Must show all Stage name

            $allLevels = ActDiscipline::model()->findAll();
            $json = array();
            foreach ($allLevels as $discipline):
                $json[$discipline->id] = $discipline->name;
            endforeach;
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
        }
    }

    public function actionGetCobject_blocks()
    {
        if (isset($_POST['discipline_id'])) {
            $blocks = Cobjectblock::model()->findAllByAttributes(array('discipline_id' => $_POST['discipline_id']));
        } else {
            $blocks = Cobjectblock::model()->findAll();
        }
        $json = array();
        foreach ($blocks as $block):
            $json[$block->id] = $block->name;
        endforeach;
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
    }

    public function actionIndex()
    {
        $this->redirect(RENDER_ONLINE . "?isOnline=true");
    }

    public function actionPreview($id = null)
    {
        $this->redirect(RENDER_ONLINE . "?isPreview=$id");
    }

    public function actionTestepreview()
    {
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


    public function actionFilter()
    {
        $this->render('filter');
    }

    public function actionCanvas()
    {
        $this->render('canvas');
    }

    public function actionCompute()
    {
        $perf = new PeformanceActor();
        $data['piece_id'] = $_REQUEST['pieceID'];
        $data['group_id'] = (isset($_REQUEST['groupID'])) ? $_REQUEST['groupID'] : NULL;
        $data['actor_id'] = $_REQUEST['actorID'];
        $data['final_time'] = $_REQUEST['time_answer'];
        $data['value'] = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : NULL;
        $data['iscorrect'] = $_REQUEST['isCorrect'];

        $perf->setAttributes($data);
        if ($perf->validate()) {
            echo $perf->save();
        } else {
            echo $this->INVALID_ATTRIBUTES;
        }
    }

    public function actionStage()
    {

        $cobject_id = @$_REQUEST['id'];
        $disciplineID = @$_REQUEST['disciplineID'];
        $script = @$_REQUEST['scriptID'];
        $modality = @$_REQUEST['modality'];
        $degree = @$_REQUEST['degree'];
        $content = @$_REQUEST['content'];
        $blockID = @$_REQUEST['blockID'];
        $actor = @$_REQUEST['actorID'];
        $actor = Actor::model()->findbypk($actor);
        if (isset($script) && ($script != 0)) {
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
        }
        $join = "";
        $sql = "select distinct(ro.cobject_id) as id from render_cobjects ro";
        /* $sql = "select  distinct(a1.id)
          from cobject a1
          join cobject_metadata a2 on(a1.id=a2.cobject_id and a2.type_id=13)
          join act_goal a3 on(a3.id=a2.value)
          join act_goal_content a4 on(a3.id=a4.goal_id)
          join act_content a6 on(a6.id=a4.content_id)
          join act_degree a7 on(a3.degree_id=a7.id)"; */
        //$where = " where a1.id not in('335','356','571','15','431','68','430','641','642','428','647','643','645','71','335','654','76') and a1.status='on' and a7.stage = '2' and (year = '1') and a1.theme_id = 30 and a3.discipline_id = $disciplineID";
        $where = " where ro.status = 'on'";
        if (isset($contentsIn) && isset($contentOut)) {
            $where .= " and (a6.id in($contentsIn) or a6.id not in($contentOut))";
        } else if (isset($contentsIn) && !isset($contentOut)) {
            $where .= " and (a6.id in($contentsIn))";
        } else if (isset($contentOut) && !isset($contentsIn)) {
            $where .= " and (a6.id not in($contentOut))";
        }
        if (isset($blockID) && !empty($blockID)) {
            $join .= " left join cobject_cobjectblock ccobj on(ccobj.cobject_id=ro.cobject_id)";
            $where .= " and ccobj.cobject_block_id=$blockID";
        }
        if (isset($modality)) {
            $join .= " left join act_goal_modality a5 on(a3.id=a5.goal_id)";
            $where .= "";
        }
        if (isset($degree)) {
            $join .= " left join act_degree a14 on(a14.id=a3.degree_id)";
            $where .= "";
        }
        if (isset($content)) {
            $where .= "";
        }
        $fsql = $sql . $join . $where . " order by ro.year,ro.grade,ro.id";
        //var_dump($fsql);exit();
        $command = Yii::app()->db->createCommand($fsql);
        $command->execute();
        $reader = $command->queryAll();
        $json['ids'] = $reader;
        $json['size'] = count($reader);
        $json['pctitem'] = round(100 / count($reader), 1);
        $json = json_encode($json);
        //var_dump($json);
        $this->render('stage', array('json' => $json, 'actor' => $actor));
    }

    public function actionJson()
    {
        set_time_limit(0);
        if (isset($_POST['op']) &&
            ($_POST['op'] == 'select' || $_POST['op'] == 'classes')
        ) {
            $json = array();

            $id = isset($_POST["id"]) ? (int)$_POST["id"] : die('ERRO: id não recebido');

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
            $_POST['op'] == 'select' ? $json['unitys'] = $unitys : $json['classes'] = $unitys;
            $json['fatherID'] = $id;
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
            exit;
        } elseif (isset($_POST['op']) and $_POST['op'] == 'actors') {
            $json = array();
            $id = isset($_POST["id"]) ? (int)$_POST["id"] : die('ERRO: id não recebido');

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
                                    foreach ($piece->piece->editorPieceElements as $piece_element) {

                                        $b++;
                                        $pe_properties = $events = $gproperties = array();
                                        foreach ($piece_element->editorPieceelementProperties as $pe_property) {
                                            $pe_properties[] = array('name' => $pe_property->property->name, 'value' => $pe_property->value);
                                        }
                                        if ($cobject->cobject->template->code == 'AEHC') {
                                            $pe_properties[] = array('name' => 'group', 'value' => $piece->piece->ID);
                                        }
                                        foreach ($piece_element->editorEvents as $event) {
                                            $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
                                        }
                                        foreach ($piece_element->element->editorElementProperties as $gproperty) {
                                            if ($gproperty->property->name == 'libraryID') {
                                                $lib = Library::model()->findByAttributes(array('ID' => $gproperty->value));
                                                foreach ($lib->libraryProperties as $libproperty) {
                                                    $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                                                };
                                            } else {
                                                $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
                                            }
                                        }

                                        foreach ($piece_element->element->editorElementAliases as $alias) {
                                            $gproperties[] = array('type' => $alias->type->name, 'value' => $gproperty->value);
                                        }
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['code'] = 'EP' . $piece_element->ID;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['elementProperties'] = $pe_properties;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['events'] = $events;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['generalProperties'] = $gproperties;
                                        $json['contents'][$x]['goals'][$y]['cobjects'][$z]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['type'] = $piece_element->element->type->name;
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
                            foreach ($piece->piece->editorPieceElements as $piece_element) {
                                $b++;
                                $pe_properties = $events = $gproperties = array();
                                foreach ($piece_element->editorPieceelementProperties as $pe_property) {
                                    $pe_properties[] = array('name' => $pe_property->property->name, 'value' => $pe_property->value);
                                }
                                if ($cobject->template->code == 'AEHC') {
                                    $pe_properties[] = array('name' => 'group', 'value' => $piece->piece->ID);
                                }
                                foreach ($piece_element->editorEvents as $event) {
                                    $events[] = array('name' => $event->type->name, 'event' => $event->event, 'action' => $event->action);
                                }
                                foreach ($piece_element->element->editorElementProperties as $gproperty) {
                                    if ($gproperty->property->name == 'libraryID') {
                                        $lib = Library::model()->findByAttributes(array('ID' => $gproperty->value));
                                        foreach ($lib->libraryProperties as $libproperty) {
                                            $gproperties[] = array('name' => $libproperty->property->name, 'value' => $libproperty->value);
                                        };
                                    } else {
                                        $gproperties[] = array('name' => $gproperty->property->name, 'value' => $gproperty->value);
                                    }
                                }
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['code'] = 'EP' . $piece_element->ID;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['elementProperties'] = $pe_properties;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['events'] = $events;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['generalProperties'] = $gproperties;
                                $json['contents'][$row['contentID']]['goals'][$row['goalID']]['cobjects'][$row['cobjectID']]['screens'][$w]['piecesets'][$v]['pieces'][$a]['elements'][$b]['type'] = $piece_element->element->type->name;
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

    //Funções para Render DB Online
    public function actionLogin()
    {
        $json = array();
        $login = isset($_POST['login']) ? $_POST['login'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if ($login !== null && $password !== null) {
            //Verificar se o usuário e senha são válidos
            $person = Person::model()->findByAttributes(array('login' => $login, 'password' => $password));
            if (count($person) > 0) {
                //Login e Senha estão corretos
                //
                //Actor
                $actor = Actor::model()->findByAttributes(array('person_id' => $person['id']));
                if (count($actor) > 0) {
                    //Essa pessoa possui um personagem. Então pode realizar Login
                    $json['authorization'] = true;
                    $json['actor']['name'] = $person['name'];

                    $json['actor']['id'] = $actor['id'];
                    $json['actor']['unity_id'] = $actor['unity_id'];

                    //Personage
                    $personage = Personage::model()->findByPk($actor['personage_id']);
                    $json['actor']['personage_name'] = $personage['name'];
                } else {
                    //Pessoa Sem Personagem
                    $json['actor'] = null;
                    $json['authorization'] = false;
                }
            } else {
                //Login e/ou a Senha está incorreta
                $json['actor'] = null;
                $json['authorization'] = false;
            }
        } else {
            $json['actor'] = null;
            $json['authorization'] = false;
        }


        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
    }

}
