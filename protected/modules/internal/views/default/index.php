
<div id="page-wrapper">

	<!-- /.row -->
<?php //CVarDumper::dump($sql_counts_result,10,true); 
 
$total_count = 0;
$pending_count = 0;
$purchased_count = 0;
$rejected_count = 0;
$not_responding_count = 0;
$visited_count = 0;
if(!empty($sql_counts_result)){
	foreach ($sql_counts_result as $key => $value) {
		$total_count = $total_count+$value['count(id)'];
		if($value['current_status']=='0'){
			$pending_count = $pending_count+$value['count(id)'];
		}
		if($value['current_status']=='1'){
			$purchased_count = $purchased_count+$value['count(id)'];
		}
		if($value['current_status']=='3'){
			$rejected_count = $rejected_count+$value['count(id)'];
		}
		if($value['current_status']=='4'){
			$not_responding_count = $not_responding_count+$value['count(id)'];
		}
		if($value['current_status']=='5'){
			$visited_count = $visited_count+$value['count(id)'];
		}										
	}
} 
$current_time = time();
$sevenDay_time = $current_time-(60*60*24*10);

$start_time = urlencode(date("d/m/Y",$sevenDay_time));
$end_time = urlencode(date("d/m/Y",$current_time)); 

?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="fa fa-bar-chart-o"></i> Lead Statistics: 
						<?php echo date("F d Y",$sevenDay_time); ?>  -  <?php echo date("F d Y",$current_time); ?>
					</h3>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">
						<div class="alert alert-success alert-dismissable" style="margin-bottom: 0px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							We are one of the leading property developers in Bangalore with a focus on Residential Plots, 
							Apartments and Villas. We strive to provide a comfortable and happy living for our customers in all our projects. 
							Such is their appreciation for our projects, that our customers themselves do the selling for us.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="announcement-heading">
								<?php 
								echo $total_count; 
								?>
							</p>
							<p class="announcement-text">New Leads!</p>
						</div>
					</div>
				</div>
				<a href="/internal/manageLeads?from=<?php echo $start_time; ?>&to=<?php echo $end_time; ?>&date_filter=created_date">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-12">View Leads
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="announcement-heading"><?php echo $pending_count; ?></p>
							<p class="announcement-text">Pending Leads</p>
						</div>
					</div>
				</div>
				<a href="/internal/manageLeads?from=<?php echo $start_time; ?>&to=<?php echo $end_time; ?>&date_filter=created_date&status_filter=0">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-12">
								View Leads
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="announcement-heading"><?php echo $rejected_count; ?></p>
							<p class="announcement-text">Rejected Leads</p>
						</div>
					</div>
				</div>
				<a href="/internal/manageLeads?from=<?php echo $start_time; ?>&to=<?php echo $end_time; ?>&date_filter=created_date&status_filter=3">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-12">View Leads
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="announcement-heading"><?php echo $purchased_count; ?></p>
							<p class="announcement-text" style="margin: 0px -10px;">Purchased Leads</p>
						</div>
					</div>
				</div>
				<a href="/internal/manageLeads?from=<?php echo $start_time; ?>&to=<?php echo $end_time; ?>&date_filter=created_date&status_filter=1">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-12">View Leads
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="announcement-heading"><?php echo $not_responding_count; ?></p>
							<p class="announcement-text" style="margin: 0px -10px;">Not Responding</p>
						</div>
					</div>
				</div>
				<a href="/internal/manageLeads?from=<?php echo $start_time; ?>&to=<?php echo $end_time; ?>&date_filter=created_date&status_filter=4">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-12">View Leads
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="announcement-heading"><?php echo $visited_count; ?></p>
							<p class="announcement-text">Visited Leads</p>
						</div>
					</div>
				</div>
				<a href="/internal/manageLeads?from=<?php echo $start_time; ?>&to=<?php echo $end_time; ?>&date_filter=created_date&status_filter=5">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-12">View Leads
								<i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		
	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="fa fa-clock-o"></i> Recent Activity
					</h3>
				</div>
				<div class="panel-body">
					<div class="list-group">
						<?php foreach ($sql_rescent_activity_result as $key => $value) { ?>
							<a href="#" class="list-group-item LeadDetails" data-toggle="modal" style="cursor: pointer" data="#LeadDetails" data-href="/internal/LeadDetails?id=<?php echo $value['id']; ?>" data-target="#LeadDetails"> 
								<span class="badge">
									<?php 
										$now = time();
										$time_diff = $now-$value['updated_time'];
										if($time_diff<60){
											echo "Just Now";
										} else if($time_diff<3600 && $time_diff>60){
											echo intval($time_diff/(60))." Min ago";
										} else if($time_diff<86400 && $time_diff>3600){
											echo intval($time_diff/(60*60))." hour ago";
										} else if($time_diff<604800 && $time_diff>86400){
											echo intval($time_diff/(24*60*60))." days ago";
										} else if($time_diff<2592000 && $time_diff>604800){
											echo intval($time_diff/(24*60*60*7))." weak ago";
										} else if($time_diff<31536000 && $time_diff>2592000){
											echo intval($time_diff/(24*60*60*30))." month ago";
										} else if($time_diff>31536000){
											echo intval($time_diff/(24*60*60*30))." year ago";
										}
									  //echo date("d-M-Y H:i:s",$value['updated_time']); ?></span>

								<?php if($value['current_status'] == 0){ ?>
									<i class="fa fa-shopping-cart" title="Pending or New Leads"></i>
								<?php } else if($value['current_status'] == 1){ ?>
									<i class="fa fa-money" title="Purchased"></i>
								<?php } else if($value['current_status'] == 2){ ?>
									<i class="fa fa-calendar" title="On Hold"></i> 
								<?php } else if($value['current_status'] == 3){ ?>
									<i class="fa fa-trash-o" title="Rejected"></i> 
								<?php } else if($value['current_status'] == 4){ ?>
									<i class="fa fa-warning" title="Not Responding"></i> 
								<?php } else if($value['current_status'] == 5){ ?>
									<i class="fa fa-home" title="Visited"></i> 
								<?php } else if($value['current_status'] == 6){ ?>
									<i class="fa fa-search" title="Others"></i> 
								<?php } ?>
								
								<?php echo ($value['comments']=="")?"&nbsp;":$value['comments']; ?>
							</a> 
						<?php } ?>
					</div>
					<div class="text-right">
						<a href="/internal/manageLeads">View All Activity <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="fa fa-money"></i> Recent Leads
					</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table
							class="table table-bordered table-hover table-striped tablesorter">
							<thead>
								<tr>
									<th>Name <i class="fa fa-sort"></i>
									</th>
									<th>Email <i class="fa fa-sort"></i>
									</th>
									<th>Mobile <i class="fa fa-sort"></i>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($sql_rescent_leads_result as $key => $value) { ?>
									<tr>
										<td>
											<a class="LeadDetails" data-toggle="modal" style="cursor: pointer" data="#LeadDetails" data-href="/internal/LeadDetails?id=<?php echo $value['id']; ?>" data-target="#LeadDetails">
												<?php echo $value['name']; ?>
											</a>
										</td>
										<td><?php echo $value['email']; ?></td>
										<td><?php echo $value['contact_number']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="text-right">
						<a href="/internal/manageLeads">View All Transactions <i
							class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->

</div>
<!-- /#page-wrapper -->

<div class="modal fade"  id="LeadDetails"   tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="progress progress-striped active">
  <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
    <span class="sr-only">45% Complete</span>
  </div>
</div>
</div>