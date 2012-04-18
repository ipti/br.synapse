<?
session_start();
    
       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       require("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
       
    
       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       require("includes/funcoes.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

	
	setlocale(LC_MONETARY, 'pt_br');
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
    <TD class=cp width=147>
      <DIV align=left><IMG height=10
      width=130 border="0"></DIV></TD>
    <TD vAlign=bottom width=1> </TD>
    <TD class=cpt vAlign=bottom width=56>
      <DIV align=center><FONT class=bc></FONT></DIV></TD>
    <TD vAlign=bottom width=1> </TD>
    <TD class=ld vAlign=bottom align=right width=391><SPAN 
      class=ld>
  </SPAN></TD></TR>
  <TR>
    <TD colSpan=5></TD> <td width="3"></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
  
    <TR> 
      <TD class=ct vAlign=top width=7 height=4></TD>
      <TD class=ct vAlign=top width=472 height=4></TD>
      <TD class=ct vAlign=top width=7 height=4></TD>
      <TD class=ct vAlign=top width=113 height=4></TD>
    </TR>
  
    <TR> 
      <TD class=cp vAlign=top width=7 height=12> </TD>
      <TD class=cp vAlign=top width=472 height=12></TD>
      <TD class=cp vAlign=top width=7 height=12> </TD>
      <TD class=cp vAlign=top align=center width=113 height=12><? echo $peDataVcto; ?>
      </TD>
    </TR>
    <TR> 
      <TD vAlign=top width=7 height=1></TD>
      <TD vAlign=top width=472 height=1></TD>
      <TD vAlign=top width=7 height=1></TD>
      <TD vAlign=top width=113 height=1></TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
    <TR> 
      <TD class=ct vAlign=top width=7 height=13></TD>
      <TD class=ct vAlign=top width=472 height=13></TD>
      <TD class=ct vAlign=top width=7 height=13></TD>
      <TD class=ct vAlign=center width=113 height=13>&nbsp;</TD>
    </TR>
    <TR> 
      <TD class=cp vAlign=top height=12></TD>
      <TD class=cp vAlign=top height=12></TD>
      <TD class=cp vAlign=top height=12></TD>
      <TD class=cp vAlign=top align=right height=12></TD>
    </TR>
    <TR> 
      <TD class=cp vAlign=top width=7 height=12> </TD>
      <TD class=cp vAlign=top width=472 height=12></TD>
      <TD class=cp vAlign=top width=7 height=12> </TD>
      <TD class=cp vAlign=top align=right width=113 height=12> </TD>
    </TR>
    <TR> 
      <TD vAlign=top width=7 height=1></TD>
      <TD vAlign=top width=472 height=1></TD>
      <TD vAlign=top width=7 height=1></TD>
      <TD vAlign=top width=113 height=1></TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
  <TR>
    <TD class=ct vAlign=top width=7 height=13></TD>
      <TD class=ct vAlign=top width=113 height=13></TD>
    <TD class=ct vAlign=top width=7 height=13></TD>
      <TD class=ct vAlign=top width=163 height=13></TD>
    <TD class=ct vAlign=top width=7 height=13></TD>
    <TD class=ct vAlign=top width=62 height=13></TD>
    <TD class=ct vAlign=top width=7 height=13></TD>
    <TD class=ct vAlign=top width=34 height=13></TD>
    <TD class=ct vAlign=top width=7 height=13></TD>
    <TD class=ct vAlign=top width=72 height=13></TD>
    <TD class=ct vAlign=top width=7 height=13></TD>
    <TD class=ct vAlign=top width=114 height=13></TD></TR>
  <TR>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=113 height=12>
      <DIV align=left><? echo date("d/m/Y"); ?></DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=163 height=12></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=62 height=12>
      <DIV align=left></DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=34 height=12>
      <DIV align=left></DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=72 height=12>
      <DIV align=left><? echo date("d/m/Y", cvdate($peDataPedido)); ?></DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top align=right width=114 height=12> 
  </TD></TR>
  <TR>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=113 height=1></TD>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=163 height=1></TD>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=62 height=1></TD>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=34 height=1></TD>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=72 height=1></TD>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=114 height=1></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
  <TR>
    <TD class=ct vAlign=top width=7 height=10></TD>
    <TD class=ct vAlign=top colSpan=3 height=10> </TD>
    <TD class=ct vAlign=top width=7 height=10></TD>
    <TD class=ct vAlign=top width=83 height=10></TD>
    <TD class=ct vAlign=top width=7 height=10></TD>
    <TD class=ct vAlign=top width=53 height=10></TD>
    <TD class=ct vAlign=top width=7 height=10></TD>
    <TD class=ct vAlign=top width=123 height=10></TD>
    <TD class=ct vAlign=top width=7 height=10></TD>
    <TD class=ct vAlign=top width=140 height=10></TD>
    <TD class=ct vAlign=top width=7 height=10></TD>
    <TD class=ct vAlign=top width=114 height=10></TD></TR>
  <TR>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top colSpan=3 height=12>
      <DIV align=left></DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=83>
      <DIV align=left></DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=53>
      <DIV align=left> </DIV></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top width=123></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top  align=center width=140><? echo  number_format($peTotal, 2, ',', '.');?></TD>
    <TD class=cp vAlign=top width=7 height=12> </TD>
    <TD class=cp vAlign=top align=right width=114 height=12><? echo  number_format($peTotal, 2, ',', '.');?></TD></TR>
  <TR>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=31 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=83 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=53 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=123 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=140 height=2></TD>
    <TD vAlign=top width=7 height=2></TD>
    <TD vAlign=top width=114 height=2></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=601 border=0>
  <TBODY>
    <TR> 
      <TD align=right width=10> <TABLE cellSpacing=0 cellPadding=0 align=left border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
      <TD vAlign=top width=468 rowSpan=5><BR> <SPAN class=cp>
      <?
        $SQL = "SELECT * FROM order_detail WHERE activity_order=".$peCod."  AND quantity>0;";
		$res = pg_query($SQL);
		$tq=0;
		$tt=0;
	    while($linha = pg_fetch_array($res)){
  		    $SQL = "SELECT goal.name_varchar, activity.value 
						FROM activity 
								LEFT JOIN goal ON goal.id = activity.goal_id
						WHERE activity.id=".$linha[2];
			$res2 = pg_query($SQL);
			$linha2 = pg_fetch_array($res2);
			$tt = ($linha[3] * $linha2['values']) + $tt;
			$tq = $linha[3] + $tq;
			echo  $linha[3] . ' X ' . $linha2['name_varchar'] . ' = ' . number_format($linha['quantity'] * $linha2['value'], 2, ',', '.').  '<br>';
		}
		$tt = number_format($tt, 2, ',', '.');
      ?>
        </SPAN></TD>
      <TD align=right width=188> <TABLE cellSpacing=0 cellPadding=0 border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
              <TD class=ct vAlign=top width=180 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
              <TD class=cp vAlign=top align=right width=180 height=12></TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
              <TD vAlign=top width=180 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
    </TR>
    <TR> 
      <TD align=right width=10> <TABLE cellSpacing=0 cellPadding=0 align=left border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1><IMG height=1 
            src="boleto_arquivos/2.gif" width=1 border=0></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
      <TD align=right width=188> <TABLE cellSpacing=0 cellPadding=0 border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
              <TD class=ct vAlign=top width=180 height=13> </TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
              <TD class=cp vAlign=top align=right width=180 height=12></TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
              <TD vAlign=top width=180 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
    </TR>
    <TR> 
      <TD align=right width=10> <TABLE cellSpacing=0 cellPadding=0 align=left border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
      <TD align=right width=188> <TABLE cellSpacing=0 cellPadding=0 border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
              <TD class=ct vAlign=top width=180 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
              <TD class=cp vAlign=top align=right width=180 height=12></TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
              <TD vAlign=top width=180 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
    </TR>
    <TR> 
      <TD align=right width=10> <TABLE cellSpacing=0 cellPadding=0 align=left border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
      <TD align=right width=188> <TABLE cellSpacing=0 cellPadding=0 border=0>
          <TBODY>
            <TR> 
              <TD class=ct vAlign=top width=7 height=13></TD>
              <TD class=ct vAlign=top width=180 height=13></TD>
            </TR>
            <TR> 
              <TD class=cp vAlign=top width=7 height=12> </TD>
              <TD class=cp vAlign=top align=right width=180 height=12></TD>
            </TR>
            <TR> 
              <TD vAlign=top width=7 height=1></TD>
              <TD vAlign=top width=180 height=1></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
    </TR>
    <TR> 
      <TD width=10 height="20" align=right>&nbsp; </TD>
      <TD align=right width=188>&nbsp;</TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE width="601" border=0 cellPadding=0 cellSpacing=0>
  <TBODY>
  <TR>
    <TD class=ct vAlign=top width=5 height=13></TD>
      <TD class=ct vAlign=top width=360 height=13> </TD>
    </TR>
  <TR>
    <TD class=cp vAlign=top width=5 height=12> </TD>
    <TD class=cp vAlign=top width=360 height=12><? echo $usuario;  ?> 
  </TD>
    </TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
  <TR>
    <TD class=cp vAlign=top width=7 height=12> </TD>
      <TD class=cp vAlign=top width=594 height=12>Rua. <? echo  $clRua; ?> - <?  echo $clCEP;?> </TD>
    </TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
  <TR>
    <TD class=ct vAlign=top width=7 height=13></TD>
    <TD class=cp vAlign=top width=472 height=13></TD>
    <TD class=ct vAlign=top width=7 height=13></TD>
    <TD class=ct vAlign=top width=114 height=13></TD></TR>
  <TR>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=472 height=1></TD>
    <TD vAlign=top width=7 height=1></TD>
    <TD vAlign=top width=114 height=1></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=600 border=0>
  <TBODY>
  <TR>
    <TD class=ct width=7 height=12></TD>
    <TD class=ct width=409></TD>
    <TD class=ct width=184>
      <DIV align=right><B class=cp></B></DIV></TD></TR>
  <TR>
    <TD class=ct colSpan=3></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=600 border=0>
  <TBODY>
  <TR>
    <TD width="600" height=50 align=left vAlign=bottom> </TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=600 border=0>
  <TBODY>
  <TR>
    <TD class=ct width=600></TD></TR>
  <TBODY>
  <TR>
    <TD class=ct width=600>
      <DIV align=right></DIV></TD></TR>
  <TR>
    <TD class=ct width=600></TD></TR></TBODY></TABLE></BODY></HTML>
