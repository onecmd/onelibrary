
<div style="float:left; width:65%; margin-left:10px;">
	<div style="margin:15px 20px 10px 0px;">
		<font color=red><b>我的积分：<?php echo $totalScore ?></b></font>
	</div>
	积分历史
	<hr style="margin:5px 0px 5px 0px; padding-top:0px 0px 0px 0px">
	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadScorePage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
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
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadScorePage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
	</ul>
<table class="table table-condensed table-hover table-striped">
	<tr class="info">
	  <td>No</td>
	  <td>主题</td>
	  <td>积分</td>
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
	  	<td><?php echo $data->action ?></td>
	  	<td><?php echo $data->scores ?></td>
	  	<td><?php echo $data->add_time ?></td>
	</tr>
	<?php 
		}
	?>
</table>
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadScorePage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
			<?php 
				for($pageNum=0; $pageNum<$page["pageCount"]; $pageNum++)
				{
					$pgclass="";
					if($pageNum == $page["currentPage"])
					{
						$pgclass='class="active"';
					}
			?>
		  	<li <?php echo $pgclass ?>><a href="#" onclick="loadScorePage(<?php echo $pageNum ?>)"><?php echo $pageNum+1 ?><span class="sr-only">(current)</span></a></li>
		  	<?php 
		  		}
		  	?>
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadScorePage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
		</ul>
</div>

<div style="float:right; width:30%; margin:5px auto 5px auto; padding: 15px 20px 5px 20px;">
					<b>积分价值：</b>
					<ol>
						<li>10 积分价值 0.1 元；</li>
					</ol>		
					<br><b>积分用途：</b>
					<ol>
						<li>缴纳图书超期归还罚款，10 积分冲抵 0.1 元；</li>
						<li>充当现金，自选书籍，图书馆为您采购；</li>
					</ol>		
					<br>
					<b>获得积分方式：</b>
					<ol>
						<li>借阅书籍，在到期前15天内归还(不包含续借书)，每次可获得 50 积分；</li>
						<li>参与图书馆组织的活动，并签到，每次可获得 500 积分；</li>
						<li>加入图书馆志愿者，每值班（或其它任务）一小时，可获得500积分；</li>
						<li>提交心愿书单，并被采购，每次可获得 20 积分；</li>
						<li>罚金多算，可申请等额积分补偿；</li>
						<!--  <li>捐赠书籍一本，可获得 1000 积分；</li> -->
					</ol>	
</div>