<?php

//@todo 1 - Criação da tabela PieceSet-Element
//@todo 2 - Criação do modelo PieceSet-Element
//@done 3 - Remover o botão de Som e Imagem no enunciado do pieceset
//@todo 4 - Adicionar o botão Inserir Elementos
//@todo 5 - Criação uma função em JS para adicionar N elementos ao PieceSet de qualquer tipo
//@todo 6 - Criar função de associar elementos através do group ID 
//@todo 7 - Modificar no rendenrizador o template de texto para exibir o texto em HTML.
//@todo 8 - Mudar o método do editor para receber o CObjectID via get.
//@todo 9 - Possibilidade de Lincar ou anexar um texto à atividade.
//@todo 10- Modificar um input da descrition do PieceSet para textArea
//@todo 11- Versão offiline (Ruan)
//@todo 12 - Cadastrar blocos
//@todo 13 - Redenrizar blocos
//@todo 14 - Linque para visualizar atividade
//@done 15- Quantificar elementos do AEL a partir dos elementos respostas.
//@todo 16 - Listar TODAS as atividade prontas.
//@todo 17 - Terminar o Associar Elementos
//@done 18 - Corrigir os tipos das classes .element
//@done 19 - Modificar alguns eventos para usar o .live
//@done 20 - Pôr o agrupamento match nas divs('divs default') compostas por elemenstos do mesmo grupo
//@done 21 - Corrigir o SaveAll para se adequar aos matchs
//@done 22 - Corrigir o EditorControle para se adequar aos matchs
//@done 23 - Contabilizar a ordem dos matchs no add para o MTE
//@done 24 - Contabilizar a ordem dos matchs no add para o AEL
//@todo 25 - Contabilizar a ordem dos matchs no update para o MTE
//@todo 26 - Contabilizar a ordem dos matchs no update para o AEL
//@done 27 - Pôr imagem,texto na mesma div
//@done 28 - Criar contadores separados dos grupos para cada Template
//@done 29 - Corrigir o load das imagens do Associar Elementos
//@done 30 - Corrigir o load das imagens do Multiple Escolha
//@done 31 - Corrigir o load de elementos com mesmo grupo do Associar Elementos
//@todo 32 - Corrigir o load de elementos com mesmo grupo do Multiple Escola 

// 23-01 := 4;
// 24-01 := 1;


class EditorController extends Controller {

    public $layout = 'editor';
    public $TYPE_ELEMENT_TEXT = "TEXT";
    public $TYPE_ELEMENT_MULTIMIDIA = "MULTIMIDIA";
    public $TYPE_LIBRARY_IMAGE = "IMAGE";
    public $TYPE_LIBRARY_SOUND = "SOUND";
    public $TYPE_LIBRARY_MOVIE = "MOVIE";

    //==== Transaction Variable-  ====//
    // private $transaction;
    //=================================
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'upload', 'json', 'preeditor', 'filtergoal', 'poseditor'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        if (isset($_GET['cID']) || isset($_POST['cobjectID'])) {
            $this->render('index');
        } elseif (!isset($_POST['commonType']) && !isset($_POST['cobjectTemplate']) && !isset($_POST['cobjectTheme'])) {
            $this->redirect('/editor/preeditor');
        } else {
            if (isset($_POST['actGoal'])) {
                $this->render('index');
            } else {
                $this->redirect('/editor/preeditor?error=1');
            }
        }
    }

    public function actionPreeditor() {
        $this->render('preeditor');
    }

    public function actionPoseditor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['img'])) {
            //Na Solicitação AJAX
            //include( 'cutImage.class.php' );
            $oImg = new cutImage($_POST['img']);
            if ($oImg->valida() == 'OK') {
                $oImg->posicaoCrop($_POST['x'], $_POST['y']);
                $oImg->redimensiona($_POST['w'], $_POST['h'], 'crop');
                $oImg->grava($_POST['img']);
                //====== Atualizar o LibraryProperty ======//
                $libraryID = $_POST['libraryID'];
                $libsProperty = LibraryProperty::model()->findAllByAttributes(array('library_id' => $libraryID));
                foreach ($libsProperty as $libprop):
                    switch ($libprop->property_id) {
                        case 1 : $libprop->value = $_POST['w']; //Width
                            $libprop->save();
                            break;
                        case 2 : $libprop->value = $_POST['h']; //Height
                            $libprop->save();
                    }
                endforeach;
                //==================================================
            } else {
                $this->redirect('poseditor?error=' . $oImg->valida());
            }
        } else {
            //Solicitação Não AJAX
            // memory limit (nem todo server aceita)
            ini_set("memory_limit", "50M");
            set_time_limit(0);

            //--------------------------------------------
            $uploadedLibraryIDs = isset($_POST['uploadedLibraryIDs']) ? $_POST['uploadedLibraryIDs'] : null;
            if ($uploadedLibraryIDs == null) {
                $this->redirect('/editor');
            }

            $num_img = count($uploadedLibraryIDs);
            $i = 0;
            $idPropertySrc = $this->getPropertyIDByName('src', 'library');
            foreach ($uploadedLibraryIDs as $upLibId):
                $libsProperty[$i] = LibraryProperty::model()->findByAttributes(array('library_id' => $upLibId,
                    'property_id' => $idPropertySrc));
                $i++;
            endforeach;
            //--------------------------------------------          
            $j = 0;
            for ($i = 0; $i < $num_img; $i++) {

                $name_img[$i] = $libsProperty[$j]->value; // .value = srcOfimage
                $nome_extension = explode('.', $name_img[$i]);
                $extension = $nome_extension[1];
                // Não Recortar Gifs
                if ($extension == 'gif') {
                    $j++;
                    $i--;
                    $num_img--;
                    continue;
                }
                $libraryID[$i] = $libsProperty[$j]->library_id;
                $tem_crop = false;
                $img[$i] = '';
                if (isset($name_img[$i])) {
                    $newDir[$i] = Yii::app()->basePath . "/../rsc/library/images/" . $name_img[$i];
                    $newDir[$i] = str_replace('\\', "/", $newDir[$i]);
                    $newUrl[$i] = "/rsc/library/images/" . $name_img[$i];
                    $imagesize[$i] = getimagesize($newDir[$i]);
                    if ($imagesize[$i] !== false) {
                        $oImg = new cutImage($newDir[$i]);
                        if ($oImg->valida() == 'OK') {
                            // $oImg->redimensiona('400', '', '');
                            $oImg->grava($newDir[$i]);

                            $imagesize[$i] = getimagesize($newDir[$i]);
                            $img[$i] = '<img src="' . $newUrl[$i] . '" id="jcrop' . $i . '" ' . $imagesize[$i][3] . ' />';
                            $preview[$i] = '<img src="' . $newUrl[$i] . '" id="preview' . $i . '" ' . $imagesize[$i][3] . ' />';
                            $tem_crop = true;
                        }
                    }
                }
                $j++;
            }

            //=================================
            $this->layout = 'none';
            $property_img = array(array());
            for ($i = 0; $i < $num_img; $i++) {
                $property_img[$i]['newDir'] = $newDir[$i];
                $property_img[$i]['newUrl'] = $newUrl[$i];
                $property_img[$i]['imagesize'] = $imagesize[$i];
                $property_img[$i]['img'] = $img[$i];
                $property_img[$i]['preview'] = $preview[$i];
                $property_img[$i]['name_img'] = $name_img[$i];
                $property_img[$i]['tem_crop'] = $tem_crop;
                $property_img[$i]['libraryID'] = $libraryID[$i];
            }
            $this->render('poseditor', array('property_img' => $property_img));
        }
    }

    public function actionFiltergoal() {
        if (!isset($_POST['goalID'])) {
            $idDiscipline = $_POST['idDiscipline'];
            $idDegree = $_POST['idDegree'];
            if ($idDegree == "undefined") {
                $actGoal_disc = Yii::app()->db->createCommand('SELECT degree_id FROM act_goal 
            WHERE discipline_id =' . $idDiscipline . ' GROUP BY degree_id')->queryAll();
                $count_Agoal_disc = count($actGoal_disc);
                if ($count_Agoal_disc > 0) {
                    for ($i = 0; $i < $count_Agoal_disc; $i++) {
                        // Array dos Degrees - A cada repetição irá guarda 1 único registro 
                        $actDegree[$i] = Yii::app()->db->createCommand('SELECT id, name FROM act_degree
                WHERE id = ' . $actGoal_disc[$i]['degree_id'] . ' AND grade > 0')->queryAll();
                    }
                    $count_Adeg = count($actDegree);
                    if ($count_Adeg > 0) {
                        $str = "<div id='propertyAdeg' align='left'> 
                 Nível&nbsp;:&nbsp;
                 <select id='actDegree' name='actDegree'>  ";
                        for ($i = 0; $i < $count_Adeg; $i++) {
                            $str.= "<option value=" . $actDegree[$i][0]['id'] . ">" . $actDegree[$i][0]['name'] . "</option>";
                        }
                        $str.= "</select> 
              </div> ";

                        //Por padrão, como não foi selecionado algum Degree, mostrará o GOAL do 1° [0]
                        $actGoal_d = Yii::app()->db->createCommand('SELECT id, name FROM act_goal 
                     WHERE discipline_id =' . $idDiscipline . ' AND degree_id =' . $actDegree[0][0]['id'])->queryAll();
                        $count_Agoal_d = count($actGoal_d);
                        // No mínimo possui 1 registro
                        $str.= "<div id='propertyAgoal' class='propertyAgoal' align='center'>
                      <br> Objetivo&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
                        for ($i = 0; $i < $count_Agoal_d; $i++) {
                            $str.= "<option value=" . $actGoal_d[$i]['id'] . ">" . $actGoal_d[$i]['name'] . "</option>";
                        }

                        $str.= "</select>";
                        $str.= $this->searchCobjectofGoal($actGoal_d[0]['id']) .
                                "</div>                  

             <script type='text/javascript'>
                $('#actDegree').change(function(){
                    $('#propertyAgoal').load(\"filtergoal\", {idDiscipline: $('#actDiscipline').val(), idDegree: $('#actDegree').val()} ); 
                });
                $('#actGoal').change(function(){
                    $('#showCobjectIDs').load('filtergoal', {goalID: $('#actGoal').val()} );  
                });
                $('#actGoal,#actDegree,#actDiscipline').change(function(){
                    $('#error').hide(1000);
                });
             </script>";
                        echo $str;
                    } else {
                        //Não encontrou algum act_degree relacionado a esta disciplina(with grade>0)
                    }
                } else {
                    //Não encontrou algum goal para a disciplina selecionada
                    echo "<font color='red' size='2'>
                Não encontrou algum Objetivo para a disciplina selecionada !</font>";
                }
            } else {
                //Selecionou Algum Degree
                $actGoal_d = Yii::app()->db->createCommand('SELECT id, name FROM act_goal 
                     WHERE discipline_id =' . $idDiscipline . ' AND degree_id =' . $idDegree)->queryAll();
                $count_Agoal_d = count($actGoal_d);
                // No mínimo possui 1 registro
                $str = "<br> Objetivo&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
                for ($i = 0; $i < $count_Agoal_d; $i++) {
                    $str.= "<option value=" . $actGoal_d[$i]['id'] . ">" . $actGoal_d[$i]['name'] . "</option>";
                }
                $str.= "</select>";
                $str.= $this->searchCobjectofGoal($actGoal_d[0]['id']);
                $str.="
                <script language='javascript' type='text/javascript'>  
                $('#actGoal').change(function(){
                    $('#showCobjectIDs').load('filtergoal', {goalID: $('#actGoal').val()} );  
                }); </script> ";

                echo $str;
            }
        } else {
            //Somente Pesquisar Pelo GoalID
            $goalID = $_POST['goalID'];
            echo $this->searchCobjectofGoal($goalID);
        }
    }

    private function searchCobjectofGoal($actGoal_id) {
        //Se foi definida, então existe pelo menos a posição 0
        $IDActGoal = (isset($actGoal_id) ? $actGoal_id : -1);
        //Selecionando ou não algum Degree
        //==========Editar os Cobjects Existentes - As atividades========//
        //context = CobjectData  ; name = goal_id
        $context = "CobjectData";
        $name = "goal_id";
        $Cobj_met_typeID = $this->getTypeIDbyName_Context($context, $name);
        $cobject_metadata = Yii::app()->db->createCommand('SELECT cobject_id FROM cobject_metadata
            WHERE type_id =' . $Cobj_met_typeID . ' AND  value = ' . $IDActGoal)->queryAll();
        $count_CobjMdata = count($cobject_metadata);
        if ($count_CobjMdata > 0) {
            $str2 = "<div id='showCobjectIDs' align='left'>
              <br><span id='txtIDsCobject'> Lista de Cobjects para Goal Corrente  </span>
                <form id='cobjectIDS' name='cobjectIDS' method='POST' action='/editor/index/'>
                <select id='cobjectID' name='cobjectID' style='width:430px'>";
            for ($i = 0; $i < $count_CobjMdata; $i++) {
                $First_screen = EditorScreen::model()->findByAttributes(array('cobject_id' => $cobject_metadata[$i]['cobject_id']));
                if (isset($First_screen)) {
                    //Existe Pelo menos uma Screen
                    $First_screen_pieceSet = EditorScreenPieceset::model()->findByAttributes(
                            array('screen_id' => $First_screen->id));
                    if (isset($First_screen_pieceSet)) {
                        //Existe Pelo Menos Um PieceSet
                        $First_pieceSet = EditorPieceset::model()->findByPk($First_screen_pieceSet->pieceset_id);
                    }
                }
                $innerHtml = isset($First_pieceSet) ? $cobject_metadata[$i]['cobject_id'] . " ['" . $First_pieceSet->description . "']" : $cobject_metadata[$i]['cobject_id'];
                $str2.= "<option value=" . $cobject_metadata[$i]['cobject_id'] . ">"
                        . $innerHtml . "</option>";
            }
            $str2.= "</select>
                    <input type='hidden' name='op' value='load'> 
                         <input id='editCobject' name='editCobject' type='submit' value='Change Cobject'>
                    </div>";
            return $str2;
        }

        //=================================================================
    }

    public function actionJson() {
        $json = array();
        if (isset($_POST['op'])) {
//            if (!isset($this->transaction) && $_POST['op'] != 'load') {
//                //Criar Nova Transação
//                //======================
//                $this->transaction = Yii::app()->db->beginTransaction();
//                //======================
//            }
//            if ($_POST['op'] == 'finish') {
//                try {
//                    var_dump($this->transaction);exit();
//                    $this->transaction->commit();
//                    
//                } catch (Exception $e) {
//                    $this->transaction->rollback();
//                    throw $e;
//                }
//            }else

            if ($_POST['op'] == 'save' || $_POST['op'] == 'update' && isset($_POST['step'])) {

                switch ($_POST['step']) {
                    case "CObject":
                        if (isset($_POST['COtypeID'])
                                && isset($_POST['COtemplateType']) && isset($_POST['COgoalID'])) {
                            $typeID = $_POST['COtypeID'];
                            $templateID = $_POST['COtemplateType'];
                            $themeID = ($_POST['COthemeID'] != '-1') ? $_POST['COthemeID'] : NULL;
                            $goalID = $_POST['COgoalID'];

                            $newCobject = new Cobject();
                            $newCobject->type_id = $typeID;
                            $newCobject->template_id = $templateID;
                            $newCobject->theme_id = $themeID;
                            $newCobject->status = 'on';
                            $newCobject->insert();

                            $cobject = Cobject::model()->findByAttributes(array(), array('order' => 'id desc'));
                            $cobjectID = $cobject->id;

                            $type_id = $this->getTypeIDbyName_Context('CobjectData', 'goal_id');
                            $newCobjectMetadata = new CobjectMetadata();
                            $newCobjectMetadata->cobject_id = $cobjectID;
                            $newCobjectMetadata->type_id = $type_id;
                            $newCobjectMetadata->value = $goalID;
                            $newCobjectMetadata->insert();

                            $json['CObjectID'] = $cobjectID;
                        } else {
                            throw new Exception("ERROR: Dados do CObject insuficientes.<br>");
                        }
                        break;
                    case "Screen":
                        if (isset($_POST['CObjectID']) && isset($_POST['Ordem']) && isset($_POST['DomID'])) {

                            $DomID = $_POST['DomID'];
                            $cobjectID = $_POST['CObjectID'];
                            $ordem = $_POST['Ordem'];

                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $IDDB = $_POST['ID_BD'];
                                $newScreen = EditorScreen::model()->findByPk($IDDB);
//                                //Desvincular Relação Cobject_Screen - Quando é Excluída !
//                                
//                                $BrothersScreens = EditorScreen::model()->findAllByAttributes(array('cobject'));
                            } else {
                                $newScreen = new EditorScreen();
                            }

                            $newScreen->cobject_id = $cobjectID;
                            $newScreen->order = $ordem;
                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newScreen->save();
                                $screen = $newScreen;
                            } else {
                                $newScreen->insert();
                                $screen = EditorScreen::model()->findByAttributes(array(), array('order' => 'id desc'));
                            }
                            $screenID = $screen->id;

                            $json['DomID'] = $DomID;
                            $json['screenID'] = $screenID;
                        } else {
                            throw new Exception("ERROR: Dados da Screen insuficientes.<br>");
                        }
                        break;
                    case "PieceSet":
                        if (isset($_POST['description']) && isset($_POST['screenID'])
                                && isset($_POST['order']) && isset($_POST['templateID']) && isset($_POST['DomID'])) {

                            $DomID = $_POST['DomID'];
                            $description = $_POST['description'];

                            $screenID = $_POST['screenID'];
                            $order = $_POST['order'];
                            $templateID = $_POST['templateID'];

                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $IDDB = $_POST['ID_BD'];
                                $newPieceSet = EditorPieceset::model()->findByPk($IDDB);
                            } else {
                                $newPieceSet = new EditorPieceset();
                            }
                            $newPieceSet->template_id = $templateID;
                            $newPieceSet->description = $description;
                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newPieceSet->save();
                                $pieceSet = $newPieceSet;
                            } else {
                                $newPieceSet->insert();
                                $pieceSet = EditorPieceset::model()->findByAttributes(array(), array('order' => 'id desc'));
                            }

                            $pieceSetID = $pieceSet->id;

                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newScreenPieceSet = EditorScreenPieceset::model()->find(array(
                                    'condition' => 'screen_id =:screenID AND pieceset_id=:piecesetID',
                                    'params' => array(':screenID' => $screenID, ':piecesetID' => $pieceSetID)
                                        ));
                            } else {
                                $newScreenPieceSet = new EditorScreenPieceset();
                            }

                            $newScreenPieceSet->screen_id = $screenID;
                            $newScreenPieceSet->pieceset_id = $pieceSetID;
                            $newScreenPieceSet->order = $order;
                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newScreenPieceSet->save();
                            } else {
                                $newScreenPieceSet->insert();
                            }


                            $json['DomID'] = $DomID;
                            $json['PieceSetID'] = $pieceSetID;
                        } else {
                            throw new Exception("ERROR: Dados da PieceSet insuficientes.<br>");
                        }
                        break;
                    case "Piece":
                        if (isset($_POST['pieceSetID']) && isset($_POST['ordem'])
                                && isset($_POST['DomID']) && isset($_POST['screenID'])) {

                            $DomID = $_POST['DomID'];
                            $pieceSetID = $_POST['pieceSetID'];
                            $screenID = $_POST['screenID'];
                            $ordem = $_POST['ordem'];
                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $IDDB = $_POST['ID_BD'];
                                $newPiece = EditorPiece::model()->findByPk($IDDB);
                            } else {
                                $newPiece = new EditorPiece();
                            }


                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newPiece->save();
                                $piece = $newPiece;
                            } else {
                                $newPiece->insert();
                                $piece = EditorPiece::model()->findByAttributes(array(), array('order' => 'id desc'));
                            }

                            $pieceID = $piece->id;

                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newPieceSetPiece = EditorPiecesetPiece::model()->find(array(
                                    'condition' => 'piece_id =:pieceID AND pieceset_id=:piecesetID',
                                    'params' => array(':pieceID' => $pieceID, ':piecesetID' => $pieceSetID)
                                        ));
                            } else {
                                $newPieceSetPiece = new EditorPiecesetPiece();
                            }
                            $newPieceSetPiece->piece_id = $pieceID;
                            $newPieceSetPiece->pieceset_id = $pieceSetID;
                            $newPieceSetPiece->screen_id = $screenID;
                            $newPieceSetPiece->order = $ordem;
                            if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                $newPieceSetPiece->save();
                            } else {
                                $newPieceSetPiece->insert();
                            }

                            $json['DomID'] = $DomID;
                            $json['PieceID'] = $pieceID;
                        } else {
                            throw new Exception("ERROR: Dados da Piece insuficientes.<br>");
                        }
                        break;
                    case "Element":
                        if (isset($_POST['typeID']) || isset($_POST['justFlag'])) {

                            if (isset($_POST['typeID'])) {
                                $typeName = $_POST['typeID'];
                                $typeID = $this->getTypeIDByName($typeName);
                            }

                            if (isset($_POST['pieceID']) && isset($_POST['flag']) && isset($_POST['ordem'])
                                    && (isset($_POST['value']) || isset($_POST['justFlag']) ) && isset($_POST['DomID'])) {
                                $DomID = $_POST['DomID'];
                                $pieceID = $_POST['pieceID'];
                                $flag = $_POST['flag'];
                                $match = isset($_POST['match']) ? $_POST['match'] : -1;
                                if (isset($_POST['value'])) {
                                    $value = $_POST['value'];
                                }

                                $order = $_POST['ordem'];

                                $new = false;
                                $unlink_New = false;
                                $delete = false;
                                $justFlag = false;
                                if ($_POST['op'] == 'update' && isset($_POST['ID_BD']) &&
                                        isset($_POST['updated']) && $_POST['updated'] == 1) {
                                    //Desvincula e Cria um novo elemento !
                                    $IDDB = $_POST['ID_BD'];
                                    $newElement = EditorElement::model()->findByPk($IDDB);
                                    $Element_Piece = EditorPieceElement::model()->findByAttributes(
                                            array('piece_id' => $pieceID, 'element_id' => $newElement->id));
                                    
                                      var_dump($pieceID .' -- '.$newElement->id);
                                      
                                    $Element_Piece_Property = EditorPieceelementProperty::model()
                                            ->findAll(array(
                                        'condition' => 'piece_element_id=:idPieceElement',
                                        'params' => array(':idPieceElement' => $Element_Piece->id)
                                            ));
                                    $size_properties_Element_Piece = count($Element_Piece_Property);
                                    $ls = null;
                                    foreach ($Element_Piece_Property as $ls):
                                        // Excluir cada propriedade do Element_Piece
                                        $ls->delete();
                                    endforeach;
                                    //Depois, Desvincula o elemento da peça.                                  
                                    $Element_Piece->delete();

                                    $unlink_New = true;
                                } elseif ($_POST['op'] == 'update' && isset($_POST['ID_BD']) &&
                                        isset($_POST['updated']) && $_POST['updated'] == 0) {
                                    // Somente Atualiza a FLag
                                    $justFlag = true;
                                } else {
                                    //Cria um novo somente.
                                    $new = true;
                                }

                                if ($new || $unlink_New) {
                                    $newElement = new EditorElement(); // Cria um novo
                                    $newElement->type_id = $typeID; // novo tipo ou alterado
                                    $newElement->insert();
                                    $element = EditorElement::model()->findByAttributes(array(), array('order' => 'id desc'));
                                    $elementID = $element->id;
                                    $newPieceElement = new EditorPieceElement();
                                    $newPieceElement->piece_id = $pieceID;
                                    $newPieceElement->element_id = $elementID;
                                    $newPieceElement->order = $order;
                                    $newPieceElement->insert();
                                    $json['ElementID'] = $elementID;
                                    $pieceElement = EditorPieceElement::model()->findByAttributes(array('piece_id' => $pieceID, 'element_id' => $elementID), array('order' => 'id desc'));
                                    $pieceElementID = $pieceElement->id;

                                    //layertype
                                    $propertyName = "layertype";
                                    $propertyContext = "piecelement";
                                    $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                    //===========================================================
                                    $newPieceElementProperty = new EditorPieceelementProperty();
                                    $newPieceElementProperty->piece_element_id = $pieceElementID;
                                    $newPieceElementProperty->property_id = $propertyID;
                                    $newPieceElementProperty->value = $flag == "true" ? "Acerto" : "Erro";
                                    $newPieceElementProperty->insert();

                                    // grouping
                                    $propertyName = "grouping";
                                    $propertyContext = "piecelement";
                                    $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                    //===========================================================
                                    $newPieceElementProperty = new EditorPieceelementProperty();
                                    $newPieceElementProperty->piece_element_id = $pieceElementID;
                                    $newPieceElementProperty->property_id = $propertyID;
                                    $newPieceElementProperty->value = $match;
                                    $newPieceElementProperty->insert();

                                    if (isset($_POST["library"])) {
                                        $libraryTypeName = $_POST["library"];
                                        $libraryTypeID = $this->getTypeIDByName($libraryTypeName);

                                        if ($libraryTypeName == $this->TYPE_LIBRARY_IMAGE) {//image
                                            $src = $value['url'];
                                            $nome = $value['name'];
                                            $ext = explode(".", $nome);
                                            $ext = $ext[1];
                                            //Pegar informações da imagem
                                            //$url = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
                                            $path = Yii::app()->basePath;
                                            list($width, $height, $type) = getimagesize($path . "/../" . $src);
                                            //Salva library
                                            //type 9 
//                                            if ($unlink_New) { Can't
//                                                //Desvincular Element_Library
//                                                $propName = "library_id";
//                                                $propContext = "multimidia";
//                                                $propID = $this->getPropertyIDByName($propName, $propContext);
//                                                //Id da Library-Img
//                                                $ElementProperty_IDlib = EditorElementProperty::model()->find(array(
//                                                    'condition' => 'element_id =:elementID AND property_id=:propID',
//                                                    'params' => array(':elementID' => $elementID,
//                                                        ':propID' => $propID)));
//                                                // 
//                                                $ElementProperty_IDlib->delete;
//                                                //====================
//                                            } 

                                            $newLibrary = new Library();
                                            $library_typeName = $_POST['library'];
                                            $newLibrary->type_id = $this->getTypeIDByName($library_typeName);
                                            $newLibrary->insert();
                                            //Pegar o ID do ultimo adicionado.
                                            $library = Library::model()->findByAttributes(array(), array('order' => 'id desc'));
                                            $libraryID = $library->id;
                                            //Salva library_property 's
                                            //1 width
                                            $propertyName = "width";
                                            $propertyContext = $libraryTypeName;
                                            $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);

                                            $newLibraryProperty = new LibraryProperty();

                                            $newLibraryProperty->library_id = $libraryID;
                                            $newLibraryProperty->property_id = $propertyID;
                                            $newLibraryProperty->value = $width;
                                            $newLibraryProperty->insert();

                                            //2 height
                                            $propertyName = "height";
                                            $propertyContext = $libraryTypeName;
                                            $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                            $newLibraryProperty = new LibraryProperty();

                                            $newLibraryProperty->library_id = $libraryID;
                                            $newLibraryProperty->property_id = $propertyID;
                                            $newLibraryProperty->value = $height;
                                            $newLibraryProperty->insert();

                                            //5 src
                                            $propertyName = "src";
                                            $propertyContext = "library";
                                            $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                            $newLibraryProperty = new LibraryProperty();
                                            $newLibraryProperty->library_id = $libraryID;
                                            $newLibraryProperty->property_id = $propertyID;
                                            $newLibraryProperty->value = $nome; //apenas o nome do arquivo
                                            $newLibraryProperty->insert();

                                            //12 extension
                                            $propertyName = "extension";
                                            $propertyContext = "library";
                                            $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                            $newLibraryProperty = new LibraryProperty();
                                            $newLibraryProperty->library_id = $libraryID;
                                            $newLibraryProperty->property_id = $propertyID;
                                            $newLibraryProperty->value = $ext;
                                            $newLibraryProperty->insert();

                                            //Salva a editor_element_property
                                            //4 libraryID
                                            $propertyName = "library_id";
                                            $propertyContext = $typeName;
                                            $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                            $newElementProperty = new EditorElementProperty();

                                            $newElementProperty->element_id = $elementID;
                                            $newElementProperty->property_id = $propertyID;
                                            $newElementProperty->value = $libraryID;
                                            $newElementProperty->insert();
                                            $json['LibraryID'] = $libraryID;
                                        } elseif (false) {
                                            //Verificar - Se for um som.
                                        }
                                    } elseif ($typeName == $this->TYPE_ELEMENT_TEXT) {  //text
                                        //salva editor_element_property 's
                                        //text   
                                        $propertyName = "text";
                                        $propertyContext = "phrase";
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        $newElementProperty = new EditorElementProperty();
                                        $newElementProperty->element_id = $elementID;
                                        $newElementProperty->property_id = $propertyID;
                                        $newElementProperty->value = $value;
                                        $newElementProperty->insert();

                                        //language
                                        $propertyName = "language";
                                        $propertyContext = "element";
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        $newElementProperty = new EditorElementProperty();
                                        $newElementProperty->element_id = $elementID;
                                        $newElementProperty->property_id = $propertyID;
                                        $newElementProperty->value = "português";
                                        $newElementProperty->insert();
                                    } else {
                                        throw new Exception("ERROR: Tipo inválido.<br>");
                                    }
                                } elseif ($delete) {
                                    // Se deletou o Element                                  
                                } elseif ($justFlag) {
                                    // Apenas Atualiza as Flags
                                    $IDDB = $_POST['ID_BD'];
                                    $pieceElement = EditorPieceElement::model()->findByAttributes(array(
                                        'piece_id' => $pieceID,
                                        'element_id' => $IDDB));
                                    $change_flag = EditorPieceelementProperty::model()->findByAttributes(
                                            array('piece_element_id' => $pieceElement->id,
                                                'property_id' => $this->getPropertyIDByName('layertype', 'piecelement')));
                                    $change_flag->value = $flag == "true" ? "Acerto" : "Erro";
                                    $change_flag->save();
                                }
                            } else {
                                throw new Exception("ERROR: Dados da Element insuficientes.<br>");
                            }
                        } else {
                            throw new Exception("ERROR: Operação inválida.<br>");
                        }
                        break;
                    default:
                        throw new Exception("ERROR: Operação inválida.<br>");
                }
            } elseif ($_POST['op'] == 'load') {
                if (isset($_POST['cobjectID'])) {
                    $cobjectID = $_POST['cobjectID'];
                    $cobject = Cobject::model()->findByAttributes(array('id' => $cobjectID));
                    $json['cobject_id'] = $cobjectID;
                    $json['typeID'] = $cobject->type_id;
                    $json['themeID'] = $cobject->theme_id;
                    $json['templateID'] = $cobject->template_id;

                    $Srceens = EditorScreen::model()->findAllByAttributes(array('cobject_id' => $cobjectID), array('order' => '`order`'));

                    foreach ($Srceens as $sc):
                        $json['S' . $sc->id] = array();
                        $ScreenPieceset = EditorScreenPieceset::model()->findAllByAttributes(array('screen_id' => $sc->id), array('order' => '`order`'));
                        foreach ($ScreenPieceset as $scps):
                            $PieceSet = EditorPieceset::model()->findByAttributes(array('id' => $scps->pieceset_id));
                            $json['S' . $sc->id]['PS' . $PieceSet->id] = array();
                            $json['S' . $sc->id]['PS' . $PieceSet->id]['description'] = $PieceSet->description;
                            $json['S' . $sc->id]['PS' . $PieceSet->id]['template_id'] = $PieceSet->template_id;

                            $PieceSetPiece = EditorPiecesetPiece::model()->findAllByAttributes(array('pieceset_id' => $PieceSet->id), array('order' => '`order`'));
                            foreach ($PieceSetPiece as $psp):
                                $Piece = EditorPiece::model()->findByAttributes(array('id' => $psp->piece_id));
                                $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id] = array();
                                $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['description'] = $Piece->description;
                                $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['name'] = $Piece->name;

                                $PieceElement = EditorPieceElement::model()->findAllByAttributes(array('piece_id' => $psp->piece_id), array('order' => '`order`'));

                                foreach ($PieceElement as $pe):
                                    $Element = EditorElement::model()->findByAttributes(array('id' => $pe->element_id));
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id] = array();
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['type_name'] = $Element->type->name;
                                    $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                        'property_id' => $this->getPropertyIDByName('layertype', 'piecelement')));
                                    //var_dump($pe_property->value); exit();
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['flag'] = $pe_property->value;
                                    //=============== grouping ===============================
                                    $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                        'property_id' => $this->getPropertyIDByName('grouping', 'piecelement')));
                                    //var_dump($pe_property->value); exit();
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['match'] = $pe_property->value;
                                    
                                    $ElementProperty = EditorElementProperty::model()->findAllByAttributes(array('element_id' => $Element->id));
                                    foreach ($ElementProperty as $ep):
                                        if ($ep->property_id == $this->getPropertyIDByName('library_id', 'multimidia')) { //libraryID
                                            $Library = Library::model()->findByAttributes(array('id' => $ep->value));
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['L' . $Library->id] = array();
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['L' . $Library->id]['type_name'] = $Library->type->name; //9 image; 17 movie; 20 sound 
                                            $LibraryProperty = LibraryProperty::model()->findAllByAttributes(array('library_id' => $Library->id));
                                            foreach ($LibraryProperty as $lp):
                                                $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['L' . $Library->id][$lp->property->name] = $lp->value;
                                            endforeach;
                                        }else {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id][$ep->property->name] = $ep->value;
                                        }
                                    endforeach;
                                endforeach;
                            endforeach;
                        endforeach;
                    endforeach;
                }
            } elseif ($_POST['op'] == 'delete') {
                //Verificar Array de objetos para deletá-los
                $array_del = $_POST['array_del'];
                $size = count($array_del);
                $type = null;
                $id = null;
                $delAll_Ok = true;
                // Para cada elemento Excluído
                foreach ($array_del as $ls):
                    if ($ls[0] . $ls[1] == 'PS') {
                        $type = $ls[0] . $ls[1];
                        $id = str_replace($type, '', $ls);
                    } else {
                        $type = $ls[0];
                        $id = str_replace($type, '', $ls);
                    }

                    switch ($type) {
                        case 'S':$this->delScreen($id);
                            break;
                        case 'PS':$this->delPieceset($id);
                            break;
                        case 'P': $delAll_Ok = (!$this->delPiece($id)) ? false : $delAll_Ok;
                            break;
                        case 'E':
                            $expl_element = explode('P', $id);
                            $id_element = $expl_element[0];
                            $id_piece = $expl_element[1];
                            $delAll_Ok = (!$this->delElement($id_element, $id_piece)) ? false : $delAll_Ok;
                    }
                endforeach;
                if (!$delAll_Ok) {
                    throw new Exception("ERROR: NEM Todos os Objectos solicitados para deleção foram Deletados!<br>");
                }
                //--------------------------
            } else {
                throw new Exception("ERROR: Operação inválida.<br>");
            }
        } else {
            throw new Exception("ERROR: Operação inválida.<br>");
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
    }

    private function delScreen($id) {
        //Excluir Screen
        $delScreen = EditorScreen::model()->findByPk($id);
        $delPS = EditorScreenPieceset::model()->findAllByAttributes(
                array('screen_id' => $delScreen->id));
        foreach ($delPS as $dps):
            $pieceset_id = $dps->pieceset_id;
            //Deletar cada PieceSet
            $this->delPieceset($pieceset_id);
        endforeach;
        //Depois, Exclui a Screen                       
        $delScreen->delete();
        //============================ 
    }

    private function delPieceset($id) {
        $delPS = EditorScreenPieceset::model()->findByAttributes(
                array('pieceset_id' => $id));
        //Deleta 1° a relação ScreenPieceset
        $delPS->delete();
        $delP = EditorPiecesetPiece::model()->findAllByAttributes(
                array('pieceset_id' => $id));
        foreach ($delP as $dp):
            $piece_id = $dp->piece_id;
            //Deletar cada Piece
            $this->delPiece($piece_id);
        endforeach;
        //Depois, Exclui o PieceSet
        $delete_pieceSet = EditorPieceset::model()->findByPk($id);
        $delete_pieceSet->delete();
        //============================
    }

    private function delPiece($id) {
        $delP = EditorPiecesetPiece::model()->findByAttributes(
                array('piece_id' => $id));
        //Deleta 1° a relação Pieceset_Piece
        $delP->delete();
        $delE = EditorPieceElement::model()->findAllByAttributes(
                array('piece_id' => $id));
        $delpiece = true;
        foreach ($delE as $el):
            //Desvincular cada Elemento 
            $delpiece = (!$this->delElement($el->element_id, $id)) ? false : $delpiece;
        endforeach;
        //Depois, Exclui a peça Se Não existir Algum piece_element <=> performance_actor
        if ($delpiece) {
            $delete_piece = EditorPiece::model()->findByPk($id);
            $delete_piece->delete();
        }

        return $delpiece;
    }

    // Dois argumentos, pois, um elemento pode está em várias pieces
    private function delElement($id, $piece_id) {
        $newElement = EditorElement::model()->findByPk($id);
        $Element_Piece = EditorPieceElement::model()->findByAttributes(
                array('piece_id' => $piece_id, 'element_id' => $newElement->id));
        $Performance_Actor = PeformanceActor::model()->findByAttributes(
                array('piece_element_id' => $Element_Piece->id));
        //Somente DELETA se NÃO existir alguma PERFORMANCE ACTOR
        if (!isset($Performance_Actor)) {
            $Element_Piece_Property = EditorPieceelementProperty::model()
                    ->findAll(array(
                'condition' => 'piece_element_id=:idPieceElement',
                'params' => array(':idPieceElement' => $Element_Piece->id)
                    ));
            $size_properties_Element_Piece = count($Element_Piece_Property);
            $ls = null;
            foreach ($Element_Piece_Property as $ls):
                // Excluir cada propriedade do Element_Piece
                $ls->delete();
            endforeach;
            //Depois, Desvincula o elemento da peça.                                  
            $Element_Piece->delete();
            return true;
            //==========================
        }

        return false;
    }

    public function actionUpload() {
        $json = array();
        //Checa se existem arquivos
        if (isset($_FILES['file'])) {
            //checa se existe operação
            if (isset($_POST['op'])) {
                //se opreação for imagem
                if ($_POST['op'] == 'image') {
                    //define as extensões aceitas
                    $extencions = array(".png", ".gif", ".bmp", ".jpeg", ".jpg", ".ico");
                    //define tamanho máximo
                    $max_size = 1024 * 5; //5MB
                    //se operação for audio
                } elseif ($_POST['op'] == 'audio') {
                    //define as extensões aceitas
                    $extencions = array(".mp3", ".wav", ".ogg");
                    //define tamanho máximo
                    $max_size = 1024 * 10; //10MB
                    //se opração for video    
                } elseif ($_POST['op'] == 'video') {
                    //define as extensões aceitas
                    $extencions = array(".mp4", ".webm", ".ogg");
                    //define tamanho máximo
                    $max_size = 1024 * 20; //20MB
                }
                //define qual o endereço que será guardado o arquivo
                $type_multimidia = $_POST['op'] == 'image' ? $_POST['op'] . 's' : $_POST['op'];
                $path = Yii::app()->basePath . '/../rsc/library/' . $type_multimidia . '/';
                //define qual a url para visualização do arquivo
                $url = "/rsc/library/" . $type_multimidia . "/";

                //pega o nome do arquivo
                $file_name = $_FILES['file']['name'];
                //pega o tamanho do arquivo
                $file_size = $_FILES['file']['size'];

                //pega a extensão do arquivo
                $ext = strtolower(strrchr($file_name, "."));

                //se a extensão do arquivo estiver na array de extensão
                if (in_array($ext, $extencions)) {
                    //muda unidade do tamanho do arquivo
                    $size = round($file_size / 1024);
                    //se o tamanho for menor que o máximo
                    if ($size < $max_size) {
                        //gera um código md5 concatenado com a extensão para ser o nome do arquivo
                        //e evitar duplicatas
                        //=============================
                        $name = md5(uniqid(time())) . $ext;
                        ///=============================
                        //pega o nome temporário do arquivo, para poder move-lo
                        $tmp = $_FILES['file']['tmp_name'];
                        //tenta
                        try {
                            //move o arquivo temporário para o novo local
                            move_uploaded_file($tmp, $path . $name);
                            //adiciona ao retorno do json a URL e o nome do arquivo
                            $json['url'] = $url . $name;
                            $json['name'] = $name;
                            //se não funcionar
                        } catch (Exception $e) {
                            throw new Exception("ERROR: Falha ao enviar.<br>");
                        }
                    } else {
                        throw new Exception("ERROR: A arquivo deve ser de no máximo $size<br>");
                    }
                } else {
                    throw new Exception("ERROR: Somente são aceitos arquivos do tipo " . $_POST['op'] . ".<br>");
                }
            } else {
                throw new Exception("ERROR: Operação não definida.<br>");
            }
        } else {
            throw new Exception("ERROR: Selecione um arquivo.<br>");
        }
        //cria o cabeçalho do json
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        //escreve o json que sera retornado
        echo json_encode($json);
    }

    private function getTypeIDByName($str) {
        $typeName = $str;
        $type = CommonType::model()->findByAttributes(array('name' => strtolower($typeName)));
        $typeID = $type->id;

        return $typeID;
    }

    private function getTypeIDbyName_Context($context, $name) {
        $type = CommonType::model()->findByAttributes(array('context' => $context, 'name' => $name));
        return $type->id;
    }

    private function getTypeNameByID($str) {
        $typeID = $str;
        $type = CommonType::model()->findByAttributes(array('id' => $typeName));
        $typeName = $type->name;

        return $typeName;
    }

    private function getPropertyIDByName($str, $str2) {
        $propertyName = $str;
        $propertyContext = $str2;
        $property = CommonProperty::model()->findByAttributes(array('name' => strtolower($propertyName), 'context' => strtolower($propertyContext)));
        $propertyID = $property->id;

        return $propertyID;
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
