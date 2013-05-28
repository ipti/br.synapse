 <?php       
     $commonType =  Yii::app()->db->createCommand('SELECT ID, name FROM common_type WHERE context LIKE \'Cobject\' ')->queryAll(); 
     $count_CT = count($commonType);
     $cobjectTemplate = Yii::app()->db->createCommand('SELECT ID, name FROM cobject_template')->queryAll();
     $count_Ctemp = count($cobjectTemplate);
     $cobjectTheme = Yii::app()->db->createCommand('SELECT ID, name FROM cobject_theme')->queryAll();
     $count_Cthem = count($cobjectTheme);
?>
          <html>
          <style>
            .prerender{border:1px solid #000;width:452px;margin:100px auto;background: #262626;}
            .prerender .innerborder{border:1px solid #4A4A4A;background:#fff;width:450px;}
            .prerender label{display:block;font-size:12px;color:#5E5E5E;margin:5px 0px;}
            .prerender form{display:block;padding:5px;}
            .prerender label{display:block;clear:both;height:20px;}
            .prerender font{float:left;width:120px;height:20px;text-align:right;margin-right:5px; line-height: 20px;}
         </style>

          <body bgcolor='#585858'>
          <div id = 'property' class='prerender'>
          <div id = 'property' class='innerborder'>
          <form name='propertyForm' id='propertyForm' method='POST' action='index'>
          <div id='propertyCT'> 
          Common Type&nbsp;:&nbsp;
          <select id='commonType' name='commonType'> 
          <?php
          for ($i = 0; $i < $count_CT; $i++) {
            echo  "<option value=" . $commonType[$i]['ID'] . ">" . $commonType[$i]['name'] . "</option>" ; 
          }
          ?>
         </select> 
          </div>
          <div id='propertyCTemp' > 
          Cobject Template&nbsp;:&nbsp;
          <select id='cobjectTemplate' name='cobjectTemplate'> 
              <?php
            for ($i = 0; $i < $count_Ctemp; $i++) {
                echo "<option value=" . $cobjectTemplate[$i]['ID'] . ">" . $cobjectTemplate[$i]['name'] . "</option>" ; 
             }
              ?>
          </select> 
          </div>
          <div id='propertyCthem'  > 
          Cobject Theme&nbsp;:&nbsp;
          <select id='cobjectTheme' name='cobjectTheme'> 
           <?php   
            for ($i = 0; $i < $count_Cthem; $i++) {
                echo "<option value=" . $cobjectTheme[$i]['ID'] . ">" . $cobjectTheme[$i]['name'] . "</option>" ; 
             }
           ?> 
        </select> 
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