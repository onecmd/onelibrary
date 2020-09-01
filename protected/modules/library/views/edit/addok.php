<div class="row">
	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10" style="padding:10px 10px 20px 10px;">
		<b>Book added finished!</b><br><br>
		<?php 
			if(isset($message))
			{
				echo $message;
			}
		?>
		<a href="<?php echo $this->createUrl("add") ?>" class="btn btn-info">Add book again</a>
        <a href="<?php echo Yii::app()->createUrl("library/search/index") ?>" class="btn btn-default">Go to book list</a>
	</div>
</div>