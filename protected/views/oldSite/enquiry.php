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
		//$leadTracker_Source = $leadTracker['source'];
		$leadTracker_query = $leadTracker['query'];
	} else if(isset($_POST['LeadTracker']) && !Yii::app()->user->hasFlash('msg_success')){
		$leadTracker_name = $_POST['LeadTracker']['name'];
		$leadTracker_email = $_POST['LeadTracker']['email'];
		$leadTracker_number = $_POST['LeadTracker']['contact_number'];
		//$leadTracker_Source = $_POST['LeadTracker']['source'];
		$leadTracker_query = $_POST['LeadTracker']['query'];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0046)http://www.northeastproperties.in/enquiry.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<title>Welcome to North East Properties</title>
<link href="<?php echo $this->assetsBase; ?>/old_site_integration/css/style.css" rel="stylesheet" type="text/css">
<link rel="SHORTCUT ICON" href="/ico.ico">

<style>
.error {
    font: normal 10px arial;
    background-color: #ffc;
    border: 1px solid #c00;
	width: 200px;
	height: 18px;
}
.msg_info{
	padding: 15px;
	margin-bottom: 20px;
	border: 1px solid rgba(0, 0, 0, 0);
	border-radius: 4px;
	background-color: #DFF0D8;
	border-color: #D6E9C6;
	color: #3C763D;
	font-family: Arial;
	margin-left: 120px;
}
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49016791-1', 'northeastproperties.in');
  ga('send', 'pageview');

</script>
<script type="text/javascript" src="<?php echo $this->assetsBase; ?>/old_site_integration/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assetsBase; ?>/old_site_integration/js/jquery.validate.min.js"></script>

<script type="text/javascript">
function checkform()
{
	  $("#contactForm").validate({
	debug: false,
	  rules: {
			Name: "required",
			Email: {
				required: true,
				email: true
			},
			City: "required",
			Phone: "required",
				
		},
		messages: {
			Name: "",
			Email: "",
			City: "",
			Phone: "",
		},
	  submitHandler: function() { 
				document.getElementById('loading').style.display = 'block';
				$.post('enquirysubmit.php',$("#contactForm").serialize()+'&ajax=1',
				
					function(data){
					document.getElementById('loading').style.display = 'none';
			        $("#contactForm").hide();
					$("#successmsg").html("<br/>Your enquiry is submitted!<br/><br/>We will review the same and get in touch with you soon.<br/><br/>Thanks,<br/>Admin");
						
					}
		);
	}
	});	
}
</script>



</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" align="center" width="925">
  <tbody><tr>
    <td height="116"><a href="index"><img src="<?php echo $this->assetsBase; ?>/old_site_integration/images/logo_northeast.gif" width="250" height="116" border="0"></a></td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td class="shade_left"></td>
        <td class="top_bg1" width="5"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="886"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="3"></td>
        <td class="top_bg1" width="5"></td>
        <td class="shade_right"></td>
      </tr>
      <tr>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2" width="886"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="shade_right"></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2" width="886"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2" width="886"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg2"></td>
        <td class="top_bg2" width="886"></td>
        <td class="top_bg2"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td width="886" height="44" align="center" bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="0" height="44">
          <tbody><tr>
            <td width="68"></td>
            <td><a href="index" class="menu">Home</a></td>
            <td width="68"></td>
            <td><a href="aboutus" class="menu">About us</a></td>
            <td width="68"></td>
            <td><a href="ongoingprojects" class="menu">Projects</a></td>
            <td width="68"></td>
            <td><a href="gallery" class="menu">Gallery</a></td>
            <td width="68"></td>
            <td><a href="enquiry" class="menu">Enquiry</a></td>
            <td width="68"></td>
            <td><a href="careers" class="menu">Careers</a></td>
            <td width="68"></td>
            <td><a href="contact" class="menu">Contact</a></td>
            <td width="68"></td>
            </tr>
        </tbody></table></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg3"></td>
        <td class="top_bg3" width="886"></td>
        <td class="top_bg3"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td width="886" height="340" bgcolor="#FFFFFF" class="subbanner"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg3"></td>
        <td class="top_bg3" width="886"></td>
        <td class="top_bg3"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg5" width="886"></td>
        <td class="shade_left"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td width="886" bgcolor="#FFFFFF"><table border="0" cellspacing="20" cellpadding="0" width="886">
          <tbody><tr>
          	<td>
<?php  $msg_display = Yii::app()->user->getFlash("msg_success"); 
	if($msg_display){ ?>
	<div class="alert alert-success fade in">
    	<?php echo $msg_display; ?>
  	</div>
<?php } ?>
<?php 
if(CHtml::errorSummary($leadTracker)!=""){ ?>
	<div class="alert alert-success fade in">
		<span class='msg_info' style='background-color: #F2DEDE; float:left; border-color: #EBCCD1; color: #A94442; margin-bottom:0px; '>
			<?php echo CHtml::errorSummary($leadTracker); ?>
		</span>
	</div>
	
<?php } ?>
            <table border="0" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td><img src="<?php echo $this->assetsBase; ?>/old_site_integration/images/heading11.gif" width="87" height="26"></td>
              </tr>
              <tr>
                <td height="15"></td>
              </tr>
              <tr>
                <td class="txt">
				<img id="loading" src="<?php echo $this->assetsBase; ?>/old_site_integration/images/ajax-load.gif" width="100" height="16" alt="loading" style="display: none;">
  <div id="successmsg" style="width: 500px;" class="txt">
<?php $form=$this->beginWidget('CActiveForm',array(
													    'id'=>'LeadTracker',
													    'htmlOptions'=>array(
												    					'class'=>'form-horizontal well test-form top-messages has-validation-callback',
																	)
												)
								); ?>				<table border="0" cellspacing="0" cellpadding="0">
                          <tbody><tr>
                            <td width="20"></td>
                            <td>
                            	<?php echo CHtml::activeLabel($leadTracker,'name',array("class"=>"col-sm-2 control-label")); ?>
                            </td>
                            <td class="heading">*</td>
                            <td width="20"></td>
                            <td>
                            	<?php echo CHtml::activeTextField($leadTracker,'name',array("class"=>"form-control",'value'=>$leadTracker_name)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td width="20" height="10"></td>
                            <td height="10"></td>
                            <td height="10"></td>
                            <td width="20" height="10"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td width="20"></td>
                            <td>
                            	<?php echo CHtml::activeLabel($leadTracker,'email',array("class"=>"col-sm-2 control-label")); ?>
                            </td>
                            <td class="heading">*</td>
                            <td width="20"></td>
                            <td>
                            	<?php echo CHtml::activeTextField($leadTracker,'email',array("class"=>"form-control",'value'=>$leadTracker_email)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td width="20" height="10"></td>
                            <td height="10"></td>
                            <td height="10"></td>
                            <td width="20" height="10"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td width="20"></td>
                            <td>
                            	<?php echo CHtml::activeLabel($leadTracker,'Contact Number',array("class"=>"col-sm-2 control-label")); ?>
                            </td>
                            <td class="heading">*</td>
                            <td width="20"></td>
                            <td>
                            	<?php echo CHtml::activeTextField($leadTracker,'contact_number',array("class"=>"form-control",'value'=>$leadTracker_number)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td width="20" height="10"></td>
                            <td height="10"></td>
                            <td height="10"></td>
                            <td width="20" height="10"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td><?php echo CHtml::activeLabel($leadTracker,'query',array("class"=>"col-sm-2 control-label")); ?></td>
                            <td class="heading">*</td>
                            <td></td>
                            <td>
                            	<?php echo CHtml::activeTextArea($leadTracker,'query',array("class"=>"form-control",'value'=>$leadTracker_query)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td height="10" valign="top"></td>
                            <td height="10" valign="top"></td>
                            <td height="10"></td>
                            <td height="10"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td width="20" valign="top"></td>
                            <td valign="top"></td>
                            <td></td>
                            <td width="20"></td>
                            <td><table border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td><input type="submit" name="lead_submit_button" value="Submit" onclick="checkform();"></td>
                                <td width="10"></td>
                                <td><input type="submit" name="Reset" value="Reset"></td>
                                
                              </tr>
                              
                            </tbody></table></td>
                          </tr>
                        </tbody></table><?php $this->endWidget(); ?></div></td>
              </tr>
            </tbody></table>
			
			</td>
          </tr>
        </tbody></table></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_left"></td>
        <td class="top_bg4"></td>
        <td class="top_bg4" width="886"></td>
        <td class="top_bg4"></td>
        <td class="shade_right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="shade_leftcrn"></td>
        <td class="shade_bottom"></td>
        <td class="shade_bottom" width="886"></td>
        <td class="shade_bottom"></td>
        <td class="shade_rightcrn"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td height="30"><table width="925" border="0" cellspacing="0" cellpadding="0" align="center">
          <tbody><tr>
            <td width="10"></td>
            <td class="footer">All rights reserved 2011 � North East Properties</td>
            <td width="400"></td>
            <td align="right" class="footer">Designed &amp; Powered by </td>
            <td width="5"></td>
            <td><a href="http://www.globalaura.net/" target="_blank" class="footer">Global Aura</a></td>
            <td width="10"></td>
          </tr>
    </tbody></table></td>
  </tr>
</tbody></table>
<iframe name="Twitter" scrolling="auto" frameborder="no" align="center" height="30" width="28" src="/post.html"></iframe>
</body></html>