var DomCobject = function(cobject){
    this.cobject = cobject;
    this.currentScreen = '';
    this.currentPieceSet = '';
    this.currentPiece = '';
    this.currentElement = '';
    this.domDefault = '<div class="render"></div>';
    this.dom = $('<div class="cobjects"></div>');
    this.domScreen = '';
    this.domPieceSet = '';
    this.domPiece = '';
    this.domElement = '';
    this.dirLibrary = '/rsc/library';
    var self = this;

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
        for (this.pos.screen = 0; this.pos.screen < this.cobject.screens.length; this.pos.screen++) {
            self.id.screen = this.cobject.screens[this.pos.screen].id;
            self.dom.append(self.buildScreen());
        };
        return self.dom;
    }

    this.buildScreen = function(){
        self.domScreen = $('<div class="T_screen" id="S'+self.id.screen+'"></div>');
        var piecesets_length = this.cobject.screens[this.pos.screen].piecesets.length;
        for(this.pos.pieceset = 0; this.pos.pieceset < piecesets_length; this.pos.pieceset++) {
            self.id.pieceset =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].id;
            self.domScreen.append(this.buildPieceSet());
        };
        return self.domScreen;
        //eval('this.buildScreen_'+this.cobject.template);
    }
            
    this.buildPieceSet = function(){
        self.domPieceSet = $('<div class="pieceset" id="'+self.id.pieceset+'"></div>');
        var pieces_length =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces.length;
        for(this.pos.piece = 0; this.pos.piece < pieces_length; this.pos.piece++) {
            self.id.piece =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[this.pos.piece].id;
            self.domPieceSet.append(this.buildPiece());
        };
        return self.domPieceSet;
    }
            
    this.buildPiece = function(){
        self.domPiece = $('<div class="piece" id="'+self.id.piece+'"></div>');
        //self.domPiece.append(self.buildEnum());
        // var elements_length = self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].elements.length;
        // console.log(self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].elements);
        //                 for(self.pos.element = 0; self.pos.element < elements_length; self.pos.element++) {
        //                     self.id.element =  self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].elements[self.pos.element].elementID;
        //                     self.domPiece.append(self.buildElement());
        //                  };
        var groups = self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups;
        $.each(groups, function(current_group, elements_group){
            self.pos.group =current_group; // O grupo Corrent dessa Piece !
            var elements_length = elements_group.elements.length;
            for(self.pos.element = 0; self.pos.element < elements_length; self.pos.element++) {
                self.id.element =  elements_group.elements[self.pos.element].id;
                self.domPiece.append(self.buildElement());
            };
                        
        });
                    
                    
                    
        return self.domPiece;
    }

    this.buildEnum = function(){
        self.domEnum = $('<div class="enunciation"></div>');
        eval("self.buildEnum_"+cobject.template_code+"();");
    }
            
    this.buildElement = function(){
        return eval("self.buildElement_"+cobject.template_code+"();");
    }

    this.buildEnum_MTE = function(){
        //self.domEnum
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
                    //console.log(properties);
                }
            });
            properties+="};";
            
            html+= eval('self.'+strBuild_library_type+'("'+properties+'");');
            
        }else if(currentElement.type == 'text'){
            var strBuild_text = "";
            var properties = "var properties = {";
            $.each(currentElement.generalProperties, function(i,item){
                properties+= "'"+item['name'] +"':'"+ item['value']+"',";
                //console.log(properties);
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
           
}

