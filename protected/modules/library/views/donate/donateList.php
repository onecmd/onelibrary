<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
	<table class="table table-condensed table-hover table-striped">
		<tr class="info">
		  <td>No</td>
		  <td>Book Name</td>
		  <td>Donator</td>
		  <td>Donate Time</td>
		  <td>Win Present</td>
		  <td>Present Received</td>
		  <td>Action</td>
		</tr>
		<?php
			$no = $pageSize*$page["currentPage"];
			foreach($ResultBooks as $data)
			{
				$no = $no+1;
		?>
		<tr>
		  	<td><?php echo $no ?></td>
		  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->book_id)) ?>" target="_blank"><?php echo $data->book_name ?></a></td>
		  	<td><?php echo $data->user_name."(".$data->user_email.")" ?></td>
		  	<td><?php echo cutDate($data->donate_time) ?></td>
		  	<td><?php echo $data->present ?></td>
		  	<td><?php echo $data->present_status==0?"" : "Yes" ?></td>
		  	<td>
		  	<?php 
					if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
					{
				?>
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("deleteById",array("id"=>$data->id)) ?>")' role="button" class="btn btn-danger btn-xs">
					 &nbsp; Delete &nbsp;
				</a>
				<?php 						
					if($data->present_status==0){
				?>
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("receivePresent",array("id"=>$data->id, 'status'=>1)) ?>")' role="button" class="btn btn-warning  btn-xs">
					 &nbsp; Present Received &nbsp;
				</a>
				<?php 
						}
						else{
				?>
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("receivePresent",array("id"=>$data->id, 'status'=>0)) ?>")' role="button" class="btn btn-warning btn-xs">
					 &nbsp; Not Received &nbsp;
				</a>
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
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPager('<?php echo $this->createUrl("donateList", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
</div>