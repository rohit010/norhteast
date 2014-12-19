<?php

class OldSiteController extends CController
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = "oldsite_layout";
	public $breadcrumbs = null;
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	private $_assetsBase;

   public function getAssetsBase()
   {
       if ($this->_assetsBase === null) {
           $this->_assetsBase = Yii::app()->assetManager->publish(
               Yii::getPathOfAlias('application.assets'),
               false,
               -1,
               defined('YII_DEBUG') && YII_DEBUG
           );
       }
       return $this->_assetsBase;
   }
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	public function actionaboutus()
	{
		$this->render('aboutus');
	}
	public function actionongoingprojects()
	{
		$this->render('ongoingprojects');
	}
	public function actiongallery()
	{
		$this->render('gallery');
	}
	public function actionenquiry()
	{
		$leadTracker = new LeadTracker();
		$uid = Yii::app()->user->id;
		$time = time();
	    if(isset($_POST['lead_submit_button']))
		{
			$_POST['LeadTracker']['updated_time'] = $time;
			$_POST['LeadTracker']['created_time'] = $time;
			$_POST['LeadTracker']['current_status'] = 0;
			$_POST['LeadTracker']['created_by'] = 1;
			$_POST['LeadTracker']['updated_by'] = 1;
			$_POST['LeadTracker']['comments'] = " Direct From northeastproperties.in site";
			$_POST['LeadTracker']['source'] = "DirectNortheastSite";
			$_POST['LeadTracker']['assigned_to'] = 0;
			$_POST['LeadTracker']['assigned_on'] = $time;
			$leadTracker->attributes = $_POST['LeadTracker'];
  			if($leadTracker->validate()){
  				$contact_number = $_POST['LeadTracker']['contact_number'];
  				$last3_mont_time = time()-(60*60*24*180);
  				$user_exist = Yii::app()->db->createCommand()
						    ->select('count(*) as record_exist_count')
						    ->from('lead_tracker')
						    ->where('contact_number = :contact_number  and created_time >:created_time', array(':created_time'=>$last3_mont_time,':contact_number'=>$contact_number))
						    ->queryRow();
							if($user_exist['record_exist_count']>0){
  								$leadTracker->addError('contact_number', "  Phone number `$contact_number` is added ");
							} else {
								if($leadTracker->save(false)){
  									Yii::app()->user->setFlash('msg_success',"<span class='msg_info'> Thank you for your Interest in Northeastproperties. One of our sales Executive will contact you soon. </span>");
								} else {
									$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
								}
							}
  			} 
			//CVarDumper::dump($leadTracker,10,true); exit();
	    }
		$this->render('enquiry',array("leadTracker"=>$leadTracker));
	}
	public function actioncareers()
	{
		$this->render('careers');
	}
	public function actioncontact()
	{
		$this->render('contact');
	}
	public function actionnortheastparadise()
	{
		$this->render('northeastparadise');
	}
	public function actionnortheastblossom()
	{
		$this->render('northeastblossom');
	}
	public function actionaerovista()
	{
		$this->render('aerovista');
	}
	public function actionnews()
	{
		$this->render('news');
	}
	

	/**
	 * This is the action to handle external exceptions.
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

	/**
	 * Displays the contact page
	 */
	// public function actionContact()
	// {
		// $model=new ContactForm;
		// if(isset($_POST['ContactForm']))
		// {
			// $model->attributes=$_POST['ContactForm'];
			// if($model->validate())
			// {
				// $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				// $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				// $headers="From: $name <{$model->email}>\r\n".
					// "Reply-To: {$model->email}\r\n".
					// "MIME-Version: 1.0\r\n".
					// "Content-Type: text/plain; charset=UTF-8";
// 
				// mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				// Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				// $this->refresh();
			// }
		// }
		// $this->render('contact',array('model'=>$model));
	// }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}