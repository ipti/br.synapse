
<?php

/*
  @done-1 - Correções nas condicionais do método loadCobject
  @done-2 - Agrupar elementos no Json
  @done-3 - Criar Arrays para a tree da atividade para todos os templates
  @done 4 - Criação do método no controller para acesso ao novo render
  @done 5 - Criar função ajax para carregar um Cobject específico.
  @done 6 - Corrigir o que é array e objeto nos grupos de elementos
  @done 7 - Corrigir o que é array e objeto nos elementos
  @done 8 - Construção da estrutura principal do build_image
  @done 9 - Criação do render.css
  @done 10 - Listar html básico do elememt Img
  @done 11 - Listar html básico do elememt sound
  @done 12 - Listar html básico do element Text
  @done 13 - Criação de um novo layout para o render
  @done 14 - Correção do seletor de elementos img do render.css
  @todo 15 - Corrigir a substituição de elementos de mesmo grupo na rendenrização do elemento na tela
  @done 16 - Corrigir o contador de elementos no Json do getCobjectID do RenderController
  @done 17 - Verificar se o array de elementos no Json já foi para criar o array de elementos do getCobjectID do RenderController
  @done 18 - Criação do buildInfo_Cobject, para apresentar informações do CObject corrente.
  @done 19 - Criação de classes css para a div de Informações do Cobject
  @done 20 - Separar visualmente os pieceSets.
  @done 21 - Separar o conteúdo do CObject das Informações do CObject

  @done 22 - Criação da função buildToolBar para adicionar ferramentas para usar durante a atividade
  @done 23 - Adicionar o botão nextScreen para viajar nas telas
  @done 24 - Criação do Script events.js para a criação das funcionalidade de cada evento chamado no render
  @done 25 - Criação da função para o botão nextSreen em events
 * @done 26 - Iniciar todas as screens como hide, com exeção do '.currentSreen'
 * @done 27 - Criação do buildInfo_PieceSet, para apresentar a descrição dos PieceSets.
 * @done 28 - Chamar o script de eventos, events.js somente depois de caregado todo o cobjects
 * @done 29 - Definir destaque para os grupos de elementos, no onclick
 * @done 30 - Construir style para organizar horizontalmente as divs dos grupos de  elementos
 * @done 31 - Torna os divs[group] do answer do AEL, hide quando iniciar o render
 * @done 32 - Definir opacidade quando clica um ou duas vezes
 * @done 33 - Quando clicar adcionar classe que indica o clique em cada elemento
 * @done 34 - Quando clicar em elementos do  ask - AEL, dá um hidden nos irmãos visíveis
 * @done 35 - Quando clicar em elementos do  ask - AEL, dá um show nos divs[group] do answer
 * @done 36 - Quando clicar em elementos do answer - AEL, dá um hidden na divs[group] do answer
 * @done 37 - Quando clicar em elementos do answer - Dá um show em todas as divs[group] que não estão 'clicadas'
 * @done 38 - Voltar o click do elemento ask-AEL, e assim escolher outro element ask
 * @done 39 - Criação da classe Meet.js 
 * @done 40 - Criação do método showMessage no Meet.js

 * @done 41 - Deixar o CObject como atributo de 'delegação' no Meet.js
 * @done 42 - Criação do setDomCobjects
 * @done 43 - Adcionar o headMeet
 * @done 44 - Criar o 'construtor' com informações do aluno,turma,escola
 * @done 45 - (antigo) Criação da função isset no meet.js
 * 
 * @todo 46 - Transpor as funções do events.js para meet.js
 * @todo 47 - Criação da função de init_Common para eventos 
 * @todo 48 - Criação da função init_AEL
 * @todo 49 - Criação da função isMatch para verificar se os elementos estão em right matched
 * @todo 50 - Criação da função shuffleArray para embaralhar um array qualquer
 * @todo 51 - 
 * @todo 52 - 
 * @todo 53 - 
 * 
 * 
 * 
 * 
 * 
  @todo 54 - Criar Login para o Render Somente com o JS(CPF + SENHA[Data_Nascimento])
 * 
 * 
  today:6:6;

 * 
 */

class RenderController extends Controller {

    public $layout = 'render';
    //MSG for Translate
    public $INVALID_ATTRIBUTES = "Atributes Inválidos";
    //
    private $tempArchiveZipMultiMedia = null;
    private $dir_library = "/library/";

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

    public function cobjectbyid($cobject_id, $buildZipMultimedia) {

        /**
         * RECONSTRUIR TUDO PARA DO PONTO DE VISTA DE SEMATICA FICA EXATAMENTE IDENTICO A ESTRUTURA QUE O RENDER PRECISARÁ, REMOVENDO DO EDITOR
         * COMPLEXIDADES NO TRATAMENTO DOS ELEMENTOS E AGRUPAMENTO. OU SEJA TRAZER AS REGRAS DE NEGÓCIO DO RENDER PARA AQUI.
         *
         */
        $buildZipMultimedia = isset($buildZipMultimedia) && $buildZipMultimedia;

        $sql = "SELECT * from render_cobjects where cobject_id = $cobject_id;";
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $row = $command->queryRow();
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
                        $a5 = (int) -1;
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
    }

    private function buildJsonElement($isCobjectElement, $isPiecesetElement, $father, &$json, $as, $buildZipMultimedia) {
        //Begin Function Element =======================================
        // $gproperties = ELEMENT_PROPERTY + LIBRARY_PROPERTY

        $pe_properties = $events = $gproperties = array();

        if (!$isPiecesetElement && !$isCobjectElement) {
            foreach ($father->editorPieceelementProperties as $property) {
                $pe_properties[$property->property->name] = $property->value;
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
                    $this->tempArchiveZipMultiMedia->addFile($src, '/library/' . $dir_uploadType . '/' . $libproperty->value);
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
            $aTemp['type'] = (string) $father->element->type->name;
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

    public function actionLoadcobject() {
        $cobject_id = $_REQUEST['ID'];
        $json = $this->cobjectbyid($cobject_id);
        echo json_encode($json);
        exit;
    }

    /**
     * 
     * @param
     */
    public function actionLoadtext() {
        $cobject_id = $_REQUEST['ID'];
        $json = $this->cobjectbyid($cobject_id);
        $json = json_encode($json);
        $this->render('text', array('json' => $json));
    }

    public function actionLoadcobjects() {
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
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('listcobjects', 'loadtext', 'compute', 'loadcobject', 'stage',
                    'index', 'view', 'create', 'update', 'json', 'mount', 'login', 'logout',
                    'filter', 'loadcobjects', 'canvas', 'testepreview', 'meet', 'exportToOffline',
                    'importPeformance', 'getSchool', 'getCobject_blocks', 'getDisciplines'),
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

    public function actionMeet() {
        if (isset($_POST["actor"])) {
            $this->render("meet");
        } else {
            $this->redirect("/render/filter");
        }
    }

    public function actionExportToOffline() {
        if (isset($_REQUEST['school']) || isset($_REQUEST['cobject_block'])) {
            if (isset($_REQUEST['school'])) {
                $school = Unity::model()->findByPk($_REQUEST['school']);
                //Obtendo a escola agora pesquisa seus filhos, as suas turmas e seleciona todos os actores dessa turma
                $query = "SELECT u.id AS unity_id, u.name AS unity_name, 
                    u.organization_id AS unity_organization_id, u.father_id AS unity_father,
                    act.id, person.name, personage.name AS personage, person.login, person.password 
                    FROM unity_tree AS ut
                    INNER JOIN unity AS u ON(ut.secondary_unity_id = u.id)
                    INNER JOIN organization AS o ON(ut.secondary_organization_id = o.id)
                    INNER JOIN actor AS act ON(act.unity_id = ut.secondary_unity_id)
                    INNER JOIN person ON(act.person_id = person.id)
                    INNER JOIN personage ON(act.personage_id = personage.id)
                    WHERE (ut.primary_organization_id = " . $school->organization_id . "
                    AND ut.primary_unity_id = " . $school->id . ") 
                    OR (ut.secondary_organization_id = " . $school->organization_id . "
                    AND ut.secondary_unity_id = " . $school->id . "); ";

                //Criar Objeto user => actor_id, name, name_personage, login, senha
                $array_actorsOwnUnity = Yii::app()->db->createCommand($query)->queryAll();
            }
            
            $nameDisciplineSelected = "";
            //Obter as disciplinas
            $disciplines = ActDiscipline::model()->findAll();
            $array_disciplines = array();
            foreach ($disciplines as $idx => $discipline):
                $array_disciplines[$idx]['id'] = $discipline->id;
                $array_disciplines[$idx]['name'] = $discipline->name;
                
                if($_POST['discipline'] == $discipline->id){
                    $nameDisciplineSelected = substr($discipline->name,0,3);
                }
            endforeach;
            
            
            //Obter o CobjectBloco Selecionado
            $cobjectBlock = Cobjectblock::model()->findByPk($_REQUEST['cobject_block']);
            $array_cobjectBlock = array();
            $array_cobjectBlock[0]['id'] = $cobjectBlock->id;
            $array_cobjectBlock[0]['name'] = $cobjectBlock->name;
            $array_cobjectBlock[0]['discipline_id'] = $cobjectBlock->discipline_id;

            //Obter os Cobject_cobjectBlock do CobjectBlock acima
            $cobject_cobjectBlocks = CobjectCobjectblock::model()->findAllByAttributes(
                    array('cobject_block_id' => $array_cobjectBlock[0]['id']));
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
                $zipname = 'importRender_' . date('d_m_Y H_i_s') . '.zip';
                $this->tempArchiveZipMultiMedia = new ZipArchive;
                $this->tempArchiveZipMultiMedia->open($zipname, ZipArchive::CREATE);
                $this->tempArchiveZipMultiMedia->addEmptyDir("/library/image/");
                $this->tempArchiveZipMultiMedia->addEmptyDir("/library/sound/");
                $this->tempArchiveZipMultiMedia->addEmptyDir("/json/");

                foreach ($cobjectCobjectblocks as $cobjectCobjectblock):
                    array_push($json_cobjects, $this->cobjectbyid($cobjectCobjectblock->cobject_id, true));
                endforeach;

                // Fazer Download no Final
                //Arquivo Json para adcionar no ZIP
                $json = array();
                //Tratar Separação no JS
                $json['ActorsOwnUnity'] = $array_actorsOwnUnity;
                $json['Disciplines'] = $array_disciplines;
                $json['CobjectBlock'] = $array_cobjectBlock;
                $json['Cobject_cobjectBlocks'] = $array_cobject_cobjectBlocks;
                $json['Cobjects'] = $json_cobjects;
                $json_encode = "var dataJson$nameDisciplineSelected = ";
                $json_encode.=json_encode($json);
                $json_encode.=";";

                $this->tempArchiveZipMultiMedia->addFromString("/json/renderData$nameDisciplineSelected.js", $json_encode);

                //Salva as alterações no zip
                $this->tempArchiveZipMultiMedia->close();


                if (file_exists($zipname)) {

                    header('Content-type: application/zip');
                    header('Content-Disposition: attachment; filename="' . $zipname . '"');
                    readfile($zipname);
                    //Remover o arquivo zip do temp do servidor
                    unlink($zipname);
                }
            }
        } else {
            //Carrega a página para exportar para o render Offline
            $this->render("exportToOffline");
        }
    }

    public function actionImportPeformance() {

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
                $strSqlPerformInserts = "INSERT INTO `synapse`.`peformance_actor`"
                        . "(`actor_id`, `piece_id`, `group_id`, `final_time`, `iscorrect`, `value` ) VALUES";
                $totalPeformances = count($peformances);
                foreach ($peformances as $idx => $peform):
                    $strSqlPerformInserts.='( "';
                    $strSqlPerformInserts.= $peform->actor_id . '", "' . $peform->piece_id
                            . '", "' . $peform->group_id . '", "' . $peform->final_time
                            . '", "' . $peform->iscorrect . '", "' . $peform->value;
                    $strSqlPerformInserts.='" )';
                    if($idx < $totalPeformances-1){
                        $strSqlPerformInserts.=", ";
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

    public function actionGetSchool() {
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

    public function actionGetDisciplines() {
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

    public function actionGetCobject_blocks() {
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

    public function actionIndex() {
        if (Yii::app()->session['personage'] == "Tutor") {
            $this->redirect("/render/filter");
        } else {
            $this->redirect("/render/meet");
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

    public function actionStage() {

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
            $where.= " and (a6.id in($contentsIn) or a6.id not in($contentOut))";
        } else if (isset($contentsIn) && !isset($contentOut)) {
            $where.= " and (a6.id in($contentsIn))";
        } else if (isset($contentOut) && !isset($contentsIn)) {
            $where.= " and (a6.id not in($contentOut))";
        }
        if (isset($blockID) && !empty($blockID)) {
            $join .= " left join cobject_cobjectblock ccobj on(ccobj.cobject_id=ro.cobject_id)";
            $where .=" and ccobj.cobject_block_id=$blockID";
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

}
