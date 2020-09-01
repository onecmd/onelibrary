<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#available" role="tab" data-toggle="tab">Available</a></li>
  <li><a href="#reserved" role="tab" data-toggle="tab">Reserved</a></li>
  <li><a href="#overdue" role="tab" data-toggle="tab">Overdue</a></li>
  <li><a href="#mybooks" role="tab" data-toggle="tab">My Books</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="available">
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
	  	<td>
	  		<div class="dropdown">
	  			<button type="button" class="btn btn-success btn-xs" onclick='reserve("<?php echo $this->createUrl('reserve', array('bkid'=>$data->id)) ?>")'>Reserve</button>
	  			<button type="button" class="btn btn-primary btn-xs" onclick='edit("<?php echo $this->createUrl('edit', array('bkid'=>$data->id)) ?>")'>&nbsp; Edit &nbsp;</button>
			  	<button class="btn btn-info dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown">
			    	Type To
			    	<span class="caret"></span>
			  	</button>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='removebk("<?php echo $this->createUrl('remove', array('bkid'=>$data->id)) ?>")'>Remove</button>
			  	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			  		<?php echo $bookTypeHtml ?>
			  	</ul>
			</div>
		</td>
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
	</div>
  	<div class="tab-pane" id="reserved">reserved</div>
  	<div class="tab-pane" id="overdue">overdue</div>
  	<div class="tab-pane" id="mybooks">mybooks</div>
</div>

<!-- Modal -->
<div class="modal fade" id="dlgmain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="dlgtitle">Modal title</h4>
      </div>
      <div class="modal-body" id="dlgbody">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script language="javascript">
	var loadimg="<img src='<?php echo Yii::app()->request->baseUrl.'/img/load2.gif' ?>'>";
	function reserve(url){
		$('#dlgtitle').html("Reserve Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function edit(url){
		$('#dlgtitle').html("Edit Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function removebk(url){
		$('#dlgtitle').html("Remove Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}

	function changeBkTypeTo(bkId, url){
		$("#bktype_"+bkId).html(loadimg);
		$("#bktype_"+bkId).load(url);
	}
</script>