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
    this.currentQuest = 'pg0_q0';
    this.currentTask = 'pg0_q0_t0';
    
    this.changeTask = function(task){
        $('.task').removeClass('active');
        var id = task.attr('id');
        task.addClass('active');
        this.currentTask = id;
    }
    
    this.addPage = function(){
        this.countPage = this.countPage+1;
        $(".content").append('<div class="page" id="pg'+this.countPage+'"></div>');
        this.countQuestion['pg'+this.countPage] = 0;
        
        $('.canvas').pajinate({
            items_per_page : 1,
            nav_label_first : '<<',
            nav_label_last : '>>',
            nav_label_prev : '<',
            nav_label_next : '>',
            show_first_last : false,
            num_page_links_to_display: 20,
            nav_panel_id : '.navpage',
            editor : this
        });
    }
    
    this.addQuest = function(){
        var questionID = this.currentPageId+'_q'+this.countQuestion[this.currentPageId];
        this.countTasks[questionID] = 0;
        $('#'+this.currentPageId).append(''+
            '<div class="quest" id="'+questionID+'_q">'+
                '<input type="text" class="actName" />'+
                '<button class="insertImage">Insert Image</button>'+
                '<button class="insertSound">Insert Sound</button>'+
                '<button class="addTask" id="tsk_'+questionID+'">AddTask</button>'+
                '<div id="'+questionID+'_q_forms"></div>'+
                '<ul class="tasklist" id="'+questionID+'"></ul>'+
                '<span class="clear"></span>'+
            '</div>');

        this.countQuestion[this.currentPageId] =  this.countQuestion[this.currentPageId]+1;          

        var parent = this;
        $("#"+questionID+"_q > button.insertImage").click(function(){
            parent.addImage(questionID+"_q_forms");
            $(this).attr('disabled', 'disabled');
        });
        $("#"+questionID+"_q > button.insertSound").click(function(){
            parent.addSound(questionID+"_q_forms");
            $(this).attr('disabled', 'disabled');
        });

    }
    
    this.addTask = function(id){
        var questid = id.replace("tsk_", "");
        this.currentQuest = questid;
        
        var taskID = this.currentQuest+'_t'+this.countTasks[this.currentQuest];
        this.countPieces[taskID] = 0;
        $('#'+questid).append(''+
            '<li id="'+taskID+'" class="task">'+
                '<button class="delTask">DelTask</button>'+
                '<div class="tplMulti">'+
                    '<button class="newOption">newOption</button>'+
                    '<br>'+
                '</div>'+
            '</li>');
        
        this.countTasks[this.currentQuest] =  this.countTasks[this.currentQuest]+1;
        
        var parent = this;
        $("#"+taskID+"> div > button.newOption").click(function(){
            parent.addOption();
        });
        $("#"+taskID+"> button.delTask").click(function(){
            parent.delTask(taskID);
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
            id      : "pieceID",            //$_POST['pieceID'] on save
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
                accept: Array("png","gif","bmp","jpeg","jpg","ico"),
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
    
    this.addOption = function(){
        var pieceID = this.currentTask+'_p'+this.countPieces[this.currentTask]; 
        $('#'+this.currentTask+" > div.tplMulti").append(''+
            '<span id="'+pieceID+'" class="moptions">'+
                '<div>' +
                    '<button class="insertImage">Insert Image</button>'+
                    '<button class="insertText">Insert Text</button>'+
                    '<button class="delOption">Delete Option</button>'+
                    '<br>'+
                    '<br>'+
                    '<label>'+
                        '<input type="checkbox" id="'+pieceID+'_flag" name="'+pieceID+'_flag" value="Correct">'+
                        'Correct'+
                    '</label>'+
                '</div>' +
            '</span>');
        this.countPieces[this.currentTask] =  this.countPieces[this.currentTask]+1;
        
        var parent = this;
        $("#"+pieceID+" > div > button.insertText").click(function(){
            parent.addText(pieceID);
            $(this).attr('disabled', 'disabled');
            //adicionar opção de alterar
        });
        $("#"+pieceID+" > div > button.insertImage").click(function(){
            parent.addImage(pieceID);
            $(this).attr('disabled', 'disabled');
            //adicionar opção de alterar
        });
        $("#"+pieceID+" > div > button.delOption").click(function(){
            parent.delOption(pieceID);
        });
    }

    this.delTask = function(id){
        if(confirm('Deseja realmente remover esta Task?')){
            $("#"+id).remove();
            delete this.countPieces[id];
        }
    }
    this.delOption = function(id){
        if(confirm('Deseja realmente remover esta Option?')){
            $("#"+id).remove();
        }
   }
   
   this.saveAll = function(){
       //enviar para o banco//
       $('form').submit();
       alert("Salvo com sucesso!");
   }
}
