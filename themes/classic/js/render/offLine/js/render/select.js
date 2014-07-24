$(document).ready(function(){
    var DB_synapse = new DB();
 
    //Classe Principal
    var getAllClassAndStudents = function(){
        DB_synapse.actorOwnUnity = new Array();
        DB_synapse.getAllClass(DB_synapse.getAllStudentFromClasses,eventFilterMeet);
    }

    var eventFilterMeet = function (actorOwnUnity){
        var classrooms = actorOwnUnity;

        if(sessionStorage.getItem('login_personage_name') == 'Tutor'){
            $("#login-select").show();

            $("#classroom").html('');
            $.each(classrooms, function(i, v){
                $("#classroom").append("<option value='"+v['unity_id']+"' id='"+i+"' >"+v['unity_name']+"</option>");
            });

            $('#classroom').change(function(){
                $('#actor').html('');
                var cr = $('#classroom option:selected').attr('id');
                $.each(classrooms[cr]['actors'], function(i, v){
                    $('#actor').append("<option value='"+v['actor_id']+"''>"+v['actor_name']+"</option>");
                })
            });
            $("#classroom").trigger('change');
        } else {
            $("#login-select").hide();
            $("#select-discipline").css('margin-top', '10%')
        }

        $('.discipline').click(function(){

            sessionStorage.setItem('id_discipline', $(this).attr('discipline'));
            if(sessionStorage.getItem('login_personage_name') == 'Tutor'){
                sessionStorage.setItem('id_actor', $('#actor').val());
                sessionStorage.setItem('name_actor', $('#actor').find(":selected").text());
            }
            window.location = "./meet.html";
        });
    }
    
    if(sessionStorage.getItem('login_personage_name') == 'Tutor'){
        getAllClassAndStudents();
    }else{
        eventFilterMeet(null);
    }

});