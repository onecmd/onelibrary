<div class="row">
	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" id="nav_login" style="padding-bottom: 20px;">
		<br><br>
	<?php 
		echo $message;
		
		if(isset($backUrl)){
			
		?>
		<br><br><br>
		<a href="#<?php echo $backTabId ?>" onclick='javascript:showPage("<?php echo $backTabId ?>", "<?php echo $backUrl ?>", true)'>返回</a>
		<?php 
		}
		?>
	</div>
</div>