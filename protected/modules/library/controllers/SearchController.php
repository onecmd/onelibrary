<?php 

class SearchController extends Controller
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
		$booyTypeArray = $this->getRsBookTypeAsArray();
		$this->render('index', array(
			'BookTypeArray'=>$booyTypeArray,
			'BookCategory'=>$this->getRsBookCategory1(),
			'BookTypeCodes'=>$this->getRsBookTypeCodes(),
		));
	}

	public function getRsBookTypeCodes()
	{
		$db = Yii::app()->db; 
		$sql = "select type_name,type_code from tb_books_type where grade=1;";
		$ResultBooksType = $db->createCommand($sql)->query();
		
		$arBookType = array();
		foreach($ResultBooksType as $result)
		{
			$arBookType[$result["type_code"]]=$result["type_name"];
		}
		return $arBookType;
	}
	public function getRsBookCategory1()
	{
		$db = Yii::app()->db; 
		$sql = "select distinct category_1 from tb_books where category_1<>'';";
		$ResultBooksCategory = $db->createCommand($sql)->query();
		
		return $ResultBooksCategory;
	}
	
	public function actionList()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}		
		
		$criteria = $this->getCDbCriteria();
		$this->responseBooksByCriteria('list', $currentPage, $pageSize, $criteria);
	}
			
	public function actionImage()
	{
		$currentPage = 0;
		$pageSize = 30;
		if(isset($_REQUEST['page']))
		{
			$currentPage = intval($_REQUEST['page']);
		}	

		$criteria = $this->getCDbCriteria();
		$this->responseBooksByCriteria('image', $currentPage, $pageSize, $criteria);
	}
	public function actionShowType()
	{
		if(isset($_REQUEST['showType']) && $_REQUEST['showType'] == "image")
		{
			Yii::app()->session['showType'] = "image";
		}
		else
		{
			Yii::app()->session['showType'] = "list";
		}
		$this->actionIndex();
	}
	
	public function getCDbCriteria()
	{
		$criteria=new CDbCriteria;   
		if(isset($_REQUEST["Books"]))
		{
			if(!empty($_REQUEST["Books"]["book_id"]))
			{
				$criteria->addCondition("book_id=:book_id", "and");
				$criteria->params[':book_id']=$_REQUEST["Books"]["book_id"]; 
			}
			if(!empty($_REQUEST["Books"]["book_name"]))
			{
				$criteria->addCondition("book_name like :book_name", "and");
				$criteria->params[':book_name']="%".$_REQUEST["Books"]["book_name"]."%"; 
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
			if(!empty($_POST["Books"]["category_1"]))
			{
				$criteria->addCondition("category_1=:category_1", "and");
				$criteria->params[':category_1']=$_POST["Books"]["category_1"]; 
			}
			if(!empty($_POST["Books"]["location_building"]))
			{
				$criteria->addCondition("location_building=:location_building", "and");
				$criteria->params[':location_building']=$_POST["Books"]["location_building"]; 
			}
		}
		
		// sort by:
		$criteria->order = "total_saygood DESC, total_borrowed DESC, liked_num DESC, total_clicks DESC";	
		if(isset($_POST["Books"]["sort_by"]))
		{
			switch ($_POST["Books"]["sort_by"])
			{
				case "add_time":
					$criteria->order = "add_time";	
					break;
				case "add_time_desc":
					$criteria->order = "add_time DESC";	
					break;
				case "total_saygood":
					$criteria->order = "total_saygood DESC, total_borrowed DESC, liked_num DESC, total_clicks DESC";	
					break;
				case "total_borrowed":
					$criteria->order = "total_borrowed DESC, total_saygood DESC,liked_num DESC, total_clicks DESC";	
					break;
				case "total_clicks":
					$criteria->order = "total_clicks DESC, total_saygood DESC, total_borrowed DESC, liked_num DESC";	
					break;
				case "liked_num":
					$criteria->order = "liked_num DESC, total_borrowed DESC, total_saygood DESC, total_clicks DESC";	
					break;
				case "category_2":
					$criteria->order = "category_2, total_saygood DESC, total_borrowed DESC, liked_num DESC, total_clicks DESC";	
					break;
				case "book_name":
					$criteria->order = "book_name";	
					break;
				case "due_date":
					$criteria->order = "due_date DESC";	
					break;
				default:
					$criteria->order = "total_saygood DESC, total_borrowed DESC, liked_num DESC, total_clicks DESC";	
					break;	
			} // end sitch
		}	
		
		return $criteria;
	}
	
	public function actionViewfull()
	{
		if(isset($_REQUEST["bkid"])) 
		{
			$this->directViewFull($_REQUEST["bkid"]);
		}
		else 
		{
			$this->render(Yii::app()->createUrl('default/login'));
		}
	}
	
	private function directViewFull($book_id)
	{
			$model = Books::model()->findByAttributes(array('id'=>$book_id));
			if(isset($model))
			{
				// add clicks：
				$model->total_clicks = $model->total_clicks + 1;
				$model->save();
				
				$comments = BooksComments::model()->findAllByAttributes(
							array('book_id'=>$book_id), 
							new CDbCriteria(array("order"=>"add_time desc"))
							);
				$readhistory = BooksHistory::model()->findAllByAttributes(
							array('book_id'=>$book_id),
							new CDbCriteria(array("order"=>"borrow_time desc"))
							);
				$booklikes = BooksLikes::model()->findAllByAttributes(
							array('book_id'=>$book_id),
							new CDbCriteria(array("order"=>"add_time desc"))
							);
				$bookwaiting = BooksWaiting::model()->findAllByAttributes(
							array('book_id'=>$book_id, 'status'=>array(0,1)),
							new CDbCriteria(array("order"=>"status desc, id "))// ,"limit"=>"20", "offset"=>"0" // limit 0,20
							);
				$this->render('viewfull', 
					array("ResultBooks"=> $model, 
						"ResultBooksType"=>$this->getBookTypeList(),
						"Comments"=>$comments,
						"ReadHistory"=>$readhistory,
						"BookLikes"=>$booklikes,
						"BooksWaiting"=>$bookwaiting,
					));
			}
			else 
				$this->render('editok', array("message"=> "The book not found, Please try again from webpage!"));
		
	}
		
	public function actionSayGood()
	{
		$book_id = $_REQUEST["bkid"]; 
		if(!isset(Yii::app()->session['user']))
		{
			redirect(Yii::app()->createUrl('default/login'));
		}		
		else if(!isset($book_id))
		{
			$this->render('editok', array("message"=> "Parameter not right! Please try again from webpage!"));
		}
		else if(isset(Yii::app()->session["saygood_".$book_id]))
		{
			$this->render('editok', array("message"=> "您已经对该书点过赞啦!"));
		}
		else
		{
			$model = Books::model()->findByAttributes(array('id'=>$book_id));
			if(isset($model))
			{
				$model->total_saygood = $model->total_saygood+1;
				if($model->save())
				{
					Yii::app()->session["saygood_".$book_id] = "true";
				}
			}
			$this->directViewFull($book_id);
		}
	}
	
	public function actionLikeit()
	{
		$bookid = $_POST['bkid'];
		if(!isset(Yii::app()->session['user']))
		{
			redirect(Yii::app()->createUrl('default/login'));
		}
		else if(!isset($bookid))
		{
			$this->render('editok', array("message"=> "Parameter not right! Please try again from webpage!"));
		}
		else
		{
			$model = BooksLikes::model()->findByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id, "book_id"=>$bookid));
			if(!isset($model))
			{
				$model = new BooksLikes();
			}
			$model->book_id = $bookid;
			$model->book_name =  $_POST['book_name'];
			$model->user_id = RoleUtil::getUser()->nsn_id;
			$model->user_name = RoleUtil::getUser()->user_name;
			$model->is_like = 1;
			$model->add_time = getCurTime();
			
			if($model->save())
			{
				// add likes number:
				$book = Books::model()->findByAttributes(array("id"=>$bookid));
				if(isset($book))
				{
					$book->liked_num = $book->liked_num+1;
					$book->save();
				}
			}

			//$this->directViewFull($_REQUEST["book_id"]);
			header("location:".Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$bookid)));
		}		
	}	
	
	public function actionUnlikeit()
	{
		$bookid = $_POST['bkid'];
		if(!isset(Yii::app()->session['user']))
		{
			redirect(Yii::app()->createUrl('default/login'));
		}
		else if(!isset($bookid))
		{
			$this->render('editok', array("message"=> "Parameter not right! Please try again from webpage!"));
		}
		else
		{
			$delnum = BooksLikes::model()->deleteAllByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id, "book_id"=>$bookid));
			if($delnum>0)
			{
				$book = Books::model()->findByAttributes(array("id"=>$bookid));
				if(isset($book))
				{
					$book->liked_num = $book->liked_num-1;
					$book->liked_num = $book->liked_num>0?$book->liked_num:0;
					$book->save();
				}
			}
			/*
			 $model = BooksLikes::model()->findByAttributes(array("user_id"=>RoleUtil::getUser()->nsn_id, "book_id"=>$_POST['book_id']));
			if(!isset($model))
			{
				//$model = new BooksLikes();
			}
			else 
			{
				
				$model->book_id = $_POST['book_id'];
				$model->book_name =  $_POST['book_name'];
				$model->user_id = RoleUtil::getUser()->nsn_id;
				$model->user_name = RoleUtil::getUser()->user_name;
				$model->is_like = 0;
				$model->add_time = getCurTime();
				
				if($model->de)
				{
					// add likes number:
					$book = Books::model()->findByAttributes(array("id"=>$_POST['book_id']));
					if(isset($book))
					{
						$book->liked_num = $book->liked_num-1;
						$book->liked_num = $book->liked_num>0?$book->liked_num:0;
						$book->save();
					}
				}
			}
			*/			
			//$this->directViewFull($_REQUEST["book_id"]);
			header("location:".Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$bookid)));
		}
	}		
	
	public function actionAddComment()
	{
		if(!isset(Yii::app()->session['user']))
		{
			redirect(Yii::app()->createUrl('default/login'));
		}
		else if(!isset($_POST['book_id']) || !isset($_POST['comments']))
		{
			$this->render('editok', array("message"=> "Parameter not right or comments is empty! Please try again from webpage!"));
		}
		else
		{
			$comments = new BooksComments();
			$comments->book_id = $_POST['book_id'];
			$comments->comments = htmlspecialchars($_POST['comments']);
			$comments->user_id = RoleUtil::getUser()->nsn_id;
			$comments->user_name = RoleUtil::getUser()->user_name;
			$comments->score = 4;
			$comments->add_time = getCurTime();
			$comments->add_ip = getClientIP();
			
			$comments->save();
			
			//$this->directViewFull($_REQUEST["book_id"]);
			header("location:".Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$_POST['book_id'])));
		}
	}
	
	public function actionJoinWaiting()
	{
		try 
		{
			if(!isset(Yii::app()->session['user']))
			{
				redirect(Yii::app()->createUrl('default/login'));
			}
			else if(!isset($_REQUEST['book_id']) || !isset($_REQUEST['book_name']) || !isset($_REQUEST['id']))
			{
				$this->render('editok', array("message"=> "Parameter not right! Please try again from webpage!"));
			}
			else
			{
				$model = new BooksWaiting();
				$model->book_id = $_REQUEST["id"];
				$model->book_no = $_REQUEST["book_id"];
				$model->book_name = $_REQUEST["book_name"];
				$model->user_id = RoleUtil::getUser()->nsn_id;
				$model->user_name = RoleUtil::getUser()->user_name;
				$model->user_email = RoleUtil::getUser()->email;
				$model->join_time = getCurTime();
				$model->status = 0;
				
				//$model->borrowed_time = ;
				//$model->due_time = ;
				
				$model->save();
				
				//$this->directViewFull($_REQUEST["book_id"]);
				header("location:".Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$_REQUEST['id'])));
				
			}
		}
		catch(Exception $ex)
		{
			$this->render('editok', array("message"=> "Execute failed!".$ex->getMessage()));
		}
	}
	
	public function actionCancelWaiting()
	{
		try 
		{
			if(!isset(Yii::app()->session['user']))
			{
				redirect(Yii::app()->createUrl('default/login'));
			}
			else if(!isset($_REQUEST['book_id']))
			{
				$this->render('editok', array("message"=> "Parameter not right! Please try again from webpage!"));
			}
			else
			{
				BooksWaiting::model()->updateAll(
					array("status"=>"4", "cancel_time"=>getCurTime()),
					"book_id=:book_id and user_id=:user_id", 
					array(":book_id"=>$_REQUEST['book_id'], ":user_id"=>RoleUtil::getUser()->nsn_id)					
					);
				
				//$this->directViewFull($_REQUEST["book_id"]);
				header("location:".Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$_REQUEST['book_id'])));
			}
		}
		catch(Exception $ex)
		{
			$this->render('editok', array("message"=> "Execute failed!".$ex->getMessage()));
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
			'pageSize'=>$pageSize,
		);
		
		$booklist = $dataProvider->getData();
		$booyTypeArray = $this->getRsBookTypeAsArray();
		
		if(isset($_REQUEST['view']) && $_REQUEST['view'] == "full"){
			$this->render($view,array(
				'ResultBooks'=>$booklist,
				'page'=>$page,
				'BookTypeArray'=>$booyTypeArray,
			));	
		}else{
			$this->renderPartial($view,array(
				'ResultBooks'=>$booklist,
				'page'=>$page,
				'BookTypeArray'=>$booyTypeArray,
			));	
		}		
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
		return date('m-d',strtotime($returndate));
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