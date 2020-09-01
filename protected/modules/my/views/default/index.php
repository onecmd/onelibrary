 <div class="row" style="padding: 20px 20px 30px 20px; font-weight:normal">
		<?php 
			$user = RoleUtil::getUser();
			if(!isset($user))
			{
				Header("Location:".Yii::app()->createUrl(Yii::app()->user->loginUrl));
			}
			$system_role = RoleUtil::getSystemRoleStr(RoleUtil::getUserSystemRole());
			$library_role = RoleUtil::getLibraryRoleStr(RoleUtil::getUserLibraryRole());
		?>
	<div class="form-group">
		<b>User Information</b>
		<hr size="1">
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">NSN ID:</label>
		<label class="col-sm-7 control-label"><?php echo $user->nsn_id ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Name:</label>
		<label class="col-sm-7 control-label"><?php echo $user->user_name ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Title:</label>
		<label class="col-sm-7 control-label"><?php echo $user->title ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">System Role:</label>
		<label class="col-sm-7 control-label"><?php echo $system_role ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Library Role:</label>
		<label class="col-sm-7 control-label"><?php echo $library_role ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Email:</label>
		<label class="col-sm-7 control-label"><?php echo $user->email ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Regist Time:</label>
		<label class="col-sm-7 control-label"><?php echo $user->create_time ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Last login:</label>
		<label class="col-sm-7 control-label"><?php echo $user->last_time ?></label>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Last login IP:</label>
		<label class="col-sm-7 control-label"><?php echo $user->last_ip ?></label>
	</div>

 </div>