<div class="row">
	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" id="nav_login" style="padding-bottom: 20px;">
		<?php echo $message ?><br>Please refresh the list page.<br>
		<?php 
			$bkid = isset($_REQUEST["bkid"])?$_REQUEST["bkid"]:"0";
		?>
		<a href="<?php echo $this->createUrl("viewfull", array("bkid"=>$bkid)) ?>"  role="button" class="btn btn-success"> &nbsp; OK  &nbsp; </a>
	</div>
</div>