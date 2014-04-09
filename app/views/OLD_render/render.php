<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
         <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/poseditor/jquery.min.js"></script>
          <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/render_model.js"></script>
          <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/domode.json"></script>
          <script type="text/javascript">
              
              $(document).ready(function(){
                  console.log(cobject);
                  var domCobject = new DomCobject(cobject);
                  domCobject.buildAll();
              });
              
          </script>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body id="synapse">
        <div id="register_canvas">
            
        </div>
        <div id="register_student_canvas">
            
        </div>
        <div id="render_canvas">
            <span id="msgload" style="font-size:12px;">Inicializando...</span>

        </div>
    </body>
</html>

