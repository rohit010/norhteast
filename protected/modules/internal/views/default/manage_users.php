<div class="row" id="lead_mange_folter">
	<form name="lead_search">
		<div class="col-md-3">
			<input type="text" class="form-control" placeholder="Name / Email / Mobile" name="keyword" value="<?php echo (isset($_GET['keyword'])?$_GET['keyword']:""); ?>"/>
		</div>
		<div class="col-md-3 form_increase_width">
			<select class="form-control" name="keyword_filter_type">
				<option value="name" <?php echo (isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']=="name")?"selected='selected'":""; ?> >Name</option>
				<option value="email" <?php echo (isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']=="email")?"selected='selected'":""; ?> >Email</option>
				<option value="mobile" <?php echo (isset($_GET['keyword_filter_type']) && $_GET['keyword_filter_type']=="mobile")?"selected='selected'":""; ?> >Mobile</option>
			</select>
		</div>
		<div class="col-md-2">
			<select name="user_status" class="form-control">
				<option value="-1" <?php echo (isset($_GET['user_status']) && $_GET['user_status']=="-1")?"selected='selected'":""; ?>> All Status </option>
				<option value="0" <?php echo (isset($_GET['user_status']) && $_GET['user_status']=="0")?"selected='selected'":""; ?>> InActive </option>
				<option value="1" <?php echo (isset($_GET['user_status']) && $_GET['user_status']=="1")?"selected='selected'":((!isset($_GET['user_status']))?"selected='selected'":""); ?>> Active </option>
			</select>
		</div>

		<div class="col-md-1">
			<input type="submit" class="btn btn-info" value="Search"/>
		</div>
	</form>
</div>



<div class="table-responsive manage_data">
	<?php if(!empty($sql_query_users_result)){ ?>
 	<table class="table table-bordered table-hover table-striped tablesorter">
		<thead>
			<tr>
				<th class="header">Id <i class="fa fa-sort"></i></th>
				<th class="header">Name <i class="fa fa-sort"></i></th>
				<th class="header">Phone <i class="fa fa-sort"></i></th>
				<th class="header">Email <i class="fa fa-sort"></i></th>
				<th class="header">Location</th>
				<th class="header">Date of Birth</th>
				<th class="header">Created Date</th>
				<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){ ?>
				<th class="header">Status</th>
				<?php } ?>
			</tr>	
		</thead>
		<tbody>
		<?php foreach ($sql_query_users_result as $key => $value) { ?>
			<tr>
				<td><?php echo $value['uid']; ?></td>
				<td>
					<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){ ?>
					<a target="_blank" href="/internal/EditUsersinfo?uid=<?php echo $value['uid']; ?>"><?php echo $value['name']; ?></a>
					<?php } else {
							echo $value['name'];
					} ?>
				</td>
				<td><?php echo $value['contact_number']; ?></td>
				<td><?php echo $value['email']; ?></td>
				<td><?php echo $value['location']; ?></td>
				<td><?php echo date("d-M-Y",$value['date_of_birth']); ?></td>
				<td><?php echo date("d-M-Y",$value['created']); ?></td>
				<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])){ ?>
				<td>
					<select name="user_status" class="form-control user_status" data-uid="<?php echo $value['uid']; ?>">
						<option value="1" <?php echo ($value['status']==1)?"selected='selected'":""; ?>>Active</option>
						<option value="0" <?php echo ($value['status']==0)?"selected='selected'":""; ?>>InActive</option>
					</select>
				</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div id="pagination">
		<?php echo $pagination; ?>
	</div>
	<?php } ?>
</div>