<?php

class UserclassController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'loadmatrix'),
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
        $d = UserclassMatrix::model()->findAllByAttributes(array('classID' => $id));
        $listItens = '';
        foreach ($d as $i) {
            $listItens.= '[' . $i->matrix->name . ']';
        }
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'listItens'=>$listItens
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/assets/js/',array('file'=>'common.js')),CClientScript::POS_END);
        $model = new Userclass;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Userclass'])) {
            $model->attributes = $_POST['Userclass'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('default', 'Userclass Created Successful:'));
                foreach ($_POST['UserclassMatrix'] as $item) {
                    $matrix = new UserclassMatrix();
                    $matrix->matrixID = (int) $item;
                    $matrix->classID = (int) $model->ID;
                    $matrix->save();
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
        $matrixes = UserclassMatrix::model()->findAllByAttributes(array('classID' => $id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Userclass'])) {
            $model->attributes = $_POST['Userclass'];
            if ($model->save()) {
                $itens = array();
                foreach ($matrixes as $matrix) {
                    $itens[] = $matrix->matrix->ID;
                }
                if (isset($_POST['UserclassMatrix'])) {
                    $removed = array_diff($itens, $_POST['UserclassMatrix']);
                    UserclassMatrix::model()->deleteAllByAttributes(array('classID' => $model->ID, 'matrixID' => array_values($removed)));
                    $insert = array_diff($_POST['UserclassMatrix'], $itens);
                    if (isset($insert)) {
                        foreach ($insert as $in) {
                            $d = new UserclassMatrix();
                            $d->classID = $model->ID;
                            $d->matrixID = $in;
                            $d->save();
                        }
                    }
                } else {
                    UserclassMatrix::model()->deleteAllByAttributes(array('classID' => $model->ID));
                }

                //$this->redirect(array('view', 'id' => $model->ID));
            }
        }
        $matrixes = UserclassMatrix::model()->findAllByAttributes(array('classID' => $id));
        $this->render('update', array(
            'model' => $model,
            'matrixes' => $matrixes,
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
        $dataProvider = new CActiveDataProvider('Userclass',
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
        $model = new Userclass('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Userclass']))
            $model->attributes = $_GET['Userclass'];

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
        $model = Userclass::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'userclass-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoadMatrix() {
        $data = ActMatrix::model()->findAllByAttributes(array('degreeID' => (int) $_POST['Userclass']['degreeID'], 'disciplineID' => (int) $_POST['disciplineID']));
        $data = CHtml::listData($data, 'ID', 'name');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

}
