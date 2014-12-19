<h3>Our Team</h3>
<div class="table-responsive manage_data">
<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin'])){ ?>
	<div class="pull-right">
		<?php if(!isset($_GET['compleate_list'])){ ?>
			<a href="/internal/OurTeam?compleate_list=full">Compleate List</a>
		<?php } ?>
			<input type="button" value="Print" onclick="window.print();" />
	</div>
<?php } ?>
	<table class="table table-bordered table-hover table-striped tablesorter">
		<?php if(!isset($_GET['compleate_list'])){  ?>
		<form>
		<tr>
			<td><input type="text" value="<?php echo (isset($_GET['uid']))?$_GET['uid']:""; ?>" name="uid" class="form-control"/></td>
			<td><input type="text" value="<?php echo (isset($_GET['name']))?$_GET['name']:""; ?>" name="name" class="form-control"/></td>
			<td><input type="text" value="<?php echo (isset($_GET['phone']))?$_GET['phone']:""; ?>" name="phone" class="form-control"/></td>
			<td><input type="text" value="<?php echo (isset($_GET['email']))?$_GET['email']:""; ?>" name="email" class="form-control"/></td>
			<td><input type="text" value="<?php echo (isset($_GET['location']))?$_GET['location']:""; ?>" name="location" class="form-control"/></td>
			<td><input type="submit" value="Search" name="btn" class="btn btn-info"/></td>
		</tr>
		</form>	
		<?php } ?>
		<thead>
			<tr>
				<?php if(!isset($_GET['compleate_list'])){  ?>
				<th class="header">Id <i class="fa fa-sort"></i></th>
				<?php } ?>
				<th class="header">Name <i class="fa fa-sort"></i></th>
				<th class="header">Phone <i class="fa fa-sort"></i></th>
				<th class="header">Email <i class="fa fa-sort"></i></th>
				<th class="header">Location</th>
				<th class="header">Date of Birth</th>
			</tr>	
		</thead>
		<tbody>
			<?php foreach ($user_List as $key => $value) { ?>
			<tr>
				<?php if(!isset($_GET['compleate_list'])){  ?>
				<td><?php echo $value['uid']; ?></td>
				<?php } ?>
				<td><?php echo $value['name']; ?></td>
				<td><?php echo $value['contact_number']; ?></td>
				<td><?php echo $value['email']; ?></td>
				<td><?php echo $value['location']; ?></td>
				<td><?php echo date('d-M-Y',$value['date_of_birth']); ?></td>
			</tr>
				
			<?php } ?>
		</tbody>
	</table>
	<?php if(!isset($_GET['compleate_list'])){  ?>
		<div id="pagination">
			<?php echo $pagination; ?>
		</div>
	<?php } ?>
</div>