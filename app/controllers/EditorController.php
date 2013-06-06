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
                'actions' => array('index', 'upload', 'json', 'preeditor', 'filtergoal'),
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
           if(isset($_POST['actGoal'])) {
            $this->render('index');
           }else{
            $this->redirect('/editor/preeditor?error=1');   
           }
        }
    }
    public function actionPreeditor(){
        $this->render('preeditor');
    }
    public function actionFiltergoal(){
        $idDiscipline = $_POST['idDiscipline'];
        $idDegree = $_POST['idDegree'];
     if($idDegree == "undefined") { 
        $actGoal_disc = Yii::app()->db->createCommand('SELECT degreeID FROM act_goal 
            WHERE disciplineID =' . $idDiscipline . ' GROUP BY degreeID')->queryAll();
        $count_Agoal_disc = count($actGoal_disc);
        if($count_Agoal_disc > 0){
            for($i=0; $i<$count_Agoal_disc; $i++) {
                // Array dos Degrees - A cada repetição irá guarda 1 único registro 
              $actDegree[$i] = Yii::app()->db->createCommand('SELECT ID, name FROM act_degree
                WHERE ID = ' . $actGoal_disc[$i]['degreeID'] . ' AND grade > 0')->queryAll();
            }
            $count_Adeg = count($actDegree);
              if($count_Adeg > 0 ) {
                  $str = "<div id='propertyAdeg' align='left'> 
                 Act Degree&nbsp;:&nbsp;
                 <select id='actDegree' name='actDegree'>  ";
                  for($i=0; $i < $count_Adeg; $i++) {
                    $str.= "<option value=" . $actDegree[$i][0]['ID'] . ">" . $actDegree[$i][0]['name'] . "</option>";
                  }
                  $str.= "</select> 
              </div> " ;
                  
                  //Por padrão, como não foi selecionado algum Degree, mostrará o GOAL do 1° [0]
                  $actGoal_d = Yii::app()->db->createCommand('SELECT ID, name FROM act_goal 
                     WHERE disciplineID =' . $idDiscipline . ' AND degreeID =' . $actDegree[0][0]['ID'])->queryAll();
                  $count_Agoal_d = count($actGoal_d);
                  // No mínimo possui 1 registro
                  $str.= "<div id='propertyAgoal' class='propertyAgoal' align='center'>
                      <br> Act Goal&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
                  for($i=0; $i < $count_Agoal_d; $i++) {
                    $str.= "<option value=" . $actGoal_d[$i]['ID'] . ">" . $actGoal_d[$i]['name'] . "</option>" ;   
                  }
                  $str.= "</select>
                      </div>
             <script type='text/javascript'>
                $('#actDegree').change(function(){
                  $('#propertyAgoal').load(\"filtergoal\", {idDiscipline: $('#actDiscipline').val(), idDegree: $('#actDegree').val()} ); 
                });
                $('#actGoal,#actDegree,#actDiscipline').change(function(){
                  $('#error').hide(1000);
                });
             </script>";
                  
                  echo $str;
                  
              }else{
                  //Não encontrou algum act_degree relacionado a esta disciplina(with grade>0)
              }
            
        }else{
            //Não encontrou algum goal para a disciplina selecionada
            echo "<font color='red' size='2'>
                Não encontrou algum Objetivo para a disciplina selecionada !</font>";
        }
         
     }else{
         //Selecionou Algum Degree
                  $actGoal_d = Yii::app()->db->createCommand('SELECT ID, name FROM act_goal 
                     WHERE disciplineID =' . $idDiscipline . ' AND degreeID =' . $idDegree)->queryAll();
                  $count_Agoal_d = count($actGoal_d);
                  // No mínimo possui 1 registro
                  $str = "<br> Act Goal&nbsp;:&nbsp;
                      <select id='actGoal' name='actGoal' style='width:430px'> ";
                  for($i=0; $i < $count_Agoal_d; $i++) {
                    $str.= "<option value=" . $actGoal_d[$i]['ID'] . ">" . $actGoal_d[$i]['name'] . "</option>" ;   
                  }
                  $str.= "</select>";
                  
                  echo $str;
     }
     
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
