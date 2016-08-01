<?php

class CobjectCobjectblockController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='fullmenu';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete', 'admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	/*
	 * Verificar se a rela��o Bloco+Atividade j� existe
	 *
	 */

	private function hasCobjectInDB($cobject_id){
		return Cobject::model()->findAllByPk($cobject_id) != null;
	}

	 private function hasCobjectInBlock($cobject_block_id, $cobject_id){
			$cobjectCobjectblock = CobjectCobjectblock::model()->findAllByAttributes(array('cobject_block_id' => $cobject_block_id, 'cobject_id' => $cobject_id));
		    return count($cobjectCobjectblock) > 0;
	 }


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){

		$model=new CobjectCobjectblock;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if($_POST){
			$cobjectIDs = $_POST['CobjectCobjectblock']['cobject_id'];
			$pattern = '/\d+/';
			preg_match_all ($pattern, $cobjectIDs, $matches);
			$cobject_id_array = $matches[0];
			$blockID = $_POST['CobjectCobjectblock']['cobject_block_id'];
			$msgsArray = array();
			$i = 0;
			$msgsArray[$i]['cobjectID'] = "Cobject ID";
			$msgsArray[$i]['msg'] = "Mensagem";
			$i = 1;

			foreach ($cobject_id_array AS $co) {
				$msgsArray[$i]['cobjectID'] = $co;
				$model = new CobjectCobjectblock;
				$cobject = array('cobject_id' => $co, 'cobject_block_id' => $blockID);
				$model->attributes = $cobject;
				//Somente salva se N�o existir a rela��o bloco+atividade
				if(!$this->hasCobjectInBlock($model->cobject_block_id, $model->cobject_id)) {
					if($this->hasCobjectInDB($model->cobject_id)){
						//salvar
						if ($model->save()) {
							$msgsArray[$i]['msg'] = "Salvo com Sucesso!";
						}
					}else{
						$msgsArray[$i]['msg'] = "Nao Encontrado!";
					}
				}else{
					//está no bloco. Existe Cobject!
					//Emite uma mensagem, indicando que a rela��o j� existe
					$msgsArray[$i]['msg'] = "A Atividade ja esta relacionada ao Bloco!";
				}
				$i++;
			}
			$time = time();
			$nameFile = "CobjectBlocks_import_Messages_$time.csv";
			$fp = fopen("exports/$nameFile", 'w');
			ignore_user_abort(true);
			foreach ($msgsArray as $message) {
				fputcsv($fp, $message);
			}
			fclose($fp);

			//unlink($fp);

			if (file_exists("exports/$nameFile")) {
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Disposition: attachment;filename=$nameFile");
				header("Content-Transfer-Encoding: binary ");
				//header("location:../exports/CobjectBlocks_import_Messages.csv");
				readfile("exports/$nameFile");
			}



		}else{
			$this->render('create',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CobjectCobjectblock']))
		{
			$model->attributes=$_POST['CobjectCobjectblock'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            
//		if(Yii::app()->request->isPostRequest)
//		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CobjectCobjectblock',
                array('pagination' => array(
                        'pageSize' => 12,
                        )));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CobjectCobjectblock('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CobjectCobjectblock']))
			$model->attributes=$_GET['CobjectCobjectblock'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CobjectCobjectblock::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cobject-cobjectblock-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
