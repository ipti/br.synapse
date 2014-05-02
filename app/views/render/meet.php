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
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->


<script>
    $(document).ready(function(){
        //Iniciar Encontro
        var personage = '<?php echo Yii::app()->session['personage']; ?>';
        var idActor = '<?php echo Yii::app()->session['idActor']; ?>';
        var unityIdActor = '<?php echo Yii::app()->session['unityIdActor']; ?>';
        var newMeet = new Meet(personage, idActor, unityIdActor);
        
        <?php var_dump($_POST); ?>
        
        var CobjectID = 999;
       $.ajax({
            type: "POST",
            url: "/render/loadcobject",
            dataType: 'json',
            data: {
                ID:CobjectID
            },                
            error: function( jqXHR, textStatus, errorThrown ){
                $('#img_load').remove();
                $('html').html(jqXHR.responseText);
            },
            success: function(response, textStatus, jqXHR){
                //Cobjects 
                 var current_cobject = response; 
                 var dump = new DomCobject(current_cobject);
                 $('#render_canvas').html(dump.buildAll());
                 // Render Ready!
                 //Carregar o Script de eventos, após a construção do html dos cobjects
                 $.getScript("<?php echo Yii::app()->theme->baseUrl;?>/js/render/events.js").done(function(script, textStatus) {
             });
                 
                // newMeet.getInfoStudent
                  
            }
                });
            
        
    }); 
    
</script>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body id="synapse">
        <div id="register_canvas">
            
        </div>
        <div id="register_student_canvas">
            
        </div>
        <div id="render_canvas">

        </div>
    </body>
</html>

