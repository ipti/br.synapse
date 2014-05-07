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
        //===========================================
        var unityfather = '<?php echo $_POST["unityfather"]; ?>'; 
        var org = '<?php echo $_POST["org"][1]; ?>'; 
        var classe = '<?php echo $_POST["class"]; ?>'; 
        var actor = '<?php echo $_POST["actor"]; ?>'; 
        
        //var unityfather_name = '<?php // echo $_POST["unityfather"]; ?>'; 
        var org_name = '<?php echo $_POST["name_org_1"]; ?>'; 
        var classe_name = '<?php echo $_POST["name_classes"]; ?>'; 
        var actor_name = '<?php echo $_POST["name_actors"]; ?>'; 
          
        var options = {
            org: [org,org_name],
            classe: [classe,classe_name],
            actor: [actor,actor_name]
        };
        
        
        var newMeet = new Meet(unityfather,options);
        $('#head_meet').append(newMeet.headMeet());
        
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
                 //Adicionar o domCobjets no Encontro 'Meet'
                 newMeet.setDomCobjects(dump);
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
        <div id="head_meet">
        </div>
        
        <div id="register_student_canvas">
        </div>
        
        <div id="render_canvas">
        </div>
    </body>
</html>

