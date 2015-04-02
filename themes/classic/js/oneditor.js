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
        $('#COdescription').val('Descrição da Atividade .....');
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
            $('#COdescription').val('Descrição da Atividade .....');
            $('#COdescription').attr('noString', 'true');
            console.log('a');
        } else {
             console.log('B');
            $('#COdescription').attr('noString', 'false');
        }
    });
    //===================================


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
            $(this).val('Descrição do Cabeçalho .....');
            $(this).attr('noString', 'true');
        } else {
            $(this).attr('noString', 'false');
        }
    });

    //===================

    //Combinação de teclas CRTL + T pra abrir nova Screen
    $(document).keydown(function (e) {

    });

    $(document).keyup(function (e) {
        if (e.which == 17) {
            holdingCtrl = false;
        }
    });
    $(document).keydown(function (e) {

        //Se for S
//         if (e.which == 83) {
//            if(holdingCtrl){
//                console.log('s');
//            }
//        }

        //Se for Q
        if (e.which == 81) {
            if (holdingCtrl) {
                newEditor.addScreen();
            }
        }

        //Se for CTRL
        if (e.which == 17) {
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
    //====================

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
        //===================
        if (holdingCtrl) {
            //Com o ctrl Pressionado
            holdingCtrl = false;
        } else {
            //click normal
            newEditor.insertImgCobject(null, null);
        }
        //====================
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


});
