      var DomCobject = function(cobject){
            this.cobject = cobject;
            this.currentScreen = '';
            this.currentPieceSet = '';
            this.currentPiece = '';
            this.currentElement = '';
            this.domDefault = '<div class="render"></div>';
            this.html = '<div class="cobjects"></div>';
            this.domScreen = '';
            this.domPieceSet = '';
            this.domPiece = '';
            this.domElement = '';
            
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
               for (this.pos.screen = 0; i < this.cobject.screens.length; this.pos.screen++) {
                     self.id.screen = this.cobject.screens[this.pos.screen].id;
                     self.buildScreen(this.cobject.screens[this.pos.screen]);
               };
            }

            this.buildScreen = function(){
                  this.domScreen = '<div class="screen" id="S'+self.id.screen+'"></div>';
                  var piecesets_length = this.cobject.screens[this.pos.screen].piecesets.length;
                  for(this.pos.pieceset = 0; this.pos.pieceset < piecesets_length; this.pos.pieceset++) {
                     self.id.pieceset =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].id;
                     this.domScreen.append(this.buildPieceSet());
                  };
                  //eval('this.buildScreen_'+this.cobject.template);
            }
            
             this.buildPieceSet = function(){
                  this.domPieceSet = $('<div class="pieceset" id="'+self.id.pieceset+'"></div>');
                  var pieces_length =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces.length;
                  for(this.pos.piece = 0; this.pos.piece < pieces_length; this.pos.piece++) {
                     self.id.piece =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[this.pos.piece].id;
                     this.domPieceSet.append(this.buildPiece());
                  };
            }
            
            this.buildPiece = function(){
                  this.domPiece = $('<div class="piece currentPiece" id="'+self.id.piece+'"></div>');
                  var elements_length = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[this.pos.piece].elements.lenght;
                  for(this.pos.element = 0; this.pos.element < elements_length; this.pos.element++) {
                     self.id.element =  this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[this.pos.piece].elements[this.pos.element].id;
                     this.domPiece.append(this.buildElement());
                  };
            }
            
             this.buildElement = function(){
                  this.domElement = $('<div class="element" id="'+self.id.element+'"></div>');
                  var length = this.currentPiece.elements[this.pos.element].properties.length;


                  for(this.pos.elementProperties = 0; this.pos.elementProperties < length; this.pos.elementProperties++) {
                     this.domElement.append(this.buildElementHTML());
                  };
            }
            
            this.buildElementHTML = function(){
                
            }
            
            
      }

        


//      var templates{
//         screen:'<div></div>',
//         header: '',
//
//      }