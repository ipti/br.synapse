<?php $unityfather = Yii::app()->session['unityIdActor']; ?>
<!--Início do JS -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/renderize.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/date/jquery.maskedinput.js"> </script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/date/dates.js"> </script>
<script>
    var unity = <?php echo $unityfather ?>;
    
    $(function() {
        var newRenderize = new renderize();
   
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'select', id:unity},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                newRenderize.startRenderize(response,'unity', 
                    function () {
                        var num_unitys = 0;
                        num_unitys = $('.org').size(); // coincide com o OrgfatherID da Última Unity
                        var lastUnity = $('.org').last();
                        var lastUnityID = lastUnity.val(); 
                        $.post("/unity/loadOrg", {unity_id: lastUnityID} , function(result) {
                           $('#Unity_organization_id').html(result);                      
                           var IDfolk = $('#org_'+num_unitys).val(); // Id do Pai da nova Unity
                           $('#Unity_father_id').val(IDfolk);
                        });
                    } );
            },
            error:function(){
            }
        });
        
//        $.post(
//            "/render/json",
//            {op:'select', id:unity},//data for throwing the expected url
//                function () {
//                    var id = $('.org').size();
//                    console.log("count:"+id);
//                } 
//        );

    });
    
 $(document).ready( 
   function(){
   //-- Update----//
   timestmpToDate( $('#Unity_active_date').val() ,'actDt') ;
   timestmpToDate( $('#Unity_desactive_date').val() ,'desDt') ;
   //-------   -----//
   $('#actDt').mask("99/99/9999");
   $('#actDt').change(function() { dateToTimestmp(this.value,'Unity_active_date') });
   $('#desDt').mask("99/99/9999");
   $('#desDt').change(function() { dateToTimestmp(this.value,'Unity_desactive_date')  });
   $('#desDt, #actDt').blur( function() { 
       if( ($('#Unity_desactive_date').val() <= $('#Unity_active_date').val()) &&
          $('#Unity_desactive_date').val() != '' && $('#Unity_active_date').val() != '' ) {
            var act_des_date = "A Data de Desativação deve ser MAIOR que a Data de Ativação !";
            window.alert(act_des_date);
             } 
        } );
     });
    
   
</script>
<!--      Final do JS         -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'unity-form',
	'enableAjaxValidation'=>false,
)); ?>
        <div class="panelGroup form">
            <?php echo $form->errorSummary($model); ?>
            <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
</div></div>
            <div class="panelGroupBody">
                <div class="panelGroupAbout">
                     <?php echo Yii::t('default', 'Fields with * are required.')?></div>

                      <div id="filter">
                        <input type="hidden" id="UnityFather" value="<?php  echo $unityfather; ?>"/>
                        <div id="box_0" class="box formField">
                        </div>
                      </div>              
                    <div class="formField">
                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
                        <?php echo $form->error($model,'name'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'organization_id'); ?>
                                 <?php
                                 echo $form->dropDownList(
                                        $model,
                                        'organization_id',
                                        CHtml::listData(Organization::model()->findAll(),'id','name') );
                                 ?>                         
                        <?php echo $form->error($model,'organization_id'); ?>
                    </div>

                                       <div class="formField">
                       <!-- <?php //  echo $form->labelEx($model,'fatherID'); ?> -->
                        <?php  echo $form->hiddenField($model,'father_id'); ?>
                      <!--  <?php //  echo $form->error($model,'fatherID'); ?> -->
                        </div>  

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'location_id'); ?>
                        <?php // echo $form->textField($model,'locationID'); ?>
                          <?php
                             echo $form->dropDownList($model, 'location_id', 
                                     CHtml::listData(Location::model()->findAll(), 'id', 'name')); 
                           ?>                     
                        <?php echo $form->error($model,'location_id'); ?>
                    </div>

                                     <!--  <div class="formField">
                        <?php //echo $form->labelEx($model,'fk_code'); ?>
                        <?php //echo $form->textField($model,'fk_code',array('size'=>45,'maxlength'=>45)); ?>
                        <?php //echo $form->error($model,'fk_code'); ?>
                    </div> -->

                                  <!-- GERAR AUTOMATICAMENTE !!! <div class="formField">
                        <?php //echo $form->labelEx($model,'autochild'); ?>
                        <?php //echo $form->textField($model,'autochild'); ?>
                        <?php //echo $form->error($model,'autochild'); ?>
                    </div> -->

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'active_date'); ?>
                              <input type="text" id="actDt">
                        <?php echo $form->hiddenField($model,'active_date'); ?>
                        <?php echo $form->error($model,'active_date'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'desactive_date'); ?>
                              <input type="text" id="desDt">
                        <?php echo $form->hiddenField($model,'desactive_date'); ?>
                        <?php echo $form->error($model,'desactive_date'); ?>
                    </div>

<!--                                        <div class="formField">
                        <?php //echo $form->labelEx($model,'capacity'); ?>
                        <?php // echo $form->textField($model,'capacity'); ?>
                        <?php //echo $form->error($model,'capacity'); ?>
                    </div>-->

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
