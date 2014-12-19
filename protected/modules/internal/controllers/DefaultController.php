<?php
class DefaultController extends InternalController
{
	public $layout = 'internalLayout';
	
	public function beforeAction($action){
		$anaymonous_page_list =array("","login","LeadDetails");
		$current_action = Yii::app()->controller->action->id;
		$current_page = urlencode(Yii::app()->request->url);
		if(!Yii::app()->user->id) {
			if(in_array($current_action,$anaymonous_page_list)){
				return TRUE;
			} else {
				$this->redirect(array("/internal/login?redirect_url=$current_page"));
			}
		} else {
			return TRUE;
		}
	}
	public function actionIndex()
	{
		$this->pageTitle = "Dashbord";
		if(Yii::app()->user->id==""){
			$this->redirect("/internal/login");
			exit();
		}
		$sevenDay_time = time()-(60*60*24*10);
		$sevenDay_time = date("d-M-Y",$sevenDay_time);
		$sevenDay_time = strtotime($sevenDay_time);
		$lead_owner_count = "";
		$update_owner = "";
		$lead_owner = "";
		$user_hierarchy_list = array(Yii::app()->user->id);
		if(isset(Yii::app()->user->user_hierarchy_list) && !empty(Yii::app()->user->user_hierarchy_list)){
			$user_hierarchy_list = Yii::app()->user->user_hierarchy_list;
		}
		if(isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']){
			$lead_owner = "";
			$update_owner = "";
		} else if(isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager']){
			$lead_owner_count = " AND assigned_to in (".implode(",", $user_hierarchy_list).")";
			$lead_owner = " WHERE assigned_to in (".implode(",", $user_hierarchy_list).")";
			$update_owner = "WHERE updated_by in (".implode(",", $user_hierarchy_list).")";
		} else {
			$lead_owner_count = " AND assigned_to = '".Yii::app()->user->id."'";
			$lead_owner = " WHERE assigned_to = '".Yii::app()->user->id."'";
			$update_owner = "WHERE updated_by = '".Yii::app()->user->id."'";
		}
			
		$and_condiyion = ($lead_owner=='')?'':"and";
		$sql_counts = "SELECT `current_status`,count(id) FROM `lead_tracker` WHERE `assigned_on`>'$sevenDay_time' $lead_owner_count group by `current_status`";
		$sql_counts_result = Yii::app()->db->createCommand($sql_counts)->queryAll();
		$sql_rescent_activity = "SELECT id,current_status,comments,updated_time FROM lead_tracker $update_owner order by updated_time desc limit 10";
		$sql_rescent_activity_result = Yii::app()->db->createCommand($sql_rescent_activity)->queryAll();
		
		$sql_rescent_leads = "SELECT id,name,email,contact_number,query,created_time FROM lead_tracker  $lead_owner order by created_time desc limit 10";
		$sql_rescent_leads_result = Yii::app()->db->createCommand($sql_rescent_leads)->queryAll();
		//CVarDumper::dump($sql_rescent_activity_result,10,true); exit();
       $this->render('index',array(
       									"sql_counts_result"				=>	$sql_counts_result,
       									"sevenDay_time"					=>	$sevenDay_time,
										"sql_rescent_activity_result"	=>	$sql_rescent_activity_result,
										"sql_rescent_leads_result"		=>	$sql_rescent_leads_result
									)
					);
	}
	
	public function actionLogin()
	{
		if(Yii::app()->user->id!=""){
			if(isset($_GET['redirect_url']) && $_GET['redirect_url']!="") {
				$redirect_url = $_GET['redirect_url'];
			} else {
				$redirect_url = "/internal/index";
			}
			$this->redirect($redirect_url);
			exit();
		}
		$this->layout = "internalEmptyLayout";
		$form=new LoginForm;
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$form->attributes=$_POST['LoginForm'];
			// validate user input and redirect to previous page if valid
			if($form->validate()  && $form->login()){
				if(isset($_GET['redirect_url']) && $_GET['redirect_url']!="") {
				$redirect_url = $_GET['redirect_url'];
				} else {
					$redirect_url = "/internal/index";
				}
				$this->redirect($redirect_url);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$form));
	}
	
	public function actionUpdateLead(){
		if(isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']==TRUE){
		
			$this->pageTitle = "Update Leads";
			$id = (isset($_GET['id'])?$_GET['id']:0);
			$time = time();
		  	$leadTracker = LeadTracker::model()->findByPk($id);
			$phoneNumber = $leadTracker->contact_number;
			$email = $leadTracker->email;
		  	
		    if(isset($_POST['lead_submit_button']))
			{
	///			$_POST['LeadTracker']['updated_time'] = $time;
				$_POST['LeadTracker']['current_status'] = 0;
	//			$_POST['LeadTracker']['updated_by'] = $uid;
				$_POST['LeadTracker']['assigned_on'] = $time;
				$leadTracker->attributes = $_POST['LeadTracker'];
	  			if($leadTracker->validate()){
	  				$last3_mont_time = time()-(60*60*24*180);
	  				if($_POST['LeadTracker']['contact_number']=="" && $_POST['LeadTracker']['email']==""){
	  					$leadTracker->addError('error', "Email Or Contact Numbers any one sholud be present");
	  				} else if($_POST['LeadTracker']['contact_number']=="" && $_POST['LeadTracker']['email']!=""){
	  					$email = $_POST['LeadTracker']['email'];
						if($email!=$_POST['LeadTracker']['email']){
		  					$user_exist = Yii::app()->db->createCommand()
													    ->select('count(*) as record_exist_count')
													    ->from('lead_tracker')
													    ->where('email = :email  and created_time>:created_time', array(':created_time'=>$last3_mont_time,':email'=>$email))
													    ->queryRow();
							if($user_exist['record_exist_count']>0){
								$leadTracker->addError('email', "Email-id `$email` is added in last 180 days please use same for further process");
							} else {
			  					if($leadTracker->save(false)){
									Yii::app()->user->setFlash('msg_success',"Lead Updated Successfully");
									$this->redirect(array("manageLeads"));
								} else {
									$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
								}
							}
						} else {
							if($leadTracker->save(false)){
								Yii::app()->user->setFlash('msg_success',"Lead Updated Successfully");
								$this->redirect(array("manageLeads"));
							} else {
								$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
							}
						}
					} else if(($_POST['LeadTracker']['contact_number']!="" && $_POST['LeadTracker']['email']=="") || ($_POST['LeadTracker']['contact_number']!="" && $_POST['LeadTracker']['email']!="")){
		  				$contact_number = $_POST['LeadTracker']['contact_number'];
						if($phoneNumber!=$_POST['LeadTracker']['contact_number']){
			  				$user_exist = Yii::app()->db->createCommand()
													    ->select('count(*) as record_exist_count')
													    ->from('lead_tracker')
													    ->where('contact_number = :contact_number  and created_time>:created_time', array(':created_time'=>$last3_mont_time,':contact_number'=>$contact_number))
													    ->queryRow();
							if($user_exist['record_exist_count']>0){
								$leadTracker->addError('contact_number', "Phone number `$contact_number` is added in last 180 days please use same for further process");
							} else {
								if($leadTracker->save(false)){
									Yii::app()->user->setFlash('msg_success',"Lead Updated Successfully");
									$this->redirect(array("manageLeads"));
								} else {
									$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
								}
							}
						} else {
							if($leadTracker->save(false)){
								Yii::app()->user->setFlash('msg_success',"Lead Updated Successfully");
								$this->redirect("manageLeads");
							} else {
								$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
							}
						}
					}
	  			} 
		    }
			
			 
		    $this->render('add_leads',
		    							array(
		    									"leadTracker"	=>	$leadTracker,
											)
						);
		} else {
				throw new CHttpException(401,'You Are not authorized to perform this action');
		}
	}
	public function actionAddLeads(){
		$this->pageTitle = "Add Leads";
		$leadTracker = new LeadTracker();
		$uid = Yii::app()->user->id;
		$time = time();
	    if(isset($_POST['lead_submit_button']))
		{
			$_POST['LeadTracker']['updated_time'] = $time;
			$_POST['LeadTracker']['created_time'] = $time;
			$_POST['LeadTracker']['current_status'] = 0;
			$_POST['LeadTracker']['created_by'] = $uid;
			$_POST['LeadTracker']['updated_by'] = $uid;
			$_POST['LeadTracker']['comments'] = "Created by ".Yii::app()->user->name;
			if(isset(Yii::app()->user->user_access['Manager'])){
				$_POST['LeadTracker']['assigned_to'] = $uid;
			} else {
				$_POST['LeadTracker']['assigned_to'] = 0;
			}
			$_POST['LeadTracker']['assigned_on'] = $time;
			$leadTracker->attributes = $_POST['LeadTracker'];
  			if($leadTracker->validate()){
  				$last3_mont_time = time()-(60*60*24*180);
  				if($_POST['LeadTracker']['contact_number']=="" && $_POST['LeadTracker']['email']==""){
  					$leadTracker->addError('error', "Email Or Contact Numbers any one sholud be present");
  				} else if($_POST['LeadTracker']['contact_number']=="" && $_POST['LeadTracker']['email']!=""){
  					$email = $_POST['LeadTracker']['email'];
  					$user_exist = Yii::app()->db->createCommand()
							    ->select('count(*) as record_exist_count')
							    ->from('lead_tracker')
							    ->where('email = :email  and created_time>:created_time', array(':created_time'=>$last3_mont_time,':email'=>$email))
							    ->queryRow();
								if($user_exist['record_exist_count']>0){
	  								$leadTracker->addError('email', "Email-id `$email` is added in last 180 days please use same for further process");
								} else {
				  					if($leadTracker->save(false)){
										Yii::app()->user->setFlash('msg_success',"Lead Added Successfully <a href='/internal/AddLeads'>Add another Lead</a>");
									} else {
										$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
									}
								}
				} else if(($_POST['LeadTracker']['contact_number']!="" && $_POST['LeadTracker']['email']=="") || ($_POST['LeadTracker']['contact_number']!="" && $_POST['LeadTracker']['email']!="")){
	  				$contact_number = $_POST['LeadTracker']['contact_number'];
	  				$user_exist = Yii::app()->db->createCommand()
							    ->select('count(*) as record_exist_count')
							    ->from('lead_tracker')
							    ->where('contact_number = :contact_number  and created_time>:created_time', array(':created_time'=>$last3_mont_time,':contact_number'=>$contact_number))
							    ->queryRow();
								if($user_exist['record_exist_count']>0){
	  								$leadTracker->addError('contact_number', "Phone number `$contact_number` is added in last 180 days please use same for further process");
								} else {
									if($leadTracker->save(false)){
	  									Yii::app()->user->setFlash('msg_success',"Lead Added Successfully <a href='/internal/AddLeads'>Add another Lead</a>");
									} else {
										$leadTracker->addError('contact_number', 'Something happened Please try again after some time');
									}
								}
				}
				
				
  			} 
	    }
	    $this->render('add_leads',array("leadTracker"=>$leadTracker));
	}
	public function getUserInfo($user_list,$uid,$user_count){
		if($user_count>0 && $uid>0){
			if($uid >= intval($user_count/2)){
				for ($i=$user_count-1; $i < $user_count; $i--) { 
					if($user_list[$i]['uid']==$uid){
						echo $user_list[$i]['name'];
						break;
					}
				}
			} else {
				for ($i=0; $i < $user_count; $i++) { 
					if($user_list[$i]['uid']==$uid){
						echo $user_list[$i]['name'];
						break;
					}
				}
			}
		} else {
			echo "No User";
		}
	}
	private function getUsersList($type=0){
		$active_condition = "";
		if($type==1){
			$user_list = "";
			if((isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager'])){
				$user_hierarchy_list = array(Yii::app()->user->id);
				if(isset(Yii::app()->user->user_hierarchy_list) && !empty(Yii::app()->user->user_hierarchy_list)){
					$user_hierarchy_list = Yii::app()->user->user_hierarchy_list;
				}
				$user_list = " and uid in (".implode(",", $user_hierarchy_list).")";
			}
			$active_condition = "where status = '1' $user_list";
		} 
		
		$sql_users = "select uid,name from users $active_condition";
		$sql_users_result = Yii::app()->db->createCommand($sql_users)->queryAll();
		return $sql_users_result;
	}

	public function actionmanageLeads(){
		$this->pageTitle = "Manage Leads";
		$uid = Yii::app()->user->id;
		$user_hierarchy_list = array($uid);
		if(isset(Yii::app()->user->user_hierarchy_list) && !empty(Yii::app()->user->user_hierarchy_list)){
			$user_hierarchy_list = Yii::app()->user->user_hierarchy_list;
		}
		$usersList = $this->getUsersList();
		$usersActiveList = $this->getUsersList("1");
		$source_list = $this->getSourceList();
		$keyword_search = "";
		$owner_search = "";
		$date_filter= "";
		$source_filter = "";
		$status_filter = "";
		$manager_list = array();
		if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageLeads']) && Yii::app()->user->user_access['AdminManageLeads'])) {
			$manager_list =  $this->getManagersList();
			$admin_user = 1;
		} else {
			$admin_user = 0;
		}
		$limit = 25;
		$offset = 0;
		if(isset($_GET['limit']) && $_GET['limit']!=""){
			$limit = $_GET['limit'];
		}
		if(isset($_GET['offset']) && $_GET['offset']!=""){
			$offset = $_GET['offset']-1;
		}
		
		if(isset($_GET['status_filter']) && $_GET['status_filter']!=""){
			$status_filter_query = " and current_status = '".$_GET['status_filter']."'";
		} else {
			$status_filter_query = "";
		}
		
		if(isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']!="" && isset($_GET['keyword'])){
			if($_GET['keyword_filter_type']=="name"){
				$keyword_search = " and name LIKE '%".$_GET['keyword']."%'";
			} else if($_GET['keyword_filter_type']=="email"){
				$keyword_search = " and email  = '".$_GET['keyword']."'";
			} else if($_GET['keyword_filter_type']=="mobile"){
				$keyword_search = " and contact_number = '".$_GET['keyword']."'";
			} 
		} 
		if($admin_user){
			if(isset($_GET['select_lead_owner']) && $_GET['select_lead_owner']!=""){
				if($_GET['select_lead_owner']=="-1"){
					$owner_search = " and assigned_to = 0";
				} else {
					$owner_search = " and assigned_to=".$_GET['select_lead_owner'];
				}
			}
		} else {
			if(isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager']){
				$owner_search = " and assigned_to in (".implode(",", $user_hierarchy_list).")";
				//$lead_owner_creater = " or created_by = ".Yii::app()->user->id;
			} else {
				$owner_search = " and assigned_to=".Yii::app()->user->id;
			}
		}
		if(isset($_GET['source']) && $_GET['source']!=""){
			$source_filter = "and source = '".$_GET['source']."'";
		}
		if(isset($_GET['date_filter']) && $_GET['date_filter']!=""){
			$filter_type = "and created_time ";
			if($_GET['date_filter']=="created_date"){
				$filter_type = "and created_time ";
			} else if($_GET['date_filter']=="assign_date"){
				$filter_type = "and assigned_on ";
			} else if($_GET['date_filter']=="updated_date"){
				$filter_type = "and updated_time ";
			}
			if((isset($_GET['from']) && $_GET['from']!="") && (isset($_GET['to']) && $_GET['to']!="")){
				$date_filter_condition = " BETWEEN ".strtotime(str_replace("/","-",$_GET['from']))." AND ".(strtotime(str_replace("/","-",$_GET['to']))+(60*60*24));
			} else if((isset($_GET['from']) && $_GET['from']!="") && $_GET['to']==""){
				$date_filter_condition = " > ".strtotime(str_replace("/","-",$_GET['from']));
			} else if((isset($_GET['to']) && $_GET['to']!="") && $_GET['from']=""){
				$date_filter_condition = " < ".(strtotime(str_replace("/","-",$_GET['to']))+(60*60*24));
			}
		 	$date_filter = " $filter_type $date_filter_condition"; 
		}
		$where = "where 1=1 $keyword_search $owner_search $date_filter $source_filter $status_filter_query ";
		$order = " order by updated_time desc";
		$sql_query_lead_capure_count = "select count(id) from lead_tracker $where";
		$sql_query_lead_capure = "select * from lead_tracker $where $order LIMIT $offset,$limit";
		$sql_query_lead_capure_full_list = "select * from lead_tracker $where $order ";
		$sql_query_lead_capure_count_result = Yii::app()->db->createCommand($sql_query_lead_capure_count)->queryScalar();
		$sql_query_lead_capure_result = Yii::app()->db->createCommand($sql_query_lead_capure)->queryAll();
		$pagination = $this->Pagination(preg_replace('/(&?limit=\d+)|(&?offset=\d+)/','',Yii::app()->request->url),$sql_query_lead_capure_count_result,$offset,$limit);
		
		$this->render("manage_leads",
									array(	"sql_query_lead_capure_result"		=>	$sql_query_lead_capure_result,
											"usersList"							=>	$usersList,
											"usersActiveList"					=>	$usersActiveList,
											"source_list"						=>	$source_list,
											"sql_query_lead_capure"				=>	$sql_query_lead_capure,
											"admin_user"						=>	$admin_user,
											"pagination"						=>	$pagination,
											"sql_query_lead_capure"				=>	$sql_query_lead_capure,
											"sql_query_lead_capure_full_list"	=>	$sql_query_lead_capure_full_list,
											"manager_list"						=>	$manager_list,
											"totalCount"						=>	$sql_query_lead_capure_count_result
										)
					);
	}
	public function actionLeadDetails(){
		$this->pageTitle = "Leads Details";
		$this->layout = "internalEmptyLayout";
		if(isset($_GET['id']) && $_GET['id']!=""){
			$usersList = $this->getUsersList();
			$lead_id =  $_GET['id'];
			$sql_query_current_lead = "select * from lead_tracker where id = $lead_id";
			$sql_query_current_lead_result = Yii::app()->db->createCommand($sql_query_current_lead)->queryRow();
			$sql_query_current_lead_history = "select * from lead_tracker_history where lead_id = $lead_id order by id desc";
			$sql_query_current_lead_history_result = Yii::app()->db->createCommand($sql_query_current_lead_history	)->queryAll();
			
			$this->render("LeadDetails",array( 
												"sql_query_current_lead_result"			=> $sql_query_current_lead_result,
												"sql_query_current_lead_history_result"	=> $sql_query_current_lead_history_result,
												"usersList"								=> $usersList
												)
							);
			
		} else {
			
		}
		
	}
	function cleanData(&$str) {
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if (strstr($str, '"'))
		$str = '"' . str_replace('"', '""', $str) . '"';
	}
	public function actionDownloadData(){
		if(isset($_GET['data']) && $_GET['data']!=""){
			$filename = "Lead_list_" . date('d-M-Y') . ".xls";
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
		} else {
			echo "Something went wrong";
			exit();
		}
		$slNo = 1;
		$encoded_query = $_GET['data'];
		$query_string =  base64_decode($encoded_query);
		$query_result = Yii::app()->db->createCommand($query_string)->queryAll();
		echo "Name" . "\t"."Email" . "\t"."Contact Number"."\t". " Query" ."\r\n";
		foreach ($query_result as $key => $row) {
			echo $row['name']."\t" .$row['email']."\t" .$row['contact_number']."\t".$row['query']."\r\n";
			$slNo++;
		}
	}
	public function actionmanageUsers(){
		$this->pageTitle = "Manage Users";
		$limit = 10;
		$offset = 0;
		if(isset($_GET['limit']) && $_GET['limit']!=""){
			$limit = $_GET['limit'];
		}
		if(isset($_GET['offset']) && $_GET['offset']!=""){
			$offset = $_GET['offset']-1;
		}
		$keyword_search = "";
		$default_status = "status = 1 ";
		if(isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']!="" && (isset($_GET['keyword']) && $_GET['keyword']!="")){
			if($_GET['keyword_filter_type']=="name"){
				$keyword_search = " and name LIKE '%".$_GET['keyword']."%'";
			} else if($_GET['keyword_filter_type']=="email"){
				$keyword_search = " and email  = '".$_GET['keyword']."'";
			} else if($_GET['keyword_filter_type']=="mobile"){
				$keyword_search = " and contact_number = '".$_GET['keyword']."'";
			} 
		}
		if(isset($_GET['user_status']) && $_GET['user_status']!=""){
			if($_GET['user_status']=="-1"){
				$default_status = "1=1";
			} else {
				$default_status = " status = ".$_GET['user_status'];
			}
		}
		$sql_query_users = "select * from users where $default_status $keyword_search LIMIT $offset,$limit";
		$sql_query_users_count = "select count(uid) from users where $default_status $keyword_search";
		$sql_query_users_result = Yii::app()->db->createCommand($sql_query_users)->queryAll();
		$sql_query_users_count_result = Yii::app()->db->createCommand($sql_query_users_count)->queryScalar();
		$pagination = $this->Pagination(preg_replace('/(&?limit=\d+)|(&?offset=\d+)/','',Yii::app()->request->url),$sql_query_users_count_result,$offset,$limit);
		$this->render("manage_users",array("sql_query_users_result"=>$sql_query_users_result,"pagination"=>$pagination));
	}
	public function actionOurTeam(){
		$this->pageTitle = "Our Team";
		$where = "";
		$offset=0;
		$limit=10;
		if(isset($_GET['limit']) && $_GET['limit']!=""){
			$limit = $_GET['limit'];
		}
		if(isset($_GET['offset']) && $_GET['offset']!=""){
			$offset = $_GET['offset']-1;
		}
		$variable_array = array();
		if(isset($_GET['uid']) && $_GET['uid']!=""){
			$where .= " and uid= :uid ";
			$variable_array[':uid'] = $_GET['uid'];
		}
		if(isset($_GET['name']) && $_GET['name']!=""){
			$where .= " and name like :name";
			$variable_array[':name'] = "%".$_GET['name']."%";
		}
		if(isset($_GET['phone']) && $_GET['phone']!=""){
			$where .= " and contact_number = :phone";
			$variable_array[':phone'] = $_GET['phone'];
		}
		if(isset($_GET['email']) && $_GET['email']!=""){
			$where .= " and email= :email ";
			$variable_array[':email'] = $_GET['email'];
		}
		if(isset($_GET['location']) && $_GET['location']!=""){
			$where .= " and location like :location";
			$variable_array[':location'] = "%".$_GET['location']."%";
		}
		$user_List_limit = Yii::app()->db->createCommand()
						    ->select('count(uid) as total_count')
						    ->from('users')
						    ->where("status=1 $where",$variable_array)
						    ->queryScalar();						

		if(isset($_GET['compleate_list']) && $_GET['compleate_list']!=""){
			$limit  = $user_List_limit;
		}
		$user_List = Yii::app()->db->createCommand()
						    ->select('uid,name,contact_number,date_of_birth,email,location')
						    ->from('users')
						    ->where("status=1 $where",$variable_array)
							->limit($limit,$offset)
						    ->queryAll();
		
		$pagination = $this->Pagination(preg_replace('/(&?limit=\d+)|(&?offset=\d+)/','',Yii::app()->request->url),$user_List_limit,$offset,$limit);
		$this->render("OurTeam",array(	'user_List'		=>	$user_List,
										"pagination"	=>	$pagination,
										"user_count"	=>	$user_List_limit
									)
					);
	}

	public function actionManage_user_hierarchy(){
		$status		=	0;
		$msg 		= 	"";
		if(isset($_POST['method']) && $_POST['method']!=""){
			if($_POST['method']=="remove"){
				$user_remove_group = AdminUserHierarchy::model() -> find("admin_user_id = :admin_user_id and mapped_admin_user_id = :mapped_admin_user_id ",array(':admin_user_id' => $_POST['parent_id'],':mapped_admin_user_id' => $_POST['user_id']));
				if($user_remove_group!="null"){
					if($user_remove_group->delete()){
						$status 	= 1;
						$msg 		= 	"User removed successfully";				
					} else {
						$status 	= 0;
						$msg 		= 	"Something went wrong while adding users";
					}	
				} else {
					$status 	= 0;
					$msg 		= 	"User not found please refresh page and try again";
				}
			}
			else if($_POST['method']=="add"){
				$user_add_group = AdminUserHierarchy::model() -> find("admin_user_id = :admin_user_id and mapped_admin_user_id = :mapped_admin_user_id ",array(':admin_user_id' => $_POST['parent_id'],':mapped_admin_user_id' => $_POST['user_id']));
				if($user_add_group==null){
					$AdminUserHierarchy = new AdminUserHierarchy();
					$final_data = array(
											"admin_user_id"			=>	$_POST['parent_id'],
											"mapped_admin_user_id"	=>	$_POST['user_id']
										);
					$AdminUserHierarchy->attributes = $final_data;
					if($AdminUserHierarchy->save()){
						$status 	= 1;
						$msg 		= 	"User added successfully";	
					} else {
						$status 	= 0;
						$msg 		= 	"Something went wrong while adding users";
					}	
				} else {
					$status 	= 0;
					$msg 		= 	"User not found please refresh page and try again";
				}
			}
		}
		echo json_encode(array("status"=>$status,"msg"=>$msg));
	}

	public function actionAddUsers(){
		$this->pageTitle = "Add Users";
		$time = time();
		$Users  = new Users();
		if(isset($_POST['add_users_button'])){
			$_POST['Users']['created'] = $time;
			$_POST['Users']['user_type'] = 3;
			$_POST['Users']['status'] = 0;
			
			$_POST['Users']['date_of_birth'] = strtotime($_POST['Users']['date_of_birth']);
			$Users->attributes = $_POST['Users'];
			if($Users->validate()){
				$Users->password = base64_encode($_POST['Users']['password']);
	  			if($Users->save(false)){
	  				//CVarDumper::dump($Users->attributes,10,true);
					$AdminUserHierarchy = new AdminUserHierarchy();
					$user_Hierarchy_data = array(
											"admin_user_id"			=>	$Users->attributes['uid'],
											"mapped_admin_user_id"	=>	$Users->attributes['uid']
										);
					$AdminUserHierarchy->attributes = $user_Hierarchy_data;
					$AdminUserHierarchy->save();
					
	  				Yii::app()->user->setFlash('msg_success',"User Added Successfully <a href='/internal/AddUsers'>Add another employee</a>");
	  			} 
			}
		}
		$this->render("add_users",array("Users"=>$Users));
	}
	
	public function actionEditUsersinfo(){
		$this->pageTitle = "Edit Users Info";
		$Users_info = null;
		$error_list = array();
		$owner_user = TRUE;
		
		if(isset($_GET['uid']) && $_GET['uid']!=""){
			$Users = new Users();
			$uid = $_GET['uid'];
			$usersList = array();
			$User_hierarchy_list = array();
			$User_hierarchy_ids = array(Yii::app()->user->id); 
		 	if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser']) || (isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager'])){
				if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){
					$Manage_user_uid = $uid;
				} else {
					$Manage_user_uid = Yii::app()->user->id;
				}
				$Manage_user_hierarchy = AdminUserHierarchy::model() -> findall("admin_user_id = :admin_user_id",array(':admin_user_id' => $Manage_user_uid));
				$usersList = $this->getUsersList();
				//CVarDumper::dump($Manage_user_hierarchy,10,true); exit();
				if(!empty($Manage_user_hierarchy)){
					foreach ($Manage_user_hierarchy as $key => $value) {
						array_push($User_hierarchy_list,$value->attributes);
						 if(isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager']){
							if(!in_array($value->mapped_admin_user_id, $User_hierarchy_ids)){
								array_push($User_hierarchy_ids,$value->mapped_admin_user_id);
							}
						 }
					}
				}
		 	}	
			if((isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser']) || (isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin'])){
				$owner_user = TRUE;				
			} else if(isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager']){
				if(!in_array($uid, $User_hierarchy_ids)){
					Yii::app()->user->setFlash('error',"You are not authorized to do this");
					$owner_user = FALSE;
				}
				
			} else {
				if($uid!=Yii::app()->user->id){
					Yii::app()->user->setFlash('error',"You are not authorized to do this");
					$owner_user = FALSE;
				}
			}
			try{
				if($owner_user){
					$Users_info = Users::model()->findByPk($uid);
				} else {
					$Users_info = null;
				}
			} catch(exception $e){
				Yii::app()->user->setFlash('error',"Users not found");
			}
			if($Users_info!=null) {
				if(isset($_POST['Users'])){
					$_POST['Users']['date_of_birth'] = strtotime($_POST['Users']['date_of_birth']);
					$Users_info->name = $_POST['Users']['name'];
					$Users_info->email = $_POST['Users']['email'];
					$Users_info->contact_number = $_POST['Users']['contact_number'];
					$Users_info->password = $_POST['Users']['password'];
					$Users_info->repeat_password = $_POST['Users']['repeat_password'];
					$Users_info->location = $_POST['Users']['location'];
					$Users_info->date_of_birth = $_POST['Users']['date_of_birth'];
					$Users_info->message = $_POST['Users']['message'];
					if($Users_info->validate()){
						$Users_info->password = base64_encode($_POST['Users']['password']);
						$Users_info->repeat_password = base64_encode($_POST['Users']['repeat_password']);
						if($Users_info->save(false)){
							Yii::app()->user->setFlash('msg_success',"User Updated Successfully <a href='/internal/manageUsers'>Manage Users</a>");
						}
					} 
					$error_list = $Users_info->getErrors();
				}
				$this->render("add_users",array(
														"Users"					=>	$Users,
														"Users_info"			=>	$Users_info->attributes,
														"error_list"			=>	$error_list,
														"User_hierarchy_list"	=>	$User_hierarchy_list,
														"usersList"			=>	$usersList,
														"uid"					=>	$uid
													)
								);
			} else {
				$this->render("error",array("msg"=>"User not found"));
			}
		} else {
			$this->render("error",array("msg"=>"User not found"));
		}
	}
	
	public function actionAjaxUpadeUserStatus(){
		$status = $_POST['change_status'];
		$uid = $_POST['uid'];
		$update_user_status = "UPDATE users SET  status =  '$status' WHERE  uid = '$uid'";
		$update_user_status_result = Yii::app()->db->createCommand($update_user_status)->Execute();
		echo json_encode(array("status_code"=>"0","status_msg"=>"User Status Changed Successfully"));
	}
	public function actionMyLeads(){
		$this->render("add_users");
	}
	
	public function getSourceList(){
		$sql_source = "select distinct(source) from lead_tracker where source !=''";
		$sql_source_result = Yii::app()->db->createCommand($sql_source)->queryAll();
		return $sql_source_result;
	}
	protected function performAjaxValidation($model)
	{
	    if(isset($_POST['ajax']) && $_POST['ajax']==='lead_capture')
	    {	
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
    	}
	}
	
	public function getManagersList(){
		$sql_manager_list = "SELECT u.uid,u.name FROM users u JOIN `AuthAssignment` a ON u.uid = a.userid where a.itemname = 'Manager' order by name";
		$manager_list = Yii::app()->db->createCommand($sql_manager_list)->queryAll();
		return $manager_list;
	}
	
	public function Update_lead_information($lead_id,$data=array()){
		$time = time();
		$leadInfo = LeadTracker::model()->findByPk($lead_id);
		$LeadTrackerHistory_values = array();
		$LeadTrackerHistory_values['lead_id'] = $leadInfo->id;
		$LeadTrackerHistory_values['comments'] = $leadInfo->comments;
		$LeadTrackerHistory_values['status'] = $leadInfo->current_status;
		$LeadTrackerHistory_values['assigned'] = $leadInfo->assigned_to;
		$LeadTrackerHistory_values['current_time'] = $leadInfo->updated_time;
		$LeadTrackerHistory_values['updated_by'] = $leadInfo->updated_by;
		if($data['assigne_exist']==1){
			$leadInfo->assigned_to = $data['lead_assigne'];
			$leadInfo->assigned_on = $time;
		} else {
			$leadInfo->current_status = $data['lead_status'];
		}
		$leadInfo->updated_by = Yii::app()->user->id;
		$leadInfo->comments = $data['lead_comments'];
		$leadInfo->updated_time = $time;
		if($leadInfo->save()){
			$LeadTrackerHistory = new LeadTrackerHistory();
			$LeadTrackerHistory->attributes = $LeadTrackerHistory_values;
			if($LeadTrackerHistory->save()){
				return TRUE;
			} else {
				return FALSE;
			}
		}  else {
			return FALSE;
		}
	}
	public function actionAJAXUpdateLeadInformation(){
		if($_POST['users_type']=="all"){
			$_POST['lead_assigne'] = $_POST['lead_assigne_all'];
		} else if($_POST['users_type']=="managers"){
			$_POST['lead_assigne'] = $_POST['lead_assigne_manager'];
		}
		$lead_id = $_POST['lead_id'];
		$lead_update = $this->Update_lead_information($lead_id,$_POST);
	}
	public function actionAJAXBulkAssigneLeads(){
		$data = array(
						'assigne_exist' 	=> '1',
    					'lead_assigne' 		=> $_POST['assigne_id'],
    					'lead_comments' 	=> $_POST['bulk_lead_comments']
					);
		$lead_ids = explode(",", $_POST['lead_ids']);
		$success = 0;
		$fails = 0;
		for ($i=0; $i < count($lead_ids) ; $i++) {
			$data['lead_id'] = $lead_ids[$i];
			$lead_update = $this->Update_lead_information($lead_ids[$i],$data);
			if($lead_update){
				$success++;
			} else {
				$fails++;
			}
		}
		echo json_encode(array(
								"sucess"	=>	$success,
								"total"		=>	count($lead_ids),
								"fails"		=>	$fails
								)
						);
	}
	
	public function Pagination($url,$total_count,$offset,$limit){
		$no_of_pages_to_display = "5";
		if($total_count==0){
			$pagination = "Showing 0-0 of 0 Records";
		} else {
			if (strpos($url,'?') !== false) {
				$url = $url;
			} else {
				$url = $url."?";
			}
			$no_of_pages = intval($total_count/$limit)+((($total_count%$limit)==0)?"0":"1");
			if($offset==0){
				$current_page  = (($offset)/$limit)+1;
			} else {
				$current_page  = round(($offset-1)/$limit)+1;
			}
			if($no_of_pages < $no_of_pages_to_display){
				$start_page = "1";
				$end_page = $no_of_pages;
			} else {
				if(($current_page-2)<=0){
					$start_page = "1";
					$end_page = $no_of_pages_to_display;
				} else {
					if(($current_page-2+$no_of_pages_to_display)<$no_of_pages){
						$start_page = $current_page-2;
						$end_page = $current_page+2;
					} else {
						$start_page = $no_of_pages-4;
						$end_page = $no_of_pages;
					}
				}
			}
			$start_count = $offset+1;
			if(($total_count-$offset)<= $limit){
				$total_limit = $total_count-$offset;
			}  else {
				$total_limit = $offset+$limit;
			}
			//$total_limit = $offset+$limit;
			$pagination = "<span>Showing $start_count-$total_limit of $total_count Records</span>";
			$pagination = $pagination."<ul class='pagination'>";
			if($start_page>1){
				$left_page_class="";
				$left_page_link=$url."&limit=".$limit."&offset=".(($current_page*$limit)-(2*$limit)+1);
				$link_title = "title='Prev Page'";
			} else {
				$left_page_class="class='disabled'";
				$left_page_link="#";
				$link_title = "";
			}
				
			$pagination = $pagination."<li $left_page_class><a href='$left_page_link' $link_title>&laquo;</a></li>";
			for ($i = $start_page; $i <= $end_page; $i++) {
				if($i==$current_page){
					$class_name = "class='active'";
					$next_tab_link = $url."&limit=$limit&offset=".(($i*$limit)-$limit+1);
					$active_page_highlight = " <span class='sr-only'>(current)</span>";
				} else {
					$class_name = "";
					$next_tab_link = $url."&limit=$limit&offset=".(($i*$limit)-$limit+1);
					$active_page_highlight = "";
				}
				$pagination .="<li $class_name><a href='$next_tab_link' title='$i'>$i</a></li>"; 
			}
			if($end_page>=$no_of_pages){
				$right_page_class="class='disabled'";
				$right_page_link="#";
				$link_title = "title='Next Page'";
			} else {
				$right_page_class="";
				$right_page_link=$url."&limit=".$limit."&offset=".(($current_page*$limit)+1);
				$link_title = "#";
			}
			$pagination = $pagination."<li $right_page_class><a href='$right_page_link' $link_title>&#187;</a></li>";
			$pagination = $pagination."</ul>";
		}
		return $pagination;
	}
	public function actionImportCSV()
    {
    	$this->pageTitle = "Bulk Upload";
    	$result_array = array();
		$LeadTracker =  new LeadTracker();
        if(isset($_POST['LeadTracker']))
        {
        	include 'protected/extensions/excel_reader/reader.php';
			$excel = new Spreadsheet_Excel_Reader();
			$excel->read($_FILES['LeadTracker']['tmp_name']['file']);
			if(!empty($excel)){
					$total_data = array();
					$added_records = array();
					$failed_records = array();
					$junk_records = array();
					
				   	$x = 1;
			    	if($x<=$excel->sheets[0]['numRows']) {
			    		$id = 0;
						$current_time = time();
						$dummy_num_check = array();
						$last3_mont_time = time()-(60*60*24*180);
			    		foreach ($excel->sheets[0]['cells'] as $key => $value) {
							if((isset($value['1']) && trim($value['1'])=='Name') || (isset($value['2']) && trim($value['2'])=='Email') || (isset($value['3']) && trim($value['3'])=='Contact Number')){
								//continue;
							} else {
								$value['2'] = isset($value['2'])?$value['2']:"";
								$value['3'] = isset($value['3'])?$value['3']:"";
								if(isset($value['1']) && isset($value['2']) && isset($value['3'])){
									if(($value['2']=="") && ($value['3']=="")){
										$temp_junk_record = array(
														"name"				=>	isset($value['1'])?$value['1']:"",
														"email"				=>	isset($value['2'])?$value['2']:"",
														"contact_number"	=>	isset($value['3'])?$value['3']:"",
														"query"				=>	isset($value['4'])?$value['4']:"",
														"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
														"reason"			=>	"Please Email Or Mobile no atleast on should be present"
													);
										array_push($junk_records,$temp_junk_record);
									} else if(($value['2']!="") && ($value['3']=="")){
							  				$user_exist = Yii::app()->db->createCommand()
													    ->select('count(*) as record_exist_count')
													    ->from('lead_tracker')
													    ->where('email = :email  and created_time>:created_time', array(':created_time'=>$last3_mont_time,':email'=>$value['2']))
													    ->queryRow();
											if($user_exist['record_exist_count']>0){
												$temp_failed_record = array(
																	"name"				=>	$value['1'],
																	"email"				=>	$value['2'],
																	"contact_number"	=>	$value['3'],
																	"query"				=>	isset($value['4'])?$value['4']:"",
																	"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																	"reason"			=>	"Email-Id `$value[2]` is added in last 180 days please use same for further process"
																);
												array_push($failed_records,$temp_failed_record);
											} else {
												$LeadTracker =  new LeadTracker();
												$proper_data = array(
																		"name"				=>	$value['1'],
																		"email"				=>	$value['2'],
																		"contact_number"	=>	$value['3'],
																		"query"				=>	isset($value['4'])?$value['4']:"",
																		"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																		"created_time"		=>	$current_time,
																		"created_by"		=>	Yii::app()->user->id,
																		"updated_by"		=>	Yii::app()->user->id,
																		"updated_time"		=>	$current_time,
																		"current_status"	=>	0,
																		"comments"			=>	((isset($value['5'])&& $value['5']!="")?$value['5']:"Added by ".Yii::app()->user->name)." through Execel Upload",
																		"assigned_to"		=>	0,
																		"assigned_on"		=>	$current_time
																		
																	);
											$LeadTracker->attributes = $proper_data;
											if($LeadTracker->save()){
												$temp_added_record = array(
																	"name"				=>	$value['1'],
																	"email"				=>	$value['2'],
																	"contact_number"	=>	$value['3'],
																	"query"				=>	isset($value['4'])?$value['4']:"",
																	"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload")
																);
												array_push($added_records,$temp_added_record);
											} else {
												$temp_failed_record = array(
																"name"				=>	$value['1'],
																"email"				=>	$value['2'],
																"contact_number"	=>	$value['3'],
																"query"				=>	isset($value['4'])?$value['4']:"",
																"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																"reason"			=>	CHtml::errorSummary($LeadTracker)
															);
												array_push($failed_records,$temp_failed_record);
											}
										}
									} else if((($value['2']=="") && ($value['3']!="")) || (($value['2']!="") && ($value['3']!=""))){
										if(isset($value['3']) && is_numeric($value['3'])){
							  				$user_exist = Yii::app()->db->createCommand()
													    ->select('count(*) as record_exist_count')
													    ->from('lead_tracker')
													    ->where('contact_number = :contact_number  and created_time>:created_time', array(':created_time'=>$last3_mont_time,':contact_number'=>$value['3']))
													    ->queryRow();
											if($user_exist['record_exist_count']>0){
												$temp_failed_record = array(
																	"name"				=>	$value['1'],
																	"email"				=>	$value['2'],
																	"contact_number"	=>	$value['3'],
																	"query"				=>	isset($value['4'])?$value['4']:"",
																	"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																	"reason"			=>	"Phone number `$value[3]` is added in last 180 days please use same for further process"
																);
												array_push($failed_records,$temp_failed_record);
											} else {
												$LeadTracker =  new LeadTracker();
													$proper_data = array(
																			"name"				=>	$value['1'],
																			"email"				=>	$value['2'],
																			"contact_number"	=>	$value['3'],
																			"query"				=>	isset($value['4'])?$value['4']:"",
																			"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																			"created_time"		=>	$current_time,
																			"created_by"		=>	Yii::app()->user->id,
																			"updated_by"		=>	Yii::app()->user->id,
																			"updated_time"		=>	$current_time,
																			"current_status"	=>	0,
																			"comments"			=>	((isset($value['5'])&& $value['5']!="")?$value['5']:"Added by ".Yii::app()->user->name)." through Execel Upload",
																			"assigned_to"		=>	0,
																			"assigned_on"		=>	$current_time
																			
																		);
													$LeadTracker->attributes = $proper_data;
												if($LeadTracker->save()){
													$temp_added_record = array(
																		"name"				=>	$value['1'],
																		"email"				=>	$value['2'],
																		"contact_number"	=>	$value['3'],
																		"query"				=>	isset($value['4'])?$value['4']:"",
																		"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload")
																	);
													array_push($added_records,$temp_added_record);
												} else {
													$temp_failed_record = array(
																	"name"				=>	$value['1'],
																	"email"				=>	$value['2'],
																	"contact_number"	=>	$value['3'],
																	"query"				=>	isset($value['4'])?$value['4']:"",
																	"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																	"reason"			=>	CHtml::errorSummary($LeadTracker)
																);
													array_push($failed_records,$temp_failed_record);
												}
											}
										} else {
											$temp_failed_record = array(
																	"name"				=>	isset($value['1'])?$value['1']:"",
																	"email"				=>	isset($value['2'])?$value['2']:"",
																	"contact_number"	=>	isset($value['3'])?$value['3']:"",
																	"query"				=>	isset($value['4'])?$value['4']:"",
																	"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
																	"reason"			=>	$value['3']." is not a number"
																);
											array_push($failed_records,$temp_failed_record);
											
										}
									}
								} else {
									$temp_junk_record = array(
														"name"				=>	isset($value['1'])?$value['1']:"",
														"email"				=>	isset($value['2'])?$value['2']:"",
														"contact_number"	=>	isset($value['3'])?$value['3']:"",
														"query"				=>	isset($value['4'])?$value['4']:"",
														"source"			=>	((isset($value['6'])&& $value['6']!="")?$value['6']:"ExecelUpload"),
														"reason"			=>	"Please check the data and add it one more time"
													);
									array_push($junk_records,$temp_junk_record);
								}
								
							}
							
						}
				   
				    }
					$result_array = array(
											"added_records"		=>	$added_records,
											"failed_records"	=>	$failed_records,
											"junk_records"		=>	$junk_records
										);
			}
			
		}
 
		$this->render("ImportCSV",array(
									'model'			=>	$LeadTracker,
									"result_array"	=>	$result_array
								)
					);
	}

	 
}		