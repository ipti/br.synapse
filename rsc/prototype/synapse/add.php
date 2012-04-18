<?php
 
     ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
     require('http://' . $_SERVER['SERVER_NAME'] . '/synapse/includes/historico_navegacao.php');
     ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}

     session_start();

     if (session_is_registered('navegacao')) {
        
         ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
         require("includes/conecta.php");
         ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		
		 ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		 require("includes/funcoes.php");
		 ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
     
        if(isset($prod)){
            $SQL = "SELECT a.*, (g.name_varchar) as g_name, (s.name_varchar) as s_name 
					FROM activity a 
						LEFT JOIN goal g ON g.id = a.goal_id LEFT JOIN semantic s ON s.id = a.semantic_id 
					WHERE a.id = ".$prod;

            $res = pg_query($SQL);

            $linha = pg_fetch_array($res);

            if( (sizeof($_SESSION['produtos'])) > 0){

               foreach($_SESSION['produtos'] as $produto){
                   if($produto['id'] == $linha['id']){
                       $existe = true;
                       break;
                   }
               }

               if(!$existe){
                   $_SESSION['produtos'][(sizeof($produtos)+1)] = $linha;
                   $_SESSION['qtdes'][(sizeof($produtos))] = $qtde;
                   $_SESSION['produtos'][(sizeof($produtos))][13] = $qtde;

               }
            }else{

               $_SESSION['produtos'] = array();
               $_SESSION['qtdes'] = array();
               $_SESSION['produtos'][1] = $linha;
               $_SESSION['qtdes'][1] = $qtde;
               $_SESSION['produtos'][1][13] = $qtde;
            }
        }
     header("Location: http://".$_SERVER['HTTP_HOST']. $back);
     }
 ?>