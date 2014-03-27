/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 MEET_EXAM_TYPE = "EXAME";
 MEET_TRIAL_TYPE = "TRIAL";
 DEFAULT_CONTENT = "{}";
 DEFAULT_CANVAS_ID = "#render_canvas";
 DEFAULT_WINDOW_ID = "#synapse";
 GETDATA_COBJET = "loadcobject"
 DEFAULT_URL = "/render/";
 REQUEST_AJAX = "ajax";

this.Util = function(){
    this.progressBar = function(percent, $element) {
        if(percent > 100){
            percent = 100;
        }
        var progressBarWidth = percent * $element.width() / 100;
        progressBarWidth = Math.round(progressBarWidth);
        $element.find('div').animate({
            width: progressBarWidth
        }, 10).html(Math.round(percent) + "%&nbsp;");
    }
}

this.getData = function($options){
    switch ($options.type_data){
        case GETDATA_COBJET:
           var gourl = DEFAULT_URL+"loadcobject";
           var filename = "caminhodoarquivo";
           break;
    }
    if($options.type_request == REQUEST_AJAX){
        $.ajax({
            url:gourl,
            data:$options.params,
            type:"POST",
            dataType:"json",
            sucesss: $options.sucess_function(response),
            error:$options.error_function(response)
        });
    }
    
}


var ClassRender = function($options) {
    
    var self = this;
    this.content = $options.content|| DEFAULT_CONTENT;
    this.meet_type = $options.meet_type || MEET_EXAM_TYPE;
    this.canvas_id = $options.canvas_id || DEFAULT_CANVAS_ID;
    this.window_id = $options.window_id || DEFAULT_WINDOW_ID;
    this.cobject = $options.cobject;
    
    var init = function(){
        self.loadCanvas();
        self.loadCobjectsProgressive();
    }
    
    var loadCobjectsProgressive = function(id,pos){
        var position = pos || 0;
        id = id || this.content.ids[position].id;
        this.loadCobject(id);
        this.loadBar(); //---
        this.loadCobjectsProgressive(this.content.ids[position+1].id,position+1);
    }
    
    var loadBar = function(response){
        Util.progressBar(pct_load, $('#progressBar'));
        pct_load = pct_load+cobject.pct_load_item;
        self.messageload("Carregando "+response.cobject_type+" "+id+"...",response.goal);
        if(pos+1 >= json.size){
            $('#msgload').hide();
            self.messageload("Concluido");
            $("#start").show();
            NEWRENDER.mountReportScreen();
        }else{
            parent.ajaxrecursive(json.ids[pos+1].id,pos+1,json);
        }
    }
   
    var loadCanvas = function(){
        $(this.window_id).find('div').hide();
        $(this.canvas_id).show();
    }
    var messageload = function(title,text){
        $('#titleload').text(title);
        $('#msgload').html(text);
    }
   
    var loadCobject = function(id){
        var cobject = Util.getData({
        type_data:GETDATA_COBJET,
        type_request:REQUEST_AJAX,
        params:{
            ID:id,
            sucess_function: function(response){
                self.loadBar(response);
            } ,
            error_function: function(){
            }
        }
        });
    }
   
    var buildCobject = function(){
    //parent.loadcobject(response);
    }
   
}


var ClassMeet = function(){
    this.self = this;
    this.peformance_qtd_correct = 0;
    this.peformance_qtd_wrong = 0;
    this.discipline_id = 0;
    this.script_id = 0;
    
//this.screen_start_time = 0;
//this.screen_
}


var $options = {
    meet_type:'Oi',
    content:json
}
render = new ClassRender($options);
