<!DOCTYPE html>
<head>
    <title>Render</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
        $(document).ready(function(){
            //Carragar Escolas
            $.ajax({
                type: "POST",
                url: "/Render/GetSchool",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var schools = response;
                    var htmlSelect = "<option value=''>Selecione uma Escola</option>";
                    $.each(schools,function(index, value){
                        htmlSelect+='<option value="'+index+'">'+value+'</option>\n';
                    });
                    $('#school').html(htmlSelect);
                }
            });
        
            //Carragar Disciplinas
            $.ajax({
                type: "POST",
                url: "/Render/GetDisciplines",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var disciplines = response;
                    var htmlSelect = "<option value=''>Selecione uma Disciplina</option>";
                    $.each(disciplines,function(index, value){
                        htmlSelect+='<option value="'+index+'">'+value+'</option>\n';
                    });
                    $('#discipline').html(htmlSelect);
                }
            });
        
            $('#discipline').on('change',function(){
                //Carregar Cobjects
                $.ajax({
                    type: "POST",
                    url: "/Render/GetCobject_blocks",
                    data :{discipline_id:$(this).val()},
                    dataType: 'json',
                    error: function( jqXHR, textStatus, errorThrown ){
                        window.alert(jqXHR.responseText);
                    },
                    success: function(response, textStatus, jqXHR){
                        var cobjectBlocks = response;
                        var htmlSelect = "";
                        $.each(cobjectBlocks,function(index, value){
                            htmlSelect+='<option value="'+index+'">'+value+'</option>\n';
                        });
                        $('#cobject_block').html(htmlSelect);
                    }
                });
            });
            
        
        });
        
        
        
    </script>
</head>

<body id="synapse">
    <form action="exportToOffline" method="POST" id="getIDatas" name="getIDatas">
        <select id="school" name="school">
        </select>
        <select id="discipline" name="discipline">
        </select>
        <select id="cobject_block" name="cobject_block">
        </select>
        <input type="submit" value="Baixar" >
    </form>
</body>
</html>