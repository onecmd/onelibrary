
<form id="user_regist"
	action="<?php echo $this->createUrl("changepasswd") ?>" method="post"
	class="form-horizontal col-sm-offset-1" role="form"
	style="margin-top: 20px;padding-bottom:30px;">
	<div class="form-group">
	<?php
	if(isset($message))
	{
		?>
		<div
			class="alert alert-warning alert-dismissible col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8" role="alert">
			<?php echo $message; ?>
		</div>
		<?php
	}
	?>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-3 control-label">New Password</label>
		<div class="col-sm-7">
			<input type="password" class="form-control" id="password" name="password" placeholder="Required">
		</div>
	</div>
	<div class="form-group">
		<label for="password_repeat" class="col-sm-3 control-label">Repeat Password</label>
		<div class="col-sm-7">
			<input type="password" class="form-control" id="password_repeat" name="password_repeat" placeholder="Required">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-7" style="padding-top: 15px;">
			<button type="submit" class="btn btn-primary">Change Password</button>
		</div>
	</div>
</form>