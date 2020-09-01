<?php

class DefaultController extends Controller
{
	// // is for //views/layouts;
	// / is for modules/[modulename]/views/layouts
	public $layout='//layouts/layout_index';

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->redirect(array('library/default/index'));
		// $db = Yii::app()->db_mvnform; 
		// //$sql = "select id,title,last_modified,module,out_link from tb_news where module=:module order by last_modified desc limit 0,30;";
		// $sql = "SELECT ThreadId,PostId,ParentPostId,ForumID,ThreadID,MemberID,MemberName,PostTopic,PostLastEditDate FROM mvnforumpost m where ParentPostId=0 and MemberName='CDTU_Committee' order by PostLastEditDate desc limit 0,40;";
		// $ResultTUNews = $db->createCommand($sql)->query();

		// $sql = "SELECT id,activitytype,activitySubject,tSignupEnd,tBeginTime,tEndTime,tReturnTime, t.ThreadId  FROM mvnforumpost_activity a, mvnforumthread t where a.id=t.ActivityId order by tSignupEnd desc limit 0,30;";
		// $ResultTUActives = $db->createCommand($sql)->query();
		
		// //$sql = "select id,title,last_modified,module from tb_news where module=:module order by last_modified desc limit 0,13;";
		// //$ResultClubsNews = $db->createCommand($sql)->query(array(":module"=>"club"));
		
		//  $this->render('index', array("ResultTUNews"=>$ResultTUNews, "ResultTUActives"=>$ResultTUActives, "ResultClubsNews"=>null));
	}
	
	public function actionNews()
	{
		$this->render('news');
	}
	
	public function actionAddcomments()
	{
		if(isset($_POST["content"]))
		$model = new Comments();
		
		$model->title = "[CDTU]Comments and Suggestions";
		$model->content = $_POST["content"];
		$model->module = "cdtu";
		$model->user_id = RoleUtil::getUser()->nsn_id;
		$model->add_time = getCurTime();
		$model->add_ip = getClientIP();
		$model->reply = "";
		
		$model->save();
		
		Header("Location:".$this->createUrl("index"));
	}	
		
	public function actionNavigate()
	{
		 //$this->redirect(array('food/default/index'));
		 $this->render('navigate');
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->redirect(array('default/error'));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// collect user input data
		if(isset($_POST['UserForm']))
		{
			$model=new UserForm;
			$model->attributes=$_POST['UserForm'];
			// validate user input and redirect to the previous page if valid
			if($model->login())
			{
				$this->redirect(Yii::app()->createUrl("library/my/index"));
			}
			else 
			{
				$errors = $model->getErrors('login');
				$this->render('login',array('targetAction'=>'login','loginErrors'=>'Login failed: '.$errors[0]));
			}
		}
		else
		{
			// display the login form
			$this->render('login');
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->session->clear();
		$this->redirect(array('login'));
	}
	
	public function actionRegist()
	{
		// collect user input data
		if(isset($_POST['Users']))
		{
			if($_POST['Users']['password'] != $_POST['pass_rep'])
			{
				$this->render('login',array('targetAction'=>'regist','registErrors'=>'Regist failed: password inputed two times not same.'));
				return;
			}
			//check if shop_id exist:
			$isexist = Users::model()->exists("nsn_id=:nsn_id",array(":nsn_id"=>$_POST['Users']['nsn_id']));
			if(!$isexist)
			{
				if(!is_email($_POST['Users']['email']))
				{
					$this->render('login',array('targetAction'=>'regist','registErrors'=>'Regist failed: Email address not available.'));
					return;
				}
				
				$curtime=getCurTime();
				$clientip=getClientIP();
				
				$model = new Users();
				$model->attributes=$_POST['Users'];
				$model->password=md5($model->password);
				
				$model->logo="userlogo.jpg";
				$model->last_time=$curtime;
				$model->last_ip=$clientip;
				$model->create_time=$curtime;
				$model->create_ip=$clientip;
				
				//if(!isset($model->user_name) || empty($model->user_name))
				//{
				$model->user_name = cutString($model->email, '@');
				//}
				
				try {
				if ($model->save()) 
				{	
					// create user role:
					$userRole = new UsersRole();
					$userRole->user_id = $model->nsn_id;
					$userRole->is_tu = 1;
					$userRole->role_system = 0;
					$userRole->role_library = 0;
					$userRole->save();
					
					// end email:
					sendRegistEmail($model,"");
					
					// automatically login:
					$loginmodel=new UserForm;
					$loginmodel->username = $model->nsn_id;
					$loginmodel->password = $model->password;
					$loginmodel->rememberMe = false;
					if($loginmodel->login())	
					{				
						$this->redirect($this->createUrl("default/index"));
					}
					else 
					{
						$this->render('login',array('targetAction'=>'login','loginErrors'=>'Regist successfully, please login.'));
					}
				}
				else 
				{
					$this->render('login',array('targetAction'=>'regist','registErrors'=>'Regist failed, please try again.'));
				}}
				catch(Exception $ex)
				{
					$this->render('login',array('targetAction'=>'regist','registErrors'=>'Regist failed: duplicated email address, please try again.'));
				}				
			}
			else 
			{
				$this->render('login',array('targetAction'=>'regist','registErrors'=>'Regist failed: The account exist, please login or reset password.'));
			}
		}
		else 
		{
			$this->render('login',array('targetAction'=>'regist','registErrors'=>'Regist failed: No data submitted, please try again.'));
		}
	}
	
	function actionResetpwd()
	{
		try
		{
			if(!isset($_REQUEST["nsn_id"]) || !isset($_REQUEST["email"]))
			{
				$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'NSN ID or NSN email not set, please try again!'));
			}
			else
			{
				$nsnId = $_REQUEST["nsn_id"];
				$emailStart=explode('@',$_REQUEST["email"])[0];
				if(strlen($emailStart)<3){
					$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'NSN Email not right, please retry!'));
					return;
				}
				
				$model = Users::model()->findByAttributes(array('nsn_id'=>$nsnId));
				$dbEmail=explode('@',$model->email)[0];
				
				if(!isset($model))
				{
					$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'NSN ID not registed, please regist at first!'));
				}
				else if($dbEmail != $emailStart)
				{
					$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'NSN Email not right, please try again!'));
				}
				else 
				{
					$passwd = getRandChar(8);
					$model->password=md5($passwd);
					if ($model->save())
					{
						// send email:
						sendResetPwdEmail($model, $passwd);
						$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'Reset password successfully, please login with the new password!'));
					}
					else
					{
						$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'Reset password failed, please try again!'));
					}
				}
			}
		}
		catch(Exception $e)
		{
			$this->render('login',array('targetAction'=>'resetpwd','resetpwdErrors'=>'Reset password failed, please try again!'));
		}	
	}
	
	function actionMail()
	{
		try 
		{
			sendEmail2("bihong.he@onelibrary.com", "test from php", "ok email");
			echo "ok";
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
	/*
	function actionTest1()
	{
		print_r(SiteSystemParameters::getAllParms());
	}
	function actionTest0()
	{
		echo SiteSystemParameters::getParmValue("EmailSendName");
	}
	*/
}