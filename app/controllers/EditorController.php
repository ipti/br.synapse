<?php

class EditorController extends Controller {

    public $layout = 'editor';
    public $TYPE_ELEMENT_TEXT = "TEXT";
    public $TYPE_ELEMENT_MULTIMIDIA = "MULTIMIDIA";
    public $TYPE_LIBRARY_IMAGE = "IMAGE";
    public $TYPE_LIBRARY_SOUND = "SOUND";
    public $TYPE_LIBRARY_MOVIE = "MOVIE";

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
            foreach ($uploadedLibraryIDs as $upLibId):
                $libsProperty[$i] = LibraryProperty::model()->findByAttributes(array('library_id' => $upLibId,
                    'property_id' => 5));
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
                    $newDir[$i] = Yii::app()->basePath . "/../rsc/upload/image/" . $name_img[$i];
                    $newDir[$i] = str_replace('\\', "/", $newDir[$i]);
                    $newUrl[$i] = "/rsc/upload/image/" . $name_img[$i];
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
                      <br> Nível&nbsp;:&nbsp;
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
                    window.alert('Change Act_Goal');
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
                $str = "<br> Nível&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
                for ($i = 0; $i < $count_Agoal_d; $i++) {
                    $str.= "<option value=" . $actGoal_d[$i]['id'] . ">" . $actGoal_d[$i]['name'] . "</option>";
                }
                $str.= "</select>";
                $str.= $this->searchCobjectofGoal($actGoal_d[0]['id']);
                $str.="
                <script language='javascript' type='text/javascript'>  
                $('#actGoal').change(function(){
                    window.alert('Change Act_Goal - 2');
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
        $cobject_metadata = Yii::app()->db->createCommand('SELECT cobject_id FROM cobject_metadata
            WHERE value = ' . $IDActGoal)->queryAll();
        $count_CobjMdata = count($cobject_metadata);
        if ($count_CobjMdata > 0) {
            $str2 = "<div id='showCobjectIDs' align='left'>
              <br><span id='txtIDsCobject'> Lista de Cobjects para Goal Corrente  </span>
                <form id='cobjectIDS' name='cobjectIDS' method='POST' action='/editor/index/'>
                <select id='cobjectID' name='cobjectID' style='width:430px'>";
            for ($i = 0; $i < $count_CobjMdata; $i++) {
                $str2.= "<option value=" . $cobject_metadata[$i]['cobject_id'] . ">"
                        . $cobject_metadata[$i]['cobject_id'] . "</option>";
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
            if ($_POST['op'] == 'save' || $_POST['op'] == 'update' && isset($_POST['step'])) {
                switch ($_POST['step']) {
                    case "CObject":
                        if (isset($_POST['COtypeID']) && isset($_POST['COthemeID'])
                                && isset($_POST['COtemplateType']) && isset($_POST['COgoalID'])) {
                            $typeID = $_POST['COtypeID'];
                            $templateID = $_POST['COtemplateType'];
                            $themeID = $_POST['COthemeID'];
                            $goalID = $_POST['COgoalID'];

                            $newCobject = new Cobject();
                            $newCobject->type_id = $typeID;
                            $newCobject->template_id = $templateID;
                            $newCobject->theme_id = $themeID;
                            $newCobject->insert();

                            $cobject = Cobject::model()->findByAttributes(array(), array('order' => 'id desc'));
                            $cobjectID = $cobject->id;

                            $newCobjectMetadata = new CobjectMetadata();
                            $newCobjectMetadata->cobject_id = $cobjectID;
                            $newCobjectMetadata->type_id = 6;
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
                            } else {
                                $newScreen = new EditorScreen();
                            }



                            $newScreen->cobject_id = $cobjectID;
                            $newScreen->order = $ordem;
                            if ($_POST['op'] == 'update') {
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

                            if ($_POST['op'] == 'update') {
                                $IDDB = $_POST['ID_BD'];
                                $newPieceSet = EditorPieceset::model()->findByPk($IDDB);
                            } else {
                                $newPieceSet = new EditorPieceset();
                            }
                            $newPieceSet->template_id = $templateID;
                            $newPieceSet->description = $description;
                            if ($_POST['op'] == 'update') {
                                $newPieceSet->save();
                                $pieceSet = $newPieceSet;
                            } else {
                                $newPieceSet->insert();
                                $pieceSet = EditorPieceset::model()->findByAttributes(array(), array('order' => 'id desc'));
                            }

                            $pieceSetID = $pieceSet->id;

                            if ($_POST['op'] == 'update') {
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
                            if ($_POST['op'] == 'update') {
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
                            if ($_POST['op'] == 'update') {
                                $IDDB = $_POST['ID_BD'];
                                $newPiece = EditorPiece::model()->findByPk($IDDB);
                            } else {
                                $newPiece = new EditorPiece();
                            }


                            if ($_POST['op'] == 'update') {
                                $newPiece->save();
                                $piece = $newPiece;
                            } else {
                                $newPiece->insert();
                                $piece = EditorPiece::model()->findByAttributes(array(), array('order' => 'id desc'));
                            }

                            $pieceID = $piece->id;

                            if ($_POST['op'] == 'update') {
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
                            if ($_POST['op'] == 'update') {
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
                        if (isset($_POST['typeID'])) {
                            $typeName = $_POST['typeID'];
                            $typeID = $this->getTypeIDByName($typeName);

                            if (isset($_POST['pieceID']) && isset($_POST['flag']) && isset($_POST['ordem'])
                                    && isset($_POST['value']) && isset($_POST['DomID'])) {
                                $DomID = $_POST['DomID'];
                                $pieceID = $_POST['pieceID'];
                                $flag = $_POST['flag'];
                                $value = $_POST['value'];
                                $order = $_POST['ordem'];
                                if ($_POST['op'] == 'update') {
                                    $IDDB = $_POST['ID_BD'];
                                    $newElement = EditorElement::model()->findByPk($IDDB);
                                } else {
                                    $newElement = new EditorElement();
                                }
                                $newElement->type_id = $typeID;
                                if ($_POST['op'] == 'update') {
                                    $newElement->save();
                                    $element = $newElement;
                                } else {
                                    $newElement->insert();
                                    $element = EditorElement::model()->findByAttributes(array(), array('order' => 'id desc'));
                                }

                                $elementID = $element->id;

                                if ($_POST['op'] == 'update') {
                                    $newPieceElement = EditorPieceElement::model()->find(array(
                                        'condition' => 'element_id =:elementID AND piece_id=:pieceID',
                                        'params' => array(':elementID' => $elementID, ':pieceID' => $pieceID)
                                            ));
                                } else {
                                    $newPieceElement = new EditorPieceElement();
                                }

                                $newPieceElement->piece_id = $pieceID;
                                $newPieceElement->element_id = $elementID;
                                $newPieceElement->order = $order;
                                if ($_POST['op'] == 'update') {
                                    $newPieceElement->save();
                                } else {
                                    $newPieceElement->insert();
                                }

                                $json['ElementID'] = $elementID;

                                $pieceElement = EditorPieceElement::model()->findByAttributes(array('piece_id' => $pieceID, 'element_id' => $elementID), array('order' => 'id desc'));
                                $pieceElementID = $pieceElement->id;


                                //layertype
                                $propertyName = "layertype";
                                $propertyContext = "piecelement";
                                $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                $newPieceElementProperty = new EditorPieceelementProperty();
                                $newPieceElementProperty->piece_element_id = $pieceElementID;
                                $newPieceElementProperty->property_id = $propertyID;
                                $newPieceElementProperty->value = $flag == 1 ? 'Correto' : 'Errado';
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
                                        $url = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
                                        list($width, $height, $type) = getimagesize("$url$src");
                                        //Salva library
                                        //type 9 
                                        if ($_POST['op'] == 'update') {
                                            $propName = "library_id";
                                            $propContext = "multimidia";
                                            $propID = $this->getPropertyIDByName($propName, $propContext);
                                            //Id da Library-Img
                                            $ElementProperty_IDlib = EditorElementProperty::model()->find(array(
                                                'condition' => 'element_id =:elementID AND property_id=:propID',
                                                'params' => array(':elementID' => $elementID,
                                                    ':propID' => $propID)));
                                            // HERE, SEM RETORNO !!!!
                                            // 
                                            $theIDLibrary = $ElementProperty_IDlib->value;
                                            //====================
                                            $newLibrary = Library::model()->findByPk($theIDLibrary);
                                        } else {
                                            $newLibrary = new Library();
                                        }
                                        $library_typeName = $_POST['library'];
                                        $newLibrary->type_id = $this->getTypeIDByName($library_typeName);
                                        if ($_POST['op'] == 'update') {
                                            $newLibrary->save();
                                            $library = $newLibrary;
                                        } else {
                                            $newLibrary->insert();
                                            //Pegar o ID do ultimo adicionado.
                                            $library = Library::model()->findByAttributes(array(), array('order' => 'id desc'));
                                        }
                                        $libraryID = $library->id;
                                        //Salva library_property 's
                                        //1 width
                                        $propertyName = "width";
                                        $propertyContext = $libraryTypeName;
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty = LibraryProperty::model()->find(array(
                                                'condition' => 'library_id =:libraryID AND property_id=:propertyID',
                                                'params' => array(':libraryID' => $libraryID,
                                                    ':propertyID' => $propertyID)
                                                    ));
                                        } else {
                                            $newLibraryProperty = new LibraryProperty();
                                        }

                                        $newLibraryProperty->library_id = $libraryID;
                                        $newLibraryProperty->property_id = $propertyID;
                                        $newLibraryProperty->value = $width;
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty->save();
                                        } else {
                                            $newLibraryProperty->insert();
                                        }


                                        //2 height
                                        $propertyName = "height";
                                        $propertyContext = $libraryTypeName;
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty = LibraryProperty::model()->find(array(
                                                'condition' => 'library_id =:libraryID AND property_id=:propertyID',
                                                'params' => array(':libraryID' => $libraryID,
                                                    ':propertyID' => $propertyID)
                                                    ));
                                        } else {
                                            $newLibraryProperty = new LibraryProperty();
                                        }

                                        $newLibraryProperty->library_id = $libraryID;
                                        $newLibraryProperty->property_id = $propertyID;
                                        $newLibraryProperty->value = $height;
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty->save();
                                        } else {
                                            $newLibraryProperty->insert();
                                        }


                                        //5 src
                                        $propertyName = "src";
                                        $propertyContext = "library";
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty = LibraryProperty::model()->find(array(
                                                'condition' => 'library_id =:libraryID AND property_id=:propertyID',
                                                'params' => array(':libraryID' => $libraryID,
                                                    ':propertyID' => $propertyID)
                                                    ));
                                        } else {
                                            $newLibraryProperty = new LibraryProperty();
                                        }
                                        $newLibraryProperty->library_id = $libraryID;
                                        $newLibraryProperty->property_id = $propertyID;
                                        $newLibraryProperty->value = $nome; //apenas o nome do arquivo
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty->save();
                                        } else {
                                            $newLibraryProperty->insert();
                                        }


                                        //12 extension
                                        $propertyName = "extension";
                                        $propertyContext = "library";
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty = LibraryProperty::model()->find(array(
                                                'condition' => 'library_id =:libraryID AND property_id=:propertyID',
                                                'params' => array(':libraryID' => $libraryID,
                                                    ':propertyID' => $propertyID)
                                                    ));
                                        } else {
                                            $newLibraryProperty = new LibraryProperty();
                                        }
                                        $newLibraryProperty->library_id = $libraryID;
                                        $newLibraryProperty->property_id = $propertyID;
                                        $newLibraryProperty->value = $ext;
                                        if ($_POST['op'] == 'update') {
                                            $newLibraryProperty->save();
                                        } else {
                                            $newLibraryProperty->insert();
                                        }

                                        //Salva a editor_element_property
                                        //4 libraryID
                                        $propertyName = "library_id";
                                        $propertyContext = $typeName;
                                        $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                        if ($_POST['op'] == 'update') {
                                            $newElementProperty = EditorElementProperty::model()->find(array(
                                                'condition' => 'element_id =:elementID AND property_id=:propertyID',
                                                'params' => array(':elementID' => $elementID,
                                                    ':propertyID' => $propertyID)
                                                    ));
                                        } else {
                                            $newElementProperty = new EditorElementProperty();
                                        }

                                        $newElementProperty->element_id = $elementID;
                                        $newElementProperty->property_id = $propertyID;
                                        $newElementProperty->value = $libraryID;
                                        if ($_POST['op'] == 'update') {
                                            $newElementProperty->save();
                                        } else {
                                            $newElementProperty->insert();
                                        }

                                        $json['LibraryID'] = $libraryID;
                                    }
                                } elseif ($typeName == $this->TYPE_ELEMENT_TEXT) {  //text
                                    //salva editor_element_property 's
                                    //text                                        
                                    $propertyName = "text";
                                    $propertyContext = "phrase";
                                    $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                    if ($_POST['op'] == 'update') {
                                        $newElementProperty = EditorElementProperty::model()->find(array(
                                            'condition' => 'element_id =:elementID AND property_id=:propertyID',
                                            'params' => array(':elementID' => $elementID,
                                                ':propertyID' => $propertyID)
                                                ));
                                    } else {
                                        $newElementProperty = new EditorElementProperty();
                                    }
                                    $newElementProperty->element_id = $elementID;
                                    $newElementProperty->property_id = $propertyID;
                                    $newElementProperty->value = $value;
                                    if ($_POST['op'] == 'update') {
                                        $newElementProperty->save();
                                    } else {
                                        $newElementProperty->insert();
                                    }

                                    //language
                                    $propertyName = "language";
                                    $propertyContext = "element";
                                    $propertyID = $this->getPropertyIDByName($propertyName, $propertyContext);
                                    if ($_POST['op'] == 'update') {
                                        $newElementProperty = EditorElementProperty::model()->find(array(
                                            'condition' => 'element_id =:elementID AND property_id=:propertyID',
                                            'params' => array(':elementID' => $elementID,
                                                ':propertyID' => $propertyID)
                                                ));
                                    } else {
                                        $newElementProperty = new EditorElementProperty();
                                    }
                                    $newElementProperty->element_id = $elementID;
                                    $newElementProperty->property_id = $propertyID;
                                    $newElementProperty->value = "português";
                                    if ($_POST['op'] == 'update') {
                                        $newElementProperty->save();
                                    } else {
                                        $newElementProperty->insert();
                                    }
                                } else {
                                    throw new Exception("ERROR: Tipo inválido.<br>");
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
                                    $json['S' . $sc->id]['PS' . $PieceSet->id]['P' . $Piece->id]['E' . $Element->id]['type_name'] = $Element->type->name;// $this->getTypeNameByID($Element->type_id);

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
            } elseif ($_POST['op'] == 'update') {
                
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
                $path = Yii::app()->basePath . '\..\rsc\upload\\' . $_POST['op'] . '\\';
                //define qual a url para visualização do arquivo
                $url = "/rsc/upload/" . $_POST['op'] . "/";

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
                        if ($_POST['isload'] && isset($_POST['name_DB'])) {
                            $delImg_name = $path . $_POST['name_DB'];
                            if (file_exists($delImg_name)) {
                                unlink($delImg_name);
                            }
                        }
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
