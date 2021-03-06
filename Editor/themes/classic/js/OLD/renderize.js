/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function renderize(){
    this.op;
    this.func;
    this.startRenderize = function (response, op, func){
        //se operação não existir, o pradão é all
        if(typeof(op) == "undefined"){
            this.op = "all";
        }
        else{
            this.op = op;
            //lista de operações
                //unity
                //class
                //all
        }
        //Função será chamada no Onchange de cada Unity
        if(typeof (func) != "undefined")
            this.func = func;
        else
            this.func = function(id){};
        
        if(typeof(response.unitys) != "undefined"){
            this.loadUnitys(response.unitys, 0);
        }
    }
    this.loadUnitys = function (unitys, fatherID){
        var id = $(".box").last().attr("id");
        id = id.replace("box_", "");
        id = parseInt(id)+1;

        var nextUnity;
        var count = unitys.length;
        
        if(count == 0){
            if(this.op != "unity")
                this.loadJsonClasses(fatherID);
        }
        else if (count == 1){
            $("#box_"+(id)).remove();
            $("#box_"+(id-1)).append("<div id='box_"+id+"' class='box'></div>");
            $("#box_"+id).append("<input type='hidden' id='org_"+id+"' class='org' name='org["+id+"]' value='"+unitys[0].secondary_unity_id+"'>");
            nextUnity = unitys[0].secondary_unity_id;
            this.loadJsonUnity(nextUnity);
        }
        else{
            var parent = this;
            $("#box_"+id).remove();
            var options = "";
            for(i=0; i<count; i++){
                options += "<option value='"+unitys[i].secondary_unity_id+"'>"+unitys[i].name+"</option>";
            }
            $("#box_"+(id-1)).append("<div id='box_"+id+"' class='box'></div>");
            
            $("#box_"+(id)).append((id == 1) ? "<font>Unidade:</font>" : "<font>-></font>");
            // Chamar função no onChange
            $("#box_"+(id)).append("<select id='org_"+id+"' name='org["+id+"]' class='org' >"+options+"</select>");
            $("#org_"+id).change(function(){
                id = $(this).attr("id");
                id = id.replace("org_", "");
                id = parseInt(id);
                $("#box_"+(id+1)).remove();
                parent.loadJsonUnity($(this).val());
            });
            nextUnity = unitys[0].secondary_unity_id;
            this.loadJsonUnity(nextUnity);
        }
    }
    this.loadClasses = function (classes){
        var parent = this;
        var options = "";
        var count = classes.length;
        
        for(i=0; i<count; i++){
            options += "<option value='"+classes[i].secondary_unity_id+"'>"+classes[i].name+"</option>";
        }
        $("#classesbox").remove();
        $("#filter").append("<div id='classesbox' class='formField'></div>");
        $("#classesbox").append("<font>Turma:</font>");
        $("#classesbox").append("<select id='classes' name='class'>"+options+"</select>");
        $("#classes").change(function(){
            if(parent.op == "all")
                parent.loadJsonActors($(this).val());
        });
        var nextClass = classes[0].secondary_unity_id;
        if(parent.op == "all")
            parent.loadJsonActors(nextClass);
    }
    this.loadActors = function (actors){
        var options = "";
        var count = actors.length;
        
        for(i=0; i<count; i++){
            options += "<option value='"+actors[i].actor_id+"'>"+actors[i].name+"</option>";
        }
        $("#actorsbox").remove();
        $("#filter").append("<div id='actorsbox' class='formField'></div>")
        $("#actorsbox").append("<font>Aluno:</font>");
        $("#actorsbox").append("<select id='actors' name='actor'>"+options+"</select>");
        $("#actorsbox").append("<br>");
        $("#actorsbox").append("<br><input style='display:block;margin:0 auto;' type='submit' value='Confirmar'>");
        $("#actors").change(function(){
        });
    }
    this.loadJsonUnity = function (unityID){
        var parent = this;
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'select', id:unityID},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                parent.loadUnitys(response.unitys, response.fatherID);
                parent.func();
            },
            error:function(){
            }
        });
    }
    this.loadJsonClasses = function (unityID){
        var parent = this;
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'classes', id:unityID},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                parent.loadClasses(response.classes);
            },
            error:function(){
            }
        });
    }
    this.loadJsonActors = function (unityID){
        var parent = this;
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'actors', id:unityID},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                parent.loadActors(response.actors);
            },
            error:function(){
            }
        });
    }
}
