<?php 

class EditController extends Controller
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
		$this->render('index');
	}
	
	public function actionTest()
	{
			/*
		include_once "/protected/extensions/phpQuery.php";
		header("Content-type: text/html; charset=gbk");
		phpQuery::$defaultCharset = 'gbk';
		phpQuery::newDocumentFile('http://item.jd.com/10393278.html');  
		$imgurl = pq('#spec-n1')->find('img')->attr('src'); 
		//echo $imgurl;
		$items = pq('#parameter2')->html();  
		//echo $items;
		
		phpQuery::newDocumentFileHTML('http://d.3.cn/desc/10393278?callback=showdesc');  
		$details = pq('');  
		$allstr = explode('"content":"', $details->html())[1];
		$allstr = str_replace('\n', '', $allstr);
		$allstr = str_replace('\'\\"', '"', $allstr);
		$allstr = str_replace('\\"\'', '"', $allstr);
		
		/ *
		file_put_contents('tmp.html', $allstr);
		phpQuery::newDocument('tmp.html');
		$details = pq('detail-tag-id-3');  
		echo $details->html();
		* /
		$allstr = explode('<div class="item-mt">', $allstr);
		$i=0;
		foreach($allstr as $detail)
        {
        	$i++;
        	if($i<3)
        		continue;
        		
        	$detail = str_replace('</div>', '', $detail);
        	echo "\n-------------------".$i."----------------------\n";
        	$strs = explode('<div class="item-mc">', $detail);
        	$j=0;
        	foreach($strs as $str)
        	{
        		$j++;
        		echo "\n========".$i.".".$j."========\n";
            	echo $str;
        	}
        }
        */
		/* 
		//phpQuery::newDocumentFileHTML('http://product.dangdang.com/20723445.html'); 
		phpQuery::newDocumentFileHTML('http://www.amazon.cn/gp/product/B004K6KKUU?ie=UTF8&isInIframe=1&ref_=dp_proddesc_0&s=books&showDetailProductDesc=1#iframe-wrapper');
		$details = pq('#detail_bullets_id')->find('li');  
		echo $details->html();
		
		$details = pq('#product-description-iframe');
		echo $details->html();
		
		$imgurl = pq('#largePicDiv')->find("img")->attr('wsrc'); 
		echo $imgurl;
		
		$details = pq('.book_messbox');  
		echo $details->html();
		
		$details = pq('.key');
		echo $details->html();
		
		$details = pq('#abstract_all')->html();
		echo $details;
		$details = pq('#content_all')->html();
		echo $details;
		*/
		
	}

	public function actionAdd()
	{
			// collect Books input data
		if(isset($_POST['Books']))
		{
			//check if shop_id exist:
			$isexist = Books::model()->exists("book_id=:book_id",array(":book_id"=>$_POST['Books']['book_id']));
			if($isexist)
			{
				$this->render('addbook');
			}
			else 
			{
				$curtime=getCurTime();
				$clientip=getClientIP();
				
				$model = new Books();
				$model->attributes=$_POST['Books'];
				$model->return_time=$curtime;
				
				$model->book_logo="bklogo.jpg";
				$model->add_time=$curtime;
				$model->adder_nsn_id=RoleUtil::getUser()->nsn_id;
				$model->remove_time=$curtime;
				$model->borrowed_time = $curtime;						   				
				$model->due_date = $curtime;
				
				
				$file = CUploadedFile::getInstanceByName('book_logo_new');  
				// 判断是否选择了新文件，选择了则上传并更新链接，否则logo地址不变
	            if(is_object($file)&&get_class($file) === 'CUploadedFile')
				{   
					$filename =  'bk_'.$model->book_id.'.'.$file->extensionName;
					// 上传图片
		            if($file->saveAs("./".getBookLogoPath()."/".$filename))
		            {
						$model->book_logo = $filename;
		            }
				}
				
				if ($model->save()) 
				{			
					$this->render("addok");
				}
				else 
				{
					$this->render('addbook', array("ResultBooksType"=>$this->getBookTypeList()));
				}				
			}
		}
		else 
		{
			$this->render('addbook', array("ResultBooksType"=>$this->getBookTypeList()));
		}
	}
	
	public function actionLoadfromcsv()
	{
		$filename =  './upload/tmp/csv_bk_'.getCurImgMicroTime().'.csv';
		$file = CUploadedFile::getInstanceByName('csv_file_books');
		if(is_object($file)&&get_class($file) === 'CUploadedFile')
		{
			if($file->saveAs($filename))
			{
				$msg_ok = "";
				$msg_failed = "";
				$clientip=getClientIP();
				
				$file_handle = fopen($filename, "r");
				$linenum = 0;
				while (!feof($file_handle)) 
				{
					$linenum = $linenum+1;
				   	$line = fgets($file_handle);
				   	// convert ansi(gbk, big5) format to utf-8
				   	$line = iconv("GBK","UTF-8",$line); 
				   	
				   	// split with ',':
				   	$bookes = explode(",", $line);
				   	
				   	if(strstr($bookes[0],"Book_id")) // if header continue;
				   		continue;
				   		
				   	if(count($bookes) == 15)
				   	{
				   		try 
				   		{
					   		$book = new Books();
							$curtime=getCurTime();
						
					   		$book->book_logo="bklogo.jpg";
							$book->add_time=$curtime;
							$book->adder_nsn_id=RoleUtil::getUser()->nsn_id;
						
					   		// format: Book_id,book_name,Category,Category2,Group,link,publisher,publish time,ISBN,author,Language,TotalPage,Summary,Comments
							$book->book_id = $bookes[0];
					   		$book->book_name = $bookes[1];
					   		$book->book_type = $bookes[2]; //1:books;2:magazine;					   		
					   		$book->category_1 = $bookes[3];
					   		$book->category_2 = $bookes[4];
					   		$book->owner_team = $bookes[5];
					   		$book->more_url = $bookes[6];
					   		$book->publisher = $bookes[7];
					   		$book->publish_time = $bookes[8];
					   		$book->isbn = $bookes[9];
					   		$book->author = $bookes[10];
							$book->language = $bookes[11];
							$book->total_pages = $bookes[12];
							$book->book_summary = $bookes[13];
							$book->comments = $bookes[14];
					   		
					   		$book->book_admin = RoleUtil::getUser()->nsn_id;
					   		$book->status = 0; 
					   		$book->suggest_reason = "";
					   		$book->location_building = 0; // 0: chengdu A4; 1: E1 chengdu
					   		
					   		if($book->save())
					   		{
					   			$msg_ok = $msg_ok.$linenum." load successful: ".$line."<br>";
					   		}
					   		else 
					   		{
					   			$msg_failed = $msg_failed.$linenum." load failed: ".$line."<br>";
					   		}
				   		}
				   		catch(Exception $ex)
				   		{	
				   			//print_r($ex);
				   			$msg_failed = $msg_failed.$linenum." load failed: ".$line."Exception:".$ex->getMessage()."<br>";
				   			//return;
				   		}
				   }
				}
				fclose($file_handle);
				
				// finished:
				$message = "<b>Follow lines load successfully:</b><br>".$msg_ok
						."<br><b>Follow lines load failed:</b><br>".$msg_failed."<br>";
				$this->render("addok", array("message"=>$message));
			}
		}
		else 
		{
			$this->render('addbook', array("ResultBooksType"=>$this->getBookTypeList()));
		}
		
	}
	
	public function actionLoadbook()
	{
		$this->render('loadbook');
	}
	
	public function actionLoadmagazine()
	{
		$this->render('loadmagazine');
	}
	
	function findLibrarianUserIdByName($librationName)
	{
		$librations = array(
			"Xiong Wei"=>"61442185",
			"Rachel Gong"=>"61441157",
			"Juanjuan Lin"=>"61414518",
			"Fan Suo"=>"61377616",
			"Lisa Zeng"=>"61333069",
			"Frank Luo"=>"61307947",
			"Jane Liu"=>"61306114",
			"Cheng Matthew"=>"61415888",
			"Zhang Gary"=>"10001",
			"Xiaotong Yang"=>"10002",
			"Songyun Li"=>"10003",
		);
		
		$value = $librations[$librationName];
		return isset($value)?$value:RoleUtil::getUser()->nsn_id;
	}

	public function actionLoadbookfromcsv()
	{
		$filename =  './upload/tmp/csv_old_bk_'.getCurImgMicroTime().'.csv';
		$file = CUploadedFile::getInstanceByName('csv_file_old_records');
		if(is_object($file)&&get_class($file) === 'CUploadedFile')
		{
			if($file->saveAs($filename))
			{		
				$msg_ok = "";
				$msg_failed = "";
				$msg_failed_nouser = "";
				$msg_failed_nobook = "";
				$msg_add_new_book = "";
				$clientip=getClientIP();
				
				$file_handle = fopen($filename, "r");
				$linenum = 0;
				while (!feof($file_handle)) 
				{
					try 
					{
					$linenum = $linenum+1;
				   	$line = fgets($file_handle);
				   	// convert ansi(gbk, big5) format to utf-8
				   	$line = iconv("GBK","UTF-8",$line); 
				   	// split with ',':
				   	$bookes = explode(",", $line);
				   	
				   	if(strstr($bookes[0],"No.")) // if header continue;
				   		continue;
				   		
				   	if(count($bookes) == 10)
				   	{
				   		try 
				   		{
					   		$bookHistory = new BooksHistory();
							$curtime=getCurTime();
						
					   		// format: No.,Book Name,Book ID,Employee,E-mail,Borrowing Date,Return Date,Librarian,Return Status,Annotation
							$bookHistory->book_name = trim($bookes[1]);
							$trimbookid = strtoupper(str_replace(' ', '', trim($bookes[2])));
							
					   		$bookHistory->user_name = trim($bookes[3]);
					   		
					   		$nokiaemail = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($bookes[4])));	
					   		$nsnemail = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($bookes[4])));	
					   		$bookHistory->user_email = $nokiaemail;		
					   							
					   		$bookHistory->borrow_time = date('Y-m-d H:i:s',strtotime($bookes[5]));
					   		$bookHistory->return_time = date('Y-m-d H:i:s',strtotime($bookes[6]));
					   		$bookHistory->actual_return_time = $bookHistory->return_time;
					   		$bookHistory->is_return = (strtolower(trim($bookes[8]))=="yes"?1:0);
					   		$bookHistory->comments = trim($bookes[9]);

					   		// find userID by nsn email:
					   		$borrowuser = getUserFromMvnforumAndRegistByEmail($nsnemail);
					   		if(isset($borrowuser))
					   			$bookHistory->user_id = $borrowuser->nsn_id;
					   		else 
					   		{
					   			// find userID by Onelibrary email:
					   			$borrowuser = getUserFromMvnforumAndRegistByEmail($nokiaemail);
					   			if(isset($borrowuser))
					   			$bookHistory->user_id = $borrowuser->nsn_id;
					   			else 
					   			{
					   				$msg_failed_nouser = $msg_failed_nouser.$linenum.": ".$line."<br>";
						   			//continue;
					   				$bookHistory->user_id = "000000";
					   			}
					   		}
					   		
							$model = Books::model()->findByAttributes(array('book_id'=>$trimbookid));
							if(isset($model))
							{
					   			$bookHistory->book_id = $model->id;
							}
					   		else 
					   		{
					   			// find book by book name:
					   			$model = Books::model()->findByAttributes(array('book_name'=>$bookHistory->book_name));
					   			if(isset($model))
								{
						   			$bookHistory->book_id = $model->id;
								}
						   		else 
						   		{
						   			// find book by like book name:
						   			$model = Books::model()->find('book_name like :book_name', array(':book_name'=>'%'.$bookHistory->book_name.'%'));
						   			if(isset($model))
						   			{
						   				$bookHistory->book_id = $model->id;
						   			}
						   			else
						   			{
						   				// create new book:
						   				$model = new Books();
						   				$model->book_id = $trimbookid;
						   				$model->book_name = $bookHistory->book_name;
						   				$model->owner_team = "OSS";
						   				$model->book_admin = RoleUtil::getUser()->nsn_id;;
						   				$model->remove_time = $curtime;
						   				$model->book_summary = "No summary.";
						   				$model->book_type = 1;// 1:book; 2:magazine;
						   				$model->comments = "Added by load librarion record.";
						   				
						   				$model->status = $bookHistory->is_return == 0 ? 1 : 0;
						   				$model->holder_nsn_id = $bookHistory->user_id;
						   				$model->holder_name = $bookHistory->user_name;
						   				$model->holder_email = $bookHistory->user_email;
						   				$model->borrowed_time = $bookHistory->borrow_time;						   				
						   				$model->due_date = $bookHistory->return_time;
						   				$model->return_time = $bookHistory->return_time;
						   				
						   				// location:
						   				$model->location_library = "";
						   				$model->location_building = 0;// 0: chengdu A4; 1: chengdu E1
										
										$model->book_logo="bklogo.jpg";
										$model->add_time=$curtime;
										$model->adder_nsn_id=RoleUtil::getUser()->nsn_id;
										
										if($model->save())
										{
											$bookHistory->book_id = $model->id;
											$msg_add_new_book = $msg_add_new_book.$linenum.": ".$line."  added new book[id=".$bookHistory->book_id."]<br>";
										}
										else
										{
						   					$msg_failed_nobook = $msg_failed_nobook.$linenum.": ".$line."  <br>";
						   					continue;
										}
						   			}
						   		}
					   		}
					   		//print_r($borrowuser);
					   		//return;
					   		
					   		$bookHistory->librarian_borrow_id = $this->findLibrarianUserIdByName(trim($bookes[7]));
					   		$bookHistory->librarian_return_id = $bookHistory->librarian_borrow_id;
					   		
					   		$bookHistory->notify_email_times = 0;
					   		$bookHistory->last_email_time = $curtime;
					   		$bookHistory->overdue_fine = 0;
					   		$bookHistory->fine_overdue_per_day = 0.2;
					   		
					   		if($bookHistory->save())
					   		{
					   			$msg_ok = $msg_ok.$linenum.": ".$line."<br>";
					   			
					   			// if the book not return, update books table:
					   			if($bookHistory->is_return==0 && isset($model))
					   			{
					   				try 
					   				{
						   				//$model = Books::model()->findByAttributes(array('id'=>$bookHistory->book_id));
						   				$model->status = 1;
						   				$model->holder_nsn_id = $bookHistory->user_id;
						   				$model->return_time = $bookHistory->return_time;
						   				$model->holder_name = $bookHistory->user_name;
						   				$model->holder_email = $bookHistory->user_email;
						   				$model->borrowed_time = $bookHistory->borrow_time;
						   				$model->due_date = $bookHistory->return_time;
						   				
						   				$model->save();
					   				}
					   				catch(Exception $exx)
					   				{
					   					//print_r($exx);
					   					$msg_failed = $msg_failed.$linenum.": ".$line." save to Books table failed: Exception:".$exx->getMessage()."<br>";
					   				}
					   			} // end if(!$bookHistory->is_return)
					   		}
					   		else 
					   		{
					   			$msg_failed = $msg_failed.$linenum.": ".$line."   Save failed ..<br>";
					   		}
				   		}
				   		catch(Exception $ex)
				   		{	
				   			//print_r($ex);
				   			$msg_failed = $msg_failed.$linenum.": ".$line."Exception:".$ex->getMessage()."<br>";
				   		}
				   } // end if(count($bookes) == 10)
				   else 
				   {
				   		$msg_failed = $msg_failed.$linenum.": ".$line."  array size is not 10.<br>";
				   }
					}
					catch(Exception $ee)
					{
						$msg_failed = $msg_failed.$linenum.": ".$line."  Failed to read and store datas. Exception:".$ee->getMessage()."<br>";
					}
				} // end while
				fclose($file_handle);
				
				// update sumary in tb_books:
				$sql = "update tb_books set total_borrowed=(select count(*) from tb_books_history where book_id=tb_books.id);";
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
				
				// finished:
				$message = "<b>Follow lines load successfully:</b><br>".$msg_ok
						."<br><b>Following lines user not found, user_id=000000:</b><br>".$msg_failed_nouser
						."<br><b>Following lines load failed due to book not found:</b><br>".$msg_failed_nobook
						."<br><b>Follow lines load failed:</b><br>".$msg_failed."<br>";
				$this->render("addok", array("message"=>$message));				
			}
			else 
			{
				$this->render("addok", array("message"=>"Import failed: failed to upload file!"));	
			}
		}
		else 
		{
			$this->render('importold');
		}
	}

	public function actionLoadmagazinefromcsv()
	{
		$filename =  './upload/tmp/csv_old_bk_'.getCurImgMicroTime().'.csv';
		$file = CUploadedFile::getInstanceByName('csv_file_old_records');
		if(is_object($file)&&get_class($file) === 'CUploadedFile')
		{
			if($file->saveAs($filename))
			{		
				$msg_ok = "";
				$msg_failed = "";
				$msg_failed_nouser = "";
				$msg_failed_nobook = "";
				$msg_add_new_book = "";
				$clientip=getClientIP();
				
				$file_handle = fopen($filename, "r");
				$linenum = 0;
				while (!feof($file_handle)) 
				{
					try 
					{
					$linenum = $linenum+1;
				   	$line = fgets($file_handle);
				   	// convert ansi(gbk, big5) format to utf-8
				   	$line = iconv("GBK","UTF-8",$line); 
				   	// split with ',':
				   	$bookes = explode(",", $line);
				   	
				   	if(strstr($bookes[0],"No.")) // if header continue;
				   		continue;
				   		
				   	if(count($bookes) == 10)
				   	{
				   		try 
				   		{
					   		$bookHistory = new BooksHistory();
							$curtime=getCurTime();
						
					   		// format: No.,Book Name,Book ID,Employee,E-mail,Borrowing Date,Return Date,Librarian,Return Status,Annotation
							$bookHistory->book_name = trim($bookes[1]);
							$trimbookid = strtoupper(str_replace(' ', '', trim($bookes[2])));
							
					   		$bookHistory->user_name = trim($bookes[3]);
					   		
					   		$nokiaemail = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($bookes[4])));	
					   		$nsnemail = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($bookes[4])));	
					   		$bookHistory->user_email = $nokiaemail;		
					   							
					   		$bookHistory->borrow_time = date('Y-m-d H:i:s',strtotime($bookes[5]));
					   		$bookHistory->return_time = date('Y-m-d H:i:s',strtotime($bookes[6]));
					   		$bookHistory->actual_return_time = $bookHistory->return_time;
					   		$bookHistory->is_return = (strtolower(trim($bookes[8]))=="yes"?1:0);
					   		$bookHistory->comments = trim($bookes[9]);

					   		// find userID by nsn email:
					   		$borrowuser = getUserFromMvnforumAndRegistByEmail($nsnemail);
					   		if(isset($borrowuser))
					   			$bookHistory->user_id = $borrowuser->nsn_id;
					   		else 
					   		{
					   			// find userID by Onelibrary email:
					   			$borrowuser = getUserFromMvnforumAndRegistByEmail($nokiaemail);
					   			if(isset($borrowuser))
					   			$bookHistory->user_id = $borrowuser->nsn_id;
					   			else 
					   			{
					   				$msg_failed_nouser = $msg_failed_nouser.$linenum.": ".$line."<br>";
						   			//continue;
					   				$bookHistory->user_id = "000000";
					   			}
					   		}
					   		
							$model = Books::model()->findByAttributes(array('book_id'=>$trimbookid, 'book_name'=>$bookHistory->book_name));
							if(isset($model))
							{
					   			$bookHistory->book_id = $model->id;
							}
					   		else 
					   		{
					   			// find book by book name:
					   			//$model = Books::model()->findByAttributes(array('book_name'=>$bookHistory->book_name));
					   			//if(isset($model))
								//{
						   		//	$bookHistory->book_id = $model->id;
								//}
						   		//else 
						   		//{
						   			// find book by like book name:
						   			//$model = Books::model()->find('book_name like :book_name', array(':book_name'=>'%'.$bookHistory->book_name.'%'));
						   			//if(isset($model))
						   			//{
						   			//	$bookHistory->book_id = $model->id;
						   			//}
						   			//else
						   			//{
						   				// create new book:
						   				$model = new Books();
						   				$model->book_id = $trimbookid;
						   				$model->book_name = $bookHistory->book_name;
						   				$model->owner_team = "OSS";
						   				$model->book_admin = RoleUtil::getUser()->nsn_id;;
						   				$model->remove_time = $curtime;
						   				$model->book_summary = "No summary.";
						   				$model->book_type = 2; // 1:book; 2:magazine;
						   				$model->comments = "Added by load librarion record.";
						   				
						   				$model->status = $bookHistory->is_return == 0 ? 1 : 0;
						   				$model->holder_nsn_id = $bookHistory->user_id;
						   				$model->holder_name = $bookHistory->user_name;
						   				$model->holder_email = $bookHistory->user_email;
						   				$model->borrowed_time = $bookHistory->borrow_time;						   				
						   				$model->due_date = $bookHistory->return_time;
						   				$model->return_time = $bookHistory->return_time;
						   				
						   				// location:
						   				$model->location_library = "";
						   				$model->location_building = 0; // 0: chengdu A4; 1: chengdu E1
						   				
										$model->book_logo="bklogo.jpg";
										$model->add_time=$curtime;
										$model->adder_nsn_id=RoleUtil::getUser()->nsn_id;
										
										if($model->save())
										{
											$bookHistory->book_id = $model->id;
											$msg_add_new_book = $msg_add_new_book.$linenum.": ".$line."  added new book[id=".$bookHistory->book_id."]<br>";
										}
										else
										{
						   					$msg_failed_nobook = $msg_failed_nobook.$linenum.": ".$line."  <br>";
						   					continue;
										}
						   			//}
						   		//}
					   		}
					   		//print_r($borrowuser);
					   		//return;
					   		
					   		$bookHistory->librarian_borrow_id = $this->findLibrarianUserIdByName(trim($bookes[7]));
					   		$bookHistory->librarian_return_id = $bookHistory->librarian_borrow_id;
					   		
					   		$bookHistory->notify_email_times = 0;
					   		$bookHistory->last_email_time = $curtime;
					   		$bookHistory->overdue_fine = 0;
					   		$bookHistory->fine_overdue_per_day = 0.2;
					   		
					   		if($bookHistory->save())
					   		{
					   			$msg_ok = $msg_ok.$linenum.": ".$line."<br>";
					   			
					   			// if the book not return, update books table:
					   			if($bookHistory->is_return==0 && isset($model))
					   			{
					   				try 
					   				{
						   				//$model = Books::model()->findByAttributes(array('id'=>$bookHistory->book_id));
						   				$model->status = 1;
						   				$model->holder_nsn_id = $bookHistory->user_id;
						   				$model->return_time = $bookHistory->return_time;
						   				$model->holder_name = $bookHistory->user_name;
						   				$model->holder_email = $bookHistory->user_email;
						   				$model->borrowed_time = $bookHistory->borrow_time;
						   				$model->due_date = $bookHistory->return_time;
						   				
						   				$model->save();
					   				}
					   				catch(Exception $exx)
					   				{
					   					//print_r($exx);
					   					$msg_failed = $msg_failed.$linenum.": ".$line." save to Books table failed: Exception:".$exx->getMessage()."<br>";
					   				}
					   			} // end if(!$bookHistory->is_return)
					   		}
					   		else 
					   		{
					   			$msg_failed = $msg_failed.$linenum.": ".$line."   Save failed ..<br>";
					   		}
				   		}
				   		catch(Exception $ex)
				   		{	
				   			//print_r($ex);
				   			$msg_failed = $msg_failed.$linenum.": ".$line."Exception:".$ex->getMessage()."<br>";
				   		}
				   } // end if(count($bookes) == 10)
				   else 
				   {
				   		$msg_failed = $msg_failed.$linenum.": ".$line."  array size is not 10.<br>";
				   }
					}
					catch(Exception $ee)
					{
						$msg_failed = $msg_failed.$linenum.": ".$line."  Failed to read and store datas. Exception:".$ee->getMessage()."<br>";
					}
				} // end while
				fclose($file_handle);
				
				// update sumary in tb_books:
				$sql = "update tb_books set total_borrowed=(select count(*) from tb_books_history where book_id=tb_books.id);";
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
				
				// finished:
				$message = "<b>Follow lines load successfully:</b><br>".$msg_ok
						."<br><b>Following lines user not found, user_id=000000:</b><br>".$msg_failed_nouser
						."<br><b>Following lines load failed due to book not found:</b><br>".$msg_failed_nobook
						."<br><b>Follow lines load failed:</b><br>".$msg_failed."<br>";
				$this->render("addok", array("message"=>$message));				
			}
			else 
			{
				$this->render("addok", array("message"=>"Import failed: failed to upload file!"));	
			}
		}
		else 
		{
			$this->render('importold');
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
	
	public function actionReserve()
	{
		$this->renderPartial('reserve');
	}
	public function actionView()
	{
		if(isset($_REQUEST["bkid"]))
		{
			$model = Books::model()->findByAttributes(array('id'=>$_REQUEST["bkid"]));
			if(isset($model))
				$this->renderPartial('view', array("ResultBooks"=> $model, "ResultBooksType"=>$this->getBookTypeList()));
			else 
				$this->renderPartial('editok', array("message"=> "The book not found, Please try again from webpage!"));
		}
		else 
		{
			$this->renderPartial('editok', array("message"=> "Please try again from webpage!"));
		}
	}
	
	public function actionEdit()
	{
		if(isset($_POST['Books']))
		{
			//check if shop_id exist:
			$model = Books::model()->findByAttributes(array('id'=>$_POST['Books']['id']));
			//$isexist = Books::model()->exists("book_id=:book_id",array(":book_id"=>$_POST['Books']['book_id']));
			if(!isset($model))
			{
				$this->renderPartial('editok', array("message"=> "The book not found, Please try again from webpage!"));
			}
			else 
			{
				//$curtime=getCurTime();
				//$clientip=getClientIP();
				
				$model->attributes=$_POST['Books'];
				//$model->return_time=$curtime;
				
				//$model->book_logo="bklogo.jpg";
				//$model->add_time=$curtime;
				//$model->adder_nsn_id=RoleUtil::getUser()->nsn_id;
				//$model->remove_time=$curtime;
				
				$file = CUploadedFile::getInstanceByName('book_logo_new');  
				// 判断是否选择了新文件，选择了则上传并更新链接，否则logo地址不变
	            if(is_object($file)&&get_class($file) === 'CUploadedFile')
				{   
					echo "Start to upload ...";
					$filename =  'bk_'.$model->id.'.'.$file->extensionName;
					// 上传图片
		            if($file->saveAs("./".getBookLogoPath()."/".$filename))
		            {
		            	echo "uploaded ...";
						$model->book_logo = $filename;
		            }
				}
				
				if ($model->save()) 
				{			
					$this->renderPartial("editok", array("message"=> "Update successfully!"));
				}
				else 
				{
					$this->renderPartial("editok", array("message"=> "Update failed, please try again!"));
				}				
			}
		}
		else if(isset($_REQUEST["bkid"]))
		{
			$model = Books::model()->findByAttributes(array('id'=>$_REQUEST["bkid"]));
			if(isset($model))
				$this->renderPartial('editbook', array("ResultBooks"=> $model, "ResultBooksType"=>$this->getBookTypeList()));
			else 
				$this->renderPartial('editok', array("message"=> "The book not found, Please try again from webpage!"));
		}
		else 
		{
			$this->renderPartial('editok', array("message"=> "Please try again from webpage!"));
		}
	}
	public function actionEditfull()
	{
		if(isset($_POST['Books']))
		{
			//check if shop_id exist:
			$model = Books::model()->findByAttributes(array('id'=>$_POST['Books']['id']));
			//$isexist = Books::model()->exists("book_id=:book_id",array(":book_id"=>$_POST['Books']['book_id']));
			if(!isset($model))
			{
				$this->renderPartial('editok', array("message"=> "The book not found, Please try again from webpage!"));
			}
			else 
			{
				//$curtime=getCurTime();
				//$clientip=getClientIP();
				
				$model->attributes=$_POST['Books'];
				//$model->return_time=$curtime;
				
				//$model->book_logo="bklogo.jpg";
				//$model->add_time=$curtime;
				//$model->adder_nsn_id=RoleUtil::getUser()->nsn_id;
				//$model->remove_time=$curtime;
				
				$file = CUploadedFile::getInstanceByName('book_logo_new');  
				// 判断是否选择了新文件，选择了则上传并更新链接，否则logo地址不变
	            if(is_object($file)&&get_class($file) === 'CUploadedFile')
				{   
					//echo "Start to upload ...";
					$filename =  'bk_'.$model->id.'.'.$file->extensionName;
					// 上传图片
		            if($file->saveAs("./".getBookLogoPath()."/".$filename))
		            {
		            	//echo "uploaded ...";
						$model->book_logo = $filename;
		            }
				}
				
				if ($model->save()) 
				{			
					Header("Location:".Yii::app()->createUrl("library/search/viewfull", array("bkid"=> $model->id)));	
				}
				else 
				{
					$this->render("editok", array("message"=> "Update failed, please try again! [<a href='#' onclick='javascript:history.back()'><font color=red>返回修改</font></a>]"));
				}				
			}
		}
		else if(isset($_REQUEST["bkid"]))
		{
			$model = Books::model()->findByAttributes(array('id'=>$_REQUEST["bkid"]));
			if(isset($model))
				$this->render('editbookfull', array("ResultBooks"=> $model, "ResultBooksType"=>$this->getBookTypeList()));
			else 
				$this->render('editok', array("message"=> "The book not found, Please try again from webpage!"));
		}
		else 
		{
			$this->render('editok', array("message"=> "Please try again from webpage!"));
		}
	}	
/*	
	public function actionRemove()
	{
		$this->renderPartial('remove');
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
			  echo "Available for borrow";
			  break;
			case 1:
			  echo "Not Available for borrow";
			  break;
			case 2:
			  echo "Removed";
			  break;
			 default:
			  echo "Available for borrow";
		}
	}
}