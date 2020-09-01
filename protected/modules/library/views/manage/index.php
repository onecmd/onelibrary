<?php 
	$action = isset($_REQUEST["action"])?$_REQUEST["action"]:null;
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="maintab">
<!--  
  <li><a href="#tbimage"  onclick='showPage("tbimage","<?php echo $this->createUrl("image", array('page'=>'1'))?>")'>By Image</a></li>
-->
  <li class="<?php echo (!isset($action) || $action=="list")? "active":"" ?>"><a href="#tblist" onclick='showPage("tblist","<?php echo $this->createUrl("list", array('page'=>'0'))?>")'>By List</a></li>
  <li class="<?php echo (isset($action) && $action=="waiting")? "active":"" ?>"><a href="#tbwaiting" onclick='showPage("tbwaiting","<?php echo $this->createUrl("waitingView", array('page'=>'0'))?>")'>Reserve List</a></li>
  <li class="<?php echo (isset($action) && $action=="return")? "active":"" ?>"><a href="#tbreturn" onclick='showPage("tbreturn","<?php echo $this->createUrl("returnView")?>")'>Return</a></li>
  <li class="<?php echo (isset($action) && $action=="notify")? "active":"" ?>"><a href="#tbnotify" onclick='showPage("tbnotify","<?php echo $this->createUrl("notifyView", array('page'=>'0'))?>")'>Notification</a></li>
  <li class="<?php echo (isset($action) && $action=="finelist")? "active":"" ?>"><a href="#tbfinelist" onclick='showPage("tbfinelist","<?php echo $this->createUrl("finelistView", array('page'=>'0'))?>")'>Fine List</a></li>
  <li class="<?php echo (isset($action) && $action=="summary2years")? "active":"" ?>"><a href="#tbsummary2years" onclick='showPage("tbsummary2years","<?php echo $this->createUrl("summary2years", array('page'=>'0'))?>")'>Summary Years</a></li>
  <li class="<?php echo (isset($action) && $action=="removed")? "active":"" ?>"><a href="#tbremoved" onclick='showPage("tbremoved","<?php echo $this->createUrl("removedView", array('page'=>'0'))?>")'>Removed</a></li>
  <li class="<?php echo (isset($action) && $action=="dutyBooking")? "active":"" ?>"><a href="#tbdutyBooking" onclick='showPage("tbdutyBooking","<?php echo $this->createUrl("dutyBookingView", array('page'=>'0'))?>")'>值班预约</a></li>
  <li class="<?php echo (isset($action) && $action=="userDuty")? "active":"" ?>"><a href="#tbuserDuty" onclick='showPage("tbuserDuty","<?php echo $this->createUrl("userDutyView", array('page'=>'0'))?>")'>值班记录</a></li>
  <li class="<?php echo (isset($action) && $action=="userScore")? "active":"" ?>"><a href="#tbuserScore" onclick='showPage("tbuserScore","<?php echo $this->createUrl("userScoreView", array('page'=>'0'))?>")'>用户积分</a></li>
  <li class="<?php echo (isset($action) && $action=="userScrum")? "active":"" ?>"><a href="#tbuserScrum" onclick='showPage("tbuserScrum","<?php echo $this->createUrl("userScrumView", array('page'=>'0'))?>")'>Team借阅者</a></li>
</ul>
<style type="text/css">
    	.form-group{padding:5px 0px 5px 0px;margin-bottom:0px;font-size:12px;}
    	.form-control{padding:0px 0px 0px 0px;height:28px;}
</style>
<!-- Tab panes -->
<div class="tab-content">

	<div class="tab-pane <?php echo (!isset($action) || $action=="list")? "active":"" ?>" id="tblist">
		<div class="panel panel-default" style="margin-bottom:0px;border-width:0px;">
		<!--  
			<div class="panel-heading">
				<h4 class="panel-title text-right">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="btn btn-info"> Search Options </a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
			-->	<div class="panel-body" style="padding:0px 0px 0px 0px;">
			<div style="width:82%;float:left;">
					<form id="tblist_form" action="<?php echo $this->createUrl("list") ?>" method="post" class="form-horizontal" role="form" style="margin-top: 10px;">
						<div class="form-group">
							<div class="col-sm-7">
							</div>
							<div class="col-sm-5">
								<?php 
								$week = date("w");
								switch($week){
                            	case 2:
                            	case 4:
	  								$startTime=strtotime(date('Y-m-d').' 13:10:00');
	  								$endTime=strtotime(date('Y-m-d').' 14:40:00');
                            		if(time()>=$startTime && time()<=$endTime){
                            			
										if(!isset(Yii::app()->session['dutyStartTime'])){
								?>
								<button type="button" class="btn btn-warning col-sm-8" onclick="startDuty(<?php echo $page["currentPage"] ?>)">值班一小时</button>
								<?php 
										}else{
								?>
								<font style="font-size:16px; color:red">正在值班[From <?php echo Yii::app()->session['dutyStartTime']; ?>]...</font>
								<?php 
										} // end if session
                            		} // end if time
                            		break;
                            	} // end switch
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="book_id" class="col-sm-2 control-label">Book ID</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="book_id" name="Books[book_id]" placeholder="">
							</div>
							<label for="book_name" class="col-sm-2 control-label">Book Name</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="book_name" name="Books[book_name]" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="holder_nsn_id" class="col-sm-2 control-label">Holder NSN ID</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="holder_nsn_id" name="Books[holder_nsn_id]" placeholder="">
							</div>
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="Books[status]">
									<option value="10">All</option>
									<option value="0">Available for borrow</option>
									<option value="1">For Return</option>
									<option value="2">Removed</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="owner_team" class="col-sm-2 control-label">Owner Team</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="owner_team" name="Books[owner_team]" placeholder="">
							</div>
							<label for="book_type" class="col-sm-2 control-label">Book Type</label>
							<div class="col-sm-3">
								<select class="form-control" id="book_type" name="Books[book_type]">
									<option value="0">All</option>
									<?php
									foreach($BookTypeArray as $key=>$value)
									{
										?>
									<option value="<?php echo $key?>">
									<?php echo $value ?>
									</option>
									<?php
								  	}
								  	?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="tags" class="col-sm-2 control-label">Tags</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="tags" name="Books[tags]" placeholder="">
							</div>
							<label for="language" class="col-sm-2 control-label">Language</label>
							<div class="col-sm-3">
								<select class="form-control" id="language" name="Books[language]">
									<option value="all">All</option>
									<option value="Chinese">Chinese</option>
									<option value="English">English</option>
									<option value="Finnish">Finnish</option>
									<option value="French">French</option>
									<option value="German">German</option>
									<option value="Spanish">Spanish</option>
									<option value="Japanese">Japanese</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="author" class="col-sm-2 control-label">Author</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="author" name="Books[author]" placeholder="">
							</div>
							<label for="isbn" class="col-sm-2 control-label">ISBN</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="isbn" name="Books[isbn]" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="publisher" class="col-sm-2 control-label">Publisher</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="publisher" name="Books[publisher]" placeholder="">
							</div>
							<label for="stock_total" class="col-sm-2 control-label"> </label>
							<div class="col-sm-3">
								<button type="button" class="btn btn-info col-sm-8" onclick="ajaxSubmit('tblist_form', 'tblist_search_result')">Search</button>
								<input type="hidden" id="page" name="page" value="0">
							</div>
						</div>
					</form>
					</div>
					<div style="width:15%;float:left;text-align:center;font-size:13px; margin-left:10px;">
			<br><b>支付宝.罚金扫码支付</b><br>
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/cn98tu_alipay.jpg" style="height: 180px;" alt="工会图书馆支付宝二维码">
		</div>
				</div>
			<!--  </div>-->
		</div>
		<div class="row" id="tblist_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="return")? "active":"" ?>" id="tbreturn">
		<div class="row" id="tbreturn_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="removed")? "active":"" ?>" id="tbremoved">
		<div class="row" id="tbremoved_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="notify")? "active":"" ?>" id="tbnotify">
		<div class="row" id="tbnotify_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="finelist")? "active":"" ?>" id="tbfinelist">
		<div class="row" id="tbfinelist_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="summary2years")? "active":"" ?>" id="tbsummary2years">
		<div class="row" id="tbsummary2years_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="waiting")? "active":"" ?>" id="tbwaiting">
		<div class="row" id="tbwaiting_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="userDuty")? "active":"" ?>" id="tbuserDuty">
		<div class="row" id="tbuserDuty_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="userScore")? "active":"" ?>" id="tbuserScore">
		<div class="row" id="tbuserScore_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="userScrum")? "active":"" ?>" id="tbuserScrum">
		<div class="row" id="tbuserScrum_search_result"></div>
	</div>
	<div class="tab-pane <?php echo (isset($action) && $action=="dutyBooking")? "active":"" ?>" id="tbdutyBooking">
		<div class="row" id="tbdutyBooking_search_result"></div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="dlgmain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
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
<script language="javascript">
	var loadimg="<img src='<?php echo Yii::app()->request->baseUrl.'/img/load2.gif' ?>'>";
	function actionDlg(title, url){
		$('#dlgtitle').html(title);
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function reserve(url){
		$('#dlgtitle').html("Borrow Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function view(url){
		$('#dlgtitle').html("View Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function edit(url){
		$('#dlgtitle').html("Edit Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function returnview(url){
		$('#dlgtitle').html("Return Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function renewview(url){
		$('#dlgtitle').html("Renew Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function removebk(url){
		$('#dlgtitle').html("Remove Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function restore(url){
		$('#dlgtitle').html("Restore Book");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function notify(url){
		$('#dlgtitle').html("Notify OverDue Books");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function finelist(url){
		$('#dlgtitle').html("Fine List");
		$('#dlgbody').html(loadimg);
		$('#dlgmain').modal('show');
		$('#dlgbody').load(url);
	}
	function transferDutyTo(target, url){
		userId=target.value;
		
		if(userId!=""){
			$('#dlgtitle').html("值班安排");
			$('#dlgbody').html(loadimg);
			$('#dlgmain').modal('show');
			$('#dlgbody').load(url+"?userId="+userId);
		}
	}

	function changeBkTypeTo(bkId, url){
		$("#bktype_"+bkId).html(loadimg);
		$("#bktype_"+bkId).load(url);
	}

	function loadEmail(dnsnid, demailId, url){
		var nsnid=$("#"+dnsnid).val();
		url = url.replace("nsn_id", nsnid);
		email = $.ajax({url:url,async:false});
		restext=email.responseText.split(";");
		$("#"+demailId).val(restext[0]);
		if(restext.length>1)
			$("#borrow_fine_msg").html(restext[1]);
		else
			$("#borrow_fine_msg").html("");
	}
	function showPage(tabId, url){
		$('#maintab a[href="#'+tabId+'"]').tab('show');
		if($('#'+tabId+'_search_result').html().length<20){
			$('#'+tabId+'_search_result').html('<br>'+loadimg+' 页面加载中，请稍后...');
			//ajaxSubmit(tabId+'_form', tabId+'_search_result');
			$('#'+tabId+"_search_result").load(url);
		}
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
	ajaxSubmit('tblist_form', 'tblist_search_result');
	function loadPage(page){
		$('#page').val(page);
		//alert($('#page').val());
		ajaxSubmit('tblist_form', 'tblist_search_result');
	}
	function loadReturn(url){
		$('#tbreturn_search_result').load(url);
	}
	function ajaxReturn(){
		ajaxSubmit('tbReturn_form','tbreturn_search_result');
	}
	function loadRemoved(url){
		$('#tbremoved_search_result').load(url);
	}	
	function loadUserDuty(url){
		$('#tbuserDuty_search_result').load(url);
	}	
	function loadUserScore(url){
		$('#tbuserScore_search_result').load(url);
	}	
	function loadUserScrum(url){
		$('#tbuserScrum_search_result').load(url);
	}	
	function loadDutyBooking(url){
		$('#tbdutyBooking_search_result').html('<br>'+loadimg+' 页面加载中，请稍后...');
		$('#tbdutyBooking_search_result').load(url);
	}	
	function loadSummary2years(url){
		$('#tbsummary2years_search_result').load(url);
	}	
	function ajaxSummary2years(){
		ajaxSubmit('tbWaiting_form','tbsummary2years_search_result');
	}
	
	function loadNotify(url){
		$('#tbnotify_search_result').load(url);
	}
	function loadFinelist(url){
		$('#tbfinelist_search_result').load(url);
	}
	function notifyall(){
		var str="";
		var listchk = $("input[name='notify_book_ids']");
		for(i=0;i<listchk.length;i++){
		 if(listchk[i].checked){
		  str += listchk[i].value+',';
		 }
		}
		ajaxCallUrl=$('#notifyall_form').attr("action");
		ajaxCallUrl = ajaxCallUrl.replace("notify_book_ids",str);
		$('#notifyall_form').attr("action",ajaxCallUrl);
		//alert($('#notifyall_form').attr("action"));
		ajaxSubmit('notifyall_form', 'tbnotify_search_result_notexist');
		$('#resresh_notifys').click();
	}
	function loadWaiting(url){
		$('#tbwaiting_search_result').load(url);
	}	
	function ajaxWaiting(){
		ajaxSubmit('tbWaiting_form','tbwaiting_search_result');
	}
			
	function dlgload(url){
		//$('#dlgbody').load(url);
		$('#message_response').load(url);
	}	
	
	function notifyFineAll(){
		var str="";
		var listchk = $("input[name='notify_fine_ids']");
		for(i=0;i<listchk.length;i++){
		 if(listchk[i].checked){
		  str += listchk[i].value+',';
		 }
		}
		ajaxCallUrl=$('#notifyfine_form').attr("action");
		ajaxCallUrl = ajaxCallUrl.replace("notify_fine_ids",str);
		$('#notifyfine_form').attr("action",ajaxCallUrl);
		//alert($('#notifyall_form').attr("action"));
		ajaxSubmit('notifyfine_form', 'tbnot_exist');
		$('#refresh_fine_list').click();
	}

	function changeToPaid(url){
		if(confirm("确定已经收到罚款了吗 ？确认后不可修改 "))
		{
			$('#tbfinelist_search_result').load(url);
		}
	}

	function startDuty(page){
		$.ajax({
	           type: "POST",
	           url:'<?php echo $this->createUrl("userDuty1Hour") ?>',
	           //data:$('#'+formid).serialize(),
	           async: false,
	           error: function(request) {
	        	   $('#'+'tblist_search_result').html("修改失败:网络错误!");
	           },
	           success: function(data) {
	        	   location.reload();
	        	   //$('#tblist_search_result').load('<?php echo $this->createUrl("list", array('page'=>'0'))?>');
	        	   //loadPage(page);
	                //$('#'+'tblist_search_result').html(data);
	           } // end success
	        });	// end ajax
		//loadPage(page);
	}

		
</script>