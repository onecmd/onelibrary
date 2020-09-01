<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;width:100%;">
		  	<li><a id="refresh_fine_list" href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
			<?php 
				if(!isset($page["currentPage"]))
					$page["currentPage"] = 0;
					
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		<div style="float:right; margin-right:30px;">
			<?php 
				$role = RoleUtil::getUserLibraryRole();
				if(!isset($role) || $role >= 6)
				{
			?>
			<button type="button" onclick="notifyFineAll()" class="btn btn-warning btn-normal" style="margin-left:30px;">Notify All Selected</button>
			<?php 
				}
			?>
		</div>
	</ul>
	<div class="row" style="margin-left:30px; color:red">
		通过支付宝备注信息和Pay Number确定支付的是哪一条罚款信息，当收到罚款时请及时确认支付.
	</div>
	<form id="notifyfine_form" action="<?php echo $this->createUrl("notifyFines", array("ids"=>"notify_fine_ids"));  ?>" method="post">
<table class="table table-condensed table-hover table-striped" style="margin-bottom:5px;">
	<!-- On rows 
	<tr class="active">...</tr>
	<tr class="success">...</tr>
	<tr class="warning">...</tr>
	<tr class="danger">...</tr>
	<tr class="info">...</tr>
	-->
	<!-- On cells (`td` or `th`) -->
	<tr class="info">
	  <td></td>
	  <td>No</td>
	  <td>Book Name</td>
	  <td>User ID</td>
	  <td>Holder</td>
	  <td>Borrwed</td>
	  <td>Returned</td>
	  <td>Fine</td>
	  <td>Pay Number</td>
	  <td>Notified</td>
	  <td>Last Notify</td>
	  <td>Action</td>
	</tr>
	<?php
		$allemail = "";
		foreach($ResultBooks as $data)
		{
			$totaldays = floor((time()-strtotime($data->return_time))/86400);
			$fine = $data->fine_overdue_per_day * $totaldays;
			$duecolor = $totaldays>0?"red":"blue";
			$holder = isset($data->user_name) ? $data->user_email : $data->user_name;
			if(strpos($allemail, $holder) === false){
				$allemail = $allemail."; ".$holder;
			}
	?>
	
	<tr>
	  	<td>
	  		<?php 
	  		if($data->fine_is_paid != 1){
	  		?>
	  		<input type="checkbox" name="notify_fine_ids" value="<?php echo $data->id ?>">
	  		<?php 
	  		}
	  		?>
	  	</td>
	  	<td><?php echo $data->id ?></td>
	  	<td>
	  		<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
	  			<?php echo $data->book_name ?>
	  		</a>
	  	</td>
	  	<td><?php echo $data->user_id ?><br>
	  	<td><?php echo "<font color=orange>".$holder."</font>" ?></td>
	  	<td><?php echo shortDate($data->borrow_time) ?></td>
	  	<td><font color="<?php echo $duecolor?>"><?php echo shortDate($data->actual_return_time) ?></font></td>
	  	<td><?php 
				if($data->fine_is_paid == 1){
		  			echo "<del><font color='green'> ￥".number_format($data->overdue_fine, 2)." </font></del>";
		  		}
		  		else{
		  			echo "<font color='red'> ￥".number_format($data->overdue_fine, 2)." </font>";
		  		}
	  	?></td>
	  	<td><?php 
				if($data->fine_is_paid == 1){
					$exist = strpos($data->fine_paid_time, "211");
					if($exist == "" || $exist<0){
						echo longDate($data->fine_paid_time);
					}
					else{
						echo "已支付";
					}
		  		}
		  		else{
		  			echo "<font color='red'> ".$data->pay_password." </font>";
		  		}
	  	?></td>
	  	<td><?php echo $data->fine_notify_times ?></td>
	  	<?php 
	  		$notdate = shortDate($data->fine_lastnotify_time);			
	  		if(strpos($data->fine_lastnotify_time, "211")>-1)
	  		{
	  			$notdate = "";
	  		}
	  		
	  		$user_is_paid="";
	  		if($data->fine_is_paid == 2){
	  			$notdate=$notdate."<font color=green>用户已付</font>";
	  		}else if($data->fine_is_paid == 1 && $data->fine_paid_method==1){
	  			$notdate="<font color=green>积分支付(".$data->paid_scores.")</font>";
	  		}
	  	?>
	  	<td><?php echo $notdate ?></td>
	  	<td>
	  		<?php 
	  			if($data->fine_is_paid != 1){
					$role = RoleUtil::getUserLibraryRole();
					if(!isset($role) || $role >= 6)
					{
	  		?>
	  		<button type="button" class="btn btn-danger btn-xs" onclick='changeToPaid("<?php echo $this->createUrl('changeToPaid', array('id'=>$data->id)) ?>")'>&nbsp; 确认已付 &nbsp;</button> 
			<?php 
					}
	  			}
			?>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
</form>
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
			<?php 
				if(!isset($page["currentPage"]))
					$page["currentPage"] = 0;
					
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadFinelist('<?php echo $this->createUrl("finelistView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
</div>