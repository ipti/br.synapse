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
            var self = this;

            this.pos = {
               screen:0,
               pieceset:0,
               piece:0,
               element:0,
            }
            this.id = {
               screen:0,
               pieceset:0,
               piece:0,
               element:0,
            }

            this.buildAll = function(){
               for (this.pos.screen = 0; this.pos.screen < this.cobject.screens.length; this.pos.screen++) {
                     self.id.screen = this.cobject.screens[this.pos.screen].id;
                     self.dom.append(self.buildScreen());
               };
               return self.dom;
            }

            this.buildScreen = function(){
                  self.domScreen = $('<div class="screen" id="S'+self.id.screen+'"></div>');
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
                        
                   var elements_length = elements_group.elements.length;
                   console.log(elements_group);
                // console.log(self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].elements);
                   for(self.pos.element = 0; self.pos.element < elements_length; self.pos.element++) {
                       self.id.element =  elements_group.elements[self.pos.element].elementID;
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
                self.domElement = $('<li class="element" id="'+self.id.element+'"><span>'+self.id.element+'</span></li>');
                return self.domElement;
            }
            
            this.buildElement_PRE = function(){
            }
            
            this.buildElement_TXT = function(){
            }
            
            
           
      }

