	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadWaitingPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadWaitingPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
	<div class="row" style="margin-left:30px;color:red;">
		以下是你正在排队等候借阅的书籍，当书籍被归还时，将会为您保留一段时间，按排队顺序先排先借，请随时关注书籍归还时间。
	</div>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>Book Name</td>
	  <td>Reserve Time</td>
	  <td>Waiting Times</td>
	  <td>Status</td>
	  <td>Comments</td>
	  <td>Action</td>
	</tr>
	<?php
		$no = $pageSize*$page["currentPage"];
		$timeint = 3600*24;
		foreach($ResultWaitings as $data)
		{
			$no = $no+1;
			$totalhours = floor((time()-strtotime($data->join_time))/$timeint);
	?>
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->book_id)) ?>" target="_blank"><?php echo $data->book_name ?></a></td>
	  	<td><?php echo cutDate($data->join_time) ?></td>
	  	<td><?php echo $totalhours ?> Days</td>
	  	<td><?php echo $data->status==0?"Waiting" : "<font color=red>Book Returned</font>" ?></td>
	  	<td><?php echo $data->status==0?"Waiting" : "Please come to library to borrow the book immediately!"  ?></td>
		<td><a href="<?php echo Yii::app()->createUrl("library/search/cancelWaiting",array("book_id"=>$data->book_id,)) ?>" onclick='loadWaitingPage(<?php echo $page["currentPage"] ?>)' target="_blank" role="button" class="btn btn-warning btn-xs"> Cancel </a></td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadWaitingPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
			<?php 
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadWaitingPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadWaitingPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
		</ul>