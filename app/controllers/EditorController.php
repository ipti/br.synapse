<?php

class EditorController extends Controller {

    public $layout = 'editor';

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
        if(isset($_GET['cID'])){
            $this->render('index');
        }
        elseif (!isset($_POST['commonType']) && !isset($_POST['cobjectTemplate']) && !isset($_POST['cobjectTheme'])) {
            $this->redirect('/editor/preeditor');
        }
        else {
            if (isset($_POST['actGoal'])) {
                $this->render('index');
            }else {
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
            } else {
                $this->redirect('poseditor?error=' . $oImg->valida());
            }
        } else {
            //Solicitação Não AJAX
            // memory limit (nem todo server aceita)
            ini_set("memory_limit", "50M");
            set_time_limit(0);
            $img_sent = array("Chrysanthemum.jpg", "Hydrangeas.jpg",
                "Jellyfish.jpg", "Koala.jpg", "Lighthouse.jpg"); // O array de imagens que foram enviadas
            $num_img = count($img_sent);


            // $num_img = 4;
            for ($i = 0; $i < $num_img; $i++) {
                $name_img[$i] = $img_sent[$i];
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
                            $oImg->redimensiona('400', '', '');
                            $oImg->grava($newDir[$i]);

                            $imagesize[$i] = getimagesize($newDir[$i]);
                            $img[$i] = '<img src="' . $newUrl[$i] . '" id="jcrop' . $i . '" ' . $imagesize[$i][3] . ' />';
                            $preview[$i] = '<img src="' . $newUrl[$i] . '" id="preview' . $i . '" ' . $imagesize[$i][3] . ' />';
                            $tem_crop = true;
                        }
                    }
                }
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
            }
            $this->render('poseditor', array('property_img' => $property_img));
        }
    }

    public function actionFiltergoal() {
      if(!isset($_POST['goalID']) ) {  
            $idDiscipline = $_POST['idDiscipline'];
            $idDegree = $_POST['idDegree'];
        if ($idDegree == "undefined") {
            $actGoal_disc = Yii::app()->db->createCommand('SELECT degreeID FROM act_goal 
            WHERE disciplineID =' . $idDiscipline . ' GROUP BY degreeID')->queryAll();
            $count_Agoal_disc = count($actGoal_disc);
            if ($count_Agoal_disc > 0) {
                for ($i = 0; $i < $count_Agoal_disc; $i++) {
                    // Array dos Degrees - A cada repetição irá guarda 1 único registro 
                    $actDegree[$i] = Yii::app()->db->createCommand('SELECT ID, name FROM act_degree
                WHERE ID = ' . $actGoal_disc[$i]['degreeID'] . ' AND grade > 0')->queryAll();
                }
                $count_Adeg = count($actDegree);
                if ($count_Adeg > 0) {
                    $str = "<div id='propertyAdeg' align='left'> 
                 Act Degree&nbsp;:&nbsp;
                 <select id='actDegree' name='actDegree'>  ";
                    for ($i = 0; $i < $count_Adeg; $i++) {
                        $str.= "<option value=" . $actDegree[$i][0]['ID'] . ">" . $actDegree[$i][0]['name'] . "</option>";
                    }
                    $str.= "</select> 
              </div> ";

                    //Por padrão, como não foi selecionado algum Degree, mostrará o GOAL do 1° [0]
                    $actGoal_d = Yii::app()->db->createCommand('SELECT ID, name FROM act_goal 
                     WHERE disciplineID =' . $idDiscipline . ' AND degreeID =' . $actDegree[0][0]['ID'])->queryAll();
                    $count_Agoal_d = count($actGoal_d);
                    // No mínimo possui 1 registro
                    $str.= "<div id='propertyAgoal' class='propertyAgoal' align='center'>
                      <br> Act Goal&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
                    for ($i = 0; $i < $count_Agoal_d; $i++) {
                        $str.= "<option value=" . $actGoal_d[$i]['ID'] . ">" . $actGoal_d[$i]['name'] . "</option>";
                    }
                      
                    $str.= "</select>";
                    $str.=  $this->searchCobjectofGoal($actGoal_d[0]['ID']) .
                           "</div>
                            <br>                      

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
            $actGoal_d = Yii::app()->db->createCommand('SELECT ID, name FROM act_goal 
                     WHERE disciplineID =' . $idDiscipline . ' AND degreeID =' . $idDegree)->queryAll();
            $count_Agoal_d = count($actGoal_d);
            // No mínimo possui 1 registro
            $str = "<br> Act Goal&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
            for ($i = 0; $i < $count_Agoal_d; $i++) {
                $str.= "<option value=" . $actGoal_d[$i]['ID'] . ">" . $actGoal_d[$i]['name'] . "</option>";
            }
            $str.= "</select>";
            $str.=  $this->searchCobjectofGoal($actGoal_d[0]['ID']);
            echo $str;
        }
      }else{
          //Somente Pesquisar Pelo GoalID
          $goalID = $_POST['goalID'];
          echo  $this->searchCobjectofGoal($goalID);
      }  
   }
    
    private function searchCobjectofGoal($actGoal_id) {
        //Se foi definida, então existe pelo menos a posição 0
        $IDActGoal = (isset($actGoal_id) ? $actGoal_id : -1) ; 
        //Selecionando ou não algum Degree
        //==========Editar os Cobjects Existentes - As atividades========//
        $cobject_metadata = Yii::app()->db->createCommand('SELECT cobjectID FROM cobject_metadata
            WHERE value = ' . $IDActGoal)->queryAll();
        $count_CobjMdata = count($cobject_metadata); 
        if($count_CobjMdata > 0 ) {
            $str2 = "<br><br><div id='showCobjectIDs' align='left'>
                <span id='txtIDsCobject'> Lista de Cobjects para Goal Corrente  </span>
                <form id='cobjectIDS' name='cobjectIDS' method='POST' action='/editor/json/'>
                <select id='cobjectID' name='cobjectID' style='width:430px'>";
            for($i = 0; $i < $count_CobjMdata; $i++){
                $str2.= "<option value=" . $cobject_metadata[$i]['cobjectID'] . ">"
                      . $cobject_metadata[$i]['cobjectID'] . "</option>";
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
            if ($_POST['op'] == 'save' && isset($_POST['step'])) {
                switch ($_POST['step']) {
                    case "CObject":
                        if (isset($_POST['COtypeID']) && isset($_POST['COthemeID'])
                                && isset($_POST['COtemplateType']) && isset($_POST['COgoalID'])) {
                            $typeID = $_POST['COtypeID'];
                            $templateID = $_POST['COtemplateType'];
                            $themeID = $_POST['COthemeID'];
                            $goalID = $_POST['COgoalID'];

                            $newCobject = new Cobject();
                            $newCobject->typeID = $typeID;
                            $newCobject->templateID = $templateID;
                            $newCobject->themeID = $themeID;
                            $newCobject->insert();

                            $cobject = Cobject::model()->findByAttributes(array(), array('order' => 'ID desc'));
                            $cobjectID = $cobject->ID;

                            $newCobjectMetadata = new CobjectMetadata();
                            $newCobjectMetadata->cobjectID = $cobjectID;
                            $newCobjectMetadata->typeID = 6;
                            $newCobjectMetadata->value = $goalID;
                            $newCobjectMetadata->insert();

                            $json['CObjectID'] = $cobjectID;
                        } else {
                            throw new Exception("ERROR: Dados do CObject insuficientes.<br>");
                        }
                        break;
                    case "Screen":
                        if (isset($_POST['CObjectID']) && isset($_POST['Number']) && isset($_POST['Ordem'])
                                && isset($_POST['Width']) && isset($_POST['Height']) && isset($_POST['DomID'])) {

                            $DomID = $_POST['DomID'];
                            $cobjectID = $_POST['CObjectID'];
                            $number = $_POST['Number'];
                            $ordem = $_POST['Ordem'];
                            $width = $_POST['Width'];
                            $height = $_POST['Height'];

                            $newScreen = new EditorScreen();
                            $newScreen->cobjectID = $cobjectID;
                            $newScreen->number = $number;
                            $newScreen->order = $ordem;
                            $newScreen->width = $width;
                            $newScreen->height = $height;
                            $newScreen->insert();

                            $screen = EditorScreen::model()->findByAttributes(array(), array('order' => 'ID desc'));
                            $screenID = $screen->ID;

                            $json['DomID'] = $DomID;
                            $json['screenID'] = $screenID;
                        } else {
                            throw new Exception("ERROR: Dados da Screen insuficientes.<br>");
                        }
                        break;
                    case "PieceSet":
                        if (isset($_POST['typeID']) && isset($_POST['desc']) && isset($_POST['screenID'])
                                && isset($_POST['position']) && isset($_POST['templateID']) && isset($_POST['DomID'])) {

                            $DomID = $_POST['DomID'];
                            $typeID = $_POST['typeID'];
                            $desc = $_POST['desc'];

                            $screenID = $_POST['screenID'];
                            $position = $_POST['position'];
                            $templateID = $_POST['templateID'];

                            $newPieceSet = new EditorPieceset();
                            $newPieceSet->typeID = $typeID;
                            $newPieceSet->desc = $desc;
                            $newPieceSet->insert();

                            $pieceSet = EditorPieceset::model()->findByAttributes(array(), array('order' => 'ID desc'));
                            $pieceSetID = $pieceSet->ID;

                            $newScreenPieceSet = new EditorScreenPieceset();
                            $newScreenPieceSet->screenID = $screenID;
                            $newScreenPieceSet->piecesetID = $pieceSetID;
                            $newScreenPieceSet->position = $position;
                            $newScreenPieceSet->templateID = $templateID;
                            $newScreenPieceSet->insert();

                            $json['DomID'] = $DomID;
                            $json['PieceSetID'] = $pieceSetID;
                        } else {
                            throw new Exception("ERROR: Dados da PieceSet insuficientes.<br>");
                        }
                        break;
                    case "Piece":
                        if (isset($_POST['pieceSetID']) && isset($_POST['ordem'])
                                && isset($_POST['typeID']) && isset($_POST['DomID'])) {

                            $DomID = $_POST['DomID'];
                            $pieceSetID = $_POST['pieceSetID'];
                            $ordem = $_POST['ordem'];
                            $typeID = $_POST['typeID'];

                            $newPiece = new EditorPiece();
                            $newPiece->typeID = $typeID;
                            $newPiece->insert();

                            $piece = EditorPiece::model()->findByAttributes(array(), array('order' => 'ID desc'));
                            $pieceID = $piece->ID;

                            $newPieceSetPiece = new EditorPiecesetPiece();
                            $newPieceSetPiece->pieceID = $pieceID;
                            $newPieceSetPiece->piecesetID = $pieceSetID;
                            $newPieceSetPiece->order = $ordem;
                            $newPieceSetPiece->insert();

                            $json['DomID'] = $DomID;
                            $json['PieceID'] = $pieceID;
                        } else {
                            throw new Exception("ERROR: Dados da Piece insuficientes.<br>");
                        }
                        break;
                    case "Element":
                        if (isset($_POST['typeID'])) {
                            $typeID = $_POST['typeID'];

                            if (isset($_POST['pieceID']) && isset($_POST['flag']) && isset($_POST['ordem'])
                                    && isset($_POST['value']) && isset($_POST['DomID'])) {

                                $DomID = $_POST['DomID'];
                                $pieceID = $_POST['pieceID'];
                                $flag = $_POST['flag'];
                                $value = $_POST['value'];
                                $position = $_POST['ordem'];

                                $newElement = new EditorElement();
                                $newElement->typeID = $typeID;
                                $newElement->insert();

                                $element = EditorElement::model()->findByAttributes(array(), array('order' => 'ID desc'));
                                $elementID = $element->ID;

                                $newPieceElement = new EditorPieceElement();
                                $newPieceElement->pieceID = $pieceID;
                                $newPieceElement->elementID = $elementID;
                                $newPieceElement->position = $position;
                                $newPieceElement->insert();

                                $json['ElementID'] = $elementID;

                                switch ($typeID) {
                                    case 11: //text
                                        //salva editor_element_property 's
                                        //6 text
                                        $newElementProperty = new EditorElementProperty();
                                        $newElementProperty->elementID = $elementID;
                                        $newElementProperty->propertyID = 6;
                                        $newElementProperty->value = $value;
                                        $newElementProperty->insert();
                                        //10 language
                                        $newElementProperty = new EditorElementProperty();
                                        $newElementProperty->elementID = $elementID;
                                        $newElementProperty->propertyID = 10;
                                        $newElementProperty->value = "português";
                                        $newElementProperty->insert();
                                        break;
                                    case 16: //image
                                        $src = $value['url'];
                                        $nome = $value['name'];
                                        $ext = explode(".", $nome);
                                        $ext = $nome[1];
                                        //Pegar informações da imagem

                                        $url = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
                                        list($width, $height, $type) = getimagesize("$url$src");

                                        //Salva library
                                        //type 9 
                                        $newLibrary = new Library();
                                        $newLibrary->typeID = 9;
                                        $newLibrary->insert();

                                        //Pegar o ID do ultimo adicionado.
                                        $library = Library::model()->findByAttributes(array(), array('order' => 'ID desc'));
                                        $libraryID = $library->ID;

                                        //Salva library_property 's
                                        //1 width
                                        $newLibraryProperty = new LibraryProperty();
                                        $newLibraryProperty->libraryID = $libraryID;
                                        $newLibraryProperty->propertyID = 1;
                                        $newLibraryProperty->value = $width;
                                        $newLibraryProperty->insert();

                                        //2 height
                                        $newLibraryProperty = new LibraryProperty();
                                        $newLibraryProperty->libraryID = $libraryID;
                                        $newLibraryProperty->propertyID = 2;
                                        $newLibraryProperty->value = $height;
                                        $newLibraryProperty->insert();

                                        //5 src
                                        $newLibraryProperty = new LibraryProperty();
                                        $newLibraryProperty->libraryID = $libraryID;
                                        $newLibraryProperty->propertyID = 5;
                                        $newLibraryProperty->value = $nome;//apenas o nome do arquivo
                                        $newLibraryProperty->insert();

                                        //12 extension
                                        $newLibraryProperty = new LibraryProperty();
                                        $newLibraryProperty->libraryID = $libraryID;
                                        $newLibraryProperty->propertyID = 12;
                                        $newLibraryProperty->value = $ext;     
                                        $newLibraryProperty->insert();

                                        //Salva na editor_element_property
                                        //4 libraryID
                                        $newElementProperty = new EditorElementProperty();
                                        $newElementProperty->elementID = $elementID;
                                        $newElementProperty->propertyID = 4;
                                        $newElementProperty->value = $libraryID;
                                        $newElementProperty->insert();

                                        $json['LibraryID'] = $libraryID;

                                        break;
                                    default:
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
                if(isset($_POST['cobjectID'])){
                    $cobjectID = $_POST['cobjectID'];
                    $cobject = Cobject::model()->findByAttributes(array('ID'=>$cobjectID));
                    $json['cobjectID'] = $cobjectID;
                    $json['typeID'] = $cobject->typeID;
                    $json['themeID'] = $cobject->themeID;
                    $json['templateID'] = $cobject->templateID;
                    
                    $Srceens = EditorScreen::model()->findAllByAttributes(array('cobjectID'=>$cobjectID),array('order'=>'`order`'));
                    
                    foreach ($Srceens as $sc):
                        $json['S'.$sc->ID] = array();
                        $ScreenPieceset = EditorScreenPieceset::model()->findAllByAttributes(array('screenID'=>$sc->ID),array('order'=>'`position`'));
                        foreach ($ScreenPieceset as $scps):
                            $PieceSet = EditorPieceset::model()->findByAttributes(array('ID'=>$scps->piecesetID));
                            $json['S'.$sc->ID]['PS'.$PieceSet->ID] = array();
                            $json['S'.$sc->ID]['PS'.$PieceSet->ID]['desc'] = $PieceSet->desc;
                            $json['S'.$sc->ID]['PS'.$PieceSet->ID]['typeID'] = $PieceSet->typeID;
                            
                            $PieceSetPiece = EditorPiecesetPiece::model()->findAllByAttributes(array('piecesetID'=>$PieceSet->ID),array('order'=>'`order`'));
                            foreach ($PieceSetPiece as $psp):
                                $Piece = EditorPiece::model()->findByAttributes(array('ID'=>$psp->pieceID));
                                $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID] = array();
                                $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['description'] = $Piece->description;
                                $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['name'] = $Piece->name;
                                $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['typeID'] = $Piece->typeID;
                                
                                $PieceElement = EditorPieceElement::model()->findAllByAttributes(array('pieceID'=>$psp->pieceID),array('order'=>'`position`'));
                                
                                foreach ($PieceElement as $pe):
                                    $Element = EditorElement::model()->findByAttributes(array('ID'=>$pe->elementID));
                                    $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['E'.$Element->ID] = array();
                                    $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['E'.$Element->ID]['typeID'] = $Element->typeID;
                                    
                                    $ElementProperty = EditorElementProperty::model()->findAllByAttributes(array('elementID'=>$Element->ID));
                                    foreach ($ElementProperty as $ep):
                                        if($ep->propertyID == 4){ //libraryID
                                            $Library = Library::model()->findByAttributes(array('ID'=>$ep->value));
                                            $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['E'.$Element->ID]['L'.$Library->ID] = array();
                                            $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['E'.$Element->ID]['L'.$Library->ID]['typeID'] = $Library->typeID; //9 image; 17 movie; 20 sound 
                                            
                                            $LibraryProperty = LibraryProperty::model()->findAllByAttributes(array('libraryID'=>$Library->ID));
                                            foreach($LibraryProperty as $lp):
                                                $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['E'.$Element->ID]['L'.$Library->ID]['Prop'.$lp->propertyID] = $lp->value;
                                            endforeach;
                                        }else{
                                            $json['S'.$sc->ID]['PS'.$PieceSet->ID]['P'.$Piece->ID]['E'.$Element->ID]['Prop'.$ep->propertyID] = $ep->value;
                                            
                                        }
                                    endforeach;
                                endforeach;
                            endforeach;
                        endforeach;
                    endforeach;
                    
                }
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
                        $name = md5(uniqid(time())) . $ext;
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
        //escreve o json que serpa retornado
        echo json_encode($json);
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
