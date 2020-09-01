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
  <li class="active"><a href="#requestList" onclick='showPage("requestList","<?php echo $this->createUrl("requestList")?>")'>All Request</a></li>
	<?php 
		if(isset(Yii::app()->session['user']))
		{
	?>
  <li><a href="#mybuy" onclick='showPage("mybuy","<?php echo $this->createUrl("mybuy", array('page'=>'0'))?>")'>My Request</a></li>
  <li><a href="#newBuy" onclick='showPage("newBuy","<?php echo $this->createUrl("newBuy", array('page'=>'0'))?>")'>Request A Book</a></li>
	<?php 
			//if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
			//{
	?>
  <li><a href="#buyList" onclick='showPage("buyList","<?php echo $this->createUrl("buyList", array('page'=>'0'))?>")'>采购计划</a></li>
  	<?php 
			//}
		}
  	?>
  </ul>

<!-- Tab panes -->
<div class="tab-content">
  	<div class="tab-pane active" id="requestList"></div>
  	<div class="tab-pane" id="newBuy"></div>
  	<div class="tab-pane" id="mybuy"></div>
  	<div class="tab-pane" id="buyList"></div>

</div>

<!-- Modal -->
<div class="modal fade" id="dlgmain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog"  id="dlgModalShow">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="dlgtitle">Modal title</h4>
      </div>
      <div class="modal-body" id="dlgbody">
        ...
      </div>
      <!--  
      <div class="modal-footer" id="dlgfoot">
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>
  </div>
</div>

<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop='static'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" style="text-align: center;height:60px;">
        	加载中...
      </div>
    </div>
  </div>
</div>

<script language="javascript">
	var loadimg="<img src='<?php echo Yii::app()->request->baseUrl.'/img/load2.gif' ?>'>";
	
	function showDlg(url, title, isLarge=true){
		if(isLarge){
			$('#dlgModalShow').addClass("modal-lg");
		}
		else{
			$('#dlgModalShow').removeClass("modal-lg");
		}
		$('#dlgtitle').html(title);
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	
	function showPage(tabId, url){
		showPage(tabId, url, false);
	}
	
	function showPage(tabId, url, isReload){
		$('#maintab a[href="#'+tabId+'"]').tab('show');
		if(isReload || $('#'+tabId).html().length<20){
			$('#'+tabId).html('<br>'+loadimg+' 页面加载中，请稍后...');
			$('#'+tabId).load(url);
		}
	}
		
	//showPage("<?php echo isset($target)?$target:"requestList"?>","<?php echo $this->createUrl(isset($target)?$target:"requestList")?>");
	showPage("requestList","<?php echo $this->createUrl("requestList")?>");
	
	function loadPager(url){
		//showPage("requestList", url);
		$('#requestList').load(url);
//		window.location=url;
	}

	function showActionDlg(){
		
	}

	function reserve(url){
//		$('#requestList').html(loadimg);
		$('#requestList').load(url);
		
	}	
	function ajaxSubmit(formid, tabId){
		ajaxCallUrl=$('#'+formid).attr("action");
		$.ajax({
           type: "POST",
           url:ajaxCallUrl,
           data:$('#'+formid).serialize(),
           async: false,
           error: function(request) {
        	   $('#'+tabId).html("修改失败:网络错误!");
           },
           success: function(data) {
                $('#'+tabId).html(data);
           } // end success
        });	// end ajax
	}
	function loadPage(page){
		$('#page').val(page);
		//alert($('#page').val());
		ajaxSubmit('tblist_form', 'requestList');
	}
	function loadBuyListPage(page){
		$('#buylistpage').val(page);
		//alert($('#page').val());
		ajaxSubmit('tbbuylist_form', 'buyList');
	}
	currrentPage=0;
	function loadCreateBuyList(){
		//alert($('#page').val());
		ajaxSubmit('buyList_create', 'dlgbody');
		loadBuyListPage(currrentPage);
	}	

	function loadAndRefresh(ajaxCallUrl, refreshId){
		$('#loading').modal('show');
		$.ajax({
	           url:ajaxCallUrl,
	           error: function(request) {
	        	   alert("执行失败，请重试！");
	        	   $('#loading').modal('hide');
	           },
	           success: function(data) {
	        	   $('#'+refreshId).click();
	        	   $('#loading').modal('hide');
	           } // end success
	        });	// end ajax
	}

	function confirmLoad(ajaxCallUrl, refreshId){
		if(confirm("确定修改吗？不可撤销！")){
			loadAndRefresh(ajaxCallUrl, refreshId);
		}
	}

	function loadBuyedBooks(ajaxCallUrl, value){
		if(value.length>2){
			$('#buyedBooksList').html("<li>正在查询图书馆中类似的书籍...</li>");
			$.ajax({
		           url:ajaxCallUrl+"?bookName="+value,
		           success: function(data) {
		        	   $('#buyedBooksList').html(data);
		           } // end success
		        });	// end ajax
		}
	}
    
</script>