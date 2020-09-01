<?php 

class MyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/layout_index';
	
	private $message="";

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
	
	public function actionAll()
	{
		$currentPage = 1;
		$pageSize = 20;
		if(isset($_GET['page']))
		{
			$currentPage = intval($_GET['page']);
		}		
       
		$dataProvider=new CActiveDataProvider('Books', array(
			'criteria'=>array(
				'order'=>'add_time DESC',
				//'condition'=>'shop_id=:shop_id and book_status<2', // book_status:0等待发货；1配送途中；2已收货；3已评价；4已取消；5等待预订确认
				//'params'=>array(':shop_id'=>Yii::app()->session['shop']->shop_id),
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
		
		$booklist = $dataProvider->getData();
		$booyTypeArray = $this->getRsBookTypeAsArray();
		
		$this->renderPartial('all',array(
			'ResultBooks'=>$booklist,
			'page'=>$page,
			'BookTypeArray'=>$booyTypeArray,
		));
	}
	
	public function actionInhand()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render('editok', array("message"=> "Please login at first!"));
			return;
		}
		$booklist = Books::model()->findAllByAttributes(array("holder_nsn_id"=>RoleUtil::getUser()->nsn_id, "status"=>"1"));
		
		$criteria = new CDbCriteria;  
		$criteria->condition ='user_id=:user_id and overdue_fine>0 and (fine_is_paid=0 or fine_is_paid=2)';
		$criteria->params[':user_id']=RoleUtil::getUser()->nsn_id;    
		$finelist = BooksHistory::model()->findAll($criteria);
		//$finelist = BooksHistory::model()->findAllByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id, "fine_is_paid"=>"0"));
		
		$totalScore = $this->getUserTotalScore(RoleUtil::getUser()->nsn_id);
		
		$userModel = Users::model()->findByAttributes(array("nsn_id"=>RoleUtil::getUser()->nsn_id));
		
		$this->renderPartial('inhand',array(
			'ResultBooks'=>$booklist,
			'ResultFineList'=>$finelist,
			'totalScore'=>$totalScore,
			'message'=>$this->message,
			'UserModel'=>$userModel,
		));
	}
	
	public function getUserTotalScore($userId){
		
		$sql = "select sum(scores) total from tb_users_score_history where user_id=:user_id";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":user_id",$userId);
		$scoreModel=$command->queryRow();  

		$totalScore = $scoreModel["total"];
		$totalScore = $totalScore == ""  ? "0" : $totalScore;
		
		return $totalScore;
	}
	
	public function actionMydonate()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render('editok', array("message"=> "Please login at first!"));
			return;
		}
		$booklist = Books::model()->findAllByAttributes(array("donate_nsn_id"=>RoleUtil::getUser()->nsn_id));
		
		$this->renderPartial('mydonate',array(
			'ResultBooks'=>$booklist,
		));
	}
	
	public function actionHistory()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render(Yii::app()->createUrl('default/login'));
			return;
		}
		$currentPage = 0;
		$pageSize = 20;
		if(isset($_GET['page']))
		{
			$currentPage = intval($_GET['page']);
		}		
       
		$dataProvider=new CActiveDataProvider('BooksHistory', array(
			'criteria'=>array(
				'order'=>'borrow_time DESC',
				'condition'=>'user_id=:user_id', 
				'params'=>array(':user_id'=>RoleUtil::getUser()->nsn_id),
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
		
		$booklist = $dataProvider->getData();
		
		$this->renderPartial('history',array(
			'ResultBooks'=>$booklist,
			'page'=>$page,
			'pageSize'=>$pageSize,
		));
	}
	
	public function actionWaiting()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render(Yii::app()->createUrl('default/login'));
			return;
		}
		$currentPage = 0;
		$pageSize = 20;
		if(isset($_GET['page']))
		{
			$currentPage = intval($_GET['page']);
		}		
       
		$dataProvider=new CActiveDataProvider('BooksWaiting', array(
			'criteria'=>array(
				'order'=>'status desc, id desc',
				'condition'=>'user_id=:user_id and (status=0 or status=1)', 
				'params'=>array(':user_id'=>RoleUtil::getUser()->nsn_id),
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
		
		$ResultWaitings = $dataProvider->getData();
		
		$this->renderPartial('waiting',array(
			'ResultWaitings'=>$ResultWaitings,
			'page'=>$page,
			'pageSize'=>$pageSize,
		));
	}
		
	public function actionLikebooks()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render(Yii::app()->createUrl('default/login'));
		}
		else 
		{
			$likes = BooksLikes::model()->findAllByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id),new CDbCriteria(array("order"=>"add_time desc")));
			$this->renderPartial('likebooks', array("LikeBooks"=> $likes));
		}
	}
	
	public function actionNotifyPaid(){
		$this->message="Request success!";
		try 
		{
			if(!isset($_REQUEST['id']))
			{
				$this->message= "Failed, please retry.";
			}
			else
			{
				$model = BooksHistory::model()->findByAttributes(array("id"=>$_REQUEST['id'], "user_id"=>RoleUtil::getUser()->nsn_id));
				if(!isset($model)){
					$this->message= "Failed, Record not found!";
				}
				else
				{
					$model->fine_is_paid=2;
					$model->fine_paid_method=0;
					$model->paid_scores=0;
					$model->fine_paid_time=getCurTime();
					
					if($model->save()){
						
						// send mail to finance:
						$content="Hi , <br>".$model->user_name."(ID:".$model->user_id.") 现金支付了超期还款:"
							."<br><br>Book: ".$model->book_name
							."<br>Pay password: ".$model->pay_password
							."<br>支付方式: 现金支付宝"
							."<br><br>请确认和在管理页面更新信息。<br><br>";
							
						$emailStr = "hebihong@163.com";				
						sendEmail($emailStr, $content, $content, "notify_paid", false);
				
						$this->message= "Notify success";
					}
					else{
						$this->message= "Error, Record not found!";
					}
				}
			}
		}
		catch(Exception $e)
		{
			$this->message="Failed!".$e->getMessage();
		}	
		
		$this->actionInhand();
	}	
	
	public function actionPayByScore(){
		$this->message="Request success!";
		try 
		{
			if(!isset($_REQUEST['id']))
			{
				$this->message= "Failed, please retry.";
			}
			else
			{
				$model = BooksHistory::model()->findByAttributes(array("id"=>$_REQUEST['id'], "user_id"=>RoleUtil::getUser()->nsn_id));
				if(!isset($model)){
					$this->message= "Failed, Record not found!";
				}
				else
				{
					$totalScore = $this->getUserTotalScore($model->user_id);
					$needScore = $model->overdue_fine*100;
					if($totalScore < $needScore){
						$this->message= "Failed, Score not enough!";
					}
					else{
					
						$model->fine_is_paid=1;
						$model->fine_paid_method=1;
						$model->paid_scores=$needScore;
						$model->fine_paid_time=getCurTime();
						
						$scoreAction = "缴纳图书超期罚金: ".$model->book_name.", Return date: ".longDate($model->actual_return_time)." Fine: ￥".$model->overdue_fine;
						addUserScore($model->user_id, $scoreAction, -$needScore, "System");
						
						if($model->save()){
							
							// send mail to finance:
							/*
							$content="Hi , <br>".$model->user_name."(ID:".$model->user_id.") 积分支付了超期还款:"
								."<br><br>Book: ".$model->book_name
								."<br>Pay password: ".$model->pay_password
								."<br>支付方式: ".$model->paid_scores." 积分"
								."<br><br>";
								
							$emailStr = "hebihong@163.com";				
							sendEmail($emailStr, $content, $content, "notify_paid", false);
							*/
					
							$this->message= "Paid success";
						}
						else{
							$this->message= "Error, Record not found!";
						}
					}
				}
			}
		}
		catch(Exception $e)
		{
			$this->message="Failed!".$e->getMessage();
		}	
		
		$this->actionInhand();
	}	

	
	public function actionScore()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render(Yii::app()->createUrl('default/login'));
			return;
		}
		$currentPage = 0;
		$pageSize = 20;
		if(isset($_GET['page']))
		{
			$currentPage = intval($_GET['page']);
		}		
       
		$dataProvider=new CActiveDataProvider('UsersScoreHistory', array(
			'criteria'=>array(
				'order'=>'id desc',
				'condition'=>'user_id=:user_id and is_deleted=0', 
				'params'=>array(':user_id'=>RoleUtil::getUser()->nsn_id),
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
		
		$ResultRecords = $dataProvider->getData();
		
		$totalScore = $this->getUserTotalScore(RoleUtil::getUser()->nsn_id);
		$this->renderPartial('score',array(
			'ResultRecords'=>$ResultRecords,
			'page'=>$page,
			'pageSize'=>$pageSize,
			'totalScore'=>$totalScore,
			'message'=>$this->message,
		));
	}	
	
	public function actionScrum()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render(Yii::app()->createUrl('default/login'));
			return;
		}
		$currentPage = 0;
		$pageSize = 20;
		if(isset($_GET['page']))
		{
			$currentPage = intval($_GET['page']);
		}		
       
		$dataProvider=new CActiveDataProvider('BooksWaiting', array(
			'criteria'=>array(
				'order'=>'status desc, id desc',
				'condition'=>'user_id=:user_id and (status=0 or status=1)', 
				'params'=>array(':user_id'=>RoleUtil::getUser()->nsn_id),
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
		
		$ResultWaitings = $dataProvider->getData();
		
		$this->renderPartial('scrum',array(
			'ResultWaitings'=>$ResultWaitings,
			'page'=>$page,
			'pageSize'=>$pageSize,
		));
	}

	public function actionUpdateUserSeat(){
		$this->message="Update success!";
		try 
		{
			if(!isset($_REQUEST['seat']))
			{
				$this->message= "Failed, seat not set value.";
			}
			else
			{
				$user = Users::model()->findByAttributes(array("nsn_id"=>RoleUtil::getUser()->nsn_id));
				if(!isset($user)){
					$this->message= "Failed, User not found!";
				}
				else
				{
					$updateAttributes = array(
							'seat'=>$_REQUEST['seat'], 
						);
					$count = Users::model()->updateByPk($user->id, $updateAttributes);
					$this->message="Update success!";
				}
			}
		}
		catch(Exception $e)
		{
			$this->message="Failed!".$e->getMessage();
		}	
		
		$this->actionInhand();
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