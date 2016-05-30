<!DOCTYPE html>
<head>
    <title>Render</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                url: "/Render/GetDisciplines",
                dataType: 'json',
                error: function( jqXHR, textStatus, errorThrown ){
                    window.alert(jqXHR.responseText);
                },
                success: function(response, textStatus, jqXHR){
                    var disciplines = response;
                    var htmlSelect = "<option value='null'>Selecione uma Disciplina</option>";
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
    <style type="text/css">
        #exportToOffline{
            margin-top : 70px;
        }
        #btn-download{
            width:80px;
            height:80px;
        }
    </style>
</head>

<body id="synapse">
<div id="exportToOffline">
    <form action="exportToOffline" method="POST" id="getIDatas" name="getIDatas">
        <select id="school" name="school">
        </select>
        <select id="discipline" name="discipline">
        </select>
        <select id="cobject_block" name="cobject_block">
        </select>
        <input type="submit" value="Baixar" id="btn-download">
    </form>
</div>
</body>
</html>