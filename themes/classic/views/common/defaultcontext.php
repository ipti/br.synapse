<div class="ibox">
    <div class="iboxHeader ">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_icon_actions.png">
        <h4>Actions</h4><blockquote><?php echo $contextDesc?></blockquote>
    </div>
    <div class="iboxContent">
        <?php
        $this->widget('application.components.ContextMenu', array(
			'items'=>$this->menu,
                        'linkLabelWrapper'=>'span',
			'htmlOptions'=>array('class'=>'operations'),
		));
        ?>
    </div>
</div>