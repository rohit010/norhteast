<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title><?= $this->pageTitle; ?></title>
<link rel="SHORTCUT ICON" href="/ico.ico">
<!-- Bootstrap core CSS -->
<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/bootstrap.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/sb-admin.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/font-awesome/css/font-awesome.min.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('http://cdn.oesmith.co.uk/morris-0.4.3.min.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/common.css'); ?>

<!-- Add custom CSS here -->
<!-- Page Specific CSS -->
<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
</head>
<body>
	<div id="wrapper">
		<!-- Sidebar -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index">NorthEast Properties</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li <?php echo (Yii::app()->controller->action->id=="index")?"class='active'":""; ?>><a href="index"><i class="fa fa-dashboard"></i>Home</a></li>
					<li <?php echo (Yii::app()->controller->action->id=="AddLeads")?"class='active'":""; ?>><a href="AddLeads"><i class="fa fa-edit"></i>Add Leads</a></li>
					<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageLeads']) && Yii::app()->user->user_access['AdminManageLeads'])){ ?>
					<li <?php echo (Yii::app()->controller->action->id=="ImportCSV")?"class='active'":""; ?>><a href="ImportCSV"><i class="fa fa-edit"></i>Bulk Upload</a></li>
					<?php } ?>
					<li <?php echo (Yii::app()->controller->action->id=="manageLeads")?"class='active'":""; ?>><a href="manageLeads"><i class="fa fa-table"></i> Manage Leads</a></li>
					<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin']) || (isset(Yii::app()->user->user_access['AdminManageUser']) && Yii::app()->user->user_access['AdminManageUser'])) { ?>
					<li <?php echo (Yii::app()->controller->action->id=="AddUsers")?"class='active'":""; ?>><a href="AddUsers"><i class="fa fa-edit"></i>Add Users</a></li>
					<li <?php echo (Yii::app()->controller->action->id=="manageUsers")?"class='active'":""; ?>><a href="manageUsers"><i class="fa fa-table"></i> Manage Users</a></li>
					<?php } ?>
					<?php if((isset(Yii::app()->user->user_access['Admin']) && Yii::app()->user->user_access['Admin'])){ ?>
					<li><a href="/rights/assignment/view"><i class="fa fa-edit"></i>Rights</a></li>
					<?php } ?>
					<li <?php echo (Yii::app()->controller->action->id=="OurTeam")?"class='active'":""; ?>><a href="OurTeam"><i class="fa fa-dashboard"></i>Our Team</a></li>
					<li><a href="http://email.northeast-properties.org"><i class="fa fa-mail-forward"></i>Email</a></li>
					<!-- <li><a href="blank-page.html"><i class="fa fa-file"></i> Blank Page</a> 
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>
							Dropdown <b class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li><a href="#">Dropdown Item</a></li>
							<li><a href="#">Another Item</a></li>
							<li><a href="#">Third Item</a></li>
							<li><a href="#">Last Item</a></li>
						</ul>
					</li>-->
				</ul>

				<ul class="nav navbar-nav navbar-right navbar-user">
					<!-- <li class="dropdown messages-dropdown"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"><i
							class="fa fa-envelope"></i> Messages <span class="badge">7</span>
							<b class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li class="dropdown-header">7 New Messages</li>
							<li class="message-preview"><a href="#"> <span class="avatar"><img
										src="http://placehold.it/50x50"> </span> <span class="name"><?php echo Yii::app()->user->name; ?></span> <span class="message">Hey there, I wanted to ask
										you something...</span> <span class="time"><i
										class="fa fa-clock-o"></i> 4:34 PM</span>
							</a>
							</li>
							<li class="divider"></li>
							<li class="message-preview"><a href="#"> <span class="avatar"><img
										src="http://placehold.it/50x50"> </span> <span class="name">John
										Smith:</span> <span class="message">Hey there, I wanted to ask
										you something...</span> <span class="time"><i
										class="fa fa-clock-o"></i> 4:34 PM</span>
							</a>
							</li>
							<li class="divider"></li>
							<li class="message-preview"><a href="#"> <span class="avatar"><img
										src="http://placehold.it/50x50"> </span> <span class="name">John
										Smith:</span> <span class="message">Hey there, I wanted to ask
										you something...</span> <span class="time"><i
										class="fa fa-clock-o"></i> 4:34 PM</span>
							</a>
							</li>
							<li class="divider"></li>
							<li><a href="#">View Inbox <span class="badge">7</span>
							</a></li>
						</ul>
					</li>
					<li class="dropdown alerts-dropdown"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"><i
							class="fa fa-bell"></i> Alerts <span class="badge">3</span> <b
							class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li><a href="#">Default <span class="label label-default">Default</span>
							</a></li>
							<li><a href="#">Primary <span class="label label-primary">Primary</span>
							</a></li>
							<li><a href="#">Success <span class="label label-success">Success</span>
							</a></li>
							<li><a href="#">Info <span class="label label-info">Info</span>
							</a></li>
							<li><a href="#">Warning <span class="label label-warning">Warning</span>
							</a></li>
							<li><a href="#">Danger <span class="label label-danger">Danger</span>
							</a></li>
							<li class="divider"></li>
							<li><a href="#">View All</a></li>
						</ul>
					</li> -->
					<li class="dropdown user-dropdown"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"><i
							class="fa fa-user"></i> <?php echo Yii::app()->user->name; ?> <b class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li><a href="/internal/EditUsersinfo?uid=<?php echo Yii::app()->user->id; ?>"><i class="fa fa-gear"></i> Settings</a></li>
							<li class="divider"></li>
							<li><a href="/site/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<div id="page-wrapper">
			<?php echo $content; ?>
		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- JavaScript -->
	<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile($this->assetsBase.'/js/bootstrap.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile($this->assetsBase.'/js/tablesorter/jquery.tablesorter.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile($this->assetsBase.'/js/tablesorter/tables.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile($this->assetsBase.'/js/common.js'); ?>
	<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
</body>
</html>
