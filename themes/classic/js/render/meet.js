this.Meet = function(unityfather, options){
    // MGS
    MSG_CORRECT ='Parabéns, você acertou';
    MSG_WRONG ='Ops! Você errou, continue tentando.';
    MAME_ORGANIZATION = 'Organização';
    NAME_CLASS = 'Turma';
    NAME_ACTOR = 'Aluno';
    DEFAULT_MEET_TYPE = 1; //Atividade = 1 ; Treino = 2
    MAX_ELEMENT_PER_PIECE = 5;
    //================
    var self = this;
    this.domCobjects = null;
    //======== Variáveis Recuperadas do Filtro Inicial ===========
    this.org = options.org[0];
    this.org_name = options.org[1];
    this.classe = options.classe[0];
    this.classe_name = options.classe[1];
    this.actor = options.actor[0];
    this.actor_name = options.actor[1];
    //============================
    
    //==== Armazenar a performance do usuário
    var peformance_qtd_correct = 0;
    var peformance_qtd_wrong = 0;
    var discipline_id = 0;
    var script_id = 0;
    var start_time = 0;
    var final_time = 0;
    var meet_type = options.meet_type || DEFAULT_MEET_TYPE;
    //======================================
    
    this.setDomCobjects = function(domCobjects){
        self.domCobjects = domCobjects;
    }
    this.domCobjectBuildAll = function(){
        return self.domCobjects.buildAll();
    }
    this.beginEvents = function(){
        //iniciar code_Event dos templates
        eval("self.init_"+self.domCobjects.cobject.template_code+"();");
    }
    
    this.headMeet = function(){
        return '<b>'+MAME_ORGANIZATION+':</b>'+this.org_name
        +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' +NAME_CLASS+':</b> '+this.classe_name
        +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'+NAME_ACTOR+':</b> '+this.actor_name ;
    }
    
    //    this.verifyMatch(group1, element1ID, group2, element2ID){
    //        
    //    }
    this.init_Common = function(){
        $('#nextSreen').on('click', function(){
            var currentScreen = $('.currentScreen');
            currentScreen.removeClass('currentScreen');
            currentScreen.hide();
            currentScreen.next().addClass('currentScreen');
            currentScreen.next().show();
        });
    }
    
    this.init_AEL = function(){
        //parseInt(Math.random()*10) % MAX_ELEMENT_PER_PIECE;
        var randomArray = [];
        for(var i = 0; i < MAX_ELEMENT_PER_PIECE; i++){
            randomArray[i]= i;
        }
        
        
        // variável de encontro definida no meet.php
        $('div.answer > div[group]').hide();
        self.init_Common(); 
        $('div[group]').on('click', function(){
            var ask_answer = $(this).parents('div').attr('class');
            if(ask_answer == 'ask') { 
                if(!$(this).hasClass('ael_clicked')){
                    $(this).css('opacity','0.4');
                    $(this).siblings().hide();
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(500);
                    $(this).addClass('ael_clicked');
                    $(this).addClass('last_clicked');
                }else{
                    $(this).css('opacity','1');
                    $(this).siblings().show();
                    $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').hide(500);
                    $(this).removeClass('ael_clicked');
                    $(this).removeClass('last_clicked');
           
                }
            }else if(ask_answer == 'answer'){
                $(this).siblings().hide();
                $(this).hide();
                $(this).closest('div.answer').siblings('div.ask').children('div[group]').show(500);
                var lastClicked = $(this).closest('div.answer').siblings('div.ask').children('div[group].last_clicked');
                var groupAnswerClicked = $(this).attr('group');
                var groupAskClicked = lastClicked.attr('group');
                lastClicked.attr('real_matched',groupAnswerClicked);
                lastClicked.removeClass('last_clicked');
                $(this).closest('div.answer').siblings('div.ask').children('div[group].ael_clicked').hide();
                $(this).addClass('ael_clicked');
                //Verificar se Não existe mais elementos a serem clicados
                if($(this).siblings('div[group]:not(.ael_clicked)').size() == 0){
                    //Não existe mais elementos a clicar, verifica todas as respostas e marca correto na piece
                    $(this).closest('div.piece').attr('istrue',self.ismatch(groupAskClicked,groupAnswerClicked));
                }
            
            }
   
        });

        this.ismatch = function(ask,answer){
            return (ask==answer.split('_')[0]);
        }
    }
    
    //======================
    
    
    this.isset = function (variable){
        return (typeof variable !== 'underfined' && variable !== null);
    }
    
    this.showMessage = function(type){
        var msg = '';
        if(type == 'correct'){
            msg = '<font id="message" class="messagebox messagecorrect">'+MSG_CORRECT+'</font>';
        }else{
            msg = '<font id="message" class="messagebox messagewrong" style="">'+MSG_WRONG+'</font>';
        }
        $('.currentScreen').prepend(msg);
        $('#message').fadeOut(3000,function(){
            $('#message').remove();
        });
    }
    
}