<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/treeview/jquery.treeview.css" />
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/treeview/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#browser").treeview({
            toggle: function() {
                console.log("%s was toggled.", $(this).find(">span").text());
            }
        });
    });
</script>
<div class="panelGroupHeader">
    <div class="">Selecione o personagem e a organização:</div>
</div>
<ul id="browser" class="filetree treeview-famfamfam">
    <li><span class="folder">República Federativa do Brasil</span>
        <ul>
            <li><span class="folder">Sergipe</span>
                <ul>
                    <li><span class="file">Governador</span></li>
                </ul>
            </li>
            <li><span class="folder">São Paulo</span>
                <ul>
                    <li><span class="folder">Prefeitura Municipal de São Bernado</span>
                        <ul id="folder21">
                            <li><span class="file">Prefeito</span></li>
                            <li><span class="file">File 2.1.2</span></li>
                        </ul>
                    </li>
                    <li><span class="folder">Prefeitura Municipal de Jundiaí</span>
                        <ul>
                            <li><span class="file">Prefeito</span></li>
                            <li><span class="file">File 2.2.2</span></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="closed"><span class="folder">Rio Grande do Sul</span>
                <ul>
                    <li><span class="file">File 3.1</span></li>
                </ul>
            </li>
            <li><span class="file">File 4</span></li>
        </ul>
    </li>
</ul>
<!--<div class="ibox">
    <div class="iboxHeader ">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_icon_actions.png">
        <h4>Actions</h4><blockquote><?php echo $contextDesc ?></blockquote>
    </div>
    <div class="iboxContent">
        
    </div>
</div>-->