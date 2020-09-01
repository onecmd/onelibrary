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
			<form id="tbAddScore_form" action="<?php echo $this->createUrl("addScore") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="user_id" class="col-sm-2 control-label">NSN ID</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="user_id" name="UsersScoreHistory[user_id]" placeholder="" value="">
							</div>
							<label for="score" class="col-sm-4 control-label">积分（加积分填正数，减积分填负数）</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="score" name="UsersScoreHistory[score]" placeholder="" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="action" class="col-sm-2 control-label">积分变动事由</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="action" name="UsersScoreHistory[action]" placeholder="" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="publisher" class="col-sm-2 control-label"> </label>
							<div class="col-sm-4">
								 <font color=red><?php echo $message ?></font>
							</div>
							<label for="stock_total" class="col-sm-2 control-label"> </label>
							<div class="col-sm-4">
								<button type="button" class="btn btn-info col-sm-8" onclick="ajaxSubmit('tbAddScore_form', 'tbuserScore_search_result')">添加</button>
								<input type="hidden" id="page" name="page" value="0">
							</div>
						</div>
					</form>				
		</div>
		<hr />
	<?php 
		}
	?>
		<div class="panel panel-default" style="margin-bottom:0px;border-width:0px;">
				<div class="panel-body" style="padding:0px 0px 0px 0px;">
					<form id="tbScore_form" action="<?php echo $this->createUrl("userScoreView") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="user_id" class="col-sm-2 control-label">User ID</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="user_id" name="user_id" placeholder="">
							</div>
							<label for="user_email" class="col-sm-1 control-label">Email</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="user_email" name="user_email" placeholder="">
							</div>
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-success" value="Search"  onclick="ajaxSubmit('tbScore_form', 'tbuserScore_search_result')">
							</div>
						</div>
					</form>
				</div>
		</div>
		
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
	</ul>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>User ID</td>
	  <td>Email</td>
	  <td>积分变动事由</td>
	  <td>积分</td>
	  <td>执行者</td>
	  <td>时间</td>
	</tr>
	<?php
		$no = $pageSize*$page["currentPage"];
		foreach($ResultRecords as $data)
		{
			$no = $no+1;
	?>
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><?php echo $data->user_id ?></td>
	  	<td><?php echo $data->user_email ?></td>
	  	<td><?php echo $data->action ?></td>
	  	<td><?php echo $data->scores ?></td>
	  	<td><?php echo $data->supplier ?></td>
	  	<td><?php echo $data->add_time ?></td>
	</tr>
	<?php 
		}
	?>
</table>

		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadUserScore('<?php echo $this->createUrl("userScoreView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		</ul>
</div>