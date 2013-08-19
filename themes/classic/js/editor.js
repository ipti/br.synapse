TYPE = {}
TYPE.ELEMENT = {}
TYPE.ELEMENT.TEXT = "TEXT";
TYPE.ELEMENT.MULTIMIDIA = "MULTIMIDIA";
TYPE.LIBRARY = {}
TYPE.LIBRARY.IMAGE = "IMAGE";
TYPE.LIBRARY.SOUND = "SOUND";
TYPE.LIBRARY.MOVIE = "MOVIE";

function editor () { 
    this.COtypeID;
    this.COthemeID;
    this.COtemplateType;
    this.CObjectID;
    this.COgoalID;
    this.currentScreenId = 'sc0';
    this.lastScreenId;
    this.countScreen = 0;
    this.countPieceSet = new Array();
    this.countPieces = new Array();
    this.countElements = new Array();
    this.currentPieceSet = 'sc0_ps0';
    this.currentPiece = 'sc0_ps0_p0';
    this.uploadedElements = 0;
    this.uploadedLibraryIDs = new Array();
    this.isload = false;
    this.TXT = new Array(2);
    this.MTE = new Array(3,4,5,6);
    this.PRE = new Array(7,8,9,10,11,12);
    this.AEL = new Array(13,14,15);
    
    this.COTemplateTypeIn = function(array){
        return array.indexOf(this.COtemplateType) != -1
    }
    
    this.changePiece = function(piece){
        $('.piece').removeClass('active');
        var id = piece.attr('id');
        piece.addClass('active');
        this.currentPiece = id;
    }
    
    this.addScreen = function(id){
        //variável para adição do ID do banco, se ele não existir ficará vazio.
        var plus = "";
        //se estiver setado o novo id
        if(this.isset(id)){
            //adiciona o código na varíavel
            plus = ' idBD="'+id+'" ';
        }
        //incrementa o contador
        this.countScreen = this.countScreen+1;
        //cria a div da nova screen, e adiciona o ID do banco, caso exista.
        $(".content").append('<div class="screen" id="sc'+this.countScreen+'" '+plus+'></div>');
        //cria o novo contador de pieceSet
        this.countPieceSet['sc'+this.countScreen] = 0;
        //atualiza o pajinate
        this.attPajinate();
    }
    
    this.attPajinate = function(){
        //pega o valor da quantidade de páginas
        var lastScreen = $('.screen').size()-1;
        
        //recria o pajinate passando o start_page como a ultima tela.
        $('.canvas').pajinate({
            start_page : lastScreen,
            items_per_page : 1,
            nav_label_first : '<<',
            nav_label_last : '>>',
            nav_label_prev : '<',
            nav_label_next : '>',
            show_first_last : false,
            num_page_links_to_display: 20,
            nav_panel_id : '.navscreen',
            editor : this
        });
    }
    
    this.addPieceSet = function(id, desc, type){
        //variável para adição do ID do banco, se ele não existir ficará vazio.
        var plus = "";
        //variável para adição de descrição vinda do banco.
        var plusdesc = "";
        //variável para adição de tipo vindo do banco.
        var plustype = "";
        
        //se estiverem setadas as informações do banco
        if(this.isset(id) && this.isset(desc) && this.isset(type)){
            //adiciona o código na varíavel
            plus = ' idBD="'+id+'" ';
            plusdesc = desc;
            plustype = type;
        }
        
        var parent = this;
        var piecesetID = this.currentScreenId+'_ps'+this.countPieceSet[this.currentScreenId];
        this.countPieces[piecesetID] = 0;
        $('#'+this.currentScreenId).append(''+
            '<div class="PieceSet" id="'+piecesetID+'_list" '+plus+'>'+
            '<button class="insertImage">'+LABEL_ADD_IMAGE+'</button>'+
            '<button class="insertSound">'+LABEL_ADD_SOUND+'</button>'+
            '<button class="addPiece" id="pie_'+piecesetID+'">'+LABEL_ADD_PIECE+'</button>'+
            '<button class="del delPieceSet">'+LABEL_REMOVE_PIECESET+'</button>'+
            '<input type="text" class="actName" value="'+plusdesc+'" />'+
            '<div id="'+piecesetID+'_forms"></div>'+
            '<ul class="piecelist" id="'+piecesetID+'"></ul>'+
            '<span class="clear"></span>'+
            '</div>');

        this.countPieceSet[this.currentScreenId] =  this.countPieceSet[this.currentScreenId]+1;          

        $("#"+piecesetID+"_list > button.insertImage").click(function(){
            if (!parent.existID('#'+piecesetID+"_forms_image_form"))
                parent.addImage(piecesetID+"_forms");
        });
        $("#"+piecesetID+"_list > button.insertSound").click(function(){
            if (!parent.existID('#'+piecesetID+"_forms_audio_form"))
                parent.addSound(piecesetID+"_forms");
        });
        $("#"+piecesetID+"_list > button.delPieceSet").click(function(){
            parent.delPieceSet(piecesetID);
        });

    }
    
    this.addPiece = function(id, idbd){
        var parent = this;
        
        //variável para adição do ID do banco, se ele não existir ficará vazio.
        var plus = "";
        //se estiver setado o novo id
        if(this.isset(idbd)){
            //adiciona o código na varíavel
            plus = ' idBD="'+idbd+'" ';
        }
        
        var PieceSetid = id.replace("pie_", "");
        this.currentPieceSet = PieceSetid;
        
        //Monta o id do Piece
        var pieceID = this.currentPieceSet+'_p'+this.countPieces[this.currentPieceSet];
        //Adiciona na array de contadores
        this.countElements[pieceID] = 0;
        //inicia o html do piece
        var html = ''+
            '<li id="'+pieceID+'" class="piece" '+plus+'>'+
            '<button class="del delPiece">'+LABEL_REMOVE_PIECE+'</button>';
        //Se o Template for MTE
        if(parent.COTemplateTypeIn(parent.MTE) ){
            html += '<div class="tplMulti"><button class="newElement">'+LABEL_ADD_ELEMENT+'</button><br></div>';
        //Se o template for PRE
        }else if(parent.COTemplateTypeIn(parent.PRE)){
            html+= '<div class="tplMulti"></div>';
        }else if(parent.COTemplateTypeIn(parent.AEL)){
            html += '<div class="tplMulti"><button class="newElement">'+LABEL_ADD_ELEMENT+'</button><br></div>'+
                "<ul id='"+pieceID+"_query' class='sortable'></ul>"+
                "<ul id='"+pieceID+"_query_resp' class='sortable'></ul>";
        }
        //finaliza o html
        html+= '</li>';
        //appenda o html do piece no pieceset
        $('#'+PieceSetid).append(html);
        
        //incrementa o contador de piece
        this.countPieces[this.currentPieceSet] =  this.countPieces[this.currentPieceSet]+1;
        
        //se template for MTE
        if(parent.COTemplateTypeIn(parent.MTE)
            || parent.COTemplateTypeIn(parent.AEL)){
            //adiciona a função do botão addElement
            $("#"+pieceID+"> div > button.newElement").click(function(){
                parent.addElement();
            });
            if(parent.COTemplateTypeIn(parent.AEL)){
                //$('#'+pieceID+'_query').sortable();
                //$('#'+pieceID+'_query').disableSelection();
                //$('#'+pieceID+'_query_resp').sortable();
                //$('#'+pieceID+'_query_resp').disableSelection();
                
            }
        //se template for PRE
        }else if(parent.COTemplateTypeIn(parent.PRE)){
            //altera a seleção de piece
            parent.changePiece($('#'+pieceID));
            //adiciona um elemento neste piece
            parent.addElement();
        }
        
        //adiciona a função do botão delPiece
        $("#"+pieceID+"> button.delPiece").click(function(){
            parent.delPiece(pieceID);
        });
    }
    
    this.addText = function(ID, loaddata){       
        //variável para adição do texto se ele não existir ficará com a constante LABEL_INITIAL_TEXT. 
        var initial_text = this.isset(loaddata) ? loaddata['text'] : LABEL_INITIAL_TEXT;
        
        var parent = this;
        
        var html = '<div id="'+ID+'_text" class="text">'+
            '<font class="editable" id="'+ID+'_flag">'+initial_text+'</font>';
        if(parent.COTemplateTypeIn(parent.MTE)){
            html += '<button class="del delText">'+LABEL_REMOVE_TEXT+'</button>';
        } else if(parent.COTemplateTypeIn(parent.PRE)){
            html += '';
        } 
        
        html += '</div>';
        
        $('#'+ID).append(html);
             
        var text = "#"+ID+"_text";
        var editable = text+" > font.editable";
        
        $(text+" > button.delText").click(function(){
            parent.delObject(ID+"_text");
        });
        
        $(editable).editable(function(value, settings) { 
            //console.log(this);
            //console.log(value);
            //console.log(settings);
            return(value);
        },{ //save function(or page)
            submitdata  : {
                op: "save"
            },     //$_POST['op'] on save
            id      : "elementID",          //$_POST['elementID'] on save
            name    : "newValue",           //$_POST['newValue'] on save
            type    : "text",               //input type ex: text, textarea, select
            submit  : "Update",
            cancel  : "Calcel",
            //loadurl : "/editor/json",       //load function(or page), json
            loadtype: "POST",                 //Load method
            loaddata: {
                op: "load"
            },         //$_POST['op'] on load
            indicator : 'Saving...',        //HTML witch indicates the save process ex: <img src="img/indicator.gif">
            tooltip   : initial_text
        });        
        
        //Quando clicar no editable
        $(editable).on('click',function(){ 
            var form = editable+" > form";
            var input = form+" > input";
            var submit = form+" > button[type=submit]";

            //adiciona a função de foco ao input
            $(input).on("focus",function(){
                //se o valor for igual ao initial_text
                if($(input).val() == initial_text){
                    //remove o texto
                    $(input).val("");
                }
            });
            //adiciona a função de perda de fodo do input
            $(input).on("focusout",function(){
                //se não houver textoo
                if($(input).val() == ""){
                    //adiciona o texto initial_text
                    $(input).val(initial_text);
                    //da submit no formulário
                    $(form).submit();
                }
            });
            //seta o foco no input
            $(input).focus();
        });
        
    }
    
    this.addUploadForm = function(ID, type, responseFunction, loaddata){
        
        var parent = this; 
        
        //variável para adição do ID do banco, se ele não existir ficará vazio.
        var libBDID = "";
        
        //se estiver setado o novo id
        if(this.isset(loaddata) && this.isset(loaddata['library'])){
            //adiciona o código na varíavel
            libBDID = ' idBD="'+loaddata['library']['ID']+'" ';
        }
        
        
        //Default Image
        var uploadType = (type['type']?type['type']:'image'); 
        var uploadAccept = Array();
        uploadAccept = (type['accept']? type['accept']:'*');
        var uploadMaxSize = (type['maxsize']?type['maxsize']: 1024 * 5); 
        //var uploadMaxWidth = (type['maxwidth']?type['maxwidth']: 800); 
        //var uploadMaxHeight = (type['maxheight']?type['maxheight']: 600); 
        
        var accept = '';

        $.each(uploadAccept,function( key, value  ) {
            accept += uploadType+'/'+value+', ';
        });
        
        var file    = ID+"_"+uploadType;
        var form    = file+"_form";
        var input   = file+"_input";
        
        var identify_isload = '';
        if( parent.isset(parent.isload) ) {
             identify_isload =  '<input type="hidden" name="isload" value="'+parent.isload+'"/>' ;
        }
           
       var html = '<div id="'+file+'" '+libBDID+' class="'+uploadType+'">';
       if(parent.COTemplateTypeIn(parent.MTE)){
           html += '<button class="del delObject">'+LABEL_REMOVE_OBJECT+'</button>';
       }     
       else {
           html +="";
       }
       html += '<form enctype="multipart/form-data" id="'+form+'" method="post" action="/Editor/upload">'+
            '<input type="hidden" name="op" value="'+uploadType+'"/>'+
             identify_isload +
            '<label>'+uploadType+': '+
            '<input id="'+input+'" type="file" id="'+uploadType+'" name="file" value="" accept="'+accept+'" />'+
            '</label>'+
            '</form>'+
            '</div>';
        
        $('#'+ID).append(html);
        
        if(this.isset(loaddata) && this.isset(loaddata['library'])){
            var src = '/rsc/upload/'+uploadType+'/'+loaddata['library']['src'];
            responseFunction(src, file, form); 
        }
        
        var parent = this;
        
        $("#"+file+"> button.delObject").click(function(){
            parent.delObject(file);
        });
        
        $("#"+input).bind('change', function() {
            var filesize = this.files[0].size / 1024; //KB
            filesize = filesize / 1024; //MB
            filesize = Math.round(filesize * 1000) / 1000; //3 decimal
            
            if(filesize <= uploadMaxSize){
                if(!(this.files[0].type.indexOf(uploadType) == -1)){ 
                    
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        responseFunction(e.target.result, file, form);
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }else{
                    alert(ERROR_INCOMPATIBLE_TYPE);
                }
            }else{
                alert(ERROR_FILE_SIZE +uploadMaxSize+'MB');
            }
            
        });
    }
    
    this.addImage = function(id, loaddata){
        this.addUploadForm(id, {
            type: 'image',
            accept: Array("png","gif","bmp","jpeg","jsc","ico"),
            maxsize: (1024 * 5) //5MB
        //função onChange
        },function(src, fileid, formid){
            $("#"+fileid+" > img").remove("img");
            $("#"+fileid).append('<img  src="'+src+'" width="320" height="240" alt="Image"/>');
        },loaddata);
    }
    
    this.addSound = function(id, loaddata){
        var parent = this;
        this.addUploadForm(id, {
            type: 'audio',
            accept: Array("mp3","wav","ogg"),
            maxsize: (1024 * 10) //10MB
        }, function(src, fileid, formid){
            $("#"+fileid+" > audio").remove("audio");
            $("#"+fileid).append(''+
                '<audio src="'+src+'" controls="controls">'+
                ERROR_BROWSER_SUPORT+
                '</audio>');
        },loaddata);
    }
    
    this.addVideo = function(id, loaddata){
        var parent = this;
        this.addUploadForm(id, {
            type: 'video',
            accept: Array("mp4","wmv","ogg"),
            maxsize: (1024 * 20) //10MB
        }, function(src, fileid, formid){
            $("#"+fileid+" > video").remove("video");
            $("#"+fileid).append(''+
                '<video src="'+src+'" width="320" height="240" controls="controls">'+
                ERROR_BROWSER_SUPORT+
                '</video>');
        },loaddata);
    }
    
    this.addElement = function(idbd, type, loaddata){
        var parent = this;
            
        //variável para adição do ID do banco, se ele não existir ficará vazio.
        var plus = "";
        //se estiver setado o novo id
        if(this.isset(idbd)){
            //adiciona o código na varíavel
            plus = ' idBD="'+idbd+'" ';
        }
        
        var elementID = this.currentPiece+'_e'+this.countElements[this.currentPiece]; 
        
        var html = '<span id="'+elementID+'" '+plus+' class="element moptions">';
        if(parent.COTemplateTypeIn(parent.MTE)){
            html += ''+
            '<div>'+
            '<button class="insertImage">'+LABEL_ADD_IMAGE+'</button>'+
            '<button class="insertText">'+LABEL_ADD_TEXT+'</button>'+
            '<button class="del delElement">'+LABEL_REMOVE_ELEMENT+'</button>'+
            '<br>'+
            '<br>'+
            '<br>'+
            '<label>'+
            '<input type="checkbox" id="'+elementID+'_flag" name="'+elementID+'_flag" value="Correct"/>'+LABEL_CORRECT+
            '</label>'+
            '</div>';
        }else if(parent.COTemplateTypeIn(parent.PRE)){
            html += '<label>'+LABEL_CORRECT+' </label>';
        }else if(parent.COTemplateTypeIn(parent.AEL)){
            var group = $("#"+parent.currentPiece+"_query > .element").length+1;
            html = '<li id="'+elementID+'" '+plus+' class="element moptions" match="'+group+'">'+
            '<div>'+
            '<spam>('+group+')</spam>'+
            '<button class="insertImage" group="'+group+'">'+LABEL_ADD_IMAGE+'</button>'+
            '<button class="insertText" group="'+group+'">'+LABEL_ADD_TEXT+'</button>'+
            '</div>'+
            '</li>';
            var html2 = '<li id="'+elementID+'_resp" class="element" match="'+group+'">'+
            '<div>'+
            '<spam>('+group+')</spam>'+
            '<button class="insertText">'+LABEL_ADD_TEXT+'</button>'+
            '</div>'+
            '</li>';
            $("#"+parent.currentPiece+"_query").append(html);
            $("#"+parent.currentPiece+"_query_resp").append(html2);
            
        }
    
        if(!(parent.COTemplateTypeIn(parent.AEL))){
            html += '</span>';
            $('#'+parent.currentPiece+" > div.tplMulti").append(html);
        }
        
        if(this.isset(loaddata)){
            switch(type){
                case '11'://text
                case '12'://word
                case '13'://paragraph
                case '18'://morphem
                case '19'://number
                    this.addText(elementID, loaddata);
                    break;
                case '16'://Library
                    switch(loaddata['library']['type']){
                        case '9'://image
                            this.addImage(elementID, loaddata);
                            break;
                        case '17'://video
                            this.addVideo(elementID, loaddata);
                            break;
                        case '20'://sound
                            this.addSound(elementID, loaddata);
                            break;
                    }
                    break;
                default:
                    //console.log(elementID+' '+type+' '+loaddata);
            }
        }
        this.countElements[this.currentPiece] =  this.countElements[this.currentPiece]+1;
        
        
        if(parent.COTemplateTypeIn(parent.MTE)
            || parent.COTemplateTypeIn(parent.AEL)){
            if(parent.COTemplateTypeIn(parent.AEL)){
                var buttonTextoRespID = "#"+elementID+ (parent.COTemplateTypeIn(parent.AEL) ? "_resp" : "") + "> div > button.insertText";
                //if(parent.COTemplateTypeIn(parent.AEL))
                //    buttonTextoRespID = "#"+elementID+"_resp > div > button.insertText";
                //else
                //    buttonTextoRespID = "#"+elementID+" > div > button.insertText";
                $(buttonTextoRespID).click(function(){
                    parent.addText(elementID+"_resp");
                    $(buttonTextoRespID).remove();
                });
            }
            var buttonTextoID = "#"+elementID+"> div > button.insertText";
            var buttonImageID = "#"+elementID+" > div > button.insertImage";
            
            var buttonDelID = "#"+elementID+" > div > button.delElement";
            var textoID = "#"+elementID+"_text";
            var imageID = "#"+elementID+"_image";

            var ElementTextID = "#"+elementID+"_text";
            var ElementImageID = "#"+elementID+"_image";

            $(buttonTextoID).click(function(){
                if(parent.COTemplateTypeIn(parent.AEL)){
                    parent.addText(elementID);
                    $(buttonTextoID).remove();
                }
                else if(!parent.existID(ElementImageID) || 
                    confirm(MSG_CHANGE_ELEMENT)){
                    if(!parent.existID(ElementTextID)){
                        parent.addText(elementID);
                        $(imageID).remove();
                    }
                }
            });
            $(buttonImageID).click(function(){
                if(parent.COTemplateTypeIn(parent.AEL)){
                    parent.addImage(elementID);
                    $(buttonImageID).remove();
                }
                else if(!parent.existID(ElementTextID) ||
                    confirm(MSG_CHANGE_ELEMENT)){
                    if(!parent.existID(ElementImageID)){
                        parent.addImage(elementID);
                        $(textoID).remove();
                    }
                }
            });
            $(buttonDelID).click(function(){
                parent.delElement(elementID);
            });
        }else if(parent.COTemplateTypeIn(parent.PRE)){
            parent.addText(elementID);
        }
    }
    
    this.delScreen = function(force){
        //pega o id da screen atual
        var id = this.currentScreenId;
        //confirmação do ato de remover
        if(force || confirm(MSG_REMOVE_SCREEN)){
            //remove o elemento
            $("#"+id).remove();
            //deleta o count do pieceset
            delete this.countPieceSet[id];
            //atualiza o pajinate
            this.attPajinate();
        }
    }

    this.delPieceSet = function(id){
        if(confirm(MSG_REMOVE_PIECESET)){
            $("#"+id+"_list").remove();
            delete this.countPieces[id];
        }
    }

    this.delPiece = function(id){
        if(confirm(MSG_REMOVE_PIECE)){
            $("#"+id).remove();
            delete this.countElements[id];
        }
    }
    this.delElement = function(id){
        if(confirm(MSG_REMOVE_ELEMENT)){
            $("#"+id).remove();
        }
    }
    
    this.delObject = function(id){
        if(confirm(MSG_REMOVE_OBJECT)){
            $("#"+id).remove();
        }
    }
   
    this.saveData = function(data, sucess, beforeSend){
        $.ajax({
            type: "POST",
            url: "/Editor/Json",
            dataType: 'json',
            data: data,
            beforeSend: function(jqXHR, settings ){
                if(beforeSend){
                    beforeSend(jqXHR, settings);
                }
                else{
                    $('.savescreen').append('<br><p>Salvando '+data['step']+'...</p>');
                }    
            },
            error: function( jqXHR, textStatus, errorThrown ){
                $('.savescreen').append('<br><p>Erro ao salvar '+data['step']+'.</p>');
                $('.savescreen').append('<br><p>Error mensage:</p>');
                $('.savescreen').append(jqXHR.responseText);
            },
            success: function(response, textStatus, jqXHR){
                sucess(response, textStatus, jqXHR);
            }
        });
    }
   
    //Função de salvamento.
    //salva utilizando Ajax, parte por parte.
    this.saveAll = function(){
        //       1-> save cobject 
        //            templateID
        //            typeID
        //            themeID
        //            typeID
        //            value
        //       2-> each screen{
        //              save Screen
        //              each PieceSet{
        //                  save PieceSet
        //                  each Piece{
        //                      save Piece
        //                      each element{
        //                          Save element
        //                          if element txt{
        //                             save proprety
        //                          }
        //                          else if element img{
        //                             upload
        //                             save proprety
        //                          }
        //                      }
        //                  }
        //              }
        //          }
        //       
        //       
        
        //referência à classe
        var parent = this;
        
        //ID no DOM do elemento para o Each
        var ScreenID;
        var PieceSetID;
        var PieceID;
        var ElementID;
        
        //contadores de posição/ordem
        var screenPosition;
        var pieceSetPosition;
        var piecePosition;
        var elementPosition;
        
        //ID do ultimo Salvo no banco
        var LastScreenID;
        var LastPieceSetID;
        var LastPieceID;
        
        //ID no DOM do elemento atual
        //necessário para "sincronizar" o ajax com o javascript
        var curretScreenID;
        var curretPieceSetID;
        var curretPieceID;
        
        //Dados em geral dos elementos
        var pieceSetDescription;
        var Flag;
        
        //inicializa contador
        this.uploadedImages = 0;
        this.uploadedLibraryIDs = new Array();
        
        //cria tela de log
        $('.theme').append('<div style="left: 0px; width: 100%; height: 100%; position: fixed; top: 0px; background: none repeat scroll 0px 0px black; opacity: 0.8;" class="savebg"></div>');
        $('.theme').append('<div style="background: none repeat scroll 0px 0px white; height: 300px; border-radius: 5px 5px 5px 5px; width: 800px; margin-top: 100px; margin-left: 250px; position: fixed; border: 2px solid black; padding: 10px;" class="savescreen">'+
            '<p>Aguarde um instante...</p>'+
            '</div>');
        
        //Salva o CObject
        if(!parent.isload) {
            this.saveData({
                //Operação Salvar
                op: "save", 
                //Passo CObject
                step: "CObject",
                //Dados do CObject
                COtypeID: parent.COtypeID,
                COthemeID: parent.COthemeID,
                COtemplateType: parent.COtemplateType,
                COgoalID: parent.COgoalID
            }, 
            //funcção sucess do save Cobject
                function(response, textStatus, jqXHR){
                    //atualiza a tela de log
                    $('.savescreen').append('<br><p>CObject salvo com sucesso!</p>');
                    posSaveCobject(response, textStatus, jqXHR);
                } 
            );
         }else{
             // Então Existe um this.CObjectID
             posSaveCobject();
         }        
        //======================
        
        function posSaveCobject(response, textStatus, jqXHR ){
            
            //atualiza o ID do CObject, com a resposta do Ajax          
            if(!parent.isset(parent.CObjectID) )  {
               parent.CObjectID =  response['CObjectID'];
            }
            //Reinicia o contador da Ordem das Screens
            screenPosition = 0;
            
            //Para cada tela
            $('.screen').each(function(){
                //Atualiza a ScreeID com o ID do ".screen" atual
                ScreenID = $(this).attr('id');
                ScreenID_BD = $(this).attr('idBD');
                //Salva Screen
                parent.saveData({ 
                    //Operação Salvar, Screen, ID no DOM
                    op: parent.isload ? "update": "save", 
                    step: "Screen",
                    //Necessário para que o JS fique sincronizado com o Ajax
                    DomID: ScreenID,
                    //Dados da Screen
                    CObjectID: parent.CObjectID,
                    Ordem: ++screenPosition,//incrementa a Ordem da Screen
                    ID_BD: ScreenID_BD 
                },
                //função sucess do save Screen
                function(response, textStatus, jqXHR){
                    //Atualiza a tela de log
                    $('.savescreen').append('<br><p>Screen salvo com sucesso!</p>');
                    
                    //Retorna o ID no DOM e o ID da ultima Tela no Banco.
                    curretScreenID = response['DomID'];
                    LastScreenID = response['screenID'];
                    
                    //reinicia o contador de posição dos PieceSet na Screen
                    pieceSetPosition = 0;
                    
                    //Para cada PieceSet da Screen
                    $('#'+curretScreenID+' .PieceSet').each(function(){
                        PieceSetID = $(this).attr('id');
                        PieceSetID_BD = $(this).attr('idBD');
                        pieceSetDescription = $('#'+PieceSetID+' .actName' ).val();
                        //Salva PieceSet
                        parent.saveData({ 
                            //Operação Salvar, PieceSet, ID no DOM
                            op: parent.isload ? "update": "save",
                            step: "PieceSet",
                            DomID: PieceSetID,
                            //Dados do PieceSet
                            typeID: 7,
                            description: pieceSetDescription,
                            screenID: LastScreenID,
                            order: ++pieceSetPosition, //incrementa a Ordem do PieceSet
                            templateID: parent.COtemplateType,
                            isload: parent.isload,
                            ID_BD : PieceSetID_BD
                        },
                        //Função sucess do save PieceSet
                        function(response, textStatus, jqXHR){
                            $('.savescreen').append('<br><p>PieceSet salvo com sucesso!</p>');
                            curretPieceSetID = response['DomID'];
                            LastPieceSetID = response['PieceSetID'];
                            
                            //reiniciar o contador de posição da Piece no PieceSet
                            piecePosition = 0;
                            
                            //Para cada Piece do PieceSet
                            $('#'+curretPieceSetID+' .piece').each(function(){
                                PieceID = $(this).attr('id');
                                PieceID_BD = $(this).attr('idBD');
                                //Save Piece
                                parent.saveData({
                                    //Operação Salvar, Piece, ID no DOM
                                    op: parent.isload ? "update": "save", 
                                    step: "Piece",
                                    DomID: PieceID,
                                    //Dados do Piece
                                    typeID: 7,
                                    pieceSetID: LastPieceSetID,
                                    ordem: ++piecePosition, //incrementa a Ordem do Piece
                                    screenID: LastScreenID,
                                    isload: parent.isload,
                                    ID_BD : PieceID_BD 
                                },
                                //Função de sucess do Save Piece
                                function(response, textStatus, jqXHR){
                                    $('.savescreen').append('<br><p>Piece salvo com sucesso!</p>');
                                    curretPieceID = response['DomID'];
                                    LastPieceID = response['PieceID'];
                                    
                                    //inicializa o contador de posição do elemento
                                    elementPosition = 0;
                                    
                                    //Para cada Elemento no Piece
                                    $('#'+curretPieceID+' .element').each(function(){
                                        ElementID = $(this).attr('id');
                                        ElementID_BD = $(this).attr('idBD');
                                        Flag = $('#'+ElementID+'_flag').is(':checked') || (parent.COTemplateTypeIn(parent.PRE));
                                        Match = ((parent.COTemplateTypeIn(parent.AEL)) ? $(this).attr('match') : -1);
                                        
                                        //declaração das variáveis que serão passadas por ajax
                                        var type;
                                        var value;
                                        
                                        //IDs dos Formulários, textos e imagens
                                        var ElementTextID = "#"+ElementID+"_text";
                                        var ElementImageID = "#"+ElementID+"_image";
                                        var FormElementImageID = "#"+ElementID+"_image_form";
                                        
                                        //Dados que serão passados pelo ajax
                                        var data = {
                                            //Operação Salvar, Element, Type, ID no DOM
                                            op: parent.isload ? "update": "save", 
                                            step: "Element",
                                            DomID: ElementID,
                                            //Dados do Element
                                            ordem: ++elementPosition, //incrementa a Ordem do Element
                                            pieceID: LastPieceID,
                                            flag: Flag,
                                            value: {},
                                            match: Match,
                                            isload: parent.isload,
                                            ID_BD:  ElementID_BD
                                        };
                                       // HERE !!! verificar os IDS das librarys
                                        //Se for um Texto
                                        if(parent.existID(ElementTextID)){
                                            //Salva Elemento
                                            data["typeID"] = TYPE.ELEMENT.TEXT;
                                            data["value"] = $(ElementTextID+" > font").html();
                                            parent.saveData(
                                                //Variáveis dados
                                                data,
                                                //Função de sucess do Save Element
                                                function(response, textStatus, jqXHR){
                                                    $('.savescreen').append('<br><p>ElementText salvo com sucesso!</p>');
                                                    parent.uploadedElements++
                                                });
                                        
                                        //Se for uma Imagem
                                        }
                                        if(parent.existID(ElementImageID)){
                                            data["typeID"] = TYPE.ELEMENT.MULTIMIDIA;
                                            data["library"] = TYPE.LIBRARY.IMAGE;
                                            //criar a função para envio de formulário via Ajax
                                            $(FormElementImageID).ajaxForm({
                                                beforeSend: function() {
                                                //zerar barra de upload
                                                //$("#"+bar).width('0%')
                                                //$("#"+percent).html('0%');
                                                },
                                                uploadProgress: function(event, position, total, percentComplete) {
                                                //atualizar barra de upload
                                                //$("#"+bar).width(percentComplete + '%')
                                                //$("#"+percent).html(percentComplete + '%');
                                                },
                                                success: function(response) {
                                                    //dados de retorno do upload
                                                    data['value']['url'] = response['url'];
                                                    data['value']['name'] = response['name'];
                                                    
                                                    //Salva Elemento
                                                    parent.saveData(
                                                        //Dados
                                                        data,
                                                        //Função de sucess do Save Element
                                                        function(response, textStatus, jqXHR){
                                                            $('.savescreen').append('<br><p>ElementImage salvo com sucesso!</p>');
                                                            
                                                            //atualiza o contador de imagens enviadas e coloca o id numa array para ser enviada pelo posRender
                                                            parent.uploadedLibraryIDs[parent.uploadedElements++] = response["LibraryID"];
                                                            
                                                            //chama o posRender
                                                            parent.posEditor();
                                                        });
                                                },
                                                error: function(error, textStatus, errorThrown){
                                                    //$("#"+form).html(error.responseText);
                                                    alert(ERROR_FILE_UPLOAD);
                                                    $(".savescreen").append(error.responseText);
                                                }
                                            });
                                            
                                            //Envia o formulário atual
                                            $(FormElementImageID).submit();
                                            
                                        }
                                    });
                                });
                            });
                        });
                    });
                });       
            });
        }
        //======================     
    } // End Form SaveAll
    
    this.posEditor = function(){
        //quantidade de elementos.
        var qtdeImages = $('.element').size();
        if(qtdeImages == this.uploadedElements){
            var parent = this;
            
            var inputs = "";
            //cria os inputs para ser enviados por Post
            for (var i in parent.uploadedLibraryIDs){
                inputs += '<input type="hidden" name="uploadedLibraryIDs['+i+']" value="'+parent.uploadedLibraryIDs[i]+'">';
            }
            
            //cria formulário para enviar o array de library para o poseditor
            $('.savescreen').append('<form action="/Editor/poseditor" method="post">'+inputs+'<input type="submit" value="PosEditor"></form>');
            
            /*$.ajax({
                type: "POST",
                url: "/Editor/poseditor",
                dataType: 'json',
                ids: parent.uploadedLibraryIDs,                
                error: function( jqXHR, textStatus, errorThrown ){
                    $('.savescreen').append('<br><p>Erro ao inviar ids ao poseditor.</p>');
                    $('.savescreen').append('<br><p>Error mensage:</p>');
                    $('html').html(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    alert('Save complet!');
                }
            });*/
        }
        
    }
    
    this.load = function(){
        //define parent como a classe base
        var parent = this;
        //inicia a requisição de ajax
        $.ajax({
            type: "POST",
            url: "/Editor/json",
            dataType: 'json',
            data: {
                op:'load',
                cobjectID:parent.CObjectID
            },                
            error: function( jqXHR, textStatus, errorThrown ){
                $('html').html(jqXHR.responseText);
            },
            success: function(response, textStatus, jqXHR){
                //força a deleção da screen inicial
                parent.delScreen(true);
                parent.isload = true;//Identificar se esta no load.
                //para cada item do response
                $.each(response, function(i, item){
                    //caso i
                    switch(i){
                        //seja o ID do cobject
                        case 'cobjectID':
                            //altera na classe
                            parent.CObjectID = item;
                        //seja o ID do tipo
                        case 'typeID':
                            //altera na classe
                            parent.COtypeID = item;
                            break;
                        //seja o ID do tema
                        case 'themeID':
                            //altera na classe
                            parent.COthemeID = item;
                            break;
                        //seja o ID do template
                        case 'templateID':
                            //altera na classe
                            parent.COtemplateID = item;
                        //se não
                        default:
                            //se for uma screen
                            if(i.slice(0,1) == "S"){
                                //pega o id da screen a partir do indice
                                var screenID = i.slice(1);
                                //adiciona a screen
                                parent.addScreen(screenID);
                                
                                //para cada item da screen
                                $.each(item, function(i, item){
                                    //se for um pieceset
                                    if(i.slice(0,2) == "PS"){
                                        //pega o id do pieceset a partir do indice
                                        var piecesetID = i.slice(2);
                                        //pega a descrição do pieceset a partir do item
                                        var desc = item['desc'];
                                        //pega o tipo do pieceset a partir do item
                                        var type = item['typeID'];
                                        
                                        //adiciona o pieceset
                                        parent.addPieceSet(piecesetID, desc, type);
                                        //para cada item do pieceset
                                        $.each(item, function(i,item){
                                            //se for um piece
                                            if(i.slice(0,1) == "P"){
                                                //pega o id do pieceset a partir do indice
                                                var pieceID = i.slice(1);
                                                var DOMpiecesetID = $('.piecelist').last().attr('id');
                                                //adiciona o pieceset
                                                parent.addPiece(DOMpiecesetID,pieceID);
                                                //seleciona o piece adicionado
                                                parent.changePiece($('.piece').last());
                                                //para cada item do pieceset
                                                $.each(item, function(i,item){
                                                    //se for um elemento
                                                    if(i.slice(0,1) == "E"){
                                                        //declara a array de dados das propriedades do elemento
                                                        var data = new Array();
                                                        
                                                        //preenchimento do array de dados
                                                        $.each(item, function(i,item){
                                                            if(i.slice(0,1) == "L"){
                                                                data['library'] = new Array();
                                                                data['library']['ID'] = i.slice(1);
                                                                data['library']['type'] = item['typeID'];
                                                                
                                                                if(parent.isset(item['Prop1']))
                                                                    data['library']['width'] = item['Prop1'];
                                                                if(parent.isset(item['Prop2']))
                                                                    data['library']['height'] = item['Prop2'];
                                                                if(parent.isset(item['Prop5']))
                                                                    data['library']['src'] = item['Prop5'];
                                                                if(parent.isset(item['Prop12']))
                                                                    data['library']['extension'] = item['Prop12'];
                                                                if(parent.isset(item['Prop22']))
                                                                    data['library']['nstyle'] = item['Prop22'];
                                                                if(parent.isset(item['Prop23']))
                                                                    data['library']['content'] = item['Prop23'];
                                                                if(parent.isset(item['Prop24']))
                                                                    data['library']['color'] = item['Prop24'];
                                                            }
                                                        });
                                                        if(parent.isset(item['Prop6']))
                                                            data['text'] =item['Prop6'];
                                                        if(parent.isset(item['Prop10']))
                                                            data['language'] = item['Prop10'];
                                                        if(parent.isset(item['Prop11']))
                                                            data['classification'] = item['Prop11'];
                                                        //pega o tipo do element
                                                        var type = item['typeID'];
                                                        //pega o id do element a partir do indice
                                                        var elementID = i.slice(1);                         
                                                        parent.addElement(elementID,type,data);
                                                        
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }

                    }
                });
                alert('Load complet!');
            }
        });
    }
    
    this.existID = function(id){
        return $(id).size() > 0;
    }
    this.isset = function(variable){
        return (typeof variable !== 'undefined');
    }
}
