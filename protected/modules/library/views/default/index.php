 <div class="row">
	<div class="col-xs-12 col-sm-9 col-md-8" style="float: left;">
		<div style="font-size:14px;padding:5px 5px 5px 5px;">
			<b>New Books</b>
			<span class="badge pull-right" style="background-color:#0088FF;">
				 <a href="<?php echo Yii::app()->createUrl("library/search/index")?>">&nbsp;<font color="#fff"> More ... </font>&nbsp;</a> 
			</span>
		</div>
		<div id="newbooks" class="carousel slide" data-ride="carousel">
			
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
				<?php 
				$caractive = "active";
				$total = 0;
				foreach($ResultNewstBooks as $result)
				{
					$total = $total+1;
				?>
			    <div class="item <?php echo $caractive?>">
			    	<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$result["id"])); ?>" target="_blank">
			      		<img src="<?php echo Yii::app()->request->baseUrl; ?>/imgbk/<?php echo $result["book_logo"] ?>" style="width:100%;height:280px;">
			      	</a>
			      	<div class="carousel-caption">
			        	<font style="font-size:19px;"><b><?php echo $result["book_name"] ?></b></font>
			      	</div>
			    </div>
			    <?php 
			    	$caractive = "";
				}
			    ?>
			  </div>
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#newbooks" data-slide-to="0" class="active"></li>
			    <?php 
			    	for($i=0; $i<$total-1; $i++)
			    	{
			    ?>
			    <li data-target="#newbooks" data-slide-to="<?php echo $i+1 ?>"></li>
			    <?php 
			    	}
			    ?>
			  </ol>
			
			  <!-- Controls -->
			  <a class="left carousel-control" href="#newbooks" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left"></span>
			  </a>
			  <a class="right carousel-control" href="#newbooks" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right"></span>
			  </a>
			<script language="javascript">
			  		$("#newbooks").carousel({interval:2000,wrap:true,})
			</script>
		</div>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-4" style="float:left;">
		<?php 
		/*
		?>
		<div class="index_nav_right">
			<b>CDTU Library News</b>
		</div>
	 	<ol>
			<?php 
				foreach($ResultLibraryNews as $result)
				{
			?>
	 		<li><a href="<?php echo $this->createUrl("news", array("id"=>$result["id"])); ?>" target="_blank"><?php echo $result["title"] ?><span class="badge pull-right" style="background-color:#fff;color:#0088ff;"><?php  echo shortDate($result["last_modified"]) ?></span></a></li>
	 		<?php 
				}
	 		?>
	 	</ol>
	 	<?php 
	 	*/
	 	?>
		<div class="index_nav_right">
			<b>About Our Library</b>
		</div>
	  	<table class="table" width="100%" border="0">
	  		<tr>
	  			<td width="100">图书总数：</td>
	  			<td width="70"><?php echo $ResultLibSummary["totalbooks"]?></td>
	  			<td width="90">其中借出：</td>
	  			<td><?php echo $ResultLibSummary["book_borrowed"]?></td>
	  		</tr>
	  		<tr>
	  			<td>总借出人次：</td>
	  			<td><?php echo $ResultLibSummary["borrowed_total"]?></td>
	  			<td>借阅人数：</td>
	  			<td><?php echo $ResultLibSummary["borrowed_users"]?></td>
	  		</tr>
	  		<tr>
	  			<td>总检索次数：</td>
	  			<td><?php echo $ResultLibSummary["searched"]?></td>
	  			<td>被赞次数：</td>
	  			<td><?php echo $ResultLibSummary["saygood"]?></td>
	  		</tr>
	  		<tr>
	  			<?php 
	  				$vistarray=explode(',',$ResultLibSummary["max_date"]);
	  			?>
	  			<td>最多访问日：</td>
	  			<td><?php echo shortDate(date('Y-m-d',strtotime($vistarray[0]))) ?></td>
	  			<td>访问次数：</td>
	  			<td><?php echo $vistarray[1]?></td>
	  		</tr>
	  		<tr>
	  			<td>借阅时间：</td>
	  			<td colspan="3">
	  				周二: 13:30 ~ 14:30<br>
	  				周四: 13:30 ~ 14:30
	  			</td>
	  		</tr>
	  		<tr>
	  			<td colspan="4">当期值班：
	  				<div style="padding-left:40px;color=green">
	  					<?php
	  						/*$week = date("w");
	  						$dutyStr = "今天不是值班日，再等几天吧";
                            switch($week){
                            	case 2:
                            	case 4:
	  								$startTime=strtotime(date('Y-m-d').' 13:30:00');
	  								$endTime=strtotime(date('Y-m-d').' 14:30:00');
                            		if(time()<$startTime){
                            			$dutyStr =  "值班时间还没到，13:30开始...";
                            		}
                            		else if(time()>$endTime)
                            		{
                            			$dutyStr =  "值班时间已过，等下个值班日吧...";
                            		}
                            		else{
                            			$dutyStr =  "<font color=red>正在图书馆等您的那位小伙伴...</font>";
                            		}
                            		break;
                            }*/
	  					?>	<font color=red>疫情期间图书馆关闭，图书自动续期到疫情结束,请在疫情结束后再来借阅/归还图书</font>
                	  		TianFu New Area 3F: <?php echo $dutyStr ?><br>
                	</div>
	  			</td>
	  		</tr>
	  	</table>
	 	
	 </div>
 </div>
 <div class="row" style="padding:5px 5px 5px 15px;">
 	<div class="col-xs-12 col-sm-9 col-md-8" style="padding:5px 15px 5px 0px;">
		<div style="font-size:14px;padding:5px 5px 5px 5px; border-bottom:1px solid #0088FF;margin-bottom:5px;">
			<b>New Available Books</b>
			<span class="badge pull-right" style="background-color:#0088FF;">
				 <a href="<?php echo Yii::app()->createUrl("library/search/index")?>" target="_blank">&nbsp;<font color="#fff"> More ... </font>&nbsp;</a> 
			</span>
		</div>
	  	<div class="row">
	  		<?php 
	  			foreach($ResultNewAvail as $result)
	  			{
	  		?>
			<div style="width: 180px; height: 195px; margin-left: 10px; text-align:center;margin-top: 10px; float: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis">
				<div class="thumbnail">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/imgbk/<?php echo $result["book_logo"] ?>" style="width: 96%; height: 140px;" alt="...">
					<div class="caption" style="font-size:12px;">
						<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$result["id"])); ?>" target="_blank" title="<?php echo $result["book_name"]?>">
							<b><?php echo partString($result["book_name"], 20) ?></b>
						</a>
					</div>
				</div>
			</div>
			<?php 
	  			}
			?>
		</div> <!-- end class row -->
		<?php 
			/*
		?>
		<div style="font-size:16px;padding:5px 5px 5px 5px; border-bottom:1px solid #0088FF;margin-bottom:5px;">
			<b>Book Rankings</b>
		</div>
	  	<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-4" style="float: left; padding: 5px 5px 5px 15px;">
				<div class="index_nav_right" style="border-bottom-style:dotted;">
					Top Readed Books
				</div>
				<div>
					<ul style="list-style: none;padding-left:10px;">
			 			<li><span class="badge pull-left" style="background-color:#FF0000;color:#fff;">1</span> 程序员</li>
			 			<li><span class="badge pull-left" style="background-color:#FF3300;color:#fff;">2</span>程序员</li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF6600;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9900;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9933;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9966;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF99CC;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
					</ul>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-3 col-md-4" style="float: left; padding: 5px 5px 5px 15px;">
				<div class="index_nav_right" style="border-bottom-style:dotted;">
					Top Reader
				</div>
				<div>
					<ol>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF0000;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF3300;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF6600;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9900;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9933;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9966;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF99CC;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
					</ol>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-3 col-md-4" style="float: left; padding: 5px 5px 5px 15px;">
				<div class="index_nav_right" style="border-bottom-style:dotted;">
					Top Liked Books
				</div>
				<div>
					<ol>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF0000;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF3300;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF6600;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9900;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9933;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF9966;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FF99CC;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
			 			<li>程序员<span class="badge pull-right" style="background-color:#FFCCFF;color:#fff;">123</span></li>
					</ol>
				</div>
			</div>

		</div>	<!-- end class row -->
		<?php 
			*/
		?>
		<div style="font-size:14px;padding:5px 5px 5px 5px; border-bottom:1px solid #0088FF;margin-bottom:5px;">
			<b>Visitor Statistics</b>
		</div>
	  	<div class="row">
	  		<div>
	  		<canvas id="myChart" width="750" height="350"></canvas>
	  		</div>
	  		<?php 
	  			$chart_labs = "";
	  			$chart_values = "";
	  			foreach($ResultVisitors as $result)
	  			{
	  				$chart_labs = '"'.$result['month'].'-'.$result['day'].'",'.$chart_labs;
	  				$chart_values = $result["clicks"].",".$chart_values;
	  			}
	  		?>
	  		<script language="javascript">
	  		var data = {
	  				labels : [	<?php echo $chart_labs ?>
		  		  				//"09-01","09-02","09-03","09-04","09-05","09-06","09-07","09-08","09-09","09-10",
		  		  				//"09-11","09-12","09-13","09-14","09-15","09-16","09-17","09-18","09-19","09-20",
	  		  				],
	  				datasets : [
	  					{
	  						fillColor : "rgba(220,220,220,0.5)",
	  						strokeColor : "rgba(220,220,220,1)",
	  						data : [ <?php echo $chart_values ?>
	  		  						//65,59,90,81,56,55,40,90,81,56,
	  		  						//35,59,70,51,86,95,120,190,130,156,
	  		  						]
	  					},
	  					/*{
	  						fillColor : "rgba(151,187,205,0.5)",
	  						strokeColor : "rgba(151,187,205,1)",
	  						data : [28,48,40,19,96,27,100]
	  					}*/
	  				]
	  			}
	  		options = {
					
	  				//Boolean - If we show the scale above the chart data			
	  				scaleOverlay : true,
	  				
	  				//Boolean - If we want to override with a hard coded scale
	  				scaleOverride : false,
	  				
	  				//** Required if scaleOverride is true **
	  				//Number - The number of steps in a hard coded scale
	  				scaleSteps : null,
	  				//Number - The value jump in the hard coded scale
	  				scaleStepWidth : null,
	  				//Number - The scale starting value
	  				scaleStartValue : null,

	  				//String - Colour of the scale line	
	  				scaleLineColor : "#0088ff",
	  				
	  				//Number - Pixel width of the scale line	
	  				scaleLineWidth : 1,

	  				//Boolean - Whether to show labels on the scale	
	  				scaleShowLabels : true,
	  				
	  				//Interpolated JS string - can access value
	  				scaleLabel : "<%=value%>",
	  				
	  				//String - Scale label font declaration for the scale label
	  				scaleFontFamily : "'Arial'",
	  				
	  				//Number - Scale label font size in pixels	
	  				scaleFontSize : 12,
	  				
	  				//String - Scale label font weight style	
	  				scaleFontStyle : "normal",
	  				
	  				//String - Scale label font colour	
	  				scaleFontColor : "#4cae4c",	
	  				
	  				///Boolean - Whether grid lines are shown across the chart
	  				scaleShowGridLines : true,
	  				
	  				//String - Colour of the grid lines
	  				scaleGridLineColor : "rgba(0,0,0,.05)",
	  				
	  				//Number - Width of the grid lines
	  				scaleGridLineWidth : 1,	

	  				//Boolean - If there is a stroke on each bar	
	  				barShowStroke : true,
	  				
	  				//Number - Pixel width of the bar stroke	
	  				barStrokeWidth : 2,
	  				
	  				//Number - Spacing between each of the X value sets
	  				barValueSpacing : 5,
	  				
	  				//Number - Spacing between data sets within X values
	  				barDatasetSpacing : 1,
	  				
	  				//Boolean - Whether to animate the chart
	  				animation : true,

	  				//Number - Number of animation steps
	  				animationSteps : 60,
	  				
	  				//String - Animation easing effect
	  				animationEasing : "easeOutQuart",

	  				//Function - Fires when the animation is complete
	  				onAnimationComplete : null
	  				
	  			}
		  		//Get context with jQuery - using jQuery's .get() method.
		  		var ctx = $("#myChart").get(0).getContext("2d");
		  		//This will get the first returned node in the jQuery collection.
		  		new Chart(ctx).Bar(data,options);
			</script>
		</div>	<!-- end class row -->
			
 	</div><!-- end left body -->
 	
 	<div class="col-xs-12 col-sm-3 col-md-4" style="float:right;padding:5px 5px 5px 15px;">

	  	<div class="index_nav_right">
			<b>图书馆管理人员</b>
		</div>
		<table  class="table" width="100%">
			<tr>
				<td>工会宣传委</td>
				<td>Tang, Robin [hebihong@163.com]</td>
			</tr>
			<tr>
				<td>馆长事务及<br>技术支持</td>
				<td>He, Bihong [bihong.he@onelibrary.com]</td>
			</tr>
			<tr>
				<td>财务与采购</td>
				<td>
					Tang, Robin [hebihong@163.com]<br>
					Yu, Frances(frances.yu@onelibrary.com)
				</td>
			</tr>
			<tr>
				<td>值班考勤</td>
				<td>
					Zhang, Caiyun[hebihong@163.com]
				</td>
			</tr>
			<tr>
				<td colspan="2">

					<table class="table" width="100%">
						<tr>
							<td><b>志愿者</b></td>
							<td>Email</td>
							<td><b>位置</b></td>
						</tr>
						
						<?php 
						foreach($ResultLibrations as $result)
	  					{
	  						$email = explode("@", $result["email"])[0];
	  					?>
	  					<tr>
							<td><?php echo $result["user_name"] ?></td>
							<td><?php echo $email."@..." ?></td>
							<td><?php echo $result["seat"] ?></td>
						</tr>
	  					<?php 	
	  					}
						?>
						
						<!--  
						<tr>
							<td>Liu, Jane(jane.liu)</td>
							<td rowspan="3" valign="middle">4F</td>
							<td> </td>
						</tr>
						
						<tr>
							<td>Shi, Lei 4(lei.4.shi)</td>
							<td rowspan="1" valign="middle">4F</td>
							<td> </td>
						</tr>
						
						<tr>
							<td>Yu, Frances(frances.yu)</td>
							<td rowspan="2" valign="middle">8F</td>
							<td>8N1029</td>
						</tr>
						<tr>
							<td>Hou, Jiangtao(jiangtao.hou)</td>
							<td>8N1023</td>
						</tr>

						<tr>
							<td>He, Bihong(bihong.he)</td>
							<td rowspan="2" valign="middle">7F</td>
							<td>7E1012</td>
						</tr>
						<tr>
							<td>Liang, Alice(alice.liang)</td>
							<td>7N3010</td>
						</tr>

						<tr>
							<td>Tang, Robin(hebihong)</td>
							<td rowspan="5" valign="middle">6F</td>
							<td>6S1046</td>
						</tr>
						<tr>
							<td>Long, Catherine(catherine.long)</td>
							<td>6E0019</td>
						</tr>
						<tr>
							<td>Shi, Hong(hong.shi)</td>
							<td>6S2004</td>
						</tr>
						<tr>
							<td>Cheng, Matthew(matthew.cheng)</td>
							<td>6S1039</td>
						</tr>
						<tr>
							<td>Liao, Jack(jack.liao)</td>
							<td>6S1050</td>
						</tr>

						<tr>
							<td>Yue, Shuang(yue.shuang)</td>
							<td rowspan="1" valign="middle">5F</td>
							<td>5S1033</td>
						</tr>
						<tr>
							<td>Zheng, Yingkai(yingkai.zheng)</td>
							<td rowspan="1" valign="middle"></td>
							<td></td>
						</tr>						
						-->
					</table>
                     <font color=red>如果您也想加入我们志愿者行列，<B>且承诺每两个月至少值班服务一次</B>，请发邮件给bihong.he@onelibrary.com</font>
              
				</td>
			</tr>
		</table>

		<div class="index_nav_right">
			<b>Over Due Books</b>
		</div>
	  	<table  class="table" width="100%">
	  	<?php /*	<tr>
	  			<td colspan="3" style="color:green">
	  				共超期归还 <font color="red"><?php echo $ResultLibSummary["over_due_times"] ?></font> 人次，
	  				罚款已收 <font color="red"><?php echo round($ResultLibSummary["fin_received"],1) ?></font> 元
	  				未收 <font color="red"><?php echo round($ResultLibSummary["fin_need"],1) ?></font> 元
	  			</td>
	  		</tr>
	  		  		*/ ?>
	  		<tr>
	  			<td><b>Book Name</b></td>
	  			<td><b>Holder</b></td>
	  			<td><b>Due Date</b></td>
	  		</tr>
	  		<?php 
	  			$sec2days=3600*24*2;
	  			foreach($ResultOverDue as $result)
	  			{
	  				$duedate = shortDate($result["due_date"]);
					if(isset($result["due_date"]) && strtotime($result["due_date"])<(time()+$sec2days))
					{
						$duedate="<font color=red>".$duedate."</font>";
					}
					$holder = $result["holder_nsn_id"];
					if(strstr($holder,"00000"))
					{
						$holder = maskString($result["holder_name"]);
					}
					else 
					{
						$holder = maskString($result["holder_nsn_id"]);
					}
	  		?>
	  		<tr>
	  			<td>
	  				<a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$result["id"])); ?>" target="_blank" title="<?php echo $result["book_name"] ?>">
	  					<?php echo partString($result["book_name"],15) ?>
	  				</a>
	  			</td>
	  			<td><?php echo $holder ?></td>
	  			<td><?php echo $duedate ?></td>
	  		</tr>
	  		<?php 
	  			}
	  		?>
	  		<?php /*
	  		<tr>
	  			<td colspan="3">
	  				<div style="padding-left:5px;color:red;">
	  					超期罚款请转账给Tang, Robin（支付宝账号：18908172887， 账号名：唐斌）， 然后发邮件给hebihong@163.com并抄送给bihong.he@onelibrary.com。
	  				</div>
	  			</td>
	  		</tr>
	  		*/ ?>
	  	</table>		
	  	
	  	<div class="index_nav_right">
			<b>Top Borrowed Books</b>
		</div>
		<div>
	 		<ol>
	 			<?php 
	 				$int = 0;
	 				$backcolor = "#FFCCFF";
	 				foreach($ResultMostBorrowed as $result)
	 				{
	 					$int = $int+1;
	 					switch($int)
	 					{
	 						case 1: $backcolor = "#FF0000";break;
	 						case 2: $backcolor = "#FF3300";break;
	 						case 3: $backcolor = "#FF6600";break;
	 						case 4: $backcolor = "#FF9900";break;
	 						case 5: $backcolor = "#FF9966";break;
	 						default: $backcolor = "#FFCCFF";	 						
	 					}
	 			?>
	 			<li style="white-space:nowrap;"><a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$result["id"])); ?>" target="_blank" title="<?php echo $result["book_name"] ?>">
	 				<?php echo partString($result["book_name"],20) ?><span class="badge pull-right" style="background-color:<?php echo $backcolor ?>;color:#fff;"><?php echo $result["total_borrowed"] ?></span>
	 			</a></li>
	 			<?php 
	 				}
	 			?>
			</ol>
		</div>
			  	
	  	<div class="index_nav_right">
			<b>Top Liked Books</b>
		</div>
		<div>
	 		<ol>
	 			<?php 
	 				$int = 0;
	 				$backcolor = "#FFCCFF";
	 				foreach($ResultMostClicked as $result)
	 				{
	 					$int = $int+1;
	 					switch($int)
	 					{
	 						case 1: $backcolor = "#FF0000";break;
	 						case 2: $backcolor = "#FF3300";break;
	 						case 3: $backcolor = "#FF6600";break;
	 						case 4: $backcolor = "#FF9900";break;
	 						case 5: $backcolor = "#FF9966";break;
	 						default: $backcolor = "#FFCCFF";	 						
	 					}
	 			?>
	 			<li><a href="<?php echo Yii::app()->createUrl("library/search/viewfull", array("bkid"=>$result["id"])); ?>" target="_blank" title="<?php echo $result["book_name"] ?>">
	 				<?php echo partString($result["book_name"],20) ?><span class="badge pull-right" style="background-color:<?php echo $backcolor ?>;color:#fff;"><?php echo $result["total_clicks"] ?></span>
	 			</a></li>
	 			<?php 
	 				}
	 			?>
			</ol>
		</div>
		
	  	<?php 
	  		if(isset($ResultVote))
	  		{
	  	?>
		<div class="index_nav_right">
			<b>Vote</b>
		</div>
		<div>
			<div>
				Several Shanghai scientists announced today that an international team they led has discovered a molucular structure that relates to blood clotting in humans and could lead to new treatments for cardiovascular diseases. 
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
			<b>Comments & Suggest New Books</b>
		</div>
		<div>
			<div>
				You can tell us your favorite books here:
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