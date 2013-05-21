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
            if($_POST['op'] == 'save'){
               
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
            
        if(isset($_POST)){
            if(isset($_POST['op'])){
                if($_POST['op'] == 'image'){
                    $extencions = array(".jpg",".jpeg",".gif",".png", ".bmp");
                    $max_size = 1024 * 5; //5MB

                } elseif ($_POST['op'] == 'sound'){
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
                        $name = md5(uniqid(time())).$ext; //E:\Programas\xampp\tmp\php746E.tmp
                        $tmp = $_FILES['file']['tmp_name'];
                        if(move_uploaded_file($tmp,$path.$name)){
                            //mysql_query("INSERT INTO fotos (foto) VALUES (".$nome_atual.")");
                            $json = $url.$name;
                        }else{
                            $json = "ERROR: Falha ao enviar";
                        }
                    }else{
                        $json = "ERROR: A arquivo deve ser de no máximo $size";
                    }
                }else{
                    $json = "ERROR: Somente são aceitos arquivos do tipo ".$_POST['op'].".";
                }
            }else{
                $json = "ERROR: Operação não definida.";
            }
        }else{
            $json = "ERROR: Selecione um arquivo.";
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