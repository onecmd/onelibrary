<?php 

class DonateController extends Controller
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
		$this->render('index');
	}
	
	public function actionDonateList()
	{
		try 
		{
			$currentPage = 0;
			$pageSize = 15;
			if(isset($_REQUEST['page']))
			{
				$currentPage = intval($_REQUEST['page']);
			}		
			
			$dataProvider=new CActiveDataProvider('DonateBooks', array(
				'criteria'=>array(
					'order'=>'donate_time desc',
					'condition'=>'status=0 or status=1', 
					//'params'=>array(':user_id'=>RoleUtil::getUser()->nsn_id),
				),
				'pagination'=>array(
					'currentPage'=>$currentPage,
					'pageSize'=>$pageSize,
				),
			));
			
			$totalItemCount = $dataProvider->getTotalItemCount();
			$pageCount = ceil($totalItemCount/$pageSize);
			$itemCount = $dataProvider->getItemCount();
			
			$page = array(
				'totalItemCount'=>$totalItemCount,
				'pageCount'=>$pageCount,
				'itemCount'=>$itemCount,
				'currentPage'=>$currentPage,
			);
			
			$ResultDonates = $dataProvider->getData();
			
			$this->renderPartial('donateList',array(
				'ResultBooks'=>$ResultDonates,
				'page'=>$page,
				'pageSize'=>$pageSize,
			));
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"View donate list page failed!".$e->getMessage()));
		}		
	}
	
	public function actionMydonate()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		$booklist = DonateBooks::model()->findAllByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id),
		new CDbCriteria(array("order"=>"add_time DESC", 'condition'=>'status=0 or status=1', )));
		
		$this->renderPartial('mydonate',array(
			'ResultBooks'=>$booklist,
		));
	}

	public function actionNewDonate()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		$this->renderPartial('newDonate'/*,array(
			'ResultBooks'=>$booklist,
		)*/);
	}

	public function actionAddDonate()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->render('index', array("message"=> "Please login at first!"));
			return;
		}
		
		if(!isset($_POST['Books']))
		{
			$this->render('index', array("message"=>"Parameter not right!"));
		}
		else if(empty($_POST['Books']['user_id']) || empty($_POST['Books']['book_name'])){
			$this->render('index', array("message"=>"User NSN ID or Book Name not set!"));
		}
		
		try 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
	
			$model = new DonateBooks();
			$model->attributes=$_POST['Books'];
			
			// get user name and email:
			$user = Users::model()->findByAttributes(array('nsn_id'=>$model->user_id));
			if(!isset($user))
			{
				$user = loadUserFromMvnforunByNsnId($model->user_id);
			}
			if(isset($user)){
				$model->user_name = $user->user_name;
				$model->user_email = $user->email;
			}
			else{
				$model->user_name = "Anonymous";
				$model->user_email = "";
			}
				
			$model->status = 1;
			//$model->present_status = 0;
			$model->libration_id=RoleUtil::getUser()->nsn_id;
			$model->donate_time = $curtime;
			$model->present_give_time = $curtime;
			$model->add_time=$curtime;
			$model->add_ip=getClientIP();
			
			if($model->save())
			{
				$this->render("index", array("message"=>"Added successful!"));
			}
			else
			{
				$this->render('index', array("message"=>"Data added failed!, Please try again!"));
			}
		}
		catch(Exception $e)
		{
			$this->render('index', array("message"=>"Data added failed! Exception:".$e->getMessage()));
		}
	}
	public function actionReceivePresent()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->render('index', array("message"=> "Please login with libration at first!"));
			return;
		}
		if(!isset($_GET["id"]) || !isset($_GET["status"]))
		{
			$this->renderPartial('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		$this->updatePresentStatus($_GET["id"], $_GET["status"]);
	}	
	public function updatePresentStatus($id, $status)
	{
		try 
		{
			$curtime=getCurTime();
			
			$updateAttributes = array('present_status'=>$status, 'present_give_time'=>$curtime);
			DonateBooks::model()->updateByPk($id, $updateAttributes);
			
			$target=isset($_GET["target"])?$_GET["target"]:"donateList";
			$this->renderPartial('index', array("message"=>"Update successful!", "target"=>$target));
		}
		catch(Exception $e)
		{
			$this->renderPartial('index', array("message"=>"Update failed! Exception:".$e->getMessage()));
		}
		
	} 
	
	public function actionDeleteById()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->render('index', array("message"=> "Please login with libration at first!"));
			return;
		}
		if(!isset($_GET["id"]))
		{
			$this->renderPartial('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		$this->updateStatus($_GET["id"], 2);
	}	

	public function updateStatus($id, $status)
	{
		try 
		{
			$updateAttributes = array('status'=>$status);
			DonateBooks::model()->updateByPk($id, $updateAttributes);
			
			$target=isset($_GET["target"])?$_GET["target"]:"donateList";
			$this->renderPartial('index', array("message"=>"Update successful!", "target"=>$target));
		}
		catch(Exception $e)
		{
			$this->renderPartial('index', array("message"=>"Update failed! Exception:".$e->getMessage()));
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
	
}