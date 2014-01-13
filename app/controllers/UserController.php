<?php

class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'fullmenu';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'loadclasses'),
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $classes = UserUserclass::model()->findAllByAttributes(array('userID' => $id));
        $listClass = '';
        foreach ($classes as $class) {
            $listClass.= '[' . $class->class->name . ']';
        }
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'listClass' => $listClass));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/assets/js/',array('file'=>'common.js')),CClientScript::POS_END);
        $model = new User;
        $mUserclass = new UserUserclass();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('default', 'User Created Sucessful:'));
                foreach ($_POST['UserUserclass'] as $class) {
                    $mUserclass = new UserUserclass();
                    $mUserclass->classID = (int) $class;
                    $mUserclass->userID = (int) $model->ID;
                    $mUserclass->save();
                }
                $this->redirect(array('view', 'id' => $model->ID));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'mUserclass' => $mUserclass,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/assets/js/',array('file'=>'common.js')),CClientScript::POS_END);
        $model = $this->loadModel($id);
        $classes = UserUserclass::model()->findAllByAttributes(array('userID' => $id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $classin = array();
                foreach ($classes as $value) {
                    $classin[] = $value->class->ID;
                }
                if (isset($_POST['UserUserclass'])) {
                    $removed = array_diff($classin, $_POST['UserUserclass']);
                    UserUserclass::model()->deleteAllByAttributes(array('userID' => $model->ID, 'classID' => array_values($removed)));
                    $insertd = array_diff($_POST['UserUserclass'], $classin);
                    if (isset($insertd)) {
                        foreach ($insertd as $insert) {
                            $uclass = new UserUserclass();
                            $uclass->userID = $model->ID;
                            $uclass->classID = $insert;
                            $uclass->save();
                        }
                    }
                } else {
                    UserUserclass::model()->deleteAllByAttributes(array('userID' => $model->ID));
                }
                //$this->redirect(array('view', 'id' => $model->ID));
            }
        }
        $classes = UserUserclass::model()->findAllByAttributes(array('userID' => $id));
        $this->render('update', array(
            'model' => $model,
            'classes' => $classes,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User',
                        array('pagination' => array(
                                'pageSize' => 12,
                        )));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoadClasses() {
        $data = Userclass::model()->findAllByAttributes(array('sysID' => (int) $_POST['User']['sysID']));
        $data = CHtml::listData($data, 'ID', 'name');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }
    

}
