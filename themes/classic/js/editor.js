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
    
    this.changePiece = function(piece){
        $('.piece').removeClass('active');
        var id = piece.attr('id');
        piece.addClass('active');
        this.currentPiece = id;
    }
    
    this.addScreen = function(){
        this.countScreen = this.countScreen+1;
        $(".content").append('<div class="screen" id="sc'+this.countScreen+'"></div>');
        this.countPieceSet['sc'+this.countScreen] = 0;
        
        $('.canvas').pajinate({
            items_per_page : 1,
            nav_label_first : '<<',
            nav_label_last : '>>',
            nav_label_prev : '<',
            nav_label_next : '>',
            show_first_last : false,
            num_page_links_po_display: 20,
            nav_panel_id : '.navscreen',
            editor : this
        });
    }
    
    this.addPieceSet = function(){
        var parent = this;
        var piecesetID = this.currentScreenId+'_ps'+this.countPieceSet[this.currentScreenId];
        this.countPieces[piecesetID] = 0;
        $('#'+this.currentScreenId).append(''+
            '<div class="PieceSet" id="'+piecesetID+'_list">'+
            '<button class="insertImage">'+LABEL_ADD_IMAGE+'</button>'+
            '<button class="insertSound">'+LABEL_ADD_SOUND+'</button>'+
            '<button class="addPiece" id="pie_'+piecesetID+'">'+LABEL_ADD_PIECE+'</button>'+
            '<button class="del delPieceSet">'+LABEL_REMOVE_PIECESET+'</button>'+
            '<input type="text" class="actName" />'+
            '<div id="'+piecesetID+'_forms"></div>'+
            '<ul class="piecelist" id="'+piecesetID+'"></ul>'+
            '<span class="clear"></span>'+
            '</div>');

        this.countPieceSet[this.currentScreenId] =  this.countPieceSet[this.currentScreenId]+1;          

        var parent = this;
        $("#"+piecesetID+"_list > button.insertImage").click(function(){
            parent.addImage(piecesetID+"_forms");
            $(this).attr('disabled', 'disabled');
        });
        $("#"+piecesetID+"_list > button.insertSound").click(function(){
            parent.addSound(piecesetID+"_forms");
            $(this).attr('disabled', 'disabled');
        });
        $("#"+piecesetID+"_list > button.delPieceSet").click(function(){
            parent.delPieceSet(piecesetID);
        });

    }
    
    this.addPiece = function(id){
        var parent = this;
        var PieceSetid = id.replace("pie_", "");
        this.currentPieceSet = PieceSetid;
        
        var pieceID = this.currentPieceSet+'_p'+this.countPieces[this.currentPieceSet];
        this.countElements[pieceID] = 0;
        $('#'+PieceSetid).append(''+
            '<li id="'+pieceID+'" class="piece">'+
            '<button class="del delPiece">'+LABEL_REMOVE_PIECE+'</button>'+
            '<div class="tplMulti">'+
            '<button class="newElement">'+LABEL_ADD_ELEMENT+'</button>'+
            '<br>'+
            '</div>'+
            '</li>');
        
        this.countPieces[this.currentPieceSet] =  this.countPieces[this.currentPieceSet]+1;

        $("#"+pieceID+"> div > button.newElement").click(function(){
            parent.addElement();
        });
        $("#"+pieceID+"> button.delPiece").click(function(){
            parent.delPiece(pieceID);
        });
    }
    
    this.addText = function(ID){
        $('#'+ID).append('<font class="text editable" id="'+ID+'_text">'+LABEL_INITIAL_TEXT+'</font>');
        $('#'+ID+"_text").editable(function(value, settings) { 
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
            tooltip   : LABEL_INITIAL_TEXT
        });
    }
    
    this.addUploadForm = function(ID, type, responseFunction){
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
        
        $('#'+ID).append(''+
            '<div id="'+file+'">'+
            '<form enctype="multipart/form-data" id="'+form+'" method="post" action="/Editor/upload">'+
            '<input type="hidden" name="op" value="'+uploadType+'">'+
            '<input type="file" id="'+uploadType+'" name="file" value="" accept="'+accept+'" />'+
            '</form>'+
            '</div>');
        
        $('#'+form+' > input#'+uploadType).bind('change', function() {
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
    
    this.addImage = function(id){
        this.addUploadForm(id, {
            type: 'image',
            accept: Array("png","gif","bmp","jpeg","jsc","ico"),
            maxsize: (1024 * 5) //5MB
        },function(src, fileid, formid){
            $("#"+fileid+" > img").remove("img");
            $("#"+fileid).append('<img  src="'+src+'" width="320" height="240" alt="Image"/>');
        });
    }
    
    this.addSound = function(id){
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
        });
    }
    
    this.addVideo = function(id){
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
        });
    }
    
    this.addElement = function(){
        var parent = this;
        var elementID = this.currentPiece+'_e'+this.countElements[this.currentPiece]; 
        $('#'+this.currentPiece+" > div.tplMulti").append(''+
            '<span id="'+elementID+'" class="element moptions">'+
            '<div>' +
            '<button class="insertImage">'+LABEL_ADD_IMAGE+'</button>'+
            '<button class="insertText">'+LABEL_ADD_TEXT+'</button>'+
            '<button class="del delElement">'+LABEL_REMOVE_ELEMENT+'</button>'+
            '<br>'+
            '<br>'+
            '<br>'+
            '<label>'+
            '<input type="checkbox" id="'+elementID+'_flag" name="'+elementID+'_flag" value="'+LABEL_CORRECT+'">'+
            'Correct'+
            '</label>'+
            '</div>' +
            '</span>');
        this.countElements[this.currentPiece] =  this.countElements[this.currentPiece]+1;
        
        var buttonTextoID = "#"+elementID+" > div > button.insertText";
        var buttonImageID = "#"+elementID+" > div > button.insertImage";
        var buttonDelID = "#"+elementID+" > div > button.delElement";
        var textoID = "#"+elementID+"_text";
        var imageID = "#"+elementID+"_image";
        
        var ElementTextID = "#"+elementID+"_text";
        var ElementImageID = "#"+elementID+"_image";
        
        $(buttonTextoID).click(function(){
            if(!parent.existID(ElementImageID) || 
                confirm(MSG_CHANGE_ELEMENT)){
                    parent.addText(elementID);
                    $(buttonTextoID).attr('disabled', 'disabled');
                    $(buttonImageID).removeAttr('disabled');
                    $(imageID).remove();
                }
        });
        $(buttonImageID).click(function(){
            if(!parent.existID(ElementTextID) || 
                confirm(MSG_CHANGE_ELEMENT)){
                    parent.addImage(elementID);
                    $(buttonImageID).attr('disabled', 'disabled');
                    $(buttonTextoID).removeAttr('disabled');
                    $(textoID).remove();
                }
        });
        $(buttonDelID).click(function(){
            parent.delElement(elementID);
        });
    }
    
    this.delScreen = function(){
        var id = this.currentScreenId;
        if(confirm(MSG_REMOVE_SCREEN)){
            $("#"+id).remove();
            delete this.countPieceSet[id];
        }
    }

    this.delPieceSet = function(id){
        if(confirm(MSG_REMOVE_PIECESET)){
            $("#"+id).remove();
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
        
        //cria tela de log
        $('.theme').append('<div style="left: 0px; width: 100%; height: 100%; position: fixed; top: 0px; background: none repeat scroll 0px 0px black; opacity: 0.8;" class="savebg"></div>');
        $('.theme').append('<div style="background: none repeat scroll 0px 0px white; height: 300px; border-radius: 5px 5px 5px 5px; width: 800px; margin-top: 100px; margin-left: 250px; position: fixed; border: 2px solid black; padding: 10px;" class="savescreen">'+
            '<p>Aguarde um instante...</p>'+
            '</div>');
        
        //Salva o CObject
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
            //atualiza o ID do CObject, com a resposta do Ajax
            parent.CObjectID = response['CObjectID'];
            
            //Reubucua o contador da Ordem das Screens
            screenPosition = 1;
            
            //Para cada tela
            $('.screen').each(function(){
                //Atualiza a ScreeID com o ID do ".screen" atual
                ScreenID = $(this).attr('id');
                
                //Salva Screen
                parent.saveData({ 
                    //Operação Salvar, Screen, ID no DOM
                    op: "save", 
                    step: "Screen",
                    //Necessário para que o JS fique sincronizado com o Ajax
                    DomID: ScreenID,
                    //Dados da Screen
                    CObjectID: parent.CObjectID,
                    Number: screenPosition,
                    Ordem: screenPosition,
                    Width: 960,
                    Height: 500
                },
                //função sucess do save Screen
                function(response, textStatus, jqXHR){
                    //Atualiza a tela de log
                    $('.savescreen').append('<br><p>Screen salvo com sucesso!</p>');
                    
                    //Retorna o ID no DOM e o ID da ultima Tela no Banco.
                    curretScreenID = response['DomID'];
                    LastScreenID = response['screenID'];
                    
                    //reinicia o contador de posição dos PieceSet na Screen
                    pieceSetPosition = 1;
                    
                    //Para cada PieceSet da Screen
                    $('#'+curretScreenID+' .PieceSet').each(function(){
                        PieceSetID = $(this).attr('id');
                        pieceSetDescription = $('#'+PieceSetID+' .actName' ).val();
                        
                        //Salva PieceSet
                        parent.saveData({ 
                            //Operação Salvar, PieceSet, ID no DOM
                            op: "save",
                            step: "PieceSet",
                            DomID: PieceSetID,
                            //Dados do PieceSet
                            typeID: 7,
                            desc: pieceSetDescription,
                            screenID: LastScreenID,
                            position: pieceSetPosition,
                            templateID: parent.COtemplateType
                        },
                        //Função sucess do save PieceSet
                        function(response, textStatus, jqXHR){
                            $('.savescreen').append('<br><p>PieceSet salvo com sucesso!</p>');
                            curretPieceSetID = response['DomID'];
                            LastPieceSetID = response['PieceSetID'];
                            
                            //reiniciar o contador de posição da Piece no PieceSet
                            piecePosition = 1;
                            
                            //Para cada Piece do PieceSet
                            $('#'+curretPieceSetID+' .piece').each(function(){
                                PieceID = $(this).attr('id');
                                
                                //Save Piece
                                parent.saveData({
                                    //Operação Salvar, Piece, ID no DOM
                                    op: "save",
                                    step: "Piece",
                                    DomID: PieceID,
                                    //Dados do Piece
                                    typeID: 7,
                                    pieceSetID: LastPieceSetID,
                                    ordem: piecePosition
                                },
                                //Função de sucess do Save Piece
                                function(response, textStatus, jqXHR){
                                    $('.savescreen').append('<br><p>Piece salvo com sucesso!</p>');
                                    curretPieceID = response['DomID'];
                                    LastPieceID = response['PieceID'];
                                    
                                    elementPosition = 1;
                                    
                                    //Para cada Elemento no Piece
                                    $('#'+curretPieceID+' .element').each(function(){
                                        ElementID = $(this).attr('id');
                                        Flag = $('#'+ElementID+'_flag').is(':checked');
                                        
                                        var type;
                                        var value;
                                        
                                        var ElementTextID = "#"+ElementID+"_text";
                                        var ElementImageID = "#"+ElementID+"_image";
                                        var FormElementImageID = "#"+ElementID+"_image_form";
                                        
                                        if(parent.existID(ElementTextID)){
                                            type = 11; //text
                                            value = $(ElementTextID).html();
                                        }else if(parent.existID(ElementImageID)){
                                            type = 16; //image
                                            value = {};
                                        }else{
                                            type = -1;
                                            value = -1;
                                        }
                                        
                                        var data = {
                                            op: "save",
                                            step: "Element",
                                            typeID: type,
                                            DomID: ElementID,
                                            //Dados do Element
                                            ordem: elementPosition,
                                            pieceID: LastPieceID,
                                            flag: Flag,
                                            value: value
                                            //Operação Salvar, Element, Type, ID no DOM
                                       };
                                       
                                        if(parent.existID(ElementTextID)){
                                            //Salva Elemento
                                            parent.saveData(data,
                                            //Função de sucess do Save Element
                                            function(response, textStatus, jqXHR){
                                                $('.savescreen').append('<br><p>ElementText salvo com sucesso!</p>');
                                            });
                                            
                                            //incrementa a Ordem do Element
                                            elementPosition++;
                                            
                                        }else if(parent.existID(ElementImageID)){
                                            $(FormElementImageID).ajaxForm({
                                                beforeSend: function() {
                                                    //$("#"+bar).width('0%')
                                                    //$("#"+percent).html('0%');
                                                },
                                                uploadProgress: function(event, position, total, percentComplete) {
                                                    //$("#"+bar).width(percentComplete + '%')
                                                    //$("#"+percent).html(percentComplete + '%');
                                                },
                                                success: function(response) {
                                                    data['value']['url'] = response['url'];
                                                    data['value']['name'] = response['name'];
                                                    //enviado com sucesso!
                                                    //Salva Elemento
                                                    parent.saveData(data,
                                                    //Função de sucess do Save Element
                                                    function(response, textStatus, jqXHR){
                                                        $('.savescreen').append('<br><p>ElementImage salvo com sucesso!</p>');
                                                    });
                                                },
                                                error: function(error, textStatus, errorThrown){
                                                    //$("#"+form).html(error.responseText);
                                                    alert(ERROR_FILE_UPLOAD);
                                                    $(".savescreen").append(error.responseText);
                                                }
                                            }); 
                                            
                                            $(FormElementImageID).submit();
                                            //incrementa a Ordem do Element
                                            elementPosition++;
                                        }
                                    });
                                    //incrementa a Ordem do Piece
                                    piecePosition++;
                                });
                            });
                            //incrementa a Ordem do PieceSet
                            pieceSetPosition++;
                        });
                    });
                    //incrementa a Ordem da Screen
                    screenPosition++;
                });       
            });
        });
       
       
        
        //$('form').submit();
    }
    
    this.existID = function(id){
        return $(id).size() > 0;
    }
}
