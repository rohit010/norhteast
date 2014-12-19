<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = Users::model()->findByAttributes(array('email'=>$this->username));
		if ($user===null) { 
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		} else if (base64_decode($user->password) !== $this->password)  { 
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		} else if (!$user->status)  {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		} else { // Okay!
		    $this->errorCode=self::ERROR_NONE;
		    Yii::app()->user->setState("id",$user->uid);
		    Yii::app()->user->setState("name",$user->name);
		    Yii::app()->user->setState("user_type",$user->user_type);
			 Yii::app()->user->setState("user_access","");
			 Yii::app()->user->setState("user_hierarchy_list","");
			$user_access = array();
			$user_access_data = AuthAssignment::model() -> findall("userid = :userid",array(':userid' => $user->uid));
			if(!empty($user_access_data)){
				foreach ($user_access_data as $key => $value) {
					$user_access[$value->attributes['itemname']] = $value->attributes['itemname'];
				}
			}
			
			$user_hierarchy_list = array();
			$user_hierarchy = AdminUserHierarchy::model() -> findall("admin_user_id = :admin_user_id",array(':admin_user_id' => $user->uid));
			//CVarDumper::dump($Manage_user_hierarchy,10,true); exit();
			if(!empty($user_hierarchy)){
				foreach ($user_hierarchy as $key => $value) {
					array_push($user_hierarchy_list,$value->attributes['mapped_admin_user_id']);
				}
			}
			
			 Yii::app()->user->setState("user_access",$user_access);
			 Yii::app()->user->setState("user_hierarchy_list",$user_hierarchy_list);
		}
	
		return !$this->errorCode;
	}
}