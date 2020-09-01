<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;width:100%;">
		  	<li><a id="resresh_notifys" href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		<div style="float:right; margin-right:30px;">
			<button type="button" onclick="notifyall()" class="btn btn-warning btn-normal" style="margin-left:30px;">Notify All Selected</button>
		</div>
	</ul>
	<div class="row" style="margin-left:30px; color:red">
		显示一星期内到期，和超期未还的图书.
	</div>
	<form id="notifyall_form" action="<?php echo $this->createUrl("notifyall", array("book_ids"=>"notify_book_ids"));  ?>" method="post">
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
	  <td>Book ID</td>
	  <td>Book Type</td>
	  <!--  <td>Status</td>-->
	  <td>Holder</td>
	  <td>Due Time</td>
	  <td>Notified</td>
	  <td>Last Notify</td>
	  <td>Action</td>
	</tr>
	<?php
		$allemail = "";
		foreach($ResultBooks as $data)
		{
			$totaldays = floor((time()-strtotime($data->due_date))/86400);
			$fine = $data->fine_overdue_per_day * $totaldays;
			$duecolor = $totaldays>0?"red":"blue";
			$holder = isset($data->holder_email) ? $data->holder_email : $data->holder_name;
			if(strpos($allemail, $holder) === false){
				$allemail = $allemail."; ".$holder;
			}
	?>
	
	<tr>
	  	<td><input type="checkbox" name="notify_book_ids" value="<?php echo $data->id ?>"></td>
	  	<td><?php echo $data->id ?></td>
	  	<td>
	  		<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
	  			<?php echo $data->book_name ?>
	  		</a>
	  	</td>
	  	<td><?php echo $data->book_id ?><br>
	  	<td><div id="bktype_<?php echo $data->id ?>"><?php echo $BookTypeArray[$data->book_type] ?></div></td>
	  	<!--  <td><?php echo $this->parseBookStatus($data->status) ?></td>-->
	  	<td><?php echo "<font color=orange>".$holder."</font>" ?></td>
	  	<td><font color="<?php echo $duecolor?>"><?php echo shortDate($data->due_date) ?></font></td>
	  	<td><?php echo $data->notify_email_times ?></td>
	  	<?php 
	  		$notdate = shortDate($data->last_email_time);			
	  		if(strpos($data->last_email_time, "2114-")>-1)
	  		{
	  			$notdate = "";
	  		}
	  	?>
	  	<td><?php echo $notdate ?></td>
	  	<td>
	  		<div class="dropdown">
				<button type="button" class="btn btn-primary btn-xs" onclick='view("<?php echo Yii::app()->createUrl('library/edit/view', array('bkid'=>$data->id)) ?>")'>View</button>	  			
        		<button type="button" class="btn btn-success btn-xs" onclick='notify("<?php echo $this->createUrl('notifyPopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Notify &nbsp;</button> 
			</div>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
<div class="row" style="margin-bottom:10px;">
	<button type="button" onclick="notifyall()" class="btn btn-warning btn-normal" style="margin-left:30px;">Notify All Selected</button>
	<br>
	本页所有邮箱：<br>
	<? echo $allemail ?>
</div>
</form>
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadNotify('<?php echo $this->createUrl("notifyView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
</div>