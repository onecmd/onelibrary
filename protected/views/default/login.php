<style type="text/css">
	#nav_login>ul>li>a{border-bottom-color:#0066ff;font-weight:bold;}
	#nav_login>ul>li.active>a{border-color:#0066ff;border-bottom-color:#fff;}
	#nav_login .tab-content{border-top: 1px solid #fff;border-right: 1px solid #0066ff;border-left: 1px solid #0066ff;border-bottom: 1px solid #0066ff;padding-bottom:20px;}
	.alert-warning{color:red;}
</style>

<div class="row">
	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" id="nav_login" style="padding-top: 20px;padding-bottom: 40px;">
		<!-- Nav tabs -->
		<ul id="maintab" class="nav nav-tabs text-center nav-justified" role="tablist">
		  <li <?php echo isset($targetAction)&&$targetAction=='regist'?'':'class="active"'; ?>><a href="#tblogin" role="tab" data-toggle="tab">Login</a></li>
		  <!--
		  <li <?php echo isset($targetAction)&&$targetAction=='regist'?'class="active"':''; ?>><a href="http://10.140.1.39/mvnforum/mvnforum/registermember" target="_blank" >Regist</a></li>
		  -->
		  <li <?php echo isset($targetAction)&&$targetAction=='regist'?'class="active"':''; ?>><a href="#tbregist" role="tab" data-toggle="tab">Regist</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
		  	<div class="tab-pane <?php echo isset($targetAction)&&($targetAction=='regist' || $targetAction=='resetpwd')?'':'active'; ?>" id="tblogin">
				<form id="user_login" action="<?php echo $this->createUrl("default/login") ?>" method="post" class="form-horizontal col-sm-offset-1" role="form" style="margin-top:30px;padding-bottom:20px;">
				  <div class="form-group">
				  	<?php 
				  		if(isset($loginErrors))
				  		{
				  	?>
				  	<div class="alert alert-warning alert-dismissible col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8" role="alert">
				  		<?php echo $loginErrors; ?>
				  	</div>
				  	<?php 
				  		}
				  		//echo md5("ccr2014");
				  	?>
				  </div>
				  <div class="form-group">
				    <label for="username" class="col-sm-3 control-label">NSN ID</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="username" name="UserForm[username]" placeholder="NSN ID">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="password" class="col-sm-3 control-label">Password</label>
				    <div class="col-sm-7">
				      <input type="password" class="form-control"  id="password" name="UserForm[password]" placeholder="Password">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-7" style="padding-top:5px; padding-bottom:20px;">
				      <div class="checkbox">
				        <label>
				          <input type="checkbox" id="login_remember" name="UserForm[rememberMe]" > Remember login
				        </label>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-7">
				      <button type="submit" class="btn btn-primary">&nbsp; Login &nbsp;</button>
				      <button type="button" class="btn btn-success" onclick="showReg()">&nbsp; Regist &nbsp; </button>
					  <div style="margin-top:8px;">
						<a href="#"  onclick="showResetpwd()">Forget password</a>
						<!--  
						<a href="http://10.140.1.39/mvnforum/mvnforum/iforgotpasswords"  target="_blank">Forget password</a>
						-->
					  </div>
				    </div>
				  </div>
				</form>		  	
			</div><!-- end  tblogin -->
			
			<!--  regist -->
		  	<div class="tab-pane <?php echo isset($targetAction)&&$targetAction=='regist'?'active':''; ?>" id="tbregist">
				<form id="user_regist" action="<?php echo $this->createUrl("default/regist") ?>" method="post" class="form-horizontal col-sm-offset-1" role="form" style="margin-top:20px;">
				  <div class="form-group">
				  	<?php 
				  		if(isset($registErrors))
				  		{
				  	?>
				  	<div class="alert alert-warning alert-dismissible col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8" role="alert">
				  		<?php echo $registErrors; ?>
				  	</div>
				  	<?php 
				  		}
				  	?>
				  </div>
				  <div class="form-group">
				    <label for="shop_id" class="col-sm-3 control-label">NSN ID</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="nsn_id" name="Users[nsn_id]" placeholder="Required">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="password" class="col-sm-3 control-label">Password</label>
				    <div class="col-sm-7">
				      <input type="password" class="form-control"  id="password" name="Users[password]" placeholder="Required">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="pass_rep" class="col-sm-3 control-label">Password Repeat</label>
				    <div class="col-sm-7">
				      <input type="password" class="form-control"  id="pass_rep" name="pass_rep" placeholder="Required">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">NSN Email</label>
				    <div class="col-sm-7">
				        <input type="text" class="form-control"  id="email" name="Users[email]" placeholder="Required, No changed after regist!">
				    </div>
				  </div>
				  <!--<div class="form-group">
				    <label for="user_name" class="col-sm-3 control-label">User Name</label>
				    <div class="col-sm-7">
				      <input type="tel" class="form-control"  id="user_name" name="Users[user_name]" placeholder="">
				    </div>
				  </div>-->
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-7" style="padding-top:15px;">
				      <button type="submit" class="btn btn-primary">Regist</button>
				      <button type="button" class="btn btn-success" onclick="showLogin()">&nbsp;  Login &nbsp; </button>
				    </div>
				  </div>
				</form>					
			</div> <!-- end regist -->
			
		  	<div class="tab-pane <?php echo isset($targetAction)&&$targetAction=='resetpwd'?'active':''; ?>" id="tbresetpwd">
				<form id="user_resetpwd" action="<?php echo $this->createUrl("resetpwd") ?>" method="post" class="form-horizontal col-sm-offset-1" role="form" style="margin-top:20px;">
				  <div class="form-group">
				  	<?php 
				  		if(isset($resetpwdErrors))
				  		{
				  	?>
				  	<div class="alert alert-warning alert-dismissible col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8" role="alert">
				  		<?php echo $resetpwdErrors; ?>
				  	</div>
				  	<?php 
				  		}
				  		//echo md5("ccr2014");
				  	?>
				  </div>
				  <div class="form-group">
				    <label for="nsn_id" class="col-sm-3 control-label">NSN ID</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="nsn_id" name="nsn_id" placeholder="NSN ID">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">NSN Email</label>
				    <div class="col-sm-7">
				        <input type="text" class="form-control"  id="email" name="email" placeholder="Required">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-7" style="padding-top:15px;">
				      <button type="submit" class="btn btn-primary">Reset Password</button>
				      <div style="margin-top:8px;">
						<a href="#"  onclick="back2Login()">Login</a>
						<!--  
						<a href="http://10.140.1.39/mvnforum/mvnforum/iforgotpasswords"  target="_blank">Forget password</a>
						-->
					  </div>
				    </div>
				  </div>
					
				</form>
			</div><!-- end tbresetpwd -->
		</div>
	</div>
</div>

<script language="javascript">
function showLogin(){
	$('#maintab a[href="#tblogin"]').tab('show');
}
function showReg(){
	$('#maintab a[href="#tbregist"]').tab('show');
	//window.open("http://10.140.1.39/mvnforum/mvnforum/registermember");
}
function showResetpwd(){
	$('#tblogin').removeClass("active");
	$('#tbregist').removeClass("active");
	$('#tbresetpwd').addClass("active");
}
function back2Login(){
	$('#tblogin').addClass("active");
	$('#tbregist').removeClass("active");
	$('#tbresetpwd').removeClass("active");
}
</script>