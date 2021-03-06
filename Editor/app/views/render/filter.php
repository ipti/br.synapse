<?php
    $unityfather = Yii::app()->session['unityIdActor'];
?>
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
                newRenderize.startRenderize(response);
            },
            error:function(){
            }
        });

    });
    
            //função beforeSubmit
        function beforeSubmit(){
            $('#name_org_1').val(document.getElementById('org_1').options[document.getElementById('org_1').selectedIndex].text);
            $('#name_classes').val(document.getElementById('classes').options[document.getElementById('classes').selectedIndex].text);
            $('#name_actors').val(document.getElementById('actors').options[document.getElementById('actors').selectedIndex].text);
            return true;
        }
        
        
</script>
<style>
.prerender{border:1px solid #000;width:319px;margin:100px auto;background: #262626;}
.prerender .innerborder{border:1px solid #4A4A4A;background:#fff;width:317px;}
.prerender label{display:block;font-size:12px;color:#5E5E5E;margin:5px 0px;}
.render{display:none;}
.prerender h1{margin-top:-28px;display:block;height:112px;width:317px;background: url('/themes/classic/images/theme_render_header.png')}
.prerender form{display:block;padding:5px;}
.rscripts,.students,.tutors{display:none;}
.prerender .innerborder{width:400px !important}
.prerender label{display:block;clear:both;height:20px;}
.prerender font{float:left;width:120px;height:20px;text-align:right;margin-right:5px; line-height: 20px;}
.start{display:block;clear:both;margin:0 auto}
.waiting{display:none;}
#nextButton{text-align:center;font-size:30px;color:green;display:block;margin:20px auto;cursor:pointer}
</style>
<div class="prerender">
<div class="innerborder">
    <form id="filter" method="POST" action="/render/meet" onsubmit="return beforeSubmit()">
        <input type="hidden" name="name_org_1" id="name_org_1" value=""/>
        <input type="hidden" name="name_classes" id="name_classes" value=""/>
        <input type="hidden" name="name_actors" id="name_actors" value=""/>
        
        <input type="hidden" name="unityfather" id="UnityFather" value="<?php echo $unityfather; ?>"/>
        <div id="box_0" class="box">
        </div>
    </form>
</div>
</div>

