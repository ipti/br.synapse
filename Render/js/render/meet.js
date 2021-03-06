/* global self */
// var EDITOR = "http://local.synapse.ipti.org.br";
var EDITOR = "http://synapse.seed.ipti.org.br";

/**
 * Classe do Meet
 *
 * @class
 *
 * @param {array} options
 * @returns {Meet}
 */
this.Meet = function(options) {
    //Apontador para o próprio objeto Meet
    var self = this;
    //Modo do Render selecionado
    //type: {evaluation, proficiency, training}
    Meet.render_mode = options.render_mode;
    this.meetEvaluation;
    this.meetProficiency;

    // MGS
    MSG_CORRECT = 'Parabéns, você acertou';
    MSG_WRONG = 'Ops! Você errou, continue tentando.';
    MAME_ORGANIZATION = 'Organização';
    NAME_CLASS = 'Turma';
    NAME_ACTOR = 'Aluno';
    DEFAULT_MEET_TYPE = 1; //Atividade = 1 ; Treino = 2
    MAX_ELEMENT_PER_PIECE = 5;
    FINALIZE_ACTIVITY = "Finalizar Atividade";
    NEXT_PAGE = "Próxima Página";
    LAST_PAGE = "Última Página";


    //Strings Html
    NEXT_PIECE = '<img class="answer-ok" src="img/icons/ok.png">';
    //================


    //Verificar se é o RenderOnline
    self.isOnline = false;
    if (sessionStorage.getItem("isOnline") !== null &&
        sessionStorage.getItem("isOnline") == 'true') {
        //Render Online
        self.isOnline = true;
    }
    self.isPreview = false;
    if (sessionStorage.getItem("isPreview") !== null &&
        sessionStorage.getItem("isPreview") != -1) {
        //Render Online
        self.isPreview = sessionStorage.getItem("isPreview");
    }


    var isClockStarted = false;
    Meet.isLoadState = false;
    //Primeira peça mostrada na tela no Encontro Corrente
    Meet.firstPieceCurrentMeet = null;
    this.currentGrade = 0;
    Meet.domCobject = null;
    this.num_cobjects = 0;
    this.isFinalBlock = false;
    this.currentTemplateCode = null;
    //======== Variáveis Recuperadas do Filtro Inicial ===========

    this.org = options.org[0];
    this.org_name = options.org[1];
    this.studentClassroomID = options.studentClassroom[0];
    Meet.studentClassroomName = options.studentClassroom[1];
    Meet.studentClassroomStageFk = options.studentClassroom[2];
    //Ano atual do Aluno
    Meet.studentCurrentYear =  options.studentClassroom[3];
    Meet.studentCurrentCyclo2 = null;
    Meet.actor = options.actor[0];
    Meet.actor_name = options.actor[1];
    Meet.login_personage_name = options.actor[2];
    Meet.discipline_id = options.id_discipline;

    //==== Armazenar a performance do usuário
    Meet.peformance_qtd_correct = 0;
    Meet.peformance_qtd_wrong = 0;
    this.score = 0;
    var script_id = 0;
    var start_time = 0;
    var final_time = 0;
    var interval_group = 0;
    var start_time_piece = 0;
    var interval_piece = 0;
    var meet_type = options.meet_type || DEFAULT_MEET_TYPE;
    //Time de cada encontro Em Segundos
    this.time = 0;
    this.tag_time;
    //======================================
    //Criar Objeto para Manipulação do Banco
    Meet.DB_synapse = sessionGet("isOnline") != null && sessionGet("isOnline") != "false" ? new DBOn() : new DB();
    //======================================


    //Obter bloco a partir da disciplina selecionada
    this.start = function() {

            if (Meet.render_mode == 'evaluation') {
                //Instancia o meetEvaluation
                self.meetEvaluation = new MeetEvaluation(sessionStorage.getItem("evaluation_selected_level"));
                //Inicia o Render
                self.meetEvaluation.start();
            } else if (Meet.render_mode == 'preview') {
                var cobjectId = sessionGet('isPreview');
                var cobject = {};
                $.ajax({
                    url: EDITOR + "/render/loadcobject/",
                    type: "GET",
                    dataType: 'jsonp',
                    data: {
                        ID: cobjectId
                    },
                }).done(function(data) {
                    cobject = data;
                    self.meetPreview = new MeetPreview(cobject);
                    self.meetPreview.start();
                });
            } else if(Meet.render_mode == 'proficiency'){
                //Instancia o meetProficiency
                self.meetProficiency = new MeetProficiency();
                //Inicia o Render
                self.meetProficiency.start();
            }

            /* else if (Meet.render_mode == 'proficiency') {
                //Instancia o meetProficiency
                self.meetProficiency = new MeetProficiency();
                //Inicia o Render
                self.meetProficiency.start();
            } else if (Meet.render_mode == 'training') {

            } */


        }
        //============================

    this.setDomCobject = function(domCobject) {
        Meet.domCobject = domCobject;
    };

    /**
     * Retorna todos os CObjects de Meet.domCobject em uma string
     *
     * @returns {String.domCobjectBuildAll}
     */
    //    this.domCobjectBuildAll = function() {
    //        var domCobjectBuildAll = $('<div class="cobject_block"></div>');
    //        for (var idx in Meet.domCobject) {
    //            domCobjectBuildAll.append(Meet.domCobject[idx].buildAll());
    //            self.num_cobjects++;
    //        }
    //        //Por último a div de ferramentas
    //        domCobjectBuildAll.append(self.buildToolBar);
    //        //Retorno do 1° Cobject
    //        self.currentCobject_idx = 0;
    //        return domCobjectBuildAll;
    //    }

    /**
     *
     * @param {DOMString} cobject_id
     *
     * @returns {void}
     */
    Meet.domCobjectBuild = function(cobject_id, cobject) {
        var building = function(json_cobject) {
            var dump = new DomCobject(json_cobject);
            //Adicionar o domCobjet no Encontro 'Meet'
            self.setDomCobject(dump);

            //Depois atualiza o template corrente do Meet
            self.currentTemplateCode = Meet.domCobject.cobject.template_code;
            var domCobjectBuild;
            if ($('div.cobject_block').size() !== 0) {
                //Já existe
                domCobjectBuild = $('div.cobject_block');
            } else {
                //É o 1°
                domCobjectBuild = $('<div class="cobject_block"></div>');
            }



            domCobjectBuild.html(Meet.domCobject.buildAll());

            //Por último a div de ferramentas
            domCobjectBuild.append(self.buildToolBar);

            //Chamar função para inserir nome html
            $('#render_canvas').html(domCobjectBuild);


            Meet.domCobject.posBuildAll();

            //Inicia os eventos somente após a inclusão do html na dom
            self.beginEvents();
            // Render Ready!
            if (!isClockStarted) {
                isClockStarted = true;
                self.countTime($('.info-time .info-text'));
            }

        }


        //Construir a Dom do Cobject e append no html
        if (self.isPreview) {
            building(cobject);
        } else {
            Meet.DB_synapse.getCobject(cobject_id, building);
        }
    };

    /**
     * Inicializa os eventos dos Cobjects
     *
     * @returns {void}
     */
    this.beginEvents = function() {
        //iniciar code_Event dos template
        //Evoca o evento para este template
        if (Meet.domCobject.cobject.template_code !== 'DDROP' &&
            Meet.domCobject.cobject.template_code !== 'ONEDDROP') {
            eval("self.init_" + Meet.domCobject.cobject.template_code + "();");
        }
        //Por Fim chama o evento Comum a todos
        self.init_Common();
    };

    /**
     * Reseta os intervalos de tempo
     *
     * @returns {void}
     */
    this.restartTimes = function() {
        self.interval_group = self.start_time_piece = new Date().getTime();
    };

    //Carregar Primeira Piece do atendimento corrente
    this.loadFirstPiece = function() {
        if (Meet.render_mode == 'evaluation') {
            self.meetEvaluation.loadFirstPiece_Evaluation();
        } else if (Meet.render_mode == 'preview') {
            self.meetPreview.loadFirstPiece_Evaluation();
        } else if (Meet.render_mode == 'proficiency') {

        } else if (Meet.render_mode == 'training') {

        }

    }

    /**
     * Inicializa eventos comuns a todos os templates.
     *
     * @returns {void}
     */
    this.init_Common = function() {
        //Embaralha os grupos de Elementos
        var selector_cobject = '.cobject';
        if (Meet.domCobject.cobject.template_code !== 'PLC' && Meet.domCobject.cobject.template_code !== 'DIG') {
            $(selector_cobject + ' div[group]').closest('div.answer').shuffle();
        }

        if (Meet.domCobject.cobject.template_code !== 'AEL' && Meet.domCobject.cobject.template_code !== 'DDROP' &&
            Meet.domCobject.cobject.template_code !== 'ONEDDROP') {
            $(selector_cobject + ' div[group]').closest('div.ask').shuffle();
        }

        if (self.currentTemplateCode === 'DDROP') {
            //Existe DDROP
            self.init_DDROP();
        } else if (self.currentTemplateCode === 'ONEDDROP') {
            //Existe  ONEDDROP
            self.init_ONEDDROP();
        }


        //$(selector_cobject).find('.pieceset, .piece, .nextPiece').hide();
        $('.nextPiece').hide();

        //Carregar a primeira Piece deste atendimento atual na Tela
        self.loadFirstPiece();


        if (!self.isFinalBlock) {
            //Inicio do temporizador
            self.restartTimes();

            $('.nextPiece').bind('tap', function() {
                self.nextPiece();
            });

            //mouseup ao invés de tap , por que os elementos por traś do elemento clicado
            //Estavam sendo clicados
            $(".message-button").bind('mouseup', function() {
                $(this).closest('.modal_message').hide();
                // Após salvar, Reinicia o time da Piece e Group
                self.restartTimes();
            });


            $('#finalize_activity').bind('tap', function() {
                self.finalizeMeet();
            });

            //Se for o Tipo Texto o Cobject Corrent, então add passar páginas
            if (Meet.domCobject.cobject.template_code === 'TXT') {
                BtnPageTXT();
            } else {
                NoBtnPageTXT();
            }


        } else {
            //Atividade Já Finalizada !
            Meet.messageFinishedLevel();
        }

        if (Meet.domCobject.cobject.template_code == 'PLC' ||
            Meet.domCobject.cobject.template_code == 'DIG' ||
            Meet.domCobject.cobject.template_code == 'DES') {
            $('.refreshQuestion').on('tap', function() {
                var currentPiece = $('div.currentPiece');
                if (Meet.domCobject.cobject.template_code == 'PLC') {
                    var inputsPlc = currentPiece.find('input.PLC-input:not([readonly])');
                    inputsPlc.val('');
                    inputsPlc.data('value', '');
                }

                if (Meet.domCobject.cobject.template_code == 'DIG') {
                    //Zerar as Colunas
                    var colsPlc = currentPiece.find('.DIG-table').find('td');
                    colsPlc.removeClass('firstSelected');
                    colsPlc.removeClass('lastSelected');

                    //Zerar os HighLight
                    var highLightPlc = currentPiece.find('.DIG-table').find('div.digHighlight');
                    highLightPlc.attr('style', '');
                    highLightPlc.removeClass('currentSelected');
                    highLightPlc.removeClass('selected');
                    highLightPlc.removeAttr('posstart');
                    highLightPlc.removeAttr('posfinish');
                }

                //Esconde o NextPiece
                $('.nextPiece').hide();
            });
        }



    };

    Meet.init_eventsGlobals = function() {

        //Botão do SOM
        $(document).on('tap', '.soundIconPause', function() {
            var selfIconPause = $(this);
            var playing = selfIconPause.attr('playing') !== undefined &&
                selfIconPause.attr('playing') !== null && selfIconPause.attr('playing') === 'true';

            var li = $(this).parent();
            var span = li.children('span');
            var img = $(this);
            var audio = span.children()[0];
            if (playing) {
                audio.pause();
                audio.currentTime = 0;
                img.attr('src', "img/icons/play.png");
                selfIconPause.attr('playing', 'false');
            } else {
                //Antes do Play, dá um STOP em todos os audios em execução
                self.stopAllSounds();
                audio.play();
                img.attr('src', "img/icons/stop.png");
                selfIconPause.attr('playing', 'true');
            }

            //seta playing para false após o audio acabar
            audio.onended = function() {
                audio.pause();
                audio.currentTime = 0;
                img.attr('src', "img/icons/play.png");
                selfIconPause.attr('playing', 'false');
            };

            audio.addEventListener("ended", function() {
                img.attr('src', "img/icons/play.png");
                //playing = true;
            });

        });

    };

    this.stopAllSounds = function() {
        $('.soundIconPause[playing="true"]').each(function(idx) {
            var li = $(this).parent();
            var span = li.children('span');
            var img = $(this);
            var audio = span.children()[0];

            audio.pause();
            audio.currentTime = 0;
            img.attr('src', "img/icons/play.png");
            $(this).attr('playing', 'false');
        });
    };

    //Salvar os Pontos de parada do usuário
    this.saveBreakPoint = function(piece_id) {
        if (Meet.render_mode == 'evaluation') {
            self.meetEvaluation.saveBreakPoint(piece_id);
        } else if (Meet.render_mode == 'proficiency') {

        } else if (Meet.render_mode == 'training') {

        }

    }

    this.nextPiece = function() {
        //Pausa Todos os Sons
        self.stopAllSounds();
        $('.nextPiece').hide();
        var currentPiece = $('.currentPiece');
        //Se for PRE então Verificar ser está correto
        if (Meet.domCobject.cobject.template_code === 'PRE') {
            self.isCorrectPRE(currentPiece.attr('id'));
        }

        var isCorrectPiece;
        //Salva no BD somente se o template for != TXT
        if (Meet.domCobject.cobject.template_code !== 'TXT') {
            //Salva na PerformanceUser
            self.savePerformanceUsr(currentPiece.attr('id'));
            isCorrectPiece = Meet.domCobject.mainPieces[currentPiece.attr('id')].isCorrect;
            self.showMessageAnswer(isCorrectPiece);
        } else {
            isCorrectPiece = true;
        }

        //Veficar se o bool da currentPiece, modificado pelas funções isCorrect.
        var currentPiece = $('.currentPiece');
        if (Meet.domCobject.cobject.template_code !== 'TXT') {
            //Salva o estado do Usuário, assim que resolve a questão
            //cobject_block_id + actor_id = PK
            self.saveBreakPoint(currentPiece.attr('id'));
            //Calcula o Score
            Meet.scoreCalculator(false);
        }

        //Avanço de Questão
        currentPiece.removeClass('currentPiece');
        currentPiece.hide();
        if (currentPiece.next().size() === 0) {
            //Acabou Peça, passa pra outra PieceSet se houver
            var currentPieceSet = $('.currentPieceSet');
            currentPieceSet.removeClass('currentPieceSet');
            currentPieceSet.hide();

            if (currentPieceSet.next().size() === 0) {
                //Acabou todas as pieceSets dessa Tela
                // Passa pra a pŕoxima PieceSet
                var currentScreen = $('.currentScreen');
                currentScreen.removeClass('currentScreen');
                currentScreen.hide();
                var nextScreen = currentScreen.next();

                if (nextScreen.size() !== 0) {
                    nextScreen.addClass('currentScreen');
                    nextScreen.show();
                    nextScreen.find('.pieceset:eq(0)').addClass('currentPieceSet');
                    nextScreen.find('.piece:eq(0)').addClass('currentPiece');
                    nextScreen.find('.pieceset:eq(0), .piece:eq(0)').show();
                } else {
                    //Finalizou todas as Screen do COBJECT Corrente
                    //Vai para a próxima atividade de acordo com o Modo do Render
                    if (Meet.render_mode == 'evaluation') {
                        //Modo Avaliação
                        if (self.meetEvaluation.hasNextCobjectInBlock()) {
                            //Carrega próxima atividade se permitido
                            self.meetEvaluation.loadNextCobjectInBlock(true);

                        } else {
                            //Finalizou o Bloco de Atividades
                            Meet.messageFinishedLevel();
                        }

                    } else if (Meet.render_mode == 'proficiency') {

                    } else if (Meet.render_mode == 'training') {

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

        //Verificar se ainda é TXT
        //Se for o Tipo Texto o Cobject Corrent, então add passar páginas
        if (Meet.domCobject.cobject.template_code === 'TXT') {
            BtnPageTXT();
        } else {
            NoBtnPageTXT();
        }

        //======================================================================
    };

    Meet.messageFinishedLevel = function() {
        $('.cobject_block').hide();
        $('#finishLevel-message').show();
        $('#finishLevel-message button').bind('tap', function() {
            $('#finishLevel-message').hide();
        });
    }

    this.prevPiece = function() {
        var currentPiece = $('.currentPiece');
        //Se for PRE então Verificar ser está correto
        if (Meet.domCobject.cobject.template_code === 'PRE') {
            self.isCorrectPRE(currentPiece.attr('id'));
        }

        var isCorrectPiece;
        //Salva no BD somente se o template for != TXT
        if (Meet.domCobject.cobject.template_code !== 'TXT') {
            //Salva na PerformanceUser ?
            // self.savePerformanceUsr(currentPiece.attr('id'));
            isCorrectPiece = Meet.domCobject.mainPieces[currentPiece.attr('id')].isCorrect;
            self.showMessageAnswer(isCorrectPiece);
        } else {
            isCorrectPiece = true;
        }

        //Veficar se o bool da currentPiece, modificado pelas funções isCorrect.
        if (isCorrectPiece || !isCorrectPiece) {
            if (Meet.domCobject.cobject.template_code !== 'TXT') {
                //Salva o estado do Usuário, assim que resolve a questão
                //cobject_block_id + actor_id = PK
                self.saveBreakPoint(currentPiece.attr('id'));

                //Calcula o Score
                Meet.scoreCalculator(false);
            }

            currentPiece.removeClass('currentPiece');
            currentPiece.hide();
            if (currentPiece.prev().size() === 0) {
                //Acabou Peça, passa pra outra PieceSet se houver
                var currentPieceSet = $('.currentPieceSet');
                currentPieceSet.removeClass('currentPieceSet');
                currentPieceSet.hide();

                if (currentPieceSet.prev().size() === 0) {
                    //Acabou todas as pieceSets dessa Tela
                    // Passa pra a pŕoxima PieceSet
                    var currentScreen = $('.currentScreen');
                    currentScreen.removeClass('currentScreen');
                    currentScreen.hide();
                    var prevScreen = currentScreen.prev();

                    if (prevScreen.size() !== 0) {
                        prevScreen.addClass('currentScreen');
                        prevScreen.show();
                        prevScreen.find('.pieceset').last().addClass('currentPieceSet');
                        prevScreen.find('.piece').last().addClass('currentPiece');
                        prevScreen.find('.pieceset').last().show();
                        prevScreen.find('.piece').last().show();
                    } else {
                        //Finalisou todas as Screen do COBJECT Corrente
                        if (self.hasPrevCobjectInBlock()) {
                            var idxPrevCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id) - 1;
                            var prevCobjectID = self.cobjectsInBlock[idxPrevCobject]['cobject_id'];
                            //Criar a Dom do Cobject Anterior
                            Meet.domCobjectBuild(prevCobjectID);

                        } else {
                            //Está na Primeira Peça
                            //alert('Está na Primeira Peça');
                        }

                    }

                } else {
                    var nextPieceSet = currentPieceSet.prev();
                    nextPieceSet.addClass('currentPieceSet');
                    nextPieceSet.show();

                    var nextPiece = nextPieceSet.find('.piece').last();
                    nextPiece.addClass('currentPiece');
                    nextPiece.show();
                }
            } else {
                var nextPiece = currentPiece.prev();
                nextPiece.addClass('currentPiece');
                nextPiece.show();
            }

        } else {
            //Fica resolvendo a mesma Atividade até acertar
            //                    var info_state = {
            //                        cobject_block_id: self.cobject_block_id,
            //                        actor_id: Meet.actor,
            //                        last_piece_id: null,
            //                        qtd_correct: Meet.peformance_qtd_correct,
            //                        qtd_wrong: Meet.peformance_qtd_wrong,
            //                        currentCobject_idx: null
            //                    };
            //                    Meet.DB_synapse.NewORUpdateUserState(info_state);
            //                    //Calcula o Score
            //                    Meet.scoreCalculator(false);

        }
        //Verificar se ainda é TXT
        //Se for o Tipo Texto o Cobject Corrent, então add passar páginas
        if (Meet.domCobject.cobject.template_code === 'TXT') {
            BtnPageTXT();
        } else {
            NoBtnPageTXT();
        }

    };

    var BtnPageTXT = function() {
        $('.game').hide();
        $('#nextPage').show();
        //Verificar se mostrará o botão pra voltar o TXT
        if (self.hasPrevPieceTXT()) {
            $('#lastPage').show();
        } else {
            $('#lastPage').hide();
        }
        $('.nextPiece').hide();
    };

    var NoBtnPageTXT = function() {
        $('.game').show();
        $('#nextPage').hide();
        $('#lastPage').hide();
    };

    /**
     * Inicializa eventos do MTE
     *
     * @returns {void}
     */
    this.init_MTE = function() {
        // self.init_Common();
        $('.cobject.MTE div[group]').bind('tap', function() {
            //Se já foi clicado
            if ($(this).hasClass('last_clicked')) {
                $('.nextPiece').hide();
                $(this).css('border', '3px solid transparent');
                $(this).removeClass('last_clicked');
            } else {
                var siblings = $(this).siblings();
                $(this).css('border', '3px dashed #FBB03B');
                var siblings = $(this).siblings();
                siblings.css('border', '3px solid transparent');
                siblings.removeClass('last_clicked');
                $(this).addClass('last_clicked');
                $('.nextPiece').show();
            }

            //Primeiro Verificar se a Piece está certa!
            var pieceID = $(this).closest('.piece').attr('id');
            self.isCorrectMTE(pieceID, $(this).attr('group'));
            //Somente salva no BD no botão: Próxima Piece
        });

    };

    /**
     * Inicializa eventos do AEL
     *
     * @returns {void}
     */
    this.init_AEL = function() {
        // variável de encontro definida no meet.php
        //$('.cobject.AEL div.answer > div[group]').hide();
        $('.cobject.AEL div.answer > div[group]').css('opacity', '0.6');
        $('.cobject.AEL div[group]').bind('tap', function() {
            var ask_answer = $(this).parents('div');
            if (ask_answer.hasClass('ask')) {
                if (!$(this).hasClass('ael_clicked')) {
                    $('.nextPiece').hide();
                    $(this).css('border', '3px dashed #FBB03B');
                    $(this).siblings().hide();
                    // $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(300);
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').css('opacity', '1');
                    $(this).addClass('ael_clicked');
                    $(this).addClass('last_clicked');
                } else {
                    $(this).css('border', '3px dashed transparent');
                    $(this).siblings(':not(.ael_clicked)').show();
                    // $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').hide(500);
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').css('opacity', '0.6');
                    $(this).removeClass('ael_clicked');
                    $(this).removeClass('last_clicked');
                }
            } else if (ask_answer.hasClass('answer')) {
                var lastClicked = $(this).closest('div.answer').siblings('div.ask').children('div[group].last_clicked');
                //Só poderá realizar ação de clicou em algum elemento ask
                if (lastClicked.size() > 0) {
                    //Time de resposta
                    var time_answer = (new Date().getTime() - self.interval_group);
                    //Atualizar o marcador de inicio do intervalo para cada resposta
                    self.interval_group = time_answer;
                    //$(this).siblings().hide();
                    $(this).siblings().css('opacity', '0.6');
                    $(this).hide();
                    $(this).closest('div.answer').siblings('div.ask').children('div[group]:not(.ael_clicked)').show(300);

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
                    if ($(this).siblings('div[group]:not(.ael_clicked)').size() === 0) {
                        //Não existe mais elementos a clicar, Habilita o botão de avançar
                        $('.nextPiece').show();
                    }

                    //Respondeu, então "reinicia" o temporizador de grupo
                    self.interval_group = new Date().getTime();
                }
            }
        });

    };

    /**
     * Inicializa eventos do DDROP
     *
     * @returns {void}
     */
    this.init_DDROP = function() {
        //Definir Animação Drag and Drop
        $('.drop').css('opacity', '0.6');

        $('.drag').draggable({
            containment: "body",
            revert: true,
            start: function() {
                //armazernar posição  Original
                var position = $(this).position();
                if (!self.isset($(this).attr('OriginalLeft'))) {
                    $(this).attr('OriginalTop', position.top);
                    $(this).attr('OriginalLeft', position.left);
                }

                $(this).closest('.ask').siblings('.answer').children('.drop').css('opacity', '1');
                $(this).css('border', '3px dashed #FBB03B');
                $(this).siblings().css('opacity', '0');
                $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(300);
                $(this).siblings('.drag').removeClass('last_clicked');
                $(this).addClass('last_clicked');
            },
            stop: function() {
                $(this).css('border', '3px solid transparent');
                $(this).siblings(':not(.ael_clicked)').css('opacity', '1');
                $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').css('opacity', '0.6');

                var position = $(this).position();
                if ($(this).attr('OriginalLeft') !== position.left || $(this).attr('OriginalTop') !== position.top) {
                    $(this).css('left', $(this).attr('OriginalLeft'));
                    $(this).css('top', $(this).attr('OriginalTop'));

                }

            },
            drag: function() {}


        });

        $('.drop').droppable({
            drop: function(event, ui) {

                //Time de resposta
                var time_answer = (new Date().getTime() - self.interval_group);
                //Atualizar o marcador de inicio do intervalo para cada resposta
                self.interval_group = time_answer;
                $(this).siblings().css('opacity', '0.6');
                $(this).hide();
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
                if ($(this).siblings('div[group]:not(.ael_clicked)').size() === 0) {
                    //Não existe mais elementos a clicar, Habilita o botão de avançar peça
                    $('.nextPiece').show();
                }

                //Respondeu, então "reinicia" o temporizador de grupo
                self.interval_group = new Date().getTime();

            }


        });

    };

    /**
     * Inicializa eventos do ONEDDROP
     *
     * @returns {void}
     */
    this.init_ONEDDROP = function() {
        //Definir Animação Drag and Drop
        $('.oneDrop').css('opacity', '0.6');

        $('.oneDrag').draggable({
            containment: "body",
            revert: true,
            start: function() {
                //armazernar posição  Original
                var position = $(this).position();
                if (!self.isset($(this).attr('OriginalLeft'))) {
                    $(this).attr('OriginalTop', position.top);
                    $(this).attr('OriginalLeft', position.left);
                }

                $(this).closest('.ask').siblings('.answer').children('.drop').css('opacity', '1');
                $(this).css('border', '3px dashed #FBB03B');
                $(this).siblings().css('opacity', '0');
                $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(300);
                $(this).siblings('.drag').removeClass('last_clicked');
                $(this).addClass('last_clicked');
            },
            stop: function() {
                $(this).css('border', '3px solid transparent');
                $(this).siblings(':not(.ael_clicked)').css('opacity', '1');
                $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').css('opacity', '0.6');

                var position = $(this).position();
                if ($(this).attr('OriginalLeft') !== position.left || $(this).attr('OriginalTop') !== position.top) {
                    $(this).css('left', $(this).attr('OriginalLeft'));
                    $(this).css('top', $(this).attr('OriginalTop'));

                }

            },
            drag: function() {}


        });

        $('.oneDrop').droppable({
            drop: function(event, ui) {

                //Time de resposta
                var time_answer = (new Date().getTime() - self.interval_group);
                //Atualizar o marcador de inicio do intervalo para cada resposta
                self.interval_group = time_answer;
                $(this).hide();
                $(this).siblings().hide();
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

                //Não existe mais elementos a clicar, Habilita o botão de avançar peça
                $('.nextPiece').show();

                //Respondeu, então "reinicia" o temporizador de grupo
                self.interval_group = new Date().getTime();

            }

        });

    };

    /**
     * Inicializa eventos do PRE
     *
     * @returns {void}
     */
    this.init_PRE = function() {
        //  self.init_Common();
        $('input.text').on('keyup', function() {
            if (!self.isEmpty($(this).val())) {
                //contém algum caractere
                $('.nextPiece').show();
            } else {
                $('.nextPiece').hide();
            }
        });
    };

    /**
     * Inicializa eventos do TXT
     *
     * @returns {void}
     */
    this.init_TXT = function() {
        $('#nextPage').bind('tap', function() {
            self.nextPiece();
        });
        $('#lastPage').bind('tap', function() {
            if (self.hasPrevPieceTXT()) {
                self.prevPiece();
            }

        });
    };

    /**
     * Inicializa eventos do PLC
     *
     * @returns {void}
     */
    this.init_DIG = function() {
        // $.event.special.tap.tapholdThreshold = 250;

        //HighLight
        $('.DIG-table td').on('mousedown touchstart', function() {
            var currentPiece = $(this).closest('.piece');
            var posBegin = $(this).position();
            var posBeginLeft = posBegin.left;
            var posBeginTop = posBegin.top;
            //Encontrar o Primeiro HighLight Hide
            var firstDivHighLight;
            var finishedSearchWord = true;

            currentPiece.find('.digHighlight').each(function() {
                if (!$(this).is(':visible')) {
                    //Hide
                    //Remove  a classe currentSelected de todos as divs HL
                    $(this).closest('.piece').find('.digHighlight').removeClass('currentSelected');
                    firstDivHighLight = $(this);
                    finishedSearchWord = false;
                    //Add classe .seleted nesta div
                    $(this).addClass('currentSelected');
                    $(this).addClass('selected');
                    return false;
                }
            });

            if (!finishedSearchWord) {
                firstDivHighLight.css({
                    'left': posBeginLeft + 1,
                    'top': posBeginTop
                });
                $(this).addClass('firstSelected');
                $(this).addClass('currentStart');
                // $(this).addClass('selected');

                firstDivHighLight.show();
            }
        });

        //Se for disparo um evento touchMove
        $(".DIG-table td").on('vmousemove', function(event) {
            var currentPiece = $(this).closest('.piece');
            var currentCellStart = currentPiece.find('.DIG-table td.currentStart');
            var elementAtual = document.elementFromPoint(event.pageX, event.pageY);
            var isTdDIGTable = $(elementAtual).closest(".DIG-table").size() !== 0;
            if ($(elementAtual).get(0).nodeName === "TD" && isTdDIGTable && currentCellStart.size() !== 0) {
                //É uma célula TD com uma letra, e há uma célula que iniciou a seleção corrente
                $(elementAtual).trigger('mouseover');
            }
        });



        $('.DIG-table td').on('mouseover', function() {
            var currentPiece = $(this).closest('.piece');
            //última Div High Light Selecionada
            var currentDivHighLight = currentPiece.find('.digHighlight.currentSelected');
            var currentCellStart = currentPiece.find('.DIG-table td.currentStart');
            var rowFirst = currentCellStart.attr('row');
            var colFirst = currentCellStart.attr('col');
            var indexColStartCurrent = currentCellStart.index();
            var indexRowCurrent = $(this).closest('tr').index();
            var indexRowStartCurrent = currentCellStart.closest('tr').index();
            var posCurrentDivHighLight = currentDivHighLight.position();
            var sizeCell = currentPiece.find('.DIG-table td:eq(0)').width();
            if (self.isset(posCurrentDivHighLight)) {
                var indexCurrent = $(this).index();
                if ($(this).attr('row') === rowFirst || $(this).attr('col') === colFirst) {
                    if ($(this).attr('row') === rowFirst && $(this).attr('col') !== colFirst &&
                        currentDivHighLight.height() < (2 * currentCellStart.height())) {
                        //Estar na mesma Linha da Primeira Célula clicada
                        // E Se a Altura  da div HighLIght < 2*(currentCellStart)
                        if (indexCurrent > indexColStartCurrent) {
                            //Centro ou Indo pra Direita
                            var sizeSelected = (indexCurrent - indexColStartCurrent) + 1;
                            var distance = (sizeSelected * sizeCell);
                            currentDivHighLight.css('width', distance);
                            //Add .selected em toda célula da primeira até posição corrente
                            //                            for (var idx = indexColStartCurrent; idx <= indexCurrent; idx++) {
                            //                                currentPiece.find('.DIG-table tr').eq(indexRowCurrent).find('td').eq(idx).addClass('selected');
                            //                            }
                        } else if (indexCurrent < indexColStartCurrent) {
                            //Indo para a Esquerda
                            //Posição de ínicio se Desloca
                            var sizeSelected = (indexColStartCurrent - indexCurrent) + 1;
                            var distance = (sizeSelected * sizeCell);
                            var oldWidthDivHighLight = currentDivHighLight.width();
                            //Verificar se ocorreu alguma alteração no tamanho
                            if (oldWidthDivHighLight !== distance) {
                                var increase = Math.abs(distance - oldWidthDivHighLight);
                                currentDivHighLight.css('width', distance);
                                //Add .selected em toda célula da primeira até posição corrente
                                //                                for (var idx = indexColStartCurrent; idx >= indexCurrent; idx--) {
                                //                                    currentPiece.find('.DIG-table tr').eq(indexRowCurrent).find('td').eq(idx).addClass('selected');
                                //                                }

                                if (oldWidthDivHighLight < distance) {
                                    //Aumentou
                                    currentDivHighLight.css('left', (posCurrentDivHighLight.left - increase) + 1);
                                } else {
                                    //Diminuiu
                                    currentDivHighLight.css('left', (posCurrentDivHighLight.left + increase) + 1);
                                }

                            }
                        }

                    } else if ($(this).attr('col') === colFirst && $(this).attr('row') !== rowFirst &&
                        currentDivHighLight.width() < (2 * currentCellStart.width())) {
                        //Estar na Mesma Coluna da Primeira Célula clicada
                        // E Se a Largura  da div HighLight < 2*(Largura da currentCellStart)
                        if (indexRowCurrent > indexRowStartCurrent) {
                            //Indo pra Baixo
                            var sizeSelected = (indexRowCurrent - indexRowStartCurrent) + 1;
                            var distance = (sizeSelected * sizeCell);
                            currentDivHighLight.css('height', distance);
                            //Add .selected em toda célula da primeira até posição corrente
                            //                            for (var idx = indexRowStartCurrent; idx <= indexRowCurrent; idx++) {
                            //                                currentPiece.find('.DIG-table tr').eq(idx).find('td').eq(indexColStartCurrent).addClass('selected');
                            //                            }
                        } else if (indexRowCurrent < indexRowStartCurrent) {
                            //Indo para Cima
                            //Posição de ínicio se Desloca
                            var sizeSelected = (indexRowStartCurrent - indexRowCurrent) + 1;
                            var distance = (sizeSelected * sizeCell);
                            var oldHeightDivHighLight = currentDivHighLight.height();
                            //Verificar se ocorreu alguma alteração no tamanho
                            if (oldHeightDivHighLight !== distance) {
                                var increase = Math.abs(distance - oldHeightDivHighLight);
                                currentDivHighLight.css('height', distance);
                                //Add .selected em toda célula da primeira até posição corrente
                                //                                for (var idx = indexRowStartCurrent; idx >= indexRowCurrent; idx--) {
                                //                                    currentPiece.find('.DIG-table tr').eq(idx).find('td').eq(indexColStartCurrent).addClass('selected');
                                //                                }

                                if (oldHeightDivHighLight < distance) {
                                    //Aumentou
                                    currentDivHighLight.css('top', (posCurrentDivHighLight.top - increase) + 1);
                                } else {
                                    //Diminuiu
                                    currentDivHighLight.css('top', (posCurrentDivHighLight.top + increase) + 1);
                                }

                            }
                        }
                    } else {
                        //Estar de volta a Célula CurrentStart
                        //É igual
                        var positionCurrentCellStart = currentCellStart.position();
                        //Diminui o tamnho da Div HighLight
                        currentDivHighLight.css('width', sizeCell);
                        currentDivHighLight.css({
                            'left': positionCurrentCellStart.left + 1,
                            'top': positionCurrentCellStart.top
                        });

                        currentDivHighLight.css('height', sizeCell);
                        currentDivHighLight.css({
                            'left': positionCurrentCellStart.left,
                            'top': positionCurrentCellStart.top + 1
                        });

                    }

                }
            }
        });


        //Se for disparo um evento touchEnd
        $(".DIG-table td").on('vmouseup', function(event) {
            var currentPiece = $(this).closest('.piece');
            var currentCellStart = currentPiece.find('.DIG-table td.currentStart');
            var elementAtual = document.elementFromPoint(event.pageX, event.pageY);
            elementAtual = $(elementAtual);
            var isTdDIGTable = elementAtual.closest(".DIG-table").size() !== 0;
            if (isTdDIGTable && currentCellStart.size() !== 0) {
                if (elementAtual.get(0).nodeName !== "TD") {
                    //Então é um filho de TD
                    elementAtual = elementAtual.closest('td');
                }
                //É uma célula TD com uma letra, e há uma célula que iniciou a seleção corrente
                elementAtual.trigger('mouseup');
            }
        });



        $('.DIG-table td').on('mouseup', function() {
            var currentPiece = $(this).closest('.piece');

            //Armazenar na div high Light a posição da matriz
            //que inicia e termina a palavra selecionada atual
            var currentStart = currentPiece.find('.DIG-table td.currentStart');
            var posStart = currentStart.attr('row') + "_" + currentStart.attr('col');
            var posFinish = $(this).attr('row') + "_" + $(this).attr('col');
            var currentDivHighLight = currentPiece.find('.DIG-table .digHighlight.currentSelected');
            currentDivHighLight.attr('posStart', posStart);
            currentDivHighLight.attr('posFinish', posFinish);

            currentStart.removeClass('currentStart');
            $(this).addClass('lastSelected');

            if (currentPiece.find('.DIG-table .digHighlight:not(.selected)').size() === 0) {
                //Selecionou Todas as Palavras referentes a imagem
                var pieceID = $('.currentPiece').attr('id');
                var allDivHighLight = currentPiece.find('.DIG-table .digHighlight');
                //Armazenar as palavras selecionadas num Array
                var listWords = new Array();
                allDivHighLight.each(function() {
                    var posStart = $(this).attr('posStart');
                    var posFinish = $(this).attr('posFinish');
                    var rowStart = posStart.split('_')[0];
                    var colStart = posStart.split('_')[1];
                    var rowFinish = posFinish.split('_')[0];
                    var colFinish = posFinish.split('_')[1];
                    var word = "";
                    if (rowStart === rowFinish) {
                        //Possui a mesma Linha
                        var minCol = Math.min(colStart, colFinish);
                        var maxCol = Math.max(colStart, colFinish);
                        for (var col = minCol; col <= maxCol; col++) {
                            //Percorre todas as colunas selecionadas
                            word += currentPiece.find('.DIG-table').find('td[row="' + rowStart + '"][col="' + col + '"]').text();
                        }

                    } else if (colStart === colFinish) {
                        //Possui a mesma Coluna
                        var minRow = Math.min(rowStart, rowFinish);
                        var maxRow = Math.max(rowStart, rowFinish);
                        for (var row = minRow; row <= maxRow; row++) {
                            //Percorre todas as linhas selecionadas
                            word += currentPiece.find('.DIG-table').find('td[row="' + row + '"][col="' + colStart + '"]').text();
                        }
                    }
                    listWords.push(word);
                });

                self.isCorrectDIG(pieceID, listWords);
                $('.nextPiece').show();
            }


        });

    };

    /**
     * Inicializa eventos do PLC
     *
     * @returns {void}
     */
    this.init_PLC = function() {
        $('input.PLC-input').attr('disabled', 'disabled');

        var elementsImagePiece = $('div.PLC.group').find('div.elementImage');
        elementsImagePiece.css('cursor', 'pointer');

        elementsImagePiece.on('tap', function() {
            var currentPiece = $('.currentPiece');
            var elementsImagePiece = currentPiece.find('div.PLC.group').find('div.elementImage');
            elementsImagePiece.removeClass('selectedItem');
            var inputsPLC = currentPiece.find('.PLC-input');
            inputsPLC.attr('disabled', 'disabled');

            $(this).addClass('selectedItem');
            var wordClicked = $(this).attr('word');

            //Habilitar todos os inputs que referente à apalavra da imagem clicada
            currentPiece.find('.PLC-input[word=' + wordClicked + ']').each(function(idx) {
                if (idx == 0) {
                    $(this).focus();
                }
                $(this).removeAttr('disabled');
            });


        });



        $('input.PLC-input').on('keyup', function(e) {
            //            if (e.keyCode === 8) {
            //                console.log('8');
            //                $(this).attr('value', "");
            //                var inputs = $(this).closest('.PLC-table').find(':input');
            //                inputs.eq(inputs.index(this) - 1).focus();
            //            }

            if (!self.isEmpty($(this).val())) {
                var val = $(this).attr('value');
                if (val === ' ') {
                    $(this).attr('value', '');
                } else {
                    $(this).attr('value', val.toUpperCase());
                    var inputs = $(this).closest('.PLC-table').
                    find('input:not(:disabled):not([readonly])');
                    inputs.eq(inputs.index(this) + 1).focus();
                }
            }
            var pieceID = $('.currentPiece').attr('id');
            var wordNum = $(this).attr('word');
            var totalInputs = $(".PLC-input").length;
            var totalAnswered = $(".PLC-input[value!=]").length;
            if (totalInputs === totalAnswered) {
                self.isCorrectPLC(pieceID);
                $('.nextPiece').show();
            } else {
                $('.nextPiece').hide();
            }
        });

        $('input.PLC-input').on('focus', function() {
            if (!$(this).is('[readonly]')) {
                $(this).data('value', $(this).val());
                $(this).attr('value', '');
            }
        });

        $('input.PLC-input').on('focusout', function() {
            if (!$(this).is('[readonly]')) {
                if ($(this).val() == '') {
                    $(this).attr('value', $(this).data('value'));
                }
            }
        });

    };

    //Inicializa os eventos do template Desenho
    this.init_DES = function() {
        //Iniciar Seleção
        $('div.draw-point').on('mousedown touchstart', function() {
            //Armazena antes de tudo o conjunto de classes antigas.
            //Para no futuro poder ser retornada, caso o traço seja cancelado(quanto o mesmo ponto de sto = start)
            $(this).data('oldClass', $(this).attr('class'));


            var currentPiece = $(this).closest('.piece');
            var divCurrentDraw = currentPiece.find("div.draw");
            //Add Nova Div HighLight, nesta Piece
            divCurrentDraw.find('div.Table').append("<div class='desHighLight' ></div>");

            var posBegin = $(this).position();
            var posBeginLeft = posBegin.left;
            var posBeginTop = posBegin.top;
            //Encontrar o Primeiro HighLight Hide
            var allDivHighLight = currentPiece.find('.desHighLight');
            var divCurrentHighLight = allDivHighLight.last();

            divCurrentHighLight.attr('id', 'hl' + allDivHighLight.size());

            //Remove a classe currentSelected, das outras divsHighLight
            allDivHighLight.removeClass('currentSelected');
            //Add classe .seleted nesta div
            divCurrentHighLight.addClass('currentSelected');

            var incrLeft = ($('.draw-point').width() / 3) + 8;
            var incrTop = ($('.draw-point').height() / 3) + 8;

            divCurrentHighLight.css({
                'left': posBeginLeft + incrLeft,
                'top': posBeginTop + incrTop
            });
            //Deixar para verificar se o lastSelected seŕá na mesma div. E assim fecha a figura(corretamente)
            if (divCurrentDraw.find('.firstSelected').size() === 0) {
                $(this).addClass('firstSelected');
            }

            //Verificar se é uma extremidade
            //Ou seja se iniciou num ponto que nunca foi desenhado
            if (!$(this).hasClass('selected')) {
                $(this).addClass('extremity');
            } else {
                //Se já foi selecionado, e possui uma classe extremity, remove-a
                //$(this)
            }

            //Já foi desenhado
            $(this).addClass('selected');

            //É o início de um Traço
            $(this).addClass('start');

            //É um início mais novo
            $(this).addClass('currentStart');

            //Retira, se existitr a classe .stop. E não for final
            //de um desenho válido
            if (!$(this).hasClass('endCorrectDES')) {
                $(this).removeClass('stop');
            }

            divCurrentHighLight.show();

        });


        //Se for disparo um evento touchMove
        $("div.draw-point").on('vmousemove', function(event) {
            var currentCellStart = $(this).closest('div.Table').find('div.currentStart');
            var elementAtual = document.elementFromPoint(event.pageX, event.pageY);

            if ($(elementAtual).hasClass('draw-point') && currentCellStart.size() !== 0) {
                //É uma célula div e há uma célula que iniciou a seleção corrente
                //Somente
                $(elementAtual).trigger('mouseover');
            }
        });

        self.hasEquivalentAngle = function(angle1, angle2) {
            if (angle1 <= 0) {
                angle1 = parseInt(angle1) + 180;
            }

            if (angle2 <= 0) {
                angle2 = parseInt(angle2) + 180;
            }

            return angle1 == angle2;
        }

        $('div.draw-point').on('mouseover', function() {

            var currentPiece = $(this).closest('.piece');
            var divCurrentHighLight = currentPiece.find('.desHighLight.currentSelected');
            var currentStartPoint = currentPiece.find('div.draw-point.currentStart');
            //Verificar se existe o draw-point current Start
            if (currentStartPoint.size() > 0) {

                //Adiciona a classe para indicar que este ponto foi o último a ser selecionado
                var lastSelected = currentPiece.find('div.draw-point.lastSelected');
                lastSelected.removeClass('lastSelected');
                $(this).addClass('lastSelected');

                //Calcular ângulo entre a posição do currentStartPoint e a posição Point corrente
                var x1 = currentStartPoint.offset().left;
                var y1 = currentStartPoint.offset().top;
                var x2 = $(this).offset().left;
                var y2 = $(this).offset().top;

                //Calcula o angulo Atual
                var angle = self.calcAngleBetween2Points(x1, y1, x2, y2);

                var angleDivCurrent = divCurrentHighLight.attr('angle');

                if (self.isset(angleDivCurrent) && !self.hasEquivalentAngle(angleDivCurrent, angle)) {
                    //Se o ângulo durante o movimento mudar. Cria uma nova Div.highLight
                    //Procura o último draw-point para esta highLight. E finaliza o Traço para a highLight corrente
                    var lastCurrentDrawPoint = currentPiece.find('div.draw-point.stop.' + divCurrentHighLight.attr('id'));

                    //Sera marcado como um vértice
                    lastCurrentDrawPoint.addClass('vertex');

                    lastCurrentDrawPoint.trigger('mouseup');
                    //Depois Inicia um novo HighLight
                    lastCurrentDrawPoint.trigger('mousedown');
                    //add a classe referente ao novo highLight
                    var newIdDivCurrentHighLight = currentPiece.find('.desHighLight.currentSelected').attr('id');
                    lastCurrentDrawPoint.addClass(newIdDivCurrentHighLight);

                } else {
                    //Traçando com o mesmo Ângulo
                    // 1- Verificar se Acessará um ponto, onde outra div de diferente ângulo já passou sobre ele.
                    var currentPoint = $(this);
                    var continueDash = false;

                    if (self.isset(angleDivCurrent)) {
                        //Se existir um ângulo formado por essa div
                        if (!currentPoint.hasClass('vertex')) {
                            $(this).closest('.Table').find('div.desHighLight').each(function() {
                                if (currentPoint.hasClass($(this).attr('id'))) {
                                    //O Point foi 'riscado' com o highLight corrente
                                    //Verifica, se o ângulo do hl atual é diferente desse hl
                                    var angleThisHl = $(this).attr('angle');

                                    if (!self.hasEquivalentAngle(angleDivCurrent, angleThisHl)) {
                                        //É um vértice
                                        currentPoint.addClass('vertex');
                                        //Sai do each
                                        return false;
                                    }
                                }

                            });
                        }

                        // 1.2- Verificar se Iniciou o traço atual onde outra div de diferente ângulo já passou sobre ele.
                        if (!currentStartPoint.hasClass('vertex')) {
                            $(this).closest('.Table').find('div.desHighLight').each(function() {
                                if ($(this).attr('id') != divCurrentHighLight.attr('id') &&
                                    currentStartPoint.hasClass($(this).attr('id'))) {
                                    // O StartPoint possui uma outra HighLight
                                    //Verifica, se o ângulo do hl atual é diferente desse hl
                                    var angleThisHl = $(this).attr('angle');
                                    if (!self.hasEquivalentAngle(angleDivCurrent, angleThisHl)) {
                                        //É um vértice
                                        currentStartPoint.addClass('vertex');
                                        //Sai do each
                                        return false;
                                    }
                                }

                            });
                        }

                        //Somente se não existir o atributo dash(ou seja, é então um Início do traço)
                        if (!self.isset(divCurrentHighLight.attr('dash'))) {
                            //Então verificar se há algum HL no startPoint
                            //Com ângulo equivalente, e assim obterá seu dash
                            var startClass = currentStartPoint.attr('class');
                            var startHls = startClass.match(/hl\d/g);
                            var startHLSameDashe = null;

                            for (var idx in startHls) {
                                var hl = currentPiece.find('div.desHighLight#' + startHls[idx]);
                                //Procurar um outro hl(com mesmo ângulo) que passa por esse ponto
                                if (hl.attr('id') !== divCurrentHighLight.attr('id') &&
                                    self.hasEquivalentAngle(hl.attr('angle'), angleDivCurrent)) {
                                    startHLSameDashe = hl;
                                    //Encontrou um traço equivalente
                                    break;
                                }

                            }


                            if (startHLSameDashe !== null) {
                                //Então o traço do currentHighLight
                                //será o mesmo traço que o startHLSameDashe
                                divCurrentHighLight.attr('dash', startHLSameDashe.attr('dash'));
                            } else {
                                // Iniciará um novo e independete traço
                                //Armezenar qual traço ele representa, dashs
                                var newDashe = currentPiece.find('div.desHighLight').size() + 1;
                                divCurrentHighLight.attr('dash', newDashe);
                            }

                        }


                        //Quando passar sobre cada draw-Point, verificar se está continuando um traço já existente.
                        //E assim sempre muda o atributo dash de todos os Hls conectados com o Hl atual novo
                        //Atualizando assim todos esses Hls para o Hls do draw-point atual que já fazia parte do traço

                        var thisClass = $(this).attr('class');
                        var thisHls = thisClass.match(/hl\d/g);
                        var thisHLSameDashe = null;

                        for (var idx in thisHls) {
                            var hl = currentPiece.find('div.desHighLight#' + thisHls[idx]);
                            //Procurar um outro hl(com mesmo ângulo) que passa por esse ponto
                            if (hl.attr('id') !== divCurrentHighLight.attr('id') &&
                                self.hasEquivalentAngle(hl.attr('angle'), angleDivCurrent)) {
                                thisHLSameDashe = hl;
                                //Encontrou um traço equivalente
                                break;
                            }
                        }


                        if (thisHLSameDashe !== null) {
                            //Então o traço do currentHighLight
                            //será o mesmo traço que o thisHLSameDashe
                            continueDash = true;
                            currentPiece.find('div.desHighLight[dash=' + divCurrentHighLight.attr('dash') +
                                ']').each(
                                function() {
                                    $(this).attr('dash', thisHLSameDashe.attr('dash'));
                                });
                        }


                    }

                    //Não faz algo, quando o HighLight corrente já foi utilizado pra passar sobre este Ponto
                    if (divCurrentHighLight.size() > 0 && !$(this).hasClass(divCurrentHighLight.attr('id'))) {
                        $(this).addClass('selected');

                        //Elimina a classe end do último point do traço atual
                        var currentLastStop =
                            currentPiece.find('.draw-point.' + divCurrentHighLight.attr('id') + '.stop:not(.endCorrectDES)');
                        //Retira, se existitr a classe .stop. E não for final
                        //de um desenho válido
                        currentLastStop.removeClass('stop');

                        $(this).addClass('stop');

                        var divParentStartPoint = currentStartPoint.closest('div.Col');
                        var diameter_point = currentStartPoint.width();

                        //distância entre os pontos
                        var sizeSideCell = divParentStartPoint.width() + (parseInt(divParentStartPoint.css('padding').split('px')[0])) * 2;

                        //Add classe representando o id corrente do HighLight
                        $(this).addClass(divCurrentHighLight.attr('id'));

                        var distanceBtwPoints = 0;

                        //Linha e coluna do StartPoint Corrent
                        var celCurrentStartPoint = currentStartPoint.closest('.Col');
                        var rowStart = celCurrentStartPoint.attr('row');
                        var colStart = celCurrentStartPoint.attr('col');

                        //Linha e Coluna do draw-Point Atual
                        var celCurrentPoint = $(this).closest('.Col');
                        var rowCurrent = celCurrentPoint.attr('row');
                        var colCurrent = celCurrentPoint.attr('col');

                        var sizeCurrentSelectedPoint = 0;

                        //Verificar se não precisa mudar a posição inicial do HighLight
                        var posBegin;
                        var posBeginLeft;
                        var posBeginTop;
                        var incrLeft = +1;
                        var incrTop = -9;

                        if (angle === 0 ||
                            angle === 90 ||
                            angle === 180 ||
                            angle === -90) {
                            //Forma um Reta entre os pontos p1 e p2
                            //Calcular distância entre esses dois pontos
                            //Sentido HORÁRIO => -90, 0, 90, 180
                            if (angle === 0) {
                                //Esqueda para a Direita (verificar diferença das Colunas)
                                sizeCurrentSelectedPoint = Math.abs(colCurrent - colStart) + 1;

                            } else if (angle === 90) {
                                //Cima para baixo
                                sizeCurrentSelectedPoint = Math.abs(rowCurrent - rowStart) + 1;

                            } else if (angle === 180) {
                                //Direita para a Esquerda
                                sizeCurrentSelectedPoint = Math.abs(colStart - colCurrent) + 1;

                            } else if (angle === -90) {
                                //Baixo para Cima
                                sizeCurrentSelectedPoint = Math.abs(rowStart - rowCurrent) + 1;
                            }

                            if (angle === 180 || angle === -90) {
                                //Decrescendo o Rows ou Cols
                                //Precisa Mudar a Posição Inicial do HighLight
                                posBegin = $(this).position();
                                posBeginLeft = posBegin.left;
                                posBeginTop = posBegin.top;

                                incrLeft = (currentStartPoint.width() / 3) + 8;
                                incrTop = (currentStartPoint.height() / 3) + 8;
                            }


                            //Se é o mesmo ponto de inicío, então, não múltiplica por dois o diameter_point
                            var distance = 0;
                            if (sizeCurrentSelectedPoint == 1) {
                                distance = (sizeCurrentSelectedPoint * diameter_point);
                            } else {
                                //Incrementa o 2*diameter_point, pra que ocupe cada ponto
                                distance = (sizeSideCell * sizeCurrentSelectedPoint) -
                                    (sizeSideCell - diameter_point);

                            }

                            if (angle === 0 || angle === 180) {
                                //Horizontal
                                divCurrentHighLight.width(distance);

                            } else if (angle === 90 || angle === -90) {
                                //Vertical
                                divCurrentHighLight.height(distance);
                            }

                            divCurrentHighLight.css({
                                'left': posBeginLeft + incrLeft,
                                'top': posBeginTop + incrTop
                            });


                        } else {
                            //Não forma uma Reta entre os pontos p1 e p2. Será necessário usar o grau
                            //Calcular distância entre esses dois pontos
                            //Sentido HORÁRIO => -90, 0, 90, 180

                            //Calcular a hipotenusa
                            var catetoCol = (colCurrent - colStart) * sizeSideCell;
                            var catetoRow = (rowCurrent - rowStart) * sizeSideCell;

                            //Os catetos ao quadrado sempre serão positivos
                            var hypotenusePoint = Math.sqrt(Math.pow(catetoCol, 2) + Math.pow(catetoRow, 2));
                            //Incrementa o 2*diameter_point, pra que ocupe cada ponto
                            var distance = hypotenusePoint + diameter_point;


                            var originTransform = (diameter_point / 2) + 3;
                            divCurrentHighLight.width(distance);
                            divCurrentHighLight.css("transform", "rotate(" + angle + "deg)");
                            divCurrentHighLight.css("transform-origin", originTransform + "px " + originTransform + "px");

                            //Precisa de Ajuste
                            var currentLeft = divCurrentHighLight.css('left');
                            var currentTop = divCurrentHighLight.css('top');
                            if (catetoRow > 0) {
                                //Cima para Baixo
                                divCurrentHighLight.css({
                                    'left': currentLeft + incrLeft,
                                    'top': currentTop + incrTop
                                });
                            } else {
                                //Baixo para Cima

                            }

                        }

                        if ((x1 != x2) || (y1 != y2)) {
                            // Não é o mesmo ponto que inicio o traço atual
                            //Então existe um ângulo entre estes ponto
                            divCurrentHighLight.attr('angle', angle);
                        }



                    }

                }
            }
        });


        //Se for disparo um evento touchEnd
        //o vmouseup é disparado quando o ponteiro é solto em QUALQUER elemento
        $(document).on('vmouseup', function(event) {
            var currentPiece = $('div.currentPiece');
            var divTable = currentPiece.find('div.Table');
            var currentCellStart = divTable.find('div.currentStart');
            var elementAtual = document.elementFromPoint(event.pageX, event.pageY);

            if (currentCellStart.size() !== 0) {
                //Iniciou um Traço.
                if ($(elementAtual).hasClass('draw-point')) {
                    //É uma célula div e há uma célula que iniciou a seleção corrente
                    $(elementAtual).trigger('mouseup');
                } else {
                    //É um elemento qualquer. Então busca o último point selecionado e dispara o mouseup
                    var lastSelected = divTable.find('div.draw-point.lastSelected');
                    lastSelected.trigger('mouseup');
                }

            }
        });


        $('div.draw-point').on('mouseup', function(event) {
            var currentPiece = $(this).closest('.piece');
            var divCurrentHighLight = currentPiece.find('.desHighLight.currentSelected');
            var currentStartPoint = currentPiece.find('div.draw-point.currentStart');
            //Verificar se foi solto no mesmo ponto que iniciou
            if (currentStartPoint.attr('row') == $(this).attr('row') &&
                currentStartPoint.attr('col') == $(this).attr('col')) {
                //Retorna a classe antiga e remove a currentDivHighLight
                $(this).attr('class', $(this).data('oldClass'));
                divCurrentHighLight.remove();
            }

            //Remove a classe currentSelected, da divCurrentHighLight
            divCurrentHighLight.removeClass('currentSelected');
            //Remove a classe do point que indica onde começou o traço corrente
            currentStartPoint.removeClass('currentStart');
            var firstSelect = currentPiece.find('.firstSelected');

            //Verificar se o ponto corrente é uma extremidade
            var thisClass = $(this).attr('class');
            var thisHls = thisClass.match(/hl\d/g);
            var numHls = 0;
            for (var idx in thisHls) {
                numHls++;
            }


            //Retira todas as classes .extremity dessa currentHl, se o ponto pertencer a mais de um Hl
            var extremityCurrentHl = currentPiece.find('div.draw-point.' + divCurrentHighLight.attr('id') + '.extremity');
            extremityCurrentHl.each(function() {
                //Verificar se há um HighLight diferente do HL corrente
                var thisClass = $(this).attr('class');
                var thisHls = thisClass.match(/hl\d/g);
                var numThisHls = 0;
                for (var idx in thisHls) {
                    numThisHls++;
                }

                if (numThisHls > 1) {
                    //Remove a classe extremity
                    $(this).removeClass('extremity');
                }

            });

            if (numHls === 1) {
                //É uma extremidade
                $(this).addClass('extremity');
            }

            //Verificar se está certo
            var isCorrect = self.isCorrectDES(currentPiece.attr('id'));

            if (isCorrect) {
                $(this).addClass('endCorrectDES');
            }

            //Se encontrar algum traço
            if (currentPiece.find('.desHighLight')) {
                $('.nextPiece').show();
            }

        });

        //Cálculo de angulo entre dois Pontos
        this.calcAngleBetween2Points = function(x1, y1, x2, y2) {
            var dy = y2 - y1;
            var dx = x2 - x1;
            var theta = Math.atan2(dy, dx); // range (-PI, PI]
            theta *= 180 / Math.PI; // rads to degs, range (-180, 180]
            //if (theta < 0) theta = 360 + theta; // range [0, 360)
            return theta;
        }

    }

    this.hasPrevPieceTXT = function() {
        var isTXT = false;
        var currentPiece = $('.currentPiece');
        if (currentPiece.prev().size() === 0) {
            //Acabou Peça, passa pra outra PieceSet se houver
            var currentPieceSet = $('.currentPieceSet');
            if (currentPieceSet.prev().size() === 0) {
                //Acabou todas as pieceSets dessa Tela
                // Passa pra a pŕoxima PieceSet
                var currentScreen = $('.currentScreen');
                var prevScreen = currentScreen.prev();
                if (prevScreen.size() !== 0) {
                    isTXT = prevScreen.find('.piece').last().find('.group').last().hasClass('TXT');
                } else {
                    //Finalizou todas as Screen do COBJECT Corrente
                    if (self.hasPrevCobjectInBlock()) {

                        var idxPrevCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id) - 1;
                        var prevCobject = self.cobjectsInBlock[idxPrevCobject];
                        isTXT = prevCobject['template_code'] === 'TXT';

                    } else {
                        //Está na Primeira Peça
                        isTXT = false;
                    }
                }

            } else {
                var prevPieceSet = currentPieceSet.prev();
                var prevPiece = prevPieceSet.find('.piece').last();
                isTXT = prevPiece.find('.group').last().hasClass('TXT');
            }
        } else {
            var prevPiece = currentPiece.prev();
            isTXT = prevPiece.find('.group').last().hasClass('TXT');
        }

        return isTXT;
    };

    //Salvar PermanceUser
    /**
     * Salva a performace do usuário no banco. Retorna falso caso haja algum erro.
     *
     * @param {DOMString} currentPieceID
     * @returns {boolean}
     */
    this.savePerformanceUsr = function(currentPieceID) {
        //Obtem o intervalo de resolução da Piece
        self.interval_piece = (new Date().getTime() - self.start_time_piece);
        //Se for uma piece do template AEL, então salva cada Match dos grupos realizados
        // e a armazena no objeto piece.isCorrect da piece corrente
        if (Meet.domCobject.cobject.template_code === 'AEL' ||
            Meet.domCobject.cobject.template_code === 'DDROP' ||
            Meet.domCobject.cobject.template_code === 'ONEDDROP') {
            self.saveMatchGroup(currentPieceID);
        }
        //Neste ponto o isTrue da Piece está setado
        //Salva isCorrect da PIECE toda
        var pieceIsTrue = Meet.domCobject.mainPieces[currentPieceID].isCorrect;
        Meet.domCobject.mainPieces[currentPieceID].time_answer = self.interval_piece;
        var data_default = {
            'piece_id': currentPieceID,
            'actor_id': Meet.actor,
            'final_time': self.start_time_piece + self.interval_piece, //TimeStamp quando firmou a resolução da questão
            'interval_resolution': self.interval_piece, //delta T
            'iscorrect': pieceIsTrue
        };
        var data = data_default;
        if (Meet.domCobject.cobject.template_code === 'MTE') {
            //Último grupo clicado da Piece Corrente. Divide por 2 como um grupo ASK
            data.group_id = ($('.currentPiece .last_clicked').attr('group') / currentPieceID) / 2;
        }

        //Salvar na performance_User OffLine
        if (sessionGet('isPreview') == null || sessionGet('isPreview') == -1) {
            Meet.DB_synapse.addPerformance_actor(data);
        }

        if (pieceIsTrue) {
            Meet.peformance_qtd_correct++;
        } else {
            Meet.peformance_qtd_wrong++;
        }

        //Salvo com Sucesso !
        return true;
    };

    this.saveMatchGroup = function(currentPieceID) {
        //Para Cada GRUPO da Piece
        var pieceIsTrue = true;
        var answer = false;
        $.each(Meet.domCobject.mainPieces[currentPieceID], function(nome_attr, group) {
            //Salva a perfomande do groupo somente se foi dado um Match
            if (self.isset(this.groupMatched)) {
                if (nome_attr !== 'istrue' && nome_attr !== 'time_answer') {
                    if (self.isset(group.ismatch) && (!group.ismatch)) {
                        pieceIsTrue = false;
                    } else if (self.isset(group.ismatch) && group.ismatch) {
                        answer = true;
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
                            'actor_id': Meet.actor,
                            /**
                             * @todo Verificar this.time_answer, aparentemente eesta passando com valor nulo.
                             */
                            'final_time': this.time_answer, //delta T
                            'value': "GRP" + current_groupMatched,
                            /**
                             * @todo Verificar this.ismatch, aparentemente eesta passando com valor nulo.
                             */
                            'iscorrect': this.ismatch
                        };
                        //Salvar na performance_User OffLine
                        if (sessionGet('isPreview') == -1) {
                            Meet.DB_synapse.addPerformance_actor(data);
                        }
                    }
                }
            }
        });
        //Salvo com Sucesso
        Meet.domCobject.mainPieces[currentPieceID].isCorrect = (answer && pieceIsTrue);
        return true;
    };

    /**
     * Verifica se esta Correto PLC.
     *
     * @param {integer} pieceID
     * @param {string} groupClicked
     * @returns {Boolean}
     */
    this.isCorrectPLC = function(pieceID) {
        var piece = Meet.domCobject.mainPieces[pieceID];
        var isCorrect = true;
        $.each(piece, function(i, group) {
            if (i[0] === '_') {
                var word = group.elements[0].generalProperties[0].value;
                var row = group.elements[0].pieceElement_Properties.posy;
                var col = group.elements[0].pieceElement_Properties.posx;
                var ori = group.elements[0].pieceElement_Properties.direction.toUpperCase();

                for (var i = 0; i < word.length; i++) {
                    var correctCharactere = word[i];
                    var typedCharactere = $(".PLC-input[row=" + row + "][col=" + col + "]").attr("value");

                    isCorrect = isCorrect && correctCharactere === typedCharactere;

                    if (ori === "H")
                        col++;
                    else
                        row++;
                }
            }
        });

        Meet.domCobject.mainPieces[pieceID].isCorrect = isCorrect;
        return isCorrect;
    };

    /**
     * Verifica se esta Correto DIG.
     *
     * @param {integer} pieceID
     * @param {string} groupClicked
     * @returns {Boolean}
     */
    this.isCorrectDIG = function(pieceID, listWords) {
        var piece = Meet.domCobject.mainPieces[pieceID];
        var isCorrect = true;

        $.each(piece, function(i, group) {
            if (i[0] === '_') {
                var word = group.elements[0].generalProperties[0].value;
                if ($.inArray(word, listWords) === -1) {
                    //Não encontrou a palavra no Array
                    isCorrect = false;
                }

            }
        });

        Meet.domCobject.mainPieces[pieceID].isCorrect = isCorrect;
        return isCorrect;
    };

    /**
     * Verifica se esta Correto MTE.
     *
     * @param {integer} pieceID
     * @param {string} groupClicked
     * @returns {Boolean}
     */
    this.isCorrectMTE = function(pieceID, groupClicked) {
        var elements_group = eval("Meet.domCobject.mainPieces[pieceID]._" + groupClicked);
        //Alterar para comparar com o layertype de todo o grupo
        var isCorrect = (elements_group.elements[0].pieceElement_Properties.layertype === 'Acerto');
        //Só precisar selecionar 1 para atualizar o isCorrect da piece corrente
        Meet.domCobject.mainPieces[pieceID].isCorrect = isCorrect;
        return isCorrect;
    };

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
            //Salvar no Objeto o Metadados do acerto e erro de um element
            var elements_groupAsk = eval("Meet.domCobject.mainPieces[pieceID]._" + groupAskClicked);
            var elements_groupAnswer = eval("Meet.domCobject.mainPieces[pieceID]._" + groupAnswerClicked);

            //Veridicar Match
            var groupRevertAsk = (groupAskClicked / pieceID) / 2;
            var groupRevertAnswer = ((groupAnswerClicked.split('_')[0]) / pieceID) / 3;
            var ismatch = (groupRevertAsk === groupRevertAnswer);
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
    };

    /**
     * Verifica se o PRE esta correto
     *
     * @param {integer} pieceID
     * @returns {Boolean}
     */
    this.isCorrectPRE = function(pieceID) {
        //PRE somente possuí um grupo em cada piece
        var elements_group = eval("Meet.domCobject.mainPieces[pieceID]._" + (pieceID * 2));
        var digitated_value = $('.currentPiece').find('div[group] input.text').val();
        var idxText = null;
        //BUSCAR PROPRIEDADE  = TEXT
        for (var i = 0; i < elements_group.elements[0].generalProperties.length; i++) {
            if (elements_group.elements[0].generalProperties[i].name === 'text') {
                idxText = i;
                break;
            }
        }

        var isCorrect = (elements_group.elements[0].generalProperties[idxText].value.toUpperCase() === digitated_value.toUpperCase());
        //Só precisar selecionar 1 para atualizar o isCorrect da piece corrente
        Meet.domCobject.mainPieces[pieceID].isCorrect = isCorrect;
        return isCorrect;
    };

    this.isCorrectDES = function(pieceID) {
        var currentMainPiece = Meet.domCobject.mainPieces[pieceID];
        var shapeDrawed = self.getCurrentShapeDES();
        var isCorrect = currentMainPiece['type_name'] === "shape" && shapeDrawed === currentMainPiece['shape'];

        //console.log(shapeDrawed);

        //Armazena o resultado no mainPiece
        Meet.domCobject.mainPieces[pieceID].isCorrect = isCorrect;

        return isCorrect;
    };

    this.getCurrentShapeDES = function() {
        var currentAskDraw = $('.currentPiece').find('.draw');
        var numVertex = currentAskDraw.find('div.vertex').size();
        //Verificar se o número de vértices esta entro o aceitável
        //Verificar se os vértices formam uma figura fechada
        //Verificar o tipo de figura que estes vértices formam
        if (numVertex == 3) {
            //Pode ser um Triângulo
            var vertexs = {};
            currentAskDraw.find('div.vertex').each(function(idx) {
                vertexs[idx] = {};
                vertexs[idx]['row'] = $(this).attr('row');
                vertexs[idx]['col'] = $(this).attr('col');
            });

            var vertex1 = vertexs[0];
            var vertex2 = vertexs[1];
            var vertex3 = vertexs[2];

            //Verificar se possui algum 'buraco' entre os 3 vértices
            var distinctDash = [];
            var numDistinctDash = 0;
            currentAskDraw.find('div.desHighLight').each(function() {
                if (distinctDash.indexOf($(this).attr('dash')) === -1) {
                    //Add o novo Dash
                    distinctDash.push($(this).attr('dash'));
                    numDistinctDash++;
                }
            });


            if (numDistinctDash > 3) {
                //Figura inválida, pois possui mais de três traços
                return null;

            } else {
                //Verificar se o primeiro ponto que foi selecionado esta 'aberto'
                //Pra Não estar aberto, ele deverá possuir a classe que representa Mais de 1 HighLight
                var pointFirstSelected = currentAskDraw.find('div.draw-point.firstSelected');
                var countHlFirstSelected = 0;
                currentAskDraw.find('div.desHighLight').each(function() {
                    if (pointFirstSelected.hasClass($(this).attr('id'))) {
                        countHlFirstSelected++;
                        if (countHlFirstSelected > 1) {
                            //Está 'fechado'
                            return false;
                        }
                    }
                });

                if (countHlFirstSelected <= 1) {
                    //Está 'aberto'
                    return null;
                }


                //Verificar se possuí alguma extremidade
                if (currentAskDraw.find('div.extremity').size() > 0) {
                    return null;
                }

                //É um Triângulo
                return "triangle";
            }



        } else if (numVertex == 4) {
            //Pode ser um Quadrado ou retângulo
            var isRectangle = false;
            var isSquare = false;

            var vertexs = {};
            var minRow = 999;
            var minCol = 999;

            var maxRow = -1;
            var maxCol = -1;

            var idxMinVertex = -1;
            var idxMaxVertex = -1;
            var idxAnotherVertex1 = -1;
            var idxAnotherVertex2 = -1;

            var isNotMin = false;
            var isNotMax = false;
            currentAskDraw.find('div.vertex').each(function(idx) {
                vertexs[idx] = {};
                vertexs[idx]['row'] = $(this).attr('row');
                vertexs[idx]['col'] = $(this).attr('col');
                //Identificar o vetex TopLeft => Menor Linha e Coluna
                //Substitui o Minimo atual se possui Menor Row e Menor Col
                var oldIdxMinVertex = -1;
                var oldIdxMaxVertex = -1;

                if (vertexs[idx]['row'] < minRow && vertexs[idx]['col'] < minCol) {
                    //Encontrou um Mínimo Vertex
                    isNotMin = false;
                    if (idxMinVertex > -1) {
                        //Não é o primeiro idx a ser verificado
                        oldIdxMinVertex = idxMinVertex;

                    }

                    idxMinVertex = idx;
                    //Novo Mínimo Vertex
                    minRow = vertexs[idx]['row'];
                    minCol = vertexs[idx]['col'];

                } else {
                    isNotMin = true;
                }

                //Identificar o vetex DownRight => Maior Linha e Coluna
                //Substitui o Maximo atual se possui Maior Row e Maior Col
                if (vertexs[idx]['row'] > maxRow && vertexs[idx]['col'] > maxCol) {
                    //Encontrou um Máximo Vertex
                    isNotMax = false;
                    if (idxMaxVertex > -1) {
                        //Não é o primeiro idx a ser verificado
                        oldIdxMaxVertex = idxMaxVertex;

                    }
                    idxMaxVertex = idx;

                    //Novo Máximo Vertex
                    maxRow = vertexs[idx]['row'];
                    maxCol = vertexs[idx]['col'];

                } else {
                    isNotMax = true;
                }


                if (isNotMin && isNotMax) {
                    //Pode ser o LeftDown ou RightTop
                    if (idxAnotherVertex1 > -1) {
                        //Já existe, então add no outro Vertex2
                        idxAnotherVertex2 = idx;
                    } else {
                        idxAnotherVertex1 = idx;
                    }

                } else {
                    // É mínimo ou máximo / ou os dois(no primeiro idx)

                    if (!isNotMin && oldIdxMinVertex > -1) {
                        //O atual idx é mínimo e substituiu o antigo mínimo
                        //Verifica se o oldIdxMinVertex NÃO é Max também
                        if (oldIdxMinVertex != idxMaxVertex) {
                            if (idxAnotherVertex1 > -1) {
                                //Já existe, então add no outro Vertex2
                                idxAnotherVertex2 = oldIdxMinVertex;
                            } else {
                                idxAnotherVertex1 = oldIdxMinVertex;
                            }
                        }

                    }

                    if (!isNotMax && oldIdxMaxVertex > -1) {
                        //O atual idx é máximo e substituiu o antigo máximo
                        //Verifica se o oldIdxMaxVertex NÃO é Min também
                        if (oldIdxMaxVertex != idxMinVertex) {
                            if (idxAnotherVertex1 > -1) {
                                //Já existe, então add no outro Vertex2
                                idxAnotherVertex2 = oldIdxMaxVertex;
                            } else {
                                idxAnotherVertex1 = oldIdxMaxVertex;
                            }
                        }

                    }

                }


            });


            var vertex1 = vertexs[0];
            var vertex2 = vertexs[1];
            var vertex3 = vertexs[2];
            var vertex4 = vertexs[3];

            // 1 - Verificar se pares distintos possuem a mesma Row
            var vertexSameRowVx1 = null;
            var vertexSameRowVx2 = null;
            var vertexSameRowVx3 = null;
            var vertexSameRowVx4 = null;

            switch (vertex1['row']) {
                case vertex2['row']:
                    vertexSameRowVx1 = vertex2;
                    vertexSameRowVx2 = vertex1;
                    break;
                case vertex3['row']:
                    vertexSameRowVx1 = vertex3;
                    vertexSameRowVx3 = vertex1;
                    break;
                case vertex4['row']:
                    vertexSameRowVx1 = vertex4;
                    vertexSameRowVx4 = vertex1;
                    break;
            }

            if (vertexSameRowVx2 === null) {
                switch (vertex2['row']) {
                    case vertex3['row']:
                        vertexSameRowVx2 = vertex3;
                        vertexSameRowVx3 = vertex2;
                        break;

                    case vertex4['row']:
                        vertexSameRowVx2 = vertex4;
                        vertexSameRowVx4 = vertex2;
                        break;
                }
            }

            if (vertexSameRowVx3 === null && vertexSameRowVx4 === null) {
                if (vertex3['row'] == vertex4['row']) {
                    vertexSameRowVx3 = vertex4;
                    vertexSameRowVx4 = vertex3;
                }
            }

            if (vertexSameRowVx1 === null || vertexSameRowVx2 === null || vertexSameRowVx3 === null || vertexSameRowVx4 === null) {
                //Figura inválida
                return null;
            } else {
                // 2 - Verificar se pares distintos possuem a mesma Col
                var vertexSameColVx1 = null;
                var vertexSameColVx2 = null;
                var vertexSameColVx3 = null;
                var vertexSameColVx4 = null;

                switch (vertex1['col']) {
                    case vertex2['col']:
                        vertexSameColVx1 = vertex2;
                        vertexSameColVx2 = vertex1;
                        break;
                    case vertex3['col']:
                        vertexSameColVx1 = vertex3;
                        vertexSameColVx3 = vertex1;
                        break;
                    case vertex4['col']:
                        vertexSameColVx1 = vertex4;
                        vertexSameColVx4 = vertex1;
                        break;
                }

                if (vertexSameColVx2 === null) {
                    switch (vertex2['col']) {
                        case vertex3['col']:
                            vertexSameColVx2 = vertex3;
                            vertexSameColVx3 = vertex2;
                            break;

                        case vertex4['col']:
                            vertexSameColVx2 = vertex4;
                            vertexSameColVx4 = vertex2;
                            break;
                    }
                }

                if (vertexSameColVx3 === null && vertexSameColVx4 === null) {
                    if (vertex3['col'] == vertex4['col']) {
                        vertexSameColVx3 = vertex4;
                        vertexSameColVx4 = vertex3;
                    }
                }

                if (vertexSameColVx1 === null || vertexSameColVx2 === null || vertexSameColVx3 === null || vertexSameColVx4 === null) {
                    //Figura inválida
                    return null;
                } else {
                    //Até aqui. Sabe-se  que possue ângulos Retos com 4 lados.
                    // 3 - Verificar se entre os vértices, possui um traço
                    var findRole = false;

                    var row1 = vertex1['row'];
                    var row2 = vertexSameColVx1['row'];

                    var col1 = vertex1['col'];
                    var col2 = vertexSameRowVx1['col'];

                    var countPointsCol = Math.abs(col1 - col2);
                    var countPointsRow = Math.abs(row1 - row2);

                    var pointLimitColMax = Math.max(col1, col2);
                    var pointLimitColMin = Math.min(col1, col2);

                    var pointLimitRowMax = Math.max(row1, row2);
                    var pointLimitRowMin = Math.min(row1, row2);


                    //Percorrer Points da Primeira Linha
                    currentAskDraw.find('div.draw-point[row=' + row1 + ']').each(function(idx) {
                        if ($(this).attr('col') >= pointLimitColMin && $(this).attr('col') <= pointLimitColMax) {
                            //Verificar se todos os points nesse intervalo possuem a classe .selected
                            if (!$(this).hasClass('selected')) {
                                findRole = true;
                                return false;
                            }
                        }
                    });

                    //Verificar se encotrou um buraco entre o intervalo
                    if (findRole) {
                        return null;
                    }

                    //Percorrer Points da Segunda Linha
                    currentAskDraw.find('div.draw-point[row=' + row2 + ']').each(function(idx) {
                        if ($(this).attr('col') >= pointLimitColMin && $(this).attr('col') <= pointLimitColMax) {
                            //Verificar se todos os points nesse intervalo possuem a classe .selected
                            if (!$(this).hasClass('selected')) {
                                findRole = true;
                                return false;
                            }
                        }
                    });

                    //Verificar se encotrou um buraco entre o intervalo
                    if (findRole) {
                        return null;
                    }


                    //Percorrer Points da Primeira Coluna
                    currentAskDraw.find('div.draw-point[col=' + col1 + ']').each(function(idx) {
                        if ($(this).attr('row') >= pointLimitRowMin && $(this).attr('row') <= pointLimitRowMax) {
                            //Verificar se todos os points nesse intervalo possuem a classe .selected
                            if (!$(this).hasClass('selected')) {
                                findRole = true;
                                return false;
                            }
                        }
                    });

                    //Verificar se encotrou um buraco entre o intervalo
                    if (findRole) {
                        return null;
                    }

                    //Percorrer Points da Segunda Coluna
                    currentAskDraw.find('div.draw-point[col=' + col2 + ']').each(function(idx) {
                        if ($(this).attr('row') >= pointLimitRowMin && $(this).attr('row') <= pointLimitRowMax) {
                            //Verificar se todos os points nesse intervalo possuem a classe .selected
                            if (!$(this).hasClass('selected')) {
                                findRole = true;
                                return false;
                            }
                        }
                    });

                    //Verificar se encotrou um buraco entre o intervalo
                    if (findRole) {
                        return null;
                    }

                    //Verificar se possui algum draw select fora do retângulo
                    var vertexTopLeft = vertexs[idxMinVertex];
                    var vertexDownRight = vertexs[idxMaxVertex];
                    //Verificar qual another vertex possui a mesma Coluna do TopLeft
                    //Ecnontrando assim o DownLeft
                    var vertexDownLeft = -1;
                    var vertexTopRight = -1;


                    if (vertexTopLeft['col'] == idxAnotherVertex1['col']) {
                        //É o vertexDownLeft
                        vertexDownLeft = vertexs[idxAnotherVertex1];
                        vertexTopRight = vertexs[idxAnotherVertex2];
                    } else {
                        vertexDownLeft = vertexs[idxAnotherVertex2];
                        vertexTopRight = vertexs[idxAnotherVertex1];
                    }

                    //Obter as mínimas e máximas Linhas e Colunas
                    var minRow = vertexTopLeft['row'];
                    var minCol = vertexTopLeft['col'];
                    var maxRow = vertexDownRight['row'];
                    var maxCol = vertexDownRight['col'];

                    var therePointOutSideSquare = false;

                    currentAskDraw.find('div.draw-point.selected').each(function(idx) {
                        //Verificar se esse ponto de seleção Não está dentro do retângulo
                        var row = $(this).attr('row');
                        var col = $(this).attr('col');
                        if (row < minRow || row > maxRow || col < minCol || col > maxCol) {
                            //Este ponto está fora do retângulo
                            therePointOutSideSquare = true;
                            //Saí do each
                            return false;
                        }

                        //Verificar se tem algum ponto 'dentro' da figura
                        if ((row > minRow && row < maxRow) && (col > minCol && col < maxCol)) {
                            //Este ponto está 'dentro' do retângulo
                            therePointOutSideSquare = true;
                            //Saí do each
                            return false;
                        }

                    });

                    if (therePointOutSideSquare) {
                        //Possui um traço fora do retângulo
                        return null;
                    }


                    //Se chegou até aqui é um Retângulo
                    isRectangle = true;

                    //Verificar se possuem os lados iguais (Quadrado)
                    isSquare = countPointsRow === countPointsCol;

                    if (isSquare) {
                        //É um quadrado
                        return "square";
                    } else {
                        //É somente retângulo
                        return "rectangle";
                    }

                }
            }

        } else {
            // Não é uma forma válida
            return null;
        }
    };

    //Finaliza o Atendimento do Aluno Corrente
    this.finalizeMeet = function() {
        sessionStorage.removeItem("id_actor");
        sessionStorage.removeItem("id_classroom");
        sessionStorage.removeItem("id_discipline");
        sessionStorage.removeItem("name_actor");
        sessionStorage.removeItem("name_classroom");
        if (sessionStorage.getItem("render_mode") == "evaluation") {
            //Então remove também o nível selecionado
            sessionStorage.removeItem("evaluation_selected_level");
        }
        sessionStorage.removeItem("render_mode");
        location.href = "select.html";
        return true;
    };

    /**
     * Verifica se a variavel esta setada.
     *
     * @param {mixed} variable
     * @returns {Boolean}
     */
    this.isset = function(variable) {
        return (variable !== undefined && variable !== null);
    };

    this.isEmpty = function(variable) {
        return !self.isset(variable) || variable === '';
    };

    /**
     * Envia mensagem de Certo ou Errado par ao usuário
     *
     * @param {boolean} isTrue
     * @returns {void}
     */
    this.showMessageAnswer = function(isTrue) {
        if (isTrue) {
            $('#hit-message').show();
            //            $('#message').show();
            //            $('#message').css({
            //                'backgroundColor': 'green'
            //            });
            //            $('#message').html(MSG_CORRECT);
            //            $('#message').fadeOut(5000);
        } else {
            $('#error-message').show();
            //            $('#message').show();
            //            $('#message').css({
            //                'backgroundColor': 'red'
            //            });
            //            $('#message').html(MSG_WRONG);
            //            $('#message').fadeOut(5000);
        }

    };

    //Contador de Tempo de cada Meet
    this.countTime = function(tag) {
        //A cada segundo realiza a recursividade
        //Dando a cada chamada recursiva da função, 1s de intervalo
        if (self.isset(tag)) {
            self.tag_time = tag;
        }
        setInterval(function() {
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
        }, 1000);
    };

    Meet.scoreCalculator = function(withMSGnextLevel) {
        self.score = (Meet.peformance_qtd_correct * 10) - (Meet.peformance_qtd_wrong * 10);
        if (self.score < 0) {
            self.score = 0;
        }
        //Atualiza a quantidade de corretos
        $('.info.info-hits .info-text').html(Meet.peformance_qtd_correct);
        $('.info.info-erros .info-text').html(Meet.peformance_qtd_wrong);
        $('#points').text(self.score);

        //Se for diferente, então Passou de Nível
        if (!self.isset(Meet.domCobject) || self.currentGrade !== Meet.domCobject.cobject.grade) {
            if (self.isset(Meet.domCobject)) {
                self.currentGrade = Meet.domCobject.cobject.grade;
                $('#level').text(self.currentGrade);
            }

            if (self.isset(withMSGnextLevel) && withMSGnextLevel && false) {
                //Temporariamente, não exibe a mensagem de avanço de nível.
                if (Meet.domCobject.cobject.template_code !== 'TXT')
                    $('#nextLevel-message').show();
            }
        }

    };

    this.buildToolBar = function() {
        var html = $('<div class="toolBar"></div>');
        html.append('<button class="nextPiece">' + NEXT_PIECE + '</button>');
        html.append("<img class='btn_lastPage' id='lastPage' src=' img/icons/last.png' style='display:none' >");
        html.append("<img class='btn_nextPage' id='nextPage' src='img/icons/next.png' style='display:none' >");

        return html;
    };

};
