<?php

class EditorController extends Controller {

    public $layout = 'editor';
    public $TYPE_ELEMENT_TEXT = "TEXT";
    public $TYPE_ELEMENT_MULTIMIDIA = "MULTIMIDIA";
    public $TYPE_LIBRARY_IMAGE = "IMAGE";
    public $TYPE_LIBRARY_SOUND = "SOUND";
    public $TYPE_LIBRARY_MOVIE = "MOVIE";
    public $TYPE_ELEMENT_SHAPE = "SHAPE";

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
                'actions' => array('index', 'upload', 'json', 'preeditor', 'filtergoal', 'poseditor', 'getLastCobjectID', 'addAlias', 'getMultimidias'),
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
            $uploaded_ImagesIDs = isset($_POST['uploaded_ImagesIDs']) ? $_POST['uploaded_ImagesIDs'] : null;
            if ($uploaded_ImagesIDs == null) {
                $this->redirect('/editor');
            }

            $num_img = count($uploaded_ImagesIDs);
            $i = 0;
            $idPropertySrc = CommonProperty::getPropertyIDByName('src', 'library');
            foreach ($uploaded_ImagesIDs as $upLibId):
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
                    $newDir[$i] = Yii::app()->basePath . "/../library/image/" . $name_img[$i];
                    $newDir[$i] = str_replace('\\', "/", $newDir[$i]);
                    $newUrl[$i] = "/library/image/" . $name_img[$i];
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
        $option = array();
        $order = isset($_POST['order']) ? $_POST['order'] : null;
        $option['order'] = $order;
        if (!isset($_POST['goalID'])) {
            $idDiscipline = $_POST['idDiscipline'];
            $idDegree = $_POST['idDegree'];
            if ($idDegree == "undefined") {
                $actGoal_disc = Yii::app()->db->createCommand('SELECT g.degree_id FROM act_goal AS g 
                  INNER JOIN act_degree AS d ON(g.degree_id = d.id) 
                  WHERE g.discipline_id =' . $idDiscipline . ' AND d.name LIKE "%Fundamental%" GROUP BY g.degree_id')->queryAll();
                $count_Agoal_disc = count($actGoal_disc);
                if ($count_Agoal_disc > 0) {
                    for ($i = 0; $i < $count_Agoal_disc; $i++) {
                        // Array dos Degrees - A cada repetição irá guarda 1 único registro 
                        $actDegree[$i] = Yii::app()->db->createCommand('SELECT id, name FROM act_degree
                WHERE id = ' . $actGoal_disc[$i]['degree_id'] . ' AND grade > 0')->queryAll();
                    }
                    $count_Adeg = count($actDegree);
                    if ($count_Adeg > 0) {
                        //$actDegree[$i][0]
                        //Por padrão, como não foi selecionado algum Degree, mostrará o GOAL do 1° [0]
                        $actGoal_d = Yii::app()->db->createCommand('SELECT id, name FROM act_goal 
                     WHERE discipline_id =' . $idDiscipline . ' AND degree_id =' . $actDegree[0][0]['id'] . ' ORDER BY name ASC;')->queryAll();
                        $count_Agoal_d = count($actGoal_d);
                        // No mínimo possui 1 registro
                        $option['degree'] = $actDegree;
                        $option['goal'] = $actGoal_d;
                        $option['cObjects'] = $this->searchCobjectofGoal($actGoal_d[0]['id']);
                        echo json_encode($option);
                    } else {
                        //Não encontrou algum act_degree relacionado a esta disciplina(with grade>0)
                    }
                } else {
                    //Não encontrou algum goal para a disciplina selecionada
                    $option['error'] = "NoGoal";
                    echo json_encode($option);
                }
            } else {
                //Selecionou Algum Degree
                $actGoal_d = Yii::app()->db->createCommand('SELECT id, name FROM act_goal 
                     WHERE discipline_id =' . $idDiscipline . ' AND degree_id =' . $idDegree . ' ORDER BY name ASC;')->queryAll();
                $count_Agoal_d = count($actGoal_d);
                // No mínimo possui 1 registro
                $option['goal'] = $actGoal_d;
                $option['cObjects'] = $this->searchCobjectofGoal($actGoal_d[0]['id']);
                echo json_encode($option);
            }
        } else {
            //Somente Pesquisar Pelo GoalID
            $goalID = $_POST['goalID'];
            $option['cObjects'] = $this->searchCobjectofGoal($goalID);
            echo json_encode($option);
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
        $Cobj_met_typeID = CommonType::getTypeIDbyName_Context($context, $name);
        $cobject_metadata = Yii::app()->db->createCommand('SELECT cobject_id FROM cobject_metadata
            WHERE type_id =' . $Cobj_met_typeID . ' AND  value = ' . $IDActGoal)->queryAll();
        $count_CobjMdata = count($cobject_metadata);
        $option = array();
        if ($count_CobjMdata > 0) {
            //Verificar o porquê de adicionar uma outra tag do form 
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
                $option[$i]['id'] = $cobject_metadata[$i]['cobject_id'];
                $option[$i]['value'] = $innerHtml;
            }

            return $option;
        }

        //=================================================================
    }

    public function actionJson() {

        $transaction = Yii::app()->db->beginTransaction();

        try {
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
                            if ($_POST['op'] == 'save') {
                                if (isset($_POST['COtypeID']) && isset($_POST['COtemplateType']) && isset($_POST['COgoalID'])) {
                                    $typeID = $_POST['COtypeID'];
                                    $templateID = $_POST['COtemplateType'];
                                    $themeID = ($_POST['COthemeID'] != '-1') ? $_POST['COthemeID'] : NULL;
                                    $goalID = $_POST['COgoalID'];
                                    $description = $_POST['COdescription'];

                                    $newCobject = new Cobject();
                                    $newCobject->type_id = $typeID;
                                    $newCobject->template_id = $templateID;
                                    $newCobject->theme_id = $themeID;
                                    $newCobject->status = 'on';
                                    $newCobject->description = $description;
                                    $newCobject->insert();

                                    $cobject = Cobject::model()->findByAttributes(array(), array('order' => 'id desc'));
                                    $cobjectID = $cobject->id;

                                    $type_id = CommonType::getTypeIDbyName_Context('CobjectData', 'goal_id');
                                    $newCobjectMetadata = new CobjectMetadata();
                                    $newCobjectMetadata->cobject_id = $cobjectID;
                                    $newCobjectMetadata->type_id = $type_id;
                                    $newCobjectMetadata->value = $goalID;
                                    $newCobjectMetadata->insert();

                                    $json['CObjectID'] = $cobjectID;
                                } else {
                                    throw new Exception("ERROR: Dados do CObject insuficientes.<br>");
                                }
                            } else if ($_POST['op'] == 'update') {
                                // Somente Atualizar por enquanto a descrição do Cobject
                                $cobject_id = $_POST['CObjectID'];
                                $cobject_description = $_POST['COdescription'];
                                $cobject = Cobject::model()->findByPk($cobject_id);
                                $cobject->description = $cobject_description;
                                $cobject->save();
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
                            if (isset($_POST['description']) && isset($_POST['screenID']) && isset($_POST['order']) && isset($_POST['templateID']) && isset($_POST['DomID'])) {

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
                            if (isset($_POST['pieceSetID']) && isset($_POST['ordem']) && isset($_POST['DomID']) && isset($_POST['screenID'])) {

                                $DomID = $_POST['DomID'];
                                $pieceSetID = $_POST['pieceSetID'];
                                $screenID = $_POST['screenID'];
                                $ordem = $_POST['ordem'];
                                $typeName = isset($_POST['typeName']) ? $_POST['typeName'] : null;

                                if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                    $IDDB = $_POST['ID_BD'];
                                    $newPiece = EditorPiece::model()->findByPk($IDDB);
                                } else {
                                    $newPiece = new EditorPiece();
                                }

                                if (isset($typeName)) {
                                    $typeID = CommonType::getTypeIDbyName_Context('piece', $typeName);
                                    $newPiece->type_id = $typeID;
                                }

                                if ($_POST['op'] == 'update' && isset($_POST['ID_BD'])) {
                                    $newPiece->save();

                                    //Se for uma piece do Template Desenho
                                    if ($typeName == $this->TYPE_ELEMENT_SHAPE) {
                                        //Atualiza
                                        if (isset($_POST['shape'])) {
                                            //O Template é o Desenho
                                            //Propriedade Type_Shape
                                            $propertyName = "type_shape";
                                            $propertyContext = "piece";
                                            $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

                                            $piecePropertyShape = EditorPieceProperty::model()
                                                    ->findByAttributes(array('piece_id' => $newPiece->id, 'property_id' => $propertyID));

                                            $piecePropertyShape->value = $_POST["shape"];
                                            $piecePropertyShape->save();
                                        }
                                    }

                                    $piece = $newPiece;
                                } else {
                                    $newPiece->insert();

                                    //Se for uma piece do Template Desenho
                                    if ($typeName == $this->TYPE_ELEMENT_SHAPE) {
                                        if (isset($_POST['shape'])) {
                                            //O Template é o Desenho
                                            //Propriedade Type_Shape
                                            $newPiecePropertyShape = new EditorPieceProperty();
                                            $newPiecePropertyShape->piece_id = $newPiece->id;

                                            $propertyName = "type_shape";
                                            $propertyContext = "piece";
                                            $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                            $newPiecePropertyShape->property_id = $propertyID;
                                            $newPiecePropertyShape->value = $_POST["shape"];
                                            $newPiecePropertyShape->insert();
                                        }
                                    }

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
                            // var_dump($_POST);exit();
                            if (isset($_POST['typeID']) || isset($_POST['justFlag'])) {

                                if (isset($_POST['typeID'])) {
                                    $typeName = $_POST['typeID'];
                                    $typeID = $this->getTypeIDByName($typeName);
                                }

                                $justFlag = false;

                                if ((isset($_POST['pieceID']) || isset($_POST['pieceSetID']) ||
                                        isset($_POST['cobjectID'])) &&
                                        isset($_POST['value']) && isset($_POST['DomID'])) {
                                    $DomID = $_POST['DomID'];
                                    $isElementPieceSet = false;
                                    $isElementCobject = false;

                                    if (isset($_POST['pieceID'])) {
                                        $pieceID = $_POST['pieceID'];
                                    } else if (isset($_POST['pieceSetID'])) {
                                        $isElementPieceSet = true;
                                        $pieceSetID = $_POST['pieceSetID'];
                                    } else if (isset($_POST['cobjectID'])) {
                                        $isElementCobject = true;
                                        $cobjectID = $_POST['cobjectID'];
                                    }


                                    $flag = isset($_POST['flag']) ? $_POST['flag'] : -1;
                                    $match = isset($_POST['match']) ? $_POST['match'] : -1;
                                    if (isset($_POST['value'])) {
                                        $value = $_POST['value'];
                                    }
                                    if (isset($_POST['ordem'])) {
                                        $order = $_POST['ordem'];
                                    } else {
                                        //Não importa a posição
                                        $order = 0;
                                    }

                                    $new = false;
                                    $unlink_New = false;
                                    $delete = false;


                                    if ($_POST['op'] == 'update' && isset($_POST['ID_BD']) &&
                                            isset($_POST['updated']) && $_POST['updated'] == 1) {
                                        $IDDB = $_POST['ID_BD'];
                                        $newElement = EditorElement::model()->findByPk($IDDB);
                                        if ($_POST['typeID'] != "TEXT") {
                                            //Desvincula e Cria um novo elemento !
                                            if (!$isElementPieceSet && !$isElementCobject) {
                                                //É um elemento da PIECE
                                                $Element_Piece = EditorPieceElement::model()->findByAttributes(
                                                        array('piece_id' => $pieceID, 'element_id' => $newElement->id));

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
                                            }else if ($isElementPieceSet) {
                                                //É um elemento da PIECESET
                                                $Element_PieceSet = EditorPiecesetElement::model()->findByAttributes(
                                                        array('pieceset_id' => $pieceSetID, 'element_id' => $newElement->id));

                                                //Depois, Desvincula o elemento da PieceSet. 
                                                $Element_PieceSet->delete();
                                            } else if ($isElementCobject) {
                                                //É um elemento do Cobject
                                                $Element_Cobject = CobjectElement::model()->findByAttributes(
                                                        array('cobject_id' => $cobjectID, 'element_id' => $newElement->id));

                                                //Depois, Desvincula o elemento do Cobject. 
                                                $Element_Cobject->delete();
                                            }

                                            $unlink_New = true;
                                        } else {
                                            //Elementos textos somente precisam Atualizar seu campo
                                            //obs: verificar essa condição para os demais elementos != template TXT
                                            //salva editor_element_property 's
                                            //text   
                                            $elementID = $newElement->id;
                                            $propertyName = "text";
                                            $propertyContext = "phrase";
                                            $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                            $newElementProperty = EditorElementProperty::model()->findByAttributes(array(
                                                'element_id' => $elementID, 'property_id' => $propertyID
                                            ));
                                            $newElementProperty->value = $value;
                                            $newElementProperty->save();

                                            //language
                                            $propertyName = "language";
                                            $propertyContext = "element";
                                            $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                            $newElementProperty = EditorElementProperty::model()->findByAttributes(array(
                                                'element_id' => $elementID, 'property_id' => $propertyID
                                            ));
                                            $newElementProperty->value = "português";
                                            $newElementProperty->save();

                                            //Se for template Caça-Palavra, atualiza o Showing Letter e o PosX e PosY
                                            if (isset($_POST["showing_letters"])) {
                                                //Propriedade de showing_letters
                                                $propertyName = "showing_letters";
                                                $propertyContext = "word";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

                                                $pieceElement = EditorPieceElement::model()->findByAttributes(array('piece_id' => $_POST["pieceID"], 'element_id' => $elementID));
                                                $pePropertyShowLetters = EditorPieceelementProperty::model()->findByAttributes(array(
                                                    'piece_element_id' => $pieceElement->id,
                                                    'property_id' => $propertyID
                                                ));
                                                //Altera a propriedade Showing Letters
                                                $pePropertyShowLetters->value = $_POST["showing_letters"];
                                                $pePropertyShowLetters->save();
                                            }

                                            if (isset($_POST["posx"])) {
                                                //Propriedade da posição em X (Colunm)
                                                $propertyName = "posx";
                                                $propertyContext = "piecelement";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $pieceElement = EditorPieceElement::model()->findByAttributes(array('piece_id' => $_POST["pieceID"], 'element_id' => $elementID));
                                                $pePropertyPosX = EditorPieceelementProperty::model()->findByAttributes(array(
                                                    'piece_element_id' => $pieceElement->id,
                                                    'property_id' => $propertyID
                                                ));
                                                $pePropertyPosX->value = $_POST["posx"];
                                                $pePropertyPosX->save();
                                            }

                                            if (isset($_POST["posy"])) {
                                                //Propriedade da posição em Y (Row)
                                                $propertyName = "posy";
                                                $propertyContext = "piecelement";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $pePropertyPosY = EditorPieceelementProperty::model()->findByAttributes(array(
                                                    'piece_element_id' => $pieceElement->id,
                                                    'property_id' => $propertyID
                                                ));
                                                $pePropertyPosY->value = $_POST["posy"];
                                                $pePropertyPosY->save();
                                            }
                                        }
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

                                        if (!$isElementPieceSet && !$isElementCobject) {
                                            $newPieceElement = new EditorPieceElement();
                                            $newPieceElement->piece_id = $pieceID;
                                            $newPieceElement->element_id = $elementID;
                                            $newPieceElement->position = $order;
                                            $newPieceElement->insert();

                                            //Se for PLC. Inseri o direction e lettersShows
                                            if (isset($_POST["direction"])) {
                                                //Propriedade de Direção
                                                $newPEPropertyDirection = new EditorPieceelementProperty();
                                                $newPEPropertyDirection->piece_element_id = $newPieceElement->id;

                                                $propertyName = "direction";
                                                $propertyContext = "word";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newPEPropertyDirection->property_id = $propertyID;
                                                $newPEPropertyDirection->value = $_POST["direction"];
                                                $newPEPropertyDirection->insert();
                                            }
                                            if (isset($_POST["showing_letters"])) {
                                                //Propriedade de showing_letters
                                                //Se for Novo Elemento
                                                $propertyName = "showing_letters";
                                                $propertyContext = "word";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

                                                $newPEPropertyShowLetters = new EditorPieceelementProperty();
                                                $newPEPropertyShowLetters->piece_element_id = $newPieceElement->id;

                                                $newPEPropertyShowLetters->property_id = $propertyID;
                                                $newPEPropertyShowLetters->value = $_POST["showing_letters"];
                                                $newPEPropertyShowLetters->insert();
                                            }

                                            if (isset($_POST["posx"])) {
                                                //Propriedade da posição em X (Colunm)
                                                $newPEPropertyPosX = new EditorPieceelementProperty();
                                                $newPEPropertyPosX->piece_element_id = $newPieceElement->id;

                                                $propertyName = "posx";
                                                $propertyContext = "piecelement";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newPEPropertyPosX->property_id = $propertyID;
                                                $newPEPropertyPosX->value = $_POST["posx"];
                                                $newPEPropertyPosX->insert();
                                            }

                                            if (isset($_POST["posy"])) {
                                                //Propriedade da posição em Y (Row)
                                                $newPEPropertyPosY = new EditorPieceelementProperty();
                                                $newPEPropertyPosY->piece_element_id = $newPieceElement->id;

                                                $propertyName = "posy";
                                                $propertyContext = "piecelement";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newPEPropertyPosY->property_id = $propertyID;
                                                $newPEPropertyPosY->value = $_POST["posy"];
                                                $newPEPropertyPosY->insert();
                                            }
                                        } else if ($isElementPieceSet) {
                                            //É um elemento da PIECESET
                                            $newPieceSetElement = new EditorPiecesetElement();
                                            $newPieceSetElement->pieceset_id = $pieceSetID;
                                            $newPieceSetElement->element_id = $elementID;
                                            $newPieceSetElement->position = $order;
                                            $newPieceSetElement->insert();
                                        } else if ($isElementCobject) {
                                            //É um elemento do Cobject
                                            $newCobjectElement = new CobjectElement();
                                            $newCobjectElement->cobject_id = $cobjectID;
                                            $newCobjectElement->element_id = $elementID;
                                            $newCobjectElement->position = $order;
                                            $newCobjectElement->insert();
                                        }

                                        $json['ElementID'] = $elementID;

                                        if (!$isElementPieceSet && !$isElementCobject) {
                                            $pieceElement = EditorPieceElement::model()->findByAttributes(array('piece_id' => $pieceID, 'element_id' => $elementID), array('order' => 'id desc'));
                                            $pieceElementID = $pieceElement->id;

                                            //===========================================================
                                            if ($match != -1) {
                                                //CORIGGIR O SALVAR DE CADA GRUPO
                                                // grouping
                                                $propertyName = "grouping";
                                                $propertyContext = "piecelement";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                //===========================================================
                                                $newPieceElementProperty = new EditorPieceelementProperty();
                                                $newPieceElementProperty->piece_element_id = $pieceElementID;
                                                $newPieceElementProperty->property_id = $propertyID;
                                                $newPieceElementProperty->value = $match;
                                                $newPieceElementProperty->insert();
                                            }
                                            if ($flag != -1) {
                                                //Inseri a Flag
                                                $propertyName = "layertype";
                                                $propertyContext = "piecelement";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                //===========================================================
                                                $newPieceElementProperty = new EditorPieceelementProperty();
                                                $newPieceElementProperty->piece_element_id = $pieceElementID;
                                                $newPieceElementProperty->property_id = $propertyID;
                                                $newPieceElementProperty->value = $flag == "true" ? "Acerto" : "Erro";
                                                $newPieceElementProperty->insert();
                                                //====================
                                            }
                                        }

                                        if (isset($_POST["library"])) {
                                            $libraryTypeName = $_POST["library"];
                                            $libraryTypeID = $this->getTypeIDByName($libraryTypeName);

                                            if ($libraryTypeName == $this->TYPE_LIBRARY_IMAGE) {//image
                                                $src = $value['url'];
                                                $nome = $value['name'];
                                                $oldName = $value['oldName'];
                                                $ext = explode(".", $nome);
                                                $ext = $ext[1];
                                                //Pegar informações da imagem
                                                //$url = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
                                                $path = Yii::app()->basePath;
                                                list($width, $height, $type) = getimagesize($path . "/.." . $src);

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
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

                                                $newLibraryProperty = new LibraryProperty();

                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $width;
                                                $newLibraryProperty->insert();

                                                //2 height
                                                $propertyName = "height";
                                                $propertyContext = $libraryTypeName;
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();

                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $height;
                                                $newLibraryProperty->insert();

                                                //5 src
                                                $propertyName = "src";
                                                $propertyContext = "library";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();
                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $nome; //apenas o nome do arquivo
                                                $newLibraryProperty->insert();

                                                //12 extension
                                                $propertyName = "extension";
                                                $propertyContext = "library";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();
                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $ext;
                                                $newLibraryProperty->insert();

                                                //46 Alias
                                                $propertyName = "alias";
                                                $propertyContext = "library";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();
                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $oldName;
                                                $newLibraryProperty->insert();

                                                //Salva a editor_element_property
                                                //4 libraryID
                                                $propertyName = "library_id";
                                                $propertyContext = $typeName;
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newElementProperty = new EditorElementProperty();

                                                $newElementProperty->element_id = $elementID;
                                                $newElementProperty->property_id = $propertyID;
                                                $newElementProperty->value = $libraryID;
                                                $newElementProperty->insert();
                                                $json['LibraryID'] = $libraryID;
                                            } elseif ($libraryTypeName == $this->TYPE_LIBRARY_SOUND) {

                                                $src = $value['url'];
                                                $nome = $value['name'];
                                                $oldName = $value['oldName'];
                                                $ext = explode(".", $nome);
                                                $ext = $ext[1];

                                                $newLibrary = new Library();
                                                $library_typeName = $_POST['library'];
                                                $newLibrary->type_id = $this->getTypeIDByName($library_typeName);
                                                $newLibrary->insert();
                                                //Pegar o ID do ultimo adicionado.
                                                $library = Library::model()->findByAttributes(array(), array('order' => 'id desc'));
                                                $libraryID = $library->id;
                                                //Salva library_property 's
                                                //5 src
                                                $propertyName = "src";
                                                $propertyContext = "library";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();
                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $nome; //apenas o nome do arquivo
                                                $newLibraryProperty->insert();

                                                //12 extension
                                                $propertyName = "extension";
                                                $propertyContext = "library";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();
                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $ext;
                                                $newLibraryProperty->insert();

                                                //46 Alias
                                                $propertyName = "alias";
                                                $propertyContext = "library";
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newLibraryProperty = new LibraryProperty();
                                                $newLibraryProperty->library_id = $libraryID;
                                                $newLibraryProperty->property_id = $propertyID;
                                                $newLibraryProperty->value = $oldName;
                                                $newLibraryProperty->insert();


                                                //Salva a editor_element_property
                                                //4 libraryID
                                                $propertyName = "library_id";
                                                $propertyContext = $typeName;
                                                $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                                $newElementProperty = new EditorElementProperty();

                                                $newElementProperty->element_id = $elementID;
                                                $newElementProperty->property_id = $propertyID;
                                                $newElementProperty->value = $libraryID;
                                                $newElementProperty->insert();
                                                $json['LibraryID'] = $libraryID;
                                            }
                                        } elseif ($typeName == $this->TYPE_ELEMENT_TEXT) {  //text
                                            //salva editor_element_property 's
                                            //text   
                                            $propertyName = "text";
                                            $propertyContext = "phrase";
                                            $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
                                            $newElementProperty = new EditorElementProperty();
                                            $newElementProperty->element_id = $elementID;
                                            $newElementProperty->property_id = $propertyID;
                                            $newElementProperty->value = $value;
                                            $newElementProperty->insert();

                                            //language
                                            $propertyName = "language";
                                            $propertyContext = "element";
                                            $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
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
                                    }
                                } else if (isset($_POST['justFlag']) && $_POST['justFlag'] == 1) {
                                    // Somente a Flag
                                    $flag = $_POST['flag'];
                                    // Apenas Atualiza as Flags dos elementos
                                    if (isset($_POST['ID_BD'])) {
                                        //Atualiza as Flags
                                        $IDDB = $_POST['ID_BD'];
                                        $pieceID = $_POST['pieceID'];
                                        $pieceElement = EditorPieceElement::model()->findByAttributes(array(
                                            'piece_id' => $pieceID,
                                            'element_id' => $IDDB));
                                        $change_flag = EditorPieceelementProperty::model()->findByAttributes(
                                                array('piece_element_id' => $pieceElement->id,
                                                    'property_id' => CommonProperty::getPropertyIDByName('layertype', 'piecelement')));
                                        $change_flag->value = $flag == "true" ? "Acerto" : "Erro";
                                        $change_flag->save();
                                    }
                                } else {
                                    throw new Exception("ERROR: Dados da Element insuficientes: <br>");
                                }
                            } else {
                                throw new Exception("ERROR: Operação inválida.<br>");
                            }

                            break;
                        case "plc":
                            if (isset($_POST['crossWords'])) {

                                if ($_POST['op'] = 'save') {
                                    //Se for um Novo Cobject
                                    foreach ($_POST['crossWords'] as $crossWord):
                                        //Para cada Cruzamento
                                        //Piece_Element
                                        $pieceElementID_w1 = EditorPieceElement::model()->findByAttributes(array('piece_id' => $crossWord['idDbPiece']
                                                    , 'element_id' => $crossWord['idDbElementWord1']))->id;

                                        $pieceElementID_w2 = EditorPieceElement::model()->findByAttributes(array('piece_id' => $crossWord['idDbPiece']
                                                    , 'element_id' => $crossWord['idDbElementWord2']))->id;

                                        //Associar o PieceElemente();
                                        //Armazenar todos os pontos de cruzamento de cada relacionamento entre words
                                        //Somente será preciso armazenar as posições de cruzamento para a 1° pieceElementID
                                        $propertyName = "point_crossword";
                                        $propertyContext = "word";
                                        $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

                                        $newPEPropertyPOintCrossWord = new EditorPieceelementProperty();
                                        $newPEPropertyPOintCrossWord->property_id = $propertyID;
                                        $newPEPropertyPOintCrossWord->piece_element_id = $pieceElementID_w1;
                                        $newPEPropertyPOintCrossWord->value = "w2peID" . $pieceElementID_w2 . "|" . $crossWord['position1'] . "|" . $crossWord['position2'];
                                        $newPEPropertyPOintCrossWord->save();

                                    endforeach;
                                }
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
                        $json['themeID'] = $cobject->theme_id; //
                        $json['templateID'] = $cobject->template_id; //
                        $json['description'] = $cobject->description;

                        //===============Cobject-Element===============

                        $CobjectElement = CobjectElement::model()->findAllByAttributes(array('cobject_id' => $cobjectID), array('order' => '`position`'));

                        foreach ($CobjectElement as $cElem):
                            $Element = EditorElement::model()->findByAttributes(array('id' => $cElem->element_id));
                            $json['E' . $Element->id] = array();
                            $json['E' . $Element->id]['type_name'] = $Element->type->name;

                            //=============POSITION==================================
                            $json['E' . $Element->id]['position'] = $cElem->position;

                            $ElementProperty = EditorElementProperty::model()->findAllByAttributes(array('element_id' => $Element->id));
                            foreach ($ElementProperty as $ep):
                                if ($ep->property_id == CommonProperty::getPropertyIDByName('library_id', 'multimidia')) { //libraryID
                                    $Library = Library::model()->findByAttributes(array('id' => $ep->value));
                                    $json['E' . $Element->id]['L' . $Library->id] = array();
                                    $json['E' . $Element->id]['L' . $Library->id]['type_name'] = $Library->type->name; //9 image; 17 movie; 20 sound 
                                    $LibraryProperty = LibraryProperty::model()->findAllByAttributes(array('library_id' => $Library->id));
                                    foreach ($LibraryProperty as $lp):
                                        $json['E' . $Element->id]['L' . $Library->id][$lp->property->name] = $lp->value;
                                    endforeach;
                                }else {
                                    $json['E' . $Element->id][$ep->property->name] = $ep->value;
                                }
                            endforeach;
                        endforeach;

                        //==============================================

                        $Srceens = EditorScreen::model()->findAllByAttributes(array('cobject_id' => $cobjectID), array('order' => '`order`'));

                        foreach ($Srceens as $sc):
                            $json['S' . $sc->id] = array();
                            $ScreenPieceset = EditorScreenPieceset::model()->findAllByAttributes(array('screen_id' => $sc->id), array('order' => '`order`'));
                            foreach ($ScreenPieceset as $scps):
                                $PieceSet = EditorPieceset::model()->findByAttributes(array('id' => $scps->pieceset_id));
                                $json['S' . $sc->id]['PS' . $PieceSet->id] = array();
                                $json['S' . $sc->id]['PS' . $PieceSet->id]['description'] = $PieceSet->description;
                                $json['S' . $sc->id]['PS' . $PieceSet->id]['template_id'] = $PieceSet->template_id;
                                //===============PieceSet-Element===============

                                $PieceSetElement = EditorPiecesetElement::model()->findAllByAttributes(array('pieceset_id' => $scps->pieceset_id), array('order' => '`position`'));

                                foreach ($PieceSetElement as $pse):
                                    $Element = EditorElement::model()->findByAttributes(array('id' => $pse->element_id));
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id] = array();
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id]['type_name'] = $Element->type->name;

                                    //=============POSITION==================================
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id]['position'] = $pse->position;

                                    $ElementProperty = EditorElementProperty::model()->findAllByAttributes(array('element_id' => $Element->id));
                                    foreach ($ElementProperty as $ep):
                                        if ($ep->property_id == CommonProperty::getPropertyIDByName('library_id', 'multimidia')) { //libraryID
                                            $Library = Library::model()->findByAttributes(array('id' => $ep->value));
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id]['L' . $Library->id] = array();
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id]['L' . $Library->id]['type_name'] = $Library->type->name; //9 image; 17 movie; 20 sound 
                                            $LibraryProperty = LibraryProperty::model()->findAllByAttributes(array('library_id' => $Library->id));
                                            foreach ($LibraryProperty as $lp):
                                                $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id]['L' . $Library->id][$lp->property->name] = $lp->value;
                                            endforeach;
                                        }else {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['E' . $Element->id][$ep->property->name] = $ep->value;
                                        }
                                    endforeach;
                                endforeach;

                                //==============================================

                                $PieceSetPiece = EditorPiecesetPiece::model()->findAllByAttributes(array('pieceset_id' => $PieceSet->id), array('order' => '`order`'));
                                foreach ($PieceSetPiece as $psp):
                                    $Piece = EditorPiece::model()->findByAttributes(array('id' => $psp->piece_id));
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id] = array();
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['description'] = $Piece->description;
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['name'] = $Piece->name;

                                    if (isset($Piece->type_id) && $Piece->type_id == CommonType::getTypeIDbyName_Context('piece', 'shape')) {
                                        //O template é Desenho. 
                                        $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['type_name'] = $Piece->type->name;
                                        $piece_property = EditorPieceProperty::model()->findByAttributes(array('piece_id' => $Piece->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('type_shape', 'piece')));
                                        //Forma do Desenho
                                        $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['shape'] = $piece_property->value;
                                    }




                                    $PieceElement = EditorPieceElement::model()->findAllByAttributes(array('piece_id' => $psp->piece_id), array('order' => '`position`'));

                                    foreach ($PieceElement as $pe):
                                        $Element = EditorElement::model()->findByAttributes(array('id' => $pe->element_id));
                                        $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id] = array();
                                        $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['type_name'] = $Element->type->name;
                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('layertype', 'piecelement')));

                                        //=============POSITION==================================
                                        $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['position'] = $pe->position;
                                        //==============Flag=====================================
                                        if (isset($pe_property)) {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['flag'] = $pe_property->value;
                                        }
                                        //=============== grouping ===============================
                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('grouping', 'piecelement')));
                                        //var_dump($pe_property->value); exit();
                                        if (isset($pe_property)) {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['match'] = $pe_property->value;
                                        }
                                        //Se for template Palavra Cruzada
                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('showing_letters', 'word')));
                                        if (isset($pe_property)) {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['showing_letters'] = $pe_property->value;
                                        }

                                        //Se for template Caça Palavras
                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('posx', 'piecelement')));
                                        if (isset($pe_property)) {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['posx'] = $pe_property->value;
                                        }

                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('posy', 'piecelement')));
                                        if (isset($pe_property)) {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['posy'] = $pe_property->value;
                                        }
                                        //fim do template caça palavras

                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
                                            'property_id' => CommonProperty::getPropertyIDByName('direction', 'word')));
                                        if (isset($pe_property)) {
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['direction'] = $pe_property->value;
                                        }

//                                        $pe_property = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe->id,
//                                            'property_id' => CommonProperty::getPropertyIDByName('point_crossword', 'word')));
                                        $pe_propertyPointCross = Yii::app()->db->createCommand("SELECT * FROM editor_pieceelement_property "
                                                        . "WHERE piece_element_id = $pe->id AND "
                                                        . "property_id = " . CommonProperty::getPropertyIDByName('point_crossword', 'word'))->queryAll();

                                        if (count($pe_propertyPointCross) > 0) {
                                            //id do pieceElementProperty
                                            $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['crossWord'] = array();

                                            foreach ($pe_propertyPointCross as $idx => $eachThisElementCross):
                                                $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['crossWord']
                                                        [$idx]['idDBPieceElementPropertyPointCross'] = $eachThisElementCross['id'];

                                                //==========================================
                                                $pe_id_w2 = explode("|", $eachThisElementCross['value']);
                                                $pe_id_w2 = explode("w2peID", $pe_id_w2[0]);
                                                $pe_id_w2 = $pe_id_w2[1];

                                                $e_id_w2 = EditorPieceElement::model()->findByPk($pe_id_w2);

                                                $pointCross = explode("|", $eachThisElementCross['value']);

                                                $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['crossWord']
                                                        [$idx]['point_crossword'] = "w2eID" . $e_id_w2->element_id . "|" . $pointCross[1] . "|" . $pointCross[2];

                                                //============ Groupo do elemeto da Word2
                                                //Buscar o groupo desse Element do PieceElement estar
                                                $pe_propertyGroupCrossedWord2 = EditorPieceelementProperty::model()->findByAttributes(array('piece_element_id' => $pe_id_w2,
                                                    'property_id' => CommonProperty::getPropertyIDByName('grouping', 'piecelement')));

                                                if (isset($pe_propertyGroupCrossedWord2)) {
                                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['crossWord']
                                                            [$idx]['crossword_elementGroup_Word2'] = $pe_propertyGroupCrossedWord2->value;
                                                }

                                            endforeach;
                                        }


                                        $ElementProperty = EditorElementProperty::model()->findAllByAttributes(array('element_id' => $Element->id));
                                        foreach ($ElementProperty as $ep):
                                            if ($ep->property_id == CommonProperty::getPropertyIDByName('library_id', 'multimidia')) { //libraryID
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
                            case 'P': $delAll_Ok = $this->delPiece($id);
                                break;
                            case 'E':

                                $expl_element_PS = explode('PS', $id);
                                $expl_element_CO = explode('CO', $id);

                                if (count($expl_element_PS) == 2) {
                                    //Então realmente é uma PS
                                    $id_element = $expl_element_PS[0];
                                    $id_pieceSet = $expl_element_PS[1];
                                    $delAll_Ok = $this->delElement($id_element, $id_pieceSet, true, false);
                                } else if (count($expl_element_CO) == 2) {
                                    //Então é um element do Cobject
                                    $id_element = $expl_element_CO[0];
                                    $id_cobject = $expl_element_CO[1];
                                    $delAll_Ok = $this->delElement($id_element, $id_cobject, false, true);
                                } else {
                                    //É uma P -> piece
                                    $expl_element_PS = explode('P', $id);
                                    $id_element = $expl_element_PS[0];
                                    $id_piece = $expl_element_PS[1];
                                    $delAll_Ok = $this->delElement($id_element, $id_piece, false, false);
                                }
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


            //Persiste as alteraçoes no BD
            $transaction->commit();

//            var_dump($json);

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($json);
        } catch (Exception $e) {
            //Caso ocorra algum erro de sql e no php
            $transaction->rollBack();
        }
    }

    private function delScreen($id) {
        //Excluir Screen
        $delScreen = EditorScreen::model()->findByPk($id);
        $delPS = EditorScreenPieceset::model()->findAllByAttributes(
                array('screen_id' => $delScreen->id));
        //1° Deleta todas os PiecesSets relacionadas a esta Screen
        foreach ($delPS as $dps):
            $pieceset_id = $dps->pieceset_id;
            //Deletar cada PieceSet
            $this->delPieceset($pieceset_id);
        endforeach;
        //2° Deleta a Screen
        $delScreen->delete();
        //============================ 
    }

    private function delPieceset($id) {
        $delPS = EditorScreenPieceset::model()->findByAttributes(
                array('pieceset_id' => $id));
        //Deleta 1° a relação ScreenPieceset
        $delPS->delete();
        //2°̣Desvincula cada elemento da PieceSet
        $delPSE = EditorPiecesetElement::model()->findAllByAttributes(
            array('pieceset_id' => $id));
        foreach ($delPSE as $pse):
            //Desvincular cada Elemento da PieceSet
            $this->delElement($pse->element_id, $id, true, false);
        endforeach;

        $delP = EditorPiecesetPiece::model()->findAllByAttributes(
                array('pieceset_id' => $id));
        //3° deleta cada Piece
        foreach ($delP as $dp):
            $piece_id = $dp->piece_id;
            //Deletar cada Piece
            $this->delPiece($piece_id);
        endforeach;
        //4° Exclui o PieceSet
        $delete_pieceSet = EditorPieceset::model()->findByPk($id);
        $delete_pieceSet->delete();
        //=============== STOP HERE 25-05-2016 =============
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
            $delpiece = (!$this->delElement($el->element_id, $id, false, false)) ? false : $delpiece;
        endforeach;
        //Depois, Exclui a peça Se Não existir Algum piece_element <=> performance_actor
        if ($delpiece) {
            $delete_piece = EditorPiece::model()->findByPk($id);
            //Exclui todas as propriedades da Piece
            $Piece_Property = EditorPieceProperty::model()
                    ->findAll(array(
                'condition' => 'piece_id=:idPiece',
                'params' => array(':idPiece' => $delete_piece->id)
            ));
            $ls = null;
            foreach ($Piece_Property as $ls):
                // Excluir cada propriedade da Piece
                $ls->delete();
            endforeach;
            // Por fim deleta a piece
            $delete_piece->delete();
        }

        return $delpiece;
    }

    // Dois argumentos, pois, um elemento pode estar em várias pieces
    private function delElement($id, $id_Pai, $isElementPieceSet, $isElementCobject) {
        //Verificar se o template é PLC
        $isTemplatePlc = isset($_POST['isTemplatePlc']) ? $_POST['isTemplatePlc'] : false;

        $isElementPieceSet = isset($isElementPieceSet) && $isElementPieceSet;
        $isElementCobject = isset($isElementCobject) && $isElementCobject;

        $newElement = EditorElement::model()->findByPk($id);
        if (!$isElementPieceSet && !$isElementCobject) {
            $Element_Piece = EditorPieceElement::model()->findByAttributes(
                    array('piece_id' => $id_Pai, 'element_id' => $newElement->id));
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
                //Se for realizado a deleção de elemento do template Caça-Palavra
                if ($isTemplatePlc) {
                    //Busca todos os piece_elements para a piece corrente
                    $AllElement_Piece = Yii::app()->db->CreateCommand(""
                                    . "SELECT * FROM editor_piece_element WHERE piece_id = $id_Pai")->queryAll();

                    $propertyName = "point_crossword";
                    $propertyContext = "word";
                    $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

                    foreach ($AllElement_Piece as $pe):
                        //para cada piece_element com property: point_crossword
                        $pePropertyPointCross = EditorPieceelementProperty::model()->findByAttributes(
                                array('piece_element_id' => $pe['id'], 'property_id' => $propertyID));
                        if (isset($pePropertyPointCross)) {
                            //Verifica o valor 
                            $pieceElementIDCross = explode('w2peID', $pePropertyPointCross->value);
                            $pieceElementIDCross = explode('|', $pieceElementIDCross[1]);
                            $pieceElementIDCross = $pieceElementIDCross[0];
                            if ($pieceElementIDCross == $Element_Piece->id) {
                                //Então deleta esta propriedade
                                $pePropertyPointCross->delete();
                                break;
                            }
                        }
                    endforeach;
                }

                //Depois, Desvincula o elemento da peça.                                  
                $Element_Piece->delete();
                return true;
                //==========================
            }
        } else if ($isElementCobject) {
            //É um elemento do Cobject
            $Element_Cobject = CobjectElement::model()->findByAttributes(
                    array('cobject_id' => $id_Pai, 'element_id' => $newElement->id));
            //Desvincula o elemento do Cobject. 
            $Element_Cobject->delete();
            return true;
        } else {
            //É um elemento da PieceSet
            $Element_PieceSet = EditorPiecesetElement::model()->findByAttributes(
                    array('pieceset_id' => $id_Pai, 'element_id' => $newElement->id));
            //Desvincula o elemento da PieceSet. 
            $Element_PieceSet->delete();
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
                //se operação for imagem
                if ($_POST['op'] == 'image') {
                    //define as extensões aceitas
                    $extencions = array(".png", ".gif", ".bmp", ".jpeg", ".jpg", ".ico");
                    //define tamanho máximo
                    $max_size = 1024 * 5; //5MB
                    //se operação for audio
                } elseif ($_POST['op'] == 'sound') {
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
                $type_multimidia = $_POST['op'];
                $path = Yii::app()->basePath . '/../library/' . $type_multimidia . '/';
                //define qual a url para visualização do arquivo
                $url = "/library/" . $type_multimidia . "/";

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
                        //pega o nome temporário do arquivo, para poder move-lo
                        $tmp = $_FILES['file']['tmp_name'];

                        //gera um código md5 concatenado com a extensão para ser o nome do arquivo
                        //e evitar duplicatas
                        //=============================
                        // $name = md5(uniqid(time())) . $ext;
                        //Identifica cada imagem a partir de seu nome + size, 
                        //E impedi que seja feito outro upload
                        $name = md5($file_name . $file_size) . $ext;
                        $fileExists = file_exists($path . $name);
                        $fileExists = isset($fileExists) && $fileExists;
                        ///=============================
                        //adiciona ao retorno do json a URL e o nome do arquivo
                        $json['url'] = $url . $name;
                        $json['name'] = $name;
                        $json['oldName'] = explode(".", $file_name);
                        $json['oldName'] = $json['oldName'][0];

                        if (!$fileExists) {
                            //Somente faz o upload se o mesmo arquivo Não existe no servidor 
                            try {
                                //move o arquivo temporário para o novo local
                                $varMUF = move_uploaded_file($tmp, $path . $name);
                                $json['varMUF'] = $varMUF;
                                //se não funcionar
                            } catch (Exception $e) {
                                throw new Exception("ERROR: Falha ao enviar.<br>");
                            }
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

    public function actionAddAlias() {
        $this->render('addAlias');
    }

    public function actionGetMultimidias() {
        $filterAlias = $_POST['filter'];
        //46 Alias
        $propertyName = "alias";
        $propertyContext = "library";
        $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);
        $where = "";
        if (isset($filterAlias) && !empty($filterAlias)) {
            $where = " WHERE property_id=$propertyID";
            $where .= " AND value LIKE '%" . $filterAlias . "%' ";
        }
        $limit = " LIMIT 0,10";
        //cada registro com library_id e o Alias correspondente
        //STOP HERE, VERIFICAR CONDIÇAO DE DISTINCT OU NAO
        $librarysIdAlias = Yii::app()->db->createCommand('SELECT library_id, value FROM library_property' . $where . $limit)->queryAll();
        //Busca agora o src de cada library encontrada
        //4 src
        $propertyName = "src";
        $propertyContext = "library";
        $propertyID = CommonProperty::getPropertyIDByName($propertyName, $propertyContext);

        $librarys = array();
        foreach ($librarysIdAlias AS $libId_Alias):

            $srcFromLibrary_id = Yii::app()->db->createCommand('SELECT value FROM library_property '
                            . ' WHERE property_id =' . $propertyID . ' AND library_id =' . $libId_Alias['library_id'])->queryAll();

            if (isset($filterAlias) && !empty($filterAlias)) {
                //Encontrou librarys usando o filtro
                if (!isset($librarys[$libId_Alias['library_id']]['alias'])) {
                    //Se for o 1° Alias para esta library
                    $librarys[$libId_Alias['library_id']]['alias'] = array();
                    $librarys[$libId_Alias['library_id']]['src'] = $srcFromLibrary_id[0]['value'];
                }
                //Array Alias que possuira todos os Alias de determinada library   
                array_push($librarys[$libId_Alias['library_id']]['alias'], $libId_Alias['value']);
            } else {
                //Encontrou sem filtro
                $librarys[$libId_Alias['library_id']]['src'] = $srcFromLibrary_id[0]['value'];
            }
            echo $libId_Alias['library_id'];
        endforeach;

        if (count($librarysIdAlias) == 0) {
            //NAO encontrou algum Alias
            echo "";
        }

        echo json_encode($librarys);
    }

    private function getTypeIDByName($str) {
        $typeName = $str;
        $type = CommonType::model()->findByAttributes(array('name' => strtolower($typeName)));
        $typeID = $type->id;

        return $typeID;
    }


    public function actionGetLastCobjectID() {
        $lastID = Yii::app()->db->createCommand('SELECT Max(id) AS lastID FROM cobject;')->queryAll();
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($lastID);
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
