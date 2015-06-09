TYPE = {};
TYPE.ELEMENT = {};
TYPE.ELEMENT.TEXT = "TEXT";
TYPE.ELEMENT.MULTIMIDIA = "MULTIMIDIA";
TYPE.LIBRARY = {};
TYPE.LIBRARY.IMAGE = "IMAGE";
TYPE.LIBRARY.SOUND = "SOUND";
TYPE.LIBRARY.MOVIE = "MOVIE";

//Classe Editor
function editor() {
    //OnNewEditor
    this.onEditor;

    this.COtypeID;
    this.COthemeID;
    this.COtemplateType;
    this.CObjectID;
    this.COgoalID;
    this.COdescription;
    this.currentScreenId;
    this.lastScreenId;
    this.countScreen = 0;
    this.countPieceSet = new Array();
    this.countPieces = new Array();
    this.countElements = new Array();
    this.countElementsPS = new Array();
    this.countElementsCobject;
    this.currentPieceSet = 'sc0_ps0';
    this.currentPiece = 'sc0_ps0_p0';
    this.uploadedElements = 0;
    this.uploadedFlags = 0;
    this.uploadedPieces = 0;
    this.uploadedPiecesets = 0;
    this.uploadedScreens = 0;
    this.totalElements = 0;
    this.uploaded_ImagesIDs = new Array();
    this.uploadedImages = 0;
    this.uploadedSounds = 0;
    this.isload = false;
    this.orderDelets = [];
    this.NONE = new Array();        //NONE: Nenhum
    this.TXT = new Array();         //TXT: Texto
    this.MTE = new Array(3, 4, 5, 6);  //MTE: Multipla Escolha
    this.PRE = new Array(7, 8, 9, 10, 11, 12);   //PRE: Pergunta e Resposta
    this.AEL = new Array(13, 14, 15); //AEL: Associar Elementos
    this.PLC = new Array();         //PLC: Palavra Cruzada
    this.DIG = new Array();         //DIG: Diagrama
    this.LVR = new Array();         //LVR: Livre
    this.FRM = new Array();         //FRM: Questionário
    this.PDC = new Array();         //PDC: Produç]ao
    this.DDROP = new Array();       //DDROP: Drag and Drop
    this.ONEDDROP = new Array();       //1DDROP: One Drag and Drop
    this.TXT.push(2);
    this.PLC.push(16);
    this.DIG.push(17);
    this.LVR.push(18);
    this.FRM.push(19);
    this.PDC.push(20);
    this.DDROP.push(21);
    this.ONEDDROP.push(22);
    this.unLinks = [];
    //Lista de peças e suas palavras cruzadas
    this.crossWords = new Array();
    this.crossInfomationSent = false;
    var self = this;

    this.setEventsOnEditor = function (newOnEditor) {
        self.onEditor = newOnEditor;
    },
            /**
             * Verifica se COtemplateType esta setado.
             * 
             * @param {array} array
             * @returns {Boolean}
             */
            this.COTemplateTypeIn = function (array) {
                return array.indexOf(this.COtemplateType) !== -1;
            },
            /**
             * Ativa 'Piece' desejada, e desativa todas as outras.
             * 
             * @param {element} piece
             * @returns {void}
             */
            this.changePiece = function (piece) {
                $('.piece').removeClass('active');
                var id = piece.attr('id');
                piece.addClass('active');
                this.currentPiece = id;
            },
            /**
             * Cria uma nova 'Screen'
             * 
             * @param {integer} id
             * @returns {void}
             */
            this.addScreen = function (id) {
                //variável para adição do ID do banco, se ele não existir ficará vazio.
                var plus = "";
                //se estiver setado o novo id
                if (this.isset(id)) {
                    //adiciona o código na varíavel
                    plus = ' idBD="' + id + '" ';
                }
                //incrementa o contador
                this.countScreen = this.countScreen + 1;
                //cria a div da nova screen, e adiciona o ID do banco, caso exista.
                var screenID = 'sc' + this.countScreen;
                $(".content").append('<div class="screen" id="' + screenID + '" ' + plus + '></div>');
                //cria o novo contador de pieceSet
                this.countPieceSet[screenID] = 0;
                //atualiza o pajinate
                this.attPajinate();

                //Se for novo ADD a 1° PieceSet
                var iddb = $('#' + screenID).attr('idbd');
                if (!this.isset(iddb)) {
                    //adiciona uma PieceSet nesta Screen se for uma Nova Screen
                    self.addPieceSet();
                }
            },
            /**
             * Atualiza a Paginação.
             * 
             * @returns {void}
             */
            this.attPajinate = function () {
                //pega o valor da quantidade de páginas
                var lastScreen = $('.screen').size() - 1;

                //recria o pajinate passando o start_page como a ultima tela.
                $('.canvas').pajinate({
                    start_page: lastScreen,
                    items_per_page: 1,
                    nav_label_first: '<<',
                    nav_label_last: '>>',
                    nav_label_prev: '<i class="fa fa-arrow-circle-left fa-3x"></i>',
                    nav_label_next: '<i class="fa fa-arrow-circle-right fa-3x"></i>',
                    show_first_last: false,
                    num_page_links_to_display: 20,
                    nav_panel_id: '.navscreen',
                    editor: this
                });
            },
            /**
             * Adiciona um novo 'PieceSet'.
             * 
             * @param {integer} id
             * @param {string} desc
             * @param {string} type
             * @returns {void}
             */
            this.addPieceSet = function (id, desc, type) {
                //variável para adição do ID do banco, se ele não existir ficará vazio.
                var plus = "";
                //variável para adição de descrição vinda do banco.
                var plusdesc = "";
                //variável para adição de tipo vindo do banco.
                var plustype = "";

                //se estiverem setadas as informações do banco
                if (this.isset(id) && this.isset(desc) && this.isset(type)) {
                    //adiciona o código na varíavel
                    plus = ' idBD="' + id + '" ';
                    plusdesc = desc;
                    plustype = type;
                }

                var parent = this;
                var piecesetID = this.currentScreenId + '_ps' + this.countPieceSet[this.currentScreenId];
                this.countPieces[piecesetID] = 0;
                // STOP HERE - CRIAR CLASSE PARA ESTA DIV DE ELEMENTOS
                $('#' + this.currentScreenId).append('' +
                        '<div class="PieceSet" id="' + piecesetID + '_list" ' + plus + '>' +
                        '<button class="addPiece" id="pie_' + piecesetID + '"><i class="fa fa-cubes fa-2x"></i><br>' + LABEL_ADD_PIECE + '</button>' +
                        '<button class="insertImage" id="pie_' + piecesetID + '"><i class="fa fa-file-image-o fa-2x"></i><br>' + LABEL_ADD_IMAGE + '</button>' +
                        '<button class="insertSound" id="pie_' + piecesetID + '"><i class="fa fa-file-audio-o fa-2x"></i><br>' + LABEL_ADD_SOUND + '</button>' +
                        '<button class="del delPieceSet pull-right"><i class="fa fa-times"></i></button>' +
                        '<input type="text" class="actName" value="' + plusdesc + '"/>' +
                        '<div id="' + piecesetID + '_forms"></div>' +
                        '<ul class="piecelist" id="' + piecesetID + '"></ul>' +
                        '<span class="clear"></span>' +
                        '</div>');

                // .actName 
                // Descrição Padrão do PieceSet
                if ($('#' + this.currentScreenId + ' .PieceSet[id="' + piecesetID + '_list"] .actName').val() === '') {
                    //Deixa a mesma mensagem
                    $('#' + this.currentScreenId + ' .PieceSet[id="' + piecesetID + '_list"] .actName').val('Descrição do Cabeçalho .....');
                    $('#' + this.currentScreenId + ' .PieceSet[id="' + piecesetID + '_list"] .actName').attr('noString', 'true');
                } else {
                    $('#' + this.currentScreenId + ' .PieceSet[id="' + piecesetID + '_list"] .actName').attr('noString', 'false');
                }


                this.countPieceSet[this.currentScreenId] = this.countPieceSet[this.currentScreenId] + 1;

                //Cria função do botões
                $("#" + piecesetID + "_list > button.insertImage").click(function () {
                    if (holdingCtrl) {
                        //Com o ctrl Pressionado
                        holdingCtrl = false;
                    } else {
                        //Click normal
                        parent.insertImgPieceSet(piecesetID, null, null);
                    }

                });
                $("#" + piecesetID + "_list > button.insertSound").click(function () {
                    parent.insertAudioPieceSet(piecesetID, null);
                });
                $("#" + piecesetID + "_list > button.delPieceSet").click(function () {
                    parent.delPieceSet(piecesetID);
                });

                //Se for novo ADD a 1° Piece
                var iddb = $('#' + piecesetID + "_list").attr('idbd');
                if (!this.isset(iddb)) {
                    //adiciona uma Piece neste pieceSet se for um Novo PieceSet
                    parent.addPiece(piecesetID);
                }

            },
            /**
             * Adiciona um 'Piece', vindo do Banco ou não.
             * 
             * @param {integer} id
             * @param {integer} idbd
             * @returns {void|false} False se for do template PRE ou TXT e já possuir piece.
             */
            this.addPiece = function (id, idbd) {
                var parent = this;
                var PieceSetId = id.replace("pie_", "");
                this.currentPieceSet = PieceSetId;
                //Se for PRE OU TXT
                //E Verificar se possui classe Piece dentro deste PieceSet 
                if ((parent.COTemplateTypeIn(parent.PRE) || parent.COTemplateTypeIn(parent.TXT))
                        && $('#' + PieceSetId + ' .piece').length) {
                    return false;
                }
                var isDB = this.isset(idbd);

                //variável para adição do ID do banco, se ele não existir ficará vazio.
                var plus = isDB ? ' idBD="' + idbd + '" ' : "";

                //Monta o id do Piece
                var pieceID = this.currentPieceSet + '_p' + this.countPieces[this.currentPieceSet];
                //Adiciona na array de contadores
                this.countElements[pieceID] = 0;

                /**
                 * Gera código HTML do 
                 * 
                 * @param {string} id
                 * @param {string} plus
                 * @param {string} tplClass
                 * @param {string} content
                 * 
                 * @return {string} HTML da li
                 */
                var generateLi = function (id, plus, tplClass, content) {
                    return '<li id="' + id + '" class="piece" ' + plus + '>' +
                            '<button class="del delPiece pull-right"><i class="fa fa-times"></i></button>' +
                            '<div class="' + tplClass + ' tpl">' +
                            content +
                            '</div>' +
                            '</li>';
                };

                /**
                 * Gera código HTML do botão de NewElement
                 * 
                 * @return {String} HTML do botão.
                 */
                var generateNewElementButton = function () {
                    return ('<button class="newElement"><i class="fa fa-cube fa-2x "></i><br>' + LABEL_ADD_ELEMENT + '</button><br>');
                };


                var MTE = parent.COTemplateTypeIn(parent.MTE);
                var multi = parent.COTemplateTypeIn(parent.MTE)
                        || parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP);
                var pre = parent.COTemplateTypeIn(parent.PRE);
                var txt = parent.COTemplateTypeIn(parent.TXT);
                var plc = parent.COTemplateTypeIn(parent.PLC);
                var dig = parent.COTemplateTypeIn(parent.DIG);

                var tplClass;
                var content = "";

                //Se o Template for MTE
                if (multi) {
                    tplClass = 'tplMulti';
                    content = generateNewElementButton() +
                            (!MTE ? "<ul id='" + pieceID + "_query' class='sortable'></ul>" +
                                    "<ul id='" + pieceID + "_query_resp' class='sortable'></ul>" : "");
                    //Se o template for PRE
                } else if (pre) {
                    tplClass = 'tplPre';
                    content = "";
                } else if (txt) {
                    tplClass = 'tplTxt';
                    content = "";
                } else if (parent.COTemplateTypeIn(parent.PLC)) {
                    tplClass = 'tplPlc';
                    content = '<div class="elementsPlc">' + generateNewElementButton() + '</div><div class="crosswords Table"></div>';
                }
                else if (parent.COTemplateTypeIn(parent.DIG)) {
                    tplClass = 'tplDig';
                    var html = '';
                    for (var i = 0; i < 4; i++) {
                        html += "<div class='Row'>";
                        for (var j = 0; j < 10; j++) {

                            //"ABCDEFGHIJKLMNOPQRSTUVWXYZBCDFGHJKLMNPQRSTVWXYZ" italo 
                            //ABCDEFGHIJKLMNOPQRSTUVWXYZVOW  bruno

                            var rndChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZVOW";
                            //ZYXOWVTSRQPNMKJHGFDC


                            html += "<div class='Cell' row='" + i + "' col='" + j + "' >" + rndChar.charAt(Math.floor(Math.random() * rndChar.length)) + "</div>";
                        }

                        html += "</div>";
                    }
                    content = '<div class="elementsDig">' + generateNewElementButton() + '</div><div class="wordsearch Table pull-left">' + html + '</div><div class="words-list"><b>Palavras:</b><ul></ul></div>';
                }

                $('#' + PieceSetId).append(generateLi(pieceID, plus, tplClass, content));

                //incrementa o contador de piece
                this.countPieces[this.currentPieceSet] = this.countPieces[this.currentPieceSet] + 1;


                if (!(txt || pre)) {
                    //adiciona a função do botão addElement
                    $("#" + pieceID + " button.newElement").click(function () {
                        parent.addElement();
                    });
                }

                //altera a seleção de piece
                parent.changePiece($('#' + pieceID));
                var iddb = $('#' + pieceID).attr('idbd');
                if (!this.isset(iddb)) {
                    //adiciona um elemento neste piece se for uma Nova Piece
                    parent.addElement();
                }

                //adiciona a função do botão delPiece
                $("#" + pieceID + "> button.delPiece").click(function () {
                    parent.delPiece(pieceID);
                });

            },
            this.canEditThisWordCross = function (pieceID, group) {
                var word = $(".piece[id='" + pieceID + "']").find('.element.text input').val();

                if (self.isset(word)) {
                    word = word.replace(/\s/g, '');
                    //OPCIONAL + Antes, se houver letras alteradas antes de algum cruzamento, então incrementa a posição de cada cruzamento

                    //Verificar se existe um cruzamento com alguma letra e essa letra fora alterada
                    for (var idx in self.crossWords) {
                        var crossWord = self.crossWords[idx];
                        //SOMENTE quando estar na mesma Piece
                        if (crossWord['pieceID'] === pieceID) {
                            if (crossWord['word1Group'] === group || crossWord['word2Group'] === group) {
                                var crossLetter = crossWord['letter'];
                                var crossPosition;
                                if (crossWord['word1Group'] === group) {
                                    crossPosition = crossWord['position1'];
                                    if (!self.isset(word[crossPosition]) || word[crossPosition] !== crossLetter) {
                                        //A letra que já fora cruzada com outra palavra não pode ser alterada
                                        return false;
                                    }
                                } else if (crossWord['word2Group'] === group) {
                                    crossPosition = crossWord['position2'];
                                    if (!self.isset(word[crossPosition]) || word[crossPosition] !== crossLetter) {
                                        //A letra que já fora cruzada com outra palavra não pode ser alterada
                                        return false;
                                    }
                                }

                            }
                        }
                    }

                    //Agora Verifica se existe alguma letra que não pertence ao mesmo groupo no 'caminho' 
                    var thisDivGroup = $(".piece[id='" + pieceID + "']").find("div[group='" + group + "']");
                    var txtDirection = thisDivGroup.attr('txtDirection');
                    var sizeOldLetters = 0;
                    var lastCellGroup;
                    thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Cell[groups*="'
                            + 'g' + thisDivGroup.attr('group') + '"]').each(function (index) {
                        //É encontrado na ordem : de cima para baixo, da esquerda para a direita
                        sizeOldLetters++;
                        lastCellGroup = $(this);
                    });

                    if (word.length > sizeOldLetters) {
                        //Verifica se possui Alguma célula com Letra no Caminho
                        if (txtDirection === 'h') {
                            for (var i = sizeOldLetters; i < word.length; i++) {
                                if (lastCellGroup.next().length !== 0) {
                                    //Existe uma próxima Célula. Veirificar se ela possui uma letra
                                    if (self.isset(lastCellGroup.next().text()) && lastCellGroup.next().text().replace(/\s/g, '') !== '') {
                                        //Encontrou uma letra
                                        return false;
                                    }
                                    //Não encontrou uma Letra
                                    lastCellGroup = lastCellGroup.next();
                                } else {
                                    //Não existe uma próxima célula
                                    break;
                                }
                            }
                        } else if (txtDirection === 'v') {
                            var indexCellWord = lastCellGroup.index();
                            for (var i = sizeOldLetters; i < word.length; i++) {
                                var nextRow = lastCellGroup.closest('.Row').next();
                                if (nextRow.length !== 0) {
                                    //Existe uma próxima Linha. Veirificar se ela possui uma letra na coluna dessa Palavra Corrente
                                    var nextCellGroup = nextRow.find('.Cell').eq(indexCellWord);
                                    if (self.isset(nextCellGroup.text()) && nextCellGroup.text().replace(/\s/g, '') !== '') {
                                        //Encontrou uma letra
                                        return false;
                                    }
                                    //Não encontrou uma Letra
                                    lastCellGroup = nextCellGroup;
                                } else {
                                    //Não existe uma próxima célula
                                    break;
                                }
                            }
                        }
                    }



                    return true;
                }

                return false;

            },
            this.delWordPLC = function (thisDivGroup) {
                //Então exclui alguma letras
                var txtDirection = thisDivGroup.attr('txtdirection');
                var currentTxtInput = thisDivGroup.find('font.editable').text().replace(/\s/g, '');

                var totalDeleted = currentTxtInput.length;
                //Busca a última célula que possui esse grupo
                var lastCellGroup = thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Cell[groups*=g' + thisDivGroup.attr('group') + ']').last();
                var idxLastCell = lastCellGroup.index();
                var idxFirstCell = thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Cell[groups*=g' + thisDivGroup.attr('group') + ']').first().index();
                //Apaga as letras 
                thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Cell[groups*="'
                        + 'g' + thisDivGroup.attr('group') + '"]').each(function (index) {
                    //É encontrado na ordem : de cima para baixo, da esquerda para a direita
                    //Então retira o atributo groups
                    if ($(this).attr('groups').split('g').length <= 2) {
                        //A letra só pertence a este único Grupo
                        $(this).removeAttr('groups');
                        $(this).html("");
                    } else {
                        //Somente retira o Group corrente de groups
                        var splitGroup = $(this).attr('groups').split('g' + thisDivGroup.attr('group'));
                        var before = splitGroup[0];
                        var after = splitGroup[1];
                        //Novo Groups
                        $(this).attr('groups', before + after);
                    }
                });

                if (txtDirection === 'h') {
                    //Então verificar toda a coluna = '' pra a exclusão
                    var mayDeleteColunmRight;
                    var mayDeleteColunmLeft;
                    while (totalDeleted > 0) {
                        var Row = thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row');
                        mayDeleteColunmRight = Row.size() !== 0;
                        mayDeleteColunmLeft = Row.size() !== 0;
                        Row.each(function () {
                            //Verificar últimas Células
                            if ($(this).find('.Cell').eq(idxLastCell).text().replace(/\s/g, '') !== '') {
                                //Não pode excluir
                                mayDeleteColunmRight = false;
                            }

                            //Verificar primeiras Células
                            if ($(this).find('.Cell').eq(idxFirstCell).text().replace(/\s/g, '') !== '') {
                                //Não pode excluir
                                mayDeleteColunmLeft = false;
                            }

                        });
                        if (mayDeleteColunmLeft || mayDeleteColunmRight) {
                            //Então Exlcui a Coluna e continua procurando outras, se existir pra deletar
                            Row.each(function () {
                                if (mayDeleteColunmLeft) {
                                    $(this).find('.Cell').eq(idxFirstCell).remove();
                                }
                                if (mayDeleteColunmRight) {
                                    $(this).find('.Cell').eq(idxLastCell).remove();
                                }

                            });
                        } else {
                            //Não pode deletar Algum
                            break;
                        }

                        if (mayDeleteColunmRight) {
                            idxLastCell--;
                        }


                        if (mayDeleteColunmLeft && mayDeleteColunmRight) {
                            //Deletou os dois extremos
                            totalDeleted--;
                        }

                        totalDeleted--;
                    }

                } else if (txtDirection === 'v') {
                    //Então verificar se toda a linha = '' para a deleção de cada
                    var mayDeleteRowTop;
                    var mayDeleteRowDown;
                    while (totalDeleted > 0) {
                        //Verificar se há linhas vazias Mais Abaixo
                        var lastRow = thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').last().find('.Cell');
                        mayDeleteRowDown = lastRow.size() !== 0;
                        lastRow.each(function () {
                            if ($(this).text().replace(/\s/g, '') !== '') {
                                //Não pode excluir
                                mayDeleteRowDown = false;
                            }
                        });
                        if (mayDeleteRowDown) {
                            //Então Exlcui a Linha e continua procurando outras, se existir pra deletar
                            thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').last().remove();
                        }

                        //Verificar se há linhas vazias Mais Acima
                        var firstRow = thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').first().find('.Cell');
                        mayDeleteRowTop = firstRow.size() !== 0;
                        firstRow.each(function () {
                            if ($(this).text().replace(/\s/g, '') !== '') {
                                //Não pode excluir
                                mayDeleteRowTop = false;
                            }
                        });
                        if (mayDeleteRowTop) {
                            //Então Exlcui a Linha e continua procurando outras, se existir pra deletar
                            thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').first().remove();
                        }

                        if (!mayDeleteRowDown && !mayDeleteRowTop) {
                            //Não pode deletar
                            break;
                        }

                        if (mayDeleteRowDown && mayDeleteRowTop) {
                            //Deletou os 2
                            totalDeleted--;
                        }

                        totalDeleted--;
                    }
                }

                //Exclui todos os cruzamento realizados com este group
                var thisPieceID = thisDivGroup.closest('.piece').attr('id');

                for (var idx in self.crossWords) {
                    var crossWord = self.crossWords[idx];
                    if (crossWord['pieceID'] === thisPieceID) {
                        //É da mesma Piece
                        if (crossWord['word1Group'] === thisDivGroup.attr('group')
                                || crossWord['word2Group'] === thisDivGroup.attr('group')) {
                            //Encontrou, então exlui essse cruzamento
                            self.crossWords.splice(idx, 1);
                        }
                    }
                }
            },
            this.addText = function (tagAdd, loaddata, idbd) {
                var parent = this;
                var ID = this.currentPiece + '_e' + this.countElements[this.currentPiece];

                this.countElements[this.currentPiece]++;

                var isLoaded = this.isset(loaddata);
                var isDB = this.isset(idbd);
                var FLAG_ACERTO = "Acerto";

                var haveDeleteButton = parent.COTemplateTypeIn(parent.MTE)
                        || parent.COTemplateTypeIn(parent.PLC)
                        || parent.COTemplateTypeIn(parent.DIG)
                        || parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP);
                var havemOptions = parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP);
                var isTextArea = parent.COTemplateTypeIn(parent.TXT);

                var nextPosition = (parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.MTE)
                        || parent.COTemplateTypeIn(parent.PLC)
                        || parent.COTemplateTypeIn(parent.DIG)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)) ? $(tagAdd).find(".element").size() + 1 : 0;

                var flag = (isDB && isLoaded) ? loaddata['flag'] : "";
                var position = (isDB && isLoaded) ? loaddata['position'] : nextPosition;

                var checked = isDB && isLoaded && flag === FLAG_ACERTO ? ' checked="checked"' : "";
                var initial_text = isLoaded ? loaddata['text'] : (isTextArea ? "" : LABEL_INITIAL_TEXT);
                var match = isDB ? loaddata['match'] : $(tagAdd).attr('group');
                var updated = 0;
                if (parent.COTemplateTypeIn(parent.PLC)) {
                    //Se for PLC, todos os elementos textos estarão como editados
                    updated = 1;
                }
                var plusDB = isDB ? 'idbd="' + idbd + '" updated="' + updated + '"' : '';

                var plus = 'position="' + position + '" match="' + match + '" ' + plusDB;

                var addDeleteButton = function (have) {
                    return have ? '<button class="del delElement pull-right"><i class="fa fa-times"></i></button>' : '';
                };
                var addTextArea = function (id, text) {
                    return "<textarea name='" + id + "_flag' class='TXT' id='" + id + "_flag' style='width:100%' >" + text + "</textarea>";
                };
                var addFontEditable = function (id, text) {
                    return '<font class="editable" id="' + id + '_flag">' + text + '</font>';
                };
                var addDiv = function (id, classes, plus, input, exclude) {
                    return '<div id="' + id + '_text" class="' + classes + '" ' + plus + '>' + input + exclude + '</div>';
                };

                var classes = havemOptions ? "text element moptions" : "text element";
                var input = isTextArea ? addTextArea(ID, initial_text) : addFontEditable(ID, initial_text);
                var del = addDeleteButton(haveDeleteButton);

                if (parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)
                        || parent.COTemplateTypeIn(parent.PRE)
                        || parent.COTemplateTypeIn(parent.TXT)) {
                    $(tagAdd).append(addDiv(ID, classes, plus, input, del));
                } else if (parent.COTemplateTypeIn(parent.MTE)
                        || parent.COTemplateTypeIn(parent.PLC)
                        || parent.COTemplateTypeIn(parent.DIG)) {
                    $(tagAdd).find('span:eq(0)').append(addDiv(ID, classes, plus, input, del));
                }

                var text_element = "#" + ID;
                var text_div = "#" + ID + "_text";

                if (isTextArea) {
                    //Para os textarea!
                    tinymce.init({
                        selector: "textarea#" + ID + "_flag"
                    });

                    $(text_element + "_flag").on('change', function () {
                        var txt_BD = $(text_element + "_flag").val();
                        var txt_NEW = $("body", $(text_element + "_flag_ifr").contents()).html();
                        var text_div = text_element + '_text';
                        //Verificar se foi Alterado em relação a do DB        
                        this.textChanged(txt_BD, txt_NEW, text_element, text_div);
                    });

                } else {

                    var editable = text_div + " > font.editable";
                    var value_txt = "#" + ID + "_flag.editable";
                    var id_const = ID;
                    //ID sempre muda, logo criar outra variável local id_const, quando o evento é chamado
                    $(text_div + " > button.delElement").click(function () {
                        parent.delElement(id_const + "_text");
                    });
                    $(editable).editable(function (value, settings) {
                        return(value);
                    }, {//save function(or page)
                        submitdata: {
                            op: "save"
                        }, //$_POST['op'] on save
                        id: "elementID", //$_POST['elementID'] on save
                        name: "newValue", //$_POST['newValue'] on save
                        type: "text", //input type ex: text, textarea, select
                        submit: "Update",
                        cancel: "Calcel",
                        //loadurl : "/editor/json",       //load function(or page), json
                        loadtype: "POST", //Load method
                        loaddata: {
                            op: "load"
                        }, //$_POST['op'] on load
                        indicator: 'Saving...', //HTML witch indicates the save process ex: <img src="img/indicator.gif">
                        tooltip: initial_text
                    });
                    //Quando clicar no editable
                    $(editable).on('click', function () {
                        var form = editable + " > form";
                        var input = form + " > input";
                        var submit = form + " > button[type=submit]";
                        //adiciona a função de foco ao input
                        $(input).on("focus", function () {
                            //se o valor for igual ao initial_text
                            if ($(input).val() === initial_text && initial_text === LABEL_INITIAL_TEXT) {
                                //remove o texto
                                $(input).val("");
                            }
                        });
                        $(input).on("change", function () {
                            //se não houver texto
                            if ($(input).val() === "") {
                                //adiciona o texto initial_text
                                $(input).val(initial_text);
                            } else if (parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG)) {
                                //Converte para maiúsculas se o template for do tipo PLC
                                $(input).val($(input).val().toUpperCase());
                            }
                        });
                        //adiciona a função de perda de foco do input
                        $(input).on("focusout", function () {

                            if (parent.COTemplateTypeIn(parent.PLC)) {
                                var thisDivGroup = $(this).closest('div[group]');
                                var currentPieceID = $(this).closest('.piece').attr('id');
                            }
                            var edited = false;


                            if (!parent.COTemplateTypeIn(parent.PLC) ||
                                    (parent.COTemplateTypeIn(parent.PLC) && parent.canEditThisWordCross(currentPieceID, thisDivGroup.attr('group')))) {
                                //da submit no formulário
                                $(form).submit();
                                //Verificar se foi Alterado em relação a do DB             
                                parent.textChanged(initial_text, value_txt, text_element, text_div);
                                var txt_New_noHtml = $(value_txt).text();
                                //===========================
                                if (parent.COTemplateTypeIn(parent.PRE) && (txt_New_noHtml === "")) {
                                    // O template é do tipo PRE  e o elemento está vazio
                                    //Deleta o PieceSet
                                    parent.delPieceSet(parent.currentPieceSet, true); // TODO
                                    //Atualiza Total de elementos e o Total alterados
                                    parent.totalElements = $('.element').size();
                                    parent.totalElementsChanged = $('.element[updated="1"]').size();
                                    parent.totalElementsNOchanged = $('.element[updated="0"]').size();
                                    parent.totalPieces = $('.piece').size();
                                    parent.totalPiecesets = $('.PieceSet').size();

                                    if (parent.isset(idbd)) {
                                        //Enviar array de objetos a serem excluidos 
                                        parent.saveData({
                                            op: "delete",
                                            array_del: parent.orderDelets
                                        },
                                        //função sucess
                                        function (response, textStatus, jqXHR) {
                                            parent.orderDelets = []; // ZERA array de objetos a serem excluidos 
                                            $('.savescreen').append('<br><p> Objeto PRE Deletado!...</p>');
                                            //Verificar se acabou as requisições
                                            parent.verify_requestFinish();
                                        });
                                    }

                                }

                                edited = true;
                            }
                            if (parent.COTemplateTypeIn(parent.PLC) && edited) {
                                //Seleciona o grupo corrente, aguardando assim o click em alguma letra 
                                // de alguma palavra cruzada, para realizar um novo cruzamento

                                var currentTxtInput = thisDivGroup.find('.element font').text().replace(/\s/g, '');
                                var str = "";
                                if (currentTxtInput !== "CliqueparaAlterar..." && currentTxtInput !== "Clicktoedit" &&
                                        currentTxtInput !== "UpdateCalcel" &&
                                        currentTxtInput !== "") {

                                    if (thisDivGroup.closest(".elementsPlc").siblings(".crosswords").text().replace(/\s/g, '') === '') {
                                        //Primeira palavra, na horizontal
                                        thisDivGroup.attr('txtDirection', 'h');
                                        str += "<div class='Row'>";
                                        for (var i = 0; i < currentTxtInput.length; i++) {
                                            str += "<div class='Cell' groups='g" + thisDivGroup.attr('group') + "'>" + currentTxtInput[i] + "</div>";
                                        }
                                        str += "</div>";

                                        thisDivGroup.closest(".elementsPlc").siblings(".crosswords").html(str);
                                        //Então add class de Selecionado nesse grupo
                                        thisDivGroup.attr('selected', 'true');

                                        //Após add a primeira palavra no CrossWord habilita o botão de criar elemento
                                        thisDivGroup.closest(".tplPlc").find(".newElement").removeAttr('disabled');
                                    } else {
                                        //Já existe uma palavra no CrossWords
                                        if (!self.isset(thisDivGroup.attr('selected'))) {
                                            thisDivGroup.attr('selected', 'true');
                                            thisDivGroup.siblings('div[lastSelected]').removeAttr('lastSelected');
                                            thisDivGroup.attr('lastSelected', 'true');
                                        }
                                        //Verificar se a palavra já estar no crossWord
                                        //Se estiver então atualiza ela
                                        var txtDirection = thisDivGroup.attr('txtDirection');
                                        var sizeOldLetters = 0;
                                        var lastCellGroup;
                                        var constLastCellGroup;
                                        thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Cell[groups*="'
                                                + 'g' + thisDivGroup.attr('group') + '"]').each(function (index) {
                                            //É encontrado na ordem : de cima para baixo, da esquerda para a direita
                                            sizeOldLetters++;
                                            if (currentTxtInput.substring(index, index + 1).replace(/\s/g, '') === '') {
                                                //Então retira o atributo groups
                                                $(this).removeAttr('groups');
                                            }
                                            $(this).html(currentTxtInput.substring(index, index + 1));
                                            constLastCellGroup = $(this);
                                            lastCellGroup = $(this);
                                        });

                                        if (currentTxtInput.length > sizeOldLetters) {

                                            for (var i = sizeOldLetters; i < currentTxtInput.length; i++) {
                                                //Então adiciona o restante
                                                if (txtDirection === 'h') {
                                                    if (lastCellGroup.next().length === 0) {
                                                        //Então NÃO existe uma célula seguinte
                                                        //Adiciona a quantidade de células restantes
                                                        var sizeColunmAddAfter = currentTxtInput.length - i;
                                                        for (var cont = 0; cont < sizeColunmAddAfter; cont++) {
                                                            lastCellGroup.closest('.crosswords').find('.Row').each(function () {
                                                                $(this).append("<div class='Cell'></div>");
                                                            });

                                                        }
                                                    }
                                                    //Adiciona as letras restantes nas próximas células
                                                    //Add o grupo
                                                    lastCellGroup.next().attr('groups', "g" + thisDivGroup.attr('group'));
                                                    //Add a letra
                                                    lastCellGroup.next().html(currentTxtInput[i]);
                                                    //Next
                                                    lastCellGroup = lastCellGroup.next();
                                                } else if (txtDirection === 'v') {
                                                    var indexCellWord = lastCellGroup.index();
                                                    var totalCells = lastCellGroup.closest('.Row').find('.Cell').last().index() + 1;
                                                    var nextCellGroup = lastCellGroup.closest('.Row').next().find('.Cell').eq(indexCellWord);
                                                    if (nextCellGroup.length === 0) {
                                                        //Então NÃO existe uma Linha seguinte
                                                        //Adiciona a quantidade de Linhas restantes
                                                        var sizeRowAddAfter = currentTxtInput.length - i;
                                                        var newRow = $("<div class='Row'></div>");
                                                        //Inclui a quantidade de células existentes
                                                        for (var contCells = 0; contCells < totalCells; contCells++) {
                                                            newRow.append("<div class='Cell'></div>");
                                                        }

                                                        for (var cont = 0; cont < sizeRowAddAfter; cont++) {
                                                            lastCellGroup.closest('.crosswords').append(newRow);
                                                        }

                                                        nextCellGroup = lastCellGroup.closest('.Row').next().find('.Cell').eq(indexCellWord);
                                                    }
                                                    //Adiciona as letras restantes nas próximas células
                                                    //Add o grupo
                                                    nextCellGroup.attr('groups', "g" + thisDivGroup.attr('group'));
                                                    //Add a letra
                                                    nextCellGroup.html(currentTxtInput[i]);
                                                    //Next
                                                    lastCellGroup = nextCellGroup;
                                                }
                                            }
                                        } else if (currentTxtInput.length < sizeOldLetters) {
                                            //Então exclui alguma letras
                                            var totalDeleted = sizeOldLetters - currentTxtInput.length;
                                            var idxLastCell = constLastCellGroup.index();
                                            var idxLastRow = constLastCellGroup.closest('.Row').index();
                                            if (txtDirection === 'h') {

                                                //Então verificar toda a coluna = '' pra a exclusão
                                                var mayDeleteColunm;
                                                while (totalDeleted > 0) {
                                                    mayDeleteColunm = true;
                                                    thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').each(function () {
                                                        if ($(this).find('.Cell').eq(idxLastCell).text().replace(/\s/g, '') !== '') {
                                                            //Não pode excluir
                                                            mayDeleteColunm = false;
                                                        }
                                                    });
                                                    if (mayDeleteColunm) {
                                                        //Então Exlcui a Coluna e continua procurando outras, se existir pra deletar
                                                        thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').each(function () {
                                                            $(this).find('.Cell').eq(idxLastCell).remove();
                                                        });
                                                    } else {
                                                        //Não pode deletar
                                                        break;
                                                    }

                                                    idxLastCell--;
                                                    totalDeleted--;
                                                }

                                            } else if (txtDirection === 'v') {
                                                //Então verificar se toda a linha = '' para a deleção de cada
                                                var mayDeleteRow;
                                                while (totalDeleted > 0) {
                                                    mayDeleteRow = true;
                                                    thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').last().find('.Cell').each(function () {
                                                        if ($(this).text().replace(/\s/g, '') !== '') {
                                                            //Não pode excluir
                                                            mayDeleteRow = false;
                                                        }
                                                    });
                                                    if (mayDeleteRow) {
                                                        //Então Exlcui a Linha e continua procurando outras, se existir pra deletar
                                                        thisDivGroup.closest('.tplPlc').find('.crosswords').find('.Row').last().remove();
                                                    } else {
                                                        //Não pode deletar
                                                        break;
                                                    }

                                                    totalDeleted--;
                                                }
                                            }

                                        }

                                    }

                                }
                            }

                            //===========================
                        });
                        //seta o foco no input
                        $(input).focus();

                    });
                }
            },
//Verificar se foi Alterado em relação a do DB
            this.textChanged = function (initial_text, value_txt, text_element, text_div) {
                var parent = this;
                value_txt = (this.COTemplateTypeIn(this.TXT)) ? value_txt : $(value_txt).text();
                if (initial_text !== value_txt || parent.COTemplateTypeIn(parent.PLC)) {
                    $(text_element).attr('updated', 1); // Fora Alterado!
                    $(text_div).attr('updated', 1);
                } else {
                    $(text_element).attr('updated', 0); // NÃO foi alterado!
                    $(text_div).attr('updated', 0);
                }

            };

    this.addUploadForm = function (tagAdd, type, responseFunction, loaddata, idbd) {
        //Verificar se é um elemento da PieceSet
        var isElementPieceSet = tagAdd.hasClass('elementPieceSet');
        var isElementCobject = tagAdd.hasClass('elementCobject');
        if (isElementPieceSet) {
            var pieceSetID = tagAdd.closest('div').attr('id').split('_', 2);
            var pieceSetID = pieceSetID[0] + '_' + pieceSetID[1];
            if (!this.isset(this.countElementsPS[pieceSetID])) {
                //Se não existe algo
                this.countElementsPS[pieceSetID] = 0;
            }
            ID = pieceSetID + '_e' + this.countElementsPS[pieceSetID];
            this.countElementsPS[pieceSetID]++;
        } else if (isElementCobject) {
            if (!this.isset(this.countElementsCobject)) {
                //Se não existe algo
                this.countElementsCobject = 0;
            }
            ID = 'e' + this.countElementsCobject;
            this.countElementsCobject++;
        } else {
            ID = this.currentPiece + '_e' + this.countElements[this.currentPiece];
            this.countElements[this.currentPiece]++;
        }

        var parent = this;
        //Posição Default !!
        var position = 0;

        if (parent.isset(idbd)) {
            // Se existe no banco, então foi salvo no elemento o position
            position = loaddata['position'];
            if (!isElementCobject && !isElementPieceSet) {
                // Se é um elemento da Piece
                var flag = loaddata['flag'];
            }
        } else {
            if (parent.COTemplateTypeIn(parent.AEL)
                    || parent.COTemplateTypeIn(parent.MTE)
                    || parent.COTemplateTypeIn(parent.PLC)
                    || parent.COTemplateTypeIn(parent.DIG)
                    || parent.COTemplateTypeIn(parent.DDROP)
                    || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                //Sua Posição dentro do Grupo
                position = $(tagAdd).find(".element").size() + 1;
            }
        }



        var checked = "";
        if (this.isset(flag) && flag === "Acerto") {
            checked = 'checked="checked"';
        }


        //variável para adição do ID do banco, se ele não existir ficará vazio.
        var libBDID = 'position="' + position + '" ';

        //se estiver setado o novo id
        if (this.isset(loaddata) && this.isset(loaddata['library'])) {
            var match = loaddata['match'];
            //adiciona o código na varíavel
            libBDID += ' idbd="' + idbd + '" library_idbd ="' + loaddata['library']['ID'] + '"\n\
                        updated = "' + 0 + '" match="' + match + '" ';
        } else {
            var match = $(tagAdd).attr('group');
            libBDID += 'match="' + match + '"';
        }


        //Default Image
        var uploadType = (type['type'] ? type['type'] : 'image');
        var uploadAccept = Array();
        uploadAccept = (type['accept'] ? type['accept'] : '*');
        var uploadMaxSize = (type['maxsize'] ? type['maxsize'] : 1024 * 5);
        //var uploadMaxWidth = (type['maxwidth']?type['maxwidth']: 800); 
        //var uploadMaxHeight = (type['maxheight']?type['maxheight']: 600); 

        var accept = '';

        $.each(uploadAccept, function (key, value) {
            //sound  tornar-se audio
            var extAcept = (uploadType === 'sound') ? 'audio' : uploadType;
            accept += extAcept + '/' + value + ', ';
        });

        var file = ID + "_" + uploadType;
        var form = file + "_form";
        var input = file + "_input";
        var name_DB = file + "_nameDB"; // Id--> Unico pra cada form, guardando o name_DB corrent

        var name_db = '';
        var ld_src = "";
        if (parent.isset(parent.isload)) {
            if (parent.isload && this.isset(loaddata) && this.isset(loaddata['library'])) {
                ld_src = loaddata['library']['src'];
                name_db += '<input type="hidden" name="name_DB" value="' +
                        ld_src + '" + id="' + name_DB + '">';
            }
        }



        var html;
        if (parent.COTemplateTypeIn(parent.AEL)
                || parent.COTemplateTypeIn(parent.DDROP)
                || parent.COTemplateTypeIn(parent.ONEDDROP)) {
            html = '<div id="' + file + '" ' + libBDID + ' class="' + uploadType + ' element moptions">';
        } else {
            html = '<div id="' + file + '" ' + libBDID + ' class="' + uploadType + ' element">';
        }

        if (parent.COTemplateTypeIn(parent.MTE) || parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG)) {
            html += '<button class="del delElement pull-right"><i class="fa fa-times"></i></button>';
        }
        else {
            html += "";
        }
        html += '<form enctype="multipart/form-data" id="' + form + '" method="post" action="/Editor/upload">' +
                '<div id="' + file + '" ' + libBDID + ' class="' + uploadType + '">' +
                '<button class="del delElement pull-right"><i class="fa fa-times"></i></button>' +
                '<form enctype="multipart/form-data" id="' + form + '" method="post" action="/Editor/upload">' +
                '<input type="hidden" name="op" value="' + uploadType + '"/>' +
                name_db +
                '<label>' + uploadType + ': ' +
                '<input class =' + '"input_element"' + ' id="' + input + '" type="file" id="' + uploadType + '" name="file" value="' + ld_src + '" accept="' + accept + '" />' +
                '</label>' +
                '</form>' +
                '</div>';

        if (isElementPieceSet || isElementCobject) {
            $(tagAdd).append(html);
        } else {
            if (parent.COTemplateTypeIn(parent.MTE) || parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG)) {
                $(tagAdd).find('span:eq(0)').append(html);
            } else if (parent.COTemplateTypeIn(parent.AEL)
                    || parent.COTemplateTypeIn(parent.DDROP)
                    || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                $(tagAdd).append(html);
            }
        }

        if (this.isset(loaddata) && this.isset(loaddata['library'])) {
            var src = '/library/' + uploadType + '/' + loaddata['library']['src'];
            responseFunction(src, file, form);
        }

        $("#" + file + "> button.delElement").click(function () {
            parent.delElement(file);
        });

        $("#" + file + " .input_element").change(function () {
            //Se o input do Upload alterou, então verifica se NÃO existe IMG
            if ($("#" + file + " img").size() === 0) {
                // Não existe IMG, logo adicionar uma nova e incrementa o contador do elements
                parent.countElements[parent.currentPiece]++;
            }
        });


        $("#" + input).bind('change', function () {
            var filesize = this.files[0].size / 1024; //KB
            filesize = filesize / 1024; //MB
            filesize = Math.round(filesize * 1000) / 1000; //3 decimal

            if (filesize <= uploadMaxSize) {
                var extAcept = (uploadType === 'sound') ? 'audio' : uploadType;
                if (!(this.files[0].type.indexOf(extAcept) === -1)) {

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        responseFunction(e.target.result, file, form);
                    };

                    reader.readAsDataURL(this.files[0]);
                } else {
                    alert(ERROR_INCOMPATIBLE_TYPE);
                }
            }
            else {
                alert(ERROR_FILE_SIZE + uploadMaxSize + 'MB');
            }

        });

        //Trigger pra clicar no btn de Upload
        $("#" + input).trigger("click");
    },
//Add imagem do PieceSet
            this.insertImgPieceSet = function (piecesetID, idbd, loaddata) { // piecesetID e/ou idbd do element
                if (this.isset(piecesetID)) {
                    var tagAdd = $('#' + piecesetID + "_forms");
                    if (!this.existID('#' + piecesetID + "_forms_image_form")) {
                        tagAdd.append("<span class='elementPieceSet'></span>");
                        this.addImage(tagAdd.find('span:last'), loaddata, idbd);
                    }
                } else if (this.isset(loaddata['piecesetID'])) {
                    var psIDBD = loaddata['piecesetID'];
                    var psID = $('.PieceSet[idbd=' + psIDBD + ']').attr('id').split('_', 2);
                    psID = psID[0] + "_" + psID[1];
                    var tagAdd = $('#' + psID + "_forms");
                    if (!this.existID('#' + psID + "_forms_image_form")) {
                        tagAdd.append("<span class='elementPieceSet'></span>");
                        this.addImage(tagAdd.find('span:last'), loaddata, idbd);
                    }

                }
            },
//Add imagem do Cobject
            this.insertImgCobject = function (idbd, loaddata) {
                var tagAdd = $('#cobject_description');
                //Verificar se já existe um .elementCobject
                var thereElementCobject = tagAdd.find('.elementCobject').length > 0;

                if (!this.isset(idbd)) {
                    if (thereElementCobject) {
                        tagAdd.children('span:last').after("<span class='elementCobject'></span>");
                    } else {
                        tagAdd.children('#COdescription').after("<span class='elementCobject'></span>");
                    }
                    this.addImage(tagAdd.find('span:last'), loaddata, idbd);
                } else {
                    var coIDBD = loaddata['cobjectID'];
                    if (thereElementCobject) {
                        tagAdd.children('span:last').after("<span class='elementCobject'></span>");
                    } else {
                        tagAdd.children('#COdescription').after("<span class='elementCobject'></span>");
                    }
                    this.addImage(tagAdd.find('span:last'), loaddata, idbd);
                }
            },
//Add Sound no Cobject
            this.insertSoundCobject = function (idbd, loaddata) {
                var tagAdd = $('#cobject_description');
                //Verificar se já existe um .elementCobject
                var thereElementCobject = tagAdd.find('.elementCobject').length > 0;
                if (!this.isset(idbd)) {
                    if (thereElementCobject) {
                        tagAdd.children('span:last').after("<span class='elementCobject'></span>");
                    } else {
                        tagAdd.children('#COdescription').after("<span class='elementCobject'></span>");
                    }
                    this.addSound(tagAdd.find('span:last'), loaddata, idbd);
                } else {
                    var coIDBD = loaddata['cobjectID'];
                    if (thereElementCobject) {
                        tagAdd.children('span:last').after("<span class='elementCobject'></span>");
                    } else {
                        tagAdd.children('#COdescription').after("<span class='elementCobject'></span>");
                    }
                    this.addSound(tagAdd.find('span:last'), loaddata, idbd);
                }
            },
            this.insertAudioPieceSet = function (piecesetID, idbd, loaddata) {
                if (this.isset(piecesetID)) {
                    var tagAdd = $('#' + piecesetID + "_forms");
                    if (!this.existID('#' + piecesetID + "_forms_sound_form")) {
                        tagAdd.append("<span class='elementPieceSet'></span>");
                        this.addSound(tagAdd.find('span:last'), loaddata, idbd);
                    }
                } else if (this.isset(loaddata['piecesetID'])) {
                    var psIDBD = loaddata['piecesetID'];
                    var psID = $('.PieceSet[idbd=' + psIDBD + ']').attr('id').split('_', 2);
                    psID = psID[0] + "_" + psID[1];
                    var tagAdd = $('#' + psID + "_forms");
                    if (!this.existID('#' + psID + "_forms_sound_form")) {
                        tagAdd.append("<span class='elementPieceSet'></span>");
                        this.addSound(tagAdd.find('span:last'), loaddata, idbd);
                    }

                }
            },
            this.addImage = function (tagAdd, loaddata, idbd) {
                this.addUploadForm(tagAdd, {
                    type: 'image',
                    accept: Array("png", "gif", "bmp", "jpeg", "jsc", "ico"),
                    maxsize: (1024 * 5) //5MB
                            //função onChange
                }, function (src, fileid, formid) {
                    $("#" + fileid + " > img").remove("img");
                    $("#" + fileid).append('<img  src="' + src + '" width="320" height="240" alt="Image"/>');
                }, loaddata, idbd);
            },
            this.addSound = function (tagAdd, loaddata, idbd) {
                var parent = this;
                this.addUploadForm(tagAdd, {
                    type: 'sound',
                    accept: Array("mp3", "wav", "ogg"),
                    maxsize: (1024 * 10) //10MB
                }, function (src, fileid, formid) {
                    $("#" + fileid + " > audio").remove("audio");
                    $("#" + fileid).append(
                            //'<object id="obj_sound" height="100" width="150" data="'+src+'" type="audio/x-mpeg"></object>')
                            '<audio controls="controls" loop preload="preload" title="Titulo"> \n\
             <source src="' + src + '"> ' + ERROR_BROWSER_SUPORT + ' </audio>');
                }, loaddata, idbd);
            },
            this.addVideo = function (tagAdd, loaddata) {
                var parent = this;
                this.addUploadForm(tagAdd, {
                    type: 'video',
                    accept: Array("mp4", "wmv", "ogg"),
                    maxsize: (1024 * 20) //10MB
                }, function (src, fileid, formid) {
                    $("#" + fileid + " > video").remove("video");
                    $("#" + fileid).append('' +
                            '<video src="' + src + '" width="320" height="240" controls="controls">' +
                            ERROR_BROWSER_SUPORT +
                            '</video>');
                }, loaddata);
            },
            this.addElement = function (idbd, type, loaddata) {
                //O position garante que o  último elemento inserido sempre terá o position Maior que Todos
                var parent = this;

                //Se o template for PLC, só mostra a opção de excluir se for o último grupo
                //E desabilita o botão new Element da peça corrente
                if (parent.COTemplateTypeIn(parent.PLC)) {
                    var btnNewElementClicked = $('.piece#' + parent.currentPiece + ' .newElement');
                    $(btnNewElementClicked).attr('disabled', 'true');
                    $(btnNewElementClicked).closest('.elementsPlc').find('div[group] .del').hide();
                }


                //variável para adição do ID do banco, se ele não existir ficará vazio.
                var plus = "";

                //se estiver setado o novo id
                if (this.isset(idbd)) {
                    //adiciona o código na varíavel e também uma flag de alteração
                    plus = ' idBD="' + idbd + '" updated="' + 0 + '"';
                    var match = loaddata['match'];
                    var flag = loaddata['flag'];
                }

                var checked = "";
                if (this.isset(flag) && flag === "Acerto") {
                    checked = 'checked="checked"';
                }

                var elementID = this.currentPiece + '_e' + this.countElements[this.currentPiece];

                if (parent.COTemplateTypeIn(parent.MTE) || parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG) || parent.COTemplateTypeIn(parent.TXT) ||
                        parent.COTemplateTypeIn(parent.PRE)) {
                    //Agrupando Elementos
                    var group;
                    if (this.isset(match) && match !== -1) {
                        // É um load
                        group = match;
                        var sameElement = false;
                        //Já existe o div[elementID]
                        sameElement = $('#' + parent.currentPiece + ' div[group=' + match + ']').length === '1';
                    } else {
                        var last_group = $('#' + parent.currentPiece).find('div[group]').last().attr('group');
                        var next_group;
                        if (parent.isset(last_group)) {
                            next_group = parseInt(last_group);
                            next_group++;
                        } else {
                            next_group = 1;
                        }
                        group = next_group;
                    }
                }

                if (parent.COTemplateTypeIn(parent.TXT) || parent.COTemplateTypeIn(parent.PRE)) {
                    var html = $('<div group="' + group + '"></div>');
                }

                if (parent.MTE.indexOf(parent.COtemplateType) !== -1 || parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG)) {
                    var newDivMatch = false;
                    //Verificar se já existe essa div group 
                    if ($("#" + parent.currentPiece + " div[group=" + group + "]").length === 0) {
                        //Não existe, então cria um novo
                        newDivMatch = true;
                        var htmlDefault = '<div group="' + group + '">';
                        var html = htmlDefault + '<span group="' + group + '">' +
                                '<div>';

                        html += '' +
                                '<button class="insertImage"><i class="fa fa-file-image-o fa-2x"></i><br>' + LABEL_ADD_IMAGE + '</button>' +
                                '<button class="insertSound"><i class="fa fa-file-audio-o fa-2x"></i><br>' + LABEL_ADD_SOUND + '</button>' +
                                '<button class="insertText" ><i class="fa fa-font fa-2x"></i><br>' + LABEL_ADD_TEXT + '</button>' +
                                '<button class="del delElement pull-right"><i class="fa fa-times"></i></button>';
                        if (parent.COTemplateTypeIn(parent.DIG)) {
                            html += '<button class="pull-right changeOrientation" match="' + group + '" orientation="V" ><i class="fa fa-arrows-v"></i></button>';
                        }
                        html +=
                                '<br>' +
                                '<br>' +
                                '<br>' +
                                '<label>' +
                                '</div>';
                        if (!(parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG))) {
                            html += '<input type="checkbox" class="correct" match="' + group +
                                    '" value="Correct"' + checked + '/>' + LABEL_CORRECT;
                        }
                        html += '</label><br>';
                    } else {
                        // Já existe, html = '';
                        html = "";
                    }

                } else if (parent.COTemplateTypeIn(parent.PRE)) {
                    $('li[id="' + parent.currentPiece + '"] div.tplPre').append(html);
                } else if (parent.COTemplateTypeIn(parent.TXT)) {
                    $('li[id="' + parent.currentPiece + '"] div.tplTxt').append(html);
                } else if (parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                    var group;
                    var isResp;
                    if (this.isset(match) && match !== -1) {
                        // É um load
                        var right_match;
                        right_match = match.split('_')[1];
                        isResp = this.isset(right_match);
                        //If true é a resposta   
                        group = match;
                        var sameElement = false;
                        //Já existe o li[elementID]
                        sameElement = $('#' + parent.currentPiece + ' div[group=' + match + ']').length === '1';

                    } else {
                        var last_group = $('#' + parent.currentPiece).find('div[group]').last().attr('group');
                        var next_group;
                        if (parent.isset(last_group)) {
                            last_group = last_group.split('_')[0];
                            next_group = parseInt(last_group);
                            next_group++;
                        } else {
                            next_group = 1;
                        }
                        group = next_group;
                    }

                    var htmlDefault = '<div group="' + group + '">';
                    if (!sameElement) {
                        //Pode ADD um novo grupo
                        if (!this.isset(isResp) || !isResp) {
                            if (!parent.COTemplateTypeIn(parent.ONEDDROP) ||
                                    (parent.COTemplateTypeIn(parent.ONEDDROP) &&
                                            group === 1)) {
                                //Possui dois elementos no mesmo li, logo retira o: plus e : class="element moptions"
                                html = '<li>' +
                                        htmlDefault +
                                        '<spam group="' + group + '">(' + group + ')</spam>' +
                                        '<button class="insertImage"><i class="fa fa-file-image-o fa-2x"></i><br>' + LABEL_ADD_IMAGE + '</button>' +
                                        '<button class="insertSound"><i class="fa fa-file-audio-o fa-2x"></i><br>' + LABEL_ADD_SOUND + '</button>' +
                                        '<button class="insertText" ><i class="fa fa-font fa-2x"></i><br>' + LABEL_ADD_TEXT + '</button>' +
                                        '<button class="del delElement pull-right"><i class="fa fa-times"></i></button>' +
                                        '<br><br><br><br></div>' +
                                        '</li>';
                            } else {
                                html = "";
                            }
                        } else {
                            html = "";
                        }


                        var isAddTwoElementsAel = false;
                        if (!this.isset(isResp) || isResp) {
                            if (!this.isset(isResp)) {
                                group += '_1';
                            }
                            var htmlDefault = '<div group="' + group + '">';
                            //this.countElements[this.currentPiece] varia de 2 a 2 no AEL

                            if (!this.isset(isResp)) {
                                //Então adciona mais 1 no contador de IDS dos elements
                                //  DEl                   this.countElements[this.currentPiece] = this.countElements[this.currentPiece]+1;
                                //                        elementID = this.currentPiece+'_e'+this.countElements[this.currentPiece]; 
                                isAddTwoElementsAel = true;
                            }

                            var html2 = '<li>' + htmlDefault +
                                    '<spam group="' + group + '">(' + group + ')</spam>' +
                                    '<button class="insertImage" ><i class="fa fa-file-image-o fa-2x"></i><br>' + LABEL_ADD_IMAGE + '</button>' +
                                    '<button class="insertSound"><i class="fa fa-file-audio-o fa-2x"></i><br>' + LABEL_ADD_SOUND + '</button>' +
                                    '<button class="insertText" ><i class="fa fa-font fa-2x"></i><br>' + LABEL_ADD_TEXT + '</button>';
                            if (parent.COTemplateTypeIn(parent.ONEDDROP) &&
                                    group.split('_')[0] > 1) {
                                html2 += '<button class="del delElement pull-right"><i class="fa fa-times"></i></button>';
                            }
                            html2 += '<br><br><br></div></li>';

                        }

                        if (self.isset(loaddata)) {
                            var lastGroupASK;
                            var lastGroupANSWER;
                            var lastListASK;
                            var lastListANSWER;
                            if (!self.isset(group.split('_')[1])) {
                                //E um ask
                                lastListASK = $("#" + parent.currentPiece + "_query").find('li:last');
                                var continues = true;
                                do {
                                    if (lastListASK.size() !== 0) {
                                        lastGroupASK = lastListASK.find('div[group]');
                                    }

                                    if (lastListASK.size() === 0) {
                                        $("#" + parent.currentPiece + "_query").prepend(html);
                                        continues = false;
                                    } else if (group > lastGroupASK.attr('group')) {
                                        lastListASK.after(html);
                                        continues = false;
                                    } else {
                                        //lastList agora e um grupo anterior
                                        lastListASK = lastListASK.prev();
                                    }
                                } while (continues);

                            } else {
                                //E um answer
                                var numGroupAnswer = group.split('_')[0];
                                lastListANSWER = $("#" + parent.currentPiece + "_query_resp").find('li:last');
                                var continues = true;
                                do {
                                    if (lastListANSWER.size() !== 0) {
                                        lastGroupANSWER = lastListANSWER.find('div[group]');
                                    }

                                    if (lastListANSWER.size() === 0) {
                                        $("#" + parent.currentPiece + "_query_resp").prepend(html2);
                                        continues = false;
                                    } else if (numGroupAnswer > lastGroupANSWER.attr('group')) {
                                        lastListANSWER.after(html2);
                                        continues = false;
                                    } else {
                                        //lastList agora e um grupo anterior
                                        lastListANSWER = lastListANSWER.prev();
                                    }
                                } while (continues);

                            }
                        } else {
                            $("#" + parent.currentPiece + "_query").append(html);
                            if (this.isset(html2)) {
                                $("#" + parent.currentPiece + "_query_resp").append(html2);
                            }
                        }



                    } else {
                        //muda o Element para da um append no elemento Pergunta Existente
                        elementID = $('div[match=' + match + ']').attr('id');
                    }



                }

                if ((parent.COTemplateTypeIn(parent.MTE))) {
                    if (newDivMatch) {
                        html += '</span></div>';

                        if (self.isset(loaddata)) {
                            var lastGroupASK;
                            //E um ask
                            lastGroupASK = $('#' + parent.currentPiece + " > div.tplMulti").find('div[group]:last');
                            var continues = true;
                            do {

                                if (lastGroupASK.size() === 0) {
                                    $('#' + parent.currentPiece + " > div.tplMulti > br").after(html);
                                    continues = false;
                                } else if (group > lastGroupASK.attr('group')) {
                                    lastGroupASK.after(html);
                                    continues = false;
                                } else {
                                    //lastList agora e um grupo anterior
                                    lastGroupASK = lastGroupASK.prev();
                                }
                            } while (continues);

                        } else {
                            $('#' + parent.currentPiece + " > div.tplMulti").append(html);
                        }

                    }
                } else if (parent.COTemplateTypeIn(parent.PLC)) {
                    if (newDivMatch) {
                        html += '</span></div>';

                        if (self.isset(loaddata)) {
                            var lastGroupASK;
                            //E um ask
                            lastGroupASK = $('#' + parent.currentPiece + " > div.tplPlc .elementsPlc").find('div[group]:last');
                            var continues = true;
                            do {

                                if (lastGroupASK.size() === 0) {
                                    $('#' + parent.currentPiece + " > div.tplPlc .elementsPlc").append(html);
                                    continues = false;
                                } else if (group > lastGroupASK.attr('group')) {
                                    lastGroupASK.after(html);
                                    continues = false;
                                } else {
                                    //lastList agora e um grupo anterior
                                    lastGroupASK = lastGroupASK.prev();
                                }
                            } while (continues);

                        } else {
                            $('#' + parent.currentPiece + " > div.tplPlc .elementsPlc").append(html);
                        }

                    }
                    if (this.isset(loaddata)) {
                        //Se foi chamando durante o load do editor
                        //Carregar a variável crossWords, se for o template PLC
                        if (parent.isset(loaddata['crossWord'])) {
                            //Se possui point_crossword, então o template é PLC
                            for (var idx in loaddata['crossWord']) {
                                var currentCrossWord = loaddata['crossWord'][idx];
                                var splitPosition = currentCrossWord['point_crossword'].split('|');
                                var elementIDDBWord2 = splitPosition[0].split("w2eID")[1];

                                var tempJsonArray = {pieceID: "", idDBPieceElementPropertyPointCross: currentCrossWord['idDBPieceElementPropertyPointCross'], idDbPiece: loaddata['pieceID'], word1Group: group, idDbElementWord1: idbd, position1: splitPosition[1]
                                    , word2Group: currentCrossWord['crossword_elementGroup_Word2'], idDbElementWord2: elementIDDBWord2, position2: splitPosition[2], letter: loaddata['text'].substring(splitPosition[1]
                                            , parseInt(splitPosition[1]) + 1)};

                                self.crossWords.push(tempJsonArray);
                            }
                        }
                    }

                } else if (parent.COTemplateTypeIn(parent.DIG)) {
                    if (newDivMatch) {
                        html += '</span></div>';

                        if (self.isset(loaddata)) {
                            var lastGroupASK;
                            //E um ask
                            lastGroupASK = $('#' + parent.currentPiece + " > div.tplDig").find('div[group]:last');
                            var continues = true;
                            do {

                                if (lastGroupASK.size() === 0) {
                                    $('#' + parent.currentPiece + " > div.tplDig > br").after(html);
                                    continues = false;
                                } else if (group > lastGroupASK.attr('group')) {
                                    lastGroupASK.after(html);
                                    continues = false;
                                } else {
                                    //lastList agora e um grupo anterior
                                    lastGroupASK = lastGroupASK.prev();
                                }
                            } while (continues);

                        } else {
                            $('#' + parent.currentPiece + " > div.tplDig .elementsDig").append(html);
                        }

                    }
                }



                var tagAdd = "";
                if (parent.COTemplateTypeIn(parent.MTE)
                        || parent.COTemplateTypeIn(parent.PLC)
                        || parent.COTemplateTypeIn(parent.DIG)
                        || parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                    //TagAdd para o load
                    tagAdd = $('#' + parent.currentPiece + ' div[group=' + group + ']');
                } else if (parent.COTemplateTypeIn(parent.PRE) || parent.COTemplateTypeIn(parent.TXT)) {
                    tagAdd = $('li[id="' + parent.currentPiece + '"] div[group=' + group + ']');  // 
                }

                if (this.isset(loaddata)) {
                    switch (type) {
                        case 'text'://text
                        case 'word'://word
                        case 'paragraph'://paragraph
                        case 'morphem'://morphem
                        case 'number'://number
                            this.addText(tagAdd, loaddata, idbd);
                            break;
                        case 'multimidia'://Library                   
                            switch (loaddata['library']['type']) {
                                case 'image'://image
                                    this.addImage(tagAdd, loaddata, idbd);
                                    break;
                                case 'movie'://movie
                                    this.addVideo(tagAdd, loaddata);
                                    break;
                                case 'sound'://sound
                                    this.addSound(tagAdd, loaddata, idbd);
                                    break;
                            }
                            break;
                        default:
                    }

                    //Se estiver num load de uma template PLC, então Simula o onfocus pra montar o crossword na tela
                    if (parent.COTemplateTypeIn(parent.PLC) && type === 'text') {
                        //Simulação do click e da perda do focus no input text
                        tagAdd.find('.editable').trigger('click');
                        tagAdd.find('.element input').focusout();


                        var hCrossWord = tagAdd.closest('.tpl').find('.crosswords');
                        //Verificar se possui um cruzamento
                        //Se for texto a ser posto no crossword a partir do segundo
                        if (tagAdd.closest('.elementsPlc').find('div[group]').size() > 1) {
                            //Verificar qual a célula de cruzamento
                            var positionCellClick = -1;
                            var groupCellClick = -1;
                            for (var idx in self.crossWords) {
                                var crossWord = self.crossWords[idx];
                                //Como é carregado no BD então existe ID do BD único para cada elemento txt
                                if (crossWord['idDbElementWord1'] == idbd || crossWord['idDbElementWord2'] == idbd) {
                                    //Encontrou
                                    if (crossWord['idDbElementWord1'] === idbd) {
                                        //Então a posição que esse elemento cruza é position1
                                        //Logo a posisão que precisa ser clicada na outra palavra é a position2
                                        positionCellClick = crossWord['position2'];
                                        groupCellClick = crossWord['word2Group'];
                                    } else {
                                        //A posisão que precisa ser clicada na outra palavra é a position1
                                        positionCellClick = crossWord['position1'];
                                        groupCellClick = crossWord['word1Group'];
                                    }
                                    break;
                                }
                            }
                            var cellToClick = hCrossWord.find('.Cell[groups*="g' + groupCellClick + '"]').eq(positionCellClick);
                            //Simular um click na célula passada
                            self.onEditor.eventClickCellPLC(cellToClick, true);

                            console.log(groupCellClick);
                        }


                        //Verifica as letras isShow
                        var posLettersShow = loaddata['showing_letters'].split("|");

                        hCrossWord.find('.Cell[groups*=g' + group + ']').each(function (idx) {
                            if (self.inArray(posLettersShow, idx)) {
                                //A Célular corrente deve ser isShow
                                self.onEditor.eventClickCellPLC(this, true);
                            }
                        });
                        //========================================


                    }


                } else if (parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                    // o group é a Resposta '_'
                    //this.addText(tagAdd);
                }

                //Verificar se foi adicionado 2 elementos no AEL DE UMA ÚNICA VEZ
                if (isAddTwoElementsAel) {
                    var elementID_Resp = elementID;
                    elementID = elementID.split('e')[0] + 'e' + (parseInt(elementID.split('e')[1]) - 1);
                }

                if (parent.COTemplateTypeIn(parent.AEL) || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                    var firstSplitGroup = group.split('_')[0];
                }

                if ((typeof group === 'number' || (typeof group === 'string' && group.split('_').length === 1))
                        ) {
                    //É MTE OU PLC
                    if (parent.COTemplateTypeIn(parent.MTE) || parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG)) {
                        var buttonDelID = "#" + parent.currentPiece + " div[group='" + group + "'] > span > div > button.delElement:eq(0)";
                    }

                } else if (parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)) {
                    var buttonDelID = "#" + parent.currentPiece + " div[group='" + firstSplitGroup + "'] > button.delElement";
                } else if (parent.COTemplateTypeIn(parent.ONEDDROP)) {
                    if (firstSplitGroup === 1) {
                        //O primeiro deve excluir o group ask e answer juntos
                        var buttonDelID = "#" + parent.currentPiece + " div[group='" + firstSplitGroup + "'] > button.delElement";
                    } else {
                        var buttonDelID = "#" + parent.currentPiece + " div[group='" + group + "'] > button.delElement";
                    }

                }
                var buttonTextoID = "#" + elementID + " > div > button.insertText";
                var buttonImageID = "#" + elementID + " > div > button.insertImage";
                var buttonSoundID = "#" + elementID + " > div > button.insertSound";

                var textoID = "#" + elementID + "_text";
                var imageID = "#" + elementID + "_image";
                if (parent.COTemplateTypeIn(parent.MTE)
                        || parent.COTemplateTypeIn(parent.PLC)
                        || parent.COTemplateTypeIn(parent.DIG)
                        || parent.COTemplateTypeIn(parent.AEL)
                        || parent.COTemplateTypeIn(parent.DDROP)
                        || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                    if (parent.COTemplateTypeIn(parent.AEL)
                            || parent.COTemplateTypeIn(parent.DDROP)
                            || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                        var buttonTextoRespID = "#" + elementID_Resp + "> div > button.insertText";
                        var ElementTextRespID = "#" + elementID_Resp + "_text";
                        $(buttonTextoRespID).click(function () {
                            if (!parent.existID(ElementTextRespID)) {
                                parent.addText(elementID_Resp);
                            }
                        });

                    }

                    var ElementTextID = "#" + elementID + "_text";
                    var ElementImageID = "#" + elementID + "_image";
                    var ElementSoundID = "#" + elementID + "_sound";

                    $(buttonTextoID).click(function () {
                        if (!parent.COTemplateTypeIn(parent.AEL)
                                && !parent.COTemplateTypeIn(parent.DDROP)
                                && !parent.COTemplateTypeIn(parent.ONEDDROP)) {
                            if (!parent.existID(ElementImageID) ||
                                    confirm(MSG_CHANGE_ELEMENT)) {
                                if (!parent.existID(ElementTextID)) {
                                    parent.addText(elementID);
                                    $(imageID).remove();
                                }
                            }
                        } else {
                            if (!parent.existID(ElementTextID)) {
                                parent.addText(elementID);
                            }
                        }
                    });


                    if (parent.COTemplateTypeIn(parent.MTE)
                            || parent.COTemplateTypeIn(parent.PLC)
                            || parent.COTemplateTypeIn(parent.DIG)
                            || parent.COTemplateTypeIn(parent.AEL)
                            || parent.COTemplateTypeIn(parent.DDROP)
                            || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                        $(buttonDelID).click(function () {
                            if ($(buttonDelID).size() === 1) {
                                if (parent.COTemplateTypeIn(parent.AEL)
                                        || parent.COTemplateTypeIn(parent.DDROP)
                                        || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                                    parent.delElement($(this).closest('div[group]').closest('li'));
                                } else if (parent.COTemplateTypeIn(parent.MTE) || parent.COTemplateTypeIn(parent.PLC) || parent.COTemplateTypeIn(parent.DIG)) {
                                    parent.delElement($(this).closest('div[group]'));
                                }

                            }

                        });
                    }

                } else if ((parent.COTemplateTypeIn(parent.PRE) || parent.COTemplateTypeIn(parent.TXT))
                        && (!this.isset(loaddata))) {
                    parent.addText(tagAdd);
                }

                $('#' + parent.currentPieceSet).scrollTop($('#' + parent.currentPiece).height());

            },
            this.delScreen = function (force) {
                //pega o id da screen atual
                var id = this.currentScreenId;
                //confirmação do ato de remover
                if (force || confirm(MSG_REMOVE_SCREEN)) {
                    //Guarda o Tipo e ID do elemento
                    var iddb = $("#" + id).attr('idbd');
                    if (this.isset(iddb)) {
                        //Adiciona num Array de objetos deletados em ordem.
                        this.orderDelets.push('S' + iddb);
                    }
                    //remove o elemento
                    $("#" + id).remove();
                    //deleta o count do pieceset
                    delete this.countPieceSet[id];
                    //atualiza o pajinate
                    this.attPajinate();
                }
            },
            this.delPieceSet = function (id, noMessage) {
                if (this.isset(noMessage) && noMessage) {
                    //exlui sem mensagem
                    var iddb = $("#" + id + "_list").attr('idbd');
                    if (this.isset(iddb)) {
                        //Adiciona num Array de objetos deletados em ordem.
                        this.orderDelets.push('PS' + iddb);
                    }
                    $("#" + id + "_list").remove();
                    delete this.countPieces[id];

                }
                else {
                    if (confirm(MSG_REMOVE_PIECESET)) {
                        var iddb = $("#" + id + "_list").attr('idbd');
                        if (this.isset(iddb)) {
                            //Adiciona num Array de objetos deletados em ordem.
                            this.orderDelets.push('PS' + iddb);
                        }
                        $("#" + id + "_list").remove();
                        delete this.countPieces[id];
                    }
                }
            },
            this.delPiece = function (id) {
                if (confirm(MSG_REMOVE_PIECE)) {
                    var iddb = $("#" + id).attr('idbd');
                    if (this.isset(iddb)) {
                        //Adiciona num Array de objetos deletados em ordem.
                        this.orderDelets.push('P' + iddb);
                    }
                    $("#" + id).remove();
                    delete this.countElements[id];
                }
            },
            this.delElement = function (id, isRecursion) {
                var isRecursion = this.isset(isRecursion) && isRecursion;
                var isPiecesetElement = false;
                var isCobjectElement = false;
                var doDel = isRecursion ? true : confirm(MSG_REMOVE_ELEMENT);
                if (typeof id !== 'object') {
                    //Desconsiderar a última parte do último '_' que é o tipo do elemento
                    if (doDel) {
                        var iddb = $("#" + id).attr('idbd');
                        var iddb_Piece = id.split('_');
                        var i;
                        var id_P = '';
                        var id_PS = '';
                        var limitSuper = iddb_Piece.length - 2; // 2=> desconsidera o element e seu tipo

                        //Se for = 0 , então é um elemento do Cobject
                        isCobjectElement = (limitSuper === 0);

                        for (i = 0; i < limitSuper; i++) {
                            //Menos o último
                            if (i === limitSuper - 1) {
                                //É o último
                                id_P += iddb_Piece[i];
                                // Verificar se os 2 primeiros carctesres é 'ps', ou seja, se é um PieceSet
                                isPiecesetElement = (iddb_Piece[i].substring(0, 2) === 'ps');
                            } else {
                                id_P += iddb_Piece[i] + '_';
                            }
                        }



                        if (!isPiecesetElement && !isCobjectElement) {
                            var iddb_P = $('#' + id_P).attr('idbd');
                            if (this.isset(iddb)) {
                                //Adiciona num Array de objetos deletados em ordem.
                                this.orderDelets.push('E' + iddb + 'P' + iddb_P);
                            }
                        } else if (isCobjectElement) {
                            if (this.isset(iddb)) {
                                //Adiciona num Array de objetos deletados em ordem.
                                this.orderDelets.push('E' + iddb + 'CO' + self.CObjectID);
                            }

                        } else {
                            id_PS = id_P;
                            var iddb_PS = $('#' + id_PS + '_list').attr('idbd');
                            if (this.isset(iddb)) {
                                //Adiciona num Array de objetos deletados em ordem.
                                this.orderDelets.push('E' + iddb + 'PS' + iddb_PS);
                            }
                        }


                        this.delObject(id);
                    }
                } else {
                    if (doDel) {
                        var parent = this;
                        //Deleta todo o Grupo de elementos
                        //Deletar todos os objeto, se existir
                        //id é um li que possui o div-grupo
                        if (parent.COTemplateTypeIn(parent.AEL)
                                || parent.COTemplateTypeIn(parent.DDROP)
                                || parent.COTemplateTypeIn(parent.ONEDDROP)) {
                            $(id).find('div[group] div.element').each(function () {
                                var id_Element_del = $(this).attr('id');
                                parent.delElement(id_Element_del, true);
                            });

                            //Por fim Deleta o grupo, a div agora sem elements
                            var group = $(id).find('div[group]').attr('group');
                            var idCurrentPiece = $(id).closest('.piece').attr('id');
                            $(id).remove();

                            //Deleta todo o grupo RESPOSTA de elementos
                            //Deletar todos os objetos do GRUPO RESPOSTA, se existir
                            $('#' + idCurrentPiece + ' div[group=' + group + '_1] div.element').each(function () {
                                var id_ElementResp_del = $(this).attr('id');
                                parent.delElement(id_ElementResp_del, true);
                            });
                            // Deleta também o li do seu Grupo de Resposta
                            $('#' + idCurrentPiece + ' div[group=' + group + '_1]').parent().remove();
                        } else if (parent.COTemplateTypeIn(parent.MTE)
                                || parent.COTemplateTypeIn(parent.PLC)
                                || parent.COTemplateTypeIn(parent.DIG)) {

                            if (parent.COTemplateTypeIn(parent.PLC)) {
                                //Se for PLC, então remove a Palavra cruzada do html e sua associação no Array crossWord
                                self.delWordPLC($(id).closest('div[group]'));
                                //Mostra o botão de exclusão para o último grupo
                                $(id).prev('div[group]').find('.del').show();
                            } else if (parent.COTemplateTypeIn(parent.DIG)) {
//                        var activeGroup = $(".elementsDig div[group]").find("span.active").attr("group");
                                var activeGroup = $(id).children("span[group]").attr("group");
                                var delObject = $(".words-list ul").find("li[group='" + activeGroup + "']");
                                var delWord = delObject.text();
                                var startRow = delObject.attr("start").split("_")[0];
                                var startCol = delObject.attr("start").split("_")[1];
                                var orientation = delObject.attr("start").split("_")[2];
                                var end = delWord.length - 1;
                                var rndChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZVOW";
                                var currentCell;

                                if (orientation === "H") {
                                    end += parseInt(startCol);
                                    for (var i = startCol; i <= end; i++) {
//                                console.log(startCol + "/" + i + "/" + end);
                                        currentCell = $(".wordsearch").find(".Cell[row='" + startRow + "'][col='" + i + "']");
                                        if (currentCell.attr("orientation") == "HV") {
                                            var updatedGroups;
                                            for (var j = 0; j < currentCell.attr("groups").split("g").length; j++) {
                                                if (currentCell.attr("groups").split("g")[j] != activeGroup) {
                                                    updatedGroups = "g" + currentCell.attr("groups").split("g")[j];
                                                }
                                            }
                                            currentCell.attr({groups: updatedGroups, orientation: "V"});
                                        } else {
                                            currentCell.text(rndChar.charAt(Math.floor(Math.random() * rndChar.length))).removeAttr("groups orientation style");
                                        }
                                        delObject.remove();

//                                console.log($(".wordsearch").find(".Cell[row='" + startRow + "'][col='" + i + "']").text());
//                                console.log(startRow + "/" + i);
                                    }
                                }

                                if (orientation === "V") {
                                    end += parseInt(startRow);
                                    for (var i = startRow; i <= end; i++) {
//                                console.log(startRow + "/" + i + "/" + end);
                                        currentCell = $(".wordsearch").find(".Cell[row='" + i + "'][col='" + startCol + "']");
                                        if (currentCell.attr("orientation") == "HV") {
                                            var updatedGroups;
                                            for (var j = 0; j < currentCell.attr("groups").split("g").length; j++) {
                                                if (currentCell.attr("groups").split("g")[j] != activeGroup) {
                                                    updatedGroups = "g" + currentCell.attr("groups").split("g")[j];
                                                }
                                            }
                                            currentCell.attr({groups: updatedGroups, orientation: "H"});
                                        } else {
                                            currentCell.text(rndChar.charAt(Math.floor(Math.random() * rndChar.length))).removeAttr("groups orientation style");
                                        }
                                        delObject.remove();

//                                console.log($(".wordsearch").find(".Cell[row='" + i + "'][col='" + startCol + "']").text());
//                                console.log(i + "/" + startCol);
                                    }
                                }
//                        console.log(activeGroup);
//                        console.log(delWord + "/" + startRow + "/" + startCol + "/" + orientation);
                            }

                            //id é o div-grupo a ser excluído
                            $(id).find('div.element').each(function () {
                                var id_Element_del = $(this).attr('id');
                                parent.delElement(id_Element_del, true);
                            });

                            //Por fim Deleta o grupo, a div agora sem elements
                            var group = $(id).attr('group');
                            $(id).remove();

                        }
                    }
                }

            },
            this.delObject = function (id) {
                var match_div = $('#' + id).attr('match');
                //Verificar se é um elemento da PieceSet
                if ($('span.elementPieceSet > ' + '#' + id).size() === 1) {
                    $('#' + id).closest('span.elementPieceSet').remove();
                } else if ($('span.elementCobject > ' + '#' + id).size() === 1) {
                    $('#' + id).closest('span.elementCobject').remove();
                } else {
                    $("#" + id).remove();
                }

            },
            this.saveData = function (data, sucess, beforeSend) {
                var parent = this;
                $.ajax({
                    type: "POST",
                    url: "/Editor/Json",
                    dataType: 'json',
                    data: data,
                    beforeSend: function (jqXHR, settings) {
                        if (beforeSend) {
                            beforeSend(jqXHR, settings);
                        }
                        else {
                            if (parent.isset(data['step'])) {
                                if (parent.isset(data["justFlag"]) && data["justFlag"] === 1) {
                                    $('.savescreen').append('<br><p>Atualizando a Flag do Element...</p>');
                                } else {
                                    if (!parent.isload) {
                                        $('.savescreen').append('<br><p>Salvando ' + data['step'] + '...</p>');
                                    } else {
                                        $('.savescreen').append('<br><p>Atualizando ' + data['step'] + '...</p>');
                                    }
                                }

                            }
                            else {
                                $('.savescreen').append('<br><p>X Deletando Objetos!...</p>');
                            }

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (parent.isset(data['step'])) {
                            $('.savescreen').append('<br><p>Erro ao salvar ' + data['step'] + '.</p>');
                        } else {
                            $('.savescreen').append('<br><p>Erro ao Deletar TODOS os Objetos!...</p>');
                        }

                        $('.savescreen').append('<br><p>Error mensage:</p>');
                        $('.savescreen').append(jqXHR.responseText);
                    },
                    success: function (response, textStatus, jqXHR) {
                        sucess(response, textStatus, jqXHR);
                    }
                });
            },
//Atualizar o Cobject caso necessário
            this.updateCObject = function () {
                var description = $('#cobject_description > #COdescription');
                if (description.attr('valueDB') !== description.val()) {
                    //Então atualiza a Descrição do Cobject
                    this.saveData({
                        //Operação Salvar
                        op: "update",
                        //Passo CObject
                        step: "CObject",
                        //Dados do CObject
                        CObjectID: self.CObjectID,
                        COdescription: self.isset($('#cobject_description > #COdescription').val()) ?
                                $('#cobject_description > #COdescription').val() : null
                    },
                    //funcção sucess do save Cobject
                    function (response, textStatus, jqXHR) {
                        //atualiza a tela de log
                        $('.savescreen').append('<br><p>Cobject Atualizado com Sucesso!</p>');
                    }
                    );
                }
            },
//Função de salvamento.
//salva utilizando Ajax, parte por parte.
            this.saveAll = function () {
                //referência à classe
                var parent = this;

                //cria tela de log
                $('.theme').append('<div style="overflow:auto; left: 0px; width: 100%;\n\
                             height: 100%; position: fixed; top: 0px; background: none repeat scroll 0px 0px black; \n\
                                opacity: 0.8;" class="savebg"></div>');
                $('.theme').append('<div style="overflow:auto; background: none repeat scroll 0px 0px white; height: 300px; border-radius: 5px 5px 5px 5px; width: 800px; margin-top: 100px; margin-left: 250px; position: fixed; border: 2px solid black; padding: 10px;" class="savescreen">' +
                        '<p>Aguarde um instante...</p>' +
                        '</div>');
                //Salva o CObject
                if (!parent.isload) {
                    this.saveData({
                        //Operação Salvar
                        op: "save",
                        //Passo CObject
                        step: "CObject",
                        //Dados do CObject
                        COtypeID: parent.COtypeID,
                        COthemeID: parent.COthemeID,
                        COtemplateType: parent.COtemplateType,
                        COgoalID: parent.COgoalID,
                        COdescription: parent.isset($('#cobject_description > #COdescription').val()) ?
                                $('#cobject_description > #COdescription').val() : null
                    },
                    //funcção sucess do save Cobject
                    function (response, textStatus, jqXHR) {
                        //atualiza a tela de log
                        $('.savescreen').append('<br><p>CObject salvo com sucesso!</p>');
                        posSaveCobject(response, textStatus, jqXHR);
                    }
                    );
                } else {
                    // Então Existe um this.CObjectID
                    //Verificar se Alterou a descrição do Cobject e salvar, se sim
                    parent.updateCObject();
                    posSaveCobject();
                }
                //======================

                function posSaveCobject(response, textStatus, jqXHR) {
                    if (parent.orderDelets.length > 0) {
                        //Enviar array de objetos a serem excluidos 
                        parent.saveData({
                            op: "delete",
                            array_del: parent.orderDelets
                        },
                        //função sucess do saveData-DelAll
                        function (response, textStatus, jqXHR) {
                            parent.orderDelets = []; // ZERA array de objetos a serem excluidos 
                            $('.savescreen').append('<br><p>X Objetos Deletados!...</p>');
                        });
                    }
                    //==================================

                    //ID no DOM do elemento para o Each
                    var ScreenID;
                    var PieceSetID;
                    var PieceID;
                    var ElementID;

                    //contadores de posição/ordem
                    var screenPosition;
                    var pieceSetPosition;
                    var piecePosition;
                    var elementPosition;

                    //ID do ultimo Salvo no banco
                    var LastScreenID;
                    var LastPieceSetID;
                    var LastPieceID;

                    //ID no DOM do elemento atual
                    //necessário para "sincronizar" o ajax com o javascript
                    var curretScreenID;
                    var curretPieceSetID;
                    var curretPieceID;

                    //Dados em geral dos elementos
                    var pieceSetDescription;
                    var Flag;


                    //Total de elementos e o Total alterados
                    parent.totalElements = $('.element').size();
                    parent.totalElementsChanged = $('.element[updated="1"]').size();
                    parent.totalElementsNOchanged = $('.element[updated="0"]').size();
                    parent.totalPieces = $('.piece').size();
                    parent.totalPiecesets = $('.PieceSet').size();
                    parent.totalScreens = $('.screen').size();


                    //atualiza o ID do CObject, com a resposta do Ajax          
                    if (!parent.isset(parent.CObjectID)) {
                        parent.CObjectID = response['CObjectID'];
                    }
                    //Reinicia o contador da Ordem das Screens
                    screenPosition = 0;

                    //Salvar Elementos do Cobject
                    saveElements(true, false);

                    //===================================================================
                    //Criação da função para salvar os três tipos de elementos: Cobject, PieceSet e os elementos dentro da piece             
                    function saveElements(isElementCobject, isElementPieceSet, LastID, currentID, limit_element) {
                        //Inicializa o contador de posição do elemento
                        elementPosition = 0;
                        var str_seletor = "";

                        if (isElementPieceSet) {
                            //É um elemento da PieceSet
                            LastPieceSetID = LastID;
                            curretPieceSetID = currentID;
                            var idBDLastPieceSet = LastPieceSetID;
                            str_seletor = '#' + curretPieceSetID + ' .elementPieceSet .element';
                        } else if (isElementCobject) {
                            //É um elemento Cobject
                            str_seletor = '.elementCobject .element';
                        } else {
                            // É um elemento da Piece
                            LastPieceID = LastID;
                            curretPieceID = currentID;
                            str_seletor = '#' + curretPieceID + ' .element' + limit_element;
                        }
                        var currentGroup;
                        $(str_seletor).each(function () {
                            //Verificar se é um elemento da PieceSet
                            //var isElementPieceSet = $(this).closest('.elementPieceSet').size() > 0;
                            ElementID = $(this).attr('id');
                            currentGroup = $(this).closest('div[group]').attr('group');
                            ElementID_BD = $(this).attr('idBD');

                            //get Atributo position
                            elementPosition = $(this).attr('position');
                            var continuar = true;
                            //Se for element da peça e TXT acessa todos os elementos para verificar se foram alterados
                            if (parent.COTemplateTypeIn(parent.TXT) && !isElementPieceSet && !isElementCobject) {
                                var text_element = '#' + ElementID;
                                var arrayText = text_element.split('_');
                                text_element = "";
                                for (var i = 0; i < (arrayText.length - 1); i++) {
                                    if (i < (arrayText.length - 2)) {
                                        text_element += arrayText[i] + "_";
                                    } else {
                                        text_element += arrayText[i];
                                    }
                                }
                                var txt_BD = $(text_element + "_flag").val();
                                var txt_New = $("body", $(text_element + "_flag_ifr").contents()).html();
                                var text_div = text_element + '_text';
                                //Verificar se foi Alterado em relação a do DB        
                                parent.textChanged(txt_BD, txt_New, text_element, text_div);
                                //atualiza o total de elementos atualizados e não atualizados
                                parent.totalElementsChanged = $('.element[updated="1"]').size();
                                parent.totalElementsNOchanged = $('.element[updated="0"]').size();

                                var txt_New_noHtml = $("body", $(text_element + "_flag_ifr").contents()).text();
                                //Foi alterado  
                                continuar = (txt_New_noHtml !== "" && txt_BD !== txt_New);
                            }

                            if (continuar) {
                                var newElem = '';
                                var ElementIDSplit = ElementID.split('_');
                                for (var i = 0; i < ElementIDSplit.length - 1; i++) {
                                    if (i === ElementIDSplit.length - 2) {
                                        newElem += ElementIDSplit[i];
                                    } else {
                                        newElem += ElementIDSplit[i] + '_';
                                    }

                                }
                                ElementID = newElem;

                                ElementFlag_Updated = $(this).attr('updated');
                                Flag = $(this).closest('div[group]').find('input[type="checkbox"]').is(':checked');

                                Match = $(this).attr('match');
                                //declaração das variáveis que serão passadas por ajax
                                var type;
                                var value;

                                //IDs dos Formulários, textos, imagens e sons
                                var ElementTextID = "#" + ElementID + "_text";
                                var ElementImageID = "#" + ElementID + "_image";
                                var FormElementImageID = "#" + ElementID + "_image_form";
                                var input_NameDB_ID = "#" + ElementID + "_image_nameDB";
                                var input_NameCurrent_ID = "#" + ElementID + "_image_input";
                                var ElementSoundID = "#" + ElementID + "_sound";
                                var FormElementSoundID = "#" + ElementID + "_sound_form";
                                var inputSound_NameDB_ID = "#" + ElementID + "_sound_nameDB";
                                var inputSound_NameCurrent_ID = "#" + ElementID + "_sound_input";
                                //var ElementRespID = "#"+ElementID+"_resp_text";
                                //Dados que serão passados pelo ajax
                                var data = {
                                    //Operação Salvar, Element, Type, ID no DOM
                                    op: parent.isload ? "update" : "save",
                                    step: "Element",
                                    DomID: ElementID,
                                    //Dados do Element
                                    ordem: elementPosition, //Ordem do Element
                                    flag: Flag,
                                    value: {},
                                    match: Match,
                                    isload: parent.isload,
                                    ID_BD: ElementID_BD,
                                    updated: ElementFlag_Updated
                                };


                                if (isElementPieceSet) {
                                    data["pieceSetID"] = idBDLastPieceSet;
                                } else if (isElementCobject) {
                                    data["cobjectID"] = parent.CObjectID;
                                } else {
                                    data["pieceID"] = LastPieceID;
                                }

                                if (parent.COTemplateTypeIn(parent.TXT) || !(parent.isload && parent.isset(ElementFlag_Updated)
                                        && ElementFlag_Updated === 0)) {
                                    // Precisa Salvar ou Atualizar
                                    //Se for um Texto
                                    if (parent.existID(ElementTextID)) {
                                        //Salva Elemento
                                        data["typeID"] = TYPE.ELEMENT.TEXT;
                                        if (parent.COTemplateTypeIn(parent.TXT)) {

                                            data["value"] = txt_New;

                                        } else {
                                            data["value"] = $(ElementTextID + " > font").html();
                                        }
                                        //Se for Caça-Palavra, armazena a sua dirençao, wordsShowing, e sua posição inicial x,y
                                        if (parent.COTemplateTypeIn(parent.PLC) && !isElementPieceSet && !isElementCobject) {
                                            //Direção
                                            data["direction"] = $(this).closest('div[group]').attr('txtdirection');
                                            //Letras que serão exibidas
                                            var positionLettersShows = "";
                                            $(this).closest('.tplPlc').find('.crosswords')
                                                    .find('.Cell[groups*=g' + currentGroup + ']').each(function (idx) {

                                                if ($(this).attr('isshow') === "true") {
                                                    if (positionLettersShows === "") {
                                                        positionLettersShows += idx;
                                                    } else {
                                                        positionLettersShows += "|" + idx;
                                                    }
                                                }
                                            });
                                            data["showing_letters"] = positionLettersShows;


                                            var thisCrossWord = $(this).closest(".tplPlc").find(".crosswords");
                                            var column = thisCrossWord.find(".Cell[groups*="+currentGroup+"]").first().prevAll().length;
                                            var row = thisCrossWord.find(".Cell[groups*="+currentGroup+"]").first().parent().prevAll().length;
                                            
                                            data["posx"] = column;
                                            data["poxy"] = row;
                                        }
                                        data["temp_currentGroup"] = currentGroup;
                                        parent.saveData(
                                                //Variáveis dados
                                                data,
                                                //Função de sucess do Save Element
                                                        function (response, textStatus, jqXHR) {

                                                            var currentGroup = data["temp_currentGroup"];
                                                            if (!parent.isload) {
                                                                $('.savescreen').append('<br><p>ElementText salvo com sucesso!</p>');
                                                            } else {
                                                                $('.savescreen').append('<br><p>ElementText Atualizado com sucesso!</p>');
                                                            }
                                                            parent.uploadedElements++;
                                                            var saveAllElements = false;
                                                            if (!parent.isload && parent.totalElements === parent.uploadedElements) {
                                                                $('.savescreen').append('<br><br><p>Salvou Todos os Elements!</p>');
                                                                saveAllElements = true;
                                                            } else if (parent.isload && parent.totalElementsChanged === parent.uploadedElements) {
                                                                $('.savescreen').append('<br><br><p>Salvou Todos os Elements!</p>');
                                                                saveAllElements = true;
                                                            }

                                                            if (parent.COTemplateTypeIn(parent.PLC)) {
                                                                //Acrescenta o atributo idDBElement ao Array do CrossWords
                                                                for (var idx in self.crossWords) {
                                                                    var crossword = self.crossWords[idx];

                                                                    if (crossword['pieceID'] === curretPieceID) {
                                                                        if (crossword['word1Group'] === currentGroup ||
                                                                                crossword['word2Group'] === currentGroup) {
                                                                            //Encontrado um cruzamento para esta palavra
                                                                            if (crossword['word1Group'] === currentGroup) {
                                                                                //Zera o word1Group e acrecenta o novo atributo 
                                                                                self.crossWords[idx]['word1Group'] = "";
                                                                                self.crossWords[idx]['idDbElementWord1'] = response['ElementID'];
                                                                            } else {
                                                                                //Zera o word2Group e acrecenta o novo atributo 
                                                                                self.crossWords[idx]['word2Group'] = "";
                                                                                self.crossWords[idx]['idDbElementWord2'] = response['ElementID'];
                                                                            }
                                                                            //Adiciona o novo atributo idDbPiece
                                                                            self.crossWords[idx]['idDbPiece'] = LastPieceID;
                                                                        }
                                                                    }
                                                                }

                                                                if (saveAllElements) {
                                                                    //Se for um novo Cobject
                                                                    if (!parent.isload) {
                                                                        //Então salvar os cruzamentos no BD
                                                                        var dataCrossWords = {'op': 'save', 'step': 'plc', 'crossWords': self.crossWords};
                                                                        parent.saveData(
                                                                                //Variáveis dados
                                                                                dataCrossWords,
                                                                                //Função de sucess do Save crosses
                                                                                        function (response, textStatus, jqXHR) {
                                                                                            $('.savescreen').append('<br><br><p>Salvou Todas as palavras Cruzadas!</p>');
                                                                                            self.crossInfomationSent = true;
                                                                                            //Verificar se acabou as requisições
                                                                                            parent.verify_requestFinish();
                                                                                        });
                                                                            } else {
                                                                        //Se for um Load
                                                                        //Então salvar os cruzamentos no BD, somente se forem novos Cruzamentos
                                                                        var newCrossWords = new Array();
                                                                        for (var idx in self.crossWords) {
                                                                            var crossWord = self.crossWords[idx];
                                                                            if (!parent.isset(crossWord['idDBPieceElementPropertyPointCross'])) {
                                                                                //É um cruzamento Novo. Salva ele
                                                                                newCrossWords.push(crossWord);
                                                                            }
                                                                        }
                                                                        if (newCrossWords.length > 0) {
                                                                            //Salva
                                                                            var dataCrossWords = {'op': 'save', 'step': 'plc', 'crossWords': newCrossWords};
                                                                            parent.saveData(
                                                                                    //Variáveis dados
                                                                                    dataCrossWords,
                                                                                    //Função de sucess do Save crosses
                                                                                            function (response, textStatus, jqXHR) {
                                                                                                $('.savescreen').append('<br><br><p>Salvou Todas as palavras Cruzadas!</p>');
                                                                                                self.crossInfomationSent = true;
                                                                                                //Verificar se acabou as requisições
                                                                                                parent.verify_requestFinish();
                                                                                            });
                                                                                }
                                                                    }
                                                                }
                                                            }
                                                            //Verificar se acabou as requisições
                                                            parent.verify_requestFinish();

                                                        });

                                                    }

                                                    //Se for uma Imagem
                                                    if (parent.existID(ElementImageID)) {

                                                        var doUpload = true;
                                                        if (parent.isload &&
                                                                ($(input_NameDB_ID).val() === $(input_NameCurrent_ID).val()
                                                                        || $(input_NameCurrent_ID).val() === '')
                                                                ) {
                                                            //Não faz upload, pois não houve alterações
                                                            doUpload = false;
                                                        }

                                                        if (doUpload) {
                                                            data["typeID"] = TYPE.ELEMENT.MULTIMIDIA;
                                                            data["library"] = TYPE.LIBRARY.IMAGE;
                                                            //criar a função para envio de formulário via Ajax


                                                            $(FormElementImageID).ajaxForm({
                                                                beforeSend: function () {
                                                                    //zerar barra de upload
                                                                    //$("#"+bar).width('0%')
                                                                    //$("#"+percent).html('0%');
                                                                },
                                                                uploadProgress: function (event, position, total, percentComplete) {
                                                                    //atualizar barra de upload
                                                                    //$("#"+bar).width(percentComplete + '%')
                                                                    //$("#"+percent).html(percentComplete + '%');
                                                                },
                                                                success: function (response) {
                                                                    //dados de retorno do upload
                                                                    data['value'] = {};
                                                                    data['value']['url'] = response['url'];
                                                                    data['value']['name'] = response['name'];
                                                                    data['value']['oldName'] = response['oldName'];
                                                                    data['value']['isNewImg'] = self.isset(response['varMUF']);
                                                                    //Salva Elemento
                                                                    parent.saveData(
                                                                            //Dados
                                                                            data,
                                                                            //Função de sucess do Save Element
                                                                                    function (response, textStatus, jqXHR) {
                                                                                        if (!parent.isload) {
                                                                                            $('.savescreen').append('<br><p>ElementImage salvo com sucesso!</p>');
                                                                                        } else {
                                                                                            $('.savescreen').append('<br><p>ElementImage Atualizado com sucesso!</p>');
                                                                                        }
                                                                                        if (data['value']['isNewImg']) {
                                                                                            //Se for uma nova Imagem, então o upload foi feito
                                                                                            //atualiza o contador de imagens enviadas e coloca o id numa array para ser enviada pelo posRender
                                                                                            parent.uploaded_ImagesIDs[parent.uploadedImages++] = response['LibraryID'];
                                                                                        }
                                                                                        //Atualiza o contador dos Elementos
                                                                                        parent.uploadedElements++;

                                                                                        if (!parent.isload && parent.totalElements === parent.uploadedElements) {
                                                                                            $('.savescreen').append('<br><br><p>Salvou Todos os Elements!</p>');
                                                                                        }
                                                                                        else if (parent.isload && parent.totalElementsChanged === parent.uploadedElements) {
                                                                                            $('.savescreen').append('<br><br><p>Salvou Todos os Elements!</p>');
                                                                                        }
                                                                                        //Verificar se acabou as requisições
                                                                                        parent.verify_requestFinish();

                                                                                    });
                                                                        },
                                                                error: function (error, textStatus, errorThrown) {
                                                                    //$("#"+form).html(error.responseText);
                                                                    alert(ERROR_FILE_UPLOAD);
                                                                    $(".savescreen").append(error.responseText);
                                                                }
                                                            });

                                                            //Envia o formulário atual
                                                            $(FormElementImageID).submit();
                                                        }
                                                    } else if (parent.existID(ElementSoundID)) {
                                                        //Se for um Som  
                                                        var doUpload = true;
                                                        if (parent.isload &&
                                                                ($(inputSound_NameDB_ID).val() === $(inputSound_NameCurrent_ID).val()
                                                                        || $(inputSound_NameCurrent_ID).val() === '')
                                                                ) {
                                                            //Não faz upload, pois não houve alterações
                                                            doUpload = false;
                                                        }

                                                        if (doUpload) {
                                                            data["typeID"] = TYPE.ELEMENT.MULTIMIDIA;
                                                            data["library"] = TYPE.LIBRARY.SOUND;
                                                            //criar a função para envio de formulário via Ajax


                                                            $(FormElementSoundID).ajaxForm({
                                                                beforeSend: function () {
                                                                    //zerar barra de upload
                                                                    //$("#"+bar).width('0%')
                                                                    //$("#"+percent).html('0%');
                                                                },
                                                                uploadProgress: function (event, position, total, percentComplete) {
                                                                    //atualizar barra de upload
                                                                    //$("#"+bar).width(percentComplete + '%')
                                                                    //$("#"+percent).html(percentComplete + '%');
                                                                },
                                                                success: function (response) {
                                                                    //dados de retorno do upload
                                                                    data['value'] = {};
                                                                    data['value']['url'] = response['url'];
                                                                    data['value']['name'] = response['name'];
                                                                    data['value']['oldName'] = response['oldName'];
                                                                    //Salva Elemento
                                                                    parent.saveData(
                                                                            //Dados
                                                                            data,
                                                                            //Função de sucess do Save Element
                                                                                    function (response, textStatus, jqXHR) {
                                                                                        if (!parent.isload) {
                                                                                            $('.savescreen').append('<br><p>ElementSound salvo com sucesso!</p>');
                                                                                        } else {
                                                                                            $('.savescreen').append('<br><p>ElementSound Atualizado com sucesso!</p>');
                                                                                        }

                                                                                        //atualiza o contador de Sons enviados
                                                                                        parent.uploadedSounds++;
                                                                                        //Atualiza o contador dos Elementos
                                                                                        parent.uploadedElements++;
                                                                                        if (!parent.isload && parent.totalElements === parent.uploadedElements) {
                                                                                            $('.savescreen').append('<br><br><p>Salvou Todos os Elements!</p>');
                                                                                        }
                                                                                        else if (parent.isload && parent.totalElementsChanged === parent.uploadedElements) {
                                                                                            $('.savescreen').append('<br><br><p>Salvou Todos os Elements!</p>');
                                                                                        }

                                                                                        parent.verify_requestFinish();
                                                                                    });
                                                                        },
                                                                error: function (error, textStatus, errorThrown) {
                                                                    alert(ERROR_FILE_UPLOAD);
                                                                    $(".savescreen").append(error.responseText);
                                                                }
                                                            });

                                                            //Envia o formulário atual
                                                            $(FormElementSoundID).submit();
                                                        }
                                                    }


                                                } else {
                                                    //Atualiza Somente a Flag

                                                }
                                            } else if (txt_New_noHtml === "") {
                                                // O template é do tipo texto  e o elemento está vazio
                                                //Deleta o PieceSet
                                                parent.delPieceSet(parent.currentPieceSet, true);
                                                //Atualiza Total de elementos e o Total alterados
                                                parent.totalElements = $('.element').size();
                                                parent.totalElementsChanged = $('.element[updated="1"]').size();
                                                parent.totalElementsNOchanged = $('.element[updated="0"]').size();
                                                parent.totalPieces = $('.piece').size();
                                                parent.totalPiecesets = $('.PieceSet').size();

                                                if (parent.isset(ElementID_BD)) {
                                                    //Enviar array de objetos a serem excluidos 
                                                    parent.saveData({
                                                        op: "delete",
                                                        array_del: parent.orderDelets
                                                    },
                                                    //função sucess
                                                    function (response, textStatus, jqXHR) {
                                                        parent.orderDelets = []; // ZERA array de objetos a serem excluidos 
                                                        $('.savescreen').append('<br><p> Objeto TEXT Deletado!...</p>');
                                                        //Verificar se acabou as requisições
                                                        parent.verify_requestFinish();
                                                    });
                                                }

                                            }
                                        }); // End Of EACH ELEMENTS

                                    }

                                    //===================================================================



                                    //Para cada tela
                                    $('.screen').each(function () {
                                        //Atualiza a ScreeID com o ID do ".screen" atual
                                        ScreenID = $(this).attr('id');
                                        ScreenID_BD = $(this).attr('idBD');
                                        //Salva Screen
                                        parent.saveData({
                                            //Operação Salvar, Screen, ID no DOM
                                            op: parent.isload ? "update" : "save",
                                            step: "Screen",
                                            //Necessário para que o JS fique sincronizado com o Ajax
                                            DomID: ScreenID,
                                            //Dados da Screen
                                            CObjectID: parent.CObjectID,
                                            Ordem: ++screenPosition, //incrementa a Ordem da Screen
                                            ID_BD: ScreenID_BD
                                        },
                                        //função sucess do save Screen
                                        function (response, textStatus, jqXHR) {
                                            //Atualiza a tela de log
                                            if (!parent.isload) {
                                                $('.savescreen').append('<br><p>Screen salvo com sucesso!</p>');
                                            } else {
                                                $('.savescreen').append('<br><p>Screen Atualizada com sucesso!</p>');
                                            }
                                            //Contador da quantidade de Screen Salva
                                            parent.uploadedScreens++;
                                            if (parent.totalScreens === parent.uploadedScreens) {
                                                $('.savescreen').append('<br><br><p>Salvou Todas as Screens!</p>');
                                            }
                                            parent.verify_requestFinish();
                                            //Retorna o ID no DOM e o ID da ultima Tela no Banco.
                                            curretScreenID = response['DomID'];
                                            LastScreenID = response['screenID'];

                                            //reinicia o contador de posição dos PieceSet na Screen
                                            pieceSetPosition = 0;

                                            //Para cada PieceSet da Screen
                                            $('#' + curretScreenID + ' .PieceSet').each(function () {
                                                PieceSetID = $(this).attr('id');
                                                PieceSetID_BD = $(this).attr('idBD');
                                                pieceSetDescription = $('#' + PieceSetID + ' .actName').val();
                                                //Salva PieceSet
                                                parent.saveData({
                                                    //Operação Salvar, PieceSet, ID no DOM
                                                    op: parent.isload ? "update" : "save",
                                                    step: "PieceSet",
                                                    DomID: PieceSetID,
                                                    //Dados do PieceSet
                                                    template_id: 7,
                                                    description: pieceSetDescription,
                                                    screenID: LastScreenID,
                                                    order: ++pieceSetPosition, //incrementa a Ordem do PieceSet
                                                    templateID: parent.COtemplateType,
                                                    // isload: parent.isload,
                                                    ID_BD: PieceSetID_BD
                                                },
                                                //Função sucess do save PieceSet
                                                function (response, textStatus, jqXHR) {
                                                    if (!parent.isload) {
                                                        $('.savescreen').append('<br><p>PieceSet salvo com sucesso!</p>');
                                                    } else {
                                                        $('.savescreen').append('<br><p>PieceSet Atualizado com sucesso!</p>');
                                                    }
                                                    //Contador da quantidade de PieceSets Salva
                                                    parent.uploadedPiecesets++;
                                                    if (parent.totalPiecesets === parent.uploadedPiecesets) {
                                                        $('.savescreen').append('<br><br><p>Salvou Todas as PieceSets!</p>');
                                                    }
                                                    parent.verify_requestFinish();

                                                    curretPieceSetID = response['DomID'];
                                                    LastPieceSetID = response['PieceSetID'];
                                                    //Salvar os Elementos da PieceSet
                                                    saveElements(false, true, LastPieceSetID, curretPieceSetID);

                                                    //reiniciar o contador de posição da Piece no PieceSet
                                                    piecePosition = 0;

                                                    //Para cada Piece do PieceSet
                                                    $('#' + curretPieceSetID + ' .piece').each(function () {
                                                        PieceID = $(this).attr('id');
                                                        PieceID_BD = $(this).attr('idBD');
                                                        //Save Piece
                                                        parent.saveData({
                                                            //Operação Salvar, Piece, ID no DOM
                                                            op: parent.isload ? "update" : "save",
                                                            step: "Piece",
                                                            DomID: PieceID,
                                                            //Dados do Piece
                                                            // typeID: 7,
                                                            pieceSetID: LastPieceSetID,
                                                            ordem: ++piecePosition, //incrementa a Ordem do Piece
                                                            screenID: LastScreenID,
                                                            // isload: parent.isload,
                                                            ID_BD: PieceID_BD
                                                        },
                                                        //Função de sucess do Save Piece
                                                        function (response, textStatus, jqXHR) {
                                                            if (!parent.isload) {
                                                                $('.savescreen').append('<br><p>Piece salvo com sucesso!</p>');
                                                            } else {
                                                                $('.savescreen').append('<br><p>Piece Atualizado com sucesso!</p>');
                                                            }
                                                            //Contador da quantidade de Piece Salva
                                                            parent.uploadedPieces++;
                                                            if (parent.totalPieces === parent.uploadedPieces) {
                                                                $('.savescreen').append('<br><br><p>Salvou Todas as Pieces!</p>');
                                                            }

                                                            //                                    window.alert(parent.totalScreens + parent.uploadedScreens
                                                            //                                        +parent.totalPiecesets+ parent.uploadedPiecesets+
                                                            //                                        parent.totalPieces + parent.uploadedPieces
                                                            //                                        +!parent.isload + parent.totalElements + parent.uploadedElements+
                                                            //                                            parent.isload + parent.totalElementsChanged + parent.uploadedElements);   
                                                            //VER : MENSAGEM DE SALVANDO S,P,PS,E desnecessária no load!
                                                            parent.verify_requestFinish();

                                                            curretPieceID = response['DomID'];
                                                            LastPieceID = response['PieceID'];

                                                            //Para cada Elemento no Piece

                                                            // Só Salva ou faz Update dos elementos que foram alimentados
                                                            var limit_element = "";
                                                            if (!parent.COTemplateTypeIn(parent.TXT)) {
                                                                limit_element = '[updated="1"]';
                                                            }


                                                            saveElements(false, false, LastPieceID, curretPieceID, limit_element);

                                                            // REGISTRAR A FLAG DOS ELEMENTS
                                                            if (parent.COTemplateTypeIn(parent.MTE)) {
                                                                $("#" + curretPieceID + ' div[group]').each(function () {
                                                                    //ElementFlag_Updated = $(this).attr('updated');
                                                                    var group = $(this).attr('group');
                                                                    var contElements = $(this).find('div.element[match="' + group + '"][updated="0"]').size();
                                                                    if (contElements > 0) {
                                                                        //Então há elementos e assim atualiza a flag deste(s)
                                                                        Flag = $(this).find('input[type="checkbox"]').is(':checked');
                                                                        $(this).find('div.element[match="' + group + '"][updated="0"]').each(function () {
                                                                            //Se updated = 0, então possui um ID_DB
                                                                            ElementID_BD = parent.isset($(this).attr('idbd')) ? $(this).attr('idbd') :
                                                                                    null;
                                                                            //Dados que serão passados pelo ajax
                                                                            var data = {
                                                                                op: parent.isload ? "update" : "save",
                                                                                step: "Element",
                                                                                pieceID: LastPieceID,
                                                                                flag: Flag,
                                                                                value: {},
                                                                                match: group,
                                                                                isload: parent.isload,
                                                                                ID_BD: ElementID_BD
                                                                            };

                                                                            //Criar ou Atualiza Somente a Flag
                                                                            data["justFlag"] = 1;
                                                                            parent.saveData(
                                                                                    //Variáveis dados
                                                                                    data,
                                                                                    function (response, textStatus, jqXHR) {

                                                                                        $('.savescreen').append('<br><p>Atualizado a Flag do Element!</p>');
                                                                                        parent.uploadedFlags++;

                                                                                        //Verificar se acabou as requisições
                                                                                        parent.verify_requestFinish();

                                                                                    });
                                                                        });

                                                                    }

                                                                });
                                                            }

                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });

                                } // End do PosSaveCobject
                                //======================     
                            }, // End Form SaveAll

//Verificar se acabou as requisições!
                                    this.verify_requestFinish = function () {
                                        var parent = this;
                                        var totalElementsPieceSet = $('span.elementPieceSet > div.element').size();

                                        if ((parent.totalScreens === parent.uploadedScreens) &&
                                                (parent.totalPiecesets === parent.uploadedPiecesets) &&
                                                (parent.totalPieces === parent.uploadedPieces) &&
                                                ((!parent.isload && parent.totalElements === parent.uploadedElements) ||
                                                        (parent.isload && parent.totalElementsChanged === parent.uploadedElements &&
                                                                (!parent.COTemplateTypeIn(parent.MTE) ||
                                                                        ((parent.uploadedFlags + totalElementsPieceSet) === parent.totalElementsNOchanged))))) {

                                            if ((parent.COTemplateTypeIn(parent.PLC) && self.crossInfomationSent) ||
                                                    !parent.COTemplateTypeIn(parent.PLC)) {
                                                //chama o posEditor
                                                $('.savescreen').append('<br><p> FIM! <a href="/editor/index?cID=' + self.CObjectID + '"> Voltar </a> </p>');
                                                parent.posEditor();
                                                //=======================================================
                                            }

                                        }
                                    },
                                    this.posEditor = function () {
                                        //quantidade de elementos.

                                        if (this.uploadedImages > 0) {
                                            var parent = this;
                                            var inputs = "";
                                            //cria os inputs para ser enviados por Post
                                            for (var i in parent.uploaded_ImagesIDs) {
                                                inputs += '<input type="hidden" name="uploaded_ImagesIDs[' + i + ']" value="' + parent.uploaded_ImagesIDs[i] + '">';
                                            }

                                            //cria formulário para enviar o array de library para o poseditor
                                            $('.savescreen').append('<form action="/editor/poseditor" method="post">' + inputs + '<input type="submit" value="PosEditor"></form>');

                                        }

                                    },
                                    this.load = function () {
                                        //define parent como a classe base
                                        var parent = this;
                                        //inicia a requisição de ajax
                                        // $('#loading').html('<img src="/themes/classic/images/loading.gif" id="img_load"/>');
                                        $.ajax({
                                            type: "POST",
                                            url: "/editor/json",
                                            dataType: 'json',
                                            data: {
                                                op: 'load',
                                                cobjectID: parent.CObjectID
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                $('#img_load').remove();
                                                $('html').html(jqXHR.responseText);
                                            },
                                            success: function (response, textStatus, jqXHR) {
                                                //força a deleção da screen inicial
                                                parent.delScreen(true);
                                                parent.isload = true;//Identificar se esta no load.
                                                //para cada item do response
                                                $.each(response, function (i, item) {
                                                    //caso i
                                                    switch (i) {
                                                        //seja o ID do cobject
                                                        case 'cobject_id':
                                                            //altera na classe
                                                            parent.CObjectID = Number(item);
                                                            break;
                                                            //seja o ID do tipo
                                                        case 'typeID':
                                                            //altera na classe
                                                            parent.COtypeID = Number(item);
                                                            break;
                                                            //seja o ID do tema
                                                        case 'themeID':
                                                            //altera na classe
                                                            parent.COthemeID = Number(item);
                                                            break;
                                                            //seja o ID do template
                                                        case 'templateID':
                                                            //altera na classe
                                                            parent.COtemplateType = Number(item);
                                                            break;
                                                        case 'description':
                                                            //altera a descrição do cobject
                                                            parent.COdescription = item;
                                                            $('#cobject_description > #COdescription').attr('valueDB', parent.COdescription);
                                                            $('#cobject_description > #COdescription').val(parent.COdescription);

                                                            if ($('#COdescription').val() === '') {
                                                                //Deixa a mesma mensagem
                                                                $('#COdescription').val('Descrição da Atividade .....');
                                                                $('#COdescription').attr('noString', 'true');
                                                            } else {
                                                                $('#COdescription').attr('noString', 'false');
                                                            }

                                                            break;
                                                            //se não
                                                        default:
                                                            //se for uma screen
                                                            if (i.slice(0, 1) === "S") {
                                                                //pega o id da screen a partir do indice
                                                                var screenID = i.slice(1);
                                                                //adiciona a screen
                                                                parent.addScreen(screenID);

                                                                //para cada item da screen
                                                                $.each(item, function (i, item) {
                                                                    //se for um pieceset
                                                                    if (i.slice(0, 2) === "PS") {
                                                                        //pega o id do pieceset a partir do indice
                                                                        var piecesetID = i.slice(2);
                                                                        //pega a descrição do pieceset a partir do item
                                                                        var desc = item['description'];

                                                                        //pega o tipo do pieceset a partir do item
                                                                        var type = item['template_id'];

                                                                        //adiciona o pieceset
                                                                        parent.addPieceSet(piecesetID, desc, type);

                                                                        //Aplica o texto Padrão no input da descrição do PieceSet

                                                                        if ($('#' + self.currentScreenId + ' .PieceSet[idbd=' + piecesetID + ']').find('.actName').val() === '') {
                                                                            //Deixa a mesma mensagem
                                                                            $('#' + self.currentScreenId + ' .PieceSet[idbd=' + piecesetID + ']').find('.actName').val('Descrição do Cabeçalho .....');
                                                                            $('#' + self.currentScreenId + ' .PieceSet[idbd=' + piecesetID + ']').find('.actName').attr('noString', 'true');
                                                                        } else {
                                                                            $('#' + self.currentScreenId + ' .PieceSet[idbd=' + piecesetID + ']').find('.actName').attr('noString', 'false');
                                                                        }

                                                                        //para cada item do pieceset
                                                                        $.each(item, function (i, item) {
                                                                            //se for um piece
                                                                            if (i.slice(0, 1) === "P") {
                                                                                //pega o id do pieceset a partir do indice
                                                                                var pieceID = i.slice(1);
                                                                                var DOMpiecesetID = $('.piecelist').last().attr('id');
                                                                                //adiciona a piece
                                                                                parent.addPiece(DOMpiecesetID, pieceID);
                                                                                //seleciona o piece adicionado
                                                                                parent.changePiece($('.piece').last());
                                                                                //para cada item da piece
                                                                                $.each(item, function (i, item) {
                                                                                    //se for um elemento
                                                                                    if (i.slice(0, 1) === "E") {
                                                                                        //declara a array de dados das propriedades do elemento
                                                                                        var data = new Array();
                                                                                        data['position'] = item['position'];
                                                                                        data['flag'] = item['flag'];
                                                                                        data['match'] = item['match'];
                                                                                        //preenchimento do array de dados
                                                                                        $.each(item, function (i, item) {
                                                                                            if (i.slice(0, 1) === "L") {
                                                                                                data['library'] = new Array();
                                                                                                data['library']['ID'] = i.slice(1);
                                                                                                data['library']['type'] = item['type_name'];
                                                                                                if (parent.isset(item['width']))
                                                                                                    data['library']['width'] = item['width'];
                                                                                                if (parent.isset(item['height']))
                                                                                                    data['library']['height'] = item['height'];
                                                                                                if (parent.isset(item['src']))
                                                                                                    data['library']['src'] = item['src'];
                                                                                                if (parent.isset(item['extension']))
                                                                                                    data['library']['extension'] = item['extension'];
                                                                                                if (parent.isset(item['nstyle']))
                                                                                                    data['library']['nstyle'] = item['nstyle'];
                                                                                                if (parent.isset(item['content']))
                                                                                                    data['library']['content'] = item['content'];
                                                                                                if (parent.isset(item['color']))
                                                                                                    data['library']['color'] = item['color'];
                                                                                            }

                                                                                        });

                                                                                        //pega o tipo do element
                                                                                        var type = item['type_name'];
                                                                                        //pega o id do element a partir do indice
                                                                                        var elementID = i.slice(1);

                                                                                        if (parent.isset(item['text']))
                                                                                            data['text'] = item['text'];
                                                                                        if (parent.isset(item['language']))
                                                                                            data['language'] = item['language'];
                                                                                        if (parent.isset(item['classification']))
                                                                                            data['classification'] = item['classification'];
                                                                                        //Template Palavra Cruzada
                                                                                        if (parent.isset(item['direction']))
                                                                                            data['direction'] = item['direction'];
                                                                                        if (parent.isset(item['showing_letters']))
                                                                                            data['showing_letters'] = item['showing_letters'];
                                                                                        if (parent.isset(item['crossWord'])) {
                                                                                            //Se existir um cruzamento no templae PLC
                                                                                            data['pieceID'] = pieceID;
                                                                                            var currentCrossWord;
                                                                                            data['crossWord'] = new Array();
                                                                                            for (var idx in item['crossWord']) {
                                                                                                currentCrossWord = item['crossWord'][idx];
                                                                                                data['crossWord'][idx] = new Array();

                                                                                                data['crossWord'][idx]['point_crossword'] = currentCrossWord['point_crossword'];
                                                                                                data['crossWord'][idx]['crossword_elementGroup_Word2'] = currentCrossWord['crossword_elementGroup_Word2'];
                                                                                                data['crossWord'][idx]['idDBPieceElementPropertyPointCross'] = currentCrossWord['idDBPieceElementPropertyPointCross'];
                                                                                            }

                                                                                        }

                                                                                        parent.addElement(elementID, type, data);
                                                                                    }
                                                                                });
                                                                            } else if (i.slice(0, 1) === "E") {
                                                                                //se for um elemento
                                                                                //declara a array de dados das propriedades do elemento
                                                                                var data = new Array();
                                                                                data['position'] = item['position'];
                                                                                //preenchimento do array de dados
                                                                                $.each(item, function (i, item) {
                                                                                    if (i.slice(0, 1) === "L") {
                                                                                        data['library'] = new Array();
                                                                                        data['library']['ID'] = i.slice(1);
                                                                                        data['library']['type'] = item['type_name'];

                                                                                        if (parent.isset(item['src']))
                                                                                            data['library']['src'] = item['src'];
                                                                                        if (parent.isset(item['extension']))
                                                                                            data['library']['extension'] = item['extension'];

                                                                                        if (item['type_name'] === 'image') {
                                                                                            if (parent.isset(item['width']))
                                                                                                data['library']['width'] = item['width'];
                                                                                            if (parent.isset(item['height']))
                                                                                                data['library']['height'] = item['height'];

                                                                                            if (parent.isset(item['nstyle']))
                                                                                                data['library']['nstyle'] = item['nstyle'];
                                                                                            if (parent.isset(item['content']))
                                                                                                data['library']['content'] = item['content'];
                                                                                            if (parent.isset(item['color']))
                                                                                                data['library']['color'] = item['color'];
                                                                                        }

                                                                                    }

                                                                                });
                                                                                if (parent.isset(item['text']))
                                                                                    data['text'] = item['text'];
                                                                                if (parent.isset(item['language']))
                                                                                    data['language'] = item['language'];
                                                                                if (parent.isset(item['classification']))
                                                                                    data['classification'] = item['classification'];
                                                                                //pega o tipo do element
                                                                                var type = item['type_name'];
                                                                                //pega o id do element a partir do indice
                                                                                var elementID = i.slice(1);

                                                                                var idbd = elementID;
                                                                                var loaddata = data;
                                                                                loaddata['piecesetID'] = piecesetID;
                                                                                //var tagAdd = $('#'+piecesetID+"_forms");


                                                                                //Tipo do Elemento
                                                                                switch (type) {
                                                                                    case 'multimidia'://Library       
                                                                                        switch (loaddata['library']['type']) {
                                                                                            case 'image'://image
                                                                                                parent.insertImgPieceSet(null, idbd, loaddata);
                                                                                                break;
                                                                                            case 'movie'://movie
                                                                                                // this.addVideo(tagAdd, loaddata, idbd);
                                                                                                break;
                                                                                            case 'sound'://sound
                                                                                                parent.insertAudioPieceSet(null, idbd, loaddata);
                                                                                                break;
                                                                                        }
                                                                                        break;
                                                                                    default:
                                                                                }
                                                                                //================

                                                                                // parent.addElement(elementID, type, data);
                                                                            }



                                                                            //============
                                                                        });
                                                                    }
                                                                });
                                                            } else if (i.slice(0, 1) === "E") {
                                                                //se for um elemento
                                                                //declara a array de dados das propriedades do elemento
                                                                var data = new Array();
                                                                data['position'] = item['position'];
                                                                //preenchimento do array de dados
                                                                $.each(item, function (i, item) {
                                                                    if (i.slice(0, 1) === "L") {
                                                                        data['library'] = new Array();
                                                                        data['library']['ID'] = i.slice(1);
                                                                        data['library']['type'] = item['type_name'];

                                                                        if (parent.isset(item['src']))
                                                                            data['library']['src'] = item['src'];
                                                                        if (parent.isset(item['extension']))
                                                                            data['library']['extension'] = item['extension'];

                                                                        if (item['type_name'] === 'image') {
                                                                            if (parent.isset(item['width']))
                                                                                data['library']['width'] = item['width'];
                                                                            if (parent.isset(item['height']))
                                                                                data['library']['height'] = item['height'];

                                                                            if (parent.isset(item['nstyle']))
                                                                                data['library']['nstyle'] = item['nstyle'];
                                                                            if (parent.isset(item['content']))
                                                                                data['library']['content'] = item['content'];
                                                                            if (parent.isset(item['color']))
                                                                                data['library']['color'] = item['color'];
                                                                        }

                                                                    }

                                                                });
                                                                if (parent.isset(item['text']))
                                                                    data['text'] = item['text'];
                                                                if (parent.isset(item['language']))
                                                                    data['language'] = item['language'];
                                                                if (parent.isset(item['classification']))
                                                                    data['classification'] = item['classification'];
                                                                //pega o tipo do element
                                                                var type = item['type_name'];
                                                                //pega o id do element a partir do indice
                                                                var elementID = i.slice(1);

                                                                var idbd = elementID;
                                                                var loaddata = data;
                                                                loaddata['cobjectID'] = parent.CObjectID;
                                                                //var tagAdd = $('#'+piecesetID+"_forms");


                                                                //Tipo do Elemento
                                                                switch (type) {
                                                                    case 'multimidia'://Library                   
                                                                        switch (loaddata['library']['type']) {
                                                                            case 'image'://image
                                                                                parent.insertImgCobject(idbd, loaddata);
                                                                                break;
                                                                            case 'movie'://movie
                                                                                // this.addVideo(tagAdd, loaddata, idbd);
                                                                                break;
                                                                            case 'sound'://sound
                                                                                parent.insertSoundCobject(idbd, loaddata);
                                                                                break;
                                                                        }
                                                                        break;
                                                                    default:
                                                                }
                                                                //================

                                                                // parent.addElement(elementID, type, data);
                                                            }

                                                    }
                                                });
                                                $('#img_load').remove();
                                            }
                                        });
                                    },
                                    this.existID = function (id) {
                                        return $(id).size() > 0;
                                    },
                                    this.isset = function (variable) {
                                        return (typeof variable !== 'undefined' && variable !== null);
                                    },
                                    this.imageChanged = function (input_element) {
                                        // Change imagens
                                        var id_div = input_element.attr("id").replace('_input', '');
                                        var id_span = id_div.replace('_image', '');
                                        $('#' + id_div + '.image, #' + id_span).attr('updated', 1);
                                    },
                                    //Criação do inArray no JS
                                    //Se for prototype( Array.prototype. ), então a funcção fica como se fosse a última posição do Array
                                    self.inArray = function (array, value)
                                    {
                                        var i;
                                        for (i = 0; i < array.length; i++)
                                        {
                                            if (array[i].replace(/\s/g, '') != "" && array[i] == value)
                                            {
                                                return true;
                                            }
                                        }
                                        return false;
                                    };


                        }
