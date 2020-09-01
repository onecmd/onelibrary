 <div class="row">
	<div class="col-xs-12 col-sm-9 col-md-8" style="float: left;">
		<div style="font-size:14px;padding:5px 5px 5px 5px;">
			<b>Onelibrary Activity</b>
			<span class="badge pull-right" style="background-color:#0088FF;">
				 <a href="http://10.140.1.39/mvnforum/mvnforum/addpost?forum=7" target="_blank">&nbsp;<font color="#fff"> Add New ... </font>&nbsp;</a> 
			</span>
		</div>
		<div id="newbooks" class="carousel slide" data-ride="carousel">
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			  	
			    <div class="item active">
			    	<div style="background-color:#eee;">
			    		<table class="table">
			    			<tr style="font-weight:bold;">
			    				<td>ID</td>
			    				<td>活动</td>
			    				<td>主题内容</td>
			    				<td>报名截止</td>
			    				<td>活动开始</td>
			    				<td>结束</td>
			    			</tr>
			    		<?php 
			    			$rsid=0;
			    			$carpage = 1;
			    			$carpagesize=6;
			    			foreach($ResultTUActives as $result)
							{
			    				if($rsid>0 && ($rsid % $carpagesize == 0))
			    				{
			    					$carpage = $carpage +1;
			    		?>
			    		</table>
			    	</div>
			    </div>
			    <div class="item">
			    	<div style="background-color:#eee;">
			    		<table class="table">
						    <tr style="font-weight:bold;">
			    				<td>ID</td>
			    				<td>活动</td>
			    				<td>主题内容</td>
			    				<td>报名截止</td>
			    				<td>活动开始</td>
			    				<td>结束</td>
						    </tr>
			    		<?php 		
			    				} // end if new carpage
								$rsid = $rsid+1;
								$signdate=shortDate($result["tSignupEnd"]);
								if(isset($result["tSignupEnd"]) && strtotime($result["tSignupEnd"]) >time())
								{
									$signdate="<font color=red>".$signdate."</font>";
								}
			    		?>
			    			<tr>
			    				<td><?php echo $rsid ?></td>
			    				<td><?php echo $result["activitytype"] ?></td>
			    				<td>
			    					<a href="http://10.140.1.39/mvnforum/mvnforum/viewthread_thread,<?php echo $result["ThreadId"] ?>" target="_blank" title="<?php echo $result["activitySubject"] ?>">
			    					<?php echo mb_substr($result["activitySubject"],0,30, "utf-8") ?>
			    					</a>
			    				</td>
			    				<td><?php echo $signdate ?></td>
			    				<td><?php echo shortDate($result["tBeginTime"]) ?></td>
			    				<td><?php echo shortDate($result["tEndTime"]) ?></td>
			    			</tr>
			    		<?php 
							} // end foreach
			    		?>
			    		</table>
			    	</div>
			    </div> <!-- end item -->
			  </div> <!-- end carousel-inner -->
			  
			 <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#newbooks" data-slide-to="0" class="active" style="background-color:#0066cc;"></li>
			    <?php 
			    	for($a=0; $a<$carpage-1; $a++)
			    	{
			    ?>
			    <li data-target="#newbooks" data-slide-to="<?php echo $a+1 ?>" style="background-color:#0066cc;"></li>
			    <?php 
			    	}
			    ?>
			  </ol>
			  
			  <!-- Controls -->
			  <a class="left carousel-control" href="#newbooks" role="button" data-slide="prev" style="background-image:none;">
			    <span class="glyphicon glyphicon-chevron-left" style="color:#0066cc;"></span>
			  </a>
			  <a class="right carousel-control" href="#newbooks" role="button" data-slide="next" style="background-image:none;">
			    <span class="glyphicon glyphicon-chevron-right" style="color:#0066cc;"></span>
			  </a>
			<script language="javascript">
			  		$("#newbooks").carousel({interval:5000,wrap:true,})
			</script>
		</div>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-4" style="float:left;">
		<div class="index_nav_right">
			<b>Onelibrary News</b>
		</div>
	 	<ol style="line-height: 22px;">
			<?php 
				//foreach($ResultTUNews as $result)
				$rowid = 0;
				$sec7days=3600*24*7;
				while(($result=$ResultTUNews->read())!==false)
				{
					//$link = $this->createUrl("news", array("id"=>$result["id"]));
					//if(isset($result["out_link"]))
					//	$link = $result["out_link"];
					$adddate = shortDate($result["PostLastEditDate"]);
					if(isset($result["PostLastEditDate"]) && strtotime($result["PostLastEditDate"]) >(time()-$sec7days))
					{
						$adddate="<font color=red>".$adddate."</font>";
					}
			?>
			<?php /*?>
	 		<li><a href="<?php echo $link ?>" target="_blank"><?php echo $result["title"] ?><span class="badge pull-right" style="background-color:#fff;color:#0088ff;"><?php  echo shortDate($result["last_modified"]) ?></span></a></li>
	 		<?php */?>
	 		<li><a href="http://10.140.1.39/mvnforum/mvnforum/viewthread_thread,<?php echo $result["ThreadId"] ?>" target="_blank" title="<?php echo $result["PostTopic"]?>"><?php echo mb_substr($result["PostTopic"],0,18, "utf-8") ?><span class="badge pull-right" style="background-color:#fff;color:#0088ff;"><?php  echo $adddate ?></span></a></li>
			<?php 
					$rowid = $rowid+1;
					if($rowid>11)
						break;
					//else
					//	$rowid = $rowid+1;
				} // end while
	 		?>
	 	</ol>
	 </div>
 </div>
 <div class="row" style="padding:5px 5px 5px 15px;">
 	<div class="col-xs-12 col-sm-9 col-md-8" style="padding:5px 15px 5px 0px;">
		<div style="font-size:14px;padding:5px 5px 5px 5px; border-bottom:1px solid #0088FF;margin-bottom:5px;">
			<b>Meeting Rooms</b>
			<span class="badge pull-right" style="background-color:#0088FF;">
				 <a href="https://dominoext3.inside.nokiasiemensnetworks.com/nsn/common/mrchengdu.nsf/mba" target="_blank">&nbsp;<font color="#fff"> Booking ... </font>&nbsp;</a> 
			</span>
		</div>
	  	<div>
			<b>Floor 1: </b>
			Paris, Berlin, Beijing, Atlanta, Oulu, Kupio, Cambridge, Helsinki, Munich, Sydney, Athens, Budapest, Chengdu, Grenoble, Oxford, Boston<br>
		  <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/1f.jpg" style="width:98%" />
			<b>Floor 2: </b>
			Rose, Dandelion, Tulip, Bamboo, Gingko, Lavender, Sauna, Lab<br>
		 <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/2f2.jpg" style="width:98%" />
			<b>Floor 3: </b>
			Baikal, Tianchi, Fuji, Kemijoki, Rhein, Jinjiang, Amazon, Nile, Ontario, Mont Blanc, Kilimanjaro, Titikaka, Victoria, Dongting<br>
		 <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/3f.gif" style="width:98%" />
			<b>Floor 4: </b>
			Swallow, Skylark, Stratus, Albatross, Wagtail, Cumulus, Crane, Cirrus, Swan, Hummingbird, Nimbus, Eagle<br> 
		 <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/4f.jpg" style="width:98%" />
	 	</div>
 	</div>
 	
 	<div class="col-xs-12 col-sm-3 col-md-4" style="float:right;padding:5px 5px 5px 15px;">
	 	<ol style="line-height: 22px;" start="<?php echo $rowid+1 ?>">
		<?php 
			//foreach($ResultTUNews as $result)
			while(($result=$ResultTUNews->read())!==false)
			{
		?>
	 		<li><a href="http://10.140.1.39/mvnforum/mvnforum/viewthread_thread,<?php echo $result["ThreadId"] ?>" target="_blank" title="<?php echo $result["PostTopic"]?>"><?php echo mb_substr($result["PostTopic"],0,18, "utf-8") ?><span class="badge pull-right" style="background-color:#fff;color:#0088ff;"><?php  echo shortDate($result["PostLastEditDate"]) ?></span></a></li>
		<?php 
			}
		?>
		</ol>
		<?php	
			if(isset($ResultClubsNews))
			{
		?>
		<div class="index_nav_right">
			<b>CDTU Club News</b>
		</div>
		<div>
	 		<ol>
			<?php 
				foreach($ResultClubsNews as $result)
				{
			?>
	 		<li><a href="<?php echo $this->createUrl("news", array("id"=>$result["id"])); ?>" target="_blank"><?php echo $result["title"] ?><span class="badge pull-right" style="background-color:#fff;color:#0088ff;"><?php  echo shortDate($result["last_modified"]) ?></span></a></li>
	 		<?php 
				}
	 		?>
	 			<li>新的公告1<span class="badge pull-right" style="background-color:#fff;color:#0088ff;">09-04</span></li>
			</ol>
		</div>
	  	<?php 
 		}
 		if(isset($ResultTUVote))
 		{
	  	?>
		<div class="index_nav_right">
			<b>Vote</b>
		</div>
		<div>
			<div>
				Several Shanghai scientists announced today that an international team they led has discovered a molucular structure that relates to blood clotting in humans and could lead to new treatments for cardiovascular diseases. Their findings were published today in the scientific journal Nature.
			</div>
			<form>
			<div class="radio">
			  <label>
			    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
			    Option one is this and that&mdash;be sure
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
			    Option two can be something else and selecting
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
			    Option three is disabled
			  </label>
			</div>		
			<button type="submit" class="btn btn-success btn-sm  pull-right"> &nbsp; Submit &nbsp;  </button>	
			</form>
		</div>
		<?php
 		}
 		/*
		?>
		<div class="index_nav_right">
			<b>Comments and Suggestions</b>
		</div>
		<div>
			<div>
				You can tell us your comments and suggestions here:
			</div>
			<form action="<?php echo $this->createUrl("addcomments")?>" method="post">
				<textarea rows="4" style="width:100%" name="content"></textarea>
				<button type="submit" class="btn btn-success btn-sm  pull-right"> &nbsp; Submit &nbsp;  </button>	
			</form>
		</div>
		<?php 
			*/
		?>
 	</div>
 </div>