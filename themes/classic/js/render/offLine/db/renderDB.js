// - - - - - - - - - -  //
// CRIAR BANCO DE DADOS //
// - - - - - - - - - -  //
nameBD = "synapseDB";
// Abrindo o banco de dados
db;
synapseBD = indexedDB.open(nameBD,3);


this.buildAllSchema = function() {
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
    
                
    //Deletar DataBase : indexedDB.deleteDatabase('synapseDB');
                
    synapseBD.onerror = function(event) {
        alert("Você não habilitou minha web app para usar IndexedDB?!");
    };
    synapseBD.onsuccess = function(event) {
        db = event.target.result;
        db.onerror = function(event) {
            // Função genérica para tratar os erros de todos os requests desse banco!
            alert("Database error: " + event.target.errorCode);
        };
    //=============================
    };
               
    //Criar Schemas das tabelas na 1° vez que o banco é criado !!!! 
    synapseBD.onupgradeneeded = function(event){ 
        db = event.target.result;
        // cria um objectStore de Person para esse banco
        var objectStore = db.createObjectStore("person", {
            keyPath: "id"
        });
        // Podemos ter nomes duplicados, então não podemos usar como índice único.
        objectStore.createIndex("nome", "nome", {
            unique: false
        });
        objectStore.createIndex("login", "login", {
            unique: true
        });
        objectStore.createIndex("email", "email", {
            unique: false
        });
        //===============================================
        // Usando transação oncomplete para afirmar que a criação do objectStore 
        // é terminada antes de adicionar algum dado nele.
                       
        objectStore.transaction.oncomplete = function(event) {
        
                            
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
    var PersonObjectStore = db.transaction("person", "readwrite").objectStore("person");
    for (var i in data_person) {
        PersonObjectStore.add(data_person[i]);
    }
    // Usando transação oncomplete para afirmar que a criação do objectStore 
    PersonObjectStore.transaction.oncomplete = function(event) {
        console.log("PERSON IMPORTED!");
    //Importar Personage
            
    //Importar Actor
    }
            

}