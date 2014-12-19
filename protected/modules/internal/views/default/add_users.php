<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/common.css'); ?>
	
<?php 
	$main_info_edit_option = TRUE;
	$Users_name = "";
	$Users_email = "";
	$Users_contact_number = "";
	$Users_password = "";
	$Users_repeate_password = "";
	$Users_location = "";
	$Users_dob = time();
	$Users_message = "";
	if(isset($Users_info) && !isset($_POST['Users'])){
		if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){
			$main_info_edit_option = FALSE;
		} 
		$Users_name = $Users_info['name'];
		$Users_email = $Users_info['email'];
		$Users_contact_number = $Users_info['contact_number'];
		$Users_info['password'] = base64_decode($Users_info['password']);
		$Users_password = $Users_info['password'];
		$Users_repeate_password = $Users_info['password'];
		$Users_location = $Users_info['location'];
		$Users_dob = $Users_info['date_of_birth'];
		$Users_message = $Users_info['message'];
	} else if(isset($_POST['Users']) && !Yii::app()->user->hasFlash('msg_success')){
		$main_info_edit_option = TRUE;
		if(Yii::app()->controller->action->id=="EditUsersinfo"){
			if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){
				$main_info_edit_option = FALSE;
			} else {
				$main_info_edit_option = TRUE;
			}
			
		} else if(Yii::app()->controller->action->id=="AddUsers"){
			$main_info_edit_option = FALSE;
		}
		$Users_name = $_POST['Users']['name'];
		$Users_email = $_POST['Users']['email'];
		$Users_contact_number = $_POST['Users']['contact_number'];
		$Users_password = $_POST['Users']['password'];
		$Users_repeate_password = $_POST['Users']['repeat_password'];
		$Users_location = $_POST['Users']['location'];
		$Users_dob = $_POST['Users']['date_of_birth'];
		$Users_message = $_POST['Users']['message'];
	} else {
		$main_info_edit_option = FALSE;
	}
	$Users_dob = date('d-m-Y',$Users_dob);
?>	
<?php $msg_success = Yii::app()->user->getFlash("msg_success"); 
if($msg_success){ ?>
	<div class="alert alert-success fade in">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    	<?php echo $msg_success; ?>
  	</div>
<?php } ?>
<?php $msg_error = Yii::app()->user->getFlash("msg_error"); 
if($msg_error){ ?>
	<div class="alert alert-danger fade in">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    	<?php echo $msg_error; ?>
  	</div>
<?php } ?>
	<div class="form form-horizontal" id="leadCapture" <?php echo ($msg_success)?"style='display:none;'":""; ?>>
	<?php $form=$this->beginWidget('CActiveForm',array(
													    'id'=>'Uses',
													    'htmlOptions'=>array(
														    					'class'=>'form-horizontal well test-form top-messages has-validation-callback',
																			)
														)
									); ?>
		<div class="row" >
			<div class="col-lg-6">
			<?php if(Yii::app()->controller->action->id=="AddUsers"){ ?>
				<h3>Add User</h3>
				<?php echo CHtml::errorSummary($Users); ?>
			<?php } else { ?>
				<h3>Edit User</h3>
				<?php if(!empty($error_list)){ ?>
				<div class="errorSummary">
					<p>Please fix the following input errors:</p>
					<ul>
						<?php foreach ($error_list as $key => $value) { 
							foreach ($value as $key => $sub_value) { ?>
								<li><?php echo $sub_value; ?></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
				<?php echo CHtml::errorSummary($Users); ?>
			<?php } ?>
			</div>
			<?php if(Yii::app()->controller->action->id=="EditUsersinfo"){ ?>
			<div class="col-lg-6" id="manage_hirarchy_msg">
				
			</div>
			<?php } ?>
		</div>
		<div class="row" >
			<div class="col-lg-6">
			    <div class="row">
	    			<div class="form-group">
					    <?php echo CHtml::activeLabel($Users,'name',array("class"=>"col-sm-2 control-label")); ?>
					    <div class="col-sm-10">
					        <?php echo CHtml::activeTextField($Users,'name',array("class"=>"form-control",'value'=>$Users_name,"placeholder"=>"Name",'readonly'=>$main_info_edit_option)); ?>
						</div>
					</div>
			    </div>
			    <div class="row">
			    	<div class="form-group">
						<?php echo CHtml::activeLabel($Users,'email',array("class"=>"col-sm-2 control-label")); ?>
					    <div class="col-sm-10">
					        <?php echo CHtml::activeTextField($Users,'email',array("class"=>"form-control",'value'=>$Users_email,"placeholder"=>"Email",'readonly'=>$main_info_edit_option)); ?>
						</div>
					</div>
			    </div>
			    <div class="row">
			    	<div class="form-group">
						<?php echo CHtml::activeLabel($Users,'Contact Number',array("class"=>"col-sm-2 control-label")); ?>
					    <div class="col-sm-10">
					        <?php echo CHtml::activeTextField($Users,'contact_number',array("class"=>"form-control",'value'=>$Users_contact_number,"placeholder"=>"Contact Number",'readonly'=>$main_info_edit_option)); ?>
						</div>
					</div>
			    </div>
			    <div class="row">
			    	<div class="form-group">
						<?php echo CHtml::activeLabel($Users,'Password',array("class"=>"col-sm-2 control-label")); ?>
					    <div class="col-sm-10">
					        <?php echo $form->passwordField($Users,'password',array("class"=>"form-control",'maxlength'=>40,'value'=>$Users_password,"placeholder"=>"Password")); ?>
					        <label><input type="checkbox" id="show_password"/> Show Password </label>
						</div>
					</div>
			    </div>
			    <div class="row">
			    	 <div class="form-group">
			    	 	<?php echo CHtml::activeLabel($Users,'Repeat-Password',array("class"=>"col-sm-2 control-label")); ?>
				    	<div class="col-sm-10">
				    		<?php echo $form->passwordField($Users,'repeat_password',array("class"=>"form-control",'value'=>$Users_repeate_password,'maxlength'=>40,"placeholder"=>"Repeate Password")); ?>
				    	</div>
				  	 </div>
			    </div>
			    <div class="row">
			    	<div class="form-group">
			    	 	<?php echo CHtml::activeLabel($Users,'Location',array("class"=>"col-sm-2 control-label")); ?>
				    	<div class="col-sm-10">
				    		<?php echo CHtml::activeTextField($Users,'location',array("class"=>"form-control",'value'=>$Users_location,"placeholder"=>"Location")); ?>
				    	</div>
				  	 </div>
			    </div>
			    <div class="row">
			    	<div class="form-group">
			    	 	<?php echo CHtml::activeLabel($Users,'Date of Birth',array("class"=>"col-sm-2 control-label")); ?>
				    	<div class="col-sm-10">
				    		<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); 
			  					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								                                'name'=>'Users[date_of_birth]',
								                    			'value'=>$Users_dob,
								                                'options'=>array(
								                                'showAnim'=>'slide',
								                                'dateFormat'=>'dd-mm-yy',
								                                'changeMonth' => true,
						                                        'changeYear' => true,
			                                                    ),
			                                                    'htmlOptions'=>array(
									                                'class' => 'form-control',
									                                'placeholder'=>'Date of Birth',
			                                                     ),
			                                    )
			                );
						?>
				    	</div>
				  	 </div>
			    </div>
			    <div class="row">
			    	<div class="form-group">
			    	 	<?php echo CHtml::activeLabel($Users,'Message',array("class"=>"col-sm-2 control-label")); ?>
				    	<div class="col-sm-10">
				    		<?php echo CHtml::activeTextField($Users,'message',array("class"=>"form-control",'value'=>$Users_message,"placeholder"=>"Message" ,'readonly'=>$main_info_edit_option)); ?>
				    	</div>
				  	 </div>
			    </div>
			    <div class="row">
			    	 <div class="form-group">
			    	 	<label class="col-sm-2 control-label" > </label>
				    	<div class="col-sm-10 text-center">
				    		<input  type="submit" name="add_users_button" class="btn btn-info"/>
				    	</div>
				  	 </div>
			    </div>
			</div><!-- form -->
			<div class="col-lg-6">
				<?php if(Yii::app()->controller->action->id=="EditUsersinfo"){ ?>
				<?php 
				if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser']) || (isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager'])){ ?>
				<table class="table table-bordered">
					<tr>
						<th>ID</th>
						<th>Users List</th>
						<th>Action</th>
					</tr>
					<tbody id="myusersList">
					<?php foreach ($User_hierarchy_list as $key => $value) { ?>
						<tr>
							<td><?php echo $value['mapped_admin_user_id']; ?></td>
							<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser']) || (isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager'])){ ?>
							<td><a href="/internal/EditUsersinfo?uid=<?php echo $value['mapped_admin_user_id']; ?>" target="_blank"><?php $this->getUserInfo($usersList,$value['mapped_admin_user_id'],count($usersList)); ?></a></td>
							<?php } else { ?>
								<td><?php $this->getUserInfo($usersList,$value['mapped_admin_user_id'],count($usersList)); ?></td>
							<?php } ?>
							<td>
								<?php if($value['mapped_admin_user_id']!=$uid) { ?>
								<a href="#" data-parent-id="<?php echo $value['admin_user_id']; ?>" data-user-id="<?php echo $value['mapped_admin_user_id']; ?>" class="remove_users_hierarchy">Remove</a>
								<?php } else { echo "Owner"; } ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				
				<?php 
				if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){ ?>
				<h4>Add Users</h4>
				<div class="row">
					<?php 
					$unassignedUsersList = array($uid);
					foreach ($User_hierarchy_list as $key => $value) {
						array_push($unassignedUsersList,$value['mapped_admin_user_id']);
					}
					?>
					<div class="col-lg-6">
						<select class="form-control" id="unassignedusersList">
							<option value="">Select Users</option>
							<?php
							foreach ($usersList as $key => $value) {
								if(!in_array($value['uid'], $unassignedUsersList)){ ?>
									<option value="<?php echo $value['uid']; ?>"><?php echo $value['name']; ?></option>
								<?php }
								} 
							?>
						</select>
					</div>
					<div class="col-lg-6">
						<input type="button" class="btn btn-info" id="add_user_hirerchy_button" value="Add Users" data-parent-id="<?php echo $uid; ?>"/>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	<?php $this->endWidget(); ?>
</div>
