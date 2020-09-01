<div class="row" style="padding:5px 30px 5px 30px;">

	<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"] ?>)">刷新</a></li>
		  	<li><a href="#" onclick="loadPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
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
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
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
	  <td>Book Logo</td>
	  <td>Book Name</td>
	  <td>Book ID</td>
	  <td>Book Type</td>
	  <!--<td>Tags</td>-->
	  <td>Status</td>
	  <!--  <td>Holder</td>-->
	  <td>Due Time</td>
	  <td>Action</td>
	</tr>
	<?php
		foreach($ResultBooks as $data)
		{
			$bookTypeHtml=$this->getBookTypeHtml($BookTypeArray, $data->id);
			
			$holder = "Ok for borrow";
			if($data->status == 1)
			{
				$holder = isset($data->holder_email) ? "[".$data->holder_nsn_id."]<font color=green>".$data->holder_email."</font>" : "Borrowed <font color=green>".$data->holder_name."</font>";
			}
		?>
	<tr>
	  	<td><?php echo $data->id ?></td>
	  	<td>
			<a href="<?php echo Yii::app()->createUrl('library/edit/editfull', array('bkid'=>$data->id)) ?>" target="_blank" >	  			
				<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$data->book_logo ?>" border="0" height="30" />
	  		</a>
	  	</td>
	  	<td>
	  		<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
	  			<?php echo $data->book_name ?>
	  		</a>
	  	</td>
	  	<td><?php echo $data->book_id ?><br>
	  	<td><div id="bktype_<?php echo $data->id ?>"><?php echo $BookTypeArray[$data->book_type] ?></div></td>
	  	<!--<td><?php echo $data->tags ?></td>
	  	  <td><?php echo $this->parseBookStatus($data->status) ?></td>-->
	  	<td><?php echo $holder  ?></td>
	  	<td><?php echo shortDate($data->due_date) ?></td>
	  	<td>
	  		<div class="dropdown">
				<button type="button" class="btn btn-primary btn-xs" onclick='view("<?php echo Yii::app()->createUrl('library/edit/view', array('bkid'=>$data->id)) ?>")'>View</button>	  			
			  	<button class="btn btn-info dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown">
			    	Type To
			    	<span class="caret"></span>
			  	</button>
			  	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			  		<?php echo $bookTypeHtml ?>
			  	</ul>
	  			<button type="button" class="btn btn-success btn-xs" onclick='edit("<?php echo Yii::app()->createUrl('library/edit/edit', array('bkid'=>$data->id)) ?>")'>&nbsp; Edit &nbsp;</button>
				<?php 
	  				if($data->status==0) // available for borrow
	  				{
	  			?>
	  			<button type="button" class="btn btn-warning btn-xs" onclick='reserve("<?php echo $this->createUrl('reservePopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Borrow &nbsp;</button>
	  			<?php 
	  				}
	  				else if($data->status==1) // borrowed
	  				{
	  			?>
        		<button type="button" class="btn btn-warning btn-xs" onclick='returnview("<?php echo $this->createUrl('returnPopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Return &nbsp;</button> 
        		<button type="button" class="btn btn-success btn-xs" onclick='renewview("<?php echo $this->createUrl('renewPopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Renew &nbsp;</button> 
        		<?php 
        				$totaldays = floor((time()-strtotime($data->due_date))/86400);
        				if(($totaldays>-4 && $totaldays<1) 
       						|| ($data->notify_email_times<1 && $totaldays>-4) 
       						|| ($data->notify_email_times>0 && $totaldays>0))
       					{
        		?>
        		<button type="button" class="btn btn-danger btn-xs" onclick='notify("<?php echo $this->createUrl('notifyPopView', array('bkid'=>$data->id)) ?>")'>&nbsp; Notify &nbsp;</button> 
	  			<?php 
	  					}
	  				}
	  			?>
			  	<?php 
			  		if($data->status==0) // available for borrow
	  				{
			  	?>
	  			<button type="button" class="btn btn-danger btn-xs" onclick='removebk("<?php echo $this->createUrl('removePopView', array('bkid'=>$data->id)) ?>")'>Remove</button>
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
		<ul class="pagination" style="margin:5px auto 5px auto;">
		  	<li><a href="#" onclick="loadPage(0)">&iota;&lsaquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]<1?0:$page["currentPage"]-1 ?>)">&laquo;</a></li>
			<?php 
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
		  	<li><a href="#" onclick="loadPage(<?php echo $page["currentPage"]>=$page["pageCount"]-1?$page["pageCount"]-1:$page["currentPage"]+1 ?>)">&raquo;</a></li>
		  	<li><a href="#" onclick="loadPage(<?php echo $page["pageCount"]-1 ?>)">&rsaquo;&iota;</a></li>
		</ul>
</div>