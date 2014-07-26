/**
 * Classe do Meet
 * 
 * @class
 * 
 * @param {array} options
 * @returns {Meet}
 */
this.Meet = function(options) {
    // MGS
    MSG_CORRECT = 'Parabéns, você acertou';
    MSG_WRONG = 'Ops! Você errou, continue tentando.';
    MAME_ORGANIZATION = 'Organização';
    NAME_CLASS = 'Turma';
    NAME_ACTOR = 'Aluno';
    DEFAULT_MEET_TYPE = 1; //Atividade = 1 ; Treino = 2
    MAX_ELEMENT_PER_PIECE = 5;
    FINALIZE_ACTIVITY = "Finalizar Atividade";
    //================
    var self = this;
    this.currentCobject_idx = null;
    this.domCobjects = new Array();
    this.num_cobjects = 0;
    this.isFinalBlock = false;
    self.template_codes = new Array();
    //======== Variáveis Recuperadas do Filtro Inicial ===========
    this.org = options.org[0];
    this.org_name = options.org[1];
    this.classe = options.classe[0];
    this.classe_name = options.classe[1];
    this.actor = options.actor[0];
    this.actor_name = options.actor[1];
    this.login_personage_name = options.actor[2];
    this.discipline_id = options.id_discipline;
    this.cobject_block_id = options.cobject_block_id;
    //============================

    //==== Armazenar a performance do usuário
    this.peformance_qtd_correct = 0;
    this.peformance_qtd_wrong = 0;
    this.score = 0;
    var script_id = 0;
    var start_time = 0;
    var final_time = 0;
    var interval_group = 0;
    var interval_piece = 0;
    var meet_type = options.meet_type || DEFAULT_MEET_TYPE;
    //Time de cada encontro Em Segundos
    this.time = 0;
    this.tag_time;
    //======================================
    //Criar Objeto para Manipulação do Banco
    this.DB_synapse = new DB();

    this.pushDomCobjects = function(domCobjects) {
        self.domCobjects.push(domCobjects);
    }

    /**
     * Retorna todos os CObjects de self.domCobject em uma string
     * 
     * @returns {String.domCobjectBuildAll}
     */
    this.domCobjectBuildAll = function() {
        var domCobjectBuildAll = $('<div class="cobject_block"></div>');
        for (var idx in self.domCobjects) {
            domCobjectBuildAll.append(self.domCobjects[idx].buildAll());
            self.num_cobjects++;
        }
        domCobjectBuildAll.append(self.buildToolBar);
        //Retorno do 1° Cobject
        self.currentCobject_idx = 0;
        return domCobjectBuildAll;
    }

    /**
     * Inicializa os eventos dos Cobjects
     * 
     * @returns {void}
     */
    this.beginEvents = function() {
        //iniciar code_Event dos templates
        //Para cada cobject Inicia seus eventos


        for (var idx = 0; idx < self.num_cobjects; idx++) {
            //Add no Array o template name se não existir, para garantir que não chame o mesmo evento mais de uma vez
            if ($.inArray(self.domCobjects[idx].cobject.template_code, self.template_codes) == -1) {
                //Evoca o evento para este template
                self.template_codes.push(self.domCobjects[idx].cobject.template_code);
                if (self.domCobjects[idx].cobject.template_code != 'DDROP') {
                    eval("self.init_" + self.domCobjects[idx].cobject.template_code + "();");
                }

            }
        }

        //Por Fim chama o evento Comum a todos
        self.DB_synapse.getUserState(self.actor, self.cobject_block_id, self.init_Common);

    }

    //    /**
    //     * Retorna o cabeçalho do Meet
    //     * 
    //     * @returns {String}
    //     */
    //    this.headMeet = function() {
    //        return '<b>' + MAME_ORGANIZATION + ':</b>' + this.org_name
    //        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' + NAME_CLASS + ':</b> ' + this.classe_name
    //        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' + NAME_ACTOR + ':</b> ' + this.actor_name;
    //    }

    //    this.verifyMatch(group1, element1ID, group2, element2ID){
    //        
    //    }

    /**
     * Reseta os intervalos de tempo
     * 
     * @returns {void}
     */
    this.restartTimes = function() {
        self.interval_group = self.interval_piece = new Date().getTime();
    }

    /**
     * Inicializa eventos comuns a todos os templates.
     * 
     * @returns {void}
     */
    this.init_Common = function(info_state) {
        var gotoState = self.isset(info_state);
        if (gotoState) {
            var lastpiece_id = info_state.last_piece_id;
            self.peformance_qtd_correct = info_state.qtd_correct;
            self.peformance_qtd_wrong = info_state.qtd_wrong;
            self.currentCobject_idx = info_state.currentCobject_idx;
            //Calcula o Score
            self.scoreCalculator();
        }
        //Embaralha os gropos de Elementos
        var selector_cobject = '.cobject';
        $(selector_cobject + ' div[group]').closest('div.ask, div.answer').shuffle();

        if ($.inArray('DDROP', self.template_codes) != -1) {
            //Existe DDROP
            self.init_DDROP();
        }

        //$(selector_cobject).find('.pieceset, .piece, .nextPiece').hide();

        if (!gotoState) {
            $('.nextPiece').show();
            $(selector_cobject + ':eq(0)').addClass('currentCobject');
            $(selector_cobject + ':eq(0) .T_screen:eq(0)').addClass('currentScreen');
            $(selector_cobject + ':eq(0) .pieceset:eq(0)').addClass('currentPieceSet');
            $(selector_cobject + ':eq(0) .piece:eq(0)').addClass('currentPiece');
            $(selector_cobject + '.currentCobject, ' + selector_cobject +
                    ' .currentScreen, ' + selector_cobject + ' .currentPieceSet, ' + selector_cobject +
                    ' .currentPiece').show();
        } else {
            //Ir para a piece->pieceSet->Screen->cobject 

            var lastPiece = $(selector_cobject + ' .piece[id=' + lastpiece_id + ']');
            var nextPiece = null;
            var lastPieceSet = null;
            var lastScreen = null;
            var lastCobject = null;
            var nextPieceSet = null;
            var nextScreen = null;
            var nextCobject = null;

            if (lastPiece.next('.piece').size() != 0) {
                nextPiece = lastPiece.next('.piece');
            } else {
                //Acabou as Pieces desta PieceSet
                lastPieceSet = lastPiece.closest('.pieceset');
                nextPieceSet = lastPieceSet.next('.pieceset');
                if (nextPieceSet.size() == 0) {
                    //Acabou as PieceSets desta Screen
                    lastScreen = lastPieceSet.closest('.T_screen');
                    nextScreen = lastScreen.next('.T_screen');
                    if (nextScreen.size() == 0) {
                        //Acabou as Screens deste Cobject
                        lastCobject = lastScreen.closest('.cobject');
                        nextCobject = lastCobject.next('.cobject');
                        if (nextCobject.size() == 0) {
                            //Acabou todos os Cobjets, ATIVIDADE JÁ FINALIZADA
                            self.isFinalBlock = true;

                        } else {
                            //Ir pra a piece do next Cobject
                            self.currentCobject_idx++;
                            nextPiece = nextCobject.find('.T_screen:eq(0) .pieceset:eq(0) .piece:eq(0)');
                        }
                    } else {
                        //Ir pra a piece next Screen
                        nextPiece = nextScreen.find('.pieceset:eq(0) .piece:eq(0)');
                    }
                } else {
                    //Ir pra a piece next PieceSet
                    nextPiece = nextPieceSet.find('.piece:eq(0)');

                }


            }

            //Se NÃO for o final do bloco
            //Existe uma próxima peça
            if (!self.isFinalBlock) {
                nextPiece.addClass('currentPiece');
                nextPiece.closest('.pieceset').addClass('currentPieceSet');
                var parentScreen = nextPiece.closest('.T_screen').addClass('currentScreen');
                parentScreen.closest('.cobject').addClass('currentCobject');

                $('.nextPiece').show();
                $(selector_cobject + '.currentCobject, ' + selector_cobject +
                        ' .currentScreen, ' + selector_cobject + ' .currentPieceSet, ' + selector_cobject +
                        ' .currentPiece').show();
            }
        }

        if (!self.isFinalBlock) {
            //Inicio do temporizador
            self.restartTimes();

            $('.nextPiece').on('click', function() {
                var currentPiece = $('.currentPiece');
                //Se for PRE então Verificar ser está correto
                if (self.domCobjects[self.currentCobject_idx].cobject.template_code == 'PRE') {
                    self.isCorrectPRE(currentPiece.attr('id'));
                }

                //Salva no BD somente se o template for != TXT
                if (self.domCobjects[self.currentCobject_idx].cobject.template_code != 'TXT') {
                    //Salva na PerformanceUser
                    self.savePerformanceUsr(currentPiece.attr('id'));
                } else {
                    //Salva somente o estado corrente do usuário
                    //Salvar o estado do Actor, neste ponto.
                    //cobject_block_id + actor_id = PK
                    var info_state = {
                        cobject_block_id: self.cobject_block_id,
                        actor_id: self.actor,
                        last_piece_id: currentPiece.attr('id'),
                        qtd_correct: self.peformance_qtd_correct,
                        qtd_wrong: self.peformance_qtd_wrong,
                        currentCobject_idx: self.currentCobject_idx
                    };
                    self.DB_synapse.NewORUpdateUserState(info_state);
                }

                currentPiece.removeClass('currentPiece');
                currentPiece.hide();
                if (currentPiece.next().size() == 0) {
                    //Acabou Peça, passa pra outra PieceSet se houver
                    var currentPieceSet = $('.currentPieceSet');
                    currentPieceSet.removeClass('currentPieceSet');
                    currentPieceSet.hide();

                    if (currentPieceSet.next().size() == 0) {
                        //Acabou todas as pieceSets dessa Tela
                        // Passa pra a pŕoxima PieceSet
                        var currentScreen = $('.currentScreen');
                        currentScreen.removeClass('currentScreen');
                        currentScreen.hide();
                        var nextScreen = currentScreen.next();

                        if (nextScreen.size() != 0) {
                            nextScreen.addClass('currentScreen');
                            nextScreen.show();
                            nextScreen.find('.pieceset:eq(0)').addClass('currentPieceSet');
                            nextScreen.find('.piece:eq(0)').addClass('currentPiece');
                            nextScreen.find('.pieceset:eq(0), .piece:eq(0)').show();
                        } else {
                            //Finalisou todas as Screen do COBJECT Corrente
                            if (self.hasNextCobject()) {
                                self.currentCobject_idx++;
                                var selector_cobject = '.cobject[id=' + self.domCobjects[self.currentCobject_idx].cobject.cobject_id + ']';
                                $('.currentCobject').removeClass('currentCobject');
                                $(selector_cobject).addClass('currentCobject');
                                nextScreen = $(selector_cobject + ' .T_screen:eq(0)');
                                nextScreen.addClass('currentScreen');
                                nextScreen.show();
                                nextScreen.find('.pieceset:eq(0)').addClass('currentPieceSet');
                                nextScreen.find('.piece:eq(0)').addClass('currentPiece');
                                $(selector_cobject).show();
                                nextScreen.find('.pieceset:eq(0), .piece:eq(0)').show();

                            } else {
                                $('.nextPiece').hide();
                                $('.toolBar').append($('<button id="finalize_activity">' + FINALIZE_ACTIVITY + '</button>'));
                            }

                        }

                    } else {
                        var nextPieceSet = currentPieceSet.next();
                        nextPieceSet.addClass('currentPieceSet');
                        nextPieceSet.show();

                        var nextPiece = nextPieceSet.find('.piece:eq(0)');
                        nextPiece.addClass('currentPiece');
                        nextPiece.show();
                    }
                } else {
                    var nextPiece = currentPiece.next();
                    nextPiece.addClass('currentPiece');
                    nextPiece.show();
                }

                // Após salvar, Reinicia o time da Piece e Group
                self.restartTimes();
            });

            $('#finalize_activity').on('click', function() {
                self.finalizeMeet();
            });
        } else {
            //Atividade Já Finalizada
            $('.cobject_block').hide();
            window.alert('Atividade Já Finalizada !');
        }
    }


    /**
     * Inicializa eventos do MTE
     * 
     * @returns {void}
     */
    this.init_MTE = function() {
        // self.init_Common();
        $('.cobject.MTE div[group]').on('click', function() {
            //Se já foi clicado
            if ($(this).hasClass('last_clicked')) {
                $(this).css('border', '3px solid transparent');
                $(this).removeClass('last_clicked');
            } else {
                var siblings = $(this).siblings();
                $(this).css('border', '3px dashed #FBB03B');
                var siblings = $(this).siblings();
                siblings.css('border', '3px solid transparent');
                siblings.removeClass('last_clicked');
                $(this).addClass('last_clicked');
            }

            //Primeiro Verificar se a Piece está certa!
            var pieceID = $(this).closest('.piece').attr('id');
            self.isCorrectMTE(pieceID, $(this).attr('group'));
            //Somente salva no BD no botão: Próxima Piece
        });

    }

    /**
     * Inicializa eventos do AEL
     * 
     * @returns {void}
     */
    this.init_AEL = function() {
        // variável de encontro definida no meet.php
        $('.cobject.AEL div.answer > div[group]').hide();
        $('.cobject.AEL div[group]').on('click', function() {
            var ask_answer = $(this).parents('div').attr('class');
            if (ask_answer == 'ask') {
                if (!$(this).hasClass('ael_clicked')) {
                    $(this).css('opacity', '0.4');
                    $(this).siblings().hide();
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(500);
                    $(this).addClass('ael_clicked');
                    $(this).addClass('last_clicked');
                } else {
                    $(this).css('opacity', '1');
                    $(this).siblings(':not(.ael_clicked)').show();
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').hide(500);
                    $(this).removeClass('ael_clicked');
                    $(this).removeClass('last_clicked');

                }
            } else if (ask_answer == 'answer') {
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
                lastClicked.attr('matched', groupAnswerClicked);
                lastClicked.removeClass('last_clicked');
                $(this).closest('div.answer').siblings('div.ask').children('div[group].ael_clicked').hide();
                $(this).addClass('ael_clicked');
                var thisPieceID = $(this).closest('.piece').attr('id');

                //Vericar se o match está certo para este element
                self.isCorrectAEL(thisPieceID, groupAskClicked, groupAnswerClicked, time_answer);
                //Verificar se Não existe mais elementos a serem clicados
                if ($(this).siblings('div[group]:not(.ael_clicked)').size() == 0) {
                    //Não existe mais elementos a clicar, verifica todas as respostas e marca correto na piece
                    //$(this).closest('div.piece').attr('istrue',self.isCorrectAEL(thisPieceID));
                }

                //Respondeu, então "reinicia" o temporizador de grupo
                self.interval_group = new Date().getTime();
            }

        });

    }

    /**
     * Inicializa eventos do AEL
     * 
     * @returns {void}
     */
    this.init_DDROP = function() {
        //Definir Animação Drag and Drop
        $('.drop').hide();

        $('.drag').draggable({
            drag: function() {
                // as you drag, add your "dragging" class, like so:
                // $(this).addClass("inmotion");
                console.log('Dragingg....');
            }

        });

        $('.drop').droppable({
            drop: function(event, ui) {
                //  $(this).addClass( "droped" );
                alert('droped!');

                //Time de resposta
                var time_answer = (new Date().getTime() - self.interval_group);
                //Atualizar o marcador de inicio do intervalo para cada resposta
                self.interval_group = time_answer;
                $(this).siblings().hide();
                $(this).hide();
                //  $(this).closest('div.answer').siblings('div.ask').children('div[group]').hide();
                var lastClicked = $(this).closest('div.answer').siblings('div.ask').children('div[group].last_clicked');
                var groupAnswerClicked = $(this).attr('group');
                var groupAskClicked = lastClicked.attr('group');
                lastClicked.attr('matched', groupAnswerClicked);

                lastClicked.addClass('ael_clicked');
                lastClicked.removeClass('last_clicked');
                 $(this).closest('div.answer').siblings('div.ask').children('div[group].ael_clicked').hide();
                $(this).addClass('ael_clicked');
                var thisPieceID = $(this).closest('.piece').attr('id');

                //Vericar se o match está certo para este element
                self.isCorrectAEL(thisPieceID, groupAskClicked, groupAnswerClicked, time_answer);
                //Verificar se Não existe mais elementos a serem clicados
                if ($(this).siblings('div[group]:not(.ael_clicked)').size() == 0) {
                    //Não existe mais elementos a clicar, verifica todas as respostas e marca correto na piece
                    //$(this).closest('div.piece').attr('istrue',self.isCorrectAEL(thisPieceID));
                }

                //Respondeu, então "reinicia" o temporizador de grupo
                self.interval_group = new Date().getTime();

            }


        });



        //        
        // variável de encontro definida no meet.php

        $('.drag').on('mousedown', function() {

            $(this).css('border', '3px dashed #FBB03B');
            $(this).siblings().css('opacity', '0');
            $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(500);
            $(this).siblings('.drag').removeClass('last_clicked');
            $(this).addClass('last_clicked');

        });

        $('.drag').on('mouseup', function() {
            $(this).css('border', '3px solid transparent');
            $(this).siblings(':not(.ael_clicked)').css('opacity', '1');
            $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').hide(500);
           
        });

    }




    /**
     * Inicializa eventos do PRE
     * 
     * @returns {void}
     */
    this.init_PRE = function() {
        //  self.init_Common();

    }

    /**
     * Inicializa eventos do TXT
     * 
     * @returns {void}
     */
    this.init_TXT = function() {
        //  self.init_Common();
    }
    //======================

    //Salvar PermanceUser
    /**
     * Salva a performace do usuário no banco. Retorna falso caso haja algum erro.
     * 
     * @returns {boolean}
     */
    this.savePerformanceUsr = function(currentPieceID) {
        //Obtem o intervalo de resolução da Piece
        self.interval_piece = (new Date().getTime() - self.interval_piece);
        //Se for uma piece do template AEL, então salva cada Match dos grupos realizados 
        // e a armazena no objeto piece.isCorrect da piece corrente 
        if (self.domCobjects[self.currentCobject_idx].cobject.template_code == 'AEL' ||
                self.domCobjects[self.currentCobject_idx].cobject.template_code == 'DDROP') {
            self.saveMatchGroup(currentPieceID);
        }
        //Neste ponto o isTrue da Piece está setado
        //Salva isCorrect da PIECE toda
        var pieceIsTrue = self.domCobjects[self.currentCobject_idx].mainPieces[currentPieceID].isCorrect;
        self.domCobjects[self.currentCobject_idx].mainPieces[currentPieceID].time_answer = self.interval_piece;
        var data_default = {
            'piece_id': currentPieceID,
            'actor_id': self.actor,
            'final_time': self.interval_piece, //delta T 
            'iscorrect': pieceIsTrue
        };
        var data = data_default;
        if (self.domCobjects[self.currentCobject_idx].cobject.template_code == 'MTE') {
            //Último grupo clicado da Piece Corrente. Divide por 2 como um grupo ASK
            data.group_id = ($('.currentPiece .last_clicked').attr('group') / currentPieceID) / 2;
        }

        //Salvar na performance_User OffLine
        self.DB_synapse.addPerformance_actor(data);


        if (pieceIsTrue) {
            self.peformance_qtd_correct++;
        } else {
            self.peformance_qtd_wrong++;
        }

        //Salvar o estado do Actor, neste ponto.
        //cobject_block_id + actor_id = PK
        var info_state = {
            cobject_block_id: self.cobject_block_id,
            actor_id: self.actor,
            last_piece_id: currentPieceID,
            qtd_correct: self.peformance_qtd_correct,
            qtd_wrong: self.peformance_qtd_wrong,
            currentCobject_idx: self.currentCobject_idx
        };
        //Salva o Estado
        self.DB_synapse.NewORUpdateUserState(info_state);
        //Calcula o Score
        self.scoreCalculator();
        self.showMessageAnswer(pieceIsTrue);
        //Salvo com Sucesso !
        return true;
    }

    this.saveMatchGroup = function(currentPieceID) {
        //Para Cada GRUPO da Piece
        var pieceIsTrue = true;
        $.each(self.domCobjects[self.currentCobject_idx].mainPieces[currentPieceID], function(nome_attr, group) {
            if (nome_attr != 'istrue' && nome_attr != 'time_answer') {
                if (self.isset(group.ismatch) && (!group.ismatch)) {
                    pieceIsTrue = false;
                }
                //Salva no BD os MetaDados para cada grupo
                if (self.isset(this.groupMatched)) {
                    //Se for um grupo do tipo ASK
                    var current_group = nome_attr.split('_')[1];
                    //Armazenar o groupMatched do grupo atual
                    var current_groupMatched = this.groupMatched;

                    var data = {
                        'piece_id': currentPieceID,
                        // 'piece_elementID':current_pieceElementID,
                        'group_id': current_group,
                        'actor_id': self.actor,
                        'final_time': this.time_answer, //delta T 
                        'value': "GRP" + current_groupMatched,
                        'iscorrect': this.ismatch
                    };
                    //Salvar na performance_User OffLine
                    self.DB_synapse.addPerformance_actor(data);
                }
            }

        });
        //Salvo com Sucesso
        self.domCobjects[self.currentCobject_idx].mainPieces[currentPieceID].isCorrect = pieceIsTrue;
        return true;
    }

    /**
     * Verifica se esta Correto MTE.
     * 
     * @param {integer} pieceID
     * @param {string} groupClicked
     * @returns {Boolean}
     */
    this.isCorrectMTE = function(pieceID, groupClicked) {
        var elements_group = eval("self.domCobjects[self.currentCobject_idx].mainPieces[pieceID]._" + groupClicked);
        //Alterar para comparar com o layertype de todo o grupo
        var isCorrect = (elements_group.elements[0].pieceElement_Properties.layertype == 'Acerto');
        //Só precisar selecionar 1 para atualizar o isCorrect da piece corrente
        self.domCobjects[self.currentCobject_idx].mainPieces[pieceID].isCorrect = isCorrect;
        return isCorrect;
    }

    /**
     * Salva os Metadados no objeto e verifica se o AEL esta correto
     * 
     * @param {integer} pieceID
     * @param {string} groupAskClicked
     * @param {string} groupAnswerClicked
     * @param {integer} time_answer
     * @returns {Boolean} null caso não seja salvo
     */
    this.isCorrectAEL = function(pieceID, groupAskClicked, groupAnswerClicked, time_answer) {

        if (self.isset(groupAskClicked) && self.isset(groupAnswerClicked)) {
            console.log(self.currentCobject_idx);
            //Salvar no Objeto o Metadados do acerto e erro de um element
            var elements_groupAsk = eval("self.domCobjects[self.currentCobject_idx].mainPieces[pieceID]._" + groupAskClicked);
            var elements_groupAnswer = eval("self.domCobjects[self.currentCobject_idx].mainPieces[pieceID]._" + groupAnswerClicked);

            //Veridicar Match
            var groupRevertAsk = (groupAskClicked / pieceID) / 2;
            var groupRevertAnswer = ((groupAnswerClicked.split('_')[0]) / pieceID) / 3;
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

        //Se não foi salvo
        return null;
    }

    /**
     * Verifica se o PRE esta correto
     * 
     * @param {integer} pieceID
     * @returns {Boolean}
     */
    this.isCorrectPRE = function(pieceID) {
        //PRE somente possuí um grupo em cada piece
        var elements_group = eval("self.domCobjects[self.currentCobject_idx].mainPieces[pieceID]._" + (pieceID * 2));
        var digitated_value = $('.currentPiece').find('div[group] input.text').val();
        var idxText = null;
        //BUSCAR PROPRIEDADE  = TEXT
        for (var i = 0; i < elements_group.elements[0].generalProperties.length; i++) {
            if (elements_group.elements[0].generalProperties[i].name == 'text') {
                idxText = i;
                break;
            }
        }

        var isCorrect = (elements_group.elements[0].generalProperties[idxText].value.toUpperCase() == digitated_value.toUpperCase());
        //Só precisar selecionar 1 para atualizar o isCorrect da piece corrente
        self.domCobjects[self.currentCobject_idx].mainPieces[pieceID].isCorrect = isCorrect;
        return isCorrect;
    }


    this.hasNextCobject = function() {
        return self.isset(self.domCobjects[self.currentCobject_idx + 1]);
    }

    //======================
    /**
     * Deveria finalizar o meet... mas não faz nada.
     */
    this.finalizeMeet = function() {
        if (confirm("Deseja realmente sair?")) {
            sessionStorage.removeItem("authorization");
            sessionStorage.removeItem("id_discipline");
            sessionStorage.removeItem("login_id_actor");
            sessionStorage.removeItem("login_personage_name");
            sessionStorage.removeItem("login_name_actor");
            location.href = "index.html";
            return true;
        }
        return false;
    }

    /**
     * Verifica se a variavel esta setada.
     * 
     * @param {mixed} variable
     * @returns {Boolean}
     */
    this.isset = function(variable) {
        return (variable !== undefined && variable !== null);
    }

    /**
     * Envia mensagem de Certo ou Errado par ao usuário
     * 
     * @param {boolean} isTrue
     * @returns {void}
     */
    this.showMessageAnswer = function(isTrue) {
        if (isTrue) {
            $('#message').show();
            $('#message').css({
                'backgroundColor': 'green'
            });
            $('#message').html(MSG_CORRECT);
            $('#message').fadeOut(5000);
        } else {
            $('#message').show();
            $('#message').css({
                'backgroundColor': 'red'
            });
            $('#message').html(MSG_WRONG);
            $('#message').fadeOut(5000);
        }

    }

    //Contador de Tempo de cada Meet
    this.countTime = function(tag) {
        //A cada segundo realiza a recursividade
        if (self.isset(tag)) {
            self.tag_time = tag;
        }
        setTimeout(function() {
            self.time++;
            var current_time = self.time;

            var hours = 0;
            var mins = 0;
            var segs = 0;
            if (current_time >= 3600) {
                //Possui hora
                hours = Math.round(current_time / 3600);
                current_time %= 3600;
            }

            if (current_time >= 60) {
                //Possui minutos
                mins = Math.round(current_time / 60);
                current_time %= 60;
            }
            segs = current_time;
            if (hours < 10) {
                hours = '0' + hours;
            }
            if (mins < 10) {
                mins = '0' + mins;
            }
            if (segs < 10) {
                segs = '0' + segs;
            }
            self.tag_time.html(hours + ':' + mins + ':' + segs);
            self.countTime();
        }, 1000);
    }



    this.scoreCalculator = function() {
        self.score = (self.peformance_qtd_correct * 10) - (self.peformance_qtd_wrong * 10);
        if (self.score < 0) {
            self.score = 0;
        }
        //Atualiza a contidade de corretos
        $('.info.info-hits .info-text').html(self.peformance_qtd_correct);
        $('.info.info-erros .info-text').html(self.peformance_qtd_wrong);
        $('#points').text(self.score);
    }



    this.buildToolBar = function() {
        var html = $('<div class="toolBar"></div>');
        html.append('<button class="nextPiece">' + NEXT_PIECE + '</button>');
        return html;
    }

}
