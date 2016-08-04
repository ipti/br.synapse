this.MeetProficiency = function() {
    //Apontador para o próprio objeto MeetProficiency
    var self = this;

    //======================================
    //Disciplina Atual
    this.discipline_id = null;
    //Roteiro Atual
    this.script_id = null;
    //Objetivo atual
    this.goal_id = null;

    //Array de Cobjects no objetivo corrente
    this.cobjectsInCurrentGoal = new Array();
    //Pontos de diagnósticos para o usuário na disciplina corrente
    MeetProficiency.stopPointDiagnostics = new Array();
    //Todos os scripts disponíveis(sem diagnósticos)
    MeetProficiency.availableScripts = new Array();
    //Todos os trace scripts do usuário e disciplina corrente
    MeetProficiency.allTraceScripts = new Array();
    //Lista de Scripts de um ano específico
    MeetProficiency.currentScriptList = new Array();

    this.start = function() {

        // 1 - Buscar Todos os Roteiros disponíveis para a disciplina selecionada
        this.findAllDiagnosticPoint(function(stopPointDiagnostics){
            if(stopPointDiagnostics.length > 0){
                //Existe Ponto(s) de diagnóstico em roteiro(s)
                MeetProficiency.stopPointDiagnostics = stopPointDiagnostics;
            }
        });

        // 2 - Obter todos os traceScripts para o usuário e disciplina corrente
        this.findAllTraceDiagScript(function(allTraceScripts){
            if(allTraceScripts.length > 0){
                //Existe pelo menos 1 trace script
                MeetProficiency.allTraceScripts = allTraceScripts;
            }
        });

        // 3 - Obter todos os Scripts para o usuário e disciplina corrente
        // Onde possui objetivos do ano passado como parâmetro
        this.findAllScriptsByYear(1, function(allScriptByYear){
            if(allScriptByYear.length > 0){
                //Existe pelo menos 1 Script
                MeetProficiency.currentScriptList = allScriptByYear;
            }
        });

    }

    this.findAllDiagnosticPoint = function(callBack){
        Meet.DB_synapse.getAllDiagnosticPoint(callBack);
    }


    this.findAllTraceDiagScript = function(callBack){
        Meet.DB_synapse.getAllTraceDiagScript(callBack);
    }

    this.findAllScriptsByYear = function(scriptYear, callBack){
        Meet.DB_synapse.getAllScriptsByYear(scriptYear, callBack);
    }

    this.setCobjectsFromBlock = function(cobjectIDsCurrentBlock) {
        //Atribui ao array de cobjects do bloco corrente
        //Agora atribui um novo array que possuirá todos cobjects com seus principais atributos
        for (var idx in cobjectIDsCurrentBlock) {
            Meet.DB_synapse.getCobject(cobjectIDsCurrentBlock[idx], function(json_cobject) {
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


    this.getIdxArrayCobjectsInBlock = function(cobjectID) {
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


    this.loadNextCobjectInBlock = function(needScoredCalculator) {
        //Carregar a próxima atividade, se for permitido!

        var idxNextCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id) + 1;
        var nextCobjectID = self.cobjectsInBlock[idxNextCobject]['cobject_id'];

        //Verificar o Ano do próximo Cobject, só poderá continuar se for igual ao Nível selecionado
        Meet.DB_synapse.findCobjectById(nextCobjectID, function(cobject) {
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
    this.loadFirstPiece_Evaluation = function() {
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
    this.hasNextCobjectInBlock = function() {
        var idxCurrentCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id);
        return self.isset(self.cobjectsInBlock[idxCurrentCobject + 1]);
    };

    //Verifica se possui uma Anterior atividade no bloco
    this.hasPrevCobjectInBlock = function() {
        var idxCurrentCobject = self.getIdxArrayCobjectsInBlock(Meet.domCobject.cobject.cobject_id);
        return idxCurrentCobject > 0;
    };


    this.saveBreakPoint = function(piece_id) {
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
    this.isset = function(variable) {
        return (variable !== undefined && variable !== null);
    };

}
