/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

hashCode = function(str){
    var hash = 0;
    if (str.length == 0) return hash;
    for (i = 0; i < str.length; i++) {
        char1 = str.charCodeAt(i);
        hash = ((hash<<5)-hash)+char1;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}   
function render () {
    var html;
    this.actorName ='NENHUM';
    this.templateType;
    this.disciplineID;
    this.scriptID;
    this.classID;
    this.actorID;
    this.typeID;
    this.atdID;
    this.startTime;
    this.lastClick = -1;
    this.ctCorrect = 0;
    this.ctWrong = 0;
    this.pctLoad = 0;
    
    this.init = function(){
        $("#start").on('click',NEWRENDER.start);
    }
    this.progressbar = function(percent, $element) {
        if(percent > 100){
            percent = 100;
        }
        var progressBarWidth = percent * $element.width() / 100;
        progressBarWidth = Math.round(progressBarWidth);
        $element.find('div').animate({
            width: progressBarWidth
        }, 10).html(Math.round(percent) + "%&nbsp;");
    }
    this.messageload = function(title,text){
        $('#titleload').text(title);
        $('#msgload').html(text);
    }
    this.start = function(){
        $('.waiting').hide();
        $('.render').show();
        $('body').css('background','white');
        //requesição ajax do tipo start;
        //pega o usuário, consulta e ve onde parou e start do ponto, se não do começo
        $('.screen').first().fadeIn('slow');
        $('.screen').first().addClass('currentScreen');
    }
    this.ajaxrecursive = function(id,pos,json){
        var parent = this;
        $.ajax({
            url:"/render/loadcobject",
            data:{
                ID:id
            },
            type:"POST",
            dataType:"json",
            success:function(response){
                parent.pctLoad = parent.pctLoad+json.pctitem;
                parent.progressbar(parent.pctLoad, $('#progressBar'));
                parent.messageload("Carregando "+response.cobject_type+" "+id+"...",response.goal);
                parent.loadcobject(response);
                if(pos+1 >= json.size){
                    $('#msgload').hide();
                    parent.messageload("Concluido");
                    $("#start").show();
                }else{
                    parent.ajaxrecursive(json.ids[pos+1].id,pos+1,json);
                }
            },
            error:function(){
            }
        });
    }
    this.progresiveLoad = function(json,id){
        this.ajaxrecursive(json.ids[0].id,0,json);
    }
    this.mountHeader = function(cobject){
        infoScreen = $('<div class="screenInfo"></div>');
        infoScreen.append('<span id="infoAct"><label><strong>Aluno:</strong>'+this.actorName+' [Acertos:<span class="ctCorrect">0</span>/Erros:<span class="ctWrong">0</span>]</label><label><strong>Atividade: </strong>Nº'+cobject.cobject_id+'-'+cobject.template_code+'-'+cobject.theme+'</label><label><strong>Conteúdo: </strong> '+cobject.content+'</label><label><strong>Objetivo:</strong> '+cobject.goal+'</label></span>');
        nextScreen = $('<span id="next">»</span>').on('click',function(){
            $('.currentScreen').hide();
            $('.currentScreen').next().show();
            $('.currentScreen').removeClass('currentScreen').next().addClass('currentScreen');
            NEWRENDER.startTime = Math.round(+new Date()/1000);
        });
        prevScreen = $('<span id="previous">«</span>').on('click',function(){
            $('.currentScreen').hide();
            $('.currentScreen').prev().show();
            $('.currentScreen').removeClass('currentScreen').prev().addClass('currentScreen');
            NEWRENDER.startTime = Math.round(+new Date()/1000);
        });
        if(parent.atdID == "avaliacao"){
            prevScreen.hide();
            nextScreen.hide();     
        }
        infoScreen.append(nextScreen);
        infoScreen.prepend(prevScreen);
        infoScreen.append('<span class="clear"></span>');
        if($(".cobjects").text()==""){
            prevScreen.hide();
        }
        return infoScreen;
    }
    this.mountReportScreen = function(){
        htmlScreen = $('<div class="screen" id="SCRLAST"></div>');
        infoScreenl = $('<div class="screenInfo"></div>');
        infoScreenl.append('<span id="infoAct"></span>');
        prevScreenl = $('<span id="previous">«</span>').on('click',function(){
            $('.currentScreen').hide();
            $('.currentScreen').prev().show();
            $('.currentScreen').removeClass('currentScreen').prev().addClass('currentScreen');
        });
        if(parent.atdID == "avaliacao"){
            prevScreenl.hide();
        }
        infoScreenl.prepend(prevScreenl);
        infoScreenl.append('<span class="clear"></span>');
        htmlScreen.append(infoScreenl);
        htmlScreen.append('<strong>Aluno:</strong>'+response.userName+'(Acertos:<span class="ctCorrect">'+NEWRENDER.ctWrong+'</span>/Erros:<span class="ctWrong">'+NEWRENDER.ctCorrect+'</span>)<br/><input id="end" value="finalizar atendimento" type="button">');
        fullHtm.append(htmlScreen);
    }
    this.loadcobject = function(cobject){
        var parent = this;
        if(typeof(cobject.screens) != "undefined"){
            $.each(cobject.screens, function(i, screen) {
                htmScreen = $('<div class="screen" id="SCR'+screen.id+'"></div>');
                htmScreen.append(parent.mountHeader(cobject));
                if(typeof(screen.piecesets) != "undefined"){
                    htmScreen.append(parent.loadPiecesets(screen.piecesets,cobject.template_code));
                }
                $(".cobjects").append(htmScreen);
            });
        }
         
    }
    this.responseAnswer = function(){
        var sanswer = $(this).attr('uas');
        var useranswer = $(this).prev().val();
        uanswer = hashCode(useranswer);
        $('.currentScreen input.ielement').val("");
        if(NEWRENDER.atdID == "avaliacao"){
            $('.currentScreen input').attr('disabled','disabled');
            NEWRENDER.nextInFuction();
        }
        if(uanswer == sanswer){
            NEWRENDER.compute('correct',$(this),useranswer)
        }else{
            NEWRENDER.compute('wrong',$(this),useranswer);
        }
    }
    this.compute = function(type,element,value){
        NEWRENDER.showMessage(type);
        pieceID = element.parent().parent().parent().attr('id');
        elementID = element.attr('id');
        pieceID = pieceID.replace('BL_', '');
        elementID = elementID.replace('EP', '');
        var finaltime = Math.round(+new Date()/1000);
        if(type == 'correct'){
            NEWRENDER.ctCorrect = NEWRENDER.ctCorrect+1;
            $('.ctCorrect').text(NEWRENDER.ctCorrect);
            iscorrect = true;
        }else{
            NEWRENDER.ctWrong = NEWRENDER.ctWrong+1;
            $('.ctWrong').text(NEWRENDER.ctWrong);
            iscorrect = false;
        }
        $.ajax({
            url:"/render/compute",
            data:{
                pieceID:pieceID,
                elementID:elementID,
                actorID:NEWRENDER.actorID,
                finalTime:finaltime,
                startTime:NEWRENDER.startTime,
                isCorrect: iscorrect,
                value: value
            },
            type:"POST",
            dataType:"json"
        });
    }
    this.showMessage = function(type){
        if(type == 'correct'){
            msg = '<font id="message" class="messagebox messagecorrect">Parabéns, você acertou</font>';
        }else{
            msg = '<font id="message" class="messagebox messagewrong" style="">Oops! Você errou, continue tentando.</font>';
        }
        $('.currentScreen').prepend(msg);
        $('#message').fadeOut(3000,function(){
            $('#message').remove();
        });
    }
    this.nextInFuction = function(){
        nextScreen = $('<span id="nextButton">Avançar »</span>').on('click',function(){
            $('.currentScreen').hide();
            $('.currentScreen').next().show();
            $('.currentScreen').removeClass('currentScreen').next().addClass('currentScreen');
            NEWRENDER.startTime = Math.round(+new Date()/1000);
        });
        $('.currentScreen').append(nextScreen);
    }
    this.matchElement = function(){
        if(NEWRENDER.lastClick != -1){
            var group = $('#'+NEWRENDER.lastClick).attr('group');
            if(group == $(this).attr('group')){
                NEWRENDER.compute('correct',$(this),group);
            }else{
                NEWRENDER.compute('wrong',$(this),group);
            }
            if($(this).parent().parent().attr('id') != 'pairs'){
                $(this).off('click').addClass('delement').removeClass('ielement').parent().css('opacity','0.3');
            }
            var ID = $('#'+NEWRENDER.lastClick).parent().parent().attr('ID');
            $('.currentScreen .'+ID+' li').css('opacity','1');
            $('.currentScreen .'+ID+' .ielement').on('click',NEWRENDER.matchElement);
            if($(this).parent().parent().attr('id') == 'pairs'){
                $('#'+NEWRENDER.lastClick).css('border','none').off('click').addClass('delement').removeClass('ielement').parent().css('opacity','0.3');
            }
            NEWRENDER.lastClick = -1;
            alert($('.currentScreen #groups .ielement').length);
            if($('.currentScreen #groups .ielement').length == 0){
                //reinicializar.
                $('.currentScreen #pairs .ielement').off('click').addClass('delement').removeClass('ielement').parent().css('opacity','0.3');
                if(NEWRENDER.atdID == "avaliacao"){
                    NEWRENDER.nextInFuction();
                }else{
                    $('.currentScreen li').css('opacity','1');
                    $('.currentScreen .delement').addClass('ielement').removeClass('delement');
                    $('.currentScreen .ielement,.currentScreen .delement').on('click',NEWRENDER.matchElement).css('opacity','1');
                }
            }
        }else{
            var classID = $(this).parent().parent().attr('ID');
            $('.currentScreen .'+classID+' li').css('opacity','0.3');
            $(this).parent().css('opacity','0.9');
            $('.currentScreen .'+classID+' .ielement').css('border','none');
            $('.currentScreen .'+classID+' .ielement').off('click');
            $(this).css('border','1px dotted #000');
            NEWRENDER.lastClick = $(this).attr('ID');
        }
    }
    this.correctAnswer =  function(){
        $(this).off('click').css('cursor','auto');
        $(this).css('opacity','0.5');
        NEWRENDER.compute('correct',$(this),$(this).attr('id'));
        if(NEWRENDER.atdID == "avaliacao"){
            $('.currentScreen .eclick').off('click').css('cursor','auto');
            NEWRENDER.nextInFuction();
        }
    }
    this.wrongAnswer = function(){
        $(this).off('click').css('cursor','auto');
        $(this).css('opacity','0.5');
        NEWRENDER.compute('wrong',$(this),$(this).attr('id'));
        if(NEWRENDER.atdID == "avaliacao"){
            $('.currentScreen .eclick').off('click').css('opacity','0.5').css('cursor','auto');
            NEWRENDER.nextInFuction();
        }
        
    }
    
    this.loadScreens = function(screens,template){
        var parent = this;
        htmScreens =  $('<div class="screens"></div>');
        $.each(screens, function(i, screen) {
            htmScreen = $('<div class="screen" id="SCR'+screen.ID+'"></div>');
            if(typeof(screen.piecesets) != "undefined"){
                htmScreen.append(parent.loadPiecesets(screen.piecesets,template));
            }
            htmScreens.append(htmScreen);
        });
        return htmScreens;
    };
                
    this.loadPiecesets = function(piecesets,template){
        var parent = this;
        htmPiecesets = $('<div class="piecesets"></div>');
        $.each(piecesets, function(i, pieceset) {
            htmPieceset = $('<div id="PCSET'+pieceset.id+'" class="pieceset"><h5>'+pieceset.description+'</h5></div>');
            if(typeof(pieceset.pieces) != "undefined"){
                htmPieceset.append(parent.loadPieces(pieceset.pieces,template));
            }
            htmPiecesets.append(htmPieceset);
        });
        return htmPiecesets;
    };
                
    this.loadPieces = function(pieces,template){
        var parent = this;
        htmPieces = $('<div class="pieces"></div>');
        $.each(pieces, function(i, piece) {
            if(typeof(piece.elements) != "undefined"){
                htmPiece = $('<div id="PIECE'+piece.id+'" class="piece"><h6>'+piece.oldID+'('+template+')</h6></div>');
                htmPiece.append(parent.loadElements(piece.elements,template,piece.id));
                htmPieces.append(htmPiece);
            }
        });
        return htmPieces;
    };
    
    this.loadElements = function(elements,template,pieceID){
        var parent = this;
        htmFinal = $('<div id="BL_'+pieceID+'" class="blockElements"></div>');
        switch (template){
            case 'MTE':
                htmEnum = $('<ul class="elements enum"></ul>');
                htmOptions = $('<ul class="elements options"></ul>')
                break;
            case 'PRE':
                htmEnum = $('<ul class="elements enum"></ul>');
                htmOptions = $('<ul class="elements options"></ul>')
                break;
            case 'AEL':
                htmPair = $('<ul id="pairs" class="elements pairs"></ul>');
                htmGroup = $('<ul id="groups" class="elements groups"></ul>')
                break;
        }
        $.each(elements, function(i, element) {
            blockElement = $('<li class="element"></li>');
            switch (element.type){
                case 'multimidia':
                    switch(element.typemulti){
                        case 'image':
                            htmElement = $('<img src="none.jpg"/>');
                            break;
                        case 'sound':
                            blockElement.prepend('<font style="display:block;font-size:9px;">Clique no icone de play para escuta as instruções</font>');
                            htmElement = $('<audio controls="controls"></audio>');
                            break;
                    }
                    break;
                case 'phrase':
                    htmElement = $('<font></font>');
                    break;
                case 'word':
                    htmElement = $('<font></font>');
                    break;
                case 'number':
                    htmElement = $('<font></font>');
                    break;
                case 'paragraph':
                    htmElement = $('<font></font>');
                    break; 
                case 'text':
                    htmElement = $('<font></font>');
                    break;
            }
            htmElement.addClass('ielement');
            if(typeof(element.events) != "undefined"){
                $.each(element.events, function(i, event) {
                    htmElement.on(String(event.event),eval(String(event.action)));
                });
            }
            if(typeof(element.generalProperties) != "undefined"){
                $.each(element.generalProperties, function(i, gproperty) {
                    htmElement.attr('ID',element.code);
                    if(gproperty.name == 'text'){
                        htmElement.text(gproperty.value);
                    }else if(gproperty.name == 'src'){
                        if(element.typemulti == 'sound'){
                            htm = $('<source/>');
                            htm.attr('src','/rsc/library/sound/'+gproperty.value);
                            htmElement.append(htm);
                        }else{
                            htmElement.attr(gproperty.name,'/rsc/library/images/'+gproperty.value);
                        }
                    }else{
                        htmElement.attr(gproperty.name,gproperty.value);
                    }
                });
            }
            if(typeof(element.elementProperties) != "undefined"){
                $.each(element.elementProperties, function(i, property) {
                    switch (property.name){
                        case 'group':
                            htmElement.attr(property.name,property.value);
                            break;
                        case 'font-size':
                            htmElement.css(property.name,property.value);
                            break;
                        case 'cursor':
                            htmElement.css(property.name,property.value);
                            break;
                        case 'width':
                            //htmElement.css(property.name,property.value);
                            break;
                        case 'height':
                            //htmElement.css(property.name,property.value);
                            break;    
                        case 'posx':
                            //htmElement.css('position','absolute');
                            htmElement.css('left',property.value+'px');
                            break;
                        case 'posy':
                            //htmElement.css('position','absolute');
                            htmElement.css('top',property.value+'px');
                            break;
                        case 'drag':
                            htmElement.draggable({
                                grid: [50, 20],
                                helper: "clone",
                                opacity: 0.35,
                                revert: 'invalid',
                                snap: true,
                                start: function(event, ui) {
                                    $(this).css('border','1px dashed');
                                    $(this).html('');
                                },
                                stop: function(event, ui) {
                                    $(this).css('border','1px solid');
                                    $(this).html($(ui.helper).html());
                                }
                            });
                            blockElement.append(htmElement);
                            htmDrag.append(blockElement);
                            break;
                        case 'drop':
                            htmElement.droppable({
                                drop: function(event, ui) {
                                    eval(String(property.value));
                                    alert($(ui.draggable).attr('ID'));
                                    $(ui.draggable).replaceWith('').css('border','1px dashed').draggable( "option", "disabled" );
                                    $(this).droppable("option", "disabled",true);
                                    $(this).remove();
                                    $(this).css('border-color', 'green');
                                }
                            });
                            blockElement.append(htmElement);
                            htmDrop.append(blockElement);
                            break;
                    }
                });
                $.each(element.elementProperties, function(i, property) {
                    if(property.name == 'layertype'){
                        switch(property.value){
                            case 'Modelo':
                                switch (template){
                                    case 'MTE':
                                        htmEnum.append(blockElement.append(htmElement));
                                        break;
                                    case 'PRE':
                                        htmEnum.append(blockElement.append(htmElement));
                                        break;
                                    case 'AEL':
                                        htmElement.addClass('pclick');
                                        htmElement.on('click',parent.matchElement);
                                        htmPair.append(blockElement.append(htmElement));
                                        break;
                                }
                                break;
                            case 'Acerto':
                                switch (template){
                                    case 'MTE':
                                        htmElement.addClass('eclick');
                                        htmElement.on('click',parent.correctAnswer);
                                        htmOptions.append(blockElement.append(htmElement));
                                        break;
                                    case 'PRE':
                                        var inputElement = $("<input type='text'/>");
                                        var inputButton = $("<input class='ok' type='button' value='OK'/>");
                                        inputButton.on('click',parent.responseAnswer);
                                        var attrs = htmElement.prop("attributes");
                                        inputButton.attr('uas',hashCode(htmElement.text()));
                                        $.each(attrs, function() {
                                            inputElement.attr(this.name, this.value);
                                        });
                                        inputButton.attr('id',inputElement.attr('id'));
                                        htmElement.text("");
                                        htmElement.append(inputElement);
                                        htmElement.append(inputButton);
                                        htmOptions.append(blockElement.append(inputElement).append(inputButton));
                                        break;
                                    case 'AEL':
                                        htmElement.addClass('gclick');
                                        htmElement.on('click',parent.matchElement);
                                        htmGroup.append(blockElement.append(htmElement));
                                        break;
                                }
                                break;
                            case 'Erro':
                                switch (template){
                                    case 'MTE':
                                        htmElement.addClass('eclick');
                                        htmElement.on('click',parent.wrongAnswer);
                                        htmOptions.append(blockElement.append(htmElement));
                                        break;
                                    case 'PRE':
                                        htmElement.addClass('eclick');
                                        htmElement.on('click',parent.wrongAnswer);
                                        htmOptions.append(blockElement.append(htmElement));
                                        break;
                                    case 'AEL':
                                        htmElement.addClass('eclick');
                                        htmElement.on('click',parent.wrongAnswer);
                                        htmGroup.append(blockElement.append(htmElement));
                                        break;
                                }
                                break;    
                        }
                    }
                });
            }
        });
        switch (template){
            case 'MTE':
                htmFinal.append(htmEnum);
                htmFinal.append(htmOptions);
                break;
            case 'PRE':
                htmFinal.append(htmEnum);
                htmFinal.append(htmOptions);
                break;
            case 'AEL':
                htmPair2 = $('<ul id="pairs" class="elements pairs"></ul>');
                htmGroup2 = $('<ul id="groups" class="elements groups"></ul>');
                htmPair2.append(htmPair.find('li').sort(function(){
                    return Math.round(Math.random())-0.5;
                }));
                htmGroup2.append(htmGroup.find('li').sort(function(){
                    return Math.round(Math.random())-0.5;
                }))
                htmFinal.append(htmPair2.append('<li style="clear:both;display:block"></li>'));
                htmFinal.append(htmGroup2.append('<li style="clear:both;display:block"></li>'));
                break;
        }
        return htmFinal.append('<span style="display:block;clear:both"></span>');
    };
}
