      var DomCobject = function(cobject){
            this.cobject = cobject;
            this.currentScreen = '';
            this.currentPieceSet = '';
            this.currentPiece = '';
            this.currentElement = '';
            this.domDefault = '<div class="render"></div>';
            this.domCobject = '<div class="cobjects"></div>';
            this.domScreen = '';
            this.domPieceSet = '';
            this.domPiece = '';
            this.domElement = '';
            
            this.pos = {
               screen:0,
               pieceset:0,
               piece:0,
               element:0,
               elementProperties:0
            }
            this.build = function(){
               for (this.pos.screen = 0; i < this.cobject.screens.length; this.pos.screen++) {
                  this.domCobject.append(this.buildScreen());
               };

            }

            this.buildScreen = function(){
                  this.domScreen = '<div class="screen currentScreen" id="'+this.cobject.screens[this.pos.screen].id+'"></div>';
                  var length = this.cobject.screens[this.pos.screen].piecesets.length;
                  for(this.pos.pieceset = 0; this.pos.pieceset < length; this.pos.pieceset++) {
                    // Things[i]
                     this.domScreen.append(this.buildPieceSet());
                  };
                  
            }
            
             this.buildPieceSet = function(){
                  this.currentScreen =  this.cobject.screens[this.pos.screen];
                  this.domPieceSet = $('<div class="pieceSet currentPieceSet" id="'+this.currentScreen.pieceSets[this.pos.pieceset].id+'"></div>');
                  var length = currentScreen.pieceSets[this.pos.pieceset].pieces.length;
                  for(this.pos.piece = 0; this.pos.piece < length; this.pos.piece++) {
                    // Things[i]
                     this.domPieceSet.append(this.buildPiece());
                  };
            }
            
            this.buildPiece = function(){
                  this.currentPieceSet = this.currentScreen.pieceSets[this.pos.pieceset];
                  this.domPiece = $('<div class="piece currentPiece" id="'+this.currentPieceSet.pieces[this.pos.piece].id+'"></div>');
                  var length = this.currentPieceSet.pieces[this.pos.piece].elements.length;
                  for(this.pos.element = 0; this.pos.element < length; this.pos.element++) {
                    // Things[i]
                     this.domPiece.append(this.buildElement());
                  };
            }
            
             this.buildElement = function(){
                  this.currentPiece = this.currentPieceSet.pieces[this.pos.piece];
                  this.domElement = $('<div class="element currentElement" id="'+this.currentPiece.elements[this.pos.element].id+'"></div>');
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