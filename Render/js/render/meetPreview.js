this.MeetPreview = function(cobject) {
    //Apontador para o próprio objeto MeetEvaluation
    var self = this;

    this.cobject = cobject;

    this.start = function() {

        Meet.domCobjectBuild(this.cobject.cobject_id, this.cobject);

        Meet.init_eventsGlobals();
    }


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
