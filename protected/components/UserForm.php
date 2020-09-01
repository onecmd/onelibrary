<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember Me',
		);
	}
	
	/**
	 * Login from mvnforum
	 * 
	 * if failed return null, else create new user in this website and login.
	 * 
	 * @param unknown_type $MemberName
	 * @param unknown_type $Password
	 */
	public function loginFromMvnForm($MemberName, $Password)
	{
		try 
		{
			$user = getUserFromMvnforum($MemberName);
			if(!isset($user) || empty($user))
			{
				return null;
			}
			else 
			{
				$user->password = md5($Password);
				if(registUser($user))
				{
					return $user;
				}
				else 
				{
					return null;
				}
			}
		}
		catch (Exception $ex)
		{
			$this->addError('login','Login from mvnforum:'.$ex);
			return null;
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		$user = Users::model()->findByAttributes(array('nsn_id'=>$this->username));
		// user not found:
		if(!isset($user))
		{
			// try to login from mvnforum:
			if(!loginFromMvnforumInterface($this->username, $this->password))
			{
				$this->addError('login','NSN ID:'.$this->username.'Password not right!');
				return false;
			}
			else // login ok,
			{
				// then copy user info from  mvnforum to this db:
				$user = $this->loginFromMvnForm($this->username, $this->password);
				// user still not found
				if(!isset($user) || empty($user)) 
				{
					$this->addError('login','NSN ID:'.$this->username.' not found.');
					return false;
				}
			}
		}
		
		/////////////////////////////////////
		// if user find: password either is equals with this db or mvnforum db is ok
		//    if password not right:
		if($user->password!==md5($this->password))
		{
			// try from mvnforum:
			if(!loginFromMvnforumInterface($this->username, $this->password))
			{
				$this->addError('login','Password not right!');
				return false;
			}
			else 
			{
				// if password is stored in mvnforum, then change it in this db
				$user->password = md5($this->password);
			}
		}
			
		//////////////////////////////////////
		// login successful:
		$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
		// update last login:
		$user->last_time = getCurTime();
		$user->last_ip = getClientIP();
		if(!isset($user->create_time))
		$user->create_time = getCurTime();
		
		$user->save();
			
		Yii::app()->session['user'] = $user;
			
		// find role:
		$userrole = UsersRole::model()->findByAttributes(array('user_id'=>$user->nsn_id));
		if(isset($userrole))
		{
			Yii::app()->session['userrole'] = $userrole;
		}
		else
		{
			Yii::app()->session['userrole'] = null;
		}
			
		// find clubs:
		$userclub = ClubsUser::model()->findAllByAttributes(array('user_id'=>$user->nsn_id));
		if(isset($userrole))
		{
			Yii::app()->session['userclub'] = $userclub;
			}
			else 
			{
				Yii::app()->session['userclub'] = null;
			}
			return true;
		}
}
