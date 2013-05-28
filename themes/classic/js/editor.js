function editor () { 
    this.COtypeID;
    this.COthemeID;
    this.COtemplateType;
    this.CObjectID;
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
        var piecesetID = this.currentScreenId+'_ps'+this.countPieceSet[this.currentScreenId];
        this.countPieces[piecesetID] = 0;
        $('#'+this.currentScreenId).append(''+
            '<div class="PieceSet" id="'+piecesetID+'_list">'+
                '<button class="insertImage">Insert Image</button>'+
                '<button class="insertSound">Insert Sound</button>'+
                '<button class="addPiece" id="pie_'+piecesetID+'">AddPiece</button>'+
                '<button class="del delPieceSet">Delete PieceSet</button>'+
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
        var PieceSetid = id.replace("pie_", "");
        this.currentPieceSet = PieceSetid;
        
        var pieceID = this.currentPieceSet+'_p'+this.countPieces[this.currentPieceSet];
        this.countElements[pieceID] = 0;
        $('#'+PieceSetid).append(''+
            '<li id="'+pieceID+'" class="piece">'+
                '<button class="del delPiece">DelPiece</button>'+
                '<div class="tplMulti">'+
                    '<button class="newElement">newElement</button>'+
                    '<br>'+
                '</div>'+
            '</li>');
        
        this.countPieces[this.currentPieceSet] =  this.countPieces[this.currentPieceSet]+1;
        
        var parent = this;
        $("#"+pieceID+"> div > button.newElement").click(function(){
            parent.addElement();
        });
        $("#"+pieceID+"> button.delPiece").click(function(){
            parent.delPiece(pieceID);
        });
    }
    
    this.addText = function(ID){
        $('#'+ID).append('<font class="text editable" id="'+ID+'_text">Clique para Alterar </font>');
        $('#'+ID+"_text").editable(function(value, settings) { 
                console.log(this);
                console.log(value);
                console.log(settings);
                return(value);
             },{ //save function(or page)
            submitdata  : {op: "save"},     //$_POST['op'] on save
            id      : "elementID",            //$_POST['elementID'] on save
            name    : "newValue",           //$_POST['newValue'] on save
            type    : "text",               //input type ex: text, textarea, select
            submit  : "Update",
            cancel  : "Calcel",
            //loadurl : "/editor/json",       //load function(or page), json
            loadtype: "POST",                 //Load method
            loaddata: {op: "load"},         //$_POST['op'] on load
            indicator : 'Saving...',        //HTML witch indicates the save process ex: <img src="img/indicator.gif">
            tooltip   : 'Click to edit...'
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
        var bar     = form+" > div.progress > div.bar";
        var percent = form+" > div.progress > div.percent";
        
        $('#'+ID).append(''+
            '<div id="'+file+'">'+
                '<form enctype="multipart/form-data" id="'+form+'" method="post" action="/Editor/upload">'+
                    '<input type="hidden" name="op" value="'+uploadType+'">'+
                    '<input type="file" id="'+uploadType+'" name="file" value="" accept="'+accept+'" />'+
                    //'<input type="button" id="send" class="send" value="Upload">'+
                    '<div class="progress" style="visibility:hidden">'+
                        '<div class="bar"></div>'+
                        '<div class="percent">0%</div>'+
                    '</div>'+
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
                    alert('Tipo do arquivo incompatível.');
                }
            }else{
                alert('Arquivo muito grande. Tamanho máximo: '+uploadMaxSize+'MB');
            }
            
        });
            
        $("#"+form).ajaxForm({
            beforeSend: function() {
                $("#"+bar).width('0%')
                $("#"+percent).html('0%');
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $("#"+bar).width(percentComplete + '%')
                $("#"+percent).html(percentComplete + '%');
            },
            success: function(response) {
                //enviado com sucesso!
            },
            error: function(error, textStatus, errorThrown){
                 //$("#"+form).html(error.responseText);
                 alert("Houve um erro ao enviar o arquivo.");
                 $("#"+form).append(error.responseText);
            },
            complete: function(xhr) {
                //status.html(xhr.responseText);
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
        this.addUploadForm(id, {
                type: 'audio',
                accept: Array("mp3","wav","ogg"),
                maxsize: (1024 * 10) //10MB
            }, function(src, fileid, formid){
                $("#"+fileid+" > audio").remove("audio");
                $("#"+fileid).append(''+
                    '<audio src="'+src+'" controls="controls">'+
                        'Your browser does not support the audio element.'+
                    '</audio>');
        });
    }
    
    this.addVideo = function(id){
        this.addUploadForm(id, {
                type: 'video',
                accept: Array("mp4","wmv","ogg"),
                maxsize: (1024 * 20) //10MB
            }, function(src, fileid, formid){
                $("#"+fileid+" > video").remove("video");
                $("#"+fileid).append(''+
                    '<video src="'+src+'" width="320" height="240" controls="controls">'+
                        'Your browser does not support the video element.'+
                    '</video>');
        });
    }
    
    this.addElement = function(){
        var elementID = this.currentPiece+'_e'+this.countElements[this.currentPiece]; 
        $('#'+this.currentPiece+" > div.tplMulti").append(''+
            '<span id="'+elementID+'" class="element moptions">'+
                '<div>' +
                    '<button class="insertImage">Insert Image</button>'+
                    '<button class="insertText">Insert Text</button>'+
                    '<button class="del delElement">Delete Element</button>'+
                    '<br>'+
                    '<br>'+
                    '<label>'+
                        '<input type="checkbox" id="'+elementID+'_flag" name="'+elementID+'_flag" value="Correct">'+
                        'Correct'+
                    '</label>'+
                '</div>' +
            '</span>');
        this.countElements[this.currentPiece] =  this.countElements[this.currentPiece]+1;
        
        var parent = this;
        $("#"+elementID+" > div > button.insertText").click(function(){
            parent.addText(elementID);
            $(this).attr('disabled', 'disabled');
        });
        $("#"+elementID+" > div > button.insertImage").click(function(){
            parent.addImage(elementID);
            $(this).attr('disabled', 'disabled');
        });
        $("#"+elementID+" > div > button.delElement").click(function(){
            parent.delElement(elementID);
        });
    }
    
    this.delScreen = function(){
        var id = this.currentScreenId;
        if(confirm('Deseja realmente remover este Screen?')){
            $("#"+id).remove();
            delete this.countPieceSet[id];
        }
    }

    this.delPieceSet = function(id){
        if(confirm('Deseja realmente remover este PieceSet?')){
            $("#"+id).remove();
            delete this.countPieces[id];
        }
    }

    this.delPiece = function(id){
        if(confirm('Deseja realmente remover este Piece?')){
            $("#"+id).remove();
            delete this.countElements[id];
        }
    }
    this.delElement = function(id){
        if(confirm('Deseja realmente remover esta Element?')){
            $("#"+id).remove();
        }
   }
   
   this.saveAll = function(){
        var parent = this;
        var ScreenID;
        var PieceSetID;
        var PieceID;
        var ElementID;
        var ordem;
        var position;
        var LastScreenID;
        var LastPieceSetID;
//       1-> save cobject 
//            templateID
//            typeID
//            themeID
//       2-> save cobject_metadata
//            cobjectID
//            typeID
//            value
//       3-> each screen{
//           each PieceSet{
//               each element{
//                   each moptons -> element{
//                       
//                   }
//               }
//           }
//       }
//       
       //Save CObject
       $('.theme').append('<div style="left: 0px; width: 100%; height: 100%; position: fixed; top: 0px; background: none repeat scroll 0px 0px black; opacity: 0.8;" class="savebg"></div>');
       $('.theme').append('<div style="background: none repeat scroll 0px 0px white; height: 300px; border-radius: 5px 5px 5px 5px; width: 800px; margin-top: 100px; margin-left: 250px; position: fixed; border: 2px solid black; padding: 10px;" class="savescreen">'+
            '<p>Aguarde um instante...</p>'+
            '</div>');
       
        $.ajax({
            type: "POST",
            url: "/Editor/Json",
            dataType: 'json',
            data: { 
                op: "save", 
                step: "CObject",
                COtypeID: parent.COtypeID,
                COthemeID: parent.COthemeID,
                COtemplateType: parent.COtemplateType
            },
            beforeSend: function(jqXHR, settings ){
                $('.savescreen').append('<br><p>Salvando CObject...</p>');
            },
            error: function( jqXHR, textStatus, errorThrown ){
                $('.savescreen').append('<br><p>Erro ao salvar CObject.</p>');
                $('.savescreen').append('<br><p>Error mensage:</p>');
                $('.savescreen').append(jqXHR.responseText);
            },
            success: function(response, textStatus, jqXHR){
                $('.savescreen').append('<br><p>CObject salvo com sucesso!</p>');
                parent.CObjectID = response['CObjectID'];
            }
        });  
        
        
        
        ordem = 0;
        $('.screen').each(function(){
            ScreenID = $(this).attr('id');
            console.log(ScreenID);
            console.log('Ordem: '+ordem);
            
            //saveScreen
            //Tabela: editor_screen
            //cobjectID = CObjectID
            //number = ordem
            //order = ordem
            
            $.ajax({
                type: "POST",
                url: "/Editor/Json",
                dataType: 'json',
                data: { 
                    op: "save", 
                    step: "Screen",
                    CObjectID: parent.CObjectID,
                    Number: ordem,
                    Ordem: ordem
                },
                beforeSend: function(jqXHR, settings ){
                    $('.savescreen').append('<br><p>Salvando Screen...</p>');
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    $('.savescreen').append('<br><p>Erro ao salvar Screen.</p>');
                    $('.savescreen').append('<br><p>Error mensage:</p>');
                    $('.savescreen').append(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    $('.savescreen').append('<br><p>Screen salvo com sucesso!</p>');
                    LastScreenID = response['ScreenID'];
                }
            }); 
            ordem++;
            position = 0;
            $('#'+ScreenID+' .PieceSet').each(function(){
                PieceSetID = $(this).attr('id');
                var desc = $('#'+PieceSetID+' .actName' ).val();
                console.log('-'+PieceSetID);
                console.log('-Desc: '+desc);
                console.log('-Pos: '+position);
                
                            
                $.ajax({
                    type: "POST",
                    url: "/Editor/Json",
                    dataType: 'json',
                    data: { 
                        op: "save", 
                        step: "PieceSet",
                        typeID: parent.COTypeID,
                        desc: desc,
                        position: position,
                        templateID: parent.COtemplateType
                    },
                    beforeSend: function(jqXHR, settings ){
                        $('.savescreen').append('<br><p>Salvando PieceSet...</p>');
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        $('.savescreen').append('<br><p>Erro ao salvar PieceSet.</p>');
                        $('.savescreen').append('<br><p>Error mensage:</p>');
                        $('.savescreen').append(jqXHR.responseText);
                    },
                    success: function(response, textStatus, jqXHR){
                        $('.savescreen').append('<br><p>PieceSet salvo com sucesso!</p>');
                        LastPieceSetID = response['PieceSetID'];
                    }
                }); 
                
                //savePieceSet
                //Tabela: editor_pieceset
                //typeID = COTypeID
                //desc = desc                
                //
                //savePieceSet_on_Screen
                //Tabela: editor_screen_pieceset
                //screenID = LastScreenID
                //piecesetID = LastPieceSetID
                //position = position
                //templateID = COtemplateType;
                position++;
                $('#'+PieceSetID+' .piece').each(function(){
                    PieceID = $(this).attr('id')
                    console.log('--'+PieceID);
                    //savePiece
                    $('#'+PieceID+' .element').each(function(){
                        ElementID = $(this).attr('id')
                        console.log('---'+ElementID);
                        //saveElement
                    });
                });
            });
        });


       //enviar para o banco//
       $('form').submit();
       alert("Salvo com sucesso!");
   }
}