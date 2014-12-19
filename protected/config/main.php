<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once dirname(__FILE__).'/dbConnection.php';
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Northeast Properties',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.internal.models.*',
		'application.components.modules*',
		'application.modules.rights.*',
        'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'northeast',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.0.103'),
		),
		'rights'=>array(
			'userClass' => 'Users',	
        	//'install'=>true,
        ),
		'internal',
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'class'=>'RWebUser',
			'allowAutoLogin'=>false,
			'loginUrl'=>array('/user/login'),
		),
		'rights'=>array(
			'superuserName'=>'Admin',
			'authenticatedName'=>'Admin',
			'userIdColumn'=>'uid',
			'userNameColumn'=>'name',
			'enableBizRule'=>true,
			'enableBizRuleData'=>false,
			'displayDescription'=>true,
			'flashSuccessKey'=>'RightsSuccess',
			'flashErrorKey'=>'RightsError',
		//	'install'=>true,
			'baseUrl'=>'/rights',
			'layout'=>'rights.views.layouts.main',
			'appLayout'=>'application.views.layouts.main',
			'cssFile'=>'rights.css',
		//	'install'=>true,
			'debug'=>false,
		),

		
		'authManager'=>array(
				'class' => 'RDbAuthManager',
		    	// 'assignmentTable' => 'AuthAssignment',
		    	// 'itemTable' => 'AuthItem',
		    	// 'itemChildTable' => 'AuthItemChild',
		    	// 'rightsTable' => 'Rights',
                'connectionID'=>'db',
                
        ),
        
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'rules'=>array(
				'<action>' => 'OldSite/<action>',
				'' => 'OldSite/index',
				'internal/<action>' => 'internal/default/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'urlFormat'=>'path',
			'showScriptName'=>false,
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
		// 'db'=>array(
			// 'connectionString' => 'mysql:host=mysql7.000webhost.com;dbname=a8150779_ne',
			// 'emulatePrepare' => true,
			// 'username' => 'a8150779_ne',
			// 'password' => 'northeast10',
			// 'charset' => 'utf8',
		// ),
		'db'=>$primaryDB,
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);