<div class="row" style="margin-left:20px;">
<div class="row">
	<ul class="pagination" style="margin:5px auto 0px 10px;">
		  	<li>
		  		<a href="<?php echo Yii::app()->createUrl('library/search/showType',array('showType'=>'image') ) ?>">
					 <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
				</a>
		  	</li>
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
</div>
<div class="row" style="padding:5px 10px 5px 10px;">

<table class="table table-condensed table-hover table-striped" style="width:96%;">
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
	  <td>Language</td>
	  <td>Author</td>
	  <td>Publisher</td>
	  <td>Location</td>
	  <td>Readed/Liked</td>
	  <td>Return Date</td>
	</tr>
	<?php
		$no = $page["currentPage"]*$page["pageSize"];
		//echo $page["currentPage"]."----".$page["pageSize"];
		foreach($ResultBooks as $data)
		{
			$no = $no+1;
			$status = "In library";
			if($data->status == 1)
			{
				$status = shortDate($data->due_date);
			}
			elseif($data->status == 3){
				$status = "<font color=red>Free read</font>";
			}
		?>
	<tr>
	  	<td><?php echo $no ?></td>
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
	  	<td><?php echo $data->language ?></td>
	  	<td><?php echo $data->author ?></td>
	  	<td><?php echo $data->publisher ?></td>
	  	<td><?php echo ($data->location_building==0?"A4 ":"E2 ").$data->location_library ?></td>
	  	<td><?php echo $data->total_borrowed."/".$data->liked_num ?></td>
	  	<td><?php echo $status  ?></td>
	</tr>
	<?php 
		}
	?>
</table>


</div>
<div class="row">
		<ul class="pagination" style="margin:0px auto 5px 10px;">
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
</div>