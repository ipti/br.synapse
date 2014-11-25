 <?php       
 //veriricar Atualização
     $commonType =  Yii::app()->db->createCommand('SELECT ID, name FROM common_type WHERE context LIKE \'Cobject\' ')->queryAll(); 
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
            .prerender{border:1px solid #000;width:452px;margin:100px auto;background: #262626;}
            .prerender .innerborder{border:1px solid #4A4A4A;background:#fff;width:450px;}
            .prerender label{display:block;font-size:12px;color:#5E5E5E;margin:5px 0px;}
            .prerender form{display:block;padding:5px;}
            .prerender label{display:block;clear:both;height:20px;}
            .prerender font{float:left;width:400px;height:20px;text-align:left;margin-right:5px; line-height: 20px;}
            #submitButton{ text-align:center;}
            #submitButton input{width: 80px; height: 35px;}
            #cobjectIDS {text-align:center;}
            #cobjectIDS #editCobject{height:35px; margin-top: 8px;}
          </style>
         <script type="text/javascript">
        $(document).ready(function() {
            $('#error').hide();
          // $('#ajaxGoal').load("filtergoal", {idDiscipline: $('#actDiscipline').val(), idDegree:"undefined" } ); 
          filterGoal({idDiscipline: $('#actDiscipline').val(), idDegree:"undefined" });
          function filterGoal(data){
                    $.ajax({
                     type: "POST",
                     url: "/Editor/filtergoal",
                     dataType: 'json',
                     data: data,
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(jqXHR.responseText);
                     },
                     success: function(response, textStatus, jqXHR) {
                         var data = response;
                         
                         if(data['error'] != 'undefined' && data['error'] != null ){
                            $('#error').show();
                         }
                         
                         if(data['degree'] != 'undefined' && data['degree'] != null){
                             var str = "";
                              $.each(data['degree'], function(idx, degree){
                                  str+= '<option value = "'+degree[0]['id']+'">' + degree[0]['name'] + '</option>';
                                $('#actDegree').html(str);
                             });
                         }else if(data['degree'] == null && data['order'] == 'discipline'){
                             $('#actDegree').html('<option id="0">Nenhum Encontrado</option>');
                         }
                         
                         if( data['cObjects'] != 'undefined' && data['cObjects'] != null ){
                             var str = "";
                             $.each(data['cObjects'], function(idx, cobject){
                                  str += '<option value = "'+cobject['id']+'">' + cobject['value'] + '</option>';
                                $('#cobjectID').html(str);
                             });
                         }else if(data['cObjects'] == null){
                             $('#cobjectID').html('<option id="0">Nenhum Encontrado</option>');
                         }
                         
                           if( data['goal'] != 'undefined' && data['goal'] != null ){
                              var str = "";
                                $.each(data['goal'], function(idx, goal){
                                   str += '<option value = "'+goal['id']+'">' + goal['name'] + '</option>';     
                                   $('#actGoal').html(str);
                                });
                         }else if(data['goal'] == null && data['order'] != 'goal'){
                             $('#actGoal').html('<option id="0">Nenhum Encontrado</option>');
                         }
                         
                     }
                 });
             }
             
             $('#actDiscipline').change(function(){
              // $('#ajaxGoal').load("filtergoal", {idDiscipline: $('#actDiscipline').val(), idDegree:"undefined" } ); 
               filterGoal({idDiscipline: $('#actDiscipline').val(), idDegree:"undefined", order:"discipline" });
             }); 
             
               $(document).on('change','#actDegree',function(){
                   // $('#propertyAgoal').load("filtergoal", {idDiscipline: $('#actDiscipline').val(), idDegree: $('#actDegree').val()} ); 
                    filterGoal({idDiscipline: $('#actDiscipline').val(), idDegree: $('#actDegree').val(), order:"degree"});
                 });
                
               $(document).on('change','#actGoal',function(){
                   // $('#showCobjectIDs').load('filtergoal', {goalID: $('#actGoal').val(),isAjax:true} ); 
                   filterGoal({goalID: $('#actGoal').val(), order:"goal"});
                });
                
                $(document).on('change','#actGoal,#actDegree,#actDiscipline',function(){
                    $('#error').hide(1000);
                });
                

        });
         </script>    
         <body bgcolor='#585858'>
             <div id = 'property' class='prerender'>
                 <div id = 'property' class='innerborder'>
                     <form name='propertyForm' id='propertyForm' method='POST' action='index'>
                         <div id='propertyCT'> 
                             Tipo&nbsp;:&nbsp;
                             <select id='commonType' name='commonType'> 
                                 <?php
                                 for ($i = 0; $i < $count_CT; $i++) {
                                     echo "<option value=" . $commonType[$i]['ID'] . ">" . $commonType[$i]['name'] . "</option>";
                                 }
                                 ?>
                             </select> 
                         </div>
                         <div id='propertyCTemp' > 
                             Template&nbsp;:&nbsp;
                             <select id='cobjectTemplate' name='cobjectTemplate'> 
                                 <?php
                                 for ($i = 0; $i < $count_Ctemp; $i++) {
                                     echo "<option value=" . $cobjectTemplate[$i]['ID'] . ">" . $cobjectTemplate[$i]['name'] . "</option>";
                                 }
                                 ?>
                             </select> 
                         </div>
                         <div id='propertyCthem'  > 
                             Tema&nbsp;:&nbsp;
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
                             Disciplina&nbsp;:&nbsp;
                             <select id='actDiscipline' name='actDiscipline'> 
                                 <?php
                                 for ($i = 0; $i < $count_Adis; $i++) {
                                     echo "<option value=" . $actDiscipline[$i]['ID'] . ">" . $actDiscipline[$i]['name'] . "</option>";
                                 }
                                 ?> 
                             </select> 
                         </div>

                         <br>                  
                         <div id='ajaxGoal' name='ajaxGoal'>                  
                             <div id='propertyAdeg' align='left'> 
                                 Nível&nbsp;:&nbsp;
                                 <select id='actDegree' name='actDegree'>

                                 </select>
                             </div>
                             <div id='propertyAgoal' class='propertyAgoal' align='center'>
                                 <br> Objetivo&nbsp;:&nbsp;
                                 <select id='actGoal' name='actGoal' style='width:430px'>

                                 </select> 
                             </div>



                         </div>  
                         <div id='error'>
                             <div class='noGoal'>
                                 <font color='red' size='2'>
                                 Não encontrou algum Objetivo para a disciplina selecionada!
                                 </font>
                             </div>

                             <?php
                             if (isset($_GET['error']) && $_GET['error'] == 1) {
                                 echo "<font size='2' color='red'>Nenhum Objetivo foi Selecionado!</font>";
                             }
                             ?> 
                         </div>
                         <br>
                         <div id='submitButton' align='right'>
                             <input type='submit' value='Start' />
                         </div>

                     </form>
                             <div id='showCobjectIDs' align='left'>
                                 <br><span id='txtIDsCobject'> Lista de Cobjects para Goal Corrente  </span>
                                 <form id='cobjectIDS' name='cobjectIDS' method='POST' action='/editor/index/'>
                                     <select id='cobjectID' name='cobjectID' style='width:430px'>
                                     </select> 
                                     <input type='hidden' name='op' value='load'/> 
                                     <input id='editCobject' name='editCobject' type='submit' value='Change Cobject'/>
                                 </form>

                             </div>
                 </div>
             </div>
         </body>
            </html>