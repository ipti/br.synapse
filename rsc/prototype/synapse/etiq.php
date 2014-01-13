<?
  	  session_start();
	  
      ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
      require("includes/conecta.php");
      ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
      
	  
      ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
      require("includes/funcoes.php");
      ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
      

	?>
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<STYLE type=text/css>.cp {
	FONT: bold 10px Arial; COLOR: black
}
.ti {
	FONT: 9px Arial, Helvetica, sans-serif
}
.ld {
	FONT: bold 15px Arial; COLOR: #000000
}
.ct {
	FONT: 9px "Arial Narrow"; COLOR: #000033
}
.cn {
	FONT: 9px Arial; COLOR: black
}
.bc {
	FONT: bold 22px Arial; COLOR: #000000
}
</STYLE>

<META 

</HEAD>
<BODY text=#000000 bgColor=#ffffff background="" topMargin=0 rightMargin=0>
<TABLE cellSpacing=0 cellPadding=0 width=599 border=0>
  <TBODY>
    <TR>
      <TD width="6" class=cp>&nbsp;</TD>
      <TD width="198" class=cp> <DIV align=left><?php echo $usuario ?><br>
          <? echo $clLogra.$clRua ?>, <? echo $clNum ?> <BR>
          <?  echo $clComplemento !=""? "Comp.:". $clComplemento ."<br>":""; ?>
          Bairro <? echo $clBairro ?> <br>
          Cidade: <? echo $clCidade ?> - <? echo $clEstado ?><BR>
          CEP: <? echo $clCEP ?> </DIV></TD>
      <TD vAlign=bottom width=1> </TD>
      <TD class=ld vAlign=bottom align=right width=391><SPAN 
      class=ld> </SPAN></TD>
    </TR>
    <TR> 
      <TD height="2" colSpan=4></TD>
      <td width="3"></TD>
    </TR>
  </TBODY>
</TABLE>
</BODY></HTML>
