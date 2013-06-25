<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $layout = '//layouts/fullmenu';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('login','logout'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update','logout'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
//    public function actionLogin() {
//        $this->layout = 'full';
//        $model = new LoginForm;
//
//        // if it is ajax validation request
//        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//
//        // collect user input data
//        if (isset($_POST['LoginForm'])) {
//            $model->attributes = $_POST['LoginForm'];
//            // validate user input and redirect to the previous page if valid
//            if ($model->validate() && $model->login()){
//                if(isset(Yii::app()->user->returnUrl)){
//                    $this->redirect(Yii::app()->user->returnUrl);
//                }else{
//                    $this->redirect(Yii::app()->baseUrl.'/site/index');
//                }
//            }
//                
//                
//        }
//        // display the login form
//        $this->render('login', array('model' => $model));
//    }
    
    
    
    
    //=====Novo Login========
    
     public function actionLogin() {
         $this->layout = 'full';
        $loginmodel = new LoginForm;
     
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        if (isset($_POST["act"])) {
            // Autor Selecionado
            $actor = Actor::model()->findByAttributes(array('ID' => $_POST["act"]));
            $idActor = $actor->ID;
            $nome_personage = $actor->personage->name;
//$personageIdActor = $actor->personageID;
            $unityIdActor = $actor->unityID;
//$activatedDateActor = $actor->activatedDate;
//$desactivatedDateActor = $actor->desactivatedDate;                  
// $personage = Personage::model()->findByAttributes(array('ID'=>$personageIdActor));
//$namePersonage = $personage->name;     
          if(isset($nome_personage) && $nome_personage == "Tutor" ) {
              Yii::app()->session['personage'] = $nome_personage;
              Yii::app()->session['unityIdActor'] = $unityIdActor;
           }else{
               Yii::app()->session['personage'] = "Other";
               Yii::app()->session['idActor'] = $idActor;
           }
           
           //Redirecionamento Após Login e Seleção do Personagem
                if(isset(Yii::app()->user->returnUrl)){
                    $this->redirect(Yii::app()->user->returnUrl);
                }else{
                    $this->redirect(Yii::app()->baseUrl.'/site/index');
                }
           
        } else if (isset($_POST['LoginForm'])) {
            $loginmodel->attributes = $_POST['LoginForm'];
            $autenticar = $loginmodel->authenticate();
            $identity = $loginmodel->get_identity(); //$itentity = variável local
            if ($autenticar) {
                $idPerson = $identity->getId();
//Somente atores Ativos
                $actor = Actor::model()->findAllByAttributes(array('personID' => $idPerson), 
                        "desactivatedDate >" . time() . " OR " . "desactivatedDate is NULL OR desactivatedDate = 0 ");
                if (count($actor) > 0) {
//Método login() do CWebUser
                    Yii::app()->user->login($identity);
 
                    $html = "
                   <html>
                      <head>
                      <title> Selecionar Personagem </title>
                       
                     </head>
                   <body>
                   <form method=\"post\" action=\"/site/login\">
                   <select id=\"act\" name=\"act\">";
                    echo "Bem Vindo : " . $identity->getState('name');
//Seleciona um dos personagem de um Person
                    for ($i = 0; count($actor) > $i; $i++) {
                        $tempPersonage = Personage::model()->findByAttributes(array('ID' => $actor[$i]->personageID));
                        $html .= "<option value='".$actor[$i]->ID."'>$tempPersonage->name</option>";
                    }
                    $html .= "</select>
                     <input type='submit' value='Next' id='selectActor'/>
                    </form>";
                    $html.= " </body>
                              </html>";
                    echo $html;
                } else {
                    echo "Não há Atores Ativos para este Usuário !";
                }
            } else {
                echo $identity->errorMessage;
            }

            exit;
        }

//            $name_person = Yii::app()->user->getState('name');
//         if( (!Yii::app()->user->isGuest) && isset($name_person) ) {
//             //Está logado no Render-Login --> To be continued
//             echo "Bem Vindo : " . $name_person;
//             echo "<br> <a href=\"/render/logout\"> Click aqui para fazer logout</a> ";
//         }else{
//             //Não está logado no Render-Login
//             $this->render('login', array('model'=>$loginmodel)); 
//         }

        $this->render('login', array('model' => $loginmodel));
    }
    
    
    //==================================
    
    
    
    
    

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}