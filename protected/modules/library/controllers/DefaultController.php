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
		$db = Yii::app()->db; 
		
		addVisitorStatistics("", 1,1);

		//$sql = "select id,title,last_modified,module from tb_news where module=:module order by last_modified desc limit 0,13;";
		//$ResultLibraryNews = $db->createCommand($sql)->query(array(":module"=>"library"));
		
		$sql = "select id,book_name,total_clicks,liked_num from tb_books where status<>2 order by total_clicks desc, id desc limit 0,20;";
		$ResultMostClicked = $db->createCommand($sql)->query();

//		$sql = "select id,book_name,total_saygood,liked_num from tb_books where status<>2 order by total_saygood desc, id desc limit 0,10;";
//		$ResultMostLiked = $db->createCommand($sql)->query();

		//$sql = "select id,book_name,total_borrowed,liked_num from tb_books where status<>2 order by total_borrowed desc, id desc limit 0,20;";
		$sql = "SELECT book_id as id ,book_name,count(*) as total_borrowed FROM tb_books_history where borrow_time>'2016-1-1' group by  book_id order by total_borrowed desc limit 0, 30;";
		$ResultMostBorrowed = $db->createCommand($sql)->query();
		
		// last added book first:
		$sql = "select id,book_name,book_logo from tb_books where status<>2 order by id desc limit 0,5;";
		$ResultNewstBooks = $db->createCommand($sql)->query();
		
		// last returned book first:
		$sql = "select id,book_name,book_logo from tb_books where status=0 order by return_time desc, id desc limit 0,28;";
		$ResultNewAvail = $db->createCommand($sql)->query();
		
		$sql = "select id,book_name,holder_name, holder_nsn_id,due_date,fine_overdue_per_day from tb_books where status=1 order by due_date, borrowed_time limit 0,10;";
		$ResultOverDue = $db->createCommand($sql)->query();
		
		$sql = "select * from tb_visitor_statistics order by id desc limit 0,21;";
		$ResultVisitors = $db->createCommand($sql)->query();
		
		$sql = "select nsn_id,user_name, email,seat from tb_users u, tb_users_role r where r.user_id=u.nsn_id and role_library>0 order by seat desc, u.id desc";
		$librations = $db->createCommand($sql)->query();
		
		$sql = "SELECT sum(total_clicks) as searched, sum(total_saygood) as saygood,
			(select count(1) from tb_books where status<2) as totalbooks,
			(select count(1) from tb_books where status=1) as book_borrowed,
			(select count(1) from tb_books_history) as borrowed_total,
			(select count(distinct book_id) from tb_books_history) as borrowed_users,
			(select sum(clicks) from tb_visitor_statistics) as total_visitor,
			(select CONCAT(year,'-',month,'-',day,',',clicks) from tb_visitor_statistics order by clicks desc limit 0,1) as max_date,
			(select count(1) from tb_books_history where actual_return_time>return_time) as over_due_times,
      		(select sum(overdue_fine) from tb_books_history  where is_return=1) as fin_received,
      		(select sum(TIMESTAMPDIFF(DAY, return_time, now())*fine_overdue_per_day)  from tb_books_history  where is_return=0 and return_time<now()) as fin_need
			 FROM tb_books;";
		$command=$db->createCommand($sql);
		$ResultLibSummary = $command->queryRow();
		
		$this->render('index', array(
				"ResultLibSummary"=>$ResultLibSummary,
				//"ResultLibraryNews"=>$ResultLibraryNews, 
				"ResultMostBorrowed"=>$ResultMostBorrowed,
//				"ResultMostLiked"=>$ResultMostLiked,
				"ResultMostClicked"=>$ResultMostClicked,
				"ResultNewstBooks"=>$ResultNewstBooks, 
				"ResultNewAvail"=>$ResultNewAvail, 
				"ResultOverDue"=>$ResultOverDue, 
				"ResultVisitors"=>$ResultVisitors, 
				"ResultVote"=>null,
				"ResultLibrations"=>$librations,
					)
				);
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
	
/*	
	public function actionAddnews()
	{
		if(isset($_POST["content"]))
		$model = new News();
		
		$model->title = "[LIBRARY]Comments & Suggest New Books";
		$model->content = $_POST["content"];
		$model->module = "library";
		$model->author_id = RoleUtil::getUser()->nsn_id;
		$model->created_time = getCurTime();
		$model->created_ip = getClientIP();
		$model->last_modified = getCurTime();
		$model->tags = "";
		$model->out_link = "";
		
		$model->save();
		
		Header("Location:".$this->createUrl("index"));
	}
	
	public function actionAddcomments()
	{
		if(isset($_POST["content"]))
		$model = new Comments();
		
		$model->title = "[LIBRARY]Comments & Suggest New Books";
		$model->content = $_POST["content"];
		$model->module = "library";
		$model->user_id = RoleUtil::getUser()->nsn_id;
		$model->add_time = getCurTime();
		$model->add_ip = getClientIP();
		$model->reply = "";
		
		$model->save();
		
		Header("Location:".$this->createUrl("index"));
	}
*/	
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
	
	public function parseReturnDate($reReturnDate)
	{
		$returndate = date('Y-m-d',strtotime($reReturnDate));
		if($returndate<=date('Y-m-d'))
		{
			return "";
		}
		return date('m-d',$returndate);
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