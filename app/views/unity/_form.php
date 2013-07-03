<?php $unityfather = Yii::app()->session['unityIdActor']; ?>
<!--Início do JS -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/renderize.js"></script>
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
                        $.post("/unity/loadOrg", {totalUnity: num_unitys} , function(result) {
                           $('#Unity_organizationID').html(result);                      
                           var IDfolk = $('#org_'+num_unitys).val(); // Id do Pai da nova Unity
                           $('#Unity_fatherID').val(IDfolk);
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
                        <?php echo $form->labelEx($model,'organizationID'); ?>
                                 <?php
                                 echo $form->dropDownList(
                                        $model,
                                        'organizationID',
                                        CHtml::listData(Organization::model()->findAll(),'ID','name') );
                                 ?>                         
                        <?php echo $form->error($model,'organizationID'); ?>
                    </div>

                                       <div class="formField">
                       <!-- <?php//  echo $form->labelEx($model,'fatherID'); ?> -->
                        <?php  echo $form->hiddenField($model,'fatherID'); ?>
                      <!--  <?php//  echo $form->error($model,'fatherID'); ?> -->
                        </div>  

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'locationID'); ?>
                        <?php // echo $form->textField($model,'locationID'); ?>
                          <?php
                             echo $form->dropDownList($model, 'locationID', 
                                     CHtml::listData(Location::model()->findAll(), 'ID', 'name')); 
                           ?>                     
                        <?php echo $form->error($model,'locationID'); ?>
                    </div>

                                     <!--  <div class="formField">
                        <?php //echo $form->labelEx($model,'fcode'); ?>
                        <?php //echo $form->textField($model,'fcode',array('size'=>45,'maxlength'=>45)); ?>
                        <?php //echo $form->error($model,'fcode'); ?>
                    </div> -->

                                  <!-- GERAR AUTOMATICAMENTE !!! <div class="formField">
                        <?php //echo $form->labelEx($model,'autochild'); ?>
                        <?php //echo $form->textField($model,'autochild'); ?>
                        <?php //echo $form->error($model,'autochild'); ?>
                    </div> -->

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'actDate'); ?>
                        <?php echo $form->textField($model,'actDate'); ?>
                        <?php echo $form->error($model,'actDate'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'desDate'); ?>
                        <?php echo $form->textField($model,'desDate'); ?>
                        <?php echo $form->error($model,'desDate'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'capacity'); ?>
                        <?php echo $form->textField($model,'capacity'); ?>
                        <?php echo $form->error($model,'capacity'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
