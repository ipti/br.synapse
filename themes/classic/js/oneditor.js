var newEditor = new editor();
$(function () {
    //Add Scripts Just for Editor
//    $.getScript("/../themes/classic/js/jquery/jquery.scrollintoview.js",function(){
//       console.log('Carregou!');
//    });


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

    // #COdescription
    if ($('#COdescription').val() == '') {
        //Deixa a mesma mensagem
        $('#COdescription').val('Descrição da Atividade...');
        $('#COdescription').attr('noString', 'true');
    } else {
        $('#COdescription').attr('noString', 'false');
    }


    $(document).on('focus', '#COdescription', function () {
        if ($('#COdescription').attr('noString') == 'true') {
            //Limpa o input
            $('#COdescription').val('');
        }
    });

    $(document).on('focusout', '#COdescription', function () {
        if ($('#COdescription').val() == '') {
            //Deixa a mesma mensagem
            $('#COdescription').val('Descrição da Atividade...');
            $('#COdescription').attr('noString', 'true');
        } else {
            $('#COdescription').attr('noString', 'false');
        }
    });


    // .actName 
    // Descrição Padrão do PieceSet
    $(document).on('focus', '.actName', function () {
        if ($(this).attr('noString') == 'true') {
            //Limpa o input
            $(this).val('');
        }
    });

    $(document).on('focusout', '.actName', function () {
        if ($(this).val() == '') {
            //Deixa a mesma mensagem
            $(this).val('Descrição do Cabeçalho...');
            $(this).attr('noString', 'true');
        } else {
            $(this).attr('noString', 'false');
        }
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
        if(e.which === 37){
            $("#back").trigger("click");
        }
        
        //Se for RIGHT, avance uma página
        if(e.which === 39){
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
            if ($(this).closest('div[group]').find('div.image').size() == 0) {
                newEditor.addImage($(this).closest('div[group]'));
            }
        }
    });

    $(document).on('click', ".insertText", function () {
        //Somente adiciona se não possui outro elemento texto neste grupo
        if ($(this).closest('div[group]').find('div.text').size() == 0) {
            newEditor.addText($(this).closest('div[group]'));
        }

    });

    $(document).on('click', ".insertSound", function () { //
        //Somente adiciona se não possui outro elemento imagem neste grupo
        if ($(this).closest('div[group]').find('div.audio').size() == 0) {
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


    $(document).on("change", '.input_element', function () {
        newEditor.imageChanged($(this));
    });


    //Template TPLC

    $(document).on("click", ".elementsPlc div[group]", function () {
        var currentTxtInput = $(this).find('.element font').text().replace( /\s/g, '');
        var str = "";
        if (currentTxtInput != "CliqueparaAlterar..." && currentTxtInput != "Clicktoedit" &&
                currentTxtInput != "UpdateCalcel" &&
                currentTxtInput != "" &&
                typeof $(this).attr('selected') == "undefined") {

            if ($(this).closest(".elementsPlc").siblings(".crosswords").text().replace( /\s/g, '') == '') {
                //Primeira palavra, na horizontal
                $(this).attr('txtDirection', 'h');
                str += "<div class='Row'>";
                for (var i = 0; i < currentTxtInput.length; i++) {
                    str += "<div class='Cell' groups='g" + $(this).attr('group') + "'>" + currentTxtInput[i] + "</div>";
                }
                str += "</div>";

                $(this).closest(".elementsPlc").siblings(".crosswords").html(str);
                //Então add class de Selecionado nesse grupo
                $(this).attr('selected', 'true');

            } else {
                //Já existe uma palavra no CrossWords
                $(this).attr('selected', 'true');
                $(this).siblings('div[lastSelected]').removeAttr('lastSelected');
                $(this).attr('lastSelected', 'true');
            }

        }

    });

    $(document).on("click", ".crosswords  div.Cell[groups]", function () {
        var lastSelected = $(this).closest(".tplPlc").children(".elementsPlc").find("div[group][lastSelected]");
        var groupWordOfClickedLetter = $(this).attr('groups');
        var directionWordOfClickedLetter = $(this).closest(".tplPlc")
                .find(".elementsPlc div[group='" + groupWordOfClickedLetter.substring(1) + "']").attr('txtDirection');

        if (lastSelected.length != 0) {
            var positionNewWordMerge = -1;
            //Clicou num div Group
            //Percorre o texto dessa Div.LastSelected e verifica se possue a letra que fora clicada
            var letterClicked = $(this).text();
            var wordLastClicked = lastSelected.find(".element > font").text().replace(/\s/g, '');
            
            var positionsMayMerge = new Array();
            for (var i = 0; i < wordLastClicked.length; i++) {
                if (wordLastClicked[i] == letterClicked) {
                    positionsMayMerge.push(i);
                }
            }

            if (positionsMayMerge.length > 0) {
                //Encontrou uma letra igual, então faz o match por padrão na primeira encontrada
                //  $(this).append(wordLastClicked[positionsMayMerge[0]]);

                var letterBeforeMergePosition = "";
                var letterAfterMergePosition = "";
                for (var i = 0; i < wordLastClicked.length; i++) {
                    if (i < positionsMayMerge[0]) {
                        letterBeforeMergePosition += wordLastClicked[i];
                    } else if (i > positionsMayMerge[0]) {
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

                if (directionWordOfClickedLetter == 'h') {
                    //Antes de Tudo verificar se existe alguma letra no Caminho

                    // Posição da letra clicada   
                    var indexCurrentColl = $(this).index();
                    var indexCurrentRow = $(this).closest('.Row').index();

                    //Percorre a lista de letras que será posta Antes
                    var tempIndexCurrentRow = indexCurrentRow;
                    for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                        tempIndexCurrentRow--;
                        var currentCell = $(this).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                .eq(indexCurrentColl);
                       if(currentCell.size() == 0 || tempIndexCurrentRow < 0 || indexCurrentColl < 0){
                            //Célula Vazia
                            break;
                        }
                        if (currentCell.text().replace(/\s/g, '') != '') {
                            //Existe Letra no caminho
                            console.log(currentCell.text().replace(/\s/g, ''));
                            cancel = true;
                            break;
                        }
                    }

                    //Percorre a lista de letras que será posta Depois
                    var tempIndexCurrentRow = indexCurrentRow;
                    for (var idx in letterAfterMergePosition) {
                        tempIndexCurrentRow++;
                        var currentCell = $(this).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                .eq(indexCurrentColl);
                         if(currentCell.size() == 0 || tempIndexCurrentRow < 0 || indexCurrentColl < 0){
                            //Célula Vazia
                            break;
                        }
                        
                        if (currentCell.text().replace(/\s/g, '') != '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    if (!cancel) {
                        //Quandas linhas antes e depois da linha da letra clicada que já fora criada
                        var currentTotalRowBefore = $(this).closest('.Row').index();
                        var currentTotalRowAfter = $(this).closest('.crosswords').find('.Row').last().index() - currentTotalRowBefore;
                        var currentTotalRow = currentTotalRowBefore + 1 + currentTotalRowAfter;
                        var currentTotalCell = $(this).closest('.Row').find('.Cell').size();
                        //Criar a quantidade Row Antes  igual a diferença

                        if (currentTotalRowBefore < sizeLetterBeforeMergePosition) {
                            var sizeRowAddBefore = sizeLetterBeforeMergePosition - currentTotalRowBefore;
                            currentTotalRow += sizeRowAddBefore;
                            for (var idx = 0; idx < sizeRowAddBefore; idx++) {
                                var str = "<div class='Row'>"
                                for (var idxCell = 0; idxCell < currentTotalCell; idxCell++) {
                                    str += "<div class='Cell'> </div>";
                                }
                                str += '</div>';
                                $(this).closest('.crosswords').prepend(str);
                            }
                        }

                        //Criar a quantidade Row Depois,  igual a diferença
                        if (currentTotalRowAfter < sizeLetterAfterMergePosition) {
                            var sizeRowAddAfter = sizeLetterAfterMergePosition - currentTotalRowAfter;

                            currentTotalRow += sizeRowAddAfter;
                            for (var idx = 0; idx < sizeRowAddAfter; idx++) {
                                var str = "<div class='Row'>"
                                for (var idxCell = 0; idxCell < currentTotalCell; idxCell++) {
                                    str += "<div class='Cell'> </div>";
                                }
                                str += '</div>';
                                $(this).closest('.crosswords').append(str);
                            }
                        }

                        //Após adicionar os linhas e colunas restantes
                        // Posição da letra clicada   
                        var indexCurrentColl = $(this).index();
                        var indexCurrentRow = $(this).closest('.Row').index();

                        //Percorre a lista de letras que será posta Antes
                        var tempIndexCurrentRow = indexCurrentRow;
                        for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                            tempIndexCurrentRow--;

                            var currentCell = $(this).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                    .eq(indexCurrentColl);

                            if (typeof currentCell.attr('groups') == 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterBeforeMergePosition[idx]);
                        }

                        //Percorre a lista de letras que será posta Depois
                        var tempIndexCurrentRow = indexCurrentRow;
                        for (var idx in letterAfterMergePosition) {
                            tempIndexCurrentRow++;
                            var currentCell = $(this).closest('.crosswords').find('.Row').eq(tempIndexCurrentRow).find('.Cell')
                                    .eq(indexCurrentColl);
                            if (typeof currentCell.attr('groups') == 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterAfterMergePosition[idx]);
                        }
                    }
                } else if (directionWordOfClickedLetter == 'v') {
                    //Antes verificar se existe alguma letra na caminho

                    //Após adicionar as colunas restantes
                    // Posição da letra clicada   
                    var indexCurrentColunm = $(this).index();
                    //Percorre a lista de letras que será posta Antes
                    var tempIndexCurrentColunm = indexCurrentColunm;
                    for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                        tempIndexCurrentColunm--;
                        // groups='g"+lastSelected.attr('group')+"' directions='v'
                        var currentCell = $(this).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);
                      if(currentCell.size() == 0 || tempIndexCurrentColunm < 0){
                            //Célula Vazia
                            break;
                        }
                        if (currentCell.text().replace(/\s/g, '') != '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    //Percorre a lista de letras que será posta Depois
                    var tempIndexCurrentColunm = indexCurrentColunm;
                    for (var idx in letterAfterMergePosition) {
                        tempIndexCurrentColunm++;
                        var currentCell = $(this).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);
                         if(currentCell.size() == 0 || tempIndexCurrentColunm < 0){
                            //Célula Vazia
                            break;
                        }
                        if (currentCell.text().replace(/\s/g, '') != '') {
                            //Existe Letra no caminho
                            cancel = true;
                            break;
                        }
                    }

                    if (!cancel) {
                        //Então a palavra será adicionada na Horizontal
                        //Quantas Colunas antes e depois da célula da letra clicada que já fora criada
                        var currentTotalColunmBefore = $(this).index();
                        var currentTotalColunmAfter = $(this).closest(".Row").find('.Cell').last().index() - currentTotalColunmBefore;
                        var currentTotalColunm = currentTotalColunmBefore + 1 + currentTotalColunmAfter;
                        var currentTotalRow = $(this).closest('.crosswords').find('.Row').size();
                        var rows = $(this).closest('.crosswords').find('.Row');
                        //Criar a quantidade Colunm Antes igual a diferença
                        if (currentTotalColunmBefore < sizeLetterBeforeMergePosition) {
                            var sizeColunmAddBefore = sizeLetterBeforeMergePosition - currentTotalColunmBefore;
                            currentTotalColunm += sizeColunmAddBefore;
                            for (var idx = 0; idx < sizeColunmAddBefore; idx++) {
                                for (var idxRow = 0; idxRow < currentTotalRow; idxRow++) {
                                    $(this).closest('.crosswords').find('.Row').eq(idxRow).prepend("<div class='Cell'> </div>");
                                }
                            }
                        }

                        //Criar a quantidade Colunm Depois,  igual a diferença
                        if (currentTotalColunmAfter < sizeLetterAfterMergePosition) {
                            var sizeColunmAddAfter = sizeLetterAfterMergePosition - currentTotalColunmAfter;

                            currentTotalColunm += sizeColunmAddAfter;
                            for (var idx = 0; idx < sizeColunmAddAfter; idx++) {
                                for (var idxRow = 0; idxRow < currentTotalRow; idxRow++) {
                                    $(this).closest('.crosswords').find('.Row').eq(idxRow).append("<div class='Cell'> </div>");
                                }
                            }
                        }

                        //Após adicionar as colunas restantes
                        // Posição da letra clicada   
                        var indexCurrentColunm = $(this).index();

                        //Percorre a lista de letras que será posta Antes
                        var tempIndexCurrentColunm = indexCurrentColunm;
                        for (var idx = sizeLetterBeforeMergePosition - 1; idx >= 0; idx--) {
                            tempIndexCurrentColunm--;
                            // groups='g"+lastSelected.attr('group')+"' directions='v'
                            var currentCell = $(this).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);

                            if (typeof currentCell.attr('groups') == 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterBeforeMergePosition[idx]);
                        }

                        //Percorre a lista de letras que será posta Depois
                        var tempIndexCurrentColunm = indexCurrentColunm;
                        for (var idx in letterAfterMergePosition) {
                            tempIndexCurrentColunm++;
                            var currentCell = $(this).closest('.Row').find('.Cell').eq(tempIndexCurrentColunm);
                            if (typeof currentCell.attr('groups') == 'undefined') {
                                //cria os novos atributos
                                currentCell.attr('groups', 'g' + lastSelected.attr('group'));
                            }
                            currentCell.html(letterAfterMergePosition[idx]);
                        }


                    }
                }
                if (!cancel) {
                    if (directionWordOfClickedLetter == 'h') {
                        //Célula atual Atualiza o text Direction do grupo de elementos
                        lastSelected.attr('txtDirection', 'v');
                    } else if (directionWordOfClickedLetter == 'v') {
                        //A célula atual estar na Vertical
                        lastSelected.attr('txtDirection', 'h');
                    }
                    //Retira a marcação da última palavra clicada
                    $(this).closest('.tplPlc').children('.elementsPlc').find('div[group][lastSelected]').removeAttr('lastSelected');

                    //Registrar no Editor qual a peça, element e posicao do texto que será curzado com outro
                    var currentPieceId = $(this).closest(".piece").attr("id");
                    var lastClickedGroupElement = lastSelected.attr("group");
                    var groupThisCell = $(this).attr("groups");
                    var positionThisCellWordMerge = -1;
                    $(this).attr('currentClickedCell', 'true');

                    $(this).closest(".crosswords").find("div.Cell[groups='" + groupThisCell + "']").each(function (index) {
                        if (typeof $(this).attr('currentClickedCell') != 'undefined') {
                            //Econtrou a célula clicada, atual
                            positionThisCellWordMerge = index;
                        }
                    });

                    var tempJsonArray = {pieceID: currentPieceId, word1Group: groupThisCell, position1: positionThisCellWordMerge
                        , word2Group: lastClickedGroupElement, position2: positionNewWordMerge};
                    newEditor.crossWords.push(tempJsonArray);
                }
            } else {
                //A letra clicada não foi encontrada na palavra 
            }
        } else {
            //Macar como 'isShow', que indicará a letra que será exibida no Renderizador

        }

    });


});
