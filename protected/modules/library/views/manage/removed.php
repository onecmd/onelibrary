<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
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
	  <td>Owner Team</td>
	  <td>Status</td>
	  <td>Remove Time</td>
	  <td>Remover</td>
	  <td>Action</td>
	</tr>
	<?php
		foreach($ResultBooks as $data)
		{
			$totaldays = floor((time()-strtotime($data->due_date))/86400);
			$fine = $data->fine_overdue_per_day * $totaldays;
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
	  	<td><?php echo $data->owner_team ?></td>
	  	<td><?php echo $this->parseBookStatus($data->status) ?></td>
	  	<td><?php echo shortDate($data->remove_time) ?></td>
	  	<td><?php echo $data->remover_nsn_id ?></td>
	  	<td>
	  		<div class="dropdown">
				<button type="button" class="btn btn-primary btn-xs" onclick='view("<?php echo Yii::app()->createUrl('library/edit/view', array('bkid'=>$data->id)) ?>")'>View</button>	  			
	  			<button type="button" class="btn btn-success btn-xs" onclick='edit("<?php echo Yii::app()->createUrl('library/edit/edit', array('bkid'=>$data->id)) ?>")'>&nbsp; Edit &nbsp;</button>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='restore("<?php echo $this->createUrl('restorePopView', array('bkid'=>$data->id)) ?>")'>Restore</button>
			</div>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadRemoved('<?php echo $this->createUrl("removedView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		</ul>
</div>