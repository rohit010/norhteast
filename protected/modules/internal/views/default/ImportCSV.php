<div class="form">
 
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'service-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
    'htmlOptions'=>array(
    	'class'		=>	'form-horizontal well test-form top-messages has-validation-callback',
        'enctype'	=>	'multipart/form-data'
    )
)); ?>
 
 <?php if(!empty($result_array)){ ?>
 	<div class="row">
 		<div class="col-xs-3">
 			<label>Total Records</label> <span><?php echo count($result_array['added_records'])+count($result_array['failed_records'])+count($result_array['junk_records']);  ?></span>
 		</div>
 		<div class="col-xs-3">
 			<label>Added Records</label> <span><?php echo count($result_array['added_records']);  ?></span>
 		</div>
 		<div class="col-xs-3">
 			<label>Exist Records</label> <span><?php echo count($result_array['failed_records']);  ?></span>
 		</div>
 		<div class="col-xs-3">
 			<label>Junk Records</label> <span><?php echo count($result_array['junk_records']);  ?></span>
 		</div>
 	</div>
 	
 	<?php  
 	if(!empty($result_array['added_records'])){ ?>
		 <div class="alert alert-success fade in">
		 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <table class="table table-bordered">
		    	<tr>
		    		<th>Name</th>
		    		<th>Email</th>
		    		<th>Contact Number</th>
		    		<th>Query</th>
		    		<th>Source</th>
		    	</tr>
		    	<?php foreach ($result_array['added_records'] as $key => $value) { ?>
				<tr>
					<td><?php echo $value['name']; ?></td>
					<td><?php echo $value['email']; ?></td>
					<td><?php echo $value['contact_number']; ?></td>
					<td><?php echo $value['query']; ?></td>
					<td><?php echo $value['source']; ?></td>
				</tr>	
				<?php } ?>
			</table>
		 </div>
 		
 	<?php } ?>
 	
 	
 	<?php if(!empty($result_array['failed_records'])){ ?>
		 <div class="alert alert-danger fade in">
		 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <table class="table table-bordered">
		    	<tr>
		    		<th>Name</th>
		    		<th>Email</th>
		    		<th>Contact Number</th>
		    		<th>Query</th>
		    		<th>Source</th>
		    		<th>Reason</th>
		    	</tr>
		    	<?php foreach ($result_array['failed_records'] as $key => $value) { ?>
				<tr>
					<td><?php echo $value['name']; ?></td>
					<td><?php echo $value['email']; ?></td>
					<td><?php echo $value['contact_number']; ?></td>
					<td><?php echo $value['query']; ?></td>
					<td><?php echo $value['source']; ?></td>
					<td><?php echo $value['reason']; ?></td>
				</tr>	
				<?php } ?>
			</table>
		 </div>
 		
 	<?php }  	
 	if(!empty($result_array['junk_records'])){ ?>
		 <div class="alert alert-warning fade in">
		 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <table class="table table-bordered">
		    	<tr>
		    		<th>Name</th>
		    		<th>Email</th>
		    		<th>Contact Number</th>
		    		<th>Query</th>
		    		<th>Source</th>
		    		<th>Reason</th>
		    	</tr>
		    	<?php foreach ($result_array['junk_records'] as $key => $value) { ?>
				<tr>
					<td><?php echo $value['name']; ?></td>
					<td><?php echo $value['email']; ?></td>
					<td><?php echo $value['contact_number']; ?></td>
					<td><?php echo $value['query']; ?></td>
					<td><?php echo $value['source']; ?></td>
					<td><?php echo $value['reason']; ?></td>
				</tr>	
				<?php } ?>
			</table>
		 </div>
 		
 	<?php } ?>
 	
 <?php } ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<label for="exampleInputFile">File input</label>
        	<input id="ytLeadTracker_file" type="hidden" value="" name="LeadTracker[file]">
        	<input name="LeadTracker[file]" id="LeadTracker_file" type="file">
			<p class="help-block">
				Upload your XL file to add leads
			</p>
		</div>
		<button type="submit" class="btn btn-info">
			Upload
		</button>
 	</div>
</div>
 	
<?php $this->endWidget(); ?>
 
</div><!-- form -->