//Comunicação com o banco de dados no Servidor Online


//Verificar se É o RenderOnline
if (sessionStorage.getItem("isOnline") !== null &&
    sessionStorage.getItem("isOnline") == 'true') {

    this.DBOn = function() {

        var self = this;

        this.login = function(login, password, CBposLogin) {
            if (login !== '' && password !== '' && self.isset(login) && self.isset(password)) {

                if (login == 'admin') {
                    if (password == '123456') {
                        //Senha correta
                        var name = "Administrador";
                        var id = "-1";
                        var personage_name = "admin";
                        var classroom_id = "-1";
                        //Armazenar nome do usuário e id_Actor na sessão
                        sessionStorage.setItem("authorization", true);
                        sessionStorage.setItem("login_id_actor", id);
                        sessionStorage.setItem("login_name_actor", name);
                        sessionStorage.setItem('login_personage_name', personage_name);
                        sessionStorage.setItem("login_classroom_id_actor", classroom_id);

                    } else {
                        //Senha incorreta
                        sessionStorage.setItem("authorization", false);
                    }

                    //Chama o callBack
                    CBposLogin();

                } else {
                    //Não é um admin
                    //Buscar o usuário
                    var data = {
                        login: login,
                        password: password
                    }
                    $.ajax({
                        type: "POST",
                        url: "/Render/login",
                        dataType: 'json',
                        data: data,
                        beforeSend: function(jqXHR, settings) {
                            //executing query
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            //Error
                        },
                        success: function(response, textStatus, jqXHR) {
                            var authorization = response['authorization'];
                            var actor = response['actor'];

                            if (authorization) {
                                //Usuário e Senha válidos
                                var name = actor['name'];
                                var id = actor['id'];
                                var personage_name = actor['personage_name'];
                                var classroom_id = actor['unity_id'];
                                //Armazenar nome do usuário e id_Actor na sessão
                                sessionStorage.setItem("authorization", true);
                                sessionStorage.setItem("login_id_actor", id);
                                sessionStorage.setItem("login_name_actor", name);
                                sessionStorage.setItem('login_personage_name', personage_name);
                                sessionStorage.setItem("login_classroom_id_actor", classroom_id);
                            } else {
                                //Usuário e/ou Senha Inválida
                                sessionStorage.setItem("authorization", false);
                            }

                            //Chama o método callBack
                            CBposLogin();

                        }
                    });

                }

            } else {
                //Usuário ou Senha nulos
                sessionStorage.setItem("authorization", false);
                //Chama o método callBack
                CBposLogin();
            }

        }


        this.isset = function(variable) {
            return (typeof variable !== 'undefined' && variable !== null);
        }

    }

}
