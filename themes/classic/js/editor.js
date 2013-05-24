function editor () {
    this.templateType;
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
            '<div class="PieceSet" id="'+piecesetID+'_ps">'+
                '<input type="text" class="actName" />'+
                '<button class="insertImage">Insert Image</button>'+
                '<button class="insertSound">Insert Sound</button>'+
                '<button class="addPiece" id="pie_'+piecesetID+'">AddPiece</button>'+
                '<div id="'+piecesetID+'_ps_forms"></div>'+
                '<ul class="piecelist" id="'+piecesetID+'"></ul>'+
                '<span class="clear"></span>'+
            '</div>');

        this.countPieceSet[this.currentPageId] =  this.countPieceSet[this.currentPageId]+1;          

        var parent = this;
        $("#"+piecesetID+"_ps > button.insertImage").click(function(){
            parent.addImage(piecesetID+"_ps_forms");
            $(this).attr('disabled', 'disabled');
        });
        $("#"+piecesetID+"_ps > button.insertSound").click(function(){
            parent.addSound(piecesetID+"_ps_forms");
            $(this).attr('disabled', 'disabled');
        });

    }
    
    this.addPiece = function(id){
        var PieceSetid = id.replace("pie_", "");
        this.currentPieceSet = PieceSetid;
        
        var pieceID = this.currentPieceSet+'_p'+this.countPieces[this.currentPieceSet];
        this.countElements[pieceID] = 0;
        $('#'+PieceSetid).append(''+
            '<li id="'+pieceID+'" class="piece">'+
                '<button class="delPiece">DelPiece</button>'+
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
    
    this.addText = function(id){
        var ID = id;
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
    
    this.addUploadForm = function(id, type, responseFunction){
        var ID = id;
        
        //Default Image
        var uploadType = (type['type']?type['type']:'image'); 
        var uploadAccept = Array();
            uploadAccept = (type['accept']? type['accept']:'*');
        var uploadMaxSize = (type['maxsize']?type['maxsize']: 1024 * 5); 
        var uploadMaxWidth = (type['maxwidth']?type['maxwidth']: 800); 
        var uploadMaxHeight = (type['maxheight']?type['maxheight']: 600); 
        
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
                    '<div class="progress">'+
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
                    '<button class="delElement">Delete Element</button>'+
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
            //adicionar opção de alterar
        });
        $("#"+elementID+" > div > button.insertImage").click(function(){
            parent.addImage(elementID);
            $(this).attr('disabled', 'disabled');
            //adicionar opção de alterar
        });
        $("#"+elementID+" > div > button.delElement").click(function(){
            parent.delElement(elementID);
        });
    }

    this.delPiece = function(id){
        if(confirm('Deseja realmente remover esta Piece?')){
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
//       1-> save cobject 
//            templateID
//            typeID
//            themeID
//       2-> save cobject_metadata
//            cobjectID
//            typeID
//            value
//       3-> each page -> screen{
//           each PieceSet -> PieceSet{
//               each piece -> element{
//                   each moptons -> element{
//                       
//                   }
//               }
//           }
//       }
       //enviar para o banco//
       $('form').submit();
       alert("Salvo com sucesso!");
   }
}