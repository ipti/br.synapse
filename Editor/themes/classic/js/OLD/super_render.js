/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 MSG_LOADING = "CARREGANDO";
 MSG_COMPLETED = "CONCLUÍDO";

 DEFAULT_URL = "/render/";

 MEET_EXAM_TYPE = "EXAME";
 MEET_TRIAL_TYPE = "TRIAL";
 MEET_DEFAULT_TYPE = MEET_EXAM_TYPE;

 RENDER_DEFAULT_MEET = new ClassMeet({student_id:0,student_name:'Teste'});
 RENDER_DEFAULT_COBJECTS = {};

 GETDATA_COBJET = "loadcobject"

 REQUEST_AJAX = "ajax";
 DEFAULT_RENDER_TYPE = "";


 $_BL_PROGRESS_BAR = "#progressBar";
 $_BL_MSG_LOAD = "#messageload";
 $_BL_TITLE_LOAD = "#titleload";
 $_CTN_CANVAS = "#render_canvas";
 $_CTN_WINDOW = "#synapse";
 $_CTN_RENDER = "#render";
 $_CTN_LOADING = "#loading";
 $_BTN_START = "#start";

this.Util = function(){
    this.progressBar = function(percent, element_id) {
        if(percent > 100){
            percent = 100;
        }
        progressBarWidth = Math.round((percent * $(element_id).width() / 100));
        $(element_id).find('div').animate({
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

var ClassMeet = function($options){
    this.self = this;
    this.peformance_qtd_correct = 0;
    this.peformance_qtd_wrong = 0;
    this.discipline_id = 0;
    this.script_id = 0;
    this.start_time = 0;
    this.final_time = 0;
    this.type = $options.meet_type || 0; //DEFAULT_MEET_TYPE
}

var ClassRender = function($options) {
    this.cobjects = $options.cobjects || DEFAULT_COBJECTS;
    this.cobject = $options.cobject;
    this.meet = $options.meet || DEFAULT_MEET;
    this.canvas_id = $options.canvas_id || $_DEFAULT_CANVAS;
    this.window_id = $options.window_id || $_DEFAULT_WINDOW;
    this.progress_id = $options.progress_id || $_DEFAULT_PROGRESS;
    this.render_type = $options.render_type || DEFAULT_RENDER_TYPE;
    this.positions = {
        screen:0,
        pieceset:0,
        piece:0,
        element:0
    }
    this.html = {
        screen:'<div class="screen" id="SCR'+this.cobject[this.position.screen].id+'"></div>',
        pieceset:'',
    }
    this.pct_load = 0;
    var self = this;

    this.init = function(){
        self.loadCanvas();
        self.loadCobjectsProgressive();
    }
    
    this.loadCobjectsProgressive = function(pos,id){
        var position = pos || 0;
        var id = id || self.cobjects.ids[position].id;
        Util.getData({type_data:GETDATA_COBJET,type_request:REQUEST_AJAX,params:{
            ID:id},
            sucess_function: function(response){
                self.cobject = response;
                self.loadBar();
                var bd = new DomCobject(self.cobject);
                bd.pos.screen = 2;
                bd.pos.pieceset = 1;
                bd.buildPieceset();
                bd.htmlPiece.html;
                //self.buildCobject();
                if(position+1 >= self.cobjects.size){
                    $($_BL_MSG_LOAD).hide();
                    $($_BL_TITLE_LOAD).text(MSG_COMPLETED);
                    $($_BTN_START).on('body','onclick',self.start()).show();
                    //NEWRENDER.mountReportScreen();
                }else{
                     self.loadCobjectsProgressive(position+1,self.cobjects.ids[position+1].id);
                }
            } ,
            error_function: function(){
                
            }
        });
    }

    this.start = function(){
        $($_CTN_LOADING).hide();
        $($_CTN_RENDER).show();
        //$('.screen').first().fadeIn('slow');
        //$('.screen').first().addClass('currentScreen');
        self.meet.startTime = Math.round(+new Date()/1000);
    }
    
    this.loadBar = function(){
        Util.progressBar(self.pct_load, self.progress_id);
        self.pct_load += self.cobject.pct_load_item;
        $($_BL_TITLE_LOAD).text(MSG_LOADING+" "+self.cobject.cobject_type+" "+id+"...");
        $($_BL_MSG_LOAD).html(self.cobject.goal);
    }
   
    this.loadCanvas = function(){
        $(this.window_id).find('div').hide();
        $(this.canvas_id).show();
    }
    /*
    this.mount = function(screen){
            for (var self.positions.screen = 0; i < cobject.screens.length; self.positions.screen++) {
                
                //$(self.html.screen).append();
            };
            
    }*/
   
    this.buildCobject = function(){
        if(typeof(cobject.screens) != "undefined"){


            $.each(cobject.screens, function(i, screen) {

                self.mount('screen',screen);

                self.mountDiv();

                htmScreen = $('<div class="screen" id="SCR'+screen.id+'"></div>');
                htmScreen.append(self.mountHeader(cobject));
                if(typeof(screen.piecesets) != "undefined"){
                    htmScreen.append(self.loadPiecesets(screen.piecesets,cobject.template_code,cobject.format_code));
                    
                    


                    if(NEWRENDER.atdID == "exam"){
                        if(cobject.template_code== 'TXT'||cobject.template_code== 'PDC'){
                            htmScreen.append(parent.nextInFuction());
                        }
                    }
                }
                $(".cobjects").append(htmScreen);
            });
        }
    //parent.loadcobject(response);
    }
    this.buildHeader = function(){
        infoScreen = $('<div class="screenInfo"></div>');
        if(typeof(cobject.father) != "undefined"){
            readtext = '<a onclick="return showtext('+cobject.father+')" href="javascript:void(0);" target="_blank">Ler Texto</a>';
        }else{
            readtext = '';
        }
        infoScreen.append('<span id="infoAct"><label><strong>Aluno:</strong>'+this.actorName+' [Acertos:<span class="ctCorrect">0</span>/Erros:<span class="ctWrong">0</span>]</label><label><strong>Atividade: </strong>Nº'+cobject.cobject_id+'-'+cobject.template_code+'-'+cobject.theme+'</label><label><strong>Conteúdo: </strong> '+cobject.content+'</label><label class="goal"> '+cobject.goal+' '+readtext+'</label></span>');
        nextScreen = $('<span id="next">»</span>').on('click',function(){
            $('.currentScreen').hide();
            $('.currentScreen').next().show();
            $('.currentScreen').removeClass('currentScreen').next().addClass('currentScreen');
            NEWRENDER.startTime = Math.round(+new Date()/1000);
        });
        prevScreen = $('<span id="previous">«</span>').on('click',function(){
            $('.currentScreen').hide();
            $('.currentScreen').prev().show();
            $('.currentScreen').removeClass('currentScreen').prev().addClass('currentScreen');
            NEWRENDER.startTime = Math.round(+new Date()/1000);
        });
        if(parent.atdID == "exam"){
            prevScreen.hide();
            nextScreen.hide();     
        }
        infoScreen.append(nextScreen);
        infoScreen.prepend(prevScreen);
        infoScreen.append('<span class="clear"></span>');
        if($(".cobjects").text()==""){
            prevScreen.hide();
        }
        return infoScreen;
    }
   
}

meet_now = new ClassMeet({student_id:0,student_name:'Teste'});
render = new ClassRender({meet:meet_now,cobjects:json});
render.init();
