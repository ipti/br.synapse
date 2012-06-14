<?php

class ActScriptController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update','loadcontentparent','loadcontents'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ActScript;
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/assets/js/',array('file'=>'common.js')),CClientScript::POS_END);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ActScript'])) {
            $model->attributes = $_POST['ActScript'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('default', 'ActScript Created Successful:'));
                foreach ($_POST['ActScriptContentIn'] as $ci) {
                    $content = new ActScriptContent();
                    $content->scriptID = $model->ID;
                    $content->contentID = $ci;
                    $content->status = 'in';
                    $content->save();
                }
                foreach ($_POST['ActScriptContentOut'] as $ci) {
                    $content = new ActScriptContent();
                    $content->scriptID = $model->ID;
                    $content->contentID = $ci;
                    $content->status = 'out';
                    $content->save();
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
        $contentsin = ActScriptContent::model()->findAllByAttributes(array('scriptID' => $id,'status'=>'in'));
        $contentsout = ActScriptContent::model()->findAllByAttributes(array('scriptID' => $id,'status'=>'out'));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ActScript'])) {
            $model->attributes = $_POST['ActScript'];
            if ($model->save()){
                $icontentsout = $icontentsin = array();
                foreach ($contentsin as $in) {
                    $icontentsin[] = $in->contentID;
                }
                foreach ($contentsout as $out) {
                    $icontentsout[] = $out->contentID;
                }
                if (isset($_POST['ActScriptContentIn'])) {
                    $removed = array_diff($icontentsin, $_POST['ActScriptContentIn']);
                    ActScriptContent::model()->deleteAllByAttributes(array('status'=>'in','scriptID' => $model->ID, 'contentID' => array_values($removed)));
                    $insert = array_diff($_POST['ActScriptContentIn'], $icontentsin);
                    if (isset($insert)) {
                        foreach ($insert as $in) {
                            $d = new ActScriptContent();
                            $d->scriptID = $model->ID;
                            $d->contentID = $in;
                            $d->status = 'in';
                            $d->save();
                        }
                    }
                } else {
                    ActScriptContent::model()->deleteAllByAttributes(array('scriptID' => $model->ID,'status'=>'in'));
                }
                if (isset($_POST['ActScriptContentOut'])) {
                    $removed = array_diff($icontentsout, $_POST['ActScriptContentOut']);
                    ActScriptContent::model()->deleteAllByAttributes(array('status'=>'out','scriptID' => $model->ID, 'contentID' => array_values($removed)));
                    $insert = array_diff($_POST['ActScriptContentOut'], $icontentsout);
                    if (isset($insert)) {
                        foreach ($insert as $in) {
                            $d = new ActScriptContent();
                            $d->scriptID = $model->ID;
                            $d->contentID = $in;
                            $d->status = 'out';
                            $d->save();
                        }
                    }
                } else {
                    ActScriptContent::model()->deleteAllByAttributes(array('scriptID' => $model->ID,'status'=>'out'));
                }
                
                
                
               // $this->redirect(array('view', 'id' => $model->ID));
            }
        }
        $contentsin = ActScriptContent::model()->findAllByAttributes(array('scriptID' => $id,'status'=>'in'));
        $contentsout = ActScriptContent::model()->findAllByAttributes(array('scriptID' => $id,'status'=>'out'));
        Yii::app()->clientScript->registerScript('updateSelect',"updateLoad('actScript');",CClientScript::POS_LOAD);
        $this->render('update', array(
            'model' => $model,
            'contentsin'=>$contentsin,
            'contentsout'=>$contentsout
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
        $dataProvider = new CActiveDataProvider('ActScript',
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
        $model = new ActScript('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ActScript']))
            $model->attributes = $_GET['ActScript'];

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
        $model = ActScript::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'act-script-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoadContentParent() {
        $data = ActContent::model()->findAllByAttributes(array('contentParent'=>NULL,'disciplineID' => $_POST['ActScript']['disciplineID']));
        $data = CHtml::listData($data, 'ID', 'description');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }
    
    public function actionLoadContents() {
        $data = ActContent::model()->findAllByAttributes(array('contentParent'=>$_POST['ActScript']['contentParentID'],'disciplineID' => $_POST['ActScript']['disciplineID']));
        $data = CHtml::listData($data, 'ID', 'description');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

}
