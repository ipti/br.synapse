// // - - - - - - - - - -  //
// CRIAR BANCO DE DADOS //
// - - - - - - - - - -  //
this.DB = function() {
    self = this;
    nameBD = "synapseDB";
    DBversion = 1;
    DBsynapse = null;

    db = null;

    this.verifyIDBrownser = function() {
        // Na linha abaixo, você deve incluir os prefixos do navegador que você vai testar.
        window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
        // Não use "var indexedDB = ..." se você não está numa function.
        // Posteriormente, você pode precisar de referências de algum objeto window.IDB*:
        window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction;
        window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange;
        // (Mozilla nunca usou prefixo nesses objetos, então não precisamos window.mozIDB*)
        return window.indexedDB;
    }

    this.openDBuild = function(alterSchema) {
        window.indexedDB = self.verifyIDBrownser();
        if (!window.indexedDB) {
            window.alert("Seu navegador não suporta uma versão estável do IndexedDB. Alguns recursos não estarão disponíveis.");
        }
        //Verificar se precisa mudar o setVersion para alterar o schema do BD
        var alterSchema = (this.isset(alterSchema) && alterSchema);

        //Se ainda não atualizou o DBversion, então abre o banco na sua versão atual
        var synapseBD;
        synapseBD = window.indexedDB.open(nameBD);

        synapseBD.onerror = function(event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        }
        synapseBD.onsuccess = function(event) {
            var db = event.target.result;
            db.onerror = function(event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                alert("Database error: " + event.target.errorCode);
            };

            DBversion = db.version;
            if (alterSchema) {
                DBversion++;
            }
            //Antes de abrir o banco novamente, fecha essa conexão com o BD
            db.close();
            openBuild();
        }

    }



    var openBuild = function() {
        DBsynapse = window.indexedDB.open(nameBD, DBversion);
        DBsynapse.onerror = function(event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        };
        DBsynapse.onsuccess = function(event) {
            var db = event.target.result;
            db.onerror = function(event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                alert("Database error: " + event.target.errorCode);
            };
        }
        //Se for uma nova versão é criado o novo schemma do banco
        self.buildAllSchema();

        DBsynapse.onblocked = function(event) {
            // Se existe outra aba com a versão antiga
            window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
        };

    }


    this.buildAllSchema = function() {
        //Criar Schemas das tabelas
        DBsynapse.onupgradeneeded = function(event) {
            var db = event.target.result;

            var unityStore = db.createObjectStore("unity", {
                keyPath: "id"
            });
            // Podemos ter nomes duplicados, então não podemos usar como índice único.
            unityStore.createIndex("name", "name", {
                unique: false
            });
            // Falta organization_id & father_id 
            //===========================================

            // cria um objectStore de ACTOR
            var actorStore = db.createObjectStore("actor", {
                keyPath: "id"
            });
            // Podemos ter nomes duplicados, então não podemos usar como índice único.
            actorStore.createIndex("name", "name", {
                unique: false
            });
            actorStore.createIndex("login", "login", {
                unique: true
            });
            // Falta personage_name & password
            //===============================================

            // cria um objectStore da discipline
            var disciplineStore = db.createObjectStore("discipline", {
                keyPath: "id"
            });
            disciplineStore.createIndex("name", "name", {
                unique: true
            });
            //================================================

            // cria um objectStore do cobjectblock
            var cobjectblockStore = db.createObjectStore("cobjectblock", {
                keyPath: "id"
            });
            // Nome do bloco deve ser Único
            cobjectblockStore.createIndex("name", "name", {
                unique: true
            });
            // Falta discipline_id

            //================================================


            // cria um objectStore do cobject_cobjectblock
            var cobject_cobjectblockStore = db.createObjectStore("cobject_cobjectblock", {
                keyPath: "id"
            });
            // Faltam cobject_id, cobject_block_id

            //================================================

            // cria um objectStore do cobject
            var cobjectStore = db.createObjectStore("cobject", {
                keyPath: "cobject_id"
            });
            // E Falta  o Json de toda a view deste cobject_id
            //================================================


            // cria um objectStore do performance_actor
            var performance_actorStore = db.createObjectStore("performance_actor", {
                keyPath: "id", autoIncrement:true
            });
            //Faltam
            /* piece_id
             piece_element_id
             actor_id
             start_time
             final_time
             value
             iscorrect
             group_id  */
            //===============================================


            // Usando transação oncomplete para afirmar que a criação do objectStore 
            // é terminada antes de adicionar algum dado nele.

            unityStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }

            actorStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }
            disciplineStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }
            cobjectblockStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }
            cobject_cobjectblockStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }
            cobjectStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }
            performance_actorStore.transaction.oncomplete = function(event) {
                //Se for o último dos 7 então contruiu todos os schemas
                db.close();
                window.alert('Criou os Schemas');
            }

            useDatabase(db);
        }
    }




    // - - - - - - - - - -  //
    // IMPORT PARA BANCO DE DADOS //
    // - - - - - - - - - -  //

    this.importAllDataRender = function(unitys, actors, disciplines, cobjectblock
            , cobject_cobjectblocks, cobjects) {
        //Unidade e Usuário
        var data_unity = unitys;

        var data_actor = actors;
        //======================================
        //Blocos de Atividades para cada Disciplina
        var data_discipline = disciplines;

        var data_cobjectBlock = cobjectblock;

        var data_cobject_cobjectBlock = cobject_cobjectblocks;

        //Cobjets
        var data_cobject = cobjects;


        window.indexedDB = self.verifyIDBrownser();
        DBsynapse = window.indexedDB.open(nameBD);
        DBsynapse.onerror = function(event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        };
        DBsynapse.onsuccess = function(event) {
            var db = event.target.result;
            db.onerror = function(event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                window.alert("Database error: " + event.target.errorCode);
            };

            //Importar as unitys
            self.importUnity(db, data_unity);

            //Importar os atores
            self.importActor(db, data_actor);

            //Importar as disciplines
            self.importDiscipline(db, data_discipline);

            //Importar os cobjectblocks
            self.importCobjectblock(db, data_cobjectBlock);

            //Importar os cobject_cobjectblocks
            self.importCobject_cobjectblock(db, data_cobject_cobjectBlock);

            // Salvar o Objeto JSON. NÃO PRECISA CRIAR VARIAS TABELA E GERAR UM JSON. Custa processamento.
            //Importar os cobjects
            self.importCobject(db, data_cobject);

            //Importar os performance_actors
            // self.importPerformance_actor(db,data_performance_actor); 


        }
        DBsynapse.onblocked = function(event) {
            // Se existe outra aba com a versão antiga
            window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
        }


    }

    //////////////////////
    //Métodos de Import 
    /////////////////////

    //Importar as unitys
    this.importUnity = function(db, data_unity) {

        var UnityObjectStore = db.transaction("unity", "readwrite").objectStore("unity");
        for (var i in data_unity) {
            UnityObjectStore.add(data_unity[i]);
        }
        UnityObjectStore.transaction.oncomplete = function(event) {
            window.alert("Unitys IMPORTED!");
        }
    }

    //Importar os atores
    this.importActor = function(db, data_actor) {
        var ActorObjectStore = db.transaction("actor", "readwrite").objectStore("actor");
        for (var i in data_actor) {
            ActorObjectStore.add(data_actor[i]);
        }
        ActorObjectStore.transaction.oncomplete = function(event) {
            window.alert("Actors IMPORTED!");
        }
    }

    //Importar as disciplines
    this.importDiscipline = function(db, data_discipline) {
        var DisciplineObjectStore = db.transaction("discipline", "readwrite").objectStore("discipline");
        for (var i in data_discipline) {
            DisciplineObjectStore.add(data_discipline[i]);
        }
        DisciplineObjectStore.transaction.oncomplete = function(event) {
            window.alert("Disciplines IMPORTED!");
        }
    }

    //Importar os cobjectblocks
    this.importCobjectblock = function(db, data_cobjectBlock) {
        var CobjectblockObjectStore = db.transaction("cobjectblock", "readwrite").objectStore("cobjectblock");
        for (var i in data_cobjectBlock) {
            CobjectblockObjectStore.add(data_cobjectBlock[i]);
        }
        CobjectblockObjectStore.transaction.oncomplete = function(event) {
            window.alert("Cobjectblocks IMPORTED!");
        }
    }

    //Importar os cobject_cobjectblocks
    this.importCobject_cobjectblock = function(db, data_cobject_cobjectBlock) {
        var Cobject_cobjectBlockObjectStore = db.transaction("cobject_cobjectblock", "readwrite").objectStore("cobject_cobjectblock");
        for (var i in data_cobject_cobjectBlock) {
            Cobject_cobjectBlockObjectStore.add(data_cobject_cobjectBlock[i]);
        }
        Cobject_cobjectBlockObjectStore.transaction.oncomplete = function(event) {
            window.alert("Cobject_cobjectblocks IMPORTED!");
        }
    }

    // Salvar o Objeto JSON. NÃO PRECISA CRIAR VARIAS TABELA E GERAR UM JSON. Custa processamento.
    //Importar os cobjects
    this.importCobject = function(db, data_cobject) {
        var CobjectObjectStore = db.transaction("cobject", "readwrite").objectStore("cobject");
        for (var i in data_cobject) {
            CobjectObjectStore.add(data_cobject[i]);
        }
        CobjectObjectStore.transaction.oncomplete = function(event) {
            window.alert("Cobjects IMPORTED!");
        }
    }

    //Importar os performance_actors
    this.importPerformance_actor = function(db, data_performance_actor) {
        var Performance_actorObjectStore = db.transaction("performance_actor", "readwrite").objectStore("performance_actor");
        for (var i in data_performance_actor) {
            Performance_actorObjectStore.add(data_performance_actor[i]);
        }
        Performance_actorObjectStore.transaction.oncomplete = function(event) {
            window.alert("Performance_actors IMPORTED!");
        }
    }


    //Pesquisas No Banco        
    this.login = function(login, password, callBack) {
        if (login !== '' && password !== '' && self.isset(login) && self.isset(password)) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
            }
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    window.alert("Database error: " + event.target.errorCode);
                }
                //Tudo ok Então Busca O Actor
                var ActorObjectStore = db.transaction("actor").objectStore("actor");
                var requestGet = ActorObjectStore.index("login").get(login);
                requestGet.onerror = function(event) {
                    // Tratar erro!
                }
                requestGet.onsuccess = function(event) {
                    // Fazer algo com request.result!
                    if (self.isset(requestGet.result)) {
                        //Encontrou o Usuário
                        if (password == requestGet.result.password) {
                            //Senha correta
                            var name = requestGet.result.name;
                            var id = requestGet.result.id;
                            //Armazenar nome do usuário e id_Actor na sessão 
                            sessionStorage.setItem("authorization", true);
                            sessionStorage.setItem("id_actor", id);
                            sessionStorage.setItem("name_actor", name);
                        } else {
                            sessionStorage.setItem("authorization", false);
                        }

                    } else {
                        //Usuário Não encontrado
                        sessionStorage.setItem("authorization", false);
                    }

                    //Chama o método callBack
                    callBack();
                }

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        } else {
            //Usuário ou Senha nulos
            sessionStorage.setItem("authorization", false);
            //Chama o método callBack
            callBack();
        }
    }

    //===================
    this.getCobject = function(cobject_id, callBack) {
        if (self.isset(cobject_id)) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
            }
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    window.alert("Database error: " + event.target.errorCode);
                }
                //Tudo ok Então Busca O Cobject
                var cobjectStore = db.transaction("cobject").objectStore("cobject");
                var requestGet = cobjectStore.get(cobject_id);
                requestGet.onerror = function(event) {
                    // Tratar erro!
                }
                requestGet.onsuccess = function(event) {
                    var json_cobject = requestGet.result;
                    callBack(json_cobject);
                }

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }
    }


    //Armazenar a performance
    this.addPerformance_actor = function(data) {
        var piece_id = data.piece_id;
        var actor_id = data.actor_id;
        var final_time = data.final_time;
        var value = self.isset(data.value) ? data.value : null;
        var iscorrect = data.iscorrect;
        var group_id = self.isset(data.group_id) ? data.group_id : null;

        var data_performance_actor = {
            'piece_id': piece_id,
            'group_id': group_id,
            'actor_id': actor_id,
            'final_time': final_time,
            'value': value,
            'iscorrect': iscorrect
        };

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
            }
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    window.alert("Database error: " + event.target.errorCode);
                }
                var Performance_actorObjectStore = db.transaction("performance_actor", "readwrite").objectStore("performance_actor");
                Performance_actorObjectStore.add(data_performance_actor);
                Performance_actorObjectStore.transaction.oncomplete = function(event) {
                    console.log('Performance Salva !!!! ');
                }

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

    }


    function useDatabase(db) {
        // Esteja certo de que adicionou um evento para notificar se a página muda a versão
        // Devemos fechar o banco. Isso permite à outra página ser atualizada
        db.onversionchange = function(event) {
            db.close();
            alert("Uma nova versão desta web app está pronta. Atualiza, por favor!");
        }
    }


    this.isset = function(variable) {
        return (typeof variable !== 'undefined' && variable !== null);
    }

}