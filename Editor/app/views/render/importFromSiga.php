<?php
/**
 * Created by PhpStorm.
 * User: F�bioNascimento
 * Date: 03/05/2016
 * Time: 10:46
 */
?>
<head>
    <title>Import From Siga</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        #import {
            margin-top: 65px;
        }

        .import-button {
            margin: 20px auto;
            display: block;
            width: 200px;
        }

        .import-option {
            display: block;
            margin: 10px auto;
        }

        .msg {
            text-align: center;
            margin-top: 20px;
            font-size: 40px;
        }
    </style>

</head>

<body id="synapse">
<div id="import">
    <form action="/render/importFromSiga" method="POST">
        <select class="import-option" name="option">
            <option value="" label="-"/>
            <option value="school" label="Escola"/>
            <option value="classroom" label="Turma"/>
            <option value="student" label="Aluno"/>
            <option value="enrollment" label="Matrícula"/>
        </select>
        <div>
            <button class="import-button" type="submit">Importar</button>
        </div>
    </form>
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
</div>
</body>
</html>