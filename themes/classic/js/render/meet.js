this.Meet = function(unityfather, options){
    // MGS
    MSG_CORRECT ='Parabéns, você acertou';
    MSG_WRONG ='Ops! Você errou, continue tentando.';
    MAME_ORGANIZATION = 'Organização';
    NAME_CLASS = 'Turma';
    NAME_ACTOR = 'Aluno';
    
    
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
    
    //======================================
    
    this.setDomCobjects = function(comCobjects){
        self.domCobjects = comCobjects;
    }
    
    this.headMeet = function(){
        return '<b>'+MAME_ORGANIZATION+':</b>'+this.org_name
            +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' +NAME_CLASS+':</b> '+this.classe_name
            +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'+NAME_ACTOR+':</b> '+this.actor_name ;
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