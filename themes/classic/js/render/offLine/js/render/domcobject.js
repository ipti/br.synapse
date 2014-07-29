COBJECT_GOAL = "Goal";
COBJECT_TYPE = "Type";
COBJECT_DEGREE_NAME = "Degree Name";
COBJECT_DISCIPLINE = "Discipline";
COBJECT_CONTENT = "Content";
//Label Buttons
NEXT_PIECE = '<img class="answer-ok" src="img/icons/ok.png">';
NEXT_SCREEN = "Próxima Tela >>>>>";
BEGIN_ACTIVITY = "Iniciar Atividade";

var DomCobject = function(cobject, idx) {
    this.cobject = cobject;
    this.idx = idx;
    this.currentScreen = '';
    this.currentPieceSet = '';
    this.currentPiece = '';
    this.currentElement = '';
    this.domCobject = '';
    this.currentElementType = '';

    this.dom = $('<div class="cobject ' + this.cobject.template_code + '" style="display:none" id=' + this.cobject.cobject_id + '></div>');


    this.domContent = $('<div class="content"></div>');
    this.domScreen = '';
    this.domPieceSet = '';
    this.domPiece = '';
    this.domElement = '';
    this.dirLibrary = 'data/library';
    var self = this;
    //Armazenar Árvore de Peças
    //var pieces, 
    this.mainPieces = new Array();
    //==========================

    this.pos = {
        screen: 0,
        pieceset: 0,
        elementPS: 0,
        piece: 0,
        group: 0,
        element: 0
    }
    this.id = {
        screen: 0,
        pieceset: 0,
        elementPS: 0,
        piece: 0,
        element: 0
    }

    this.buildAll = function() {
        self.dom.append(self.buildInfo_Cobject);
        self.dom.append(self.domContent);
        
        for (this.pos.screen = 0; this.pos.screen < this.cobject.screens.length; this.pos.screen++) {
            self.id.screen = this.cobject.screens[this.pos.screen].id;
            self.domContent.append(self.buildScreen());
        }
        return self.dom;
    }

    this.buildScreen = function() {
        self.domScreen = $('<div class="T_screen" style="display:none" id="S' + self.id.screen + '"></div>');

        var piecesets_length = this.cobject.screens[this.pos.screen].piecesets.length;
        for (this.pos.pieceset = 0; this.pos.pieceset < piecesets_length; this.pos.pieceset++) {
            self.id.pieceset = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].id;
            if (self.cobject.template_code == 'TXT') {
                self.id.piece = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[0].id;
                self.domScreen.append(this.buildRightBook());
            } else {
                self.domScreen.append(this.buildPieceSet());
            }
        }
        ;
        return self.domScreen;
    }

    this.buildRightBook = function() {
        self.pos.group = 1;
        self.domPieceSet = $('<div class="pieceset book" style="display:none" id="' + self.id.pieceset + '"></div>');
        self.domPiece = $('<div class="piece" style="display:none" id="' + self.id.piece + '"></div>');
        var fd = $('<div class="book-right"></div>');
        var elements_group = self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups[self.pos.group];
        for (self.pos.element = 0; self.pos.element < elements_group.elements.length; self.pos.element++) {
            self.id.element = elements_group.elements[self.pos.element].id;
            self.domPiece.append(self.buildElement());
        }
        fd.append(self.domPiece);
        self.domPieceSet.append(fd);
        self.domPieceSet.prepend(self.buildInfo_PieceSet());
        return self.domPieceSet;
    }

    this.buildPieceSet = function() {
        self.domPieceSet = $('<div class="pieceset" style="display:none" id="' + self.id.pieceset + '"></div>');
        self.domPieceSet.append(self.buildInfo_PieceSet());
        var fd = $('<fieldset class="answer-container"></fieldset>');
        var pieces_length = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces.length;

        //Construir os pieces desta pieceSet
        for (this.pos.piece = 0; this.pos.piece < pieces_length; this.pos.piece++) {
            self.id.piece = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].pieces[this.pos.piece].id;
            fd.append(this.buildPiece());
        }
        ;
        self.domPieceSet.append(fd);
        return self.domPieceSet;
    }

    this.buildPiece = function() {
        self.domPiece = $('<div class="piece" style="display:none" id="' + self.id.piece + '"></div>');
        var domElementASK = $('<div class="ask"></div>');
        //Verificar se é uma peça do template AEL
        if (self.cobject.template_code == 'AEL' || self.cobject.template_code == 'DDROP') {
            var domElementANSWER = $('<div class="answer"></div>');
        }

        var groups = self.cobject.screens[this.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups;

        var objGroups_currentPiece = {};
        $.each(groups, function(current_group, elements_group) {
            self.pos.group = current_group; // O grupo Corrent dessa Piece!

            //array que armazena todos os objetos grupos da piece atual
            var group_split = current_group.split('_');
            // ASK = Múltiplo de 2 ; ANSWER = Múltiplo de 3
            var newIdGroup = (group_split[1] === undefined) ? (self.id.piece * (group_split[0])) * 2 : (self.id.piece * (group_split[0])) * 3 + '_1';
            eval("objGroups_currentPiece._" + newIdGroup + " = elements_group;");
            var domTypeGroup = "";
            var domGroup = "";
            var isAskGroup = current_group.split('_').length == 1;
            if (isAskGroup) {
                //is ASK-GROUP
                domTypeGroup = domElementASK;
            } else {
                // is ANSWER-GROUP
                domTypeGroup = domElementANSWER;
            }
            var possibleGroup = domTypeGroup.find('div[group="' + newIdGroup + '"]');
            var isNewGroup = (possibleGroup.size() == 0);

            if (isNewGroup) {
                // Novo Grupo
                domGroup = $('<div group="' + newIdGroup + '" class="' + self.cobject.template_code + ' group" ></div>');
                //Add class drop somente se for um group Ask
                if(self.cobject.template_code == 'DDROP') {
                    if(isAskGroup){
                        domGroup.addClass('drag');
                    }else{
                        // is ANSWER-GROUP
                        domGroup.addClass('drop');
                    }
                    
                }
            } else{
                //Grupo existente
                domGroup = possibleGroup;
            }

            var elements_length = elements_group.elements.length;
            var order_type_elements = new Array();
            //PErcorrer Elementos do grupo Corrent
            for (self.pos.element = 0; self.pos.element < elements_length; self.pos.element++) {
                self.id.element = elements_group.elements[self.pos.element].id;
                var element = self.buildElement();
                if(order_type_elements.length == 0){
                    order_type_elements[self.currentElementType] = new Array();
                    order_type_elements[self.currentElementType].push(element);
                }else{
                    //Existe pelo menos Um
                    if(self.isset(order_type_elements[self.currentElementType])){
                        //Push neste
                        order_type_elements[self.currentElementType].push(element);
                    }else{
                        //É um novo
                        order_type_elements[self.currentElementType] = new Array();
                        order_type_elements[self.currentElementType].push(element);
                    }
                }
                domGroup.addClass(self.currentElementType);
            }
            
            //Agora apenda os elementos do grupo acima em ordem: imagem - som - texto
            if(self.isset(order_type_elements['build_image'])){
                //Apenda As Imagens
                $.each(order_type_elements['build_image'], function(idx, element){
                    domGroup.append(element);
                });
            }
            if(self.isset(order_type_elements['build_sound'])){
                //Apenda Os Sons
                $.each(order_type_elements['build_sound'], function(idx, element){
                    domGroup.append(element);
                });
            }
            if(self.isset(order_type_elements['build_text'])){
                //Apenda os Textos
                $.each(order_type_elements['build_text'], function(idx, element){
                    domGroup.append(element);
                });
            }
            if (isNewGroup){
                //Se for um novo Grupo, então add o novo
                domTypeGroup.append(domGroup);
            }
            
        });
        //Armazena todos os grupos de cada peça
        objGroups_currentPiece.istrue = null;
        self.mainPieces[self.id.piece] = objGroups_currentPiece;
        self.domPiece.append(domElementASK);
        if (self.cobject.template_code == 'AEL' || self.cobject.template_code == 'DDROP') {
            self.domPiece.append(domElementANSWER);
        }

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

    this.buildEnum = function() {
        self.domEnum = $('<div class="enunciation"></div>');
        eval("self.buildEnum_" + self.cobject.template_code + "();");
    }

    this.buildElement = function() {
        return eval("self.buildElement_" + cobject.template_code + "();");
    }

    this.buildElementPS = function() {
        var isElement_PieceSet = true;
        return self.buildElement_AEL(isElement_PieceSet);
    }

    this.buildElement_MTE = function() {
        return self.buildElement_AEL();
    }
    this.buildElement_DDROP = function() {
        return self.buildElement_AEL();
    }
    
//    this.buildElement_ = function() {
//        return self.buildElement_AEL();
//    }

    this.buildElement_AEL = function(isElement_PieceSet) {
        var html = "";
        var elementID = 0;
        if (self.isset(isElement_PieceSet) && isElement_PieceSet) {
            //É um elemento da PieceSet
            elementID = self.id.elementPS;
            var currentElement = self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].elements[self.pos.elementPS];
        } else {
            elementID = self.id.element;
            var currentElement = self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups[self.pos.group].elements[self.pos.element];
        }
        var strBuild_library_type = "";
        if (currentElement.type == 'multimidia') {
            var properties = "var properties = {";
            $.each(currentElement.generalProperties, function(i, item) {
                if (item['name'] == 'library_type') {
                    strBuild_library_type = "build_" + item['value'];
                } else {
                    properties += "'" + item['name'] + "':'" + item['value'] + "',";
                }
            });
            properties += "};";

            html += eval('self.' + strBuild_library_type + '("' + properties + '");');

        } else if (currentElement.type == 'text') {
            strBuild_library_type = 'build_text';
            var properties = "var properties = {";
            $.each(currentElement.generalProperties, function(i, item) {
                properties += "'" + item['name'] + "':'" + item['value'] + "',";
            });
            properties += "};";
            html += self.build_text(properties);
        }
        self.currentElementType = strBuild_library_type;
        self.domElement = $('<li class="element element-' + strBuild_library_type + '" id="' + elementID + '">' + html + '</li>');
        return self.domElement;
    }

    this.buildElement_PRE = function() {
        var html_Answer = "<input type='text' class='text' autocomplete='off'>";
        return html_Answer;
    }

    this.buildElement_TXT = function() {
        var TXT = $("<p class='element TXT'></p>");
        var elements_group = self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].pieces[self.pos.piece].groups[self.pos.group];
        //BUSCAR PROPRIEDADE  = TEXT
        var idxText = null;
        for (var i = 0; i < elements_group.elements[0].generalProperties.length; i++) {
            if (elements_group.elements[0].generalProperties[i].name == 'text') {
                idxText = i;
                break;
            }
        }
        TXT.append(elements_group.elements[0].generalProperties[idxText].value);
        return TXT;
    }

    // Type Text
    this.build_text = function(properties) {
        //Properties : extension, src, width, height
        eval(properties);
        var text = properties['text'];
        var language = properties['language'];
        var html = '<span class="elementText">\n\
                    ' + text + '</span>';
        return html;
    }

    // Type of Elements
    this.build_image = function(properties) {
        //Properties : extension, src, width, height
        eval(properties);
        var src = self.dirLibrary + '/image/' + properties['src'];
        var extension = properties['extension'];
        var library_id = properties['library_id'];
        var width = properties['width'];
        var height = properties['height'];
        var html = '<span class="elementImage"  library_id=' + library_id + ' >\n\
                 <img src="' + src + '"></img></span>';
        return html;
    }

    this.build_sound = function(properties) {
        //Properties : extension, src
        eval(properties);
        var src = self.dirLibrary + '/sound/' + properties['src'];
        var extension = properties['extension'];
        var library_id = properties['library_id'];
        var html = '<img class="soundIconPause" src="img/icons/play.png"></img><span class="elementSound" library_id=' + library_id + '> \n\
                 <audio controls="controls" preload="preload" title="Titulo" src="' + src + '"></audio></span>';

        return html;
    }

    this.build_txt = function(properties) {
        //Properties : extension, src
        eval(properties);
        var src = self.dirLibrary + '/sound/' + properties['src'];
        var extension = properties['extension'];
        var library_id = properties['library_id'];
        var html = '<span class="elementSound" library_id=' + library_id + '> \n\
                 <audio controls="controls" preload="preload" title="Titulo"> \n\
                 <source src="' + src + '"> ' + 'ERROR_BROWSER_SUPORT' + ' </audio></span>';

        return html;
    }


    this.buildEnum_MTE = function() {

    }
    this.buildEnum_AEL = function() {

    }
    this.buildEnum_TXT = function() {

    }
    this.buildEnum_PRE = function() {

    }



    this.buildInfo_MEET = function() {

    }

    this.buildInfo_Cobject = function() {
        var goal = self.cobject.goal;
        var type = self.cobject.cobject_type;
        var degree_name = self.cobject.degree_name;
        var discipline = self.cobject.discipline;
        var content = self.cobject.content;
        var html = $('<div class="cobjectInfo"></div>');
        html.append('<span><b>' + COBJECT_GOAL + ":</b> " + goal + " <b>" + COBJECT_TYPE + ":</b> " + type + " <br><b>" + COBJECT_DEGREE_NAME + ":</b> " + degree_name +
            " <b>" + COBJECT_DISCIPLINE + ":</b> " + discipline + " <b>" + COBJECT_CONTENT + ":</b> " + content + '<span>');
        return html;
    }

    

    this.buildInfo_PieceSet = function() {
        var description = self.cobject.screens[self.pos.screen].piecesets[self.pos.pieceset].description;
        if (self.cobject.template_code == 'TXT') {
            var html = $('<div class="book-left"></div>');
        } else {
            var html = $('<div class="pieceSetInfo question-container"></div>');
        }
        if (self.isset(this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].elements)) {
            var elementPS_length = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].elements.length;
            //Construir os elementos dessa PieceSet
            for (this.pos.elementPS = 0; this.pos.elementPS < elementPS_length; this.pos.elementPS++) {
                self.id.elementPS = this.cobject.screens[this.pos.screen].piecesets[this.pos.pieceset].elements[this.pos.elementPS].id;
                html.append(self.buildElementPS());
                html.addClass(self.currentElementType);
            }
        }
        if (description !== undefined && description !== null) {
            html.addClass('build_text');
            html.append('<li class="element-question"><h1 class="question-title">' + description + '</h1></li>');
        }
        return html;
    }

    this.isset = function(variable) {
        return (variable !== undefined && variable !== null);
    }


}

