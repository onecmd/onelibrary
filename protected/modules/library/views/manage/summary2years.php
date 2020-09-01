<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
		<div class="panel panel-default" style="margin-bottom:0px;border-width:0px;">
				<div class="panel-body" style="padding:0px 0px 0px 0px;">
					<form id="tbWaiting_form" action="<?php echo $this->createUrl("summary2years") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="holder_nsn_id" class="col-sm-2 control-label"></label>
							<label for="book_name" class="col-sm-2 control-label">Book Name:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="book_name" name="book_name" value="<?php echo isset($_REQUEST['book_name'])?$_REQUEST['book_name']:'' ?>" placeholder="">
							</div>
							<div class="col-sm-2"><?php //echo count($ResultWaitings) ?>
							</div> 
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-success" value="Search"  onclick="ajaxSummary2years()">
							</div>
						</div>
					</form>
				</div>
		</div>
		
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>Book Name</td>
	  <td>Status</td>
	  <td>2016</td>
	  <td>2017</td>
	  <td>2018</td>
	  <td>2019</td>
	  <td>From 2016</td>
	  <td>Action</td>
	</tr>
	<?php
		$no = $pageSize*$page["currentPage"];
		foreach($ResultWaitings as $data)
		{
			$no = $no+1;
			
			$freeStatus= $data["status"] == 3?"Free Borrow" : "In Library";
	?>
	<tr>
	  	<td><?php echo $no ?><?php// echo var_dump($data) ?></td>
	  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data["id"])) ?>" target="_blank"><?php echo $data["book_name"] ?></a></td>
	  	<td><?php echo $freeStatus ?></td>
	  	<td><?php echo $data["total_2016"] ?></td>
	  	<td><?php echo $data["total_2017"] ?></td>
	  	<td><?php echo $data["total_2018"] ?></td>
	  	<td><?php echo $data["total_2019"] ?></td>
	  	<td><?php echo $data["total_from_2016"] ?></td>
		<td>
			<?php 
				if($data["status"]==3){
			?>
			<a href="#" onclick='loadSummary2years("<?php echo Yii::app()->createUrl("library/manage/setBookInLibrary",array("id"=>$data["id"], "page"=>$page["currentPage"], "book_name"=>$_REQUEST["book_name"])) ?>")' role="button" class="btn btn-success btn-xs">
				 &nbsp; Restore &nbsp;
			</a>
			<?php 
				} else {
			?>
			<a href="#" onclick='loadSummary2years("<?php echo Yii::app()->createUrl("library/manage/setBookToFreeBorrow",array("id"=>$data["id"], "page"=>$page["currentPage"], "book_name"=>$_REQUEST["book_name"])) ?>")' role="button" class="btn btn-warning btn-xs">
				 &nbsp; Free Borrow &nbsp;
			</a>
			<?php 
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
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadSummary2years('<?php echo $this->createUrl("summary2years", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
</div>