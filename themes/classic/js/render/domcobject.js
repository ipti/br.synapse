COBJECT_GOAL = "Goal";
COBJECT_TYPE = "Type";
COBJECT_DEGREE_NAME = "Degree Name";
COBJECT_DISCIPLINE = "Discipline";
COBJECT_CONTENT = "Content";
//Label Buttons
 NEXT_PIECE = "Próxima Atividade >>>>>";
 NEXT_SCREEN = "Próxima Tela >>>>>";
 BEGIN_ACTIVITY = "Iniciar Atividade"
var DomCobject = function(cobject){
    this.cobject = cobject;
    this.currentScreen = '';
    this.currentPieceSet = '';
    this.currentPiece = '';
    this.currentElement = '';
    this.domCobject = '';
    this.dom = $('<div class="cobjects"></div>');
    this.domContent = $('<div class="content"></div>');
    this.domScreen = '';
    this.domPieceSet = '';
    this.domPiece = '';
    this.domElement = '';
    this.dirLibrary = '/rsc/library';
    var self = this;
    
    //Armazenar Árvore de Peças
    //var pieces, 
    this.mainPieces= new Array();
    //==========================

    this.pos = {
        screen:0,
        pieceset:0,
        piece:0,
        group:0,
        element:0
    }
    this.id = {
        screen:0,
        pieceset:0,
        piece:0,
        element:0
    }

    this.buildAll = function(){
        self.dom.append(self.buildInfo_Cobject);
        self.dom.append(self.buildToolBar);
        self.dom.append(self.domContent);
        for (this.pos.screen = 0; this.pos.screen < this.cobject.screens.length; this.pos.screen++) {
            self.id.screen = this.cobject.screens[this.pos.screen].id;
            self.domContent.append(self.buildScreen());
        };
        return self.dom;
    }

    this.buildScreen = function(){
        if(this.pos.screen == 0){
            // É a primeira Screen
            self.domScreen = $('<div class="T_screen currentScreen" id="S'+self.id.screen+'"> \n\
           <button id="begin_activity">'+BEGIN_ACTIVITY+'</button></div>');  
        }else{
            self.domScreen = $('<div class="T_screen" style="display:none" id="S'+self.id.screen+'"></div>'); 
        }
        
        var piecesets_length = this.cobject.screens[this.pos.screen].piecesets.length;
        for(this.pos.pieceset = 0; this.pos.pieceset < piecesets_length; this.pos.pieceset++) {
            self.id.pieceset =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].id;
            self.domScreen.append(this.buildPieceSet());
        };
        return self.domScreen;
    }
            
    this.buildPieceSet = function(){
        self.domPieceSet = $('<div class="pieceset" id="'+self.id.pieceset+'"></div>');
        self.domPieceSet.append(self.buildInfo_PieceSet()); 
        var fd = $('<fieldset></fieldset>');
        var pieces_length =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces.length;
        for(this.pos.piece = 0; this.pos.piece < pieces_length; this.pos.piece++) {
            self.id.piece =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[this.pos.piece].id;
            fd.append(this.buildPiece());
        };
        self.domPieceSet.append(fd);
        return self.domPieceSet;
    }
            
    this.buildPiece = function(){
        self.domPiece = $('<div class="piece" id="'+self.id.piece+'"></div>');
        var domElementASK = $('<div class="ask"></div>');
        var domElementANSWER = $('<div class="answer"></div>');
        var groups = self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups;
        
        var objGroups_currentPiece = {};
        $.each(groups, function(current_group, elements_group){
            self.pos.group =current_group; // O grupo Corrent dessa Piece!
            
            //array que armazena todos os objetos grupos da piece atual
            var group_split = current_group.split('_');   
            // ASK = Múltiplo de 2 ; ANSWER = Múltiplo de 3
            var newIdGroup = (group_split[1]===undefined) ? (self.id.piece*(group_split[0]))*2 : (self.id.piece*(group_split[0]))*3 +'_1';
            eval("objGroups_currentPiece._"+newIdGroup+" = elements_group;");
            
            // console.log(groupsPiece[self.id.piece][current_group]);
            // groupsPiece[self.id.piece][current_group] = elements_group;
            
            var domTypeGroup="";
            var domGroup="";
            if(current_group.split('_').length==1){
                //is ASK-GROUP
                domTypeGroup = domElementASK;
            }else{
                // is ANSWER-GROUP
                domTypeGroup = domElementANSWER;
            }
            var possibleGroup = domTypeGroup.find('div[group="'+newIdGroup+'"]');
            var isNewGroup = (possibleGroup.size() == 0);
            if(isNewGroup){
                // Novo Grupo
                domGroup =$('<div group="'+newIdGroup+'" class="'+self.cobject.template_code+' group" ><div>'); 
            }else{
                //Grupo existente
                domGroup =possibleGroup; 
            }
            
            var elements_length = elements_group.elements.length;
            for(self.pos.element = 0; self.pos.element < elements_length; self.pos.element++) {
                self.id.element =  elements_group.elements[self.pos.element].id;
                domGroup.append(self.buildElement());
                if(isNewGroup){
                    //Se for um novo Grupo, então add o novo
                    domTypeGroup.append(domGroup);
                }
                
            };
        });
        //Armazena todos os grupos de cada peça
        objGroups_currentPiece.istrue = null;
        self.mainPieces[self.id.piece] = objGroups_currentPiece;
        self.domPiece.append(domElementASK);
        self.domPiece.append(domElementANSWER);      
              
        return self.domPiece;
    }
    
    
    //Embaralhar qualquer Array
//    this.shuffleArray = function (array) {
//        var counter = array.length;
//        var temp,index;
//        // Percorrer os elementos do Array do > para o <
//        while (counter > 0) {
//            //Obter um Random Index
//            index = Math.floor(Math.random() * counter);
//            counter--;
//            // E da um swap entre o index e o último count
//            temp = array[counter];
//            array[counter] = array[index];
//            array[index] = temp;
//        }
//
//        return array;
//    }
    

    this.buildEnum = function(){
        self.domEnum = $('<div class="enunciation"></div>');
        eval("self.buildEnum_"+self.cobject.template_code+"();");
    }
            
    this.buildElement = function(){
        return eval("self.buildElement_"+cobject.template_code+"();");
    }

    this.buildElement_MTE = function(){
    }
            
    this.buildElement_AEL = function(){
        var html = "";
        var currentElement = self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups[self.pos.group].elements[self.pos.element];
        if(currentElement.type == 'multimidia') {
            var strBuild_library_type = "";
            var properties = "var properties = {";
            $.each(currentElement.generalProperties, function(i,item){
                if(item['name']=='library_type') {
                    strBuild_library_type="build_"+item['value'];
                }else{
                    properties+= "'"+item['name'] +"':'"+ item['value']+"',";
                }
            });
            properties+="};";
            
            html+= eval('self.'+strBuild_library_type+'("'+properties+'");');
            
        }else if(currentElement.type == 'text'){
            var strBuild_text = "";
            var properties = "var properties = {";
            $.each(currentElement.generalProperties, function(i,item){
                properties+= "'"+item['name'] +"':'"+ item['value']+"',";
            });
            properties+="};";
            html+= self.build_text(properties);
        }   
        self.domElement = $('<li class="element" id="'+self.id.element+'">'+html+'</li>');
        return self.domElement;
    }
            
    this.buildElement_PRE = function(){
    }
            
    this.buildElement_TXT = function(){
    }
            
    // Type Text
    this.build_text = function(properties){
        //Properties : extension, src, width, height
        eval(properties);
        var text = properties['text'];
        var language = properties['language'];
        var html = '<span class="elementText">\n\
                    '+ text +'</span>';
        return html;
    }
           
    // Type of Elements
    this.build_image = function(properties){
        //Properties : extension, src, width, height
        eval(properties);
        var src = self.dirLibrary+'/images/'+properties['src']; 
        var extension = properties['extension']; 
        var library_id = properties['library_id'];  
        var width = properties['width']; 
        var height = properties['height']; 
        var html = '<span class="elementImage"  library_id=' + library_id + ' >\n\
                 <font style="display:block;font-size:9px;"></font> \n\
                 <img src="'+src+'"></img></span>';
        return html;
    }
 
    this.build_sound = function(properties){
        //Properties : extension, src
        eval(properties);
        var src = self.dirLibrary+'/audio/'+properties['src']; 
        var extension = properties['extension']; 
        var library_id = properties['library_id'];  
        var html = '<span class="elementSound" library_id=' + library_id + '><font style="display:block;font-size:9px;">Clique no icone de play para escuta as instruções</font> \n\
                 <audio controls="controls" preload="preload" title="Titulo"> \n\
                 <source src="'+src+'"> '+'ERROR_BROWSER_SUPORT'+' </audio></span>';
     
        return html;
    }
 
    this.build_txt = function(properties){
        //Properties : extension, src
        eval(properties);
        var src = self.dirLibrary+'/audio/'+properties['src']; 
        var extension = properties['extension']; 
        var library_id = properties['library_id'];  
        var html = '<span class="elementSound" library_id=' + library_id + '><font style="display:block;font-size:9px;">Clique no icone de play para escuta as instruções</font> \n\
                 <audio controls="controls" preload="preload" title="Titulo"> \n\
                 <source src="'+src+'"> '+'ERROR_BROWSER_SUPORT'+' </audio></span>';
     
        return html;
    }  
    
    
    this.buildEnum_MTE = function(){
        
    }
    this.buildEnum_AEL = function(){
        
    }
    this.buildEnum_TXT = function(){
        
    }
    this.buildEnum_PRE = function(){
        
    }
    
       
       
    this.buildInfo_MEET = function(){
       
    } 
   
    this.buildInfo_Cobject = function(){
        var goal = self.cobject.goal; 
        var type = self.cobject.cobject_type;
        var degree_name = self.cobject.degree_name;
        var discipline = self.cobject.discipline;
        var content = self.cobject.content; 
        var html = $('<div class="cobjectInfo"></div>');
        html.append('<span><b>'+COBJECT_GOAL+":</b> "+goal+" <b>"+COBJECT_TYPE+":</b> "+type+" <br><b>"+COBJECT_DEGREE_NAME+":</b> "+degree_name+
            " <b>"+COBJECT_DISCIPLINE+":</b> "+discipline+" <b>"+COBJECT_CONTENT+":</b> "+content+'<span>');
        return html;
    } 
    
    this.buildToolBar = function(){
        var html = $('<div class="toolBar"></div>');
        html.append('<button id="nextPiece">'+ NEXT_PIECE +'</button>');
        return html;
    }
      
    this.buildInfo_PieceSet = function(){
        var description = self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].description;
        var html = $('<div class="pieceSetInfo"></div>');
        html.append('<span><b>'+description+'</b></span>');
        return html;
    } 
    
    this.isset = function (variable){
        return (variable !== undefined && variable !== null);
    }
   
       
}

