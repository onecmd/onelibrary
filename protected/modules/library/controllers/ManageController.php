<?php 

class ManageController extends Controller
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
            'accessAuth',  
        ); 
	}
	
	public function filterAccessAuth($filterChain) 
	{ 
		$role = RoleUtil::getUserLibraryRole();
		if(!isset($role) || $role<5)
		{
			Header("Location:".Yii::app()->createUrl(Yii::app()->user->loginUrl));
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
		$booyTypeArray = $this->getRsBookTypeAsArray();
		$this->render('index', array(
			'BookTypeArray'=>$booyTypeArray,)
		);
	}
	
	public function actionList()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		
		
		$criteria=new CDbCriteria;   
		if(isset($_POST["Books"]))
		{
			if(!empty($_POST["Books"]["book_id"]))
			{
				$criteria->addCondition("book_id=:book_id", "and");
				$criteria->params[':book_id']=$_POST["Books"]["book_id"]; 
			}
			if(!empty($_POST["Books"]["book_name"]))
			{
				$criteria->addCondition("book_name like :book_name", "and");
				$criteria->params[':book_name']="%".$_POST["Books"]["book_name"]."%"; 
			}
			if(!empty($_POST["Books"]["holder_nsn_id"]))
			{
				$criteria->addCondition("holder_nsn_id like :holder_nsn_id", "and");
				$criteria->params[':holder_nsn_id']="%".$_POST["Books"]["holder_nsn_id"]."%"; 
			}
			if(isset($_POST["Books"]["status"]))
			{
				if($_POST["Books"]["status"]=="10")
				{
					$criteria->addCondition("status<>2", "and"); // not removed
				}
				else 
				{
					$criteria->addCondition("status=:status", "and");
					$criteria->params[':status']=$_POST["Books"]["status"]; 
				}
			}
			else 
			{
				$criteria->addCondition("status<>2", "and"); // not removed
			}
			if(!empty($_POST["Books"]["owner_team"]))
			{
				$criteria->addCondition("owner_team like :owner_team", "and");
				$criteria->params[':owner_team']="%".$_POST["Books"]["owner_team"]."%"; 
			}
			if(!empty($_POST["Books"]["book_type"]) && $_POST["Books"]["book_type"]!="0")
			{
				$criteria->addCondition("book_type=:book_type", "and");
				$criteria->params[':book_type']=$_POST["Books"]["book_type"]; 
			}
			if(!empty($_POST["Books"]["language"]) && $_POST["Books"]["language"]!="all")
			{
				$criteria->addCondition("language=:language", "and");
				$criteria->params[':language']=$_POST["Books"]["language"]; 
			}
			if(!empty($_POST["Books"]["tags"]))
			{
				$criteria->addCondition("tags like :tags", "and");
				$criteria->params[':tags']="%".$_POST["Books"]["tags"]."%"; 
			}
			if(!empty($_POST["Books"]["author"]))
			{
				$criteria->addCondition("author like :author", "and");
				$criteria->params[':author']="%".$_POST["Books"]["author"]."%"; 
			}
			if(!empty($_POST["Books"]["isbn"]))
			{
				$criteria->addCondition("isbn like :isbn", "and");
				$criteria->params[':isbn']="%".$_POST["Books"]["isbn"]."%"; 
			}
			if(!empty($_POST["Books"]["publisher"]))
			{
				$criteria->addCondition("publisher like :publisher", "and");
				$criteria->params[':publisher']="%".$_POST["Books"]["publisher"]."%"; 
			}
		}
		
		$criteria->order = "add_time DESC";		
		
		$this->responseBooksByCriteria('list', $currentPage, $pageSize, $criteria);
	}
	
	public function actionReturnView()
	{
		$currentPage = 0;
		$pageSize = 40;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		
		
		$criteria=new CDbCriteria;   
		$criteria->addCondition("status=1", "and");
		if(isset($_REQUEST['book_name']) && !empty($_REQUEST['book_name']))
		{
			$criteria->addCondition("book_name like :book_name", "and");
			$criteria->params[':book_name']="%".$_POST["book_name"]."%";
		}
		if(isset($_REQUEST['holder_nsn_id']) && !empty($_REQUEST['holder_nsn_id']))
		{
			$criteria->addCondition("holder_nsn_id=:holder_nsn_id", "and");
			$criteria->params[':holder_nsn_id']=$_POST["holder_nsn_id"]; 
		}
		//print_r($_REQUEST);
		//print_r($criteria);
		//return ;
		$criteria->order = "due_date, borrowed_time";		
		$this->responseBooksByCriteria('return', $currentPage, $pageSize, $criteria);
	}
	
	public function actionRemovedView()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		
		
		$criteria=new CDbCriteria;   
		$criteria->addCondition("status=2", "and");
		$criteria->order = "remove_time desc";		
		$this->responseBooksByCriteria('removed', $currentPage, $pageSize, $criteria);
	}
	
	public function actionUserDutyView()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		
		
		$criteria=new CDbCriteria;   
		$criteria->order = "create_time desc";		
		
		$dataProvider=new CActiveDataProvider('UsersDuty', array(
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
		
		$booklist = $dataProvider->getData();
		
		$this->renderPartial('userDuty',array(
			'ResultDutys'=>$booklist,
			'page'=>$page,
		));	
	}
	
	public function actionUserDuty1Hour(){
		try{
			$model = new UsersDuty();
							// for fine:
					$model->nsn_id = RoleUtil::getUser()->nsn_id;
					$model->user_name=RoleUtil::getUser()->user_name;
					$model->user_email=RoleUtil::getUser()->email;
					$model->duty_point=1;
					$model->comment="Duty 1 hour";
					$model->start_time=getCurTime();
					$model->end_time = date("Y-m-d H:i:s",time()+3600);
					$model->create_time = getCurTime();
					$model->got_gift = 0;
					$model->author_nsn_id = RoleUtil::getUser()->nsn_id;
					$model->author_user_name=RoleUtil::getUser()->user_name;
					$model->author_email=RoleUtil::getUser()->email;
					
					if($model->save()){
						Yii::app()->session['dutyStartTime']=getCurTime();
						echo "0";
					}
					else{
						echo "1";
					}
		}
		catch(Exception $e){
			echo $e;
			echo "1";
		}
	}	
	
	public function actionDeleteDuty(){
		try{
			if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])){
				echo "参数不对，请刷新重试";
				return ;
			}
			
			$model = UsersDuty::model()->findByPk($_REQUEST["id"]);
			if(!isset($model)){
				echo "记录不存在";
				return;
			}
			
			$count = UsersDuty::model()->deleteByPk($_REQUEST["id"]);
					
			if($count>0){
				echo "删除成功，请刷新";
				
				//$content="Hi ".$model->user_name.": ".RoleUtil::getUser()->user_name." 删除了你  ".longDate($model->start_time)." 日的一条值班记录";
				//$emailStr = str_replace("@onelibrary.com","@onelibrary.com",$model->user_email);				
				//sendEmail($emailStr, $content, $content, "delete_duty", false);
				
			}else{
				echo "删除失败";
			}
		}
		catch(Exception $e){
			echo "删除失败:".$e;
		}
		
	}
	
	
	public function actionDutyBookingView()
	{
		header("Content-type: text/html; charset=utf-8"); 
		$db = Yii::app()->db;

		if(isset($_REQUEST["year"]) && isset($_REQUEST["quarter"])){
			$year=(int)$_REQUEST["year"];
   			$quarter=(int)$_REQUEST["quarter"];
			$sql="select distinct user_id, user_name, email,
			(select count(*) from tb_users_duty dt where year(create_time)=".$year." and quarter(create_time)=".$quarter." and nsn_id=user_id group by user_name) as total 
			from tb_users, tb_users_role where role_library>=5 and user_id=nsn_id order by total desc;";			
		}
		else{
			$sql="select distinct user_id, user_name, email,
			(select count(*) from tb_users_duty dt where year(create_time)=year(curdate()) and quarter(create_time)=quarter(curdate()) and nsn_id=user_id group by user_name) as total 
			from tb_users, tb_users_role where role_library>=5 and user_id=nsn_id order by total desc;";
		}
		
		$resultDutys = $db->createCommand($sql)->query();
		
		///////////////
		$sql="select * from tb_users_duty_booking where date(book_date)>=date(curdate()) and ((year(book_date)=year(curdate()) and quarter(book_date)=quarter(curdate())) or datediff(book_date,curdate()) between 0 and 120) order by book_date;";
		$dutyBooking = $db->createCommand($sql)->query();
				
		$this->renderPartial('dutyBooking',array(
			'ResultDutys'=>$resultDutys,
			'ResultDutyBooking'=>$dutyBooking,
		));	
	}	
	
	public function actionCreateDutyBooking1Year(){
		
		$stimestamp = strtotime(getCurTime());
		for($i = 0; $i < 365; $i++){
        	$newDate = date('Y-m-d', $stimestamp + (86400 * $i));
        	$week = date("w",strtotime($newDate));
        	//echo $newDate."==>".$week."<br>";
        	if($week==2 || $week==4){        	
        	
				$isexist = UsersDutyBooking::model()->exists("date(book_date)=date(:book_id)",array(":book_id"=>$newDate));
				if(!$isexist)
				{
		        	$model = new UsersDutyBooking();
		        	
		        	$model->book_date=$newDate;
					//$model->nsn_id = RoleUtil::getUser()->nsn_id;
					//$model->user_name=RoleUtil::getUser()->user_name;
					//$model->email=RoleUtil::getUser()->email;
		        	$model->create_time=getCurTime();
		        	
		        	$model->save();				
				}
        	}
     	}
     	echo "ok";
	}
	
	public function actionBookOneDuty(){
		try{
			
			$updateAttributes = array(
				'nsn_id'=>RoleUtil::getUser()->nsn_id, 
				'user_name'=>RoleUtil::getUser()->user_name, 
				'email'=>RoleUtil::getUser()->email, 
				'create_time'=>getCurTime()
			);
			$count = UsersDutyBooking::model()->updateByPk($_REQUEST["id"], $updateAttributes);

			if($count>0){
				echo "预约成功，请刷新";
			}else{
				echo "预约失败";
			}
		}
		catch(Exception $e){
			echo "预约失败:".$e;
		}
		
	}
	
	public function actionCancelOneDuty(){
		try{
			$oldDuty = UsersDutyBooking::model()->findByPk($_REQUEST["id"]);
			if(!isset($oldDuty)){
				echo "预约记录没找到，请刷新重试";
				return ;
			}

			$updateAttributes = array(
				'nsn_id'=>'', 
				'user_name'=>'', 
				'email'=>'', 
				'create_time'=>getCurTime()
			);
			$count = UsersDutyBooking::model()->updateByPk($_REQUEST["id"], $updateAttributes);
			
			/*
			$model = new UsersDutyBooking();
			
			$model->id=$_REQUEST["id"];
			$model->nsn_id = "";
			$model->user_name="";
			$model->email="";
			$model->create_time=getCurTime();	
					*/
			if($count>0){
				$UID=$this->getDutyEmailUID($oldDuty);
				sendCencelMeetingMail($UID, $oldDuty->email, "3F Library Room，Tianfu New Area" ,"(取消)图书馆值班");
				echo "取消成功，请刷新";
			}else{
				echo "取消失败";
			}
		}
		catch(Exception $e){
			echo "预约失败:".$e;
		}
	}

	public function getDutyEmailUID($model){
		$dutyDate = str_replace(" 00:00:00", "", $model->book_date);
		return "nokia_tulib_duty_".$dutyDate."_".$model->id."_".$model->nsn_id."@onelibrary.com";
	}
	
	public function actionAskDutyReplace(){
		try{
			$db = Yii::app()->db;
			
			$model = UsersDutyBooking::model()->findByPk($_REQUEST["id"]);
			$sql = "select email from tb_users, tb_users_role where role_library>=5 and user_id=nsn_id and user_id!='".$model->nsn_id."'";

			$resultEmails = $db->createCommand($sql)->query();
			
			$emailStr=$model->email;
			foreach($resultEmails as $rs) {
				$emailStr = $emailStr.";".$rs["email"];
			}
			//$emailStr = str_replace("@onelibrary.com","@onelibrary.com",$emailStr);
			
			$content = 'Hi ,<br><br>'.
			'我是'.$model->user_name.'<br><br>'.
			'因 <b><font color=red>'.shortDate($model->book_date).'</font></b> 日没空，可否帮我值一天班?<br><br>'.
			'Thanks!<br>'.
			$model->user_name.'<br>'.
			getCurTime().
			'';
			
			sendEmail($emailStr, "因".shortDate($model->book_date)."日没空，可否帮我值一天班", $content, "Ask_duty_replace", false);
			
			echo "成功发送请求邮件给了: ".$emailStr."<br>请刷新";
			
		}
		catch(Exception $e){
			echo "请求失败失败:".$e;
		}
	}
	
	public function actionSendDutyCalendar(){
		try{
			$db = Yii::app()->db;
			
			$model = UsersDutyBooking::model()->findByPk($_REQUEST["id"]);
			
			//$emailStr = "bihong.he@onelibrary.com";//str_replace("@onelibrary.com","@onelibrary.com",$model->email);
			$emailStr = $model->email; //str_replace("@onelibrary.com","@onelibrary.com",$model->email);
			
			$content = 'Hi ,\n\n'.
			'图书馆值班哦，别忘了~~\n\n'.
			'工会图书馆\n'.
			getCurTime().
			'';
			
			$startTime = str_replace("00:00:00", "13:30:00", $model->book_date);
			$endTime = str_replace("00:00:00", "14:30:00", $model->book_date);
			$inviteName = "Library";
			sendMeetingMail($emailStr, $startTime, $endTime, $inviteName, "3F Library Room，Tianfu New Area" ,"图书馆值班", $content);
			
			echo "成功发送请求邮件给了: ".$emailStr."<br>请刷新";
			
		}
		catch(Exception $e){
			echo "请求失败失败:".$e;
		}
	}	
	public function actionTransferDutyTo(){
		try{
			if(!isset($_REQUEST["userId"]) || empty($_REQUEST["userId"])){
				echo "参数不对，请刷新重试";
				return ;
			}
			
			$user = Users::model()->findByAttributes(array('nsn_id'=>strtolower($_REQUEST["userId"])));
			if(!isset($user)){
				echo "用户没找到，请刷新重试";
				return ;
			}
			
			// find old duty user:
			$oldDuty = UsersDutyBooking::model()->findByPk($_REQUEST["id"]);
			if(!isset($oldDuty)){
				echo "预约记录没找到，请刷新重试";
				return ;
			}

			$updateAttributes = array(
				'nsn_id'=>$user->nsn_id, 
				'user_name'=>$user->user_name, 
				'email'=>$user->email, 
				'create_time'=>getCurTime()
			);

			// update to new:
			$count = UsersDutyBooking::model()->updateByPk($_REQUEST["id"], $updateAttributes);
			if($count>0){
				echo "分配成功，请刷新";

				$content="Hi ".$user->user_name.": ".RoleUtil::getUser()->user_name." 安排了你在 ".longDate($oldDuty->book_date)." 日值班";
				$emailStr = $user->email;//str_replace("@onelibrary.com","@onelibrary.com",$user->email);
				sendEmail($emailStr, $content, $content, "assign_duty", false, false);

				// send cancel meeting email to old duty user:
				$UID=$this->getDutyEmailUID($oldDuty);
				if(!empty($oldDuty->nsn_id)){
					sendCencelMeetingMail($UID, $oldDuty->email, "3F Library Room，Tianfu New Area" ,"(取消)图书馆值班");
				}
				
				// send new meeting email to new duty user:
				$content = 'Hi ,\n\n'.
					'图书馆值班哦，别忘了~~\n\n'.
					'工会图书馆\n'.
					getCurTime().
					'';

				$startTime = str_replace("00:00:00", "13:30:00", $oldDuty->book_date);
				$endTime = str_replace("00:00:00", "14:30:00", $oldDuty->book_date);
				$inviteName = "Library";

				sendMeetingMail($user->email, $startTime, $endTime, $inviteName, "3F Library Room，Tianfu New Area" ,"图书馆值班", $content);

				
			}else{
				echo "分配失败，请刷新重试";
			}
		}catch(Exception $e){
			echo "分配失败，请刷新重试:".$e;
		}
	}
		
	public function responseBooksByCriteria($view, $currentPage, $pageSize, $criteria)
	{
		$dataProvider=new CActiveDataProvider('Books', array(
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
		
		$booklist = $dataProvider->getData();
		$booyTypeArray = $this->getRsBookTypeAsArray();
		
		$this->renderPartial($view,array(
			'ResultBooks'=>$booklist,
			'page'=>$page,
			'BookTypeArray'=>$booyTypeArray,
		));			
	}
	
	public function getBookTypeList()
	{
		// get books:
		$db = Yii::app()->db; 
		$sql = "select * from tb_books_type where grade=0 order by id ;";
		$ResultBooksType = $db->createCommand($sql)->query();
		
		return $ResultBooksType;
	}
	
	public function getRsBookTypeAsArray()
	{
		$ResultBooksType = $this->getBookTypeList();
		
		$arBookType = array();
		foreach($ResultBooksType as $result)
		{
			$arBookType[$result["id"]]=$result["type_name"];
		}
		return $arBookType;
	}
	
	public function getBookTypeHtml($BookTypeArray, $bookId)
	{
		$html = "";
		foreach($BookTypeArray as  $key=>$value)
		{
			$url = $this->createUrl("changeBkType", array("bookId"=>$bookId, "typeId"=>$key));
			$html = $html.'<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="changeBkTypeTo('.$bookId.', \''.$url.'\')">'.$value.'</a></li>';
		}
		return $html;
	}
	
	public function actionChangeBkType($bookId, $typeId)
	{
		$db = Yii::app()->db; 
		// update:
		$rows = $db->createCommand()->update(
			'tb_books',   // table name
			array('book_type' => $typeId),  // update item
			'id=:id', array(':id' => $bookId) // where conditions
			); 
		
		// load booktype:
		$sql = "select type_name from tb_books_type where id=(select book_type from tb_books where id=".$bookId.");";
		$ResultBooksType = $db->createCommand($sql)->query();
		$row = $ResultBooksType->read();
		$typeName = $row["type_name"];
		
		// response result:
		if($rows >0)
			echo $typeName."[<font color='green'>ok</font>]";
		else 
			echo $typeName."[<font color='red'>Failed</font>]";
	}
	
	public function actionReservePopView()
	{
		if(isset($_GET["bkid"]))
		{
			$bookid = $_GET["bkid"];
			if(isset($_REQUEST["user_id"]) && !empty($_REQUEST["user_id"]))
			{
				Yii::app()->session['preBorrower'] = $_REQUEST["user_id"];
			}
			$resultBook = Books::model()->findByAttributes(array('id'=>$bookid));
			
			if(isset($resultBook))
			{
				$resultBookType = BooksType::model()->findByAttributes(array('id'=>$resultBook->book_type));
				
				$this->renderPartial('reserve', array(
					"ResultBooks"=>$resultBook, 
					'BookTypeArray'=>$this->getRsBookTypeAsArray(),
					'ResultBookType'=>$resultBookType,
					));
			}
			else 
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
		}
		else 
		{
				$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
	}
	
	public function actionReserve()
	{
			if(!isset($_POST['BooksHistory']))
			{
				$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
			}
			else 
			{
				try 
				{
					$book = Books::model()->findByAttributes(array('id'=>$_POST['BooksHistory']['book_id'], 'status'=>'0'));
					if(!isset($book))
					{
						$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
						return;
					}
					$user = Users::model()->findByAttributes(array('nsn_id'=>$_POST['BooksHistory']['user_id']));
					if(!isset($user))
					{
						if(isset($_POST['user_email'])) // regist automatically
						{
							$user = registByNsnIdAndEmail($_POST['BooksHistory']['user_id'], $_POST['user_email']);
							if(!isset($user) || empty($user))
							{
								$this->renderPartial('reserveok', array("message"=>"Regist failed, please make sure nsn id and email not registed!"));
							}
						}
						else
							$this->renderPartial('reserveok', array("message"=>"User not found and email not giving, please regist at first!"));
					}
					// check how many books inhand for the user:
					$inhandBooks = Books::model()->findAllByAttributes(array("holder_nsn_id"=>$user->nsn_id, "status"=>"1"));
					if(isset($inhandBooks))
					{
						$totalBooks = 0;
						$totalMagazines = 0;
						$books = "";
						foreach($inhandBooks as $data)
						{
							if($data->book_type == 1 ){
								$totalBooks = $totalBooks+1;
							}
							else{
								$totalMagazines = $totalMagazines+1;
							}
							$books = $books."<li>".$data->book_name."</li>";
						}
						// if inhand books max than borrow limit, refuse to borrow:
						$booklimit = intval(SiteSystemParameters::getParmValue('BorrowBookLimits'));
						$magazinelimit = intval(SiteSystemParameters::getParmValue('BorrowMagazineLimits'));
						$booklimitForScrum = intval(SiteSystemParameters::getParmValue('ScrumLeaderBorrowBookLimits'));
						
						$borrowLimitExceed = false;
						$isScrumLeader = (isset($user->is_scrum_borrow_leader) && $user->is_scrum_borrow_leader==1 );
						if($book->book_type == 1){
							if($isScrumLeader ){
								$borrowLimitExceed = ($totalBooks >= $booklimitForScrum);
							}else if( $totalBooks >= $booklimit){
								$borrowLimitExceed = true;
							}
						}
						else if($book->book_type == 2 && $totalMagazines > ($magazinelimit-1)){
							$borrowLimitExceed = true;
						}
						
						if($borrowLimitExceed)
						{
							$msg = "<font color=#0088ff>Reserved failed!<br> <br>".
									"There are <font color=red>".$totalBooks."</font> books and <font color=red>".$totalMagazines."</font> magazines inhand and not returned for this User:<br>".
									"<br>".$books."<br>".
									"Only <font color=red>".$booklimit."</font> books and <font color=red>".$magazinelimit."</font> magazines for each User to borrow.<br>".
									"每人最多可同时借阅<font color=red><b> ".$booklimit."</b></font> 本书<font color=red>(Scrum借阅者为".$booklimitForScrum."本)</font>和  <font color=red><b>".$magazinelimit."</b></font> 本杂志。<br><br>".
									"<font color=red>本人为Scrum借阅者：".($isScrumLeader?"Yes":"No")."</font><br><br>".
									"Please return them at first!</font>";
							$this->renderPartial('reserveok', array("message"=>$msg));
							return;
						}
					}
					$curtime=getCurTime();
					$clientip=getClientIP();
					
					// for BooksHistory:
					$model = new BooksHistory();
					$model->attributes=$_POST['BooksHistory'];
					
					$model->librarian_borrow_id = RoleUtil::getUser()->nsn_id;
					$model->borrow_time = $curtime;
					$model->user_name = $user->user_name;
					$model->user_email = $user->email;
					$model->is_return = 0;
					$model->overdue_fine = 0;
					$model->book_name = $book->book_name;
					
					// for book:
					$book->book_admin = $model->librarian_borrow_id;
					$book->status = 1;
					$book->holder_nsn_id = $model->user_id;
					$book->holder_name = $model->user_name;
					$book->holder_email = $user->email;
					$book->fine_overdue_per_day = $model->fine_overdue_per_day;
					$book->borrowed_time = $curtime;
					$book->due_date = $model->return_time;
					$book->comments = $model->comments;
					$book->total_borrowed = $book->total_borrowed+1;
					
					if($book->update())
					{
						Yii::app()->session['preBorrower']=$book->holder_nsn_id;
						if($model->save())
						{
							$this->renderPartial('reserveok', array("message"=>"Book reserved successfully!"));
						}
						else // if save history failed, try again:
						{
							if($model->save())
							{
								$this->renderPartial('reserveok', array("message"=>"Book reserved successfully!"));
							}
							else 
							{
								$this->renderPartial('reserveok', array("message"=>"Book reserved successfully, but save history failed!"));
							}
						}
					}
					else // if save to book table failed:
					{
						$this->renderPartial('reserveok', array("message"=>"Book reserved failed, please try again!"));
					}
					
				}// end try
				catch(Exception $e)
				{
					$this->renderPartial('reserveok', array("message"=>"Book reserved failed!".$e->getMessage()));
				}
			}
	}
	public function actionLoademail()
	{
		try 
		{
			if(isset($_GET["nsnid"]))
			{
				try 
				{
					$user = Users::model()->findByAttributes(array('nsn_id'=>$_GET["nsnid"]));
					
					if(isset($user))
					{
						$booklist = Books::model()->findAllByAttributes(array("holder_nsn_id"=>$user->nsn_id, "status"=>"1"));
						$overdulenum=0;
						foreach($booklist as $data)
						{
							$totaldays = floor((time()-strtotime($data->due_date))/86400);
							$fine = $data->fine_overdue_per_day * $totaldays;
							if($fine>0)
							{
							 	$overdulenum++;
							}
						}
						if($overdulenum>0)
						{
							echo $user->email.";�? ".$overdulenum." 本书超期未归还，请先归还再�??!";
						}
						else 
						{
							echo $user->email;
						}
					}
					else 
					{
						// search from mvnforum:
						$user = getUserFromMvnforum($_GET["nsnid"]);
						//print_r($user);;
						if(isset($user))
						{
							echo $user->email;
						}
						else 
						{
							echo "Not regist, input email here";
						}
					}
				}
				catch(Exception $e)
				{
					echo "Load failed, try again!";
				}
			}
			else 
				echo "Try again";
		}
		catch(Exception $ex)
		{
			echo $ex->getMessage();
		}
	}
	public function actionReserveok()
	{
		$this->renderPartial('reserveok');
	}	
	
	public function actionReturnPopView()
	{
		if(isset($_GET["bkid"]))
		{
			$bookid = $_GET["bkid"];
			$resultBook = Books::model()->findByAttributes(array('id'=>$bookid));
			if(isset($resultBook))
			{
				$this->renderPartial('returnpopview', array("ResultBooks"=>$resultBook));
			}
			else 
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
		}
		else 
		{
			$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
	}
	public function actionReturn()
	{
			if(!isset($_POST['Books']))
			{
				$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
			}
			else 
			{
				try 
				{
					$book = Books::model()->findByAttributes(array('id'=>$_POST['Books']['book_id'], 'status'=>'1'));
					$model = BooksHistory::model()->findByAttributes(array('book_id'=>$_POST['Books']['book_id'], 'is_return'=>'0'));
					
					if(!isset($book))
					{
						$this->renderPartial('reserveok', array("message"=>"Book not found or is not available for this action, please refresh the page and try again from webpage!"));
						return;
					}
					else if(!isset($model))
					{
						// if not exist in BooksHistory, then create new:
						$model = new BooksHistory();
						$model->book_id = $book->id;
						$model->book_name = $book->book_name;
						$model->user_id = $book->holder_nsn_id;
						$model->fine_overdue_per_day = 0.2;
						$model->return_time = $book->due_date;
						$model->comments = "BooksHistory not found, create automatically!";
						
						$model->librarian_borrow_id = RoleUtil::getUser()->nsn_id;
						$model->borrow_time = $book->borrowed_time;
						$model->user_name = $book->holder_name;
						$model->user_email = $book->holder_email;
						$model->is_return = 0;
						$model->overdue_fine = 0;						
					}
					if($book->holder_nsn_id != ""){
						$model->user_id = $book->holder_nsn_id;
					}
					$model->return_time = $book->due_date;
						
					$curtime=getCurTime();
					$clientip=getClientIP();
					
					// for BooksHistory:
					$model->librarian_return_id = RoleUtil::getUser()->nsn_id;
					$model->actual_return_time = getCurTime();
					$model->is_return = 1;
					$model->comments =  $_POST['comments'];
					
					// for fine:
					$model->overdue_fine = $_POST['overdue_fine'];
					$model->fine_notify_times=0;
					$model->fine_lastnotify_time=longDate("2117-10-01");
					$model->fine_is_paid=0;
					$model->fine_paid_time=longDate("2117-10-01");
					$model->pay_password="".getRandNum(4);
					
					// save borrow time:
					$firstBorrowTime = $book->borrowed_time;
					
					// for book:
					$book->status = 0;
					$book->holder_nsn_id = "";
					$book->holder_name = "";
					$book->return_time = getCurTime();
					$book->due_date = getCurTime();
					$book->comments = $_POST['comments'];
					$book->notify_email_times=0;
					
					if($model->save())
					{
						if($book->update())
						{
							$waiting = BooksWaiting::model()->findByAttributes(
								array('book_id'=>$book->id, 'status'=>array(0)),
								new CDbCriteria(array("order"=>"id ", "limit"=>"1"))// ,"limit"=>"20", "offset"=>"0" // limit 0,20
								);
							
							$waitstr = "";
							if(isset($waiting))
							{
								$waitstr = $waitstr.'<br><br><a href="#" onclick=\'dlgload("'.$this->createUrl('notifyWaitingForReturn',array('id'=>$waiting->id)).'")\' class="btn btn-info">Notify the waiting reader</a>';
							}
							
							// fine email:
							$emailstr = "";
							if($model->overdue_fine > 0){
								$emailstr = "<br>".$emailstr.'<br><br><a href="#" onclick=\'dlgload("'.$this->createUrl('notifyFineForReturn',array('id'=>$model->id)).'")\' class="btn btn-info">发送罚款通知邮件</a><br><br>Email: '.$model->user_email.'<br><font color=red>罚款金额： '.$model->overdue_fine.' 元</font>';
							}
							
							// add score:
							$awardScorestr = "";
							try{
								if(isset($model->return_time)){
									$totaldays = floor((strtotime($model->return_time)-time())/86400);
									$totalRenewdays = floor((strtotime($model->borrow_time)-strtotime($firstBorrowTime))/86400);
									$timeStr = $firstBorrowTime."-->".$model->borrow_time."-->".$model->return_time;
									if( $totaldays>=0 && $totaldays<15  && $totalRenewdays >-3 && $totalRenewdays <3 ){
										$scoreForReturnBook = intval(SiteSystemParameters::getParmValue('AwardScoreForReturnBookNoDelay'));
										$scoreAction = "图书提前归还奖励: ".$model->book_name.", Borrowed on ".longDate($model->borrow_time);
										addUserScore($model->user_id, $scoreAction, $scoreForReturnBook, "System" );
										$awardScorestr = "<br><br><font color=red>提前归还，已奖励积分：".$scoreForReturnBook."</font>".$timeStr;
									}
									else{
										$awardScorestr = "<br><br><font color=red>超期归还或续借书，无积分奖励.</font>".$timeStr;
									}
								}	
							}catch(Exception $e2){
							}						
							
							$this->renderPartial('reserveok', array("message"=>"Book return successfully!".$waitstr.$emailstr.$awardScorestr));
						}
						else 
						{
							$this->renderPartial('reserveok', array("message"=>"Book return failed, please try again!"));
						}
					}
					else 
					{
						$this->renderPartial('reserveok', array("message"=>"Book return failed!"));
					}
				}// end try
				catch(Exception $e)
				{
					$this->renderPartial('reserveok', array("message"=>"Book return failed!".$e->getMessage()));
				}
			}
	}
	
	public function actionRenewPopView()
	{
		if(isset($_GET["bkid"]))
		{
			$bookid = $_GET["bkid"];
			$resultBook = Books::model()->findByAttributes(array('id'=>$bookid, 'status'=>'1'));
			if(isset($resultBook))
			{
				$resultBookType = BooksType::model()->findByAttributes(array('id'=>$resultBook->book_type));
				
				$this->renderPartial('renewpopview', array(
					"ResultBooks"=>$resultBook,
					'ResultBookType'=>$resultBookType,
					));
			}
			else 
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
		}
		else 
		{
			$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
	}
	
	public function actionRenew()
	{
		if(!isset($_POST['Books']))
		{
			$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
		else 
		{
			try 
			{
					$book = Books::model()->findByAttributes(array('id'=>$_POST['Books']['book_id'], 'status'=>'1'));
					$model = BooksHistory::model()->findByAttributes(array('book_id'=>$_POST['Books']['book_id'], 'is_return'=>'0'));
					if(!isset($book))
					{
						$this->renderPartial('reserveok', array("message"=>"Book[".$_POST['Books']['book_id']."] not found 1 or is not available for this action, please refresh the page and try again from webpage!"));
						return;
					}
					
					$curtime=getCurTime();
					$clientip=getClientIP();
					
					if(isset($model))
					{
						//$this->renderPartial('reserveok', array("message"=>"Book[".$_POST['Books']['book_id']."] not found 2 or is not available for this action, please refresh the page and try again from webpage!"));
						//return;
						
						// for BooksHistory:
						$model->librarian_return_id = RoleUtil::getUser()->nsn_id;
						$model->actual_return_time = getCurTime();
						$model->is_return = 1;
						$model->overdue_fine = $_POST['Books']['overdue_fine'];
						$model->comments =  $_POST['Books']['comments'];
						
						if(!$model->update())
						{
							$this->renderPartial('reserveok', array("message"=>"Book renew failed, failed to update old records, please try again!"));
							return ;
						}
					}
					
					// for book:
					$book->due_date = date('Y-m-d H:i:s', strtotime($_POST['Books']['new_due_date']));
					$book->notify_email_times=0;
					$book->comments =  $_POST['Books']['comments'];//Renew on ".$curtime." by ".$model->librarian_return_id;

					// for BooksHistory:
						$newmodel = new BooksHistory();
						$newmodel->book_id = $book->id;
						$newmodel->librarian_borrow_id = RoleUtil::getUser()->nsn_id;
						$newmodel->librarian_return_id = RoleUtil::getUser()->nsn_id;
						$newmodel->return_time = $book->due_date;
						$newmodel->book_name = $book->book_name;
						$newmodel->comments = $book->comments;
						$newmodel->fine_overdue_per_day = $book->fine_overdue_per_day;												
						
						$newmodel->borrow_time = $curtime;
						$newmodel->user_id = $book->holder_nsn_id;
						$newmodel->user_name = $book->holder_name;
						$newmodel->user_email = $book->holder_email;
						$newmodel->is_return = 0;
						$newmodel->overdue_fine = 0;
						
						if($newmodel->save())
						{						
							if($book->update())
							{
								$this->renderPartial('reserveok', array("message"=>"Book renew successfully!<br><br>"));
							}
							else 
							{
								$this->renderPartial('reserveok', array("message"=>"Book renew failed, please try again!"));
							}
						}
						else 
						{
							$this->renderPartial('reserveok', array("message"=>"Book boororw failed, please try again!"));
						}
			}
			catch(Exception $e)
			{
				$this->renderPartial('reserveok', array("message"=>"Book notify failed!".$e->getMessage()));
			}
		}
	}
			
	public function actionRemovePopView()
	{
		if(isset($_GET["bkid"]))
		{
			$bookid = $_GET["bkid"];
			$resultBook = Books::model()->findByAttributes(array('id'=>$bookid, 'status'=>'0'));
			if(isset($resultBook))
			{
				$this->renderPartial('removepopview', array("ResultBooks"=>$resultBook));
			}
			else 
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
		}
		else 
		{
			$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
	}
	
	public function actionRemove()
	{
		try 
		{
			$book = Books::model()->findByAttributes(array('id'=>$_POST['Books']['book_id'], 'status'=>'0'));
			if(!isset($book))
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else 
			{
				$curtime=getCurTime();
				$clientip=getClientIP();
				$book->status = 2;
				$book->holder_nsn_id = "";
				$book->holder_name = "";
				$book->return_time = getCurTime();
				$book->due_date = getCurTime();
				$book->remove_time = $curtime;
				$book->remover_nsn_id = RoleUtil::getUser()->nsn_id;
				$book->comments = $_POST['comments'];
				
				if($book->update())
				{
					$this->renderPartial('reserveok', array("message"=>"The book removed successfully!"));
				}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Book removed failed, please try again!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Book remove failed!".$e->getMessage()));
		}
	}
	
	public function actionUserDuty()
	{
		try 
		{
			$book = Books::model()->findByAttributes(array('id'=>$_POST['Books']['book_id'], 'status'=>'0'));
			if(!isset($book))
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else 
			{
				$curtime=getCurTime();
				$clientip=getClientIP();
				$book->status = 2;
				$book->holder_nsn_id = "";
				$book->holder_name = "";
				$book->return_time = getCurTime();
				$book->due_date = getCurTime();
				$book->remove_time = $curtime;
				$book->remover_nsn_id = RoleUtil::getUser()->nsn_id;
				$book->comments = $_POST['comments'];
				
				if($book->update())
				{
					$this->renderPartial('reserveok', array("message"=>"The book removed successfully!"));
				}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Book removed failed, please try again!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Book remove failed!".$e->getMessage()));
		}
	}	
	public function actionRestorePopView()
	{
		if(isset($_GET["bkid"]))
		{
			$bookid = $_GET["bkid"];
			$resultBook = Books::model()->findByAttributes(array('id'=>$bookid, 'status'=>'2'));
			if(isset($resultBook))
			{
				$this->renderPartial('restorepopview', array("ResultBooks"=>$resultBook));
			}
			else 
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
		}
		else 
		{
			$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
	}
	
	public function actionRestore()
	{
		try 
		{
			$book = Books::model()->findByAttributes(array('id'=>$_POST['Books']['book_id'], 'status'=>'2'));
			if(!isset($book))
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else 
			{
				$curtime=getCurTime();
				$clientip=getClientIP();
				$book->status = 0;
				$book->book_admin = RoleUtil::getUser()->nsn_id;
				$book->comments = $_POST['comments'];
				
				if($book->update())
				{
					$this->renderPartial('reserveok', array("message"=>"The book restored successfully!"));
				}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Book restored failed, please try again!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Book restored failed!".$e->getMessage()));
		}
	}
	
	public function actionSummary2years()
	{
		try 
		{
			$currentPage = 0;
			$pageSize = 15;
			if(isset($_REQUEST['page']))
			{
				$currentPage = intval($_REQUEST['page']);
			}	
			
			$wheresql="";
			if(isset($_REQUEST['book_name']) && !empty($_REQUEST['book_name']))
			{
				$bkname=$_REQUEST['book_name'];
				$bkname=str_replace("'","",$bkname);
				$wheresql=" and  book_name like '%".$bkname."%' ";
			}
			
			$sql="select * from (SELECT id,book_id, status, 
				(select count(*) from db_cdtu.tb_books_history where book_id=a.id  and borrow_time>'2016-1-1' and borrow_time<'2017-1-1') total_2016, 
				(select count(*) from db_cdtu.tb_books_history where book_id=a.id  and borrow_time>'2017-1-1' and borrow_time<'2018-1-1') total_2017, 
				(select count(*) from db_cdtu.tb_books_history where book_id=a.id  and borrow_time>'2018-1-1' and borrow_time<'2019-1-1') total_2018, 
				(select count(*) from db_cdtu.tb_books_history where book_id=a.id  and borrow_time>'2019-1-1') total_2019, 
				(select count(*) from db_cdtu.tb_books_history where book_id=a.id  and borrow_time>'2016-1-1') total_from_2016, 
				book_name
				FROM db_cdtu.tb_books a where (status=0 or status=3) ".$wheresql.") bb  
				order by total_from_2016 desc";// limit ".(($currentPage)*$pageSize).",".$pageSize.";";
			
			$connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$dataReader=$command->query();
			$rows=$dataReader->readAll();
			
			$totalItemCount = count($rows);
			$pageCount = ceil($totalItemCount/$pageSize);
			$itemCount = count($rows);
			
			$command = $connection->createCommand($sql." limit ".(($currentPage)*$pageSize).",".$pageSize);
			$dataReader=$command->query();
			$rows=$dataReader->readAll();
			
			$page = array(
				'totalItemCount'=>$totalItemCount,
				'pageCount'=>$pageCount,
				'itemCount'=>$itemCount,
				'currentPage'=>$currentPage,
			);
			
			$this->renderPartial('summary2years',array(
				'ResultWaitings'=>$rows,
				'page'=>$page,
				'pageSize'=>$pageSize,
			));
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"View notification page failed!".$e->getMessage()));
		}	
	}
	
	public function actionSetBookInLibrary(){
		try 
		{
			$book = Books::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(!isset($book))
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else 
			{
				$curtime=getCurTime();
				$clientip=getClientIP();
				$book->status = 0;
				
				if($book->update())
				{
					$this->actionSummary2years();
					//$this->renderPartial('reserveok', array("message"=>"The book changed successfully!"));
				}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Book changed failed, please try again!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Book changed failed!".$e->getMessage()));
		}
		
	}
	
	public function actionSetBookToFreeBorrow(){
		try 
		{
			$book = Books::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(!isset($book))
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else 
			{
				$curtime=getCurTime();
				$clientip=getClientIP();
				$book->status = 3;
				$book->remove_time = $curtime;
				$book->remover_nsn_id = RoleUtil::getUser()->nsn_id;
				
				if($book->update())
				{
					$this->actionSummary2years();
					//$this->renderPartial('reserveok', array("message"=>"The book changed successfully!"));
				}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Book changed failed, please try again!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Book changed failed!".$e->getMessage()));
		}
	}
	
	public function actionNotifyView()
	{
		try 
		{
			$currentPage = 0;
			$pageSize = 20;
			if(isset($_REQUEST['page']))
			{
				$currentPage = intval($_REQUEST['page']);
			}		
			
			$criteria=new CDbCriteria;   
			$criteria->addCondition("status=1", "and");
			$criteria->addCondition("datediff(due_date,now())<8", "and");
			
			$criteria->order = "due_date,notify_email_times, last_email_time ";
			$this->responseBooksByCriteria('notifyview', $currentPage, $pageSize, $criteria);
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"View notification page failed!".$e->getMessage()));
		}
	}
		
	public function actionNotifyPopView()
	{
		// if email disabled then cancel action:
		if(!(strtolower(SiteSystemParameters::getParmValue('EmailEnable'))=="yes"))
		{
			echo "<font color=red>Email disabled, Notification function disabled!<br>".
				"Please enable email at first!<br><br></font>";
			return;
		}
		
		if(isset($_GET["bkid"]))
		{
			$bookid = $_GET["bkid"];
			$resultBook = Books::model()->findByAttributes(array('id'=>$bookid, 'status'=>'1'));
			if(isset($resultBook))
			{
				$this->renderPartial('notifypopview', array("ResultBooks"=>$resultBook));
			}
			else 
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
		}
		else 
		{
			$this->renderPartial('reserveok', array("message"=>"Request parameter wrong, please refresh the page and try again from webpage!"));
		}
	}
	
	public function actionFinelistView()
	{
		try 
		{
			$currentPage = 0;
			$pageSize = 20;
			if(isset($_REQUEST['page']))
			{
				$currentPage = intval($_REQUEST['page']);
			}		
			
			$criteria=new CDbCriteria;   
			$criteria->addCondition("overdue_fine>0", "and");
			$criteria->addCondition("actual_return_time>'2017-09-15'", "and");
			
			$criteria->order = "actual_return_time desc ";
			$this->responseBooksHistoryByCriteria('finelist', $currentPage, $pageSize, $criteria);
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"View notification page failed!".$e->getMessage()));
		}
	}
	
	public function responseBooksHistoryByCriteria($view, $currentPage, $pageSize, $criteria)
	{
		$dataProvider=new CActiveDataProvider('BooksHistory', array(
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
		
		$booklist = $dataProvider->getData();
		$booyTypeArray = $this->getRsBookTypeAsArray();
		
		$this->renderPartial($view,array(
			'ResultBooks'=>$booklist,
			'page'=>$page,
			'BookTypeArray'=>$booyTypeArray,
		));			
	}
		
	public function actionWaitingView()
	{
		try 
		{
			$currentPage = 0;
			$pageSize = 15;
			if(isset($_REQUEST['page']))
			{
				$currentPage = intval($_REQUEST['page']);
			}	
				
			$criteria=new CDbCriteria;   
			$criteria->addCondition("status=0 or status=1", "and");
			//$criteria->addCondition("status=0 or status=1", "and");
			
			if(isset($_REQUEST['book_name']) && !empty($_REQUEST['book_name']))
			{
				$criteria->addCondition("book_name like :book_name", "and");
				$criteria->params[':book_name']="%".$_POST["book_name"]."%";
			}
			if(isset($_REQUEST['holder_nsn_id']) && !empty($_REQUEST['holder_nsn_id']))
			{
				$criteria->addCondition("user_id=:user_id", "and");
				$criteria->params[':user_id']=$_POST["holder_nsn_id"]; 
			}
			//$criteria->order = "status desc, book_id, id";
			$criteria->order = "join_time desc, status desc, book_id, id";
			
			$dataProvider=new CActiveDataProvider('BooksWaiting', array(
				'criteria'=>$criteria, //array(
					//'order'=>'status desc, book_id, id desc',
					//'condition'=>'status=0 or status=1', 
					//'params'=>array(':user_id'=>RoleUtil::getUser()->nsn_id),
				//),
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
			
			$this->renderPartial('waitingview',array(
				'ResultWaitings'=>$ResultWaitings,
				'page'=>$page,
				'pageSize'=>$pageSize,
			));
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"View notification page failed!".$e->getMessage()));
		}	
	}
	
	public function actionNotifyWaitingForReturn()
	{
		try 
		{
			if(!isset($_REQUEST['id']))
			{
				$this->renderPartial('reserveok', array("message"=> "Parameter not right! Please try again from webpage!"));
			}
			else
			{
				if($this->notifyWaiting($_REQUEST['id']))
				{
					$this->renderPartial('reserveok', array("message"=>"Notify successfully!"));
									}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Call NotifyWaiting failed: update the records failed, no notify email sended!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Call NotifyWaiting failed!".$e->getMessage()));
		}	
		
	}
	
	public function actionNotifyFineForReturn()
	{
		try 
		{
			if(!isset($_REQUEST['id']))
			{
				$this->renderPartial('reserveok', array("message"=> "Notify fine failed: Parameter not right! Please try again from webpage!"));
			}
			else
			{
				if($this->notifyFine($_REQUEST['id'])){
					$this->renderPartial('reserveok', array("message"=>"Notify fine successfully!"));
				}
				else{
					$this->renderPartial('reserveok', array("message"=>"Notify fine failed: Book history not found!"));
				}
							}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Notify fine failed!".$e->getMessage()));
		}	
		
	}	
	
	public function actionNotifyFines()
	{
		try 
		{
			if(!isset($_REQUEST['ids']))
			{
				$this->renderPartial('reserveok', array("message"=> "Notify fine failed: Parameter not right! Please try again from webpage!"));
			}
			else
			{
				$ids = $_REQUEST["ids"];
				
				$id_array = explode(",", $ids);
				foreach ($id_array as $history_id)
				{
					if(isset($history_id)){
						$this->notifyFine($history_id);
					}
				}
				$this->actionFinelistView();
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Notify fine failed!".$e->getMessage()));
		}	
		
	}
	
	private function notifyFine($history_id)
	{
		$model = BooksHistory::model()->findByAttributes(array("id"=>$history_id));
		if(isset($model))
		{
			$user = Users::model()->findByAttributes(array("nsn_id"=>$model->user_id));
			if(!isset($user)){
				$this->renderPartial('reserveok', array("message"=>"Notify fine failed: User not found!"));
			}
			else{	
				sendFineNotify($model, $user);
	
				$model->fine_notify_times = $model->fine_notify_times+1;
				$model->fine_lastnotify_time = getCurTime();
				return $model->save();
				
				//$this->renderPartial('reserveok', array("message"=>"Notify fine successfully!"));
			}
		}
		else{
			return false;
			//$this->renderPartial('reserveok', array("message"=>"Notify fine failed: Book history not found!"));
		}
	}
	
	public function actionChangeToPaid(){
		try 
		{
			if(!isset($_REQUEST['id']))
			{
				$this->renderPartial('reserveok', array("message"=> "Notify fine failed: Parameter not right! Please try again from webpage!"));
				$this->actionFinelistView();
			}
			else
			{
				$model = BooksHistory::model()->findByAttributes(array("id"=>$_REQUEST['id']));
				if(!isset($model)){
					$this->renderPartial('reserveok', array("message"=> "Record not found!"));
					$this->actionFinelistView();
				}
				else
				{
					$model->fine_is_paid=1;
					$model->fine_paid_time=getCurTime();
					
					if($model->save()){
						$this->actionFinelistView();
					}
					else{
						$this->renderPartial('reserveok', array("message"=>"Failed: please retry!"));
						$this->actionFinelistView();
					}
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Failed!".$e->getMessage()));
			$this->actionFinelistView();
		}	
	}
		
	public function actionNotifyWaiting()
	{
		try 
		{
			if(!isset($_REQUEST['id']))
			{
				$this->renderPartial('reserveok', array("message"=> "Notify waiting book failed: Parameter not right! Please try again from webpage!"));
			}
			else
			{
				if($this->notifyWaiting($_REQUEST['id']))
				{
					$this->renderPartial('reserveok', array("message"=>"Notify waiting book successfully!"));
					//$this->actionWaitingView();
				}
				else 
				{
					$this->renderPartial('reserveok', array("message"=>"Notify waiting book failed: update the records failed, no notify email sended!"));
				}
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Notify waiting book failed: ".$e->getMessage()));
		}	
	}
	
	private function notifyWaiting($waiting_id)
	{
		$model = BooksWaiting::model()->findByAttributes(array("id"=>$waiting_id));
		if(isset($model))
		{
			$user = Users::model()->findByAttributes(array("nsn_id"=>$model->user_id));
			if(!isset($user)){
				$this->renderPartial('reserveok', array("message"=>"Notify waiting book failed:  User not found!"));
				return;
			}
				
			$model->libration_user_id = RoleUtil::getUser()->nsn_id;
			$model->status = 1;
			$model->inbooking_time = getCurTime();
				
			if($model->save())
			{
				sendWaitingNotify($model, $user);
				return true;
			}
		}
		
		return false;
	}
	
	public function actionCancelWaiting()
	{
		try 
		{
			if(!isset($_REQUEST['book_id']) || !isset($_REQUEST['user_id']))
			{
				$this->renderPartial('reserveok', array("message"=> "Parameter not right! Please try again from webpage!"));
			}
			else
			{
				BooksWaiting::model()->updateAll(
					array("status"=>"4", "libration_user_id"=>RoleUtil::getUser()->nsn_id, "cancel_time"=>getCurTime()),
					"book_id=:book_id and user_id=:user_id and (status=0 or status=1)", 
					array(":book_id"=>$_REQUEST['book_id'], ":user_id"=>$_REQUEST['user_id'])					
					);
				
				$this->actionWaitingView();	
			}
			
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Call CancelWaiting failed!".$e->getMessage()));
		}	
	}
	
	private function notifyBook($book_id, $comments)
	{
			$book = Books::model()->findByAttributes(array('id'=>$book_id, 'status'=>'1'));
			if(!isset($book))
			{
				return -1;
				//$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else 
			{
				$user = Users::model()->findByAttributes(array('nsn_id'=>$book->holder_nsn_id));
				
				$curtime=getCurTime();
				$clientip=getClientIP();
				//$book->status = 0;
				$book->book_admin = RoleUtil::getUser()->nsn_id;
				$book->comments = "";//$comments;
				$book->notify_email_times = $book->notify_email_times+1;
				$book->last_email_time = getCurTime();
				$totaldays = floor((time()-strtotime($book->due_date))/86400);
				if($totaldays<1){
					$totaldays=0;
				}
				
				$msg = "The return time of your borrowed book arrived, please return it on time:<br><br>".
						"Book Name: ".$book->book_name."<br>".
						"book ID: <a href='".getRequestRootUrl().Yii::app()->createUrl('library/search/viewfull', array('bkid'=>$book->id))."'>".$book->book_id."</a><br><br>".
						//"Publisher: ".$book->publisher."<br>".
						"Borrowed Time: ".$book->borrowed_time."<br>".
						"Overdue Time: ".$book->due_date."<br>".
						"已超期: ".$totaldays."天<br><br>".
						"图书借阅期： 1 个月，杂志借阅期： 2 周<br>".
						"如超期归还，将每天征收罚金: ".$book->fine_overdue_per_day." 元<br>"
						;
				
				// send email:
				sendBookNotifyEmail($user, $msg);
				
				if($book->update())
				{
					return 1;
					//$this->renderPartial('reserveok', array("message"=>"The book notify successfully!"));
				}
				else 
				{
					return 0;
					//$this->renderPartial('reserveok', array("message"=>"Book notify failed, please try again!"));
				}
			}	
	}
	
	public function actionNotify()
	{
		try 
		{
			$code = $this->notifyBook($_POST['Books']['book_id'],$_POST['comments']);
			if($code==-1)
			{
				$this->renderPartial('reserveok', array("message"=>"Book not found or is bot available for this action, please refresh the page and try again from webpage!"));
			}
			else if($code == 1)
			{
				$this->renderPartial('reserveok', array("message"=>"The book notify successfully!"));
			}
			else 
			{	
				$this->renderPartial('reserveok', array("message"=>"Book notify failed, please try again!"));
			}
		}
		catch(Exception $e)
		{
			$this->renderPartial('reserveok', array("message"=>"Book notify failed!".$e->getMessage()));
		}
	}		
	
	public function actionNotifyall()
	{
		try 
		{
			if(!isset($_REQUEST["book_ids"]))
			{
				$this->actionNotifyView();
				return;
			}
			else 
			{
				$ids = $_REQUEST["book_ids"];
				$comments = "Notified by group by ".RoleUtil::getUser()->nsn_id." on ".getCurTime();
				
				$id_array = explode(",", $ids);
				foreach ($id_array as $book_id)
				{
					if(isset($book_id))
						$code = $this->notifyBook($book_id,$comments);
				}
				$this->actionNotifyView();
			}
			
		}
		catch(Exception $e)
		{
			$this->actionNotifyView();
		}
			
	}
	
	public function actionUserScoreView()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		

		$dataProvider=new CActiveDataProvider('UsersScoreHistory', array(
			'criteria'=>array(
				'order'=>'id desc',
				'condition'=>'is_deleted=0', 
			),
			'pagination'=>array(
				'currentPage'=>$currentPage,
				'pageSize'=>$pageSize,
			),
		));
		
		if(isset($_POST["user_id"]) && !empty($_POST["user_id"])){
			$dataProvider->criteria->addCondition("user_id=:user_id", "and");
			$dataProvider->criteria->params[':user_id']=$_POST["user_id"];
		}
		
		if(isset($_POST["user_email"]) && !empty($_POST["user_email"])){
			$dataProvider->criteria->addCondition("user_email like :user_email", "and");
			$dataProvider->criteria->params[':user_email']="%".$_POST["user_email"]."%";
		}
		
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
		
		$this->renderPartial('userScore',array(
			'ResultRecords'=>$ResultRecords,
			'page'=>$page,
			'message'=>$this->message,
		));	
	}	
	
	public function actionAddScore()
	{
		$this->message="Add success";
		try 
		{
			$role = RoleUtil::getUserLibraryRole();
			if(!isset($role) || $role<6)
			{
				$this->message="Add failed: have no right.";
			}
			else{
				if(isset($_POST["UsersScoreHistory"]))
				{
					addUserScore($_POST["UsersScoreHistory"]["user_id"], 
						$_POST["UsersScoreHistory"]["action"], $_POST["UsersScoreHistory"]["score"]
						, RoleUtil::getUser()->email."(".RoleUtil::getUser()->nsn_id.")");
				}else{
					$this->message="Add failed: wrong request, please retry.";
				}
			}
		}
		catch(Exception $e)
		{
			$this->message="Add failed:".$e->getMessage();
		}	
		
		$this->actionUserScoreView();	
	}

	
	public function actionUserScrumView()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		

		$dataProvider=new CActiveDataProvider('Users', array(
			'criteria'=>array(
				'order'=>'id desc',
				'condition'=>'is_scrum_borrow_leader=1', 
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
		
		$this->renderPartial('userScrum',array(
			'ResultRecords'=>$ResultRecords,
			'page'=>$page,
			'message'=>$this->message,
		));	
	}	
	
	public function actionAddScrumUser()
	{
		$this->message="Add success";
		try 
		{
			$role = RoleUtil::getUserLibraryRole();
			if(!isset($role) || $role<6)
			{
				$this->message="Add failed: have no right.";
			}
			else{
				if(isset($_POST["user_id"]))
				{
					$user = Users::model()->findByAttributes(array('nsn_id'=>strtolower($_POST["user_id"])));
					if(!isset($user)){
						$this->message= "用户没找到，请刷新重试";
					}else{
						$updateAttributes = array(
							'is_scrum_borrow_leader'=>'1', 
							'scrum_name'=>$_POST["scrum_name"], 
						);
						$count = Users::model()->updateByPk($user->id, $updateAttributes);
						$this->message="Add success";
					}
				}else{
					$this->message="Add failed: wrong request, please retry.";
				}
			}
		}
		catch(Exception $e)
		{
			$this->message="Add failed:".$e->getMessage();
		}	
		
		$this->actionUserScrumView();	
	}
	
	public function actionDeleteScrumUser()
	{
		$this->message="Delete success";
		try 
		{
			$role = RoleUtil::getUserLibraryRole();
			if(!isset($role) || $role<6)
			{
				$this->message="Add failed: have no right.";
			}
			else{
				if(isset($_REQUEST["id"]))
				{
					$user = Users::model()->findByPk($_REQUEST["id"]);
					if(!isset($user)){
						$this->message= "用户没找到，请刷新重试";
					}else{
						$updateAttributes = array(
							'is_scrum_borrow_leader'=>'0', 
						);
						$count = Users::model()->updateByPk($user->id, $updateAttributes);
						$this->message="Delete success";
					}
				}else{
					$this->message="Add failed: wrong request, please retry.";
				}
			}
		}
		catch(Exception $e)
		{
			$this->message="Add failed:".$e->getMessage();
		}	
		
		$this->actionUserScrumView();	
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
	
	public function parseBookStatus($reBookStatus)
	{
		switch ($reBookStatus)
		{
			case 0:
			  echo "Available";
			  break;
			case 1:
			  echo "Not Available";
			  break;
			default:
			  echo "Available";
		}
	}
}