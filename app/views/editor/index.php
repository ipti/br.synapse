<!-- <?php
    $commonType = $_POST['commonType'];
    $cobjectTemplate =  $_POST['cobjectTemplate'];
    $cobjectTheme =  $_POST['cobjectTheme'];
    $actGoal = $_POST['actGoal'];
$this->breadcrumbs=array(
	'Editor',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
-->
       <script language ="javascript" type="text/javascript">
       <?php 
          echo "newEditor.COtypeID = $commonType ; \n" ; 
          echo "newEditor.COthemeID = $cobjectTheme; \n" ;
          echo "newEditor.COtemplateType = $cobjectTemplate; \n"; 
       ?>
       </script>

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
            </div>