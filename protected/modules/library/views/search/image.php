<div class="row" style="margin-left:20px;">
<div class="row">
	<ul class="pagination" style="margin:5px auto 0px 10px;">
		  	<li>
		  		<a href="<?php echo Yii::app()->createUrl('library/search/showType',array('showType'=>"list") ) ?>">
					<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
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
<div class="row">

	<?php 
		foreach($ResultBooks as $data)
		{
	?>
  <div onmouseover="$('#popdiv_<?php echo $data->id?>').show();"  onmouseout="$('#popdiv_<?php echo $data->id?>').hide();" style="width:180px;height:190px;margin-left:10px;margin-top:10px;float:left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis">
    <div class="thumbnail">
     <a href="<?php echo $this->createUrl("viewfull", array("bkid"=>$data->id))?>" target="_blank">
      	<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$data->book_logo ?>" style="width:96%;height:140px;" alt="...">
      </a>
     <div class="caption" style="padding: 2px 5px 2px 5px;font-size:13px;">
     	<?php 
     		$namestr = $data->book_type==1?"[B]".$data->book_name : "<font color=red>[M]</font>".$data->book_name;
     		if($data->status != 0 )
     		{
     			$namestr = "<font color='#888'>".$namestr."</font>";
     		}
     	?>
        <h6><a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank"><?php echo $namestr ?></a></h6>
      </div>
	  <!-- HTML to write -->
    </div>
    <a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
    <div id="popdiv_<?php echo $data->id?>"  onmouseover="$('#popdiv_<?php echo $data->id?>').show();"
    	style="display:none;width:92%; height:173px;padding:5px 5px 5px 5px;position: relative;top:-203px;left:8px;background-color:#0088FF;filter:alpha(opacity:80);opacity:0.8;" >
    	<div style="color:#fff;word-wrap: break-word;">
    		<b><?php echo $data->book_name?></b><br>
    		ID: <?php echo $data->category_1."-".$data->category_2?><br>
    		<?php echo $data->publisher?><br>
    		Language: <?php echo $data->language?><br>
    		Author: <?php echo $data->author?><br>
    		Borrowed: <?php echo $data->total_borrowed?><br>
    		Searched: <?php echo $data->total_clicks?><br>
    	</div>
    </div>
    </a>
  </div>
	<?php 
		}
	?>

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