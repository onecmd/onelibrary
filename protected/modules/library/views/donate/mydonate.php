	<div class="row" style="margin-left:0px;padding:10px 10px 0px 10px;">
		<font color="red">
		We are very warmly welcome you to donate your free books to us - Onelibrary Library! <br>
		</font>
		Following are your donated books:
	</div>
<div class="row" style="padding:5px 30px 5px 30px;">
	<table class="table table-condensed table-hover table-striped">
		<tr class="info">
		  <td>No</td>
		  <td>Book Name</td>
		  <td>Donator</td>
		  <td>Donate Time</td>
		  <td>Win Present</td>
		</tr>
		<?php
			$no = 0;
			foreach($ResultBooks as $data)
			{
				$no = $no+1;
		?>
		<tr>
		  	<td><?php echo $no ?></td>
		  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->book_id)) ?>" target="_blank"><?php echo $data->book_name ?></a></td>
		  	<td><?php echo $data->user_name."(".$data->user_email.")" ?></td>
		  	<td><?php echo cutDate($data->donate_time) ?></td>
		  	<td><?php echo $data->present ?></td>
		</tr>
		<?php 
			}
		?>
	</table>
	<?php 
		if($no<1)
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No books donated.<br>";
	?>

</div>