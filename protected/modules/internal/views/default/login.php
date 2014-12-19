<?php Yii::app()->getClientScript()->registerCssFile($this->assetsBase.'/css/bootstrap.css'); ?>
<div class="container">
<!-- <div class="row">
<div class="col-md-3"></div>
<div class="col-md-6"> -->
<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'enableClientValidation'=>false,
					'enableAjaxValidation'=>false,
					'htmlOptions'=>array(
								'class'=>'form-signin'
					)));
		?>
		<h2 class="form-signin-heading">Please sign in</h2>
		<?php echo $form->textField($model,'username',array('class' => "required form-control",'placeholder'=>"Email address",'required'=>"",'autofocus'=>"")); ?>
		<?php echo $form->error($model,'username'); ?>
		<?php echo $form->passwordField($model,'password',array("class"=>"required form-control",'placeholder'=>"Password"));?>
       <?php echo $form->error($model,'password'); ?>
       <button class="btn btn-lg btn-primary btn-block" type="submit" id="loginButton">Sign in</button>

	<?php $this->endWidget(); ?>





</div>
      <style type="text/css">
      	body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
      </style>