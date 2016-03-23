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
                'actions' => array('delete','index', 'view', 'create', 'update', 'loadcontentparent', 'loadcontents', 'importScriptsFromCSVFile'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin'),
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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/resources/js/', array('file' => 'common.js')), CClientScript::POS_END);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ActScript'])) {
            $model->attributes = $_POST['ActScript'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('default', 'ActScript Created Successful:'));
                if (isset($_POST['ActScriptContentIn'])) {
                    foreach ($_POST['ActScriptContentIn'] as $ci) {
                        $content = new ActScriptContent();
                        $content->script_id = $model->id;
                        $content->content_id = $ci;
                        $content->status = 'in';
                        $content->save();
                    }
                }
                if (isset($_POST['ActScriptContentOut'])) {
                    foreach ($_POST['ActScriptContentOut'] as $ci) {
                        $content = new ActScriptContent();
                        $content->script_id = $model->id;
                        $content->content_id = $ci;
                        $content->status = 'out';
                        $content->save();
                    }
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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl('/resources/js/', array('file' => 'common.js')), CClientScript::POS_END);
        $model = $this->loadModel($id);
        $contentsin = ActScriptContent::model()->findAllByAttributes(array('script_id' => $id, 'status' => 'in'));
        $contentsout = ActScriptContent::model()->findAllByAttributes(array('script_id' => $id, 'status' => 'out'));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ActScript'])) {
            $model->attributes = $_POST['ActScript'];
            if ($model->save()) {
                $icontentsout = $icontentsin = array();
                foreach ($contentsin as $in) {
                    $icontentsin[] = $in->content_id;
                }
                foreach ($contentsout as $out) {
                    $icontentsout[] = $out->content_id;
                }
                if (isset($_POST['ActScriptContentIn'])) {
                    $removed = array_diff($icontentsin, $_POST['ActScriptContentIn']);
                    ActScriptContent::model()->deleteAllByAttributes(array('status' => 'in', 'script_id' => $model->id, 'content_id' => array_values($removed)));
                    $insert = array_diff($_POST['ActScriptContentIn'], $icontentsin);
                    if (isset($insert)) {
                        foreach ($insert as $in) {
                            $d = new ActScriptContent();
                            $d->script_id = $model->ID;
                            $d->content_id = $in;
                            $d->status = 'in';
                            $d->save();
                        }
                    }
                } else {
                    ActScriptContent::model()->deleteAllByAttributes(array('script_id' => $model->id, 'status' => 'in'));
                }
                if (isset($_POST['ActScriptContentOut'])) {
                    $removed = array_diff($icontentsout, $_POST['ActScriptContentOut']);
                    ActScriptContent::model()->deleteAllByAttributes(array('status' => 'out', 'script_id' => $model->id, 'content_id' => array_values($removed)));
                    $insert = array_diff($_POST['ActScriptContentOut'], $icontentsout);
                    if (isset($insert)) {
                        foreach ($insert as $in) {
                            $d = new ActScriptContent();
                            $d->script_id = $model->id;
                            $d->content_id = $in;
                            $d->status = 'out';
                            $d->save();
                        }
                    }
                } else {
                    ActScriptContent::model()->deleteAllByAttributes(array('script_id' => $model->id, 'status' => 'out'));
                }



                // $this->redirect(array('view', 'id' => $model->ID));
            }
        }
        $contentsin = ActScriptContent::model()->findAllByAttributes(array('script_id' => $id, 'status' => 'in'));
        $contentsout = ActScriptContent::model()->findAllByAttributes(array('script_id' => $id, 'status' => 'out'));
        Yii::app()->clientScript->registerScript('updateSelect', "updateLoad('actScript');", CClientScript::POS_LOAD);
        $this->render('update', array(
            'model' => $model,
            'contentsin' => $contentsin,
            'contentsout' => $contentsout
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
        $data = ActContent::model()->findAllByAttributes(array('discipline_id' => $_POST['ActScript']['discipline_id']), array('order' => 'description'));
        $data = CHtml::listData($data, 'id', 'description');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    public function actionLoadContents() {
        $data = ActContent::model()->findAllByAttributes(array('discipline_id' => $_POST['ActScript']['discipline_id']), array('order' => 'description'));
        $data = CHtml::listData($data, 'id', 'description');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    public function actionImportScriptsFromCSVFile(){
        if (isset($_FILES['fileCsv'])) {
            $tempName = $_FILES['fileCsv']['tmp_name'];
            // move_uploaded_file($tempNamename, Yii::app()->theme->basePath . '/backups/backup_peformances/');
            $fileCsv = fopen($tempName, "r") or die("Unable to open file!");
            $stringCsv = fread($fileCsv, filesize($tempName));
            //Fecha o Arquivo
            fclose($fileCsv);
            $imported = false;
            if (isset($stringCsv)) {
                $rows = explode("\n",$stringCsv);
                $numRows = count($rows);
                $count = 0;
                while($count < $numRows){
                    $count++;
                    $currentRow = $rows[$count-1];
                    //Regex para realizar a divisão de colunas por ',' com exeção de vírgulas dentro do conteúdo de um campo.
                    $cols = preg_split('/(?:(?!(".*)),(?!(.*")))/', $currentRow);
                    //$cols = preg_split('/,/', $currentRow);
                    var_dump($cols);
                    echo "<br><br>";

                }

                exit();

                $strSqlPerformInserts = "INSERT INTO `peformance_actor`"
                    . "(`actor_id`, `piece_id`, `group_id`, `final_time`, `iscorrect`, `value` ) VALUES";
                $totalPeformances = count($peformances);
                foreach ($peformances as $idx => $peform):
                    $strSqlPerformInserts.='( "';
                    $strSqlPerformInserts.= $peform->actor_id . '", "' . $peform->piece_id
                        . '", "' . $peform->group_id . '", "' . $peform->final_time
                        . '", "' . $peform->iscorrect . '", "' . $peform->value;
                    $strSqlPerformInserts.='" )';
                    if ($idx < $totalPeformances - 1) {
                        $strSqlPerformInserts.=", ";
                    }

                endforeach;

                //Executa a Query
                Yii::app()->db->createCommand($strSqlPerformInserts)->query();
                $imported = true;
            }

            if ($imported) {
                $this->render("importPeformance", array('msg' => 'success'));
            } else {
                $this->render("importPeformance", array('msg' => 'error'));
            }
        } else {
            $this->render("importScriptsFromCSVFile");
        }
    }


}
