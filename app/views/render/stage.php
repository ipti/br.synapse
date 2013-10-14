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
    .waiting{}
    #nextButton{text-align:center;font-size:30px;color:green;display:block;margin:20px auto;cursor:pointer}
    #progressBar {
        margin:0 auto;
        width: 400px;
        height: 22px;
        border: 1px solid #111;
        background-color: #292929;
    }

    #progressBar div {
        height: 100%;
        color: #fff;
        text-align: right;
        line-height: 22px; /* same as #progressBar height if we want text middle aligned */
        width: 0;
        background-color: #0099ff;
    }
</style>
<script>

    var NEWRENDER = new render();
    NEWRENDER.scriptID = 1;
    NEWRENDER.actorID = <?php echo $actor->id?>;
    NEWRENDER.actorName = '<?php echo $actor->person->name?>';
    NEWRENDER.atdID = 'trial';
    
    $(function() {
        var json = <?php echo $json ?>;
        NEWRENDER.init();
        NEWRENDER.progresiveLoad(json,'#status');
    });
</script>
<div class="waiting">
    <div style="font-size:24px;margin:200px auto;display:block; text-align: center;color:white;">
        <font id="titleload">Inicializando...</font>
        <div id="progressBar"><div></div></div>
        <span id="msgload" style="font-size:12px;">Inicializando objetivos</span>
        <input id="start" style="display:none;font-size:20px" type="button" value="Iniciar"/>
    </div>
</div>
<div class="render">
    <div class="cobjects"></div>
</div>