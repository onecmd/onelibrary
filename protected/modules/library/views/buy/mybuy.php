	<div class="row" style="margin-left:0px;padding:10px 10px 0px 10px;">
	</div>
<div class="row" style="padding:5px 30px 5px 30px;">
	<table class="table table-condensed table-hover table-striped">
		<tr class="info">
		  <td>No</td>
		  <td>Book Name</td>
		  <td>Request Time</td>
		  <td>Reason</td>
		  <td>Following</td>
		  <td>Status</td>
		  <td>Buy Time</td>
		  <td>Buy List</td>
		  <td>Comments</td>
		  <td>Action</td>
		</tr>
		<?php
			$no = $pageSize*$page["currentPage"];
			foreach($ResultBooks as $data)
			{
				$no = $no+1;
		?>
		<tr>
		  	<td><?php echo $no ?></td>
		  	<td><?php echo $data->book_name ?></td>
		  	<td><?php echo cutDate($data->request_time) ?></td>
		  	<td><?php echo $data->request_reason ?></td>
		  	<td><?php echo $data->vote_user_names ?></td>
		  	<td><?php echo $this->getStatusStr($data->status) ?></td>
		  	<td><?php echo $data->status==2?longDate($data->buy_time):"" ?></td>
		  	<td><?php 
		  		if($data->buy_list_id != ""){
		  			$jsurl='showDlg("'.$this->createUrl("buyListDetail",array("id"=>$data->buy_list_id)).'","编辑心愿书单")';
		  			echo "<a style='cursor:pointer;' onclick='".$jsurl."' >".$data->buy_list_name."</a>";
		  			//echo "<a href='showBuyList(\"".$data->buy_list_id."\")'>".$data->buy_list_name."</a>";
		  		}
		  		else{
		  			echo "unknown";
		  		}
		  	?></td>
		  	<td><?php echo $data->comments ?></td>
			<td>
				<?php 
					if(RoleUtil::getUser()->nsn_id==$data->user_id && $data->status==0)
					{
				?>				
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("cancel",array("id"=>$data->id, "target"=>"mybuy")) ?>")' role="button" class="btn btn-danger btn-xs">
					 &nbsp; Cancel &nbsp;
				</a>
				<?php 
					}
				?>
			</td>		</tr>
		<?php 
			}
		?>
	</table>
	<?php 
		if($no<1)
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No books request.<br>";
	?>

</div>