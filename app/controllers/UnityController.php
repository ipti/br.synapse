<?php

class UnityController extends Controller
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
				'actions'=>array('index','view','create','update', 'loadOrg'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        
        public function actionLoadOrg() 
        {
            if( isset($_POST['totalUnity']) ) {
                $totalUnitys = $_POST['totalUnity'];
                $orgs = Organization::model()->findAll(array( 
                    'condition' => 'father_id = :totalUnitys+1',
                    'params' => array(':totalUnitys' => $totalUnitys),
                    ));
                $num_orgs = count($orgs);
                $str = '';
                for($i=0; $i < $num_orgs; $i++ ) {
                    $str .= "<option value ='". $orgs[$i]->id ."'>" . $orgs[$i]->name . "</option>";
                }
                 echo $str;
            }
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

        // Salvar relações com Todos os seus 'Pais' na Unity_Tree
       public function saveAncient($IDunity_child, $OrgIDunity_child, 
                                    $IDunity_father, $OrgIDunity_father) {
            if(isset($IDunity_child) && isset($OrgIDunity_child)) {
                $modelUTree = new UnityTree;
                $modelUTree->primay_unity_id = $IDunity_father;   //Unity_Father
                $modelUTree->primary_organization_id = $OrgIDunity_father ; //Unity_Father
                $modelUTree->secondary_unity_id = $IDunity_child; //Unity_Child
                $modelUTree->secondary_organization_id = $OrgIDunity_child; //Unity_Child
                 if($modelUTree->save()) {
                    if(isset($IDunity_father) && $IDunity_father > 0 ) {
                        //Salvar os Próximos Pais
                        $this_father = Unity::model()->findByAttributes(array('id' => $IDunity_father )); 
                        $IDnew_father = $this_father->father_id  ; // Pai do Pai
                        $new_Org_father = null;
                        if(isset($IDnew_father) && $IDnew_father > 0) {
                            $new_father = Unity::model()->findByAttributes(array('id'=>$IDnew_father));
                            $new_Org_father = $new_father->organization_id;
                           }        
                return $this->saveAncient($IDunity_child, $OrgIDunity_child,
                $IDnew_father, $new_Org_father );
                    }
                    
                    return true;
                 }else{
                    return false;
                 }
            }
            
        }
        
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Unity;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Unity']))
		{
			$model->attributes=$_POST['Unity'];
			if($model->save()){
                            //Inserir na Árvore
                            $IDunity_child = $model->id;
                            $OrgIDunity_child = $model->organization_id;
                            $IDunity_father =  $model->father_id;
                            if(isset($IDunity_father) && $IDunity_father > 0) {
                               $father = Unity::model()->findByAttributes(array('id' => $IDunity_father )); 
                               $OrgIDunity_father = $father->organization_id;
                                // $OrgIDunity_father = $model->fatherID->organizationID;
                            }
                            $ancients = $this->saveAncient($IDunity_child, $OrgIDunity_child, 
                                    $IDunity_father, $OrgIDunity_father);
                            
                            //=====================================================
                                Yii::app()->user->setFlash('success', Yii::t('default', 'Unity Created Successful:'));
				$this->redirect(array('index'));
                               }
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Unity']))
		{
			$model->attributes=$_POST['Unity'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ID));
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Unity',
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
		$model=new Unity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unity']))
			$model->attributes=$_GET['Unity'];

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
		$model=Unity::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='unity-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
