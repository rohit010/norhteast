<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title></title>
		<link rel="stylesheet" href="style.css" />
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/bootstrap.css'); ?>
		<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/style.css'); ?>
		<?php Yii::app()->getClientScript()->registerScriptFile($this->assetsBase.'/js/bootstrap.js'); ?>
		<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
	</head>
	<body>
		<div class="container">
			<div id="container">
				<div class="header row">
					<div class="col-md-3">
						<img src="<?php echo $this->assetsBase; ?>/images/logo_northeast.gif" />
					</div>
					<div class="col-md-9">
						
					</div>
				</div>
				<div class="row manu_bar">
					<div class="masthead">
			        <ul class="nav nav-justified">
			          <li class="active"><a href="#">Home</a></li>
			          <li><a href="#">About us</a></li>
			          <li><a href="#">Projects</a></li>
			          <li><a href="#">Galary</a></li>
			          <li><a href="#">Enquiry</a></li>
			          <li><a href="#">Careers</a></li>
			          <li><a href="#">Contact</a></li>
			          
			        </ul>
			      </div>
					
				</div>
				<?php echo $content; ?>
				<div class="header">
					
				</div>
			</div>
		</div>
	</body>
</html>

