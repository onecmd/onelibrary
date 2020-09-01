<div style="width:60%;float:left;">

<div class="row" style="padding:5px 30px 5px 30px;">
<div style="padding:15px 5px 15px 5px;height:50px;">
	<div style="float:left;"><b>值班预约</b></div>
	<div style="float:right;">
		<button type="button" class="btn btn-warning btn-xs" onclick='loadDutyBooking("<?php echo $this->createUrl("dutyBookingView")?>")'>刷新</button>	  			
		<?php 
		$role = RoleUtil::getUserLibraryRole();
		if(isset($role) && $role>9)
		{
		?>
		<button type="button" class="btn btn-warning btn-xs" onclick='view("<?php echo $this->createUrl('createDutyBooking1Year') ?>")'>创建预订日历</button>	  			
		<?php 
		}
		?>
	</div>
</div>
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
	  <td>日期</td>
	  <td>星期</td>
	  <td>预约者</td>

	  <td>Action</td>
	</tr>
	<?php
		$weekarray=array("日","一","二","三","四","五","六");
		
		$dutyUsersSelectStr="";
		$dutyUsersTableStr="";
		$no = 0;
		foreach($ResultDutys as $data)
		{
			$no = $no+1;
			$dutyUsersSelectStr .='<option value="'.$data["user_id"].'">'.$data["user_name"].'</option>';
			
			$dutyUsersTableStr .= '
			<tr>
			  	<td>'.$no.'</td>
			  	<td>['.$data["user_id"].'] '.$data["user_name"].'</td>
			  	<td>'.str_replace("@onelibrary.com","@...",$data["email"]).'</td>
			  	<td>'.(isset($data["total"]) ? $data["total"]:"0").'<br>
			</tr>';
		}
		
		$no = 0;
		foreach($ResultDutyBooking as $data)
		{
			$no = $no+1;
			
	?>
	
	<tr>
	  	<td><?php echo $no ?></td>
	  	<td><?php echo longDate($data["book_date"]) ?></td>
	  	<td><?php echo $weekarray[date('w', strtotime($data["book_date"]))] ?><br>
	  	<td><?php echo $data["user_name"] ?></td>
	  	<td>
	  		<div class="dropdown">
				<select id="duty_transfer_select" onchange='transferDutyTo(this, "<?php echo $this->createUrl('transferDutyTo', array('id'=>$data["id"])) ?>")'>
	  				<option selected>安排给...</option>
	  				<?php echo $dutyUsersSelectStr ?>
	  			</select> 			
	  			<?php 
	  				if(!isset($data["nsn_id"]) || empty($data["nsn_id"])){
	  			?>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='view("<?php echo $this->createUrl('bookOneDuty', array('id'=>$data["id"])) ?>")'>预约</button>	  			
	  			<?php 
	  				}
	  				else{
	  			?>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='view("<?php echo $this->createUrl('sendDutyCalendar', array('id'=>$data["id"])) ?>")'>发送会议</button>	  			
	  			<?php 		
	  				}
	  				
	  				if(isset($data["nsn_id"]) && $data["nsn_id"]==RoleUtil::getUser()->nsn_id){
	  			?>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='view("<?php echo $this->createUrl('cancelOneDuty', array('id'=>$data["id"])) ?>")'>取消</button>	  			
	  			<button type="button" class="btn btn-warning btn-xs" onclick='view("<?php echo $this->createUrl('askDutyReplace', array('id'=>$data["id"])) ?>")'>请求代值</button>	 
				<?php 
	  				}
				?>
				
			</div>
		</td>
	</tr>
	<?php 
		}
	?>
</table>
</div>
</div>
<div style="width:38%;float:right;padding:5px 20px 15px 10px;">
<div style="padding:15px 5px 15px 5px;">
	<b>本季度值班统计</b>
</div>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>管理员</td>
	  <td>Email</td>
	  <td>已值班</td>
	  	<td><br>
	</tr>
		<?php
			echo $dutyUsersTableStr;		
		?>
	
</div>