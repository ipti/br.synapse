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
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/editor.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery-1.7.2.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.core.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.widget.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.mouse.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.draggable.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.ui.droppable.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.pajinate.min.js"></script>
        <script>
            var newEditor = new editor();
            $(function() {
                $('.canvas').pajinate({
                    items_per_page : 1,
                    nav_label_first : '<<',
                    nav_label_last : '>>',
                    nav_label_prev : '<',
                    nav_label_next : '>',
                    show_first_last : false,
                    num_page_links_to_display: 20,
                    nav_panel_id : '.navpage',
                    editor : newEditor
                });            
                newEditor.countQuestion['pg0'] = 0;
                newEditor.countTasks['pg0_q0'] = 0;
                $("#toolbar").draggable({ axis: "y" });
                            
                $("#addpage").click(function(){
                    $(".content").append(newEditor.buildHtml('addPage'));
                    $('.canvas').pajinate({
                        items_per_page : 1,
                        nav_label_first : '<<',
                        nav_label_last : '>>',
                        nav_label_prev : '<',
                        nav_label_next : '>',
                        show_first_last : false,
                        num_page_links_to_display: 20,
                        nav_panel_id : '.navpage',
                        editor : newEditor
                    });
                });
                $("#addtext").click(function(){
                    var id = newEditor.currentTask;
                    $('#'+id).append(newEditor.buildHtml('addText'));
                    $( ".text" ).draggable({ containment: '#'+id, scroll: true });
                });
                $("#addquestion").click(function(){
                    var id = newEditor.currentPageId;
                    $('#'+id).append(newEditor.buildHtml('addQuest'));
                })
                /*$(".page").live("click",(function(){
                    //alert(newEditor.currentPageId);
                    $('.page').removeClass('activePage');
                    //newEditor.currentPageId = $(this).attr('id');
                    $(this).addClass('active');
                }));
                /* $(".tasklist").live("click",(function(){
                    $('.tasklist').removeClass('active');
                    $(this).addClass('active');
                    newEditor.currentQuest = $(this).attr('id');
                }));*/
                $(".addTask").live("click",(function(){
                    var id = $(this).attr('id');
                    id = id.replace("tsk_", "");
                    newEditor.currentQuest = id;
                    $('#'+id).append(newEditor.buildHtml('addTask'));
                }));
                $('.task').live("click",function(){
                    $('.task').removeClass('active');
                    var id = $(this).attr('id');
                    $(this).addClass('active');
                    newEditor.currentTask = id;
                });
            });
        </script>
        <title></title>
    </head>
    <body class="theme">
        <style type="text/css">
            .themebutton{border:0px;border:1px solid #333; background: -moz-linear-gradient(top, #444444 0%, #343434 100%);}
            .theme .clear{clear:both;display:block;}
            .theme{font-family:sans-serif}
            .theme header{height:40px;background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_header_menu.jpg') repeat-x;border-bottom:2px solid #999}
            .theme header h1{float:left;margin-left:5px;position:relative;top:7px;height:25px;width:25px;text-indent:-9999px;background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_header_logo.jpg') no-repeat;}
            .theme header ul{float:left;}
            .theme header li{font-size:12px; color:#fff; text-shadow: 2px 2px 7px #111;padding:8px;margin-left:10px;margin-top:5px;border-radius: 6px;border:1px solid #272727;background: -moz-linear-gradient(top, #444444 0%, #343434 100%);float:left;}
            .theme div.toolbar{-moz-box-shadow: inset 0 0 1px #868787;margin-top:10px; margin-left:30px; border:1px solid #151516; float:left;width:88px; height:402px;background:#191D22}
            .theme div.toolbar h2{margin-left:1px;padding-top:6px;font-size:11px; color:#fff;text-align:center;display:block; height:14px; width:86px;background: -moz-linear-gradient(top, #46494D 0%, #191D22 100%);}
            .theme div.toolbar ul.tools{display:block;clear:both;width:84px;margin-left:2px; height:3d70px;background: -moz-linear-gradient(left, #b8bdc1 0%, #cbcfd2 46%, #b9bdc1 100%);}
            .theme ul.tools li{display:block;width:80px; height:50px;text-indent:-9999px;margin-top:10px;}
            .theme ul.tools li#addimage{padding-top:7px; background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_tools_addimage.png') bottom no-repeat;}
            .theme ul.tools li#addsound{background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_tools_addsound.png') bottom no-repeat;}
            .theme ul.tools li#addvideo{background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_tools_addvideo.png') bottom no-repeat;}
            .theme ul.tools li#addtext{background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_tools_addtext.png') bottom no-repeat;}
            .theme ul.tools li#addquestion{background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_tools_addquestion.png') bottom no-repeat;}
            .theme ul.tools li#addanswer{background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_tools_addanswer.png') bottom no-repeat;}
            .theme div.canvas{}
            .theme div.canvas button#addpage,.theme div.canvas button#delpage{float:left;font-size:12px; height:28px;font-weight:bold;color:#fff;}
            .theme div.canvas ul.navpage{float:left; width:430px;height:28px;margin-left:326px;}
            .theme div.canvas div.page{background:#fff;min-height: 500px}
            .theme ul.navpage li{float:left;}
            .theme ul.navpage li#back,.theme ul.navpage li#next{width:28px;height:23px;text-align:center;font-size:22px; font-family:serif;font-weight:bold;color:#fff;}
            .theme ul.navpage li#position{width:100px;text-align:center;height:23px;font-size:12px; line-height:22px;font-weight:bold;color:#fff;}
            .theme div.canvas div.content{background:#fff; width:100%;clear:both;margin-top:5px;}
            .theme div.page input.actName{border:1px dotted #999; width:100%; height:30px;color:#999;font-size:14px;font-weight:bold;margin-bottom:10px;}
            .theme div.quest button.addTask{float:left;height:30px;width:30px;border:0px;text-indent:-9999px;background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_activity_addtask.png')}
            .theme .tasklist{height:200px; overflow-y:scroll;float:left;width:928px;border:1px dotted #999}
            .theme .tasklist .task{display:block;border:1px dotted #999;padding:10px;margin:10px 0px;min-height:20px;}
            .theme .tasklist .delTask{border:0px; background:url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_activity_deltask.png');margin-bottom:-16px; float:right; position:relative; top:0; display:block; right: 0px; height:16px; width:16px;text-indent:-9999px;}
            .active{border-color: red !important;}
            .page_link{visibility:hidden}
            .ellipse{
                float: left;
            }

            .container{
                width: 260px;
                float: left;
                margin: 50px 10px 10px;
                padding: 20px;
                background-color: white;
            }

            .page_navigation , .alt_page_navigation{
                padding-bottom: 10px;
            }

            .page_navigation a, .alt_page_navigation a{
                padding:3px 5px;
                margin:2px;
                color:white;
                text-decoration:none;
                float: left;
                font-family: Tahoma;
                font-size: 12px;
                background-color:#DB5C04;
            }
            .active_page{
                background-color:white !important;
                color:black !important;
            }	

            .content, .alt_content{
                color: black;
            }

            .content li, .alt_content li, .content > p{
                padding: 5px
            }
            .dragsource{margin-bottom:50px;display:block;}
            .dragsource li{float:left;height:100px;width:100px;border:1px solid;}
            .dragtarget li{float:left;height:100px;width:100px;border:1px solid;}
            .dragtarget{display:block;clear:both;}
        </style>

        <header>
            <hgroup>
                <h1>TAG</h1>
                <ul>
                    <li>Leitura de palavra: substantivos.</li>
                    <li style="float:right;">ScreenTime: 16/07/2012 22:55:36</li>
                </ul>
                <span class="clear"></span>
            </hgroup>
        </header>
        <script>
            $(function() {
                $( ".dragsource li" ).draggable({ grid: [50, 20],helper: "clone",opacity: 0.35,revert: 'invalid',snap: true,
                start: function(event, ui) {
                    $(this).css('border','1px dashed');
                    $(this).html('');
                },
                stop: function(event, ui) {
                    $(this).css('border','1px solid');
                    $(this).html($(ui.helper).html());
                }
                });
                $( ".dragtarget li" ).droppable({
                    drop: function( event, ui ) {
                        $(ui.draggable).replaceWith('').css('border','1px dashed').draggable( "option", "disabled" );
                        $(this).droppable("option", "disabled", true);
                        $(this).css('border-color', 'green');
                        alert($(ui.draggable).atrr('hash'));
                    }
                    
                });
            });
        </script>

        <div class="canvas">
            <div class="content">
                <div class="page">
                    <ul class="dragsource">
                        <li hash="2356">Banana</li>
                        <li hash="42543">Maça</li>
                        <span style="display:block;clear:both"></span>
                    </ul>
                    <ul class="dragtarget">
                        <li hash="23546">Banana</li>
                        <li hash="4254">Maça</li>
                        <span style="display:block;clear:both"></span>
                    </ul>
                </div>
            </div>

    </body>
</html>
