<?php
/**
 * Created by PhpStorm.
 * User: F�bioNascimento
 * Date: 03/05/2016
 * Time: 10:46
 */
?>
<head>
    <title>Import From EducaCenso</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
        $(document).ready(function () {
            $('#fileTxt').on('change', function () {
                if ($(this).val().split('.')[1] != 'txt') {
                    $(this).val("");
                    $('#enviar').hide();
                    alert('Tipo de Arquivo Incompat�vel!');
                } else {
                    $('#enviar').show();
                }
            });

        });
    </script>
    <style type="text/css">
        #import {
            text-align: center;
            margin: 100px;
        }

        #lbFileTxt, #FileTxt {
            color: #F0F0F0;
        }

        #enviar {
            width: 100px;
            height: 50px;
            display: none;
        }

        .msg {
            text-align: center;
            margin-top: 20px;
            font-size: 40px;
        }

        #msg_success {
            color: #4dd33a;
        }

        #msg_error {
            color: red;
        }

    </style>
</head>

<body id="synapse">
<?php
if (isset($msg)) {
    ?>
    <div class="msg" id="msg_<?php echo $msg; ?>">
        <?php
        echo $msg;
        ?>
    </div>
    <?php
}
?>
<div id="import">
    <form action="/render/importFromEduCenso" method="POST" id="selectTxt" name="selectTxt"
          enctype="multipart/form-data">
        <label id="lbFileTxt" for="fileTxt"> Selecione o Arquivo de Importa��o </label> <br>
        <input type="file" id="fileTxt" name="fileTxt" accept="text/plain"> <br>
        <input type="submit" id="enviar" value="Enviar">
    </form>
</div>
</body>
</html>