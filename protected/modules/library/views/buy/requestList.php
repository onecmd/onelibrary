<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<div class="row" style="padding:5px 30px 5px 30px;">
<div class="panel-body" style="padding:0px 0px 0px 0px;">
			<div style="width:82%;float:left;">
					<form id="tblist_form" action="<?php echo $this->createUrl("requestList") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<label for="book_name" class="col-sm-2 control-label">Book Name</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="book_name" name="BooksBuyRequest[book_name]" placeholder="" value="<?php echo isset($_POST["BooksBuyRequest"])? $_POST["BooksBuyRequest"]["book_name"] : "" ?>">
							</div>
							<label for="book_id" class="col-sm-2 control-label">Requester Email</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="book_id" name="BooksBuyRequest[user_email]" placeholder="" value="<?php echo isset($_POST["BooksBuyRequest"])?$_POST["BooksBuyRequest"]["user_email"] : "" ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="book_id" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-4">
								<select class="form-control" id="status" name="BooksBuyRequest[status]">
									<?php // status:0-requring;1-buying;2-buyed;3-cancel,closed,reject ?>
									<option value="10" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["status"]=="10" ? "selected":"" ?>>All</option>
									<option value="0" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["status"]=="0" ? "selected":"" ?>>Requring</option>
									<option value="1" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["status"]=="1" ? "selected":"" ?>>Buying</option>
									<option value="2" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["status"]=="2" ? "selected":"" ?>>Buyed</option>
									<option value="3" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["status"]=="3" ? "selected":"" ?>>Cancelled And Rejected</option>

								</select>
							</div>
							<label for="book_name" class="col-sm-2 control-label">Order By</label>
							<div class="col-sm-4">
								<select class="form-control" id="status" name="BooksBuyRequest[order_by]">
									<option value="10" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="10" ? "selected":"" ?>>All</option>
									<option value="0" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="0" ? "selected":"" ?>>Request Time</option>
									<option value="1" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="1" ? "selected":"" ?>>Request Time Desc</option>
									<option value="2" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="2" ? "selected":"" ?>>Buy Time</option>
									<option value="3" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="3" ? "selected":"" ?>>Buy Time Desc</option>
									<option value="4" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="4" ? "selected":"" ?>>Vote Number</option>
									<option value="5" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="5" ? "selected":"" ?>>Buy Url</option>
									<option value="6" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="6" ? "selected":"" ?>>Book Name</option>
									<option value="7" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="7" ? "selected":"" ?>>User Name</option>
									<option value="8" <?php echo isset($_POST["BooksBuyRequest"])&&$_POST["BooksBuyRequest"]["order_by"]=="8" ? "selected":"" ?>>Status</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="publisher" class="col-sm-2 control-label"> </label>
							<div class="col-sm-4">
								 
							</div>
							<label for="stock_total" class="col-sm-2 control-label"> </label>
							<div class="col-sm-4">
								<button type="button" class="btn btn-info col-sm-8" onclick="ajaxSubmit('tblist_form', 'requestList')">Search</button>
								<input type="hidden" id="page" name="page" value="0">
							</div>
						</div>
					</form>
			</div>
</div>
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a id="resreshRequestList" href="#" onclick="loadPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $prevPage ?>)">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadPage(<?php echo $nextPage ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
	<table class="table table-condensed table-hover table-striped">
		<tr class="info">
		  <td>No</td>
		  <td>Book Name</td>
		  <td>Request By</td>
		  <td>Request Time</td>
		  <td>Reason</td>  
		  <td>Vote</td>
		  <td>Status</td>
		  <td>Buy Time</td>
		  <td>Buy List</td>
		  <td>Comments</td>
		  <td>Action</td>
		</tr>
		<?php
			$no = $pageSize*$page["currentPage"];
			foreach($ResultBooks as $data)
			{
				$no = $no+1;
				$email="";
				if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
				{
					$email="<br>(".$data->user_email.")";
				}
				$bookUrl = Yii::app()->createUrl("library/search/list",array("Books[book_name]"=>$data->book_name, "view"=>"full"));
				$buyUrl ="";
				if(isset($data->book_url) && "" != $data->book_url){
					$buyUrl = '[<a href="'.$data->book_url.'" target="_blank"><font color="#FF5809">网址</font></a>]'; 
				}
				//if(!isset($data->book_url) && $data->status == 0){
				//	$bookUrl = $data->book_url;
				//}
		?>
		<tr>
		  	<td><?php echo $no ?></td>
		  	<td><a href="<?php echo $bookUrl ?>" target="_blank"><?php echo $data->book_name ?></a><?php echo $buyUrl?></td>
		  	<td style="color: #444444"><?php echo $data->user_name.$email ?></td>
		  	<td style="color: #444444"><?php echo cutDate($data->request_time) ?></td>
		  	<td><?php echo $data->request_reason ?></td>
		  	<td style="color: #444444"><?php echo $data->vote ?></td>
		  	<td><?php echo $this->getStatusStr($data->status) ?></td>
		  	<td style="color: #0066FF "><?php echo $data->status==2?longDate($data->buy_time):"" ?></td>
		  	<td><?php 
		  		if($data->buy_list_id != ""){
		  			$jsurl='showDlg("'.$this->createUrl("buyListDetail",array("id"=>$data->buy_list_id)).'","'.$data->buy_list_name.' -- 书籍列表")';
		  			echo "<a style='cursor:pointer;' onclick='".$jsurl."' >".$data->buy_list_name."</a>";
		  		}
		  	?></td>
		  	<td>
		  		<?php
					if( $data->price_buyed > 0 ){
		  				echo "￥<font color=red><b>".$data->price_buyed."</b></font> ";
		  			}
					else if( $data->price_discount > 0 ){
		  				echo "￥<font color=red><b>".$data->price_discount."</b></font> ";
		  			}
		  			
		  			if( $data->price_origin > 0 ){
		  				echo "<font color='#666'><del>[".$data->price_origin."]</del></font>";
		  			}
		  			?>
		  		<?php echo "<br>".$data->comments ?>
		  	</td>
			<td>
				<?php 
				// status:0-requring;1-buying;2-buyed;3-cancel,closed,reject
					if(RoleUtil::getUser()->nsn_id!=$data->user_id && $data->status==0)
					{
				?>				
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("vote",array("id"=>$data->id)) ?>")' role="button" class="btn btn-success btn-xs">
					 &nbsp; I Vote &nbsp;
				</a>
				<?php 
					}
					if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
					{
						if($data->status==0 || $data->status==1 || $data->status==2){
				?>
				<a href="#" onclick='showDlg("<?php echo $this->createUrl("showEditBuyRequest",array("id"=>$data->id)) ?>", "编辑心愿书单", false)' role="button" class="btn btn-info  btn-xs">
					 &nbsp; Edit &nbsp;
				</a>
				<?php 
							
						}
						if($data->status==1 || $data->status==3){
				?>
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("requiring",array("id"=>$data->id)) ?>")' role="button" class="btn btn-success  btn-xs">
					 &nbsp; Requiring &nbsp;
				</a>
				<?php 
						}
						if($data->status==0 || $data->status==3){
				?>
				<div class="dropdown">
				  <button id="dLabel" type="button" class="btn btn-warning  btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Accept
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" aria-labelledby="dLabel">
				    <li>&nbsp; 选择采购目标清单：</li>
				    <?php 
				    foreach($ResultBuyList as $buyList)
					{
					?>
					<li><a style="cursor:pointer;" onclick='loadAndRefresh("<?php echo $this->createUrl("changeToBuyList", array("id"=>$data->id, "buyListId"=>$buyList->id)) ?>", "resreshRequestList")'><?php echo $buyList->list_name ?></a></li>
					<?php 	
					}
				    ?>
				  </ul>
				</div>
				<?php 
						}
						else {
				?>
				<div class="dropdown">
				  <button id="dLabel" type="button" class="btn btn-warning  btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    采购计划
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" aria-labelledby="dLabel">
				    <li>&nbsp; 选择采购目标清单：</li>
				    <?php 
				    foreach($ResultBuyList as $buyList)
					{
					?>
					<li><a style="cursor:pointer;" onclick='loadAndRefresh("<?php echo $this->createUrl("updateBuyList", array("id"=>$data->id, "buyListId"=>$buyList->id)) ?>", "resreshRequestList")'><?php echo $buyList->list_name ?></a></li>
					<?php 	
					}
				    ?>
				  </ul>
				</div>
				<?php 
						}
						if($data->status==0 || $data->status==1  || $data->status==3){
				?>
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("buyed",array("id"=>$data->id)) ?>")' role="button" class="btn btn-success btn-xs">
					 &nbsp; Buyed &nbsp;
				</a>
				<?php 
						}
						if($data->status!=3){
				?>
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("cancel",array("id"=>$data->id)) ?>")' role="button" class="btn btn-danger btn-xs">
					 &nbsp; Cancel &nbsp;
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
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $prevPage ?>)">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadPage(<?php echo $nextPage ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
</div>