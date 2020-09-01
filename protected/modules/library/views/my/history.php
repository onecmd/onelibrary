	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
	<div style="color:red"><!--  
    		超期罚款请转账给工会图书馆支付宝账号，转账时务必备注下面表中对应的"Pay Number"（支付宝账号：18780258675， 账号名：CN98工会图书馆）， 如未备注请发邮件给hebihong@163.com并抄送给bihong.he@onelibrary.com。
    --></div>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>Book Name</td>
	  <td>Status</td>
	  <td>Borrow Date</td>
	  <td>Return Date</td>
	  <td>Due Date</td>
	  <td>Over Due</td>
	  <td>Fine Per Day</td>
	  <td>Total Fine</td>
	  <td>Pay Number</td>
	</tr>
	<?php
		$no = $pageSize*$page["currentPage"];
		foreach($ResultBooks as $data)
		{
			$no = $no+1;
			if($data->actual_return_time > getCurTime()){
				$totaldays = 0;
			}else{
				$totaldays = floor((strtotime($data->actual_return_time)-strtotime($data->return_time))/86400);
			}
			$totaldays = $totaldays<1?0:"<font color='red'>".$totaldays."</font>";
			?>
	
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->book_id)) ?>" target="_blank"><?php echo $data->book_name ?></a></td>
	  	<td><?php echo $data->is_return==1?"Returned":"<font color='red'>In hand</font>" ?></td>
	  	<td><?php echo shortDate($data->borrow_time) ?></td>
	  	<td><?php echo $data->is_return==1?shortDate($data->actual_return_time) : ""  ?></td>
	  	<td><?php echo shortDate($data->return_time) ?></td>
	  	<td><?php echo $totaldays ?> Days</td>
	  	<td><?php echo $data->fine_overdue_per_day ?></td>
	  	<td><?php 
	  		if($data->overdue_fine>0){
		  		if($data->fine_is_paid == 1){
		  			echo "<del><font color='green'> ￥".number_format($data->overdue_fine, 2)." </font></del>";
		  		}
		  		else{
		  			echo "<font color='red'> ￥".number_format($data->overdue_fine, 2)." </font>";
		  		}
	  		} else {
	  			echo "￥0.00";
	  		}
	  	?></td>
	  	<td>
	  		<?php 
			if($data->overdue_fine>0){
		  		if($data->fine_is_paid == 1){
		  			echo "已支付";
		  		}
		  		else{
		  			echo "<font color='red'> ".$data->pay_password." </font>";
		  		}
	  		} else {
	  			echo "";
	  		}
	  		?>
	  	</td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
			<?php 
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
		</ul>