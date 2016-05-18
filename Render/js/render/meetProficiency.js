
this.MeetProficiency = function () {
    //Apontador para o próprio objeto MeetProficiency
    var self = this;

    //======================================
    //Disciplina Atual
    this.discipline_id = null;
    //Roteiro Atual
    this.script_id = null;
    //Conteúdo atual
    this.content_id = null;
    //Objetivo atual
    this.goal_id = null;
    //Todos os scripts disponíveis(sem diagnósticos)
    this.availableScripts = new Array();

    //Array de Cobjects no objetivo corrente
    this.cobjectsInCurrentGoal = new Array();

    this.start = function () {
        //Verificar o UserState

        var userStateProficiencyInfo = {
            discipline_id: self.discipline_id,
        };

        Meet.DB_synapse.getUserState_ModeDiagnostic(Meet.actor, Meet.render_mode, userStateProficiencyInfo, function (info_state) {
            var gotoState = self.isset(info_state);
            var lastCobject_id = null;

            //Ano atual no estudante
            Meet.studentCurrentYear = parseInt(Meet.studentClassroomName.match(/\d/)[0]);

            if (gotoState) {
                //Encontrou O estado do usuário
                Meet.isLoadState = true;
                lastCobject_id = info_state.last_cobject_id;
                Meet.firstPieceCurrentMeet = info_state.last_piece_id;
                Meet.peformance_qtd_correct = info_state.qtd_correct;
                Meet.peformance_qtd_wrong = info_state.qtd_wrong;
                Meet.render_mode = info_state.render_mode;
                //Calcula o Score
                Meet.scoreCalculator(false);

                //Construçao do DOM do 1° cobject de cada Meet
                Meet.domCobjectBuild(lastCobject_id);
                //Depois inicia os eventos globais 
                Meet.init_eventsGlobals();
            } else {
                //Primeiro Acesso do usuário; Não possui nenhum estado registrado
                //Indica que Não possui algum estado carregado 
                Meet.isLoadState = false;
                //Abre o Primeiro Cobject do Roteiro(aleatório)
                //
                //Obter todos roteiros para a disciplina selecionada
                Meet.DB_synapse.getAllScripts(Meet.discipline_id, function(scripts){
                    //Pequisar Todos contents e goals do script disponível e escolhido
                    //
                    //Verificar quais scripts estão disponíveis(se Não existir
                    //um ponto de diagnóstico no script para o aluno corrente )
                    
                    //Para os scripts diponíveis, sortear, qual deverá ser inciado
                    
                });

                

                for (var idx in self.cobjectsInBlock) {
                    //Encontrar o Primeiro Cobject referente ao Ano anterior da série Aluno
                    var currentCobject = self.cobjectsInBlock[idx];
                    if (currentCobject['year'] == startCobjectYear) {
                        //Encontrou o Cobject do Level selecionado
                        lastCobject_id = currentCobject['cobject_id'];
                        //Finaliza a pesquisa, pois incia sempre do 1° 
                        break;
                    }
                }

                //Se encontrou algum Cobject no bloco para o Nível selecionado
                if (self.isset(lastCobject_id)) {
                    //Inicia com o cobject encontrado
                    //Construçao do DOM do 1° cobject de cada Meet
                    Meet.domCobjectBuild(lastCobject_id);
                    //Depois inicia os eventos globais 
                    Meet.init_eventsGlobals();
                } else {
                    //Volta para o select
                    location.href = "select.html";
                    alert("Nenhuma Atividade foi Encontrada nesse Nível");
                }


            }


        });



        Meet.DB_synapse.getBlockByDiscipline(Meet.discipline_id, function (cobject_block_id) {
            // Seta o Bloco para a disciplina selecionada
            self.cobject_block_id = cobject_block_id;
            if (self.isset(self.cobject_block_id)) {
                //Inicia o encontro. Agora que já sabe qual Bloco carregar. 
                self.getCobjectsFromBlock();
            } else {
                //Não inicia
                console.log("Nenhum Bloco foi encontrado para a Disciplina selecionada !!!");
            }
        });
    }

    //Obter todos os Cobject deste Bloco
    this.getCobjectsFromBlock = function () {

        Meet.DB_synapse.getCobjectsFromBlock(self.cobject_block_id
                , function (objectsThisBlock) {
                    //count do número de objetos
                    var num_objects = 0;
                    $.each(objectsThisBlock, function () {
                        num_objects++;
                    });

                    //Setar todos os Cobjects
                    self.setCobjectsFromBlock(objectsThisBlock);

                    //Agora Verifica o UserState
                    var userStateProficiencyInfo = {
                        cobject_block_id: self.cobject_block_id,
                        evaluation_selected_level: self.evaluation_selected_level
                    };
                    Meet.DB_synapse.getUserState(Meet.actor, Meet.render_mode, userStateProficiencyInfo, function (info_state) {
                        var gotoState = self.isset(info_state);
                        var lastCobject_id = null;

                        //Ano atual no estudante
                        Meet.studentCurrentYear = parseInt(Meet.studentClassroomName.match(/\d/)[0]);

                        if (gotoState) {
                            //Encontrou O estado do usuário
                            Meet.isLoadState = true;
                            lastCobject_id = info_state.last_cobject_id;
                            Meet.firstPieceCurrentMeet = info_state.last_piece_id;
                            Meet.peformance_qtd_correct = info_state.qtd_correct;
                            Meet.peformance_qtd_wrong = info_state.qtd_wrong;
                            Meet.render_mode = info_state.render_mode;
                            self.evaluation_selected_level = info_state.evaluation_selected_level;
                            //Calcula o Score
                            Meet.scoreCalculator(false);

                            //Construçao do DOM do 1° cobject de cada Meet
                            Meet.domCobjectBuild(lastCobject_id);
                            //Depois inicia os eventos globais 
                            Meet.init_eventsGlobals();
                        } else {
                            //Primeiro Acesso do usuário; Não possui nenhum estado registrado
                            //Indica que Não possui algum estado carregado 
                            Meet.isLoadState = false;

                            //Abre o Primeiro Cobject, referente ao Nível Selecionado
                            var startCobjectYear = self.evaluation_selected_level;

                            for (var idx in self.cobjectsInBlock) {
                                //Encontrar o Primeiro Cobject referente ao Ano anterior da série Aluno
                                var currentCobject = self.cobjectsInBlock[idx];
                                if (currentCobject['year'] == startCobjectYear) {
                                    //Encontrou o Cobject do Level selecionado
                                    lastCobject_id = currentCobject['cobject_id'];
                                    //Finaliza a pesquisa, pois incia sempre do 1° 
                                    break;
                                }
                            }

                            //Se encontrou algum Cobject no bloco para o Nível selecionado
                            if (self.isset(lastCobject_id)) {
                                //Inicia com o cobject encontrado
                                //Construçao do DOM do 1° cobject de cada Meet
                                Meet.domCobjectBuild(lastCobject_id);
                                //Depois inicia os eventos globais 
                                Meet.init_eventsGlobals();
                            } else {
                                //Volta para o select
                                location.href = "select.html";
                                alert("Nenhuma Atividade foi Encontrada nesse Nível");
                            }


                        }


                    });

                    /*  $.each(objectsThisBlock, function(idx, object){
                     //Para cada Cobject Cria sua Dom
                     
                     }); */
                });
    }



    this.setCobjectsFromBlock = function (cobjectIDsCurrentBlock) {
        //Atribui ao array de cobjects do bloco corrente
        //Agora atribui um novo array que possuirá todos cobjects com seus principais atributos
        for (var idx in cobjectIDsCurrentBlock) {
            Meet.DB_synapse.getCobject(cobjectIDsCurrentBlock[idx], function (json_cobject) {
                //Para cada CobjectID
                var currentCobject = new Array();
                currentCobject['cobject_id'] = json_cobject.cobject_id;
                currentCobject['cobject_type'] = json_cobject.cobject_type;
                currentCobject['content'] = json_cobject.content;
                currentCobject['degree_name'] = json_cobject.degree_name;
                currentCobject['degree_parent'] = json_cobject.degree_parent;
                currentCobject['description'] = json_cobject.description;
                currentCobject['discipline'] = json_cobject.discipline;
                currentCobject['goal'] = json_cobject.goal;
                currentCobject['grade'] = json_cobject.grade;
                currentCobject['stage'] = json_cobject.stage;
                currentCobject['template_code'] = json_cobject.template_code;
                currentCobject['template_name'] = json_cobject.template_name;
                currentCobject['theme'] = json_cobject.theme;
                currentCobject['year'] = json_cobject.year;

                //Adiciona atributos do cobject corrente
                self.cobjectsInBlock.push(currentCobject);

            });
        }
    };


    this.getIdxArrayCobjectsInBlock = function (cobjectID) {
        var idxCobject = -1;
        for (var idx in self.cobjectsInBlock) {
            //Percorrer o Array dos Cobjects
            var currentCobjectID = self.cobjectsInBlock[idx]['cobject_id'];
            if (currentCobjectID == cobjectID) {
                //Econtrado
                idxCobject = idx;
                break;
            }
        }

        if (typeof idxCobject === "string") {
            //Se for String, transforma para inteiro
            idxCobject = parseInt(idxCobject);
        }

        return idxCobject;
    };


    this.loadNextCobjectInBlock = function (needScoredCalculator) {
        //Carregar a próxima atividade, se for permitido!

        var idxNextCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id) + 1;
        var nextCobjectID = self.cobjectsInBlock[idxNextCobject]['cobject_id'];

        //Verificar o Ano do próximo Cobject, só poderá continuar se for igual ao Nível selecionado
        Meet.DB_synapse.findCobjectById(nextCobjectID, function (cobject) {
            //Sempre encontrará o cobject referente ao nextCobjectID
            var nextCobjectYear = parseInt(cobject.year);
            if (self.evaluation_selected_level == nextCobjectYear) {
                //Pode avançar para esse Próximo Cobject
                //Criar a Dom do Próximo Cobject
                Meet.domCobjectBuild(nextCobjectID);
                //Verificar o nível do próximo Cobject
                Meet.scoreCalculator(needScoredCalculator);

                //Mostrar a primeira Questão deste Próximo Cobject
                var selector_cobject = '.cobject';
                $(selector_cobject + ':eq(0)').addClass('currentCobject');
                $(selector_cobject + ':eq(0) .T_screen:eq(0)').addClass('currentScreen');
                $(selector_cobject + ':eq(0) .pieceset:eq(0)').addClass('currentPieceSet');
                $(selector_cobject + ':eq(0) .piece:eq(0)').addClass('currentPiece');
                $(selector_cobject + '.currentCobject, ' + selector_cobject +
                        ' .currentScreen, ' + selector_cobject + ' .currentPieceSet, ' + selector_cobject +
                        ' .currentPiece').show();


            } else {
                //Finalizou as Atividades do Nível Selecionado, do bloco selecionado.
                Meet.messageFinishedLevel();
            }

        });

    }

    //Carregar Primeira Piece do atendimento corrente
    //Quando o modo do render for Avaliação
    this.loadFirstPiece_Evaluation = function () {
        var selector_cobject = '.cobject';
        if (!Meet.isLoadState) {
            //Carrega a primeira Piece
            $(selector_cobject + ':eq(0)').addClass('currentCobject');
            $(selector_cobject + ':eq(0) .T_screen:eq(0)').addClass('currentScreen');
            $(selector_cobject + ':eq(0) .pieceset:eq(0)').addClass('currentPieceSet');
            $(selector_cobject + ':eq(0) .piece:eq(0)').addClass('currentPiece');
            $(selector_cobject + '.currentCobject, ' + selector_cobject +
                    ' .currentScreen, ' + selector_cobject + ' .currentPieceSet, ' + selector_cobject +
                    ' .currentPiece').show();
        } else {
            //Ir para a piece->pieceSet->Screen->cobject 
            // O A partir daqui torna falso o isLoadState, pois só é carregado o estado na primeira vez
            Meet.isLoadState = false;

            var lastPiece = $(selector_cobject + ' .piece[id=' + Meet.firstPieceCurrentMeet + ']');
            var nextPiece = null;
            var lastPieceSet = null;
            var lastScreen = null;
            var lastCobject = null;
            var nextPieceSet = null;
            var nextScreen = null;
            var nextCobject = null;
            var isNextCobject = false;

            if (lastPiece.next('.piece').size() !== 0) {
                nextPiece = lastPiece.next('.piece');
            } else {
                //Acabou as Pieces desta PieceSet
                lastPieceSet = lastPiece.closest('.pieceset');
                nextPieceSet = lastPieceSet.next('.pieceset');
                if (nextPieceSet.size() === 0) {
                    //Acabou as PieceSets desta Screen
                    lastScreen = lastPieceSet.closest('.T_screen');
                    nextScreen = lastScreen.next('.T_screen');

                    if (nextScreen.size() === 0) {
                        //Acabou as Screens deste Cobject
                        lastCobject = lastScreen.closest('.cobject');
                        nextCobject = lastCobject.next('.cobject');

                        if (self.hasNextCobjectInBlock()) {
                            isNextCobject = true;
                            //Carrega o Cobject se permitido
                            self.loadNextCobjectInBlock(true);

                        } else {
                            //Acabou todos os Cobjets, ATIVIDADE JÁ FINALIZADA
                            self.isFinalBlock = true;
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
            //Existe uma próxima peça neste CObject
            if (!self.isFinalBlock && !isNextCobject) {
                nextPiece.addClass('currentPiece');
                nextPiece.closest('.pieceset').addClass('currentPieceSet');
                var parentScreen = nextPiece.closest('.T_screen').addClass('currentScreen');
                parentScreen.closest('.cobject').addClass('currentCobject');

                $(selector_cobject + '.currentCobject, ' + selector_cobject +
                        ' .currentScreen, ' + selector_cobject + ' .currentPieceSet, ' + selector_cobject +
                        ' .currentPiece').show();
            }

        }
    }



    //Verifica se possui uma Próxima atividade no bloco
    this.hasNextCobjectInBlock = function () {
        var idxCurrentCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id);
        return self.isset(self.cobjectsInBlock[idxCurrentCobject + 1]);
    };

    //Verifica se possui uma Anterior atividade no bloco
    this.hasPrevCobjectInBlock = function () {
        var idxCurrentCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id);
        return idxCurrentCobject > 0;
    };


    this.saveBreakPoint = function (piece_id) {
        //Salva o estado do Usuário, assim que resolve a questão
        //cobject_block_id + actor_id = PK
        var info_state = {
            render_mode: Meet.render_mode,
            cobject_block_id: self.cobject_block_id,
            actor_id: Meet.actor,
            evaluation_selected_level: self.evaluation_selected_level,
            last_cobject_id: Meet.domCobject.cobject.cobject_id,
            last_piece_id: piece_id,
            qtd_correct: Meet.peformance_qtd_correct,
            qtd_wrong: Meet.peformance_qtd_wrong
        };
        Meet.DB_synapse.NewORUpdateUserState(info_state);

    }

    /**
     * Verifica se a variavel esta setada.
     * 
     * @param {mixed} variable
     * @returns {Boolean}
     */
    this.isset = function (variable) {
        return (variable !== undefined && variable !== null);
    };

}