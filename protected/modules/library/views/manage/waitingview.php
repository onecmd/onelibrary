<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
		<div class="panel panel-default" style="margin-bottom:0px;border-width:0px;">
				<div class="panel-body" style="padding:0px 0px 0px 0px;">
					<form id="tbWaiting_form" action="<?php echo $this->createUrl("waitingView") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="book_name" class="col-sm-2 control-label">Book Name:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="book_name" name="book_name" value="<?php echo isset($_REQUEST['book_name'])?$_REQUEST['book_name']:'' ?>" placeholder="">
							</div>
							<label for="holder_nsn_id" class="col-sm-2 control-label">User NSN ID:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="holder_nsn_id" name="holder_nsn_id"  value="<?php echo isset($_REQUEST['holder_nsn_id'])?$_REQUEST['book_name']:'' ?>" placeholder="">
							</div>
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-success" value="Search"  onclick="ajaxWaiting()">
							</div>
						</div>
					</form>
				</div>
		</div>
	<div class="row" style="margin-left:30px;color:red;">
		以下是你正在排队等候借阅的书籍，当书籍被归还时，按排队顺序先排先借。
	</div>
		
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>Book Name</td>
	  <td>Reserve User</td>
	  <td>Reserve Time</td>
	  <td>Waiting Times</td>
	  <td>Status</td>
	  <td>Action</td>
	</tr>
	<?php
		$no = $pageSize*$page["currentPage"];
		foreach($ResultWaitings as $data)
		{
			$no = $no+1;
			$hhh=time()-strtotime($data->join_time);
			$totalTimes = "";
			$totalHours = floor((time()-strtotime($data->join_time))/3600);
			if($totalHours<48){
				$totalTimes = $totalHours." Hours";
			}
			else if($totalHours<(24*30)){
				$totalTimes = floor($totalHours/(24))." Days";
			}
			else if($totalHours<(24*365)){
				$totalTimes = floor($totalHours/(24*30))." Months";
			}
			else{
				$totalTimes = floor($totalHours/24*365)." Years";
			}
			$holder = isset($data->user_email) ? $data->user_email : $data->user_name;
	?>
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->book_id)) ?>" target="_blank"><?php echo $data->book_name ?></a></td>
	  	<td><?php echo $holder ?></td>
	  	<td><?php echo longDate($data->join_time) ?></td>
	  	<td><?php echo $totalTimes ?></td>
	  	<td><?php echo $data->status==0?"Waiting" : "<font color=red>Notified, waiting borrow</font>" ?></td>
		<td>
			<a href="#" onclick='loadWaiting("<?php echo Yii::app()->createUrl("library/manage/notifyWaiting",array("id"=>$data->id)) ?>")' role="button" class="btn btn-success btn-xs">
				 &nbsp; Notify &nbsp;
			</a>
			<button type="button" class="btn btn-warning btn-xs" onclick='reserve("<?php echo $this->createUrl('reservePopView', array('bkid'=>$data->book_id, 'user_id'=>$data->user_id)) ?>")'>&nbsp; Borrow &nbsp;</button>			
			<a href="#" onclick='loadWaiting("<?php echo Yii::app()->createUrl("library/manage/cancelWaiting",array("book_id"=>$data->book_id,"user_id"=>$data->user_id)) ?>")' role="button" class="btn btn-danger btn-xs">
				 &nbsp; Cancel &nbsp;
			</a>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
</form>
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadWaiting('<?php echo $this->createUrl("waitingView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
</div>