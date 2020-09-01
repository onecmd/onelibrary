<!-- Nav tabs -->
<?php 
	if(isset($message))
	{
?>
<div class="row" style="padding:5px 30px 5px 30px;color:red;">
	<?php echo $message?>
</div>
<?php 		
	}
?>
<ul class="nav nav-tabs" role="tablist" id="maintab">
  <li class="active"><a href="#donateList" onclick='showPage("donateList","<?php echo $this->createUrl("donateList")?>")'>All Donate</a></li>
	<?php 
		if(isset(Yii::app()->session['user']))
		{
	?>
  <li><a href="#mydonate" onclick='showPage("mydonate","<?php echo $this->createUrl("mydonate", array('page'=>'0'))?>")'>My Donate</a></li>
	<?php 
			if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
			{
	?>
  <li><a href="#newDonate" onclick='showPage("newDonate","<?php echo $this->createUrl("newDonate", array('page'=>'0'))?>")'>捐书登记</a></li>
  	<?php 
			}
		}
  	?>
  </ul>

<!-- Tab panes -->
<div class="tab-content">
  	<div class="tab-pane active" id="donateList"></div>
  	<div class="tab-pane" id="newDonate"></div>
  	<div class="tab-pane" id="mydonate"></div>

</div>
<script language="javascript">
	var loadimg="<img src='<?php echo Yii::app()->request->baseUrl.'/img/load2.gif' ?>'>";

	function showPage(tabId, url){
		$('#maintab a[href="#'+tabId+'"]').tab('show');
		if($('#'+tabId).html().length<20){
			$('#'+tabId).html('<br>'+loadimg+' 页面加载中，请稍后...');
			$('#'+tabId).load(url);
		}
	}
	showPage("donateList","<?php echo $this->createUrl("donateList")?>");
	
	function loadPager(url){
		$('#donateList').load(url);
	}
</script>