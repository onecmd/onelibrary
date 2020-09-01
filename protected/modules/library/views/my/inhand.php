	<div class="row" style="margin-left:0px;padding:10px 10px 0px 10px;">
		<div style="width:65%;float:left;">
				<br>
				我们的域名：<font color="red"> http://cdtu.china.nsn-net.net/shu/</font>
				<br>
				我们的邮箱：<font color="red">I_CHN_CN98TU_LIBRARIANES@internal.onelibrary.com</font>
				<br><br>
				<b><font style="color:red; font-size:18px">新图书馆位置：天府新区办公区 3F 西边电梯旁。</font>
				</b>
				<div style="border: 1px solid #0088ff;margin:10px 20px 10px 0px;padding:20px 20px 55px 20px; width:500px; ">
					<font color=red><b>我的积分： <?php echo $totalScore?></b></font><br>
					<b>我的权限：  </b>
					<ul>
						<li>Team借阅者： <?php 
							$user = isset($UserModel)? $UserModel : RoleUtil::getUser();
							if($user->is_scrum_borrow_leader == 1){
								echo "Yes"." ".$user->scrum_name;
							}else{
								echo "No";
							}
						?></li>
						<li>杂志借阅：<?php 
							$mglimits = intval(SiteSystemParameters::getParmValue('BorrowMagazineLimits'));
							echo $mglimits;
						?> 本</li>
						<li>书籍借阅：<?php 
							$scrumBooklimits = intval(SiteSystemParameters::getParmValue('ScrumLeaderBorrowBookLimits'));
							if($user->is_scrum_borrow_leader == 1){
								echo $scrumBooklimits;
							}else{
								$booklimits = intval(SiteSystemParameters::getParmValue('BorrowBookLimits'));
								echo $booklimits;
							}
							
						?> 本</li>
					</ul>
					<div>
						<div style="float:left;"><b>我的位置：</b></div> 
						<input type="text" class="form-control btn-xs" id="user_seat" name="user_seat" value="<?php echo $UserModel->seat ?>" placeholder="" style="width:80px;float:left;height:25px;"> 
						<input type="button" class="form-control btn-xs btn-success "  style="width:80px;float:left;height:25px;margin-left:5px;" value="更新"  onclick="updateSeat('myInHand', '<?php echo $this->createUrl('updateUserSeat') ?>')">
						<div style="float:left;color:red;margin-left:5px;"><?php echo $message?></div> 
					</div>
				</div>
			Following are your borrowed books:<br>
			如发现所列书籍已归还或者未有列出，请在值班时间到工会图书馆核对。<br>
			
			<div class="row">
			
				<?php 
					$total = 0;
					foreach($ResultBooks as $data)
					{
						$total = $total+1;
						$totaldays = floor((time()-strtotime($data->due_date))/86400);
						$duecolor = $totaldays>0?"red":"blue";
						$fine = $data->fine_overdue_per_day * $totaldays;
						$maxfine=intval(SiteSystemParameters::getParmValue('OverDueMaxFine'));
						if($fine<0)
						{
						 	$fine="0.0";
						}
						else if($fine>$maxfine)
						{
						 	$fine=$maxfine;
						}
						 
				?>
			  <div style="width:180px;height:280px;margin-left:10px;margin-top:10px;float:left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis">
			    <div class="thumbnail">
			      <a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
			      	<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$data->book_logo ?>" style="width:96%;height:140px;" alt="...">
			      </a>
			      <div class="caption" style="padding: 2px 5px 2px 5px;">
			        <h5><a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank"><?php echo $data->book_name ?></a></h5>
			        <h5>Borrow Time: <?php echo shortDate($data->borrowed_time) ?></h5>
			        <h5>Due Time: <b><font color="<?php echo $duecolor?>"><?php echo shortDate($data->due_date) ?></font></b></h5>
			        <h5>Fine: <b><font color="red"><?php echo $fine ?></font></b></h5>
			      </div>
			    </div>
			  </div>
				<?php 
					}
					if($total<1)
						echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No books inhand.<br>";
				?>
			
			</div> <!--  end inhand row -->
			  
		</div>
		<div style="float:right;width:32%;padding-right:15px;">
			<div style="float:left;text-align:center;font-size:13px;padding-right:10px;">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/cn98tu_weixinpub.jpg" style="height: 140px;" alt="工会图书馆微信公众号">
					<br><b>关注.微信公众号</b>
			</div>
			<div style="float:left;text-align:center;font-size:13px;padding-right:10px;">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/cn98tu_alipay.jpg" style="height: 140px;" alt="工会图书馆支付宝二维码">
					<br><b>支付宝.扫码支付</b>
			</div>
			<div style="clear:both; padding: 30px 20px 20px 10px;">
			<b>Team借阅者</b><br><br>
				为促进图书馆更好的为项目服务，图书馆增加Team借阅者账号，每个研发/Scrum Team可推举其中一人申请，
				申请者一次可借阅<font color=red> <b><?php echo $scrumBooklimits ?></b></font> 本书(其中半年内新书最多2本)，供Team成员共同阅读。<br><br>
				
				<b>Team借阅者特权</b><br>
				<li>一次可借阅<font color=red> <b><?php echo $scrumBooklimits ?></b></font> 本书</li>
				<li>书籍提前归还可同样获得积分奖励</li>
				<br>
				
				<b>Team借阅者职责</b><br>
				<li>借阅的书籍供Team成员共同阅读</li>
				<li>负责所借书籍的管理、按时归还、缴纳罚金</li>
				<br>
				
				申请Team借阅者请发邮件或Jabber给bihong.he@onelibrary.com或hebihong@163.com， 邮件中告知申请者员工号、Team名称、Team Leader等信息
				<br />
				<a href="mailto:bihong.he@onelibrary.com；hebihong@163.com" class="btn btn-success">&nbsp;我要申请 &nbsp;</a> 
					  	
			</div>
		</div>
</div>
<div class="row" >
	<hr>
	<div style="width:85%;float:left; padding-left:20px;">
				<div >
				   下面为您需要缴纳的超期归还书籍的罚款：
				   <br><br>
					<b>超期罚款现金缴纳步骤：</b>
					<ol>
						<li>手机支付宝扫一扫上面工会图书馆支付宝二维码（支付宝账号：18780258675， 账号名：CN98工会图书馆）；</li>
						<li>填写罚款缴纳金额；</li>
						<li>在付款备注上<font color=red>填写下表中对应的<b>支付码</b>(Pay Number</font>, 用于识别支付哪一笔罚款)；</li>
						<li>支付罚款，支付完成后点击下面"<font color=red><b>已付现金</b></font>"按钮通知图书馆财务；</li>
						<li>如果没有备注支付码，或者缴纳后两天内发现罚款状态未更新，可发邮件给图书馆财务hebihong@163.com，并抄送给bihong.he@onelibrary.com；</li>
					</ol>
				</div>
				<font color=red><?php echo $message ?></font>
				<table class="table table-condensed table-hover table-striped">
					<tr class="info">
					  <td>Book Name</td>
					  <td>Borrow Date</td>
					  <td>Return Date</td>
					  <td>Over Due</td>
					  <td>Total Fine</td>
					  <td>Pay Number</td>
					  <td>Action</td>
					</tr>
					<?php
					if(isset($ResultFineList)){
						foreach($ResultFineList as $data)
						{
							
							$totaldays = floor((strtotime($data->actual_return_time)-strtotime($data->return_time))/86400);
							$totaldays = $totaldays<1?0:"<font color='red'>".$totaldays."</font>";
							?>
					<tr>
					  	<td><a href="<?php echo Yii::app()->createUrl("library/search/viewfull",array("bkid"=>$data->book_id)) ?>" target="_blank"><?php echo $data->book_name ?></a></td>
					  	<td><?php echo shortDate($data->borrow_time) ?></td>
					  	<td><?php echo $data->is_return==1?shortDate($data->actual_return_time) : ""  ?></td>
					  	<td><?php echo $totaldays ?> Days</td>
					  	<td><?php 
					  		if($data->overdue_fine>0){
						  		if($data->fine_is_paid > 0){
						  			echo "<font color='green'> ￥".number_format($data->overdue_fine, 2)." </font>";
						  		}
						  		else{
						  			echo "<font color='red'> ￥".number_format($data->overdue_fine, 2)." </font>";
						  		}
					  		} else {
					  			echo "￥0.00";
					  		}
					  	?></td>
					  	<td>
					  		<?php 
							if($data->overdue_fine>0){
						  		if($data->fine_is_paid == 1){
						  			echo "已支付";
						  		}
						  		else{
						  			echo "<font color='red'> ".$data->pay_password." </font>";
						  		}
					  		} else {
					  			echo "";
					  		}
					  		?>
					  	</td>
					  	<td>
					  		<?php 
					  		if($data->fine_is_paid == 0){
					  		?>
					  			<button type="button" class="btn btn-success btn-xs" onclick='refreshPage("myInHand", "<?php echo $this->createUrl('notifyPaid', array('id'=>$data->id)) ?>", true)'>&nbsp; 已付现金 &nbsp;</button> 
					  		<?php 
					  			$needScore = $data->overdue_fine*100;
					  			if($totalScore >= $needScore ){
					  	?>
					  			<button type="button" class="btn btn-danger btn-xs" onclick='refreshPage("myInHand", "<?php echo $this->createUrl('payByScore', array('id'=>$data->id)) ?>", true)'>&nbsp;<?php echo $needScore ?> 积分支付 &nbsp;</button> 
					  	<?php 
					  			}
					  		}
								else if($data->fine_is_paid == 2){
						  			echo "<font color='green'>"."已通知财务，请等待确认 </font>";
						  		}
					  		?>
					  	</td>
					</tr>
					<?php 
						} // end foreach
					} // end if isset
					?>
				</table>
	</div>
	
	<div style="float:right;width:10%;padding-right:15px;">
	</div>
</div>
