<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
		<div class="panel panel-default" style="margin-bottom:0px;border-width:0px;">
				<div class="panel-body" style="padding:0px 0px 0px 0px;">
					<form id="tbReturn_form" action="<?php echo $this->createUrl("returnView") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="book_name" class="col-sm-2 control-label">Book Name:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="book_name" name="book_name"  value="<?php echo isset($_REQUEST['book_name'])?$_REQUEST['book_name']:'' ?>" placeholder="">
							</div>
							<label for="holder_nsn_id" class="col-sm-2 control-label">User NSN ID:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="holder_nsn_id" name="holder_nsn_id"  value="<?php echo isset($_REQUEST['holder_nsn_id'])?$_REQUEST['book_name']:'' ?>" placeholder="">
							</div>
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-success" value="Search" onclick="ajaxReturn()">
							</div>
						</div>
					</form>
				</div>
		</div>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
<table class="table table-condensed table-hover table-striped">
	<!-- On rows 
	<tr class="active">...</tr>
	<tr class="success">...</tr>
	<tr class="warning">...</tr>
	<tr class="danger">...</tr>
	<tr class="info">...</tr>
	-->
	<!-- On cells (`td` or `th`) -->
	<tr class="info">
	  <td>No</td>
	  <td>Book Logo</td>
	  <td>Book Name</td>
	  <td>Book ID</td>
	  <td>Book Type</td>
	  <!--  <td>Status</td>-->
	  <td>Holder</td>
	  <td>Borrowed</td>
	  <td>Due Date</td>
	  <td>Fine</td>
	  <td>Notify</td>
	  <td>Action</td>
	</tr>
	<?php
		foreach($ResultBooks as $data)
		{
			$totaldays = floor((time()-strtotime($data->due_date))/86400);
			$fine = $data->fine_overdue_per_day * $totaldays;
			$maxfine=intval(SiteSystemParameters::getParmValue('OverDueMaxFine'));
			if($fine<0)
			{
			 	$fine="0.0";
			}
			 else if($fine>$maxfine)
			 {
			 	$fine = $maxfine;
			 	$fine="<font color=red>".$fine."</font>";
			 }
			else 
			 {
			 	$fine="<font color=red>".$fine."</font>";
			 }
			 $duecolor = $totaldays>0?"red":"blue";
			 $holder = $data->holder_name;
			if(isset($data->holder_email))
			{
				$holder =$data->holder_email;
			}
	?>
	
	<tr>
	  	<td><?php echo $data->id ?></td>
	  	<td>
	  		<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
	  			<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$data->book_logo ?>" border="0" height="30" />
	  		</a>
	  	</td>
	  	<td><?php echo $data->book_name ?></td>
	  	<td><?php echo $data->book_id ?><br>
	  	<td><div id="bktype_<?php echo $data->id ?>"><?php echo $BookTypeArray[$data->book_type] ?></div></td>
	  	<!--  <td><?php echo $this->parseBookStatus($data->status) ?></td>-->
	  	<td><?php echo "<font color=green>".$holder."</font>" ?></td>
	  	<td><?php echo shortDate($data->borrowed_time) ?></td>
	  	<td><font color="<?php echo $duecolor?>"><?php echo shortDate($data->due_date) ?></font></td>
	  	<td>￥<?php echo $fine ?></td>
	  	<td><?php echo $data->notify_email_times ?></td>
	  	<td>
	  		<div class="dropdown">
				<button type="button" class="btn btn-primary btn-xs" onclick='view("<?php echo Yii::app()->createUrl('library/edit/view', array('bkid'=>$data->id)) ?>")'>View</button>	  			
	  			<button type="button" class="btn btn-success btn-xs" onclick='edit("<?php echo Yii::app()->createUrl('library/edit/edit', array('bkid'=>$data->id)) ?>")'>&nbsp; Edit &nbsp;</button>
       			<button type="button" class="btn btn-warning btn-xs" onclick='returnview("<?php echo $this->createUrl('ReturnPopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Return &nbsp;</button> 
       			<?php 
       				if(($totaldays>-4 && $totaldays<1) 
       					|| ($data->notify_email_times<1 && $totaldays>-4) 
       					|| ($data->notify_email_times>0 && $totaldays>0))
       				{
       			?>
         		<button type="button" class="btn btn-danger btn-xs" onclick='notify("<?php echo $this->createUrl('notifyPopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Notify &nbsp;</button> 
				<?php 
					}
				?>
			</div>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadReturn('<?php echo $this->createUrl("returnView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		</ul>
</div>