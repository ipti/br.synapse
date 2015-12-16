<?php
//veriricar Atualização
$commonType = Yii::app()->db->createCommand('SELECT ID, name FROM common_type WHERE context LIKE \'Cobject\' ')->queryAll();
$count_CT = count($commonType);
$cobjectTemplate = Yii::app()->db->createCommand('SELECT ID, name FROM cobject_template GROUP BY code')->queryAll();
$count_Ctemp = count($cobjectTemplate);
$cobjectTheme = Yii::app()->db->createCommand('SELECT ID, name FROM cobject_theme')->queryAll();
$count_Cthem = count($cobjectTheme);
$actDiscipline = Yii::app()->db->createCommand('SELECT ID, name FROM act_discipline')->queryAll();
$count_Adis = count($actDiscipline);
?>
<html>
    <style>
        #propertyForm div {
            height: 25px;
        }
        
        #cobjectIDS div {
            height: 45px;
        }
        
        #propertyForm div label, #cobjectIDS div label{
            float: left;
            height: 25px;
        }

        #propertyForm div select, #cobjectIDS select{
            float: right;
            display: block;
            width: 350px;
        }

        .prerender{
            width:450px;
            height: 300px;
            top: calc(50% - 190px);
            left: calc(50% - 225px);
            position: fixed;

            background: #666666;
            border:1px solid #fff;
            border-radius: 5px;
            box-shadow: 2px 0px 10px #2C2C2C;

            color: white;
            font-weight: bold;

            padding:5px;
        }

        input[type=submit] {
            float: right;
            width: 80px; height: 35px;
        }

        #ajaxGoal{
            height: 50px !important;
        }
        div.error{
            width: calc(100% - 100px);
            height: 29px !important;
            display: inline-block;
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#error').hide();
            filterGoal({idDiscipline: $('#actDiscipline').val(), idDegree: "undefined"});
            function filterGoal(data) {
                $.ajax({
                    type: "POST",
                    url: "/Editor/filtergoal",
                    dataType: 'json',
                    data: data,
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                    },
                    success: function (response, textStatus, jqXHR) {
                        var data = response;

                        if (data['error'] != 'undefined' && data['error'] != null) {
                            $('#error').show();
                        }

                        if (data['degree'] != 'undefined' && data['degree'] != null) {
                            var str = "";
                            $.each(data['degree'], function (idx, degree) {
                                str += '<option value = "' + degree[0]['id'] + '">' + degree[0]['name'] + '</option>';
                                $('#actDegree').html(str);
                            });
                        } else if (data['degree'] == null && data['order'] == 'discipline') {
                            $('#actDegree').html('<option id="0">Nenhum Encontrado</option>');
                        }

                        if (data['cObjects'] != 'undefined' && data['cObjects'] != null) {
                            var str = "";
                            $.each(data['cObjects'], function (idx, cobject) {
                                str += '<option value = "' + cobject['id'] + '">' + cobject['value'] + '</option>';
                                $('#cobjectID').html(str);
                            });
                        } else if (data['cObjects'] == null) {
                            $('#cobjectID').html('<option id="0">Nenhum Encontrado</option>');
                        }

                        if (data['goal'] != 'undefined' && data['goal'] != null) {
                            var str = "";
                            $.each(data['goal'], function (idx, goal) {
                                str += '<option value = "' + goal['id'] + '">' + goal['name'] + '</option>';
                                $('#actGoal').html(str);
                            });
                        } else if (data['goal'] == null && data['order'] != 'goal') {
                            $('#actGoal').html('<option id="0">Nenhum Encontrado</option>');
                        }

                    }
                });
            }

            $('#actDiscipline').change(function () {
                filterGoal({idDiscipline: $('#actDiscipline').val(), idDegree: "undefined", order: "discipline"});
            });

            $(document).on('change', '#actDegree', function () {
                filterGoal({idDiscipline: $('#actDiscipline').val(), idDegree: $('#actDegree').val(), order: "degree"});
            });

            $(document).on('change', '#actGoal', function () {
                filterGoal({goalID: $('#actGoal').val(), order: "goal"});
            });

            $(document).on('change', '#actGoal,#actDegree,#actDiscipline', function () {
                $('#error').hide();
            });


        });
    </script>    
    <body bgcolor='#585858'>
        <div id = 'property' class='prerender'>
            <div id = 'property' class='innerborder'>
                <form name='propertyForm' id='propertyForm' method='POST' action='index'>
                    <div id='propertyCT'> 
                        <label for="commonType">Tipo:</label>
                        <select id='commonType' name='commonType'> 
                            <?php
                            for ($i = 0; $i < $count_CT; $i++) {
                                echo "<option value=" . $commonType[$i]['ID'] . ">" . $commonType[$i]['name'] . "</option>";
                            }
                            ?>
                        </select> 
                    </div>
                    <div id='propertyCTemp'> 
                        <label for="cobjectTemplate">Template:</label>
                        <select id='cobjectTemplate' name='cobjectTemplate'> 
                            <?php
                            for ($i = 0; $i < $count_Ctemp; $i++) {
                                echo "<option value=" . $cobjectTemplate[$i]['ID'] . ">" . $cobjectTemplate[$i]['name'] . "</option>";
                            }
                            ?>
                        </select> 
                    </div>
                    <div id='propertyCthem'> 
                        <label for="cobjectTheme">Tema:</label>
                        <select id='cobjectTheme' name='cobjectTheme'> 
                            <option value =""> SEM TEMA </option> 
                            <?php
                            for ($i = 0; $i < $count_Cthem; $i++) {
                                echo "<option value=" . $cobjectTheme[$i]['ID'] . ">" . $cobjectTheme[$i]['name'] . "</option>";
                            }
                            ?> 
                        </select> 
                    </div>
                    <hr>
                    <div id='propertyAdis'> 
                        <label for="actDiscipline">Disciplina:</label>
                        <select id='actDiscipline' name='actDiscipline'> 
                            <?php
                            for ($i = 0; $i < $count_Adis; $i++) {
                                echo "<option value=" . $actDiscipline[$i]['ID'] . ">" . $actDiscipline[$i]['name'] . "</option>";
                            }
                            ?> 
                        </select> 
                    </div>          
                    <div id='ajaxGoal' name='ajaxGoal'>                  
                        <div id='propertyAdeg' align='left'> 
                            <label for="actDegree">Nível:</label>
                            <select id='actDegree' name='actDegree'></select>
                        </div>
                        <div id='propertyAgoal' class='propertyAgoal' align='center'>
                            <label for="actGoal">Objetivo:</label>
                            <select id='actGoal' name='actGoal'></select> 
                        </div>
                    </div>
                    <div class='error'>
                        <div id='error'>
                            <div class='noGoal'>
                                <font color='lightcoral' size='2'>
                                Não foram encontrados Objetivos<br>
                                para esta Disciplina neste Nível!
                                </font>
                            </div>
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] == 1) {
                                echo "<font size='2' color='red'>Nenhum Objetivo foi Selecionado!</font>";
                            }
                            ?> 
                        </div>
                    </div>
                    <input type='submit' value='Novo' />
                    <br>
                </form>
                <hr>
                <div id='showCobjectIDs'>
                    <form id='cobjectIDS' name='cobjectIDS' method='POST' action='/editor/index/'>
                        <div> 
                            <span id='txtIDsCobject'>Cobjects para Objetivo atual:</span>
                            <select id='cobjectID' name='cobjectID'></select> 
                        </div>
                        <input type='hidden' name='op' value='load'/> 
                        <input id='editCobject' name='editCobject' type='submit' value='Alterar'/>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>