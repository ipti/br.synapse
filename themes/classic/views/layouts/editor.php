<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery/jquery.ui.all.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/rendereditor/editor.css" />
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/editor.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery-1.7.2.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.core.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.widget.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.mouse.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.draggable.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.pajinate.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.form.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.jeditable.mini.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/oneditor.js"></script>
        <title>Synapse - Editor</title>
    </head>
    <body class="theme">
        <header>
            <hgroup>
                <h1>TAG</h1>
                <ul>
                    <li class="new">NOVO</li>
                    <li class="save">SALVAR</li>
                </ul>
                <span class="clear"></span>
            </hgroup>
        </header>
        <div id="toolbar" class="toolbar">
            <h2>INSERIR</h2>
            <ul class="tools">
                <!--<li id="addimage">Imagem</li>
                <li id="addsound">Sound</li>
                <li id="addvideo">Video</li>
                <li id="addtext">Text</li>-->
                <li id="addPieceSet">Question</li>
                <!--<li id="addanswer">Answer</li>-->
            </ul>
        </div>
        <div class="canvas">
            <button class="themebutton" id="addScreen">NOVA TELA</button>
            <ul class="navscreen"></ul>
            <button class="themebutton" id="delScreen">APAGAR TELA</button>
            <span class="clear"></span>
            <div class="content">
                <div class="screen" id="sc0">
                    <!--<div class="quest" id="pg1_q1">
                        <input type="text" class="actName" />
                        <button class="addTask" id="tsk_pg1_q1">AddTask</button>
                        <ul class="tasklist" id="pg1_q1_tasks">
                            <li class="task" id="pg1_q1_t1">
                                    <button class="delTask">DelTask</button>
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                            </li>
                             <li class="task" id="pg1_q1_t1">
                                    <button class="delTask">DelTask</button>
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    1+1 = <input type="text"/> <br/> 
                                    
                            </li>
                        </ul>
                        <span class="clear"></span>
                    </div>
                </div>-->
                </div>
            </div>
    </body>
</html>
