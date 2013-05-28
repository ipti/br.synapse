<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/rendereditor/editor.css" />
        <!---[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery-1.7.2.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.core.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.widget.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.mouse.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.draggable.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.droppable.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/render.js"></script>
    </head>
    <body class="theme" >
        <script>
            var newRender = new render();
            $(function() {
                $.ajax({
                    url:"/render/json",//this is the request page of ajax
                    data:{op:'start'},//data for throwing the expected url
                    type:"POST",
                    dataType:"json",// you can also specify for the result for json or xml
                    success:function(response){newRender.startRender(response);$('#rclassys').trigger('change');$('#rdiscipline').trigger('change');$('#rblockscript select').trigger('change');},
                    error:function(){
                    }
                });
                
                $('#previous').on('click',function(){
                    
                });
                $('#rblockscript').change(function(){
                    $('.blockscript').hide();
                    v = $("#rblockscript select").val();
                    $('#'+v).show();
                });
                $('#rdiscipline').change(function(){
                    $('.rscripts').hide();
                    $('.rblocks').hide();
                    v = $("select#rdiscipline").val();
                    newRender.disciplineID = v;
                    $('#rscript'+v).show();
                    $('#rblock'+v).show();
                });
                $('.start').click(function(){
                    newRender.typeID = $('#typeID').val();
                    newRender.atdID = $('#atdID').val();
                    newRender.scriptID = $('select#rscript'+newRender.disciplineID).val();
                    newRender.blockID = $('select#rblock'+newRender.disciplineID).val();
                    newRender.classID = $('#classID').val();
                    newRender.userID = $('select#student'+newRender.classID).val();
                    $('#userID').val(newRender.userID);
                    $('.prerender').hide();
                    $('.waiting').show();
                    loadActs();
                })
            });
            function loadActs(){
                $.ajax({
                    url:"/render/json",
                    data:{op:'render',script:newRender.scriptID,userID:newRender.userID,classID:newRender.classID,typeID:newRender.typeID,blockID:newRender.blockID},
                    type:"POST",
                    dataType:"json",// you can also specify for the result for json or xml
                    success:function(response){$('body').css('background','#fff');newRender.loadJson2(response); $('.waiting').hide();$('.render').show();newRender.paginate()},
                    error:function(){
                    }
                });
            }
        </script>
        <div class="canvasr">
            <?php echo $content?> 
        </div>   
    </body>
</html>
