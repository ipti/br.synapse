this.Meet = function(unityfather, options){
    // MGS
    MSG_CORRECT ='Parabéns, você acertou';
    MSG_WRONG ='Ops! Você errou, continue tentando.';
    MAME_ORGANIZATION = 'Organização';
    NAME_CLASS = 'Turma';
    NAME_ACTOR = 'Aluno';
    DEFAULT_MEET_TYPE = 1; //Atividade = 1 ; Treino = 2
    MAX_ELEMENT_PER_PIECE = 5;
    FINALIZE_ACTIVITY = "Finalizar Atividade";
    //================
    var self = this;
    this.domCobjects = null;
    //======== Variáveis Recuperadas do Filtro Inicial ===========
    this.org = options.org[0];
    this.org_name = options.org[1];
    this.classe = options.classe[0];
    this.classe_name = options.classe[1];
    this.actor = options.actor[0];
    this.actor_name = options.actor[1];
    //============================
    
    //==== Armazenar a performance do usuário
    var peformance_qtd_correct = 0;
    var peformance_qtd_wrong = 0;
    var discipline_id = 0;
    var script_id = 0;
    var start_time = 0;
    var final_time = 0;
    var interval_group = 0;
    var interval_piece = 0;
    var meet_type = options.meet_type || DEFAULT_MEET_TYPE;
    //======================================
    
    this.setDomCobjects = function(domCobjects){
        self.domCobjects = domCobjects;
    }
    this.domCobjectBuildAll = function(){
        return self.domCobjects.buildAll();
    }
    this.beginEvents = function(){
        //iniciar code_Event dos templates
        eval("self.init_"+self.domCobjects.cobject.template_code+"();");
    }
    
    this.headMeet = function(){
        return '<b>'+MAME_ORGANIZATION+':</b>'+this.org_name
        +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' +NAME_CLASS+':</b> '+this.classe_name
        +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'+NAME_ACTOR+':</b> '+this.actor_name ;
    }
    
    //    this.verifyMatch(group1, element1ID, group2, element2ID){
    //        
    //    }
    
    this.init_Common = function(){
        //Embaralha os gropos de Elementos
        $('div[group]').closest('div.ask, div.answer').shuffle();
        console.log(' OK! ');
        $('.pieceset, .piece, #nextPiece').hide();
        $('#begin_activity').on('click', function(){
            $(this).hide();
            $('#nextPiece').show();
            $('.pieceset:eq(0)').addClass('currentPieceSet');
            $('.piece:eq(0)').addClass('currentPiece');
            $('.pieceset:eq(0), .piece:eq(0)').show();
            
            //Inicio do temporizador
            self.interval_group =  self.interval_piece = new Date().getTime();
        });
        $('#nextPiece').on('click', function(){
            var currentPiece = $('.currentPiece');
            currentPiece.removeClass('currentPiece');
            currentPiece.hide();
            if(currentPiece.next().size()==0) {
                //Acabou Peça, passa pra outra PieceSet se houver
                var currentPieceSet = $('.currentPieceSet');
                currentPieceSet.removeClass('currentPieceSet');
                currentPieceSet.hide();
                
                if(currentPieceSet.next().size()==0){
                    //Acabou todas as pieceSets dessa Tela
                    // Passa pra a pŕoxima PieceSet
                    var currentScreen = $('.currentScreen');
                    currentScreen.removeClass('currentScreen');
                    currentScreen.hide();
                    var nextScreen = currentScreen.next();
                    
                    if(nextScreen.size()!=0) {
                        nextScreen.addClass('currentScreen');
                        nextScreen.show();
                        nextScreen.find('.pieceset:eq(0)').addClass('currentPieceSet');
                        nextScreen.find('.piece:eq(0)').addClass('currentPiece');
                        nextScreen.find('.pieceset:eq(0), .piece:eq(0)').show();
                    }else{
                        //Finalisou todas as Screen
                        $('#nextPiece').hide();
                        $('.toolBar').append($('<button id="finalize_activity">'+FINALIZE_ACTIVITY+'</button>'));
                    }
                    
                }else{
                    var nextPieceSet = currentPieceSet.next();
                    nextPieceSet.addClass('currentPieceSet');
                    nextPieceSet.show();
                    
                    var nextPiece = nextPieceSet.find('.piece:eq(0)');
                    nextPiece.addClass('currentPiece');
                    nextPiece.show();
                }
            }else{
                var nextPiece = currentPiece.next();
                nextPiece.addClass('currentPiece');
                nextPiece.show();
            }
            
        });
        
        $('#finalize_activity').on('click',function(){
            self.finalizeMeet();
        });
    }
    
    this.init_MTE = function(){
        
    }
    
    this.init_AEL = function(){
        //parseInt(Math.random()*10) % MAX_ELEMENT_PER_PIECE;
        var randomArray = [];
        for(var i = 0; i < MAX_ELEMENT_PER_PIECE; i++){
            randomArray[i]= i;
        }
        
        
        // variável de encontro definida no meet.php
        $('div.answer > div[group]').hide();
        self.init_Common(); 
        $('div[group]').on('click', function(){
            var ask_answer = $(this).parents('div').attr('class');
            if(ask_answer == 'ask') { 
                if(!$(this).hasClass('ael_clicked')){
                    $(this).css('opacity','0.4');
                    $(this).siblings().hide();
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(500);
                    $(this).addClass('ael_clicked');
                    $(this).addClass('last_clicked');
                }else{
                    $(this).css('opacity','1');
                    $(this).siblings(':not(.ael_clicked)').show();
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').hide(500);
                    $(this).removeClass('ael_clicked');
                    $(this).removeClass('last_clicked');
           
                }
            }else if(ask_answer == 'answer'){
                //Time de resposta
                var time_answer = (new Date().getTime() - self.interval_group);
                //Atualizar o marcador de inicio do intervalo para cada resposta
                self.interval_group = time_answer;
                $(this).siblings().hide();
                $(this).hide();
                $(this).closest('div.answer').siblings('div.ask').children('div[group]').show(500);
                var lastClicked = $(this).closest('div.answer').siblings('div.ask').children('div[group].last_clicked');
                var groupAnswerClicked = $(this).attr('group');
                var groupAskClicked = lastClicked.attr('group');
                lastClicked.attr('matched',groupAnswerClicked);
                lastClicked.removeClass('last_clicked');
                $(this).closest('div.answer').siblings('div.ask').children('div[group].ael_clicked').hide();
                $(this).addClass('ael_clicked');
                var thisPieceID = $(this).closest('.piece').attr('id');
                
                //Vericar se o match está certo para este element
                self.ismatchGroup(thisPieceID,groupAskClicked,groupAnswerClicked,time_answer);
                //Verificar se Não existe mais elementos a serem clicados
                if($(this).siblings('div[group]:not(.ael_clicked)').size() == 0){
                    //Não existe mais elementos a clicar, verifica todas as respostas e marca correto na piece
                    $(this).closest('div.piece').attr('istrue',self.ismatchGroup(thisPieceID));
                }
                
                //Respondeu, então reinicia o temporizador
                self.interval_group = new Date().getTime();
            }
                
        });

    }
    //======================
    
    
    this.ismatchGroup = function(pieceID,groupAskClicked,groupAnswerClicked,time_answer){
            
        if(self.isset(groupAskClicked) && self.isset(groupAnswerClicked)){
            //Salvar no Objeto o Metadados do acerto e erro de um element
            var elements_groupAsk = eval("self.domCobjects.mainPieces[pieceID]._"+groupAskClicked);
            var elements_groupAnswer = eval("self.domCobjects.mainPieces[pieceID]._"+groupAnswerClicked);
            
            //Veridicar Match
            var groupRevertAsk= (groupAskClicked/pieceID)/2;
            var groupRevertAnswer =((groupAnswerClicked.split('_')[0])/pieceID)/3; 
            var ismatch = (groupRevertAsk == groupRevertAnswer);
            //Seta como ismatch o istrue dos dois grupos 
            elements_groupAsk.ismatch = ismatch;
            elements_groupAsk.groupMatched = groupAnswerClicked;
            elements_groupAsk.time_answer = time_answer;
            //Seta em cada grupo o grupo matched
            //            elements_groupAnswer.ismatch = ismatch;
            //            elements_groupAnswer.groupMatched = groupAskClicked;
            return ismatch;
        }
            
        var pieceIsTrue = true;
            
        //Para Cada GRUPO da Piece
        $.each(self.domCobjects.mainPieces[pieceID], function(nome_attr,group){
            if(nome_attr!='istrue' && nome_attr != 'time_answer'){
                if(self.isset(group.ismatch) && (!group.ismatch)){
                    pieceIsTrue = false;
                }
                
                //Salva no BD os MetaDados para cada grupo
                if(self.isset(this.groupMatched)){
                    //Se for um grupo do tipo ASK
                    var current_group = nome_attr.split('_')[1];
                    //Armazenar o groupMatched do grupo atual
                    var current_groupMatched = this.groupMatched;
                    $.ajax({
                        url: '/render/compute',
                        type:'POST',
                        dataType:'json',
                        data: {
                            'pieceID':pieceID,
                            // 'piece_elementID':current_pieceElementID,
                            'groupID':"GRP"+current_group,
                            'actorID':self.actor,
                            'time_answer':this.time_answer,   //delta T 
                            'value':current_groupMatched, 
                            'isCorrect':this.ismatch
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            console.log(jqXHR.responseText);
                        },
                        success: function(response, textStatus, jqXHR){
                            console.log(response);
                        }
                    
                    });
                                    
                }
        
            //                        if(self.isset(this.elements)) {
            //                            $.each(this.elements, function(){
            //                                var current_pieceElementID = this.pieceElementID;
            //                            
            //                                //ou acertou ou erro para cada current_groupMatched
            //                                $.each(eval("self.domCobjects.mainPieces[pieceID]._"+current_groupMatched+".elements"),function(){
            //                                    var matched_pieceElementID = this.pieceElementID;
            //                                    console.log(matched_pieceElementID);
            //                                
            //                                }); 
            //                        
            //                            });
            //                        }
            }
                
        });
        //window.alert(pieceIsTrue);
        //Salva isCorrect da PIECE toda
        self.domCobjects.mainPieces[pieceID].istrue = pieceIsTrue;
        self.interval_piece = (new Date().getTime() - self.interval_piece); 
        self.domCobjects.mainPieces[pieceID].time_answer = self.interval_piece;
        $.ajax({
            url: '/render/compute',
            type:'POST',
            dataType:'json',
            data: {
                'pieceID':pieceID,
                'actorID':self.actor,
                'time_answer':self.interval_piece,   //delta T 
                'isCorrect':pieceIsTrue
            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log(jqXHR.responseText);
            },
            success: function(response, textStatus, jqXHR){
                console.log(response);
            }
                    
        });
        
        self.showMessageAnswer(pieceIsTrue);
        
        return pieceIsTrue;
    //=========================
           
    }
    //======================
    this.finalizeMeet = function(){
        
    }
    
    this.isset = function (variable){
        return (variable !== undefined && variable !== null);
    }
    
    this.showMessageAnswer = function(isTrue){
         if(isTrue){
            $('#message').show();
            $('#message').css({
                'backgroundColor':'green'
            });
            $('#message').html(MSG_CORRECT);
            $('#message').fadeOut(5000);
        }else{
            $('#message').show();
            $('#message').css({
                'backgroundColor':'red'
            });
            $('#message').html(MSG_WRONG);
            $('#message').fadeOut(5000);
        }
        
    }
    
}