<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
	<?php 
		$role = RoleUtil::getUserLibraryRole();
		if(isset($role) && $role>5)
		{
	?>
		<div style="border: 0px solid #ccc; margin:20px 10px 20px 10x; padding: 20px 20px 0px 20px; ">
			<form id="tbAddScrumUser_form" action="<?php echo $this->createUrl("addScrumUser") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="user_id" class="col-sm-2 control-label">NSN ID</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="user_id" name="user_id" placeholder="" value="">
							</div>
							<label for="scrum_name" class="col-sm-2 control-label">Team Name</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="score" name="scrum_name" placeholder="" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="publisher" class="col-sm-2 control-label"> </label>
							<div class="col-sm-5">
								 <font color=red><?php echo $message ?></font>
							</div>
							<div class="col-sm-4">
								<button type="button" class="btn btn-info col-sm-8" onclick="ajaxSubmit('tbAddScrumUser_form', 'tbuserScrum_search_result')">添加</button>
							</div>
						</div>
					</form>				
		</div>
		<hr />
	<?php 
		}
	?>
		
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>User ID</td>
	  <td>User Name</td>
	  <td>Email</td>
	  <td>Team Name</td>
	  <td>Action</td>
	</tr>
	<?php
		$no = $pageSize*$page["currentPage"];
		foreach($ResultRecords as $data)
		{
			$no = $no+1;
	?>
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><?php echo $data->nsn_id ?></td>
	  	<td><?php echo $data->user_name ?></td>
	  	<td><?php echo $data->email ?></td>
	  	<td><?php echo $data->scrum_name ?></td>
	  	<td>
	  	<?php 
		  	if(isset($role) && $role>5)
			{
	  	?>
		  	<button type="button" class="btn btn-danger btn-xs" 
		  		onclick='loadUserScrum("<?php echo $this->createUrl('deleteScrumUser', array('id'=>$data->id)) ?>", true)'
		  		>&nbsp; 删除 &nbsp;</button> 
	  	<?php 
			}
	  	?>
	  	</td>
	</tr>
	<?php 
		}
	?>
</table>

		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadUserScrum('<?php echo $this->createUrl("userScrumView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		</ul>
</div>