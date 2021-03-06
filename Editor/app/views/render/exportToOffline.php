<!DOCTYPE html>
<head>
    <title>Render</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="/themes/classic/css/render/exportToOffline.css" media="screen, projection">
    <script type="text/javascript">
        $(document).ready(function(){
            //Carregar Escolas
            $.ajax({
                type: "POST",
                url: "/Render/getAllSchools",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var schools = response;
                    var htmlSelect = "<option value='null'>Selecione uma Escola</option>";
                    $.each(schools,function(index, value){
                        htmlSelect+='<option value="'+index+'">'+value+'</option>\n';
                    });
                    $('#school').html(htmlSelect);
                }
            });
        
            //Carregar Disciplinas dos blocos
            $.ajax({
                type: "POST",
                url: "/Render/GetAllBlockDisciplines",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var disciplines_block = response;
                    var htmlCheckBox = "";
                    var htmlSelectBlocks = "";
                    $.each(disciplines_block,function(index, value){
                        //Adiciona uma nova Linha � Tabela. Com o checkbox da disciplina e o select dos blocos para esta disciplina
                        //Na mesma linha, por�m em colunas diferentes
                        htmlCheckBox ='<input disabled type="checkbox" name="disciplines_block[]" value="'+index+'">'+value+'</option>\n';
                        htmlSelectBlocks = '<select disabled discipline_id="'+index+'" name="cobject_block[]">' +
                            ' <option value="-1">&nbsp;&nbsp;Seleciona o Bloco&nbsp;&nbsp;</option>' +
                            ' </select>';
                        var newRow = $('<div class="Row"> <div class="Col disciplineCol"> </div> <div class="Col blockCol"> </div></div>');
                        newRow.find('div.disciplineCol').html(htmlCheckBox);
                        newRow.find('div.blockCol').html(htmlSelectBlocks);
                        $('#info-block div.Table').append(newRow);
                    });

                }
            });

            //Carregar Todas as Disciplinas
            $.ajax({
                type: "POST",
                url: "/Render/GetDisciplines",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var disciplines = response;
                    var htmlCheckBox = "";
                    var htmlSelectBlocks = "";
                    $.each(disciplines,function(index, value){
                        //Adiciona uma nova Linha � Tabela. Com o checkbox da disciplina
                        htmlCheckBox ='<input disabled type="checkbox" name="disciplines_diag[]" value="'+index+'">'+value+'</option>\n';
                        //Adiciona uma nova linha se o n�mero de colunas na �ltima linha for 4
                        var lastRow = $('#info-diag div.Table div.Row:last');
                        if($('#info-diag div.Table div.Row').size() > 1 && lastRow.find('.Col').size() < 4) {
                            //Add uma nova coluna nessa Linha
                            lastRow.append(' <div class="Col disciplineCol">'+htmlCheckBox+'</div>');
                        }else{
                            //Add uma nova Linha e Coluna
                            var newRow = $('<div class="Row"> <div class="Col disciplineCol"> </div></div>');
                            newRow.find('div.disciplineCol').html(htmlCheckBox);
                            $('#info-diag div.Table').append(newRow);
                        }

                    });

                }
            });

        
            $(document).on('change', '#info-block input[type="checkbox"]',function(){
                //Carregar os Blocos
                var disciplineBlockSelected = $(this).val();
                if($(this).is(':checked')) {
                    //Est� com checked
                    $.ajax({
                        type: "POST",
                        url: "/Render/GetCobject_blocks",
                        data: {discipline_id: $(this).val()},
                        dataType: 'json',
                        error: function (jqXHR, textStatus, errorThrown) {
                            window.alert(jqXHR.responseText);
                        },
                        success: function (response, textStatus, jqXHR) {
                            var cobjectBlocks = response;
                            var htmlSelect = "";
                            $.each(cobjectBlocks, function (index, value) {
                                htmlSelect += '<option value="' + index + '">' + value + '</option>\n';
                            });
                            $('select[discipline_id="'+disciplineBlockSelected+'"]').html(htmlSelect);
                        }
                    });
                    //Habilita a sele��o dos blocos, referente ao checkbox da disciplina clicado
                    $('#info-block').find('select[disabled][discipline_id="'+$(this).val()+'"]').removeAttr('disabled');
                }else{
                    //Desabilita a sele��o dos blocos, referente ao checkbox da disciplina clicado
                    var selectBlockFromDisciplineSelected = $('select[discipline_id="'+disciplineBlockSelected+'"]');
                    selectBlockFromDisciplineSelected.html("<option value='-1'>&nbsp;&nbsp;Seleciona o Bloco&nbsp;&nbsp;</option>");
                    selectBlockFromDisciplineSelected.attr('disabled', 'disabled');
                }

            });

            $('#school').on('change',function(){
            //Carregar os anos existentes para a escola selecionada
            if($(this).val() != 'null') {
                $.ajax({
                    type: "POST",
                    url: "/Render/getLevels",
                    data: {school_id: $('#school').val()},
                    dataType: 'json',
                    error: function (jqXHR, textStatus, errorThrown) {
                        window.alert(jqXHR.responseText);
                    },
                    success: function (response, textStatus, jqXHR) {
                        var stagesInSchool = response;
                        var htmlSelect = "";
                        $.each(stagesInSchool, function (index, value) {
                            htmlSelect += '<option value="' + index + '">' + value + '</option>\n';
                        });
                        $('#level').html(htmlSelect);
                    }
                });
                //Habilitar os campos CheckBoxs para o Modo Avalia��o
                $('#info-block').find('input[disabled]').removeAttr('disabled');

                //Habilitar o campo de sele��o dos Anos para o Modo Profici�ncia/Treino
                $('#info-diag').find('select[disabled]').removeAttr('disabled');
            }else{
                $('#level').html("<option>&nbsp;&nbsp;Selecione a Escola&nbsp;&nbsp;</option>");
                //D� um 'change' em todos os ckeckbox do Modo Avalia��o
                $('#info-block input[type="checkbox"]:checked').trigger('click');
                //Desabilitar os campos para o Modo Avalia��o
                $('#info-block').find('input').attr('disabled','disabled');
                $('#info-block').find('select').attr('disabled','disabled');

                //D� um 'change' em todos os ckeckbox do Modo Profici�ncia/Treino
                $('#info-diag input[type="checkbox"]:checked').trigger('click');
                //Desabilitar os campos para o Modo Profici�ncia/Treino
                $('#info-diag').find('input').attr('disabled','disabled');
                $('#info-diag').find('select').attr('disabled','disabled');
            }

            });

            $(document).on('change','#level',function(){
                if($(this).val().length > 0){
                    //Se algum Ano foi selecionado
                    //Habilita os campos das disciplinas para o Modo Profici�ncia/Treino
                    $('#info-diag').find('input[disabled]').removeAttr('disabled');
                }else{
                    //Desabilita os campos das disciplinas para o Modo Profici�ncia/Treino
                    $('#info-diag').find('input').attr('disabled');
                }
            });

        });
    </script>

</head>

<body id="synapse">
<div id="exportToOffline">
    <form action="exportToOffline" method="POST" id="getIDatas" name="getIDatas">
        <fieldset id="fds-main">
                <legend> Exportacao das Atividades para o Renderizador </legend>
            <select id="school" name="school">
            </select>
            <fieldset  id="fds-block">
                <legend> Exportacao para modo Avaliacao </legend>
                <div id="info-block">
                    <div class="Table"></div>
                </div>
            </fieldset>
            <fieldset  id="fds-diag">
                <legend> Exportacao para modo Proficiencia/Treino </legend>
                <div id="info-diag">
                    <div class="Table"> <div class="Row"><div class="Col">
                        <select id="level" disabled name="level[]" multiple>
                            <option>&nbsp;&nbsp;Selecione o Ano de Ensino&nbsp;&nbsp;</option>
                        </select>
                    </div></div></div>
                </div>

            </fieldset>
            <input type="submit" value="Baixar" id="btn-download">
        </fieldset>
    </form>
</div>
</body>
</html>