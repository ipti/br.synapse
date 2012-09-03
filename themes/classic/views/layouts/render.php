<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/rendereditor/editor.css" />
        <!--[if lt IE 8]>
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
    <body class="theme">
        <script>
            var newRender = new render();
            $(function() {
                $.ajax({
                    url:"/render/json",//this is the request page of ajax
                    data:{op:'start'},//data for throwing the expected url
                    type:"POST",
                    dataType:"json",// you can also specify for the result for json or xml
                    success:function(response){newRender.startRender(response);$('#rclassys').trigger('change');$('#rdiscipline').trigger('change');},
                    error:function(){
                    }
                });
                
                $('#previous').on('click',function(){
                    
                });
                $('#rdiscipline').change(function(){
                    $('.rscripts').hide();
                    v = $("select#rdiscipline").val();
                    newRender.disciplineID = v;
                    $('#rscript'+v).show();
                });
                $('.start').click(function(){
                    newRender.scriptID = $('select#rscript'+newRender.disciplineID).val();
                    $('.prerender').hide();
                    $('.waiting').show();
                    loadActs();
                })
            });
            function loadActs(){
                $.ajax({
                    url:"/render/json",//this is the request page of ajax
                    data:{op:'render',script:newRender.scriptID},//data for throwing the expected url
                    type:"POST",
                    dataType:"json",// you can also specify for the result for json or xml
                    success:function(response){$('body').css('background','#fff');newRender.loadJson2(response); $('.waiting').hide();$('.render').show();newRender.paginate()},
                    error:function(){
                    }
                });
            }
        </script>
        <div class="canvasr">
            <style>
                .prerender{border:1px solid #000;width:319px;margin:100px auto;background: #262626;}
                .prerender .innerborder{border:1px solid #4A4A4A;background:#fff;width:317px;}
                .prerender label{display:block;font-size:12px;color:#5E5E5E;margin:5px 0px;}
                .render{display:none;}
                .prerender h1{margin-top:-28px;display:block;height:112px;width:317px;background: url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_render_header.png')}
                .prerender form{display:block;padding:5px;}
                .rscripts,.students,.tutors{display:none;}
                .prerender label{display:block;clear:both;height:20px;}
                .prerender font{float:left;width:120px;height:20px;text-align:right;margin-right:5px; line-height: 20px;}
                .start{display:block;clear:both;margin:0 auto}
                .waiting{display:none;}           
            </style>
            <div class="prerender">
                <div class="innerborder">
                    <h1></h1>
                    <form>
                        <label>
                            <font>Tipo de Atendimento:</font>
                            <select>
                                <option>AVALIAÇÃO</option>
                                <option>TREINO</option>
                                <option>LIVRE</option>
                            </select>
                        </label>
                        <label id="rdiscipline">
                            <font>Disciplina:</font>
                        </label>
                        <label id="rscript">
                            <font>Roteiro:</font>
                        </label>
                        <label>
                            <font>Seguir a matriz:</font>
                            <select>
                                <option>SIM</option>
                                <option>NÃO</option>
                            </select>
                        </label>
                        <label id="rclasses">
                            <font>Turma:</font>
                        </label>
                        <label id="rtutors">
                            <font>Tutor:</font>
                        </label>
                        <label id="rstudents">
                            <font>Aluno:</font>
                        </label>
                        <label id="password">
                            <font>Senha:</font>
                            <input name="password" value="" type="password"/>
                        </label>
                        <input class="start" type="button" value="iniciar atendimento">
                    </form>
                </div>
            </div>
            <div class="waiting"><font style="font-size:50px;margin:200px auto;display:block; text-align: center">Carregando...</font></div>
            <div class="render">
                <div class="activities"></div>
            </div>
        </div>   
    </body>
</html>
