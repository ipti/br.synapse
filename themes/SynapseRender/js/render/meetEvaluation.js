

this.MeetEvaluation = function () {
    //Apontador para o próprio objeto MeetEvaluation
    var self = this;

    //======================================
   
    this.cobject_block_id = null;
    
    //Array com as principais informações de cada Cobject do bloco selecionado
    this.cobjectsInBlock = new Array();
    
    
    this.start = function(){
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
                    Meet.DB_synapse.getUserState(Meet.actor, self.cobject_block_id, function (info_state) {
                        var gotoState = self.isset(info_state);
                        var lastCobject_id = null;

                        //Ano atual no estudante
                        self.studentCurrentYear = parseInt(Meet.studentClassroomName.match(/\d/)[0]);

                        if (gotoState) {
                            //Encontrou O estado do usuário
                            self.isLoadState = true;
                            lastCobject_id = info_state.last_cobject_id;
                            self.firstPieceCurrentMeet = info_state.last_piece_id;
                            self.peformance_qtd_correct = info_state.qtd_correct;
                            self.peformance_qtd_wrong = info_state.qtd_wrong;
                            //Calcula o Score
                            Meet.scoreCalculator(false);

                            //Construçao do DOM do 1° cobject de cada Meet
                            Meet.domCobjectBuild(lastCobject_id);
                            //Depois inicia os eventos globais 
                            Meet.init_eventsGlobals();
                        } else {
                            //Primeiro Acesso do usuário; Não possui nenhum estado registrado
                            //Indica que Não possui algum estado carregado 
                            self.isLoadState = false;

                            if (self.studentCurrentYear > 2) {
                                //Abre o Primeiro Cobject, referente ao Ano anterior da série Aluno
                                var StartIdx = 0;
                                var startCobjectYear = self.studentCurrentYear - 1;

                                for (var idx in self.cobjectsInBlock) {
                                    //Encontrar o Primeiro Cobject referente ao Ano anterior da série Aluno
                                    var currentCobject = self.cobjectsInBlock[idx];
                                    if (currentCobject['year'] == startCobjectYear) {
                                        //Encontrou o Cobject do ano Anterior a do Aluno
                                        lastCobject_id = currentCobject['cobject_id'];
                                        //Finaliza a pesquisa, pois incia sempre do 1° 
                                        break;
                                    }
                                }

                                //Inicia com o cobject encontrado
                                //Construçao do DOM do 1° cobject de cada Meet
                                Meet.domCobjectBuild(lastCobject_id);
                                //Depois inicia os eventos globais 
                                Meet.init_eventsGlobals();


                            } else {
                                //Carrega o 1° Cobject, referente ao 1° Ano
                                lastCobject_id = self.cobjectsInBlock[0]['cobject_id'];
                                //Construçao do DOM do 1° cobject de cada Meet
                                Meet.domCobjectBuild(lastCobject_id);
                                //Depois inicia os eventos globais 
                                Meet.init_eventsGlobals();
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

        //Verificar o Ano do próximo Cobject, só poderá continuar se for Menor que o ano do Estudante
        //Com exeção, do estudante do 1° ano, que poderá resolver atividades do seu ano.
        Meet.DB_synapse.findCobjectById(nextCobjectID, function (cobject) {
            //Sempre encontrará o cobject referente ao nextCobjectID
            var nextCobjectYear = parseInt(cobject.year);
            if ((self.studentCurrentYear == nextCobjectYear && self.studentCurrentYear == 1)
                    || ((nextCobjectYear + 1) == self.studentCurrentYear)) {
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
                //Finalizou as Atividades do Ano Anterior ao ano corrente do estudante.
                self.messageFinishedLevel();
            }

        });

    }

    //Carregar Primeira Piece do atendimento corrente
    //Quando o modo do render for Avaliação
    this.loadFirstPiece_Evaluation = function () {
        var selector_cobject = '.cobject';
        if (!self.isLoadState) {
            $(selector_cobject + ':eq(0)').addClass('currentCobject');
            $(selector_cobject + ':eq(0) .T_screen:eq(0)').addClass('currentScreen');
            $(selector_cobject + ':eq(0) .pieceset:eq(0)').addClass('currentPieceSet');
            $(selector_cobject + ':eq(0) .piece:eq(0)').addClass('currentPiece');
            $(selector_cobject + '.currentCobject, ' + selector_cobject +
                    ' .currentScreen, ' + selector_cobject + ' .currentPieceSet, ' + selector_cobject +
                    ' .currentPiece').show();
        } else {
            //Ir para a piece->pieceSet->Screen->cobject 
            // O A partir daqui torna falso o isLoadState, pois só é carregado o estado no primeira vez
            self.isLoadState = false;

            var lastPiece = $(selector_cobject + ' .piece[id=' + self.firstPieceCurrentMeet + ']');
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