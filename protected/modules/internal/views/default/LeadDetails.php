<div class="modal-dialog"  style="width: 80%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Lead Information</h4>
      </div>
     <div class="modal-body" style="overflow: auto;">
	<?php if(!empty($sql_query_current_lead_result)) { ?>
		<table class="table table-bordered">
			<tr>
				<th>Name</th>
				<th>Number</th>
				<th>Email</th>
				<th>Query</th>
				<th>Assigned To</th>
				<th>Current Status</th>
				<th>Last Updated</th>
			</tr>
			<tr>
				<td><?php echo $sql_query_current_lead_result['name']; ?></td>
				<td><?php echo $sql_query_current_lead_result['contact_number']; ?></td>
				<td><?php echo $sql_query_current_lead_result['email']; ?></td>
				<td><?php echo $sql_query_current_lead_result['query']; ?></td><br />
				<td><?php echo $this->getUserInfo($usersList,$sql_query_current_lead_result['assigned_to'],count($usersList)); ?></td>
				<td><?php NEStaticData::getLeadStatus(TRUE, "text",null,$sql_query_current_lead_result['current_status']); ?></td>
				<td><?php echo date("d-M-Y",$sql_query_current_lead_result['updated_time']); ?></td>
			</tr>
		</table>
	<?php } ?>
	<h4>Lead History</h4>
	<?php if(!empty($sql_query_current_lead_history_result)) { ?>
		<table class="table table-bordered">
			<tr>
				<th>Updated Date</th>
				<th>Updated By</th>
				<th>Comments</th>
				<th>status</th>
				<th>Assigned To</th>
			</tr>
			<?php foreach ($sql_query_current_lead_history_result as $key => $value) { ?>
			<tr>
				<td><?php echo date("d-M-Y",$value['current_time']); ?></td>
				<td><?php echo $this->getUserInfo($usersList,$value['updated_by'],count($usersList)); ?></td>
				<td><?php echo $value['comments']; ?></td>
				<td><?php NEStaticData::getLeadStatus(TRUE, "text",null,$value['status']); ?></td>
				<td><?php echo $this->getUserInfo($usersList,$value['assigned'],count($usersList)); ?></td>
			<?php } ?>
		</table>
	<?php } ?>
     </div>
 </div><!-- /.modal-content -->
</div>
