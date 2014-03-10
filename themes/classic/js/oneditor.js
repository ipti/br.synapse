var newEditor = new editor();
$(function() { 
    $('.canvas').pajinate({
        start_page : 0,
        items_per_page : 1,
        nav_label_first : '<<',
        nav_label_last : '>>',
        nav_label_prev : '<',
        nav_label_next : '>',
        show_first_last : false,
        num_page_links_to_display: 20,
        nav_panel_id : '.navsreen',
        editor : newEditor
    }); 
    
    newEditor.countPieceSet['sc0'] = 0;
    newEditor.countPieces['sc0_ps0'] = 0;
    
    //$("#toolbar").draggable({
    //    axis: "y"
    //});                   
    $("#addScreen").click(function(){
        newEditor.addScreen();
    });
    $("#delScreen").click(function(){
        newEditor.delScreen(false);
    });
    
    $(document).on('click',".insertText",function(){
        //Somente adiciona se não possui outro elemento texto neste grupo
        if($(this).closest('div[group]').find('div.text').size() == 0){
            newEditor.addText($(this).closest('div[group]'));
        }
        
    });
    $(document).on('click',".insertImage",function(){ //
         //Somente adiciona se não possui outro elemento imagem neste grupo
        if($(this).closest('div[group]').find('div.image').size() == 0){
           newEditor.addImage($(this).closest('div[group]'));
        }
    });
    $("#addPieceSet").click(function(){
        newEditor.addPieceSet();
    })
    $(document).on("click",".addPiece",(function(){
        newEditor.addPiece($(this).attr('id'));
    }));
    $(document).on("mousedown",'.piece',function(){
        newEditor.changePiece($(this));
    });
    $('.save').click(function(){
        newEditor.saveAll();
    });
    
    if(newEditor.isload){    
        newEditor.load();
    }
    
    $(document).on("change",'.input_element',function() {
        newEditor.imageChanged($(this));
    });
    
    
});
