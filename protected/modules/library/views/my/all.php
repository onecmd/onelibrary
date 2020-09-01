<br>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadNotFin(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
			<?php 
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadNotFin(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
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
	  <td>Tags</td>
	  <td>Status</td>
	  <td>Holder</td>
	  <td>Return Time</td>
	  <td>Action</td>
	</tr>
	<?php
		foreach($ResultBooks as $data)
		{
			$returndate = $this->parseReturnDate($data->return_time);
			$bookTypeHtml=$this->getBookTypeHtml($BookTypeArray, $data->id);
			?>
	
	<tr>
	  	<td><?php echo $data->id ?></td>
	  	<td><img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$data->book_logo ?>" border="0" height="80" /></td>
	  	<td><?php echo $data->book_name ?></td>
	  	<td><?php echo $data->book_id ?><br>
	  	<td><div id="bktype_<?php echo $data->id ?>"><?php echo $BookTypeArray[$data->book_type] ?></div></td>
	  	<td><?php echo $data->owner_team ?></td>
	  	<td><?php echo $data->tags ?></td>
	  	<td><?php echo $this->parseBookStatus($data->status) ?></td>
	  	<td><?php echo $data->holder_nsn_id ?></td>
	  	<td><?php echo $returndate ?></td>
	  	<td><button type="button" class="btn btn-success btn-xs" onclick='comment("<?php echo $this->createUrl('comment', array('bkid'=>$data->id)) ?>")'>Comment </button></td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadNotFin(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
			<?php 
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadNotFin(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadNotFin(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
		</ul>