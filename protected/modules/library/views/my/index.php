<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="maintab">
  <li class="active"><a href="#myInHand" onclick='showPage("myInHand","<?php echo $this->createUrl("inhand")?>")'>In Hand</a></li>
  <li><a href="#myScore" onclick='showPage("myScore","<?php echo $this->createUrl("score", array('page'=>'0'))?>")'>我的积分</a></li>
  <!--  
  <li><a href="#myScrum" onclick='showPage("myScrum","<?php echo $this->createUrl("scrum", array('page'=>'0'))?>")'>我的Scrum</a></li>
  -->
  <li><a href="#myHistory" onclick='showPage("myHistory","<?php echo $this->createUrl("history", array('page'=>'0'))?>")'>Read History</a></li>
  <li><a href="#myWaiting" onclick='showPage("myWaiting","<?php echo $this->createUrl("waiting", array('page'=>'0'))?>")'>Reserve Books</a></li>
  <li><a href="#likebooks" onclick='showPage("likebooks","<?php echo $this->createUrl("likebooks")?>")'>Like Books</a></li>
  <!--  
  <li><a href="#mydonate" onclick='showPage("mydonate","<?php echo $this->createUrl("mydonate")?>")'>My Donate</a></li>
  -->
</ul>

<!-- Tab panes -->
<div class="tab-content">
  	<div class="tab-pane active" id="myInHand"></div>
  	<div class="tab-pane" id="myScore"></div>
  	<div class="tab-pane" id="myScrum"></div>
  	<div class="tab-pane" id="myWaiting"></div>
  	<div class="tab-pane" id="myHistory"></div>
  	<div class="tab-pane" id="likebooks"></div>
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
	function refreshPage(tabId, url, isConfirm){
		if(isConfirm){
			if(confirm("确定继续吗 ？确认后不可修改 "))
			{
				$('#'+tabId).load(url);
			}
		}else{
			$('#'+tabId).load(url);
		}
	}

	function updateSeat(tabId, url){
		$('#'+tabId).load(url+"?seat="+$("#user_seat").val());
	}
	
	function loadPage(page){
		url="<?php echo $this->createUrl("history", array('page'=>'mypage'))?>";
		url=url.replace("mypage",page);
		$('#myHistory').load(url);
	}	
	function loadWaitingPage(page){
		url="<?php echo $this->createUrl("waiting", array('page'=>'mypage'))?>";
		url=url.replace("mypage",page);
		$('#myWaiting').load(url);
	}
	function loadScorePage(page){
		url="<?php echo $this->createUrl("score", array('page'=>'mypage'))?>";
		url=url.replace("mypage",page);
		$('#myScore').load(url);
	}
	function loadScrumPage(page){
		url="<?php echo $this->createUrl("scrum", array('page'=>'mypage'))?>";
		url=url.replace("mypage",page);
		$('#myScrum').load(url);
	}

	function ajaxSubmit(formid, tabId){
		ajaxCallUrl=$('#'+formid).attr("action");
		$.ajax({
           type: "POST",
           url:ajaxCallUrl,
           data:$('#'+formid).serialize(),
           async: false,
           error: function(request) {
        	   alert("修改失败:网络错误!");
           },
           success: function(data) {
                $('#'+tabId).html(data);
           } // end success
        });	// end ajax
	}
	
	showPage("myInHand","<?php echo $this->createUrl("inhand")?>");
</script>