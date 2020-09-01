<?php
class RoleUtil
{	
	public static $SYSTEM_ROLE = array(
		"User"=>0,
		"Operator"=>2,
		"Admin"=>5,
		"SuperAdmin"=>10,
	);
	public static $LIBRARY_ROLE = array(
		"User"=>0,
		"Finance"=>2,
		"Libration"=>5,
		"SuperAdmin"=>10,
	);
	public static $CLUB_ROLE = array(
		"Member"=>0,
		"Admin"=>5,
		"Creater"=>9,
		"SuperAdmin"=>10,
	);
	
	public static function getRoleKeyByValue($curvalue, $darray)
	{
		while(list($key, $value) = each($darray))
		{
			if($value==$curvalue)
			{
				//echo $curvalue.$key;
				return $key;
			}
		}
	}
	
	public static function getSystemRoleStr($value)
	{
		return RoleUtil::getRoleKeyByValue($value, self::$SYSTEM_ROLE );
	}
	
	public static function getLibraryRoleStr($value)
	{
		return RoleUtil::getRoleKeyByValue($value, self::$LIBRARY_ROLE );
	}
	
	public static function getClubRoleStr($value)
	{
		return RoleUtil::getRoleKeyByValue($value, self::$CLUB_ROLE );
	}
	
	public static function getUserSystemRole()
	{
		if(!isset(Yii::app()->session['userrole']) || !isset(Yii::app()->session['userrole']->role_system))
			return null;
		else
			return Yii::app()->session['userrole']->role_system;
	}
	
	public static function getUserLibraryRole()
	{
		if(!isset(Yii::app()->session['userrole']) || !isset(Yii::app()->session['userrole']->role_library))
			return null;
		else
			return Yii::app()->session['userrole']->role_library;
	}
	
	public static function getUserClubRole($club_id)
	{
		$userclub = Yii::app()->session['userclub'];
		if(!isset($userclub) || count($userclub)<1)
		{
			return null;
		}
		else
		{
			foreach($array as $key=>$value)
			{
				if($value->club_id === $club_id)
					return $value->club_role;
			}
		}
		return null;
	}
	
	public static function getUser()
	{
		if(!isset(Yii::app()->session['user']))
			return null;
		else
			return Yii::app()->session['user'];
	}
	
}