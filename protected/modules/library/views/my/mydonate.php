	<div class="row" style="margin-left:0px;padding:10px 10px 0px 10px;">
		<font color="red">
		We are very warmly welcome you to donate your free books to us - Onelibrary Library! <br>
		</font>
		Following are your donated books:
	</div>
<div class="row">

	<?php 
		$total = 0;
		foreach($ResultBooks as $data)
		{
			$total++;
	?>
  <div style="width:180px;height:300px;margin-left:10px;margin-top:10px;float:left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis">
    <div class="thumbnail">
      <a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank">
      	<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$data->book_logo ?>" style="width:96%;height:140px;" alt="...">
      </a>
      <div class="caption" style="padding: 2px 5px 2px 5px;">
        <h5><a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$data->id))?>" target="_blank"><?php echo $data->book_name ?></a></h5>
         <h5><b><font color="red"><?php echo $data->total_saygood ?> </font></b>users Say Good!</h5>
        <h5><b><font color="red"><?php echo $data->total_borrowed ?> </font></b>users readed it!</h5>
        <h5><b><font color="red"><?php echo $data->liked_num ?> </font></b>users liked it!</h5>
       	<h5><b><font color="red"><?php echo $data->total_clicks ?> </font></b>users searched it!</h5>
      </div>
    </div>
  </div>
	<?php 
		}
		if($total<1)
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No books donated.<br>";
	?>

</div>