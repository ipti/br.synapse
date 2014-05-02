this.Meet = function(personage, idActor, unityIdActor){
    // MGS
    MSG_CORRECT ='Parabéns, você acertou';
    MSG_WRONG ='Ops! Você errou, continue tentando.';
    
    //================
    var self = this;
    this.personage = personage;
    this.idActor = idActor;
    this.unityIdActor = unityIdActor; 
     
     
    
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