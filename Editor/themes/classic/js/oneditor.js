
function onEditor(newEditor) {
    //Add Scripts Just for Editor
//    $.getScript("/../themes/classic/js/jquery/jquery.scrollintoview.js",function(){
//       console.log('Carregou!');
//    });

    self = this;
    holdingCtrl = false;

    $('.canvas').pajinate({
        start_page: 0,
        items_per_page: 1,
        nav_label_first: '<<',
        nav_label_last: '>>',
        nav_label_prev: '<',
        nav_label_next: '>',
        show_first_last: false,
        num_page_links_to_display: 20,
        nav_panel_id: '.navscreen',
        editor: newEditor
    });

    newEditor.countPieceSet['sc0'] = 0;
    newEditor.countPieces['sc0_ps0'] = 0;


    $("#btn-addScreen").click(function () {
        newEditor.addScreen();
    });
    $("#btn-delScreen").click(function (event) {
        newEditor.delScreen(false);
    });

    //Combinação de teclas CRTL + T pra abrir nova Screen
    $(document).keydown(function (e) {

    });

    $(document).keyup(function (e) {
        if (e.which === 17) {
            holdingCtrl = false;
        }
    });
    $(document).keydown(function (e) {

        //ALT   - 18
        //CTRL  - 17
        //SHIFT - 16
        //TAB   - 9
        //LEFT  - 37
        //UP    - 38
        //RIGHT - 39
        //DOWN  - 40

        //Se for LEFT, Volte uma página
        if (e.which === 37) {
            $("#back").trigger("click");
        }

        //Se for RIGHT, avance uma página
        if (e.which === 39) {
            $("#next").trigger("click");
        }

        //Se for CTRL+Q, adicione uma nova tela
        if (e.which === 81) {
            if (holdingCtrl) {
                newEditor.addScreen();
            }
        }

        //Se for CTRL, guarde esta informação
        if (e.which === 17) {
            holdingCtrl = true;
        }


    });

    $(document).on('click', 'div[group] .insertImage', function () {
        if (holdingCtrl) {
            //Com o ctrl Pressionado
            holdingCtrl = false;
        } else {
            //click normal
            //Somente adiciona se não possui outro elemento imagem neste grupo
            if ($(this).closest('div[group]').find('div.image').size() === 0) {
                newEditor.addImage($(this).closest('div[group]'));
            }
        }
    });

    $(document).on('click', ".insertText", function () {
        //Somente adiciona se não possui outro elemento texto neste grupo
        if ($(this).closest('div[group]').find('div.text').size() === 0) {
            newEditor.addText($(this).closest('div[group]'));
        }

    });

    $(document).on('click', ".insertSound", function () { //
        //Somente adiciona se não possui outro elemento imagem neste grupo
        if ($(this).closest('div[group]').find('div.audio').size() === 0) {
            newEditor.addSound($(this).closest('div[group]'));
        }
    });

    $("#addPieceSet").click(function () {
        newEditor.addPieceSet();
    });


    $("#tools > #addimage").click(function () {
        if (holdingCtrl) {
            //Com o ctrl Pressionado
            holdingCtrl = false;
        } else {
            //click normal
            newEditor.insertImgCobject(null, null);
        }
    });

    $("#tools > #addsound").click(function () {
        newEditor.insertSoundCobject(null, null);
    });

    $(document).on("click", ".addPiece", (function () {
        newEditor.addPiece($(this).attr('id'));
    }));
    $(document).on("mousedown", '.piece', function () {
        newEditor.changePiece($(this));
    });
    $('#save').click(function () {
        newEditor.saveAll();
    });

    $('#preview').click(function () {
        window.open('/render/preview/' + newEditor.CObjectID);
    });

    $(document).on("change", '.input_element', function () {
        newEditor.imageChanged($(this));
    });


    $(document).on('click', '.changeOrientation', function () {
        if ($(this).attr('orientation') === "v") {
            $(this).find(".fa").removeClass('fa-arrows-v');
            $(this).find(".fa").addClass('fa-arrows-h');
            $(this).attr('orientation', 'h');
        } else {
            $(this).find(".fa").removeClass('fa-arrows-h');
            $(this).find(".fa").addClass('fa-arrows-v');
            $(this).attr('orientation', 'v');
        }
    });



    $(document).on("click", ".elementsDig div[group]", function () {
        $("span.active").removeClass('active');
        $(this).children("span").addClass('active');
    });

    $(document).on("click", ".elementsPlc div[group]", function () {
        $("span.active").removeClass('active');
        $(this).children("span").addClass('active');
    });


    $(document).on("click", ".wordsearch  div.Cell", function () {
        var currentPiece = $(this).closest('.piece');
        var row = $(this).attr("row");
        var col = $(this).attr("col");
        var word = currentPiece.find("span.active").find('.element font').text();
        var orientation = currentPiece.find("span.active").find('button.changeOrientation').attr('orientation');
        var group = currentPiece.find("span.active").attr("group");
        var wordExists;
        var maxW = 10;
        var maxH = 5;

        if (word !== "Clique para Alterar..." && word !== "Click to edit" &&
                word.replace(/^\s+|\s+$/g, "") !== "UpdateCalcel" &&
                word.replace(/^\s+|\s+$/g, "") !== "" &&
                typeof $(this).attr('selected') === "undefined") {

            if (orientation === "h") {
                if (parseInt(col) + word.length <= maxW) {
                    var currentCell;
                    var checkWord = "";
                    for (var i = 0; i < word.length; i++) {
                        currentCell = $(this).closest(".Row").find(".Cell").eq(parseInt(col) + i);
                        if (currentCell.attr("groups")) {
                            if (currentCell.attr("orientation") === "v") {
                                if (currentCell.text() === word[i]) {
                                    checkWord += word[i];
                                } else {
                                    checkWord += "_";
                                }
                            }
                        } else {
                            checkWord += word[i];
                        }
                    }
                    if (checkWord === word) {
                        wordExists = false;
                        currentPiece.find(".words-list > ul li").each(function () {
                            if ($(this).text().toUpperCase() === word) {
                                wordExists = true;
                                alert("A palavra " + word + " já existe no diagrama!");
                            }
                        });
                        if (!wordExists) {
                            for (var i = 0; i < word.length; i++) {
                                currentCell = $(this).closest(".Row").find(".Cell").eq(parseInt(col) + i);
                                currentCell.text(word[i]).css("font-weight", "bold");
                                if (currentCell.attr("groups")) {
                                    currentCell.attr({groups: currentCell.attr("groups") + "g" + group, orientation: "hv"});
                                } else {
                                    currentCell.attr({groups: "g" + group, orientation: "h"});
                                }
                            }
                            word = word.charAt(0) + word.slice(1).toLowerCase();
                            currentPiece.find(".words-list ul").append('<li group="' + group + '" start="' + row + '_' + col + '_' + orientation + '">' + word + '</li>');
                            currentPiece.find("span.active .text.element").attr("updated", 1);
                        }
                    }
                }
            } else if (orientation === "v") {
                if (parseInt(row) + word.length <= maxH) {
                    var currentCell;
                    var checkWord = "";
                    for (var i = 0; i < word.length; i++) {
                        currentCell = $(this).closest(".Table").find(".Row").eq(parseInt(row) + i).find(".Cell").eq(col);
                        if (currentCell.attr("groups")) {
                            if (currentCell.attr("orientation") === "h") {
                                if (currentCell.text() === word[i]) {
                                    checkWord += word[i];
                                } else {
                                    checkWord += "_";
                                }
                            }
                        } else {
                            checkWord += word[i];
                        }
                    }
                    if (checkWord === word) {
                        wordExists = false;
                        currentPiece.find(".words-list > ul li").each(function () {
                            if ($(this).text().toUpperCase() === word) {
                                wordExists = true;
                                alert("A palavra " + word + " já existe no diagrama!");
                            }
                        });
                        if (!wordExists) {
                            for (var i = 0; i < word.length; i++) {
                                currentCell = $(this).closest(".Table").find(".Row").eq(parseInt(row) + i).find(".Cell").eq(col);
                                currentCell.text(word[i]).css("font-weight", "bold");
                                if (currentCell.attr("groups")) {
                                    currentCell.attr({groups: currentCell.attr("groups") + "g" + group, orientation: "hv"});
                                } else {
                                    currentCell.attr({groups: "g" + group, orientation: "v"});
                                }
                            }
                            word = word.charAt(0) + word.slice(1).toLowerCase();
                            currentPiece.find(".words-list ul").append('<li group="' + group + '" start="' + row + '_' + col + '_' + orientation + '">' + word + '</li>');
                            currentPiece.find("span.active .text.element").attr("updated", 1);

                        }
                    }
                }
            }
        }
    });


    //Template TPLC

    //Função do click na Célula do Template PLC
    this.eventClickCellPLC = function (clickedCell, isload) {
        var comDivCrossWord = $(clickedCell).closest('div.crosswords');
        var positionMergeSelected = null;

        if ($(clickedCell).hasClass('flashing') && !$(clickedCell).hasClass('defaultPositionMerged')) {
            //O 3ª parâmetro é a posição do positionsMayMerge escolhida
            var currentCell = $(clickedCell);
            positionMergeSelected = $(clickedCell).data('posMayMerge');

            clickedCell = $(clickedCell).closest(".crosswords").find('div.defaultPositionMerged');
            var lastGroup = clickedCell.attr('groups').split('g');
            lastGroup = lastGroup[lastGroup.length - 1];
            var elementsPlc = $(clickedCell).closest("div.tplPlc").children("div.elementsPlc");
            elementsPlc.find("div[group=" + lastGroup + "]").attr('lastSelected', 'true');
            //Deleta a última palavra cruzada. E add Novamente com a nova posição positionMergeSelected
            //Se for PLC, então remove a Palavra cruzada do html e sua associação no Array crossWord
            var lastSelected = elementsPlc.find('div[lastSelected]');
            newEditor.delWordPLC(lastSelected);
        }

        if ($(clickedCell).hasClass('defaultPositionMerged')) {
            //Por fim abilita o botão, novo Elemento
            $(clickedCell).closest(".tplPlc").find(".newElement").removeAttr('disabled');
        }

        if ($(clickedCell).hasClass('flashing')) {
            //Remove a class .flashing dos elementos
            var comDivFlashing = comDivCrossWord.find('div.flashing');
            //Para de piscar
            comDivFlashing.css('opacity', '1.0');
            comDivFlashing.removeClass('flashing');
            comDivCrossWord.find('div.defaultPositionMerged').removeClass('defaultPositionMerged');
        }

        var lastSelected = $(clickedCell).closest(".tplPlc").children(".elementsPlc").find("div[group][lastSelected]");
        var groupWordOfClickedLetter = $(clickedCell).attr('groups');
        var thisFunc = this;

        var directionWordOfClickedLetter = $(clickedCell).closest(".tplPlc")
                .find(".elementsPlc div[group='" + groupWordOfClickedLetter.substring(1) + "']").attr('txtDirection');

        if (lastSelected.length !== 0 && groupWordOfClickedLetter.split('g').length <= 2) {
            // Possui somente um groupo, ou seja nunca foi cruzado
            var positionNewWordMerge = -1;
            //Clicou num div Group
            //Percorre o texto dessa Div[LastSelected] e verifica se possue a letra que fora clicada
            var letterClicked = $(clickedCell).text();
            var wordLastClicked = lastSelected.find(".element > font").text().replace(/\s/g, '');

            if (!newEditor.isset(positionMergeSelected)) {
                //Primeiro click para este cruzamento
                var positionsMayMerge = new Array();
                for (var i = 0; i < wordLastClicked.length; i++) {
                    if (wordLastClicked[i] === letterClicked) {
                        positionsMayMerge.push(i);
                    }
                }
            }

            if (newEditor.isset(positionMergeSelected) || (newEditor.isset(positionsMayMerge) && positionsMayMerge.length > 0)) {
                //Encontrou uma letra igual, então faz o match por padrão na primeira encontrada
                //  $(clickedCell).append(wordLastClicked[positionsMayMerge[0]]);
                var posMayMerge;
                if (newEditor.isset(positionMergeSelected)) {
                    //Entao foi escolhido qual das letras iguais cruzará
                    posMayMerge = positionMergeSelected;
                } else {
                    //Primeiro click para este cruzamento
                    posMayMerge = positionsMayMerge[0];
                }
                var letterBeforeMergePosition = "";
                var letterAfterMergePosition = "";
                for (var i = 0; i < wordLastClicked.length; i++) {
                    if (i < posMayMerge) {
                        letterBeforeMergePosition += wordLastClicked[i];
                    } else if (i > posMayMerge) {
                        letterAfterMergePosition += wordLastClicked[i];
                    } else {
                        //É igual - posição do Merge
                        positionNewWordMerge = i;
                    }
                }

                //Aumentar o número de linhas e/ou colunas

                //Quantidades de letras que irá ficar na posição oposta a da letra clicada
                var sizeLetterBeforeMergePosition = letterBeforeMergePosition.length;
                var sizeLetterAfterMergePosition = letterAfterMergePosition.length;
                var cancel = false;

                if (directionWordOfClickedLetter === 'h') {
                    //Antes de Tudo verificar se existe alguma letra no Caminho

                    // Posição da letra clicada   
                    var indexCurrentColl = $(clickedCell).index();
                    var indexCurrentRow = $(clickedCell).closest('.Row').index();

                    //Percorre a lista de letras que será posta Antes
                    var tempIndexCurrentRow = indexCurrentRow;
                    for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                        tempIndexCurrentRow--;
                        var currentCell = $(clickedCell).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                .eq(indexCurrentColl);
                        if (currentCell.size() === 0 || tempIndexCurrentRow < 0 || indexCurrentColl < 0) {
                            //Célula Vazia
                            break;
                        }
                        if (currentCell.text().replace(/\s/g, '') !== '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    //Percorre a lista de letras que será posta Depois
                    var tempIndexCurrentRow = indexCurrentRow;
                    for (var idx in letterAfterMergePosition) {
                        tempIndexCurrentRow++;
                        var currentCell = $(clickedCell).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                .eq(indexCurrentColl);
                        if (currentCell.size() === 0 || tempIndexCurrentRow < 0 || indexCurrentColl < 0) {
                            //Célula Vazia
                            break;
                        }

                        if (currentCell.text().replace(/\s/g, '') !== '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    if (!cancel) {
                        //Quandas linhas antes e depois da linha da letra clicada que já fora criada
                        var currentTotalRowBefore = $(clickedCell).closest('.Row').index();
                        var currentTotalRowAfter = $(clickedCell).closest('.crosswords').find('.Row').last().index() - currentTotalRowBefore;
                        var currentTotalRow = currentTotalRowBefore + 1 + currentTotalRowAfter;
                        var currentTotalCell = $(clickedCell).closest('.Row').find('.Cell').size();
                        //Criar a quantidade Row Antes  igual a diferença

                        if (currentTotalRowBefore < sizeLetterBeforeMergePosition) {
                            var sizeRowAddBefore = sizeLetterBeforeMergePosition - currentTotalRowBefore;
                            currentTotalRow += sizeRowAddBefore;
                            for (var idx = 0; idx < sizeRowAddBefore; idx++) {
                                var str = "<div class='Row'>";
                                for (var idxCell = 0; idxCell < currentTotalCell; idxCell++) {
                                    str += "<div class='Cell'> </div>";
                                }
                                str += '</div>';
                                $(clickedCell).closest('.crosswords').prepend(str);
                            }
                        }

                        //Criar a quantidade Row Depois,  igual a diferença
                        if (currentTotalRowAfter < sizeLetterAfterMergePosition) {
                            var sizeRowAddAfter = sizeLetterAfterMergePosition - currentTotalRowAfter;

                            currentTotalRow += sizeRowAddAfter;
                            for (var idx = 0; idx < sizeRowAddAfter; idx++) {
                                var str = "<div class='Row'>";
                                for (var idxCell = 0; idxCell < currentTotalCell; idxCell++) {
                                    str += "<div class='Cell'> </div>";
                                }
                                str += '</div>';
                                $(clickedCell).closest('.crosswords').append(str);
                            }
                        }

                        //Após adicionar os linhas e colunas restantes
                        // Posição da letra clicada   
                        var indexCurrentColl = $(clickedCell).index();
                        var indexCurrentRow = $(clickedCell).closest('.Row').index();

                        //Percorre a lista de letras que será posta Antes
                        var tempIndexCurrentRow = indexCurrentRow;
                        for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                            tempIndexCurrentRow--;

                            var currentCell = $(clickedCell).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                    .eq(indexCurrentColl);

                            if (typeof currentCell.attr('groups') === 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterBeforeMergePosition[idx]);
                        }

                        //Percorre a lista de letras que será posta Depois
                        var tempIndexCurrentRow = indexCurrentRow;
                        for (var idx in letterAfterMergePosition) {
                            tempIndexCurrentRow++;
                            var currentCell = $(clickedCell).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                    .eq(indexCurrentColl);
                            if (typeof currentCell.attr('groups') === 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterAfterMergePosition[idx]);
                        }
                    }
                } else if (directionWordOfClickedLetter === 'v') {
                    //Antes verificar se existe alguma letra na caminho

                    //Após adicionar as colunas restantes
                    // Posição da letra clicada   
                    var indexCurrentColunm = $(clickedCell).index();
                    //Percorre a lista de letras que será posta Antes
                    var tempIndexCurrentColunm = indexCurrentColunm;
                    for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                        tempIndexCurrentColunm--;
                        // groups='g"+lastSelected.attr('group')+"' directions='v'
                        var currentCell = $(clickedCell).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);
                        if (currentCell.size() === 0 || tempIndexCurrentColunm < 0) {
                            //Célula Vazia
                            break;
                        }
                        if (currentCell.text().replace(/\s/g, '') !== '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    //Percorre a lista de letras que será posta Depois
                    var tempIndexCurrentColunm = indexCurrentColunm;
                    for (var idx in letterAfterMergePosition) {
                        tempIndexCurrentColunm++;
                        var currentCell = $(clickedCell).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);
                        if (currentCell.size() === 0 || tempIndexCurrentColunm < 0) {
                            //Célula Vazia
                            break;
                        }
                        if (currentCell.text().replace(/\s/g, '') !== '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    if (!cancel) {
                        //Então a palavra será adicionada na Horizontal
                        //Quantas Colunas antes e depois da célula da letra clicada que já fora criada
                        var currentTotalColunmBefore = $(clickedCell).index();
                        var currentTotalColunmAfter = $(clickedCell).closest(".Row").find('.Cell').last().index() - currentTotalColunmBefore;
                        var currentTotalColunm = currentTotalColunmBefore + 1 + currentTotalColunmAfter;
                        var currentTotalRow = $(clickedCell).closest('.crosswords').find('.Row').size();
                        var rows = $(clickedCell).closest('.crosswords').find('.Row');
                        //Criar a quantidade Colunm Antes igual a diferença
                        if (currentTotalColunmBefore < sizeLetterBeforeMergePosition) {
                            var sizeColunmAddBefore = sizeLetterBeforeMergePosition - currentTotalColunmBefore;
                            currentTotalColunm += sizeColunmAddBefore;
                            for (var idx = 0; idx < sizeColunmAddBefore; idx++) {
                                for (var idxRow = 0; idxRow < currentTotalRow; idxRow++) {
                                    $(clickedCell).closest('.crosswords').find('.Row').eq(idxRow).prepend("<div class='Cell'> </div>");
                                }
                            }
                        }

                        //Criar a quantidade Colunm Depois,  igual a diferença
                        if (currentTotalColunmAfter < sizeLetterAfterMergePosition) {
                            var sizeColunmAddAfter = sizeLetterAfterMergePosition - currentTotalColunmAfter;

                            currentTotalColunm += sizeColunmAddAfter;
                            for (var idx = 0; idx < sizeColunmAddAfter; idx++) {
                                for (var idxRow = 0; idxRow < currentTotalRow; idxRow++) {
                                    $(clickedCell).closest('.crosswords').find('.Row').eq(idxRow).append("<div class='Cell'> </div>");
                                }
                            }
                        }

                        //Após adicionar as colunas restantes
                        // Posição da letra clicada   
                        var indexCurrentColunm = $(clickedCell).index();

                        //Percorre a lista de letras que será posta Antes
                        var tempIndexCurrentColunm = indexCurrentColunm;
                        for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                            tempIndexCurrentColunm--;
                            // groups='g"+lastSelected.attr('group')+"' directions='v'
                            var currentCell = $(clickedCell).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);

                            if (typeof currentCell.attr('groups') === 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterBeforeMergePosition[idx]);
                        }

                        //Percorre a lista de letras que será posta Depois
                        var tempIndexCurrentColunm = indexCurrentColunm;
                        for (var idx in letterAfterMergePosition) {
                            tempIndexCurrentColunm++;
                            var currentCell = $(clickedCell).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);
                            if (typeof currentCell.attr('groups') === 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterAfterMergePosition[idx]);
                        }


                    }
                }
                if (!cancel) {

                    var currentPieceId = $(clickedCell).closest(".piece").attr("id");
                    var lastClickedGroupElement = lastSelected.attr("group");
                    var groupThisCell = $(clickedCell).attr("groups");

                    //Adiciona o novo grupo ao atributo groups da Célula corrente
                    var newGroup = groupWordOfClickedLetter + 'g' + lastClickedGroupElement;
                    $(clickedCell).attr('groups', newGroup);

                    if (directionWordOfClickedLetter === 'h') {
                        //Célula atual Atualiza o text Direction do grupo de elementos
                        lastSelected.attr('txtDirection', 'v');
                    } else if (directionWordOfClickedLetter === 'v') {
                        //A célula atual estar na Vertical
                        lastSelected.attr('txtDirection', 'h');
                    }
                    //Retira a marcação da última palavra clicada
                    $(clickedCell).closest('.tplPlc').children('.elementsPlc').find('div[group][lastSelected]').removeAttr('lastSelected');

                    //Se for load o crossWord já possui essas informações
                    if (!isload) {
                        //Registrar no Editor qual a peça, element e posicao do texto que será curzado com outro
                        thisFunc.tempPositionThisCellWordMerge = -1;
                        $(clickedCell).attr('currentClickedCell', 'true');

                        $(clickedCell).closest(".crosswords").find("div.Cell[groups*='" + groupThisCell + "']").each(function (index) {
                            if (typeof $(this).attr('currentClickedCell') !== 'undefined') {
                                //Econtrou a célula clicada, atual
                                thisFunc.tempPositionThisCellWordMerge = index;
                                $(clickedCell).removeAttr('currentClickedCell');
                            }
                        });
                        var tempJsonArray;
                        var word1Group = groupThisCell.split('g')[1];
                        if (newEditor.isload) {
                            //Então é um Cobject isload, porém o click vou dado pelo usuário na célula
                            var idDbElementWord1 = $(clickedCell).closest(".tplPlc").find(".elementsPlc").find("div[group=" + word1Group + "]")
                                    .find(".element.text").attr("idbd");
                            tempJsonArray = {pieceID: currentPieceId, word1Group: word1Group, idDbElementWord1: idDbElementWord1,
                                position1: thisFunc.tempPositionThisCellWordMerge,
                                word2Group: lastClickedGroupElement, position2: positionNewWordMerge, letter: $(clickedCell).text()};
                        } else {
                            tempJsonArray = {pieceID: currentPieceId, word1Group: word1Group, position1: thisFunc.tempPositionThisCellWordMerge
                                , word2Group: lastClickedGroupElement, position2: positionNewWordMerge, letter: $(clickedCell).text()};
                        }

                        newEditor.crossWords.push(tempJsonArray);

                        //Deleção do atributo temporário
                        delete thisFunc.tempPositionThisCellWordMerge;
                    }

                    if (!newEditor.isset(positionMergeSelected) && !isload) {
                        //Se NÃO foi um click na .Cell para uma Escolha da posição que será mergeda, se existir(ou seja,
                        // foi o primeiro click pra escolher o cruzamento da palavra corrente)
                        //Deixa piscando as células que podem ser ecolhidas pra o cruzamento
                        if (positionsMayMerge.length > 1) {
                            $(clickedCell).addClass('defaultPositionMerged');
                            var newWordsCells = comDivCrossWord.find('div.Cell[groups*=g' + lastSelected.attr('group') + ']');
                            for (var i in positionsMayMerge) {
                                newWordsCells.eq(positionsMayMerge[i]).addClass('flashing');
                                newWordsCells.eq(positionsMayMerge[i]).data('posMayMerge', positionsMayMerge[i]);
                            }
                        }
                    }
                    if (!newEditor.isset(positionMergeSelected) && !isload) {
                        //Se NÃO foi um click na .Cell para uma Escolha da posição que será mergeda, se existir(ou seja,
                        // foi o primeiro click pra escolher o cruzamento da palavra corrente)
                        if (positionsMayMerge.length <= 1) {
                            //Por fim abilita o botão, novo Elemento
                            $(clickedCell).closest(".tplPlc").find(".newElement").removeAttr('disabled');
                        }
                    } else {
                        //Por fim abilita o botão, novo Elemento
                        $(clickedCell).closest(".tplPlc").find(".newElement").removeAttr('disabled');
                    }

                }
            } else {
                //A letra clicada não foi encontrada na palavra 
            }
        } else {
            //Macar como 'isShow', que indicará a letra que será exibida no Renderizador
            if (!isload) {
                if ($(clickedCell).css('background-color') === 'rgba(0, 0, 0, 0)') {
                    $(clickedCell).attr('isShow', 'true');
                    $(clickedCell).css('background-color', 'yellowgreen');
                } else {
                    $(clickedCell).removeAttr('isShow');
                    $(clickedCell).css('background-color', 'rgba(0, 0, 0, 0)');
                }

                //Alterar o atributo updated dos elementos textos referente a esta célula
                var cellGroups = groupWordOfClickedLetter.split('g');
                for (idx = 1; idx < cellGroups.length; idx++) {
                    var currentGroup = cellGroups[idx];
                    $(clickedCell).closest(".tplPlc")
                            .find(".elementsPlc div[group='" + currentGroup + "']").find(".element.text").attr('updated', '1');
                }
            } else {
                //É load, sempre é clicado para tornar isShow = true
                $(clickedCell).attr('isShow', 'true');
                $(clickedCell).css('background-color', 'yellowgreen');
            }

        }


    };

    $(document).on("click", ".crosswords  div.Cell[groups]", function () {
        self.eventClickCellPLC(this, false);
    });


    $(window).load(function () {
        //Intervalo de flashs no PLC
        setInterval(function () {
            if ($('div.flashing').css('opacity') === '0.5') {
                $('div.flashing').css('opacity', '1');
            } else if ($('div.flashing').css('opacity') === '1') {
                $('div.flashing').css('opacity', '0.5');
            }
        }, 500);

        $(document).on('click', 'div.shapes img:not(.selected)' , function () {
            $(this).addClass('selected');
            $(this).siblings('img').removeClass('selected');
            $(this).closest('div.shapes').data('value', $(this).attr('name'));
            if(newEditor.isload){
                $(this).closest('div.shapes').attr('updated',1);
            }
        });


    });

}