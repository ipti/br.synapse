$(document).ready(function(){
	var classrooms = {
			"1": {
				"name":"1ª A", 
				"actors": {
					"1":"João",
					"2":"José"
				}
			}, 
			"2": {
				"name":"1ª B", 
				"actors": {
					"3":"Paulo",
					"4":"Miseravão"
				}
			}
		};

	if(sessionStorage.getItem('login_personage_name') == 'Tutor'){
		$("#login-select").show();

		$("#classroom").html('');
		$.each(classrooms, function(i, v){
			$("#classroom").append("<option value='"+i+"''>"+v['name']+"</option>");
		});

		$('#classroom').change(function(){
			$('#actor').html('');
			var cr = $('#classroom').val();

			$.each(classrooms[cr]['actors'], function(i, v){
				$('#actor').append("<option value='"+i+"''>"+v+"</option>");
			})
			
		});
		$("#classroom").trigger('change');
	} else {
		$("#login-select").hide();
	}


		$('.discipline').click(function(){

			sessionStorage.setItem('id_discipline', 	$(this).attr('discipline'));
			if(sessionStorage.getItem('login_personage_name') == 'Tutor'){
				sessionStorage.setItem('id_actor', 		$('#actor').val());
				sessionStorage.setItem('name_actor', 	$('#actor').find(":selected").text());
			}
			window.location = "./meet.html";
		});


})