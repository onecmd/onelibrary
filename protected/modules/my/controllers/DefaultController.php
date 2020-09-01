<?php 

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/layout_index';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//Header("Location:".$this->createUrl("passwd"));
		$this->render('index');
	}
	public function actionPasswd()
	{
		
		$this->render('passwd');
	}
	
	public function actionChangepasswd()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render('passwd',array('message'=>'Please login at first!!!'));
			return;
		}
		else if(!isset($_POST['password']) || !isset($_POST['password_repeat']))
		{
			$this->render('passwd', array("message"=> "Parameter not right! Please try again from webpage!"));
		}
		else if($_POST['password'] != $_POST['password_repeat'])
		{
			$this->render('passwd', array("message"=> "The two password inputed not same, please try again!!!"));
		}
		else 
		{
			$nsnId = RoleUtil::getUser()->nsn_id;
			$model = Users::model()->findByAttributes(array('nsn_id'=>$nsnId));
			$model->password = md5($_POST['password']);
			if($model->save()==true)
			{
				$this->render('passwd',array('message'=>'Password changed successful!!!'));
			}
			else 
			{
				$this->render('passwd',array('message'=>'Password changed failed!!!'));
			}
		}
	}
	/**
	 * Lists all models.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionTestMail(){
		sendEmail22();
	}	
}