<html>
    <style>

    </style>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#btnFind').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: "/Editor/GetMultimidias",
                    // dataType: 'json',
                    data: {
                        'filter':$('#findByAlias').val()
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                    },
                    success: function(response, textStatus, jqXHR) {
                        console.log(response);
                    }
                });
            });


        });
    </script>    
    <body bgcolor='#585858'>

        <div id="library">
            <div id="search"> 
                <input type="text"  id="findByAlias">
                <input type="button" id="btnFind" name="btnFind" value="Pesquisar" >
            </div>
            <div id="showMultimidias">

            </div>
            <div id="aliasPaginate" > 
                <button id="aliasPrev">  Prev </button>
                <button id="aliasNext">  Next </button>
            </div>

        </div>    

    </body>
</html>