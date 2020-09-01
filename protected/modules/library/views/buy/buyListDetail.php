
<div class="row" style="padding:5px 30px 5px 30px;">

	<form id="tblist_form" action="<?php echo $this->createUrl("buyListDetail") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
	<div class="row">	
		<div class="col-sm-12 ">		
			<?php
				$no = 0;
				$bookType="";
				$totalOrigin = 0;
				$totalDiscount = 0;
						
				$totalAllOrigin = 0;
				$totalAllDiscount = 0;
				$totalAllBuyed = 0;
				
				$newTypeIsStart = false;
				foreach($ResultBooksInList as $data)
				{
					$no = $no+1;
					$email="";
					if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
					{
						$email="<br>(".$data->user_email.")";
					}
					$bookUrl = Yii::app()->createUrl("library/search/list",array("Books[book_name]"=>$data->book_name, "view"=>"full"));
					if(isset($data->book_url)){
						$buyUrl = '[<a href="'.$data->book_url.'" target="_blank"><font color="#FF5809">网址</font></a>]'; 
					}
					
					if($data->book_type==""){
						$data->book_type="未知类别";
						$bookType=$data->book_type;
					}
										
					if(!$newTypeIsStart){
						$newTypeIsStart = true;
						$bookType=$data->book_type;
					?>
						<b><?php echo $data->book_type ?></b>
						<table class="table table-condensed table-hover table-striped">
						<tr class="info">
						  <td>No</td>
						  <td>Book Name</td>
						  <td>Vote</td>
						  <td>Prices</td>
						  <td>Status</td>
						  <td>Action</td>
						</tr>
					<?php 
					}
					
					//if(!isset($data->book_url) && $data->status == 0){
					//	$bookUrl = $data->book_url;
					//}
					
					//$newBookType=false;
					if($bookType != $data->book_type){ // new type start:
						$newTypeIsStart = false;
						// write end:
					?>
						<tr>
							<td colspan=6 align=right>
							<?php echo $bookType."类 合计：￥<font color=red>".$totalDiscount."</font> <font color='#666'><del>[".$totalOrigin."]</del></font>" ?>
							
							</td>	
						</tr>	
					</table>
				<?php 	
							$totalOrigin = 0;
							$totalDiscount = 0;
						//}
					
					if(!$newTypeIsStart){
						$newTypeIsStart = true;
					?>
						<b><?php echo $data->book_type ?></b>
						<table class="table table-condensed table-hover table-striped">
						<tr class="info">
						  <td>No</td>
						  <td>Book Name</td>
						  <td>Vote</td>
						  <td>Prices</td>
						  <td>Status</td>
						  <td>Action</td>
						</tr>
					<?php 
					}
							
						// new type start:
						$bookType=$data->book_type;
						$typeIsWrite = false;
					?>
					<?php 
						//echo "<tr><td colspan=6><b>".$data->book_type."<b></td></tr>";
					} // end if($bookType != $data->book_type)
					
						$totalOrigin += $data->price_origin;
						$totalDiscount += $data->price_discount;
						
						$totalAllOrigin += $data->price_origin;
						$totalAllDiscount += $data->price_discount;
					
						if($data->status == 2 ){ // buyed:
							$totalAllBuyed += $data->price_discount;
						}
			?>
			<tr>
			  	<td><?php echo $no ?></td>
			  	<td><a href="<?php echo $bookUrl ?>" target="_blank"><?php echo $data->book_name ?></a><?php echo $buyUrl?></td>
			  	<!--  <td style="color: #444444"><?php echo $data->user_name ?></td>
			  	<td style="color: #444444"><?php echo cutDate($data->request_time) ?></td>-->
			  	<td style="color: #444444"><?php echo $data->vote ?></td>
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
			  		<?php //echo $data->comments ?>
			  	</td>
			  	<td><?php echo $this->getStatusStr($data->status) ?></td>
			  	<td align="right">
			  		<?php 
			  		if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Finance"]-1)
			  		{
			  			if($data->status != 2 && RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Finance"]-1)
			  			{
			  		?>
					
					<button type="button" style="float:right;margin-left:5px;" class="btn btn-danger btn-xs" onclick='showDlg("<?php echo $this->createUrl("changeBuyRequestStatus",array("id"=>$data->id, "status"=>0)) ?>", "书籍列表")'>取消</button>
			  		<button type="button" style="float:right;margin-left:5px;" class="btn btn-warning btn-xs" onclick='showDlg("<?php echo $this->createUrl("changeBuyRequestStatus",array("id"=>$data->id, "status"=>2)) ?>", "书籍列表")'>已购买</button>

					<button type="button" style="float:right;margin-left:5px;" class="btn btn-success btn-xs" onclick='showDlg("<?php echo $this->createUrl("showEditBuyRequest",array("id"=>$data->id)) ?>", "编辑心愿书单")'>修改</button>
					
			  		<?php
			  			}
			  		?>
					
					<div class="dropdown" style="float:right;margin-left:5px;">
						 <button id="dLabel" type="button" class="btn btn-info  btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    类别
						    <span class="caret"></span>
						 </button>
						 <ul class="dropdown-menu" aria-labelledby="dLabel">
						    <li>&nbsp; 选择修改类别：</li>
					    	<li><a style="cursor:pointer;" onclick='showDlg("<?php echo $this->createUrl("changeBuyRequestType",array("id"=>$data->id, "book_type"=>"1.技术与项目")) ?>", "<?php echo $ResultBuyList->list_name ?> -- 书籍列表")'>1.技术与项目</a></li>
					    	<li><a style="cursor:pointer;" onclick='showDlg("<?php echo $this->createUrl("changeBuyRequestType",array("id"=>$data->id, "book_type"=>"2.育儿与教育")) ?>", "<?php echo $ResultBuyList->list_name ?> -- 书籍列表")'>2.育儿与教育</a></li>
					    	<li><a style="cursor:pointer;" onclick='showDlg("<?php echo $this->createUrl("changeBuyRequestType",array("id"=>$data->id, "book_type"=>"3.文学与励志")) ?>", "<?php echo $ResultBuyList->list_name ?> -- 书籍列表")'>3.文学与励志</a></li>
					    	<li><a style="cursor:pointer;" onclick='showDlg("<?php echo $this->createUrl("changeBuyRequestType",array("id"=>$data->id, "book_type"=>"4.其它（美食、体育、旅游...）")) ?>", "<?php echo $ResultBuyList->list_name ?> -- 书籍列表")'>4.其它（美食、体育、旅游...）</a></li>
						</ul>
					</div>
			  		
			  		<?php  
			  		}
			  		?>
			  	</td>
			</tr>
			<?php 
				} // end foreach
			?>
				<tr>
					<td colspan=6 align=right>
							<?php echo $bookType."类 合计：￥<font color=red>".$totalDiscount."</font> <font color='#666'><del>[".$totalOrigin."]</del></font>" ?>
					</td>	
				</tr>
				<tr><td colspan=6></td></tr>	
				<tr>
					<td colspan=6 align=right style="padding:10px 25px 10px 5px;"><b>
					总预算：￥ <font color=red><?php echo $ResultBuyList->budget ?></font>,&nbsp;&nbsp; 
					总价：￥<font color=red><?php echo $totalAllDiscount ?></font> 
					<font color='#666'><del>[<?php echo $totalAllOrigin ?>]</del></font>,&nbsp;&nbsp; 
					已购：￥ <font color=red><?php echo $totalAllBuyed ?></font>
					（还可采购： ￥<font color=green><?php echo ($ResultBuyList->budget - $totalAllBuyed) ?></font>）
					</b></td>	
				</tr>	
		</table>	
		<br><br>
		</div>
	
	</div>
	
	<div class="panel-body" style="padding:0px 0px 0px 0px;">
			<div style="width:82%;float:left;">
					
			</div>
	</div>
</div>