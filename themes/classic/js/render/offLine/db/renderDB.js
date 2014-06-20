// // - - - - - - - - - -  //
// CRIAR BANCO DE DADOS //
// - - - - - - - - - -  //
this.DB = function(){
    self = this;
    nameBD = "synapseDB";
    DBversion=0;
    synapseBD=null;
    db=null;
    

    this.openDB = function(alterSchema){
        // Na linha abaixo, você deve incluir os prefixos do navegador que você vai testar.
        window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
        // Não use "var indexedDB = ..." se você não está numa function.
        // Posteriormente, você pode precisar de referências de algum objeto window.IDB*:
        window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction;
        window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange;
        // (Mozilla nunca usou prefixo nesses objetos, então não precisamos window.mozIDB*)
        
        if (!window.indexedDB) {
            window.alert("Seu navegador não suporta uma versão estável do IndexedDB. Alguns recursos não estarão disponíveis.");
        }
    
        //Verificar se precisa mudar o setVersion para alterar o schema do BD
        var alterSchema = (this.isset(alterSchema) && alterSchema);
        //Se ainda não atualizou o DBversion, então abre o banco na sua versão atual
        if(DBversion == 0){
            synapseBD = window.indexedDB.open(nameBD);
        }else{
            // Atualizou o DBversion e entrou na recursão, então cria uma nova versão do banco
             DBversion++;
             synapseBD = window.indexedDB.open(nameBD, DBversion);
        }
        synapseBD.onerror = function(event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        };
        synapseBD.onsuccess = function(event) {
             console.log("okk");
             
            db = event.target.result;
            db.onerror = function(event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                alert("Database error: " + event.target.errorCode);
            };
            
            //Verificar se já atualizou o atributo DBversion
            
            if(DBversion == 0){
                self.DBversion = db.version;
                //Só entra na recursão se alterSchema = true
                if(alterSchema){
                    //self.openDB(alterSchema);
                }
               
            }else{
                //Agora constrói o buildAllSchema
                self.buildAllSchema();
            }
                
        }
            
            
    }

this.buildAllSchema = function() {
    //Deletar DataBase : indexedDB.deleteDatabase('synapseDB');
    //Criar Schemas das tabelas
    synapseBD.onupgradeneeded = function(event){ 
        db = event.target.result;
        // cria um objectStore de ACTOR
        var objectStore = db.createObjectStore("unity", {
            keyPath: "id"
        });
        // Podemos ter nomes duplicados, então não podemos usar como índice único.
        objectStore.createIndex("nome", "nome", {
            unique: false
        });
        // Falta organization_id & father_id 
        //===========================================
        
        // cria um objectStore de ACTOR
        var objectStore = db.createObjectStore("actor", {
            keyPath: "id"
        });
        // Podemos ter nomes duplicados, então não podemos usar como índice único.
        objectStore.createIndex("nome", "nome", {
            unique: false
        });
        objectStore.createIndex("login", "login", {
            unique: true
        });
        // Falta personage_name & password
        //===============================================
        
        
        // Usando transação oncomplete para afirmar que a criação do objectStore 
        // é terminada antes de adicionar algum dado nele.
        objectStore.transaction.oncomplete = function(event) {
            window.alert('Criou os Schemas');             
        }
    }
}

// - - - - - - - - - -  //
// IMPORT PARA BANCO DE DADOS //
// - - - - - - - - - -  //

this.importUserRender = function(){
    
    //Unidade e Usuário
    var data_unity_classroom = [{
        id:2,
        unity_id:"",
        person_name:"",
        person_login:"",
        person_password:"",
        personage_name:""
    }];

    var data_actor = [{
        id:2,
        unity_id:"",
        person_name:"",
        person_login:"",
        person_password:"",
        personage_name:""
    }];
    //======================================
    //Blocos de Atividades para cada Disciplina
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];

    var data_cobject_cobjectBlock = [{
        id:2,
        cobject_id:"",
        cobject_block_id:""
    }];

    //Cobjets
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];
    var data_cobjectBlock = [{
        id:2,
        name:"",
        discipline_id:""
    }];


    


    //importando person
    var ActorObjectStore = db.transaction("actor", "readwrite").objectStore("actor");
    for (var i in data_actor) {
        ActorObjectStore.add(data_actor[i]);
    }
    // Usando transação oncomplete para afirmar que a criação do objectStore 
    //Importar Unity
    
    
    //Importar Actor
    ActorObjectStore.transaction.oncomplete = function(event) {
        console.log("Actors IMPORTED!");
        
   
    }
}


this.isset = function (variable){
    return (variable !== undefined && variable !== null);
}

}