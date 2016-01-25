<?php $this->pageTitle = Yii::app()->name; ?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
             <?php $this->renderPartial('////common/cobjectcontext')?>
            </br>
        </div>
        <div class="columntwo">
            <?php $this->renderPartial('////common/goalcontext')?>
            </br>
        </div>
    </div>
</div>