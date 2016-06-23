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
        
            //Carregar Disciplinas
            $.ajax({
                type: "POST",
                url: "/Render/GetAllBlockDisciplines",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var disciplines = response;
                    var htmlCheckBox = "";
                    var htmlSelectBlocks = "";
                    $.each(disciplines,function(index, value){
                        //Adiciona uma nova Linha à Tabela. Com o checkbox da disciplina e o select dos blocos para esta disciplina
                        //Na mesma linha, porém em colunas diferentes
                        htmlCheckBox ='<input disabled type="checkbox" name="disciplines[]" value="'+index+'">'+value+'</option>\n';
                        htmlSelectBlocks = '<select disabled discipline_id="'+index+'" name="cobject_block[]">' +
                            ' <option>&nbsp;&nbsp;Selecione a Disciplina&nbsp;&nbsp;</option>' +
                            ' </select>';
                        var newRow = $('<div class="Row"> <div class="Col disciplineCol"> </div> <div class="Col blockCol"> </div></div>');
                        newRow.find('div.disciplineCol').html(htmlCheckBox);
                        newRow.find('div.blockCol').html(htmlSelectBlocks);
                        $('#info-block div.Table').append(newRow);
                    });

                }
            });


        
            $(document).on('change', '#info-block input[type="checkbox"]',function(){
                //Carregar os Blocos
                var disciplineSelected = $(this).val();
                if($(this).is(':checked')) {
                    //Está com checked
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
                            $('select[discipline_id="'+disciplineSelected+'"]').html(htmlSelect);
                        }
                    });
                }else{
                    $('select[discipline_id="'+disciplineSelected+'"]').html("<option>&nbsp;&nbsp;Selecione a Disciplina&nbsp;&nbsp;</option>");
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

                //Habilitar os campos para o Modo Avaliação
                $('#info-block').find('input[disabled]').removeAttr('disabled');
                $('#info-block').find('select[disabled]').removeAttr('disabled');
            }else{
                $('#level').html("<option>&nbsp;&nbsp;Selecione a Escola&nbsp;&nbsp;</option>");
                //E dá um 'change' em todos os ckeckbox do Modo Avaliação
                $('#info-block input[type="checkbox"]:checked').trigger('click');
                //Desabilitar os campos para o Modo Avaliação
                $('#info-block').find('input').attr('disabled','disabled');
                $('#info-block').find('select').attr('disabled','disabled');
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
                    <div class="Table"> </div>
                </div>
            </fieldset>
            <fieldset  id="fds-diag">
                <legend> Exportacao para modo Proficiencia/Treino </legend>
                <select id="level" name="level" multiple>
                    <option>&nbsp;&nbsp;Selecione a Escola&nbsp;&nbsp;</option>
                </select>
            </fieldset>
            <input type="submit" value="Baixar" id="btn-download">
        </fieldset>
    </form>
</div>
</body>
</html>