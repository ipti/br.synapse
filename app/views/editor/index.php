<?php
    $_POST['goal'] = 1;
    if (isset($_POST['commonType']) && isset($_POST['cobjectTemplate']) 
        && isset($_POST['cobjectTheme']) && isset($_POST['goal'])){
        $commonType = $_POST['commonType'];
        $cobjectTemplate = $_POST['cobjectTemplate'];
        $cobjectTheme = $_POST['cobjectTheme'];
        $goal = $_POST['goal'];
     }
     else{ 
         die('ERROR: POST Inválido');
     }
$this->breadcrumbs=array(
	'Editor',
);?>
<script language ="javascript" type="text/javascript">
<?php 
   echo "newEditor.COtypeID = $commonType ; \n" ; 
   echo "newEditor.COthemeID = $cobjectTheme; \n" ;
   echo "newEditor.COtemplateType = $cobjectTemplate; \n"; 
   echo "newEditor.COgoalID = $goal; \n"; 
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
        </div>
    </div>
</div>