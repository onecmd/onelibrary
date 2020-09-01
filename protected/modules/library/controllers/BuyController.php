<?php 

class BuyController extends Controller
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
	
	public function actionRequestList()
	{
		try 
		{
			$currentPage = 0;
			$pageSize = 15;
			if(isset($_POST['page']))
			{
				$currentPage = intval($_POST['page']);
			}		
			$criteria=new CDbCriteria;   
			if(isset($_POST["BooksBuyRequest"]))
			{
				if(!empty($_POST["BooksBuyRequest"]["book_name"]))
				{
					$criteria->addCondition("book_name like :book_name", "and");
					$criteria->params[':book_name']="%".$_POST["BooksBuyRequest"]["book_name"]."%"; 
				}
				if(!empty($_POST["BooksBuyRequest"]["user_email"]))
				{
					$criteria->addCondition("user_email like :user_email", "and");
					$criteria->params[':user_email']="%".$_POST["BooksBuyRequest"]["user_email"]."%"; 
				}
				if(isset($_POST["BooksBuyRequest"]["status"]))
				{
					if($_POST["BooksBuyRequest"]["status"]!="10")
					{
						$criteria->addCondition("status=:status", "and");
						$criteria->params[':status']=$_POST["BooksBuyRequest"]["status"]; 
					}
				}
				if(isset($_POST["BooksBuyRequest"]["order_by"]))
				{						
					if($_POST["BooksBuyRequest"]["order_by"]=="0")
					{
						$criteria->order = "request_time";
					}
					else if($_POST["BooksBuyRequest"]["order_by"]=="1")
					{
						$criteria->order = "request_time desc";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="2")
					{
						$criteria->order = "buy_time";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="3")
					{
						$criteria->order = "buy_time desc";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="4")
					{
						$criteria->order = "vote";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="5")
					{
						$criteria->order = "book_url";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="6")
					{
						$criteria->order = "book_name";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="7")
					{
						$criteria->order = "user_name";
					}					
					else if($_POST["BooksBuyRequest"]["order_by"]=="8")
					{
						$criteria->order = "status";
					}					
					else
					{
						$criteria->order = "request_time desc";
					}
				}
				else
					{
						$criteria->order = "request_time desc";
					}
			}
			else
					{
						$criteria->order = "request_time desc";
					}
			$dataProvider=new CActiveDataProvider('BooksBuyRequest', array(
				'criteria'=>$criteria,
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
			
			$ResultBuys = $dataProvider->getData();
			
			$BuyList = BooksBuyList::model()->findAllByAttributes(array("status"=>0));
			
			$this->renderPartial('requestList',array(
				'ResultBooks'=>$ResultBuys,
				'ResultBuyList'=>$BuyList,
				'page'=>$page,
				'pageSize'=>$pageSize,
			));
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"View buy list page failed!".$e->getMessage()));
		}		
	}


	
	public function actionMybuy()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}

		$booklist = BooksBuyRequest::model()->findAllByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id)
		, new CDbCriteria(array("order"=>"request_time DESC")));
		
		$this->renderPartial('mybuy',array(
			'ResultBooks'=>$booklist,
			'page'=>1,
			'pageSize'=>200,
		));
	}
	public function actionNewBuy()
	{
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		$this->renderPartial('newBuy'/*,array(
			'ResultBooks'=>$booklist,
		)*/);
	}
	
	public function actionShowEditBuyRequest(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		$BuyRequest = BooksBuyRequest::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$this->renderPartial('newBuy',array(
			'ResultBuyRequest'=>$BuyRequest,
		));
	}
	
	public function actionShowCreateBuyListDlg(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		
		$this->renderPartial('createOrEditBuyList', array(
			"isCreate"=> true
		));
	}
	
	public function actionShowEditBuyListDlg(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		if(!isset($_REQUEST['id']))
		{
			$this->renderPartial('editok', array("message"=>"Parameter not right!"));
			return ;
		}
		
		$model = BooksBuyList::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		if(!isset($model)){
			$this->renderPartial('editok', array("message"=>"Record not found!"));
			return ;
		}
		
		$this->renderPartial('createOrEditBuyList', array(
			"isCreate"=> false,
			'ResultBuyList'=>$model
		));
	}		
	
	public function actionAddBuyList(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->render('editok', array("message"=> "Please login at first!"));
			return;
		}
		if(RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]){
			$this->render('editok', array("message"=> "Please login as librarion!"));
			return;
		}
		
		if(!isset($_POST['BooksBuyList']))
		{
			$this->renderPartial('editok', array("message"=>"Parameter not right!"
			, "backTabId"=>"buyListDetail"
			, "backUrl"=>$this->createUrl("buyListDetail")
			));
			return;
		}
		
		try 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
	
			$model = new BooksBuyList();
			$model->attributes=$_POST['BooksBuyList'];
			
			$model->creator_user_id = RoleUtil::getUser()->nsn_id;
			$model->creator_name = RoleUtil::getUser()->user_name;
				//$model->user_email = RoleUtil::getUser()->email;
			
			$model->status = 0;
			$model->create_time=$curtime;
			$model->start_time =longDate($model->start_time);
			$model->finished_time =longDate($model->finished_time);
			
			if ($model->save()){			
				$this->renderPartial('editok', array("message"=>"保存成功！"));
				return;
			}
			else 
			{
				$this->renderPartial('editok', array("message"=>"创建失败，请重试！"));
			}		
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"Data added failed! Exception:".$e->getMessage()));
		}
	}
	public function actionEditBuyList(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->render('editok', array("message"=> "Please login at first!"));
			return;
		}
		if(RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]){
			$this->render('editok', array("message"=> "Please login as librarion!"));
			return;
		}
		
		if(!isset($_POST['BooksBuyList']))
		{
			$this->renderPartial('editok', array("message"=>"Parameter not right!"));
			return;
		}
		
		try 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
			//$model = new BooksBuyList();
			//$model->attributes=$_POST['BooksBuyList'];
			
			$model = BooksBuyList::model()->findByAttributes(array('id'=>$_POST['BooksBuyList']['id']));
			$model->attributes=$_POST['BooksBuyList'];
			
			//$model->creator_user_id = RoleUtil::getUser()->nsn_id;
			//$model->creator_name = RoleUtil::getUser()->user_name;
			//$model->user_email = RoleUtil::getUser()->email;
			
			//$model->status = 0;
			//$model->create_time=$curtime;
			//$model->start_time =date('Y-m-d H:i:s', strtotime($model->start_time));
			
			if ($model->save()){			
				//$this->actionBuyListDetail();
				$this->renderPartial('editok', array("message"=>"保存成功！"));
				return;
			}
			else 
			{
				$this->renderPartial('editok', array("message"=>"保存失败，请重试！"));
			}		
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"Data added failed! Exception:".$e->getMessage()));
		}
	}
		
	public function actionBuyListDetail()
	{
		try 
		{
			//$criteria1=new CDbCriteria;   
			
			//$criteria1->addCondition("status=:status", "and");
			//$criteria1->params[':status']="0"; 	
			
			//$dataProvider=new CActiveDataProvider('BooksBuyList', array(
			//	'criteria'=>$criteria1
			//));
			
			//$totalItemCount = $dataProvider->getTotalItemCount();
			//if($totalItemCount < 1){
			//	$this->renderPartial('createBuyList');
			//	return;
			//}
			//else{
			
				//$firstDatas=$dataProvider->getData();
				//$buyListId=$firstDatas[0]->id;
				
				//$criteria=new CDbCriteria;   
				
				//$criteria->addCondition("status=:status", "and");
				//$criteria->params[':status']="1"; 	
				//$criteria->addCondition("buy_list_id is NULL", "and");
				
				//$criteria->order = " vote desc, request_time desc";
						
				//$dataProvider=new CActiveDataProvider('BooksBuyRequest', array(
				//	'criteria'=>$criteria
				//));
				
				//$ResultBuys = $dataProvider->getData();
				
			$buyListId=$_REQUEST['id'];
			
			$ResultBuyList = BooksBuyList::model()->findByAttributes(array('id'=>$buyListId));
			if(!isset($ResultBuyList)){
				$this->renderPartial('editok', array("message"=>"Buy list not found!"));
				return;
			}
				
				$criteriaInList=new CDbCriteria;   
				
				//$criteriaInList->addCondition("status=:status", "and");
				//$criteriaInList->params[':status']="0"; 	
				$criteriaInList->addCondition("buy_list_id=:buyListId", "and");
				$criteriaInList->params[':buyListId']="".$buyListId;
				
				$criteriaInList->order = "book_type, request_time desc";
						
				$dataProviderInList=new CActiveDataProvider('BooksBuyRequest', array(
					'criteria'=>$criteriaInList,
					'pagination'=>false,
				));
				
				$ResultBuysInList = $dataProviderInList->getData();
			
				$this->renderPartial('buyListDetail',array(
					'ResultBuyList'=>$ResultBuyList,
					'ResultBooksInList'=>$ResultBuysInList,
				));
			//}
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"View buy list page failed!".$e->getMessage()));
		}		
	}	
	public function actionBuyList()
	{
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		try 
		{
			$currentPage = 0;
			$pageSize = 15;
			if(isset($_POST['page']))
			{
				$currentPage = intval($_POST['page']);
			}		
			$criteria=new CDbCriteria;   
			$criteria->order = "create_time desc";
			
			$dataProvider=new CActiveDataProvider('BooksBuyList', array(
				'criteria'=>$criteria,
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
			
			$ResultBuys = $dataProvider->getData();
			
			$this->renderPartial('buyList',array(
				'ResultBooks'=>$ResultBuys,
				'page'=>$page,
				'pageSize'=>$pageSize,
			));
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"View buy list page failed!".$e->getMessage()));
		}		
	}
	
	public function actionChangeToBuyList(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			//$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}

		try
		{
			if(!isset($_REQUEST['id']) || !isset($_REQUEST['buyListId']))
			{
				return;
			}
			else{
				$model = BooksBuyRequest::model()->findByAttributes(array('id'=>$_REQUEST['id']));
				$buyList = BooksBuyList::model()->findByAttributes(array('id'=>$_REQUEST['buyListId']));
				if(!isset($model) || !isset($buyList))
				{
					//$this->render('index', array("message"=> "Record not found by ID, Please try again!"));
					return;
				}
				else{
					$model->buy_list_id=$buyList->id;
					$model->buy_list_name=$buyList->list_name;
					$model->status=1;
					
					$model->last_updated=getCurTime();
					$model->last_ip=getClientIP();
					
					$model->save();
				}
			}
		}
		catch(Exception $e)
		{
			//$this->renderPartial('editok', array("message"=>"View buy list page failed!".$e->getMessage()));
		}
	}
	
	public function actionUpdateBuyList(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			//$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}

		try
		{
			if(!isset($_REQUEST['id']) || !isset($_REQUEST['buyListId']))
			{
				return;
			}
			else{
				$model = BooksBuyRequest::model()->findByAttributes(array('id'=>$_REQUEST['id']));
				$buyList = BooksBuyList::model()->findByAttributes(array('id'=>$_REQUEST['buyListId']));
				if(!isset($model) || !isset($buyList))
				{
					//$this->render('index', array("message"=> "Record not found by ID, Please try again!"));
					return;
				}
				else{
					$model->buy_list_id=$buyList->id;
					$model->buy_list_name=$buyList->list_name;
					
					$model->last_updated=getCurTime();
					$model->last_ip=getClientIP();
					
					$model->save();
				}
			}
		}
		catch(Exception $e)
		{
			//$this->renderPartial('editok', array("message"=>"View buy list page failed!".$e->getMessage()));
		}
	}
	
	public function actionChangeBuyListStatus(){
			if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			//$this->renderPartial('editok', array("message"=> "Please login at first!"));
			echo "Please login at first!";
			return;
		}

		try
		{
			if(!isset($_REQUEST['id']) || !isset($_REQUEST['status']))
			{
				echo "failed: parameters not right!";
				return;
			}
			else{
				$buyList = BooksBuyList::model()->findByAttributes(array('id'=>$_REQUEST['id']));
				if(!isset($buyList))
				{
					//$this->render('index', array("message"=> "Record not found by ID, Please try again!"));
					echo "failed: Record not found by ID, Please try again!";
					return;
				}
				else{
					$buyList->status=$_REQUEST['status'];
					$buyList->finished_time=getCurTime();
					
					$buyList->save();
					echo "ok";
				}
			}
		}
		catch(Exception $e)
		{
			echo "failed: View buy list page failed!".$e->getMessage();
			//$this->renderPartial('editok', array("message"=>"View buy list page failed!".$e->getMessage()));
		}
	}
		
	public function actionAddBuy()
	{
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->render('index', array("message"=> "Please login at first!"));
			return;
		}
		
		if(!isset($_POST['BooksBuyRequest']))
		{
			$this->render('index', array("message"=>"Parameter not right!"));
		}
		
		try 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
	
			$model = new BooksBuyRequest();
			$model->attributes=$_POST['BooksBuyRequest'];
			
			if(RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
			{
				$model->user_id = RoleUtil::getUser()->nsn_id;
				$model->user_name = RoleUtil::getUser()->user_name;
				$model->user_email = RoleUtil::getUser()->email;
			}
			else 
			{
				$user = Users::model()->findByAttributes(array('nsn_id'=>$model->user_id));
				if(!isset($user))
				{
					$user = loadUserFromMvnforunByNsnId($model->user_id);
					if(!isset($user)){
						$this->render('index', array("message"=>"User NSN ID not found, Please try again!"));
						return;
					}
				}
				$model->user_name = $user->user_name;
				$model->user_email = $user->email;
			}
			
			$model->status = 0;
			$model->request_time=$curtime;
			//$model->buy_time =$curtime;
			$model->last_updated =$curtime;
			$model->last_ip=getClientIP();
			
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
	
	public function actionEditBuyRequest(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		if(!isset($_POST['BooksBuyRequest']) || !isset($_POST['BooksBuyRequest']['id']))
		{
			$this->renderPartial('editok', array("message"=>"Parameter not right!"));
			return ;
		}
		
		try 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
	
			$model = BooksBuyRequest::model()->findByAttributes(array('id'=>$_POST['BooksBuyRequest']['id']));
			$model->attributes=$_POST['BooksBuyRequest'];
			
			if($model->save())
			{
				$this->renderPartial("editok", array("message"=>"Save successful!"));
			}
			else
			{
				$this->renderPartial('editok', array("message"=>"Data edit failed!, Please try again!"));
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"Data edit failed! Exception:".$e->getMessage()));
		}		
	}
	
	public function actionChangeBuyRequestStatus(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		if(!isset($_REQUEST['id']) || !isset($_REQUEST['status']))
		{
			$this->renderPartial('editok', array("message"=>"Parameter not right!"));
			return ;
		}
		
		try 
		{
			$model = BooksBuyRequest::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			$model->status=$_REQUEST['status'];
			
			if($_REQUEST['status'] == 0){
				$model->buy_list_id =0;
				$model->buy_list_name ="";
			}
	
			$model->last_updated =getCurTime();
			$model->last_ip=getClientIP();
			
			$model->save();
			
			$_REQUEST['id']=$model->buy_list_id;
			$_REQUEST['status']=null;
			$this->actionBuyListDetail();
			//$this->renderPartial("editok", array("message"=>"Save successful!"));
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"Data edit failed! Exception:".$e->getMessage()));
		}		
			
	}
	
	public function actionChangeBuyRequestType(){
		if(!isset(Yii::app()->session['user'])/* || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"]*/)
		{
			$this->renderPartial('editok', array("message"=> "Please login at first!"));
			return;
		}
		
		if(!isset($_REQUEST['id']) || !isset($_REQUEST['book_type']))
		{
			$this->renderPartial('editok', array("message"=>"Parameter not right!"));
			return ;
		}
		
		try 
		{
			$model = BooksBuyRequest::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			$model->book_type=$_REQUEST['book_type'];
	
			$model->last_updated =getCurTime();
			$model->last_ip=getClientIP();
			
			$model->save();
			
			$_REQUEST['id']=$model->buy_list_id;
			
			$this->actionBuyListDetail();
			//$this->renderPartial("editok", array("message"=>"Save successful!"));
		}
		catch(Exception $e)
		{
			$this->renderPartial('editok', array("message"=>"Book type edit failed! Exception:".$e->getMessage()));
		}		
	}
	
	public function actionLoadExistBooksByName(){
		$result="<li>&nbsp; 馆中已存在下面书籍，点击查看详细：</li>";
		if(!isset($_REQUEST['bookName']))
		{
			echo $result."<li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li>";
			return ;
		}
		
		try 
		{	
			$criteria=new CDbCriteria;   
			$criteria->addCondition("status<2", "and");
			$criteria->addCondition("book_name like :book_name", "and");
			$criteria->params[':book_name']="%".$_REQUEST['bookName']."%"; 
					
			$dataProvider=new CActiveDataProvider('Books', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'currentPage'=>0,
					'pageSize'=>30,
				),
			));
			
			$ResultBooks = $dataProvider->getData();
			$existBooks="";
			$total = 0;
			foreach($ResultBooks as $data)
			{
				$total = $total+1;
				$bookUrl = Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->id));
				$existBooks=$existBooks."<li><a href='".$bookUrl."' target='_blank'>".$data->book_name."</a></li>";
			}
			
			if($total<30){
				$criteria=new CDbCriteria;   
				$criteria->addCondition("status=2", "and");
				$criteria->addCondition("book_name like :book_name", "and");
				$criteria->params[':book_name']="%".$_REQUEST['bookName']."%"; 
						
				$dataProvider=new CActiveDataProvider('BooksBuyRequest', array(
					'criteria'=>$criteria,
					'pagination'=>array(
						'currentPage'=>0,
						'pageSize'=>(30-$total),
					),
				));
				
				$ResultBooks = $dataProvider->getData();
				foreach($ResultBooks as $data)
				{
					$total = $total+1;
					$existBooks=$existBooks."<li>书单：".$data->book_name."[已购]</li>";
				}
			}
			
			if($existBooks == ""){
				echo $result."<li>图书馆中没有找到类似的书，可以申请购买.</li><li>&nbsp;</li><li>&nbsp;</li>";
			}
			else{
				echo $result.$existBooks;
			}
			return;
		}
		catch(Exception $e)
		{
			echo $result."<li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li>";
			return;
		}	
	}
	
	public function actionVote()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render('index', array("message"=> "Please login at first!"));
			return;
		}
		if(!isset($_GET["id"]))
		{
			$this->render('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		try 
		{
			$id=$_GET["id"];
			
			$model = BooksBuyRequest::model()->findByAttributes(array('id'=>$id));
			if(!isset($model))
			{
				$this->render('index', array("message"=> "Record not found by ID, Please try again!"));
				return;
			}
			
			$model->vote = $model->vote+1;
			$model->vote_user_names = str_replace(RoleUtil::getUser()->user_name.", ", "",$model->vote_user_names).RoleUtil::getUser()->user_name.", ";
			
			if($model->save())
			{
				$this->render("index", array("message"=>"Update successful!"));
			}
			else
			{
				$this->render('index', array("message"=>"Update failed!, Please try again!"));
			}
		}
		catch(Exception $e)
		{
			$this->render('index', array("message"=>"Update failed! Exception:".$e->getMessage()));
		}
	}
	
	public function actionCancel()
	{
		if(!isset(Yii::app()->session['user']))
		{
			$this->render('index', array("message"=> "Please login at first!"));
			return;
		}
		if(!isset($_GET["id"]))
		{
			$this->render('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		$this->updateStatus($_GET["id"], 3);
	}
	
	public function actionRequiring()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->render('index', array("message"=> "Please login with libration at first!"));
			return;
		}
		if(!isset($_GET["id"]))
		{
			$this->render('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		$this->updateStatus($_GET["id"], 0);
	}
	
	public function actionAccept()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->render('index', array("message"=> "Please login with libration at first!"));
			return;
		}
		if(!isset($_GET["id"]))
		{
			$this->render('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		$this->updateStatus($_GET["id"], 1);
	}
	
	public function actionBuyed()
	{
		if(!isset(Yii::app()->session['user']) || RoleUtil::getUserLibraryRole()<RoleUtil::$LIBRARY_ROLE["Libration"])
		{
			$this->render('index', array("message"=> "Please login with libration at first!"));
			return;
		}
		if(!isset($_GET["id"]))
		{
			$this->render('index', array("message"=> "Wrong request, Please try again!"));
			return;
		}
		
		$this->updateStatus($_GET["id"], 2);
	}
	
	public function updateStatus($id, $status)
	{
		try 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
			
			$updateAttributes = array('status'=>$status, 'last_updated'=>$curtime,'last_ip'=>$clientip);
			if($status == 2){ // set to buyed
				$updateAttributes = array('status'=>$status, 'buy_time'=>$curtime, 'last_updated'=>$curtime,'last_ip'=>$clientip);
			}
			BooksBuyRequest::model()->updateByPk($id, $updateAttributes);
			
			if($status == 2){
				try{
					$model =  BooksBuyRequest::model()->findByPk($id);
					if(isset($model)){
						$awardScore = intval(SiteSystemParameters::getParmValue('AwardScoreForBuyRequestAccept'));
						$scoreAction = "心愿书单奖励: ".$model->book_name.", 提交于: ".longDate($model->request_time);
						addUserScore($model->user_id, $scoreAction, $awardScore, "System" );
					}
				}catch(Exception $e){
				}
			}
			
			$target=isset($_GET["target"])?$_GET["target"]:"requestList";
			$this->render('index', array("message"=>"Update successful!", "target"=>$target));
		}
		catch(Exception $e)
		{
			$this->render('index', array("message"=>"Update failed! Exception:".$e->getMessage()));
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
	
	public function getStatusStr($status)
	{
		switch ($status)
		{
			case 0: return "<font color=#00AA00>Requiring</font>"; 
			case 1: return "<font color=#FF8800 >Accept</font>"; 
			case 2: return "<font color=#FF0000 >Buyed</font>"; 
			case 3: return "<font color=#444444>Canceled</font>"; 
			default:return "<font color=#00AA00>Requiring</font>";
		}
	}
	
}