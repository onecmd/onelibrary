<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
		<div class="panel panel-default" style="margin-bottom:0px;border-width:0px;">
				<div class="panel-body" style="padding:0px 0px 0px 0px;">
					<form id="tbWaiting_form" action="<?php echo $this->createUrl("summary2years") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="book_id" class="col-sm-2 control-label" style="font-size:16px;">值班登记：</label>
							<div class="col-sm-3">
							</div>
						</div>						
						<div class="form-group">
							<label for="book_id" class="col-sm-2 control-label">值班者</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="book_id" name="Books[book_id]" placeholder="">
							</div>
							<label for="book_name" class="col-sm-2 control-label">值班小时数</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="book_name" name="Books[book_name]" placeholder="">
							</div>
						</div>						
						<div class="form-group">
							<label for="book_id" class="col-sm-2 control-label">开始时间</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="book_id" name="Books[book_id]" placeholder="">
							</div>
							<label for="book_name" class="col-sm-2 control-label">结束时间</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="book_name" name="Books[book_name]" placeholder="">
							</div>
						</div>						
						<div class="form-group">
							<label for="book_id" class="col-sm-2 control-label">备注</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="book_id" name="Books[book_id]" placeholder="">
							</div>
						</div>						
						<div class="form-group">
							<div class="col-sm-8"></div> 
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-success" value="Search"  onclick="ajaxSummary2years()">
							</div>
						</div>
					</form>
				</div>
		</div>
		
<div class="row" style="padding:5px 30px 5px 30px;">
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$page["currentPage"])) ?>')">刷新</a></li>
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
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
	  <td>用户</td>
	  <td>开始时间</td>
	  <td>结束时间</td>
	  <td>时间</td>
	  <td>备注</td>
	  <td>标记</td>
	  <td>登记人</td>
	  <td>登记时间</td>
	  <td>Action</td>
	</tr>
	<?php
		$no = $page["currentPage"]*$page["pageSize"];
		foreach($ResultDutys as $data)
		{
			$no = $no+1;
	?>
	
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><?php echo $data->user_email ?></td>
	  	<td><?php echo $data->start_time ?><br>
	  	<td><?php echo $data->end_time ?></td>
	  	<td><?php echo $data->duty_point ?></td>
	  	<td><?php echo $data->comment ?></td>
	  	<td><?php echo $data->got_gift ?></td>
	  	<td><?php echo $data->author_user_name ?></td>
	  	<td><?php echo $data->create_time ?></td>
	  	<td>
	  		<div class="dropdown">
				<?php 
				$role = RoleUtil::getUserLibraryRole();
				if(isset($role) && $role>9)
				{
				?>	  		
	  			<button type="button" class="btn btn-warning btn-xs" onclick='actionDlg("删除值班记录","<?php echo $this->createUrl('deleteDuty', array('id'=>$data["id"])) ?>")'>删除</button>	  			
	  			<?php 
				}
	  			?>
	  		<!--  
				<button type="button" class="btn btn-primary btn-xs" onclick='view("<?php echo Yii::app()->createUrl('library/edit/view', array('bkid'=>$data->id)) ?>")'>View</button>	  			
	  			<button type="button" class="btn btn-success btn-xs" onclick='edit("<?php echo Yii::app()->createUrl('library/edit/edit', array('bkid'=>$data->id)) ?>")'>&nbsp; Edit &nbsp;</button>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='restore("<?php echo $this->createUrl('restorePopView', array('bkid'=>$data->id)) ?>")'>Restore</button>
			-->
			</div>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>"0")) ?>')">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$prevPage)) ?>')">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$pageNum)) ?>')"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$nextPage)) ?>')">&raquo;</a></li>
		  	<li><a href="#" onclick="loadUserDuty('<?php echo $this->createUrl("userDutyView", array("page"=>$page["pageCount"]-1)) ?>')">&rsaquo;&iota;</a></li>
		</ul>
</div>