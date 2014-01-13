<?php

class ActMatrixController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'loadgoal'),
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
        $d = ActGoalMatrix::model()->findAllByAttributes(array('matrixID' => $id));
        $listItens = '';
        foreach ($d as $i) {
            $listItens.= '[' . $i->goal->name . ']';
        }
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'listItens' => $listItens
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ActMatrix;
       Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/assets/js/',array('file'=>'common.js')),CClientScript::POS_END);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['ActMatrix'])) {
            $model->attributes = $_POST['ActMatrix'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('default', 'ActMatrix Created Successful:'));
                foreach ($_POST['ActGoalMatrix'] as $item) {
                    $goal = new ActGoalMatrix();
                    $goal->goalID = (int) $item;
                    $goal->matrixID = (int) $model->ID;
                    $goal->save();
                }
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
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
        $goals = ActGoalMatrix::model()->findAllByAttributes(array('matrixID' => $id));
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (isset($_POST['ActMatrix'])) {
            $model->attributes = $_POST['ActMatrix'];
            if ($model->save()) {
                $itens = array();
                foreach ($goals as $goal) {
                    $itens[] = $goal->goalID;
                }
                if (isset($_POST['ActGoalMatrix'])) {
                    $removed = array_diff($itens, $_POST['ActGoalMatrix']);
                    ActGoalMatrix::model()->deleteAllByAttributes(array('matrixID' => $model->ID, 'goalID' => array_values($removed)));
                    $insert = array_diff($_POST['ActGoalMatrix'], $itens);
                    if (isset($insert)) {
                        foreach ($insert as $in) {
                            $d = new ActGoalMatrix();
                            $d->matrixID = $model->ID;
                            $d->goalID = $in;
                            $d->save();
                        }
                    }
                } else {
                    ActGoalMatrix::model()->deleteAllByAttributes(array('matrixID' => $model->ID));
                }
            }
        }
        $goals = ActGoalMatrix::model()->findAllByAttributes(array('matrixID' => $id));
        Yii::app()->clientScript->registerScript('updateSelect',"updateLoad('actMatrix');",CClientScript::POS_LOAD);
        $this->render('update', array(
            'model' => $model,
            'goals' => $goals,
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
        $dataProvider = new CActiveDataProvider('ActMatrix',
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
        $model = new ActMatrix('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ActMatrix']))
            $model->attributes = $_GET['ActMatrix'];

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
        $model = ActMatrix::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'act-matrix-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoadGoal() {
        $model = new ActMatrix;
        $model->attributes = $_POST['ActMatrix'];
        $data = ActGoal::model()->findAllBySql('SELECT a.ID,a.name FROM act_goal a JOIN act_degree b on(a.degreeID=b.ID) where a.disciplineID =:disciplineID and b.degreeParent=:degreeID', array(':degreeID' => $model->degreeID, ':disciplineID' => $model->disciplineID));
        $data = CHtml::listData($data, 'ID', 'name');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

}
