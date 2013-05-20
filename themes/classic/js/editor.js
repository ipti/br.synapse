function editor () {
    this.templateType;
    this.currentPageId = 'pg0';
    this.lastPageId;
    this.countPage = 0;
    this.countQuestion = new Array();
    this.countTasks = new Array();
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
        $(".content").append('<div class="page" id="pg'+this.countPage+'">Página com contador:</div>');
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
                '<button class="addImage">addImage</button>'+
                '<button class="addSound">addSound</button>'+
                '<button class="addTask" id="tsk_'+questionID+'">AddTask</button>'+
                '<ul class="tasklist" id="'+questionID+'"></ul>'+
                '<span class="clear"></span>'+
            '</div>');

        this.countQuestion[this.currentPageId] =  this.countQuestion[this.currentPageId]+1;          
    }
    
    this.addTask = function(id){
        id = id.replace("tsk_", "");
        this.currentQuest = id;
        
        var taskID = this.currentQuest+'_t'+this.countTasks[this.currentQuest];
        this.countPieces[taskID] = 0;
        $('#'+id).append(''+
            '<li class="task" id="'+taskID+'">'+
                '<div class="tplMulti">'+
                    '<span class="moptions">'+
                        '<button class="insertImage">Insert Image</button>'+
                        '<button class="insertText">Insert Text</button>'+
                    '</span>'+
                    '<button class="newOption">newOption</button>'+
                '</div>'+
                '<button class="delTask">DelTask</button>'+
            '</li>');
        this.countTasks[this.currentQuest] =  this.countTasks[this.currentQuest]+1;
        
        var parent = this;
        $(".insertText").last().click(function(){
            parent.addText();
        });
        $(".insertImage").last().click(function(){
            parent.addImage();
        });
    }
    
    this.addText = function(){
        var pieceID = this.currentTask+'_p'+this.countPieces[this.currentTask];
        $('#'+this.currentTask).append('<font class="text editable" id="'+pieceID+'">Clique para Alterar </font>');
        $('#'+pieceID).editable("/editor/json", {   //save page(or function)
            submitdata  : {op: "save"},     //$_POST['op'] on save
            id      : "pieceID",            //$_POST['pieceID'] on save
            name    : "newValue",           //$_POST['newValue'] on save
            type    : "text",               //input type ex: text, textarea, select
            submit  : "Update",
            cancel  : "Calcel",
            loadurl : "/editor/json",       //load page(or function), json
            loadtype: POST,                 //Load method
            loaddata: {op: "load"},         //$_POST['op'] on load
            indicator : 'Saving...',        //HTML witch indicates the save process ex: <img src="img/indicator.gif">
            tooltip   : 'Click to edit...'
         });
        this.countPieces[this.currentTask] =  this.countPieces[this.currentTask]+1;
    }
    
    this.addImage = function(){
        var pieceID = this.currentTask+'_p'+this.countPieces[this.currentTask]; 
        $('#'+this.currentTask).append(''+
            '<div id="'+pieceID+'">'+
                '<form enctype="multipart/form-data" method="post" action="/Editor/upload">'+
                    '<input type="hidden" name="op" value="image">'+
                    '<input type="file" id="imagem" name="file" />'+
                    '<input type="submit" id="send" class="send" value="Upload Image">'+
                    '<div class="progress">'+
                        '<div class="bar"></div>'+
                        '<div class="percent">0%</div>'+
                    '</div>'+
                '</form>'+
            '</div>');
        
            
            $('form').ajaxForm({
                beforeSend: function() {
                    $('.bar').width('0%')
                    $('.percent').html('0%');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    $('.bar').width(percentComplete + '%')
                    $('.percent').html(percentComplete + '%');
                },
                success: function(response) {
                    $("#"+pieceID).remove('form');
                    $("#"+pieceID).html('<img src="'+response+'" alt="Image"/>');
                },
                error: function(error){
                     $('form').html(error.responseText);
                },
                complete: function(xhr) {
                    //status.html(xhr.responseText);
                }
            }); 
            
           this.countPieces[this.currentTask] =  this.countPieces[this.currentTask]+1;
    }

}


                        
                        
                        
                     

