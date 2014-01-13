<html>
<head>
    <title>teste preview </title>
<script type="text/javascript">
        function preview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#id_imagem').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
            
            var height = $('#id_imagem').height();
            var width =  $('#id_imagem').width();
            var size = $('#previewImg')[0].files[0].size;
            var type = $('#previewImg')[0].files[0].type;
            
       }


jQuery('document').ready(function(){

    var input = document.getElementById("imagefile");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData();
    }

    input.addEventListener("change", function (evt) {

        var i = 0, len = this.files.length, img, reader, file;

        for ( ; i < len; i++ ) {
            file = this.files[i];

            //validation to check whether uploaded files are images
            if (!!file.type.match(/image.*/)) {
                if ( window.FileReader ) {
                    reader = new FileReader();
                    reader.onloadend = function (e) { 
                    };
                    reader.readAsDataURL(file);
                }


                if (formdata) {
                    //send the ajax query to upload the file(s)
                    jQuery.ajax({
                        url: "filter.php",
                        type: "POST",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                            jQuery('div#response').html("Successfully uploaded").fadeOut();
                        }
                    });
                }
            }
            else
            {
                alert('Not a vaild image!');
            }   
        }

    }, false);


});



    </script>
    
    </head>
    <body>
    <form id="form1" runat="server">
           <input id ="previewImg" type='file' onchange="preview(this);" />
           <img  id="id_imagem" src="#" alt="imagem" /> 
   
      </form>
       <form enctype="multipart/form-data">
        <input id="imagefile" type="file" name="image" accept="image/*" />
       </form>
    </body>
</html>

