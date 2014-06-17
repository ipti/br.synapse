<!DOCTYPE html>
<head>
    <title>Render</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
        
          $.ajax({
            type: "POST",
            url: "/Render/GetSchool",
            dataType: 'json',
            error: function( jqXHR, textStatus, errorThrown ){
                windows.alert(jqXHR.responseText);
            },
            success: function(response, textStatus, jqXHR){
                var schools = response;
                var htmlSelect = "";
                $.each(schools,function(index, value){
                    htmlSelect+='<option value="'+index+'">'+value+'</option>\n';
                });
                $('#school').html(htmlSelect);
            }
        });
    </script>
</head>

<body id="synapse">
    <form action="exportOffline" method="POST" id="getIDatas" name="getIDatas">
        <select id="school" name="school">
            
        </select>
        <select multiple id="cobject_block" name="cobject_block">
            <option value="1">1</option>
            <option value="1">2</option>
        </select>
        <input type="submit" value="Baixar" >
    </form>
</body>
</html>