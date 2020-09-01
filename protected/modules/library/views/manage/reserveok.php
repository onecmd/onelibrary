<div class="row">
	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" id="nav_login" style="padding-bottom: 20px;">
		<h5><font color=red><?php echo $message ?></font></h5><br>
		<div id="message_response" style="color:red;width:100%;text-align:center;"></div>
		<?php 
			if(isset($isback) && $isback)
			{
		?>
		<a href="#" onclick='window.history.back()'>Back</a>
		<?php 
			}
			else 
			{
		?>
		<!--  <a href="<?php echo $this->createUrl("index") ?>" class="btn btn-info">Continue ... </a>-->
		<?php 
			}
		?>
	</div>
</div>