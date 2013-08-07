<?php
if (isset($_SESSION['idActor'])&&!(isset($_REQUEST['actor']))) {
    $act = Actor::model()->findbypk($_SESSION['idActor']);
    $class = Unity::model()->findbypk($_SESSION['unityIdActor']);
} else {
    $act = Actor::model()->findbypk($_REQUEST['actor']);
    $class = Unity::model()->findbypk($_REQUEST['class']);
}
//actor
//
?>

<script>
    var newRender = new render();
    $(function() {
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'start'},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){newRender.startRender(response);$('#rdiscipline').trigger('change');$('#rblockscript select').trigger('change');},
            error:function(){
            }
        });

        $('#previous').on('click',function(){

        });
        $('#rblockscript').change(function(){
            $('.blockscript').hide();
            v = $("#rblockscript select").val();
            $('#'+v).show();
        });
        $('#rdiscipline').change(function(){
            $('.rscripts').hide();
            $('.rblocks').hide();
            v = $("select#rdiscipline").val();
            newRender.disciplineID = v;
            $('#rscript'+v).show();
            $('#rblock'+v).show();
        });
        $('.start').click(function(){
            newRender.scriptID = $('select#rscript'+newRender.disciplineID).val();
            newRender.typeID = $('#typeID').val();
            newRender.atdID = $('#atdID').val();
            $('#disciplineID').val(newRender.disciplineID);
            $('#scriptID').val(newRender.scriptID);
            $('form').submit();
            //            
            //           
            //            
            //            newRender.blockID = $('select#rblock'+newRender.disciplineID).val();
            //            newRender.classID = $('#classID').val();
            //            newRender.actorID = $('#actorID').val();
            //            $('.prerender').hide();
            //            $('.waiting').show();
            //            loadActs();
        })
    });
</script>

<style>
    .prerender{border:1px solid #000;width:319px;margin:100px auto;background: #262626;}
    .prerender .innerborder{border:1px solid #4A4A4A;background:#fff;width:317px;}
    .prerender label{display:block;font-size:12px;color:#5E5E5E;margin:5px 0px;}
    .render{display:none;}
    .prerender h1{margin-top:-28px;display:block;height:112px;width:317px;background: url('<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_render_header.png')}
    .prerender form{display:block;padding:5px;}
    .rscripts,.students,.tutors{display:none;}
    .prerender label{display:block;clear:both;height:20px;}
    .prerender font{float:left;width:120px;height:20px;text-align:right;margin-right:5px; line-height: 20px;}
    .start{display:block;clear:both;margin:0 auto}
    .waiting{display:none;}
    #nextButton{text-align:center;font-size:30px;color:green;display:block;margin:20px auto;cursor:pointer}
</style>
<div class="prerender">
    <div class="innerborder">
        <h1></h1>
        <form action="/render/stage" method="POST">
            <!--<label>
                <font>Tipo de Atendimento:</font>
                <select id="atdID">
                    <option value="exam">AVALIAÇÃO</option>
                    <option value="training">TREINO</option>
                </select>
            </label>-->
            <!--<label id="rblockscript">
                <font>Bloco/Roteiro:</font>
                <select id="typeID">
                    <option value="rscript">ROTEIRO</option>
                    <option value="rblock">BLOCO</option>
                </select>
            </label>-->
            <label id="rdiscipline">
                <font>Disciplina:</font>
            </label>

            <!--<label id="rlevels">
                <font>Nível:</font>
            </label>
            <label id="robjective">
                <font>Objetivo:</font>
            </label>-->
            <!--<label class="blockscript" id="rblock">
                <font>Bloco:</font>
            </label>-->
            <label class="blockscript" id="rscript">
                <font>Roteiro:</font>
            </label>
           <label id="rtheme">
                <font>Tema:</font>
            </label>
            <!--<label>
                <font>Seguir a matriz:</font>
                <select>
                    <option>SIM</option>
                    <option>NÃO</option>
                </select>
            </label>-->
            <label id="rclasses">
                <font>Turma:</font><?php echo $class->name ?>
            </label>
            <label id="rtutors">
                <font>Tutor:</font><?php echo Yii::app()->user->name; ?>
            </label>
            <label id="rstudents">
                <font>Aluno:</font><?php echo $act->person->name ?>
            </label>
            <input class="start" type="submit" value="iniciar atendimento">
            <input name="unityID" type="hidden" id="classID" value="<?php echo $class->id ?>"/>
            <input name="actorID" type="hidden" id="actorID" value="<?php echo $act->id; ?>"/>
            <input name="scriptID" type="hidden" id="scriptID" value=""/>
            <input name="disciplineID" type="hidden" id="disciplineID" value=""/>
        </form>
    </div>
</div>

