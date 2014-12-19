<div class="row" id="lead_mange_folter">
	<form name="lead_search">
		<div class="row">
			<div class="col-md-3 text-center">
				<label>Name / Email /Mobile
					<input type="text" class="form-control" placeholder="Name / Email /Mobile" name="keyword" value="<?php echo (isset($_GET['keyword'])?$_GET['keyword']:""); ?>"/>
				</label>
			</div>
			<div class="col-md-2 text-center">
				<label>Filter Type
					<select class="form-control" name="keyword_filter_type">
						<option value="">Filter Type</option>
						<option value="name" <?php echo (isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']=="name")?"selected='selected'":""; ?> >Name</option>
						<option value="email" <?php echo (isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']=="email")?"selected='selected'":""; ?> >Email</option>
						<option value="mobile" <?php echo (isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']=="mobile")?"selected='selected'":""; ?> >Mobile</option>
					</select>
				</label>
			</div>
			<div class="col-md-2 text-center">
				<label>From Date
			    	<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); 
						  		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
											                                'name'=>'from',
											                    			'value'=>isset($_GET['from'])?$_GET['from']:"",
											                                'options'=>array(
											                                'showAnim'=>'slide',
											                                'dateFormat'=>'dd/mm/yy',
											                                'changeMonth' => true,
									                                        'changeYear' => true,
						                                                    ),
						                                                    'htmlOptions'=>array(
												                                'class' => 'form-control',
												                                'placeholder'=>'From',
						                                                     ),
						                                    )
						                );
					?>
				</label>
	    	</div>
	    	<div class="col-md-2 text-center">
	    		<label>To Date
			    	<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); 
								$this->widget('zii.widgets.jui.CJuiDatePicker', array(
											                                'name'=>'to',
											                    			'value'=>isset($_GET['to'])?$_GET['to']:"",
											                                'options'=>array(
											                                'showAnim'=>'slide',
											                                'dateFormat'=>'dd/mm/yy',
											                                'changeMonth' => true,
									                                        'changeYear' => true,
						                                                    ),
						                                                    'htmlOptions'=>array(
												                                'class' => 'form-control',
												                                'placeholder'=>'To',
						                                                     ),
						                                    )
						                );
					?>
				</label>
	    	</div>
		   	<div class="col-md-2 text-center">
		   		<label> Date Filter type
					<select class="form-control" name="date_filter">
						<option value="">--Date Filter--</option>
						<option value="created_date" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter']=="created_date")?"selected='selected'":""; ?>>Created Date</option>
						<option value="assign_date" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter']=="assign_date")?"selected='selected'":""; ?>>Assign Date</option>
						<option value="updated_date" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter']=="updated_date")?"selected='selected'":""; ?>>Updated Date</option>
					</select>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 text-center">
				<label>Source
					<select class="form-control" name="source">
						<option value="">--Select Source--</option>
						<?php foreach ($source_list as $key => $value) { ?>
						<option value="<?php echo $value['source']; ?>" <?php echo (isset($_GET['source']) && $_GET['source']==$value['source'])?"selected='selected'":""; ?> ><?php echo $value['source']; ?></option>
						<?php } ?>
					</select>
				</label>
			</div>
			<div class="col-md-2 text-center">
				<label> Status
				<?php $NEStaticData = new NEStaticData(); ?>
					<?php $status_filter = "-1"; 
					if(isset($_GET['status_filter']) && $_GET['status_filter']!=""){
						$status_filter = $_GET['status_filter'];
					} ?>
					<select class="form-control" name="status_filter">
						<option value="">--Select Status--</option>
						<?php 
							$NEStaticData->getLeadStatus(TRUE, 'select',null,$status_filter); 
						?>
					</select>
				</label>
			</div>
			<div class="col-md-3 text-center">
			<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['Manager']) && Yii::app()->user->user_access['Manager'])){ ?>
				<label>Lead Owner
					<select class="form-control" name="select_lead_owner">
			    		<option value="">--Select Lead Owners--</option>
			    		<option value="-1" <?php echo (isset($_GET['select_lead_owner']) && $_GET['select_lead_owner']=="-1")?"selected='selected'":""; ?>>Not Assigned</option>
			    		<?php foreach ($usersList as $key => $value) { ?>
							<option value=<?php echo $value['uid']; ?> <?php echo (isset($_GET['select_lead_owner']) && $_GET['select_lead_owner']==$value['uid'])?"selected='selected'":""; ?>><?php echo $value['name']; ?></option>
						<?php } ?>
			    	</select>
		    	</label>
			<?php } ?>
		    </div>
		    <div class="col-md-3 text-center">
		    	</div>
			<div class="col-md-1 text-center">
				<label> &nbsp;
				<input type="submit" class="btn btn-info" value="Search"/>
				</label>
			</div>
			
		</div>


	</form>
</div>
<p class="pull-right"> Total Records : <?= $totalCount; ?></p>
<div class="table-responsive manage_data" id="manage_leads_data">
	<?php  $msg_display = Yii::app()->user->getFlash("msg_success"); 
	if($msg_display){ ?>
		<div class="alert alert-success fade in">
	    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	    	<?php echo $msg_display; ?>
	  	</div>
	<?php } ?>
	<?php if(!empty($sql_query_lead_capure_result)){ ?>
 	<table class="table table-bordered table-hover table-striped tablesorter">
		<thead>
			<tr>
				<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess']) || (isset(Yii::app()->user->user_access['AdminManageLeads']) && Yii::app()->user->user_access['AdminManageLeads'])){ ?>
					<td class="header"><input type="checkbox" id="select_all"/></td>
				<?php } ?>
				<th class="header">Name <i class="fa fa-sort"></i></th>
				<th class="header">Phone <i class="fa fa-sort"></i></th>
				<th class="header">Email <i class="fa fa-sort"></i></th>
				<th class="header">Created By</th>
				<th class="header">Created Date</th>
				<th class="header">Updated By</th>
				<th class="header">Updated Date</th>
				<th class="header">Source</th>
				<th class="header">Current Status</th>
				<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess'])){ ?>
					<th class="header">Assigned To</th>
				<?php } ?>
			</tr>	
		</thead>
		<tbody>
		<?php foreach ($sql_query_lead_capure_result as $key => $value) { ?>
			<tr>
				<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess']) || (isset(Yii::app()->user->user_access['AdminManageLeads']) && Yii::app()->user->user_access['AdminManageLeads'])){ ?>
					<td><input type="checkbox" name="select_lead" class="select_lead" value="<?php echo  $value['id']; ?>"/>
						<?php if(isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']){ ?>
							<a href="UpdateLead?id=<?=  $value['id']; ?>">Edit</a>
						<?php } ?>
					</td>
				<?php } ?>	
				<td><a class="LeadDetails" data-toggle="modal" style="cursor: pointer" data="#LeadDetails" data-href="/internal/LeadDetails?id=<?php echo $value['id']; ?>" data-target="#LeadDetails"><?php echo $value['name']; ?></a></td>
				<td><?php echo $value['contact_number']; ?></td>
				<td><?php echo $value['email']; ?></td>
				<td>
					<?php $this->getUserInfo($usersList,$value['created_by'],count($usersList)); ?>
				</td>
				<td>
					<?php echo date('d-M-Y', ($value['created_time'])); ?>
				</td>
				<td>
					<?php $this->getUserInfo($usersList,$value['updated_by'],count($usersList)); ?>
				</td>
				<td>
					<?php echo date('d-M-Y', ($value['updated_time'])); ?>
				</td>
				<td>
					<?php echo $value['source']; ?>
				</td>
				<td>
					<select class="lead_status form-control" name="lead_status" data-id="<?php echo $value['id']; ?>"  data-name="<?php echo $value['name']; ?>" data-assigne="<?php echo $value['assigned_to']; ?>" data-number="<?php echo $value['contact_number']; ?>" data-email="<?php echo $value['email']; ?>" data-query="<?php echo $value['query']; ?>" data-status="<?php echo $value['current_status']; ?>">
						<option value="">--Select Status--</option>
						<?php 
							$NEStaticData->getLeadStatus(TRUE, 'select',null,$value['current_status']); 
						?>
					</select>
				</td>
				<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess'])){ ?>
				<td>
					<?php if($value['assigned_to']==0){
	 							echo "Not Assigned";
							} else {
								$this->getUserInfo($usersList,$value['assigned_to'],count($usersList));
							}
					?>
					<br/>
					<a href="#assign_leads" class="assign_leads" data-toggle="modal" data-target="#assign_leads">
 						<?php if($value['assigned_to']==0){
	 							echo "Assigne Now";
							} else {
								echo "Change Assignee";
							}
						?>
					</a>
				</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php if(!empty($sql_query_lead_capure_result)){ ?>
		<a href="/internal/DownloadData?data=<?php echo base64_encode($sql_query_lead_capure); ?>" class="btn btn-default">Download above data</a>
		&nbsp;&nbsp; &nbsp;
		<a href="/internal/DownloadData?data=<?php echo base64_encode($sql_query_lead_capure_full_list); ?>" class="btn btn-default">Download All</a>
	<?php } ?>
	<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess']) || (isset(Yii::app()->user->user_access['AdminManageLeads']) && Yii::app()->user->user_access['AdminManageLeads'])){ ?>
		<a href="#bulk_assign_leads" data-toggle="modal" data-target="#bulk_assign_leads" class="btn btn-warning bulk_assign_leads">Assigne Leads</a>
	<?php } ?>
	<div id="pagination">
		<?php echo $pagination; ?>
	</div>
	<?php } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="assign_leads" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  	<form action="#" name="lead_update_form" id="lead_update_form">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Lead Information</h4>
	      </div>
	      <div class="modal-body">
	      <input type="hidden" id="assigne_exist" name="assigne_exist" value="0" />
	      <input type="hidden" id="lead_id" name="lead_id" value="0" /> 
	      <table class="table table-bordered">
	          <tr>
	            <th>Name</th>
				<td id="lead_name"></td>            
	          </tr>
	          <tr>
	          	<th>Mobile</th>
	          	<td id="lead_mobile_number"></td>
	          </tr>
	          <tr>
	            <th>Email</th>
	            <td id="lead_email"></td>
	          </tr>
	          <tr>
	          	<th>Query</th>
	          	<td id="data_query"></td>
	          </tr>
	          <tr>
	          	<th>Current Status</th>
				<td>
					<select class="form-control" name="lead_status" id="lead_status_info">
						<option value="">--Select Status--</option>
						<?php 
							$NEStaticData->getLeadStatus(TRUE, 'select',null); 
						?>
					</select>
				</td>
	          </tr>
	          <?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess'])){ ?>
	          <tr>
	            <th>Assigned To</th>
	            <td>
	            	<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageLeads']) && Yii::app()->user->user_access['AdminManageLeads'])){ ?>
	            	<label><input type="radio" name="users_type" value="all" class="change_users_type" checked="checked"/>All</label>
					<label><input type="radio" name="users_type" value="managers" class="change_users_type"/>Managers</label>
	            	<select id="lead_assigne" name="lead_assigne_all" class="form-control all_users">
	            		<option value="">--Select Users--</option>
	            		<?php foreach ($usersActiveList as $key => $value) {
							echo "<option value=".$value['uid'].">".$value['name']."</option>";
						} ?>
	            	</select>
	            	<select id="lead_assigne_managers" name="lead_assigne_manager" class="form-control manager_users">
	            		<option value="">--Select Users--</option>
	            		<?php foreach ($manager_list as $key => $value) {
							echo "<option value=".$value['uid'].">".$value['name']."</option>";
						} ?>
	            	</select>
	            	<?php }  else { ?>
            		<input type="hidden" name="users_type" value="all" class="change_users_type"/>
            		<select id="lead_assigne" name="lead_assigne_all" class="form-control all_users">
	            		<option value="">--Select Users--</option>
	            		<?php foreach ($usersActiveList as $key => $value) {
							echo "<option value=".$value['uid'].">".$value['name']."</option>";
						} ?>
	            	</select>
	            	<?php } ?>
	            </td>
	          </tr>
	          <?php } ?>
	          <tr>
	          	<th>Comments</th>
	          	<td>
	          		<textarea class="form-control" name="lead_comments"></textarea>
	          	</td>
	          </tr>
	      </table>
	      </div>
	      <div class="modal-footer">
	      	<div id="progressbar">
		      	<div class="progress progress-striped active">
				  <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				    <span class="sr-only">100% Complete</span>
				  </div>
				</div>
	      	</div>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" data-loading-text="Updating" class="btn btn-primary" id="lead_update_button">Save changes</button>
	        
	      </div>
	    </div>
    </form>
  </div>
</div>
<div class="modal fade" id="bulk_assign_leads" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
			        <?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['LeadAssigningAccess']) && Yii::app()->user->user_access['LeadAssigningAccess'])){ ?>
			        <tr>
			            <th>Assigned To</th>
			            <td>
			            	<label><input type="radio" name="bulk_users_type" value="all" class="change_bulk_users_type" checked="checked"/>All</label>
							<label><input type="radio" name="bulk_users_type" value="managers" class="change_bulk_users_type"/>Managers</label>
			            	<select id="bulk_lead_assigne_id" name="bulk_lead_assigne_id" class="form-control bulk_all_users">
			            		<option value="">--Select Users--</option>
			            		<?php foreach ($usersActiveList as $key => $value) {
									echo "<option value=".$value['uid'].">".$value['name']."</option>";
								} ?>
			            	</select>
			            	<select id="bulk_lead_assigne_managers" name="bulk_lead_assigne_managers" class="form-control bulk_manager_users">
			            		<option value="">--Select Users--</option>
			            		<?php foreach ($manager_list as $key => $value) {
									echo "<option value=".$value['uid'].">".$value['name']."</option>";
								} ?>
			            	</select>
			            </td>
			        </tr>
			        <tr>
			        	<th>
			        		Comments
			        	</th>
			        	<td>
			        		<textarea class="form-control" name="bulk_lead_comments" id="bulk_lead_comments"></textarea>
			        	</td>
			        </tr>
			        <?php } ?>
			        <tr>
			        	<td id="selected_lead_list" colspan="2"></td>
			        </tr>
				</table>
				<input type="hidden" id="selected_lead_ids"  value=""/>
			</div>
			<div class="modal-footer">
				<div id="bulk_lead_progressbar" style="display: none;">
			      	<div class="progress progress-striped active">
					  <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
					    <span class="sr-only">100% Complete</span>
					  </div>
					</div>
		      	</div>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Close
				</button>
				<button type="button" class="btn btn-primary" data-loading-text="Assiging Please Wait..." id="bulk_lead_assigne">
					Save changes
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade"  id="LeadDetails"   tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="progress progress-striped active">
  <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    <span class="sr-only">100% Complete</span>
  </div>
</div>
</div>
