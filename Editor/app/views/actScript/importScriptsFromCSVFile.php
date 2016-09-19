<?php
/**
 * Created by PhpStorm.
 * User: FábioNascimento
 * Date: 22/03/2016
 * Time: 11:26
 */
?>
<head>
    <title>Import Performance</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
    $(document).ready(function() {
        $('#fileCsv').on('change', function() {
            if ($(this).val().split('.')[1] != 'csv') {
                $(this).val("");
                $('#enviar').hide();
                alert('Tipo de Arquivo Incompatível!');
            } else {
                $('#enviar').show();
            }
        });

    });
    </script>
    <style type="text/css">
    #importScript{
    text-align: center;
            margin:100px;
        }
        #lbFileCsv, #FileCsv{
            color: #F0F0F0;
        }

        #enviar{
            width: 100px;
            height: 50px;
            display:none;
        }

        .msg{
    text-align: center;
            margin-top: 20px;
            font-size: 40px;
        }
        #msg_success{
            color: #4dd33a;
        }
        #msg_error{
            color: red;
        }

    </style>
</head>

<body id="synapse">
    <?php
    if (isset($msg)) {
        ?>
        <div class = "msg" id = "msg_<?php echo $msg; ?>">
            <?php
            echo $msg;
            ?>
        </div>
        <?php
    }
    ?>
<div id="importScript">
    <form action="/actScript/importScriptsFromCSVFile" method="POST" id="selectCsv" name="selectCsv" enctype="multipart/form-data">
        <label id="lbFileCsv" for="fileCsv"> Selecione o Arquivo de Exportação </label> <br>
        <input type="file" id="fileCsv" name="fileCsv"  accept=".csv" > <br>
        <input type="submit" id="enviar" value="Enviar" >
    </form>
</div>
</body>
</html>