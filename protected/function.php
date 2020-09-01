<?php

function getUserLogoPath()
{
	return "imgus";
}
function getBookLogoPath()
{
	return "imgbk";
}
/*
function getImgLogoPath()
{
	return "fdimg/logo";
}
function getImgNormalPath()
{
	return "fdimg/normal";
}
function getImgLargePath()
{
	return "fdimg/large";
}

function getShopImgLogoPath()
{
	return "spimg/logo";
}
function getShopImgNormalPath()
{
	return "spimg/normal";
}
function getShopImgLargePath()
{
	return "spimg/large";
}
*/
function parseSex($value)
{
	if($value==1)
		return "男";
	else if($value==2)
		return "女";
	else 
		return "未知";
}
	
function parseDeleteStatus($value)
{
	if($value==0)
		return "使用中";
	else if($value==1)
		return "已删除";
	else 
		return "未审核";
}

function cutString($value, $split)
{
	$rs = explode($split,$value);
	return $rs[0];
}

function partString($value, $length)
{
	if(!isset($value))
		return "";
	else if(strlen($value)<$length)
		return $value;
	else
		return mb_substr($value,0,$length, "utf-8")."...";
}

function cutDate($value)
{
	return date("m-d H:i",strtotime($value));
	//$rs = explode($split,$value);
	//return $rs[0];
}
function shortDate($value)
{
	return date("m-d",strtotime($value));
}
function longDate($value)
{
	return date("Y-m-d",strtotime($value));
}
function getClientIP()
{
	global $ip;
	
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else $ip = "Unknow";
	
	return $ip;
}

function getCurTime()
{
	return date('Y-m-d H:i:s',time());
}

function getCurImgMicroTime()
{
	return microtime_format('Ymd_His_x',microtime_float());
}

/** 获取当前时间戳，精确到毫秒 */
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

/** 格式化时间戳，精确到毫秒，x代表毫秒 */
function microtime_format($tag, $time)
{
   list($usec, $sec) = explode(".", $time);
   $date = date($tag,$usec);
   return str_replace('x', $sec, $date);
}

function getRandNum($length){
	$tmp=array(); 
	while(count($tmp)<$length){ 
		$tmp[]=mt_rand(0,9); 
		$tmp=array_unique($tmp); 
	} 
	return join($tmp); 
}

function getRandChar($length)
{
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++)
   {
    	$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
}

function is_email($email)
{ 
	$pattern="/^([\w\.-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z\.]+)$/i";//包含字母、数字、下划线_和点.的名字的email 
	if(preg_match($pattern,$email,$matches))
	{ 
		return true; 
	}
	else
	{ 
		return false; 
	} 
} 

/**
 * Login from mvn frorum http interface
 * 
 * @param unknown_type $user_id
 * @param unknown_type $password
 */
function loginFromMvnforumInterface($user_id, $password)
{
	try 
	{
		Yii::import('ehttpclient.*');
		// get my twitter status
		$client = new EHttpClient(Yii::app()->params['MvnForumAuthUrl'], array('maxredirects'=>0, 'timeout'=>30));
		$client->setParameterPost(array('userName'=>$user_id, 'userPassword'=>$password));
		$response = $client->request('POST');
		 
		//print_r($response);exit();
		if($response->isSuccessful())
		{
		    if(trim($response->getBody()) == "1")
		    	return true;
		    else 
		    	return false;
		}
		else
		{
		    return false;
		}
	}
	catch(Exception $ex)
	{
		return false;
	}
}

function getUserFromMvnforum($nsn_id)
{
		try 
		{
			$db = Yii::app()->db_mvnform; 
			//$sql = "select id,title,last_modified,module,out_link from tb_news where module=:module order by last_modified desc limit 0,13;";
			$sql = "SELECT MemberID,MemberName,MemberEmail,MemberLastname,MemberFirstname,MemberCreationDate from mvnforummember where MemberName=:MemberName;";
			$command=$db->createCommand($sql);
	        $command->bindParam(":MemberName",$nsn_id,PDO::PARAM_STR);
	        $row=$command->queryRow();
	        if(!isset($row))
	        	return null;
			else 
			{
				
				$user = new Users();
				$user->user_name = $row["MemberLastname"]." ".$row["MemberFirstname"];
				$user->nsn_id = $row["MemberName"];
				
				$nokia_user_email = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($row["MemberEmail"])));	
				$user->email = $nokia_user_email;
				
				//$user->password = md5($Password);
				$user->create_time = $row["MemberCreationDate"];
				$user->last_time = getCurTime();
				$user->create_ip = getClientIP();
				$user->last_ip = getClientIP();
				$user->logo = "userlogo.jpg";
				//$user->title = $row["MemberName"];
				
				return $user;
			}
		}
		catch (Exception $ex)
		{
			return null;
		}
}

function getUserFromMvnforumAndRegistByEmail($nsn_user_email)
{
		try 
		{	//$nsn_user_email = "YAO.LI@onelibrary.com";
			// if find in cdtu db, then return it:
			$userlocal = Users::model()->findByAttributes(array('email'=>strtolower($nsn_user_email)));
			if(isset($userlocal))
				return $userlocal;
			
			// if not found in cdtu db, then try to find it from mvnforum db and regist it in cdtu:
			$db = Yii::app()->db_mvnform; 
			//$sql = "select id,title,last_modified,module,out_link from tb_news where module=:module order by last_modified desc limit 0,13;";
			$sql = "SELECT MemberID,MemberName,MemberEmail,MemberLastname,MemberFirstname,MemberCreationDate from mvnforummember where lower(MemberEmail) like :MemberEmail;";
			$command=$db->createCommand($sql);
			$useremail = strtolower("%".$nsn_user_email."%");
	        $command->bindParam(":MemberEmail",$useremail,PDO::PARAM_STR);
	        $row=$command->queryRow();
	        if(!isset($row) || !isset($row["MemberName"]))
	        	return null;
			else 
			{
				$user = new Users();
				$user->user_name = $row["MemberLastname"]." ".$row["MemberFirstname"];
				$user->nsn_id = $row["MemberName"];
				
				$nokia_user_email = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($nsn_user_email)));	
				$user->email = $nokia_user_email;
				
				$user->create_time = $row["MemberCreationDate"];
				$user->last_time = getCurTime();
				$user->create_ip = getClientIP();
				$user->last_ip = getClientIP();
				$user->logo = "userlogo.jpg";
				
				$passwd = getRandChar(8);
				$user->password=md5($passwd);
				
				try 
				{
					if (registUser($user))
					{
						// send email:
						//sendRegistEmail($user, "Password is: ".$passwd."<br>");
					}
				}
				catch(Exception $eee)
				{}
		
				return $user;
			}
		}
		catch (Exception $ex)
		{
			return null;
		}
}

function loadUserFromMvnforunByNsnId($nsnId)
{
	try
	{
		if(strlen($nsnId)<2)
			return null;

		// search from mvnforum first:
		$model = getUserFromMvnforum($nsnId);
		
		// if not fount in mvnforum then create new:
		if(!isset($model) || empty($model)) 
		{
			return null;
		}
			
		//$model->email = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($email)));
		$passwd = getRandChar(8);
		$model->password=md5($passwd);
		
		if (registUser($model))
		{
			// send email:
//			sendRegistEmail($model, "Password is: ".$passwd."<br>");
			return $model;
		}
		else
			return null;
	}
	catch(Exception $e)
	{
		return null;
	}
}

function registByNsnIdAndEmail($nsnId, $email)
{
	try
	{
		if(strlen($nsnId)<2)
			return null;
		if(!is_email($email))
			return null; 

		// search from mvnforum first:
		$model = getUserFromMvnforum($nsnId);
		
		// if not fount in mvnforum then create new:
		if(!isset($model) || empty($model)) 
		{
			$curtime=getCurTime();
			$clientip=getClientIP();
	
			$model = new Users();
			$model->nsn_id = $nsnId;
			$model->user_name = cutString($email, '@');//str_replace('@onelibrary.com', '', $email);
	
			$model->logo="userlogo.jpg";
			$model->last_time=$curtime;
			$model->last_ip=$clientip;
			$model->create_time=$curtime;
			$model->create_ip=$clientip;
		}
			
		$model->email = str_replace('onelibrary.com', 'onelibrary.com',strtolower(trim($email)));
		$passwd = getRandChar(8);
		$model->password=md5($passwd);
		
		if (registUser($model))
		{
			// send email:
			sendRegistEmail($model, "Password is: ".$passwd."<br>");
			return $model;
		}
		else
			return null;
	}
	catch(Exception $e)
	{
		return false;
	}
}

function registUser($user)
{
	if ($user->save())
	{
		try 
		{
			// create user role:
			$userRole = new UsersRole();
			$userRole->user_id = $user->nsn_id;
			$userRole->is_tu = 1;
			$userRole->role_system = 0;
			$userRole->role_library = 0;
			$userRole->save();
		}
		catch(Exception $ex)
		{
			//$user->delete();
			//return null;
		}
		return true;
	}
	else
	{
		return false;
	}
}

function getRequestRootUrl()
{
	$url = 'http://'.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'];
	return $url;
}

function sendRegistEmail($user, $pwdmsg)
{
	$subject="Regist successfully!"; 
	$content='<font color="#0066ff">'.
			'Hi '.$user->user_name.',<br><br>'.
			'  Regist successfully in Onelibrary  Library website, <br>'.
			'Account: '.$user->nsn_id.'<br>'.
			$pwdmsg.'<br>'.
			'  If forget password, please reset it in here: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/resetpwd", array('nsn_id'=>$user->nsn_id, 'email'=>$user->email)).'">'.
			'Reset Password</a><br><br>'.
			'More information please visit: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/index").'">CDTU Library Home Page</a><br><br>'.
			'Thanks!<br>'.
			'Onelibrary Library<br>'.
			getCurTime().
			'</font>'
			;
	sendEmail($user->email, $subject, $content, "user_regist", true, false);
}

function sendResetPwdEmail($user, $passwd)
{
	$subject="Password reset successfully!";
	$content ='<font color="#0066ff">'.
				'Hi '.$user->user_name.',<br><br>'.
				'Password reset successfully.<br>'.
				'New password is: '.$passwd.'<br><br>'.
				'  If forget password, please reset it in here: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/resetpwd", array('nsn_id'=>$user->nsn_id, 'email'=>$user->email)).'">'.
				'Reset Password</a><br>'.
				'More information please visit: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/index").'">CDTU Library Home Page</a><br><br>'.
				'Thanks!<br>'.
				'Onelibrary Library<br>'.
				getCurTime().
				'</font>';
	sendEmail($user->email, $subject, $content, "user_resetpwd", true, false);
	
}

function sendBookNotifyEmail($user, $msg)
{
	$subject="Return your borrowed book now!";
	$content='<font color="#0066ff">'.
			//'Hi <a href="https://intranet.onelibrary.com/sites/Search/searchall.aspx?k='.$user->nsn_id.'" target="_blank">'.$user->user_name.'</a>,<br><br>'.
			'Hi '.$user->user_name.'(ID:'.$user->nsn_id.'),<br><br>'.
			'  '.
			$msg.'<br>'.
			'More information please visit: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/index").'">CDTU Library Home Page</a><br><br>'.
			'Thanks!<br>'.
			'Onelibrary Library<br>'.
			getCurTime().
			'</font>'
			;
	sendEmail($user->email, $subject, $content, "book_expire", false, false);
}

function sendWaitingNotify($waiting, $user)
{
	$subject="Waiting book returned, please come to borrow it immediately!";
	$content='<font color="#0066ff">'.
			'Hi '.$user->user_name.'(ID:'.$user->nsn_id.'),<br><br>'.
			'  '.
			'Your waiting book: <a href="'.getRequestRootUrl().Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$waiting->book_id)).'">'.$waiting->book_name.'</a> had been returned by the holder, please come to library to borrow it immediately!<br>'.
			'  If no need it, please go to the CDTU library website to cancel it!<br><br>'.
			'More information please visit: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/index").'">Home Page</a><br><br>'.
			'Thanks!<br>'.
			'Onelibrary Library<br>'.
			getCurTime().
			'</font>'
			;
	sendEmail($user->email, $subject, $content, "book_waiting", false, false);
}

function sendFineNotify($bookHistory, $user)
{
	$subject="Book was returned overduce, please pay for the overduce fine!";
	
	$totaldays = floor((strtotime($bookHistory->actual_return_time)-strtotime($bookHistory->return_time))/86400);
	if($totaldays<1){
		$totaldays=0;
	}
	$msg = "Your book was returned overdue, please pay for the overduce fine!<br><br>".
						"Book Name: ".$bookHistory->book_name."<br>".
						"book ID: <a href='".getRequestRootUrl().Yii::app()->createUrl('library/search/viewfull', array('bkid'=>$bookHistory->book_id))."'>".$bookHistory->book_id."</a><br><br>".
						//"Publisher: ".$book->publisher."<br>".
						"Borrowed Time: ".longDate($bookHistory->borrow_time)."<br>".
						"Overdue Time: ".longDate($bookHistory->return_time)."<br>".
						"Actrue return Time: ".longDate($bookHistory->actual_return_time)."<br>".
						"已超期: <font color=red><b> ".$totaldays." </b></font>天<br><br>".
						"超期罚款金额: <font color=red><b> ".$bookHistory->overdue_fine."  </b></font>元<br><br>".
						"图书借阅期： 1 个月，杂志借阅期： 2 周<br>".
						"如超期归还，将每天征收罚金: <font color=red><b> ".$bookHistory->fine_overdue_per_day."   </b></font>元<br><br>".
						"<font color=red>罚款缴纳方式请登录图书馆网站，在  \"My Library\" 页面中查询。</font>"
						;
	
	$content='<font color="#0066ff">'.
			//'Hi <a href="https://intranet.onelibrary.com/sites/Search/searchall.aspx?k='.$user->nsn_id.'" target="_blank">'.$user->user_name.'</a>,<br><br>'.
			'Hi '.$user->user_name.'(ID:'.$user->nsn_id.'),<br><br>'.
			'  '.
			$msg.'<br>'.
	
			'More information please visit: <a href="'.getRequestRootUrl().Yii::app()->createUrl("default/index").'">CDTU Library Home Page</a><br><br>'.
			'Thanks!<br>'.
			'Onelibrary Library<br>'.
			getCurTime().
			'</font>'
			;
			
	sendEmail($user->email, $subject, $content, "book_fine", false, false);
}

/**
 * @param  收件人 array $toEmailArr
 * @param 会议开始时间 string $startTime
 * @param 会议结束时间 string $endTime
 * @param 会议邀请人 string $inviteName
 * @param 会议地点 string $address
 * @param 会议标题 string $title
 * @param 会议内容 string $content
 * @throws \phpmailerException
*/
function sendMeetingMail($toEmailArr, $startTime, $endTime, $inviteName, $address ,$title, $content)
{
    date_default_timezone_set('Asia/Shanghai');

    $title="图书馆值班";
    
	$ical = "BEGIN:VCALENDAR\r\n";
	$ical .= "VERSION:2.0\r\n";
	$ical .= "PRODID:-//Microsoft Corporation//Outlook 11.0 MIMEDIR//EN\r\n";
	$ical .= "METHOD:REQUEST\r\n";
	$ical .= "BEGIN:VEVENT\r\n";
	$ical .= "UID:UID:".date("Ymd\TGis", strtotime($startTime)).rand()."@onelibrary.com\r\n";
	$ical .= "DTSTAMP:" .date('Ymd', time()) ."T". date('His', time()). "Z\r\n";
	$ical .= "DTSTART:".date('Ymd', strtotime($startTime)-date("Z")) ."T". date('His', strtotime($startTime)-date("Z"))."\r\n";
	$ical .= "DTEND:".date('Ymd', strtotime($endTime)-date("Z")) ."T". date('His', strtotime($endTime)-date("Z"))."\r\n";
	$ical .= "TRANSP:OPAQUE\r\n";
	$ical .= "SEQUENCE:1\r\n";
	$ical .= "SUMMARY:".$title."\r\n";
	$ical .= "ORGANIZER;CN=Onelibrary library:mailto:hebihong@163.com\r\n";
	$ical .= "LOCATION:".$address."\r\n";
	$ical .= "DESCRIPTION:".$content."\r\n";
	$ical .= "PRIORITY:5\r\n";
	$ical .= "X-MICROSOFT-CDO-IMPORTANCE:1\r\n";
	$ical .= "CLASS:PUBLIC\r\n";
	$ical .= "ATTENDEE;ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:".$toEmailArr."\r\n";
	$ical .= "END:VEVENT\r\n";
	$ical .= "END:VCALENDAR\r\n";
    
    sendEmail($toEmailArr, $title, $ical, "duty_notify", true, true);
    //echo "Time:".date('Ymd', strtotime($startTime)) ."T". date('His', strtotime($startTime)-date("Z"))." , ";
}

/**
 * @param  收件人 array $toEmailArr
 * @param 会议开始时间 string $startTime
 * @param 会议结束时间 string $endTime
 * @param 会议邀请人 string $inviteName
 * @param 会议地点 string $address
 * @param 会议标题 string $title
 * @param 会议内容 string $content
 * @throws \phpmailerException
*/
function sendCencelMeetingMail($UID, $toEmailArr, $address ,$title)
{
    date_default_timezone_set('Asia/Shanghai');

    $title="图书馆值班";
    
	$ical = "BEGIN:VCALENDAR\r\n";
	$ical .= "VERSION:2.0\r\n";
	$ical .= "PRODID:-//Microsoft Corporation//Outlook 11.0 MIMEDIR//EN\r\n";
	$ical .= "METHOD:CANCEL\r\n";
	$ical .= "BEGIN:VEVENT\r\n";
	$ical .= "UID:UID:".$UID."\r\n";
	$ical .= "DTSTAMP:" .date('Ymd', time()) ."T". date('His', time()). "Z\r\n";
	$ical .= "TRANSP:OPAQUE\r\n";
	$ical .= "SEQUENCE:0\r\n";
	$ical .= "STATUS:CANCELLED\r\n";
	$ical .= "SUMMARY:".$title."\r\n";
	$ical .= "ORGANIZER;CN=Onelibrary library:mailto:hebihong@163.com\r\n";
	$ical .= "LOCATION:".$address."\r\n";
	$ical .= "PRIORITY:5\r\n";
	$ical .= "X-MICROSOFT-CDO-IMPORTANCE:1\r\n";
	$ical .= "CLASS:PUBLIC\r\n";
	$ical .= "ATTENDEE;ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:".$toEmailArr."\r\n";
	$ical .= "END:VEVENT\r\n";
	$ical .= "END:VCALENDAR\r\n";
    
    sendEmail($toEmailArr, $title, $ical, "duty_notify", true, true);
    //echo "Time:".date('Ymd', strtotime($startTime)) ."T". date('His', strtotime($startTime)-date("Z"))." , ";
}

/**
 * Send email function
 * Enter description here ...
 * @param unknown_type $receiver
 * @param unknown_type $subject
 * @param unknown_type $message
 */
function sendEmail($receiver, $subject, $message, $module, $isSecurity, $isCalendar)
{
	$parms = SiteSystemParameters::getAllParms();
	
	// if email disabled then cancel to send email:
	if(strcasecmp("no",$parms['EmailEnable'])==0)
		return;
	
	//$receiver = "178406301@qq.com";
	$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
	$mailer->Host = $parms['EmailServer'];
	$mailer->Port = $parms['EmailServerPort'];
	$mailer->IsSMTP();
	$mailer->SMTPSecure = 'tls';
	$mailer->IsHTML(true);
	$mailer->CharSet = 'UTF-8';

	$mailer->SMTPAuth = false;
	$mailer->Username = $parms['NotifyEmailAccount'];    //这里输入发件地址的用户名
	//$mailer->Password = $parms['NotifyEmailPwd'];    //这里输入发件地址的密码

	$mailer->From = $parms['NotifyEmail'];
	$mailer->FromName = $parms['EmailSendName'];
	$mailer->AddAddress($receiver);
	if(!$isSecurity && !$isCalendar){
		$mailer->AddAddress('hebihong@163.com');
		$sender="";
		if(isset(Yii::app()->session['user']) && !empty(Yii::app()->session['user'])){
			$mailer->AddAddress(Yii::app()->session['user']->email);
			$sender=Yii::app()->session['user']->email;
		}
		if(isset($parms['NotifyBCC'])){
			$mailer->AddBCC($parms['NotifyBCC']);
		}
	}
	
	$mailer->Subject = $subject;
	$mailer->Body = $message;
	
	if($isCalendar){
		$mailer->ContentType = 'text/calendar; charset="utf-8"; method=REQUEST';
		
		$mailer->addCustomHeader('MIME-version',"1.0");
		$mailer->addCustomHeader('Content-type',"text/calendar; method=REQUEST; charset=UTF-8");
		$mailer->addCustomHeader('Content-Transfer-Encoding',"7bit");
		//$mailer->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
		$mailer->addCustomHeader("Content-class: urn:content-classes:calendarmessage");
	}
        
	$mailer->Send();
	
	
	// save it to db:
	$model = new EmailLog();
	$model->module = $module;
	$model->operator_id = RoleUtil::getUser()->nsn_id;
	$model->email_subject = $mailer->Subject;
	$model->email_from = $mailer->From;
	$model->email_from_name = $mailer->FromName;
	$model->email_receiver = $receiver.";".$sender;
	$model->email_bcc = isset($parms['NotifyBCC'])? isset($parms['NotifyBCC']) : "";
	if($isSecurity){
		$model->email_body = "Security email, email body will not stored.";
	}else{
		$model->email_body = $mailer->Body;
	}
	$model->send_time = getCurTime();
	$model->send_ip = getClientIP();

	// save UID
	
	$model->save();
}

function sendEmail222($receiver, $subject, $message)
{
	
	//$receiver = "178406301@qq.com";
	Yii::app()->mailer->Host = "onelibrary_mail.onelibrary.com";//$parms['EmailServer'];
	Yii::app()->mailer->IsSMTP();
	Yii::app()->mailer->IsHTML(true);
	Yii::app()->mailer->CharSet = 'UTF-8';

	Yii::app()->mailer->SMTPAuth = false;
	Yii::app()->mailer->Username = "onelibrary_user@onelibrary.com";    //这里输入发件地址的用户名
	//Yii::app()->mailer->Password = $parms['NotifyEmailPwd'];    //这里输入发件地址的密码

	Yii::app()->mailer->From = "onelibrary_user@onelibrary.com";
	Yii::app()->mailer->FromName = "cdtulib";//$parms['EmailSendName'];
	Yii::app()->mailer->AddAddress("hebihong@163.com");
	
	Yii::app()->mailer->Subject = $subject;
	Yii::app()->mailer->Body = $message;

	Yii::app()->mailer->Send();
}

/**
 * Send SMS function
 * Enter description here ...
 * @param unknown_type $telphone
 * @param unknown_type $message
 */
function sendSmsMb345($telphone, $message)
{
	return false;
	//header("Content-Type: text/html; charset=gb2312");
	$gateway = "http://mb345.com:999/ws/batchSend.aspx?Mobile=".urlencode($telphone)."&Content=".urlencode(mb_convert_encoding($message,'gb2312', 'utf-8'))."&Cell=&SendTime=";
	$result = file_get_contents($gateway);

	if($result ==0 || $result == 1)
	{
		//echo '短信发送成功,等待审核!<br/>';
		return true;
	//}else if($result == 1)
	//{
	//	//echo '短信发送成功<br/>';
	//	return 1;
	}
	else{
		//echo '短信发送失败'. $result.'<br/>';
		return false;
	}	
}

function compreseImage($fileName, $newwidth, $newheight)
{
	//$percent = 1.5;  //图片压缩比
	//$width = 80;
	//$height = 60;
	
	header("Content-type: image/jpeg");
	//获取原图尺寸
	list($width, $height) = getimagesize($fileName); 
	//缩放尺寸
	//$newwidth = $width * $percent;
	//$newheight = $height * $percent;
	$src_im = imagecreatefromjpeg($fileName);
	$dst_im = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	//输出压缩后的图片
	imagejpeg($dst_im); 
	imagedestroy($dst_im);
	imagedestroy($src_im);
}

function resizeImage($srcname,$maxwidth,$maxheight,$dstname,$filetype)
{
	if(function_exists("ImageCreateFromGIF") && stripos($filetype, "gif"))
	{
		$file = ImageCreateFromGIF($srcname);
	}
	else if(function_exists("ImageCreateFromPNG") && stripos($filetype, "png"))
	{
		$file = ImageCreateFromPNG($srcname);
	}
	else //if (stripos($filetype, "jpg") || stripos($filetype, "jpeg"))
	{
		$file = ImageCreateFromJPEG($srcname);
	}
	
    $pic_width = imagesx($file);
    $pic_height = imagesy($file);
	$resizewidth_tag = false;
	$resizeheight_tag = false;

    if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
    {
        if($maxwidth && $pic_width>$maxwidth)
        {
            $widthratio = $maxwidth/$pic_width;
            $resizewidth_tag = true;
        }

        if($maxheight && $pic_height>$maxheight)
        {
            $heightratio = $maxheight/$pic_height;
            $resizeheight_tag = true;
        }

        if($resizewidth_tag && $resizeheight_tag)
        {
            if($widthratio<$heightratio)
                $ratio = $widthratio;
            else
                $ratio = $heightratio;
        }

        if($resizewidth_tag && !$resizeheight_tag)
            $ratio = $widthratio;
        if($resizeheight_tag && !$resizewidth_tag)
            $ratio = $heightratio;

        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;

        if(function_exists("imagecopyresampled"))
        {
            $newim = imagecreatetruecolor($newwidth,$newheight);
           imagecopyresampled($newim,$file,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
        }
        else
        {
            $newim = imagecreate($newwidth,$newheight);
           	imagecopyresized($newim,$file,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
        }

        $dstname = $dstname.".".$filetype;
        imagejpeg($newim,$dstname);
        imagedestroy($newim);
    }
    else
    {
        $dstname = $dstname.".".$filetype;
        imagejpeg($file,$dstname);
    }           
}

function maskString($mystr)
{
	if(isset($mystr))
	{
		if(strlen($mystr)<5)
			return "*".substr($mystr,1);
		else 
			return substr($mystr,0,strlen($mystr)-4)."**".substr($mystr,strlen($mystr)-2);
	}
	return $mystr;
}

function redirect($url)
{
	header("location:".$url);
}

/**
 * add visitor clicks:
 * Enter description here ...
 * @param unknown_type $page
 * @param unknown_type $clicks
 * @param unknown_type $users
 */
function addVisitorStatistics($page, $clicks, $users)
{
		// add visitor clicks:
		try 
		{
			$model = VisitorStatistics::model()->findByAttributes(array('page'=>$page, 'year'=>date('Y'), 'month'=>date('m'), 'day'=>date('d')));
			if(isset($model))
			{
				$model->clicks = $model->clicks+$clicks;
				$model->users = $model->users+$users;
				$model->save();
			}
			else 
			{
				$model = new VisitorStatistics();
				$model->page=$page;
				$model->year = date('Y');
				$model->month = date('m');
				$model->day = date('d');
				$model->clicks = $clicks;
				$model->users = $users;
				$model->create_time = getCurTime();
				$model->save();
			}
		}
		catch(Exception $e)
		{
		}		
	
}

function addUserScore($userId, $action, $scores, $supplier){
	
	$modelUsersScore = new UsersScoreHistory();
	$modelUsersScore->user_id = $userId;
	$modelUsersScore->action = $action;
	$modelUsersScore->scores = intval($scores);
	$modelUsersScore->supplier = $supplier;
	$modelUsersScore->is_deleted=0;
	$modelUsersScore->add_time = getCurTime();
	
	if(!isset($modelUsersScore->user_id)
		|| empty($modelUsersScore->user_id)
		|| !isset($modelUsersScore->action)
		|| empty($modelUsersScore->action)
		|| !isset($modelUsersScore->scores)
		|| empty($modelUsersScore->scores)
		|| $modelUsersScore->scores == 0
		){
		throw new Exception("Attributes user_id,action,scores not set.");
	}
	
	$user = Users::model()->findByAttributes(array("nsn_id"=>$modelUsersScore->user_id));
	if(!isset($user)){
		throw new Exception("User not found.");
	}else{
		$modelUsersScore->user_name = $user->user_name;
		$modelUsersScore->user_email = $user->email;		

		if ($modelUsersScore->save()){
			return 0;
		}
		else {
			throw new Exception("Save failed, please retry.");
		}
	}
}

?>