<script type="text/JavaScript" language="JavaScript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_radio(field_name, message) {
  var isChecked = false;
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var radio = form.elements[field_name];

    for (var i=0; i<radio.length; i++) {
      if (radio[i].checked == true) {
        isChecked = true;
        break;
      }
    }

    if (isChecked == false) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_input(field_name, field_size, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == '' || field_value.length < field_size) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_select(field_name, field_default, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == field_default) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_form13(form_name) {
	if (submitted == true) {
		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
		return false;
	}  
	error = false;
	form = form_name;
	error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";

	check_radio("radio_name", "Escolha um Tipo de Texto:\n\n Pal (Palavra);\n Com (Nome Composto);\n Fra (Frase);\n Par (Parágrafo);\n Num (Número).\n");
	check_input("text", 1, "Digite um texto completo para Inserir ou parte dele para Selecionar\n");
	check_radio("verbal", "Escolha Oral ou Escrito\n");
	check_select("layertype_id", "", "Selecione o Tipo de Objeto");
	
	if (error == true) {
		alert(error_message);
		return false;
	}else{
		submitted = true;
		return true;
	}
}

function check_form2(form_name) {
	if (submitted == true) {
		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
		return false;
	}  
	error = false;
	form = form_name;
	error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";

	check_radio("radio_name", "Escolha um Tipo:\n Img (Imagem);\n Mov (Filme);\n Msc (Música);\n Snd (Som)");
	check_input("name", 3, "Digite uma palavra completa");

	if (error == true) {
		alert(error_message);
		return false;
	}else{
		submitted = true;
		return true;
	}
}

function check_form4(form_name) {
	if (submitted == true) {
		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
		return false;
	}  
	error = false;
	form = form_name;
	error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";

	if (error == true) {
		alert(error_message);
		return false;
	}else{
		submitted = true;
		return true;
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function reloadPage(){  
   javascript:location.reload();
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

var MouseDownX, MouseDownY, PrevContainerX, PrevContainerY, PrevContainerW, PrevContainerH;
var MouseIsDown = false;

function LayerEvents(e, id) {
	switch(e.type) {
		case 'mousemove':
			if(e.ctrlKey && MouseIsDown) {
				w = PXValue(document.getElementById(id).style.width);
				h = PXValue(document.getElementById(id).style.height);
				document.getElementById(id).style.width = PrevContainerW+((e.clientX-PrevContainerX)-(MouseDownX-PrevContainerX))+'px';
				document.getElementById(id).style.height =  PrevContainerH+((e.clientY-PrevContainerY)-(MouseDownY-PrevContainerY))+'px';
			} else if(MouseIsDown) {
				document.getElementById(id).style.left = e.clientX-(MouseDownX-PrevContainerX)+'px';
				document.getElementById(id).style.top = e.clientY-(MouseDownY-PrevContainerY)+'px';
			}
			break;
		case 'mousedown':
			MouseIsDown = true;
			MouseDownX = e.clientX;
			MouseDownY = e.clientY;
			PrevContainerX = PXValue(document.getElementById(id).style.left);
			PrevContainerY = PXValue(document.getElementById(id).style.top);
			PrevContainerW = PXValue(document.getElementById(id).style.width);
			PrevContainerH = PXValue(document.getElementById(id).style.height);
			break;
		case 'mouseup':
			MouseIsDown = false;
	}
	window.write(document.getElementById(id).style.top); 
}
function PXValue(s) {
	return parseInt(s.replace('px',''));
}

function filtra13(cod) {
  document.forms["form13"].filtragem.value = cod;
}

function filtra2(cod) {
  document.forms["form2"].filtragem.value = cod;
}

function filtra4(cod) {
  document.forms["form4"].filtragem.value = cod;
}

function filtra5(cod) {
  document.forms["form5"].filtragem.value = cod;
}

function up(lstr){ // converte minusculas em maiusculas
var str=lstr.value; //obtem o valor
lstr.value=str.toUpperCase(); //converte as strings e retorna ao campo
}

function upperMe() {
  var field = document.forms["form123"].converter
  var upperCaseVersion = field.value.toUpperCase()
  field.value = upperCaseVersion
}
//-->
</script>