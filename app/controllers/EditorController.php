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
                'actions' => array('index', 'upload', 'json'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionJson(){
        if(isset($_POST['op'])){
            if($_POST['op'] == 'save' && isset($_POST['step'])){
                switch($_POST['step']){
                    case "CObject":  
                        break;
                    case "Screen":  
                        break;
                    case "PieceSet":  
                        break;
                    default:
                        echo "default";
                }
              
            }elseif($_POST['op'] == 'load'){
                
            }
        }else{
            $json = "ERROR: Operação inválida.";
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
                            $json = $url.$name;
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