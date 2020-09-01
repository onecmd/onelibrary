<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Onelibrary Library Center',
	//'language'=>'zh_cn',
	 
	// change the default controller:
	'defaultController'=>'default',

	// preloading 'log' component
	'preload'=>array('log'),
	
    'aliases' => array(
        // yiistrap configuration
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change if necessary
        // yiiwheels configuration
        //'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
        // EHttpClient configuration
        'ehttpclient' => realpath(__DIR__ . '/../extensions/EHttpClient'), // change if necessary
),	

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		
		'application.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths' => array('bootstrap.gii'),
		),
		'library',
		'blogs',
		'club',
		'tuhome',
		'my',
	),

	// application components
	'components'=>array(
        // yiistrap configuration
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',   
        ),
        
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
        	'loginUrl'=>'default/login',
		),
		
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix'=>'.html',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			
			'connectionString' => 'mysql:host=localhost;dbname=db_cdtu',
			'username' => 'root',
			'password' => 'dbpass',
			
			'emulatePrepare' => true,
			'charset' => 'utf8',
			'tablePrefix'=>'tb_',
		),
		'db_mvnform'=>array(
			'class'=> 'CDbConnection' ,
			'connectionString' => 'mysql:host=localhost;dbname=mvnforum',
			'username' => 'root',
			'password' => 'dbpass',
			
			'emulatePrepare' => true,
			'charset' => 'utf8',
			'tablePrefix'=>'mvnforum',
		),
		//'mailer' => array(
      	//	'class' => 'application.extensions.mailer.EMailer',
      	//	'pathViews' => 'application.views.email',
      	//	'pathLayouts' => 'application.views.email.layouts'
   		//),
		'mailer' => array(
      		'class' => 'application.extensions.mailer.EMailer',
      		'pathViews' => 'application.views.email',
      		'pathLayouts' => 'application.views.email.layouts',
      		'CharSet' => 'utf-8', 
			'Host' => 'onelibrary_mail.onelibrary.com', 
			'SMTPAuth' => false, 
			'Username' => 'mailer_user@onelibrary.com', 
//			'Password' => 'passwd', // ....
			'Port'=>25,
			'From' => 'mailer_user@onelibrary.com', //.....email..
			'FromName' => 'Onelibrary',
   		),   		
		'errorHandler'=>array(
			// use 'default/error' action to display errors
			'errorAction'=>'default/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'MvnForumAuthUrl'=>'http://127.0.0.1/mvnforum/mvnforum/auth',
	),
);