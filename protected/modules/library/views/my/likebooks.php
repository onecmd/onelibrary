<div class="row">
	<div class="row" style="padding:10px 30px 20px 40px;">
		<table class="table table-striped">
			<tr>
				<td>ID</td>
				<td>Book Name</td>
				<td>Added Time</td>
				<td>Action</td>
			</tr>
	<?php 
		$total = 0;
		foreach($LikeBooks as $model)
		{
			$total = $total+1;
	?>
			<tr>
				<td><?php echo $total ?></td>
				<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$model->book_id)) ?>" target="_blank"><?php echo $model->book_name ?></a></td>
				<td><?php echo $model->add_time ?></td>
				<td><a href="<?php echo Yii::app()->createUrl("library/search/unlikeit",array("book_id"=>$model->book_id)) ?>" target="_blank" class="btn btn-success btn-xs">Unlike It</a></td>
			</tr>
	<?php 
		}
		if($total<1)
		{
	?>
			<tr>
				<td colspan="3">No like books found!</td>
			</tr>
	<?php 
		}
	?>
		</table>
	</div>
</div>