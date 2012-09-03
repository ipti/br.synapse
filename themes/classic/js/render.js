/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function corretAnswer(){
    $('.currentScreen').next().prepend('<font id="message" style="margin:10px auto;width:95%;display:block;padding:10px;background:green;color:#fff">Parabéns, você acertou</font>');
    $('.currentScreen').hide();$('.currentScreen').next().show();$('.currentScreen').removeClass('currentScreen').next().addClass('currentScreen');
    $('#message').fadeOut(3000,function(){$('#message').remove();});
    //ajax pra atualizar desempenho.
}
function wrongAnswer(){
    $('.currentScreen').next().prepend('<font id="message" style="margin:10px auto;width:95%;display:block;padding:10px;background:red;color:#fff">Oops! Você errou, continue tentando.</font>');
    $('.currentScreen').hide();$('.currentScreen').next().show();$('.currentScreen').removeClass('currentScreen').next().addClass('currentScreen');
    $('#message').fadeOut(3000,function(){$('#message').remove();});
    
    //ajax pra atualizar desempenho.
}
            
function render () {
    var html;
    this.templateType;
    this.disciplineID;
    this.scriptID;
    this.startRender = function (response){
        if(typeof(response.disciplines) != "undefined"){
            this.loadDisciplines(response.disciplines);
        }
        if(typeof(response.classes) != "undefined"){
            this.loadClasses(response.classes);
        }
    }
    this.loadDisciplines = function(disciplines){
        htmContent = $('<select id="rdiscipline"></select>');
        $.each(disciplines, function(i, discipline) {
            htmContent.append('<option value="'+discipline.ID+'">'+discipline.name+'</option>');
            if(typeof(discipline.scripts) != "undefined"){
                htmScript = $('<select class="rscripts" id="rscript'+discipline.ID+'"></select>');
                $.each(discipline.scripts, function(i, script) {
                    htmScript.append('<option value="'+script.ID+'">'+script.name+'</option>');
                });
                $('#rscript').append(htmScript);
            }
        });
        $('#rdiscipline').append(htmContent);
    }
    this.loadClasses = function(classes){
        htmContent = $('<select id="rclassys"></select>').change(function(){
            $('.students,.tutors').hide();
            v = $("select#rclassys").val();
            $('#student'+v+','+'#tutor'+v).show();
        });
        $.each(classes, function(i, classy) {
            htmContent.append('<option value="'+classy.ID+'">'+classy.name+'</option>');
            if(typeof(classy.students) != "undefined"){
                htmStudent = $('<select class="students" id="student'+classy.ID+'"></select>');
                $.each(classy.students, function(i, student) {
                    htmStudent.append('<option value="'+student.ID+'">'+student.name+'</option>');
                });
                $('#rstudents').append(htmStudent);
            }
            if(typeof(classy.tutors) != "undefined"){
                htmTutor = $('<select class="tutors" id="tutor'+classy.ID+'"></select>');
                $.each(classy.tutors, function(i, tutor) {
                    htmTutor.append('<option value="'+tutor.ID+'">'+tutor.name+'</option>');
                });
                $('#rtutors').append(htmTutor);
            }
        });
        $('#rclasses').append(htmContent);
    }
    this.loadJson = function(response){
        if(typeof(response.contents) != "undefined"){
            $(".activities").html(this.loadContents(response.contents));
        }
    }
    this.loadJson2 = function(response){
        var parent = this;
        var fullHtm = $('<div id="paginate"></div>');
        if(typeof(response.contents) != "undefined"){
            $.each(response.contents, function(i, content) {
                content.ID;
                content.description;
                if(typeof(content.goals) != "undefined"){
                    $.each(content.goals, function(i, goal) {
                        goal.ID;
                        goal.name;
                        if(typeof(goal.cobjects) != "undefined"){
                            $.each(goal.cobjects, function(i, cobject) {
                                cobject.ID;
                                if(typeof(cobject.screens) != "undefined"){
                                    $.each(cobject.screens, function(i, screen) {
                                        htmScreen = $('<div class="screen" id="SCR'+screen.ID+'"></div>');
                                        infoScreen = $('<div class="screenInfo"></div>');
                                        infoScreen.append('<span id="infoAct"><label><strong>Atividade:</strong>Nº'+cobject.oldID+'-'+cobject.template_code+'-'+cobject.theme+'</label><label><strong>Conteúdo:</strong> '+content.description+'</label><label><strong>Objetivo:</strong> '+goal.name+'</label><label><strong>Tela:</strong> '+screen.ID+'</label></span>');
                                        nextScreen = $('<span id="next"></span>').on('click',function(){$('.currentScreen').hide();$('.currentScreen').next().show();$('.currentScreen').removeClass('currentScreen').next().addClass('currentScreen');});
                                        prevScreen = $('<span id="previous"></span>').on('click',function(){$('.currentScreen').hide();$('.currentScreen').prev().show();$('.currentScreen').removeClass('currentScreen').prev().addClass('currentScreen');});
                                        infoScreen.append(nextScreen);
                                        infoScreen.prepend(prevScreen);
                                        infoScreen.append('<span class="clear"></span>');
                                        htmScreen.append(infoScreen);
                                        if(typeof(screen.piecesets) != "undefined"){
                                            htmScreen.append(parent.loadPiecesets(screen.piecesets,cobject.template_code));
                                        }
                                        fullHtm.append(htmScreen);
                                    });
                                }
                            });
                        }
                    });
                }
            });
            $(".activities").html(fullHtm);
        }
    }
    this.next = function(){

    }
    this.paginate = function(){
        //pega o usuário, consulta e ve onde parou e start do ponto, se não do começo
        $('.screen').first().slideDown();
        $('.screen').first().addClass('currentScreen');
    }
    this.loadContents = function(contents){
        var parent = this;
        htmContents =  $('<div class="contents"></div>');
        $.each(contents, function(i, content) {
            htmContent = $('<div class="content" id="CTN'+content.ID+'"><h1>'+content.description+'</h1></div>');
            if(typeof(content.goals) != "undefined"){
                htmContent.append(parent.loadGoals(content.goals));
            }
            htmContents.append(htmContent);
        });
        return htmContents;
    };
                
    this.loadGoals = function(goals){
        var parent = this;
        htmGoals =  $('<div class="goals"></div>');
        $.each(goals, function(i, goal) {
            htmGoal = $('<div class="goal" id="GL'+goal.ID+'"><h2>'+goal.name+'</h2></div>');
            if(typeof(goal.cobjects) != "undefined"){
                htmGoal.append(parent.loadCobjects(goal.cobjects));
            }
            htmGoals.append(htmGoal);
        });
        return htmGoals;
    };
                
    this.loadCobjects = function(cobjects){
        var parent = this;
        htmCobjects =  $('<div class="cobjects"></div>');
        $.each(cobjects, function(i, cobject) {
            htmCobject = $('<div class="cobject" id="COBJ'+cobject.ID+'"><h3><strong>Atividade:</strong>'+cobject.template_code+'-'+cobject.template+'-'+cobject.code+'</h3></div>');
            if(typeof(cobject.screens) != "undefined"){
                htmCobject.append(parent.loadScreens(cobject.screens,cobject.template_code));
            }
            htmCobjects.append(htmCobject);
        });
        return htmCobjects;
    };
                
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
            htmPieceset = $('<div id="PCSET'+pieceset.ID+'" class="pieceset"><h5>'+pieceset.desc+'</h5></div>');
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
                htmPiece = $('<div id="PIECE'+piece.ID+'" class="piece"><h6>'+piece.oldID+'('+template+')</h6></div>');
                switch (template){
                    case 'AEHDD':
                        htmPiece.append(parent.loadElements(piece.elements,template));
                        break;
                    case 'MEHW':
                        htmPiece.append(parent.loadElements(piece.elements,template));
                        break;
                //depois checar o tipo na peça pode ser que seja doubleclick
                }
                htmPieces.append(htmPiece);
            }
        });
        return htmPieces;
    };
                
    this.loadElements = function(elements,template){
        var parent = this;
        htmFinal = $('<div class="blockElements"></div>');
        switch (template){
            case 'AEHDD':
                htmDrag = $('<ul class="elements edrag"></ul>');
                htmDrop = $('<ul class="elements edrop"></li>');
                break;
            case 'MEHW':
                htmEnum = $('<ul class="elements enum"></ul>');
                htmOptions = $('<ul class="elements options"></ul>')
                break;
        }
        $.each(elements, function(i, element) {
            blockElement = $('<li class="element"></li>');
            switch (element.type){
                case 'image':
                    htmElement = $('<img src="globo.jpg"/>');
                    break;
                case 'sound':
                    blockElement.prepend('<font style="display:block;font-size:9px;">Clique no icone de play para escuta as instruções</font>');
                    htmElement = $('<audio controls="controls"></audio>');
                    break;
                case 'phrase':
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
                        if(element.type == 'sound'){
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
                        case 'font-size':
                            htmElement.css(property.name,property.value);
                            break;
                        case 'cursor':
                            htmElement.css(property.name,property.value);
                            break;
                        case 'width':
                            htmElement.css(property.name,property.value);
                            break;
                        case 'height':
                            htmElement.css(property.name,property.value);
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
                                    case 'AEHDD':
                                        break;
                                    case 'MEHW':
                                        htmEnum.append(blockElement.append(htmElement));
                                        break;
                                }
                                break;
                            case 'Acerto':
                                switch (template){
                                    case 'AEHDD':
                                        break;
                                    case 'MEHW':
                                        htmElement.on('click',corretAnswer);
                                        htmOptions.append(blockElement.append(htmElement));
                                        break;
                                }
                                break;
                            case 'Erro':
                                switch (template){
                                    case 'AEHDD':
                                        break;
                                    case 'MEHW':
                                        htmElement.on('click',wrongAnswer);
                                        htmOptions.append(blockElement.append(htmElement));
                                        break;
                                }
                                break;    
                        }
                    }
                });
            }
        });
        switch (template){
            case 'AEHDD':
                htmFinal.append(htmDrop);
                htmFinal.append(htmDrag);
                break;
            case 'MEHW':
                htmFinal.append(htmEnum);
                htmFinal.append(htmOptions);
                break;
        }
        return htmFinal.append('<span style="display:block;clear:both"></span>');
    };
}
