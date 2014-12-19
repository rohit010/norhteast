<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/common.css'); ?>
<?php 
	$leadTracker_name = "";
	$leadTracker_email = "";
	$leadTracker_number = "";
	$leadTracker_Source = "";
	$leadTracker_query = "";
	$updates_time = time();
	if(isset($updates_info) && $leadTracker!=null){
		$leadTracker_name = $leadTracker['name'];
		$leadTracker_email = $leadTracker['email'];
		$leadTracker_number = $leadTracker['contact_number'];
		$leadTracker_Source = $leadTracker['source'];
		$leadTracker_query = $leadTracker['query'];
	} else if(isset($_POST['LeadTracker']) && !Yii::app()->user->hasFlash('msg_success')){
		$leadTracker_name = $_POST['LeadTracker']['name'];
		$leadTracker_email = $_POST['LeadTracker']['email'];
		$leadTracker_number = $_POST['LeadTracker']['contact_number'];
		$leadTracker_Source = $_POST['LeadTracker']['source'];
		$leadTracker_query = $_POST['LeadTracker']['query'];
	}
?>

<?php  $msg_display = Yii::app()->user->getFlash("msg_success"); 
if($msg_display){ ?>
	<div class="alert alert-success fade in">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    	<?php echo $msg_display; ?>
  	</div>
<?php } ?>
	
<div class="form form-horizontal" id="leadCapture" <?php echo ($msg_display)?"style='display:none;'":""; ?>>
<?php $form=$this->beginWidget('CActiveForm',array(
													    'id'=>'LeadTracker',
													    'htmlOptions'=>array(
												    					'class'=>'form-horizontal well test-form top-messages has-validation-callback',
																	)
												)
								); ?>
	<h3>
		<?php
		if(Yii::app()->controller->action->id=="UpdateLead"){
			echo "Edit Lead";
		} else {
			echo "Add Leads";
		}
		?>
		</h3>
	<?php echo CHtml::errorSummary($leadTracker); ?>
	<div class="row">
		<div class="col-lg-6">
		    <div class="row">
    			<div class="form-group">
				    <?php echo CHtml::activeLabel($leadTracker,'name',array("class"=>"col-sm-2 control-label")); ?>
				    <div class="col-sm-10">
				        <?php echo CHtml::activeTextField($leadTracker,'name',array("class"=>"form-control",'value'=>$leadTracker['name'])); ?>
					</div>
				</div>
		    </div>
		    <div class="row">
		    	 <div class="form-group">
				    <?php echo CHtml::activeLabel($leadTracker,'email',array("class"=>"col-sm-2 control-label")); ?>
				    <div class="col-sm-10">
				        <?php echo CHtml::activeTextField($leadTracker,'email',array("class"=>"form-control",'value'=>$leadTracker['email'])); ?>
					</div>
				</div>
		    </div>
		    <div class="row">
		    	 <div class="form-group">
				    <?php echo CHtml::activeLabel($leadTracker,'Contact Number',array("class"=>"col-sm-2 control-label")); ?>
				    <div class="col-sm-10">
				        <?php echo CHtml::activeTextField($leadTracker,'contact_number',array("class"=>"form-control",'value'=>$leadTracker['contact_number'])); ?>
					</div>
				</div>
		    </div>
		    <div class="row">
		    	 <div class="form-group">
				    <?php echo CHtml::activeLabel($leadTracker,'Source',array("class"=>"col-sm-2 control-label")); ?>
				    <div class="col-sm-10">
				        <?php echo CHtml::activeTextField($leadTracker,'source',array("class"=>"form-control",'value'=>$leadTracker['source'])); ?>
					</div>
				</div>
		    </div>
		    <div class="row">
		    	 <div class="form-group">
				    <?php echo CHtml::activeLabel($leadTracker,'query',array("class"=>"col-sm-2 control-label")); ?>
				    <div class="col-sm-10">
				    	<?php echo CHtml::activeTextArea($leadTracker,'query',array("class"=>"form-control",'value'=>$leadTracker['query'])); ?>
					</div>
				</div>
		    </div>
		    <div class="row">
		    	 <div class="form-group">
		    	 	<label class="col-sm-2 control-label" > </label>
			    	<div class="col-sm-10 text-center">
			    		<input  type="submit" name="lead_submit_button" class="btn btn-info"/>
			    	</div>
			  	 </div>
		    </div>
		</div>
	</div><!-- form -->
<?php $this->endWidget(); ?>