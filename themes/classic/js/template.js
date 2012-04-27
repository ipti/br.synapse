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
    
    this.buildHtml = function(t){
        switch (t){
            case 'addPage':
                this.countPage = this.countPage+1;
                var htmAddPage = '<div class="page" id="pg'+this.countPage+'"></div>';
                this.countQuestion['pg'+this.countPage] = 0;
                return htmAddPage;
                break;
            case 'addQuest':
                var questionID = this.currentPageId+'_q'+this.countQuestion[this.currentPageId];
                this.countTasks[questionID] = 0;
                var htmAddQuest = '<div class="quest" id="'+questionID+'_q"><input type="text" class="actName" />'+
                '<button class="addTask" id="tsk_'+questionID+'">AddTask</button><ul class="tasklist" id="'+questionID+'"></ul><span class="clear"></span></div>';
                this.countQuestion[this.currentPageId] =  this.countQuestion[this.currentPageId]+1;
                return htmAddQuest;
                break;
            case 'addTask':
                var taskID = this.currentQuest+'_t'+this.countTasks[this.currentQuest];
                this.countPieces[taskID] = 0;
                var htmAddTask = '<li class="task" id="'+taskID+'"> <button class="delTask">DelTask</button></li>';
                this.countTasks[this.currentQuest] =  this.countTasks[this.currentQuest]+1;
                return htmAddTask;
                break;
           case 'addText':
                var pieceID = this.currentTask+'_p'+this.countPieces[this.currentTask];
                var htmAddText = '<font class="text" id="'+pieceID+'">TEXTO INSERIDO</font>';
                this.countPieces[this.currentTask] =  this.countPieces[this.currentTask]+1;
                return htmAddText;
                break;
                
        }
    }
    
    
}


                        
                        
                        
                     

