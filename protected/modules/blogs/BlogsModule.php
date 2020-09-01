<?php

class BlogsModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		Yii::app()->errorHandler->errorAction = 'blogs/default/error';
		Yii::app()->defaultController = 'blogs/default/index';
		//Yii::app()->user->loginUrl = 'blogs/default/login';

		// import the module-level models and components
		$this->setImport(array(
			'blogs.models.*',
			'blogs.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		return true;
		if(parent::beforeControllerAction($controller, $action))
		{
			if(strpos(Yii::app()->request->url,Yii::app()->user->loginUrl)>-1)
			{
				return true;
			}
			// 其他页面必须登陆才可进入：
			else 
			{
				if(isset(Yii::app()->session['user']) && !empty(Yii::app()->session['user']))
				{
					return true;
				}
				// 未登录则跳转到登陆页面
				else
				{
					Header("Location:".Yii::app()->createUrl(Yii::app()->user->loginUrl));
				}
			}
		}
		else
			return false;		
	}
}
