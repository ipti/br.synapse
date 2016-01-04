<?php

class ResourcesController extends Controller {


    public $layout = 'none';

    public function actionCss() {
        $this->render('css');
    }

    public function actionFlash() {
        $this->render('flash');
    }
    public function genfile(){

        return $content;
    }
    function compress($buffer) {
        /* remove comments */
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','     '), '', $buffer);
        /* remove other spaces before/after ; */
        $buffer = preg_replace(array('(( )+{)','({( )+)'), '{', $buffer);
        $buffer = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $buffer);
        $buffer = preg_replace(array('(;( )+)','(( )+;)'), ';', $buffer);
        return $buffer;
    }
    public function actionJs($file) {
        //$js = 's';
        //$content = file_get_contents('D:/IPTI/Projetos/synapse.ipti.org.br/themes/classic/js/'.$file);
        //$e  = include('D:/IPTI/Projetos/synapse.ipti.org.br/themes/classic/js/'.$file);
        //eval("\$js = $content;");
        //echo $content;exit;
        //$ok = CViewRenderer::fileExtension;
        //spl_autoload_extensions(".inc,.php,.js");
        //Yii::app()->findLocalizedFile($viewFile.$extension);
        //$renderer=
        //
        //ob_start();
        //include $filename;
        //echo ob_get_clean();
        // var_dump(Yii::app()->);
        $path = $_SERVER["DOCUMENT_ROOT"].Yii::app()->theme->baseUrl.'/js/'.$file;
        if(file_exists($path)){
            $fcontent = file_get_contents($path);
        }else{
            echo 'Nâo Existe';exit;
        }
        ob_start();
        eval(' ?>'.$fcontent.'<?php ');
        $content = ob_get_clean();
        echo $this->compress($content);exit;
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