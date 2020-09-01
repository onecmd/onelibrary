<?php 
	$prevPage = $page["currentPage"]<1?0:$page["currentPage"]-1;
	$nextPage = $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1;
?>
<script>
<?php 
	echo "currrentPage=".$page["currentPage"].";";
?>
</script>
<div class="row" style="padding:5px 30px 5px 30px;">
<div class="panel-body" style="padding:0px 0px 0px 0px;">
			<div style="width:82%;float:left;">
					<form id="tbbuylist_form" action="<?php echo $this->createUrl("buyList") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">

						<div class="form-group">
							<div class="col-sm-8">
								<b>书籍采购角色划分：</b>
								 <ol>
								 	<li><b>采购计划</b>：图书馆会根据工会上级组织的拨款情况"创建采购计划"，填写预算等信息；</li>
								 	<li><b>书单收集者</b>：从工会会员和网络收集本次意愿采购的书单，填写书籍网购真实地址、价格信息，再"Accept"到本次的采购计划中；</li>
								 	<li><b>采购确认者</b>:对书单收集者收集的所有书单，根据预算和计划筛选出最终购买的书单，将本次不采购的从采购计划中取消；</li>
								 	<li><b>采购实施者</b>：财务人员点击书籍列表中书籍的网址逐个加入购物车，付款采购，将采购的标记为已购买；当所有书籍采购完成，标记采购计划为完成，采购计划信息将不可再更改；</li>
								 </ol>
								 <b>步骤：</b>创建采购计划-->书单收集者收集书单-->确认最终采购书单-->财务人员下单采购；
							</div>
							<label for="stock_total" class="col-sm-1 control-label"> </label>
							<div class="col-sm-3">
								<?php 
								if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Finance"]-1)
								{
								?>
								<button type="button" class="btn btn-info col-sm-12" onclick='showDlg("<?php echo $this->createUrl('showCreateBuyListDlg') ?>", "创建采购计划")'>创建采购计划</button>
								<input type="hidden" id="buylistpage" name="page" value="0">
								<?php 
								}
								?>
							</div>
						</div>
					</form>
			</div>
</div>
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a id="resreshBuyList" href="#" onclick="loadBuyListPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadBuyListPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $prevPage ?>)">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadBuyListPage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $nextPage ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
	<table class="table table-condensed table-hover table-striped">
		<tr class="info">
		  <td>No</td>
		  <td>标题</td>
		  <td>书籍总数</td>
		  <td>预算(￥)</td>
		  <td>实际支出(￥)</td>  
		  <td>负责人</td>
		  <td>状态</td>
		  <td>开始时间</td>
		  <td>完成时间</td>
		  <td>Action</td>
		</tr>
		<?php
			$no = $pageSize*$page["currentPage"];
			foreach($ResultBooks as $data)
			{
				$no = $no+1;
				//$bookUrl = Yii::app()->createUrl("library/search/list",array("Books[book_name]"=>$data->book_name));
				//$buyUrl = $data->book_url;
				//if(!isset($data->book_url) && $data->status == 0){
				//	$bookUrl = $data->book_url;
				//}
		?>
		<tr>
		  	<td><?php echo $no ?></td>
		  	<td style="color: #444444"><?php echo $data->list_name ?></td>
		  	<td>
			<?php 
				if( "" == $data->request_ids){
					echo "0";
				}
				else{
					echo "".count(explode(',', $data->request_ids));
				}
			?>
			</td>
		  	<td style="color: #444444"><?php echo $data->budget ?></td>
		  	<td><?php echo $data->paid_account ?></td>
		  	<td style="color: #444444">
		  		采购：<?php echo $data->buyer_names ?><br>
		  		财务：<?php echo $data->approves_names ?>
		  	</td>
		  	<td>
		  	<?php 
		  		//状态：0选购中；1采购中；2已采购;3已删除
		  		if($data->status < 1){
		  			echo "<font color='orange'>收集书单</font>";
		  		}
		  		else if($data->status == 1){
		  			echo "<font color='red'>正在采购</font>";
		  		}
		  		else if($data->status == 2){
		  			echo "<font color='green'>采购完成</font>";
		  		}
		  		else if($data->status > 2){
		  			echo "<font color='green'>已取消</font>";
		  		}
		  		?>
		  	</td>
		  	<td style="color: #0066FF "><?php echo longDate($data->start_time) ?></td>
		  	<td style="color: #444444">
		  	<?php 
		  		if($data->status >= 2){
		  			echo "".longDate($data->finished_time);
		  		}
		  		else{
		  			echo "<font color='green'>正在进行</font>";
		  		}
		  	 ?>
		  	</td>

			<td>
				<button type="button" class="btn btn-info btn-xs" onclick='showDlg("<?php 
					echo $this->createUrl('buyListDetail', array("id"=>$data->id) ) 
				?>", "<?php echo $data->list_name?> -- 书籍列表")'>书籍列表</button>
				<?php 
				/*
				// status:0-requring;1-buying;2-buyed;3-cancel,closed,reject
					if(RoleUtil::getUser()->nsn_id!=$data->user_id && $data->status==0)
					{
				//?>				
				<a href="#" onclick='loadPager("<?php echo $this->createUrl("vote",array("id"=>$data->id)) ?>")' role="button" class="btn btn-success btn-xs">
					 I Vote
				</a>
				//<?php 
					} */
					if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
					{
						if($data->status<2){
				?>
				<button type="button" class="btn btn-success btn-xs" onclick='showDlg("<?php 
					echo $this->createUrl('showEditBuyListDlg', array("id"=>$data->id) ) 
				?>", "修改采购计划")'>修改</button>
				<?php 
						//}else{
				?>
				<button type="button" class="btn btn-warning btn-xs" onclick='confirmLoad("<?php echo $this->createUrl("changeBuyListStatus", array("id"=>$data->id, "status"=>2)) ?>","resreshBuyList")'>完成</button>
				<button type="button" class="btn btn-danger btn-xs" onclick='confirmLoad("<?php echo $this->createUrl("changeBuyListStatus", array("id"=>$data->id, "status"=>3)) ?>","resreshBuyList")'>取消</button>
				<?php 		
						}
						else if($data->status==3 && RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["SuperAdmin"]-1){
				?>
				<button type="button" class="btn btn-danger btn-xs" onclick='confirmLoad("<?php echo $this->createUrl("changeBuyListStatus", array("id"=>$data->id, "status"=>1)) ?>","resreshBuyList")'>恢复</button>
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
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadBuyListPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $prevPage ?>)">&laquo;</a></li>
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
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $nextPage ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadBuyListPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
</div>