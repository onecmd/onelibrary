<?php 

class SettingController extends Controller
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
            'accessAuth',  
        ); 
	}
	
	public function filterAccessAuth($filterChain) 
	{ 
		$role = RoleUtil::getUserLibraryRole();
		// 10 is superadmin, only superadmin role user available for this control
		if(!isset($role) || $role<10)
		{
			$this->render("error", array("message"=>"<font color=red>System Setting function only available for SuperAdmin user!</font>"));
		}
		else 
		{
			$filterChain->run();  
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteriaType=new CDbCriteria;   
		$criteriaType->addCondition("grade=0", "and");
		$criteriaType->order = "type_name";
		$ResultTypes = BooksType::model()->findAll($criteriaType);
		
		$criteriaType2=new CDbCriteria;   
		$criteriaType2->addCondition("grade=1", "and");
		$criteriaType2->order = "type_code";
		$ResultTypes2 = BooksType::model()->findAll($criteriaType2);
		
		//$criteriaRole=new CDbCriteria;   
		//$criteriaRole->addCondition("role_library>0", "and");
		//$criteriaRole->order = "role_library desc";
		//$ResultRols=UsersRole::model()->findAll($criteriaRole);
		// get books:
		$db = Yii::app()->db; 
		//$sql = "select * from tb_users_role r left join tb_users u on r.user_id=u.nsn_id where r.role_library>0 order by r.role_library desc;";
		$sql = "SELECT a.*, b.user_name, b.email FROM `db_cdtu`.`tb_users_role` a, tb_users b  where a.user_id=b.nsn_id and role_library!=0;";
		$ResultRols = $db->createCommand($sql)->query();
		
		
		$criteriaSystem=new CDbCriteria;   
		//$criteriaSystem->addCondition("role_library>0", "and");
		$criteriaSystem->order = "id ";
		$ResultSystems=SystemParameter::model()->findAll($criteriaSystem);
		
		$this->render('index', array(
			"ResultTypes"=>$ResultTypes,
			"ResultTypes2"=>$ResultTypes2,
			"ResultRols"=>$ResultRols,
			"ResultSystems"=>$ResultSystems,
		));
	}
	
	public function actionAddtype()
	{
		if(!isset($_POST["BooksType"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"type")));
		}
		else
		{
			$model = new BooksType();
			$model->attributes=$_POST['BooksType'];
			$model->save();
			
			Header("Location:".$this->createUrl("index", array("action"=>$model->grade==0?"type":"category")));			
		}
	}
	
	public function actionChangetype()
	{
		if(!isset($_POST["BooksType"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"type")));
		}
		else
		{
			$model =  BooksType::model()->findByPk($_POST["BooksType"]["id"]);
			if(isset($model))
			{
				$model->attributes=$_POST['BooksType'];
				$model->save();
			}
			
			Header("Location:".$this->createUrl("index", array("action"=>$model->grade==0?"type":"category")));			
		}
	}
	
	public function actionDeltype()
	{
		if(!isset($_REQUEST["id"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"category")));
		}
		else
		{
			BooksType::model()->deleteByPk($_REQUEST["id"]);
			Header("Location:".$this->createUrl("index", array("action"=>$_REQUEST["grade"]=="0"?"type":"category")));			
		}
	}
	public function actionAddlibuser()
	{
		if(!isset($_POST["UsersRole"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"user")));
		}
		else
		{
			$model = UsersRole::model()->findByAttributes(array("user_id"=>$_POST["UsersRole"]["user_id"]));
			if(isset($model))
			{
				$model->role_library=$_POST['UsersRole']["role_library"];
				$model->save();
			}
			else // not exist the user role data:
			{
				$user = Users::model()->findByAttributes(array("nsn_id"=>$_POST["UsersRole"]["user_id"]));
				if(isset($user)) // exit the user:
				{
					// create user role:
					$userRole = new UsersRole();
					$userRole->user_id = $user->nsn_id;
					$userRole->is_tu = 1;
					$userRole->role_system = 0;
					$userRole->role_library = $_POST['UsersRole']["role_library"];
					$userRole->save();
				}
			}
			
			Header("Location:".$this->createUrl("index", array("action"=>"user")));			
		}
	}
	
	public function actionChangelibuser()
	{
		if(!isset($_POST["UsersRole"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"user")));
		}
		else
		{
			$model = UsersRole::model()->findByPk($_POST["UsersRole"]["id"]);
			if(isset($model))
			{
				$model->role_library=$_POST['UsersRole']["role_library"];
				$model->save();
			}
			
			Header("Location:".$this->createUrl("index", array("action"=>"user")));			
		}
	}	
	
	public function actionDellibuser()
	{
		if(!isset($_REQUEST["id"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"user")));
		}
		else
		{
			$model = UsersRole::model()->findByPk($_REQUEST["id"]);
			if(isset($model))
			{
				// library role,"User"=>0,"Finance"=>2,"Libration"=>5,"SuperAdmin"=>10,
				$model->role_library=0;
				$model->save();
			}
			
			Header("Location:".$this->createUrl("index", array("action"=>"user")));			
		}
	}

	public function actionChangeSystem()
	{
		if(!isset($_POST["System"]))
		{
			Header("Location:".$this->createUrl("index", array("action"=>"system")));
		}
		else
		{
			$model = SystemParameter::model()->findByPk($_POST["System"]["id"]);
			if(isset($model))
			{
				$model->parm_value=$_POST["System"]["parm_value"];
				$model->save();
			}
			
			Header("Location:".$this->createUrl("index", array("action"=>"system")));			
		}
	}
}