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
                'actions' => array('index', 'upload', 'json', 'preeditor'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
   public function actionIndex() {
     if( !isset($_POST['commonType']) && !isset($_POST['cobjectTemplate']) &&  !isset($_POST['cobjectTheme']) ) {
       $this->redirect('/editor/preeditor');
       }else { 
            $this->render('index');
        }
    }
    public function actionPreeditor(){
        $this->render('preeditor');
    }
    
    public function actionJson(){
        $json = array();
        if(isset($_POST['op'])){
            if($_POST['op'] == 'save' && isset($_POST['step'])){
                switch($_POST['step']){
                    case "CObject":
                        if(isset($_POST['COtypeID']) && isset($_POST['COthemeID']) 
                            && isset($_POST['COtemplateType']) && isset($_POST['COgoalID'])){
                            $typeID = $_POST['COtypeID'];
                            $templateID = $_POST['COtemplateType'];
                            $themeID = $_POST['COthemeID'];
                            $goalID = $_POST['COgoalID'];
                            
                            $newCobject = new Cobject();
                            $newCobject->typeID = $typeID;
                            $newCobject->templateID = $templateID;
                            $newCobject->themeID = $themeID;
                            $newCobject->insert();
                            
                            $cobject = Cobject::model()->findByAttributes(array(),array('order'=>'ID desc'));
                            $cobjectID = $cobject->ID;
                            
                            $newCobjectMetadata = new CobjectMetadata();
                            $newCobjectMetadata->cobjectID = $cobjectID;
                            $newCobjectMetadata->typeID = 6;
                            $newCobjectMetadata->value = $goalID;
                            $newCobjectMetadata->insert();
                            
                            $json['CObjectID'] = $cobjectID;
                            
                        }else{
                            throw new Exception("ERROR: Dados do CObject insuficientes.<br>");   
                        }
                        break;
                    case "Screen":
                        if(isset($_POST['CObjectID']) && isset($_POST['Number']) && isset($_POST['Ordem'])
                            && isset($_POST['Width']) && isset($_POST['Height']) && isset($_POST['DomID'])){
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
                            
                            $screen = EditorScreen::model()->findByAttributes(array(),array('order'=>'ID desc'));
                            $screenID = $screen->ID;   
                            
                            $json['DomID'] = $DomID;
                            $json['screenID'] = $screenID;
                            
                        }else{
                            throw new Exception("ERROR: Dados da Screen insuficientes.<br>");   
                        }
                        break;
                    case "PieceSet":
                        if(isset($_POST['typeID']) && isset($_POST['desc']) && isset($_POST['screenID'])
                            && isset($_POST['position']) && isset($_POST['templateID']) && isset($_POST['DomID'])){
                            
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
                            
                            $pieceSet = EditorPieceset::model()->findByAttributes(array(),array('order'=>'ID desc'));
                            $pieceSetID = $pieceSet->ID;   
                            
                            $newScreenPieceSet = new EditorScreenPieceset();
                            $newScreenPieceSet->screenID = $screenID;
                            $newScreenPieceSet->piecesetID = $pieceSetID;
                            $newScreenPieceSet->position = $position;
                            $newScreenPieceSet->templateID = $templateID;
                            $newScreenPieceSet->insert();
                            
                            $json['DomID'] = $DomID;
                            $json['PieceSetID'] = $pieceSetID;
                            
                        }else{
                            throw new Exception("ERROR: Dados da PieceSet insuficientes.<br>");   
                        }
                        break;
                    case "Piece":
                        if(isset($_POST['pieceSetID']) && isset($_POST['ordem']) 
                           && isset($_POST['typeID']) && isset($_POST['DomID'])){
                            
                            $DomID = $_POST['DomID'];
                            $pieceSetID = $_POST['pieceSetID'];
                            $ordem = $_POST['ordem'];
                            $typeID = $_POST['typeID'];
                            
                            $newPiece = new EditorPiece();
                            $newPiece->typeID = $typeID;
                            $newPiece->insert();
                            
                            $piece = EditorPiece::model()->findByAttributes(array(),array('order'=>'ID desc'));
                            $pieceID = $piece->ID; 
                            
                            $newPieceSetPiece = new EditorPiecesetPiece();
                            $newPieceSetPiece->pieceID = $pieceID;
                            $newPieceSetPiece->piecesetID = $pieceSetID;
                            $newPieceSetPiece->order = $ordem;
                            $newPieceSetPiece->insert();
                            
                            $json['DomID'] = $DomID;
                            $json['PieceID'] = $pieceID;
                            
                        }else{
                            throw new Exception("ERROR: Dados da Piece insuficientes.<br>");   
                        }
                        break;
                    case "Element":
                        if(isset($_POST['typeID'])){
                            $typeID = $_POST['typeID'];
                            
                            if(isset($_POST['pieceID']) && isset($_POST['flag']) && isset($_POST['ordem']) 
                               && isset($_POST['value']) && isset($_POST['DomID'])){

                                $DomID = $_POST['DomID'];
                                $pieceID = $_POST['pieceID'];
                                $flag = $_POST['flag'];
                                $value = $_POST['value'];
                                $position = $_POST['ordem'];

                                $newElement = new EditorElement();
                                $newElement->typeID = $typeID;
                                $newElement->insert();

                                $element = EditorElement::model()->findByAttributes(array(),array('order'=>'ID desc'));
                                $elementID = $element->ID; 

                                $newPieceElement = new EditorPieceElement();
                                $newPieceElement->pieceID = $pieceID;
                                $newPieceElement->elementID = $elementID;
                                $newPieceElement->position = $position;
                                $newPieceElement->insert();

                                $json['DomID'] = $DomID;
                                $json['ElementID'] = $elementID;

                            }else{
                                throw new Exception("ERROR: Dados da Element insuficientes.<br>");   
                            }
                            
                            switch($typeID){
                                case 12: //word
                                break;
                            
                                case 16: //image
                                break;
                                default:
                                    throw new Exception("ERROR: Tipo inválido.<br>");
                            }
                        }else{
                            throw new Exception("ERROR: Operação inválida.<br>");
                        }
                        break;
                    default:
                        throw new Exception("ERROR: Operação inválida.<br>");
                }
              
            }elseif($_POST['op'] == 'load'){
                
            }else{
                throw new Exception("ERROR: Operação inválida.<br>");
            }
        }else{
            throw new Exception("ERROR: Operação inválida.<br>");
        }
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($json);
    }
    
    public function actionUpload(){
            
        if(isset($_FILES['file'])){
            if(isset($_POST['op'])){
                if($_POST['op'] == 'image'){
                    $extencions = array(".png",".gif",".bmp",".jpeg",".jpg",".ico");
                    $max_size = 1024 * 5; //5MB

                } elseif ($_POST['op'] == 'audio'){
                    $extencions = array(".mp3",".wav",".ogg");
                    $max_size = 1024 * 10; //10MB

                } elseif ($_POST['op'] == 'video'){
                    $extencions = array(".mp4",".webm",".ogg");
                    $max_size = 1024 * 20; //20MB
                }
                $path = Yii::app()->basePath . '\..\rsc\upload\\'.$_POST['op'].'\\';
                $url = "/rsc/upload/".$_POST['op']."/";

                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                
                $ext = strtolower(strrchr($file_name,"."));

                if(in_array($ext,$extencions)){
                    $size = round($file_size / 1024);
                    if($size < $max_size){
                        $name = md5(uniqid(time())).$ext; 
                        $tmp = $_FILES['file']['tmp_name'];
                        try{
                            move_uploaded_file($tmp,$path.$name);
                            $json = array();
                            $json['url'] = $url.$name;
                            $json['name'] = $name;
                        }catch (Exception $e){
                            throw new Exception("ERROR: Falha ao enviar.<br>");
                        }
                    }else{
                        throw new Exception("ERROR: A arquivo deve ser de no máximo $size<br>");
                    }
                }else{
                    throw new Exception("ERROR: Somente são aceitos arquivos do tipo ".$_POST['op'].".<br>");
                }
            }else{
                throw new Exception("ERROR: Operação não definida.<br>");
            }
        }else{
            throw new Exception("ERROR: Selecione um arquivo.<br>");
        }
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
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
