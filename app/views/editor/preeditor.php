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
         </style>
         <script type="text/javascript">
        $(document).ready(function() {
             $('#ajaxGoal').load("filtergoal", {idDiscipline: $('#actDiscipline').val(), idDegree:"undefined" } ); 
             $('#actDiscipline').change(function(){
               $('#ajaxGoal').load("filtergoal", {idDiscipline: $('#actDiscipline').val(), idDegree:"undefined" } ); 
             }); 
             
               $(document).on('change','#actDegree',function(){
                    $('#propertyAgoal').load("filtergoal", {idDiscipline: $('#actDiscipline').val(), idDegree: $('#actDegree').val()} ); 
                });
               $(document).on('change','#actGoal',function(){
                    $('#showCobjectIDs').load('filtergoal', {goalID: $('#actGoal').val(),isAjax:true} );    
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
            echo  "<option value=" . $commonType[$i]['ID'] . ">" . $commonType[$i]['name'] . "</option>" ; 
          }
          ?>
         </select> 
          </div>
          <div id='propertyCTemp' > 
          Template&nbsp;:&nbsp;
          <select id='cobjectTemplate' name='cobjectTemplate'> 
              <?php
            for ($i = 0; $i < $count_Ctemp; $i++) {
                echo "<option value=" . $cobjectTemplate[$i]['ID'] . ">" . $cobjectTemplate[$i]['name'] . "</option>" ; 
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
                echo "<option value=" . $cobjectTheme[$i]['ID'] . ">" . $cobjectTheme[$i]['name'] . "</option>" ; 
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
                       echo "<option value=" . $actDiscipline[$i]['ID'] . ">" . $actDiscipline[$i]['name'] . "</option>" ; 
                      }
                    ?> 
                  </select> 
               </div>
        
              <br>                  
                 <div id='ajaxGoal' name='ajaxGoal'>
                 </div>  
                <div id='error'>
                <?php
                if(isset($_GET['error']) && $_GET['error'] == 1  ) {
                    echo "<font size='2' color='red'>Nenhum Objetivo foi Selecionado!</font>";
                } 
                ?> 
                </div>
            <br>
            <div id='submitButton' align='right'>
            <input type='submit' value='Start' >
            </div>
            </form>
            </div>
            </div>
            </body>
            </html>