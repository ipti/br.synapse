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
        <form>
            <label>
                <font>Tipo de Atendimento:</font>
                <select id="atdID">
                    <option value="avaliacao">AVALIAÇÃO</option>
                    <option value="treino">TREINO</option>
                    <option value="livre">LIVRE</option>
                </select>
            </label>
            <label id="rblockscript">
                <font>Bloco/Roteiro:</font>
                <select id="typeID">
                    <option value="rscript">ROTEIRO</option>
                    <option value="rblock">BLOCO</option>
                </select>
            </label>
            <label id="rdiscipline">
                <font>Disciplina:</font>
            </label>

            <!--<label id="rlevels">
                <font>Nível:</font>
            </label>
            <label id="robjective">
                <font>Objetivo:</font>
            </label>-->
            <label class="blockscript" id="rblock">
                <font>Bloco:</font>
            </label>
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
                <font>Turma:</font>
            </label>
            <label id="rtutors">
                <font>Tutor:</font>
            </label>
            <label id="rstudents">
                <font>Aluno:</font>
            </label>
            <label id="password">
                <font>Senha:</font>
                <input name="password" value="" type="password"/>
            </label>
            <input class="start" type="button" value="iniciar atendimento">
            <input type="hidden" id="classID"/>
            <input type="hidden" id="userID"/>
        </form>
    </div>
</div>
<div class="waiting">
    <div style="font-size:31px;margin:200px auto;display:block; text-align: center">
        <font>Carregando...</font>
        <img style="margin:0 auto;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_loading.gif"/>
    </div>
</div>
<div class="render">
    <div class="activities"></div>
</div>
