<div class="row">
<style type="text/css">
	label{font-weight:normal;}
	.lefttd{background-color:#66CCCC;height:24px;width:120px;}
	td{padding-left:5px;}
	hr{margin-top:2px;margin-bottom:4px;}
	.tmlime_line{border-left:dotted 2px #66CC00;height:10px;padding-left:20px;margin-left:10px;}
	.tmline_body{color:#FF9900;font-size:40px;}
	.tmline_time{color:#FF6633;font-size:14px;font-weight:bold;}
	.tmline_name{color:#3366CC;font-size:13px;font-weight:bold;width:120px;}
	.tmline_text{color:#3366CC;font-size:13px;}
	.tmline_return{color:#33CC33;}
	.waitlay{margin-bottom: 5px;margin-top: 5px;width:120px;background-color:#FF9933;color:#fff;float:left;padding:5px 5px 5px 5px;text-align:center}
	.waitlayicon{float:left;padding:15px 20px 10px 20px;font-size:28px;}
</style>
	<div class="col-xs-12 col-sm-12 col-md-12" style="border:solid 0px #ff0000;">
		<div class="form-group">
			<div class="col-xs-12 col-sm-5 col-md-5 text-center" style="text-align:center;padding:10px 5px 5px 5px;">
				<div class="thumbnail" style="margin-bottom: 0px;">
					<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$ResultBooks->book_logo ?>" style="width:80%;"/>
				    <div class="caption">
				        <h5><b><?php echo htmlentities($ResultBooks->book_name,ENT_NOQUOTES,"utf-8") ?></b></h5>
						<?php 
							$action = $this->createUrl("likeit");
							$mywaiting = null;
							
							$myuser = RoleUtil::getUser();
							$bttext = "Like It";
							
							// if not log in:
							if(!isset($myuser))
							{
								$action = Yii::app()->createUrl("default/login");
							}
							// if login:
							else
							{
								$likes = BooksLikes::model()->findByAttributes(array("user_id"=>$myuser->nsn_id, "book_id"=>$ResultBooks->id, "is_like"=>1));
								if(isset($likes))
								{
									$action = $this->createUrl("unlikeit");
									$bttext = "Unlike";
								}
								
								///////////////////////////
								// for waiting:
								foreach ($BooksWaiting as $waiting)
								{
									if($waiting->user_id == RoleUtil::getUser()->nsn_id)
									{ // in waiting queue:
										$mywaiting = $waiting;
										break;
									}
								}
								
							}
						?>
				        <form action="<?php echo $action ?>" method="post">
				        	<a href="<?php echo $this->createUrl("sayGood", array("bkid"=>$ResultBooks->id)) ?>"  role="button" class="btn btn-success">点赞(<?php echo $ResultBooks->total_saygood ?>)</a>
				        	<input type="hidden" name="bkid" value="<?php echo $ResultBooks->id?>">
				        	<input type="hidden" name="book_name" value="<?php echo $ResultBooks->book_name?>">
				        	<a href="#btcomments" onclick='javascript:$("#btcomments").click();' role="button" class="btn btn-success">Comment</a>
				        	<input type="submit" class="btn btn-warning" value="<?php echo $bttext?>(<?php echo $ResultBooks->liked_num?>)">
				        </form>
				   	</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-7 col-md-7" style="padding:10px 5px 5px 5px;">
				<table class="col-xs-12 col-sm-12 col-md-12" border="1" style="border:1px solid #99CCCC;border-collapse: collapse;line-height:20px;color:#666;">
					<tr>
						<td class="lefttd">Book Name</td>
						<td>
							<b>
								<?php echo htmlentities($ResultBooks->book_name,ENT_NOQUOTES,"utf-8") ?>
							</b>
						</td>
					</tr>
					<?php 
						if(!empty($ResultBooks->donate_nsn_id) || !empty($ResultBooks->donate_name))
						{
							$doname_name = isset($ResultBooks->donate_name)?$ResultBooks->donate_name:$ResultBooks->donate_nsn_id;
					?>
					<tr>
						<td colspan="2" height="30" ><b><font color="red"> &nbsp; &nbsp; This book donated by 
						<font color="blue"><?php echo $doname_name ?></font> on  <?php echo $ResultBooks->donate_time ?> ！</font></b></td>
					</tr>
					<?php 
						}
					?>
					<tr>
						<td class="lefttd">Numbers</td>
						<td>
							赞(<font color="red"><?php echo $ResultBooks->total_saygood ?></font>) &nbsp; 
							Searched(<font color="red"><?php echo $ResultBooks->total_clicks ?></font>) &nbsp; 
							Liked(<font color="red"><?php echo $ResultBooks->liked_num ?></font>) &nbsp; 
							Readed(<font color="red"><?php echo $ResultBooks->total_borrowed ?></font>) 
						</td>
					</tr>
					<tr>
						<td class="lefttd">Book ID</td>
						<td><?php echo $ResultBooks->book_id ?></td>
					</tr>
					<tr>
						<td class="lefttd">Book Type</td>
						<td><?php 
							foreach($ResultBooksType as $result)
							{
								if($result["id"] == $ResultBooks->book_type)
								{
									echo $result["type_name"];
									break;
								}
						  	}
						  ?></td>
					</tr>
					<tr>
						<td class="lefttd">Book Category</td>
						<td><?php echo $ResultBooks->category_1."-".$ResultBooks->category_2 ?></td>
					</tr>
					<tr>
						<td class="lefttd">Owner Team</td>
						<td><?php echo htmlentities($ResultBooks->owner_team,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">Language</td>
						<td><?php echo htmlentities($ResultBooks->language,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">ISBN</td>
						<td><?php echo htmlentities($ResultBooks->isbn,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">Total Pages</td>
						<td><?php echo $ResultBooks->total_pages ?></td>
					</tr>
					<tr>
						<td class="lefttd">Author</td>
						<td><?php echo htmlentities($ResultBooks->author,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">Publisher</td>
						<td><?php echo htmlentities($ResultBooks->publisher,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">Publish Time</td>
						<td><?php echo htmlentities($ResultBooks->publish_time,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">Tags</td>
						<td><?php echo htmlentities($ResultBooks->tags,ENT_NOQUOTES,"utf-8") ?></td>
					</tr>
					<tr>
						<td class="lefttd">Location</td>
						<td><?php echo ($ResultBooks->location_building==0?"A4 ":"E2 ").$ResultBooks->location_library ?></td>
					</tr>
					<tr>
						<td class="lefttd">Status</td>
						<td><b><font color="red">
						<?php 
							if($ResultBooks->status==1)
							{
								echo "Hold In: ".$ResultBooks->holder_name. "";
							}
							else
							{
								echo $this->parseBookStatus($ResultBooks->status)." in ".htmlentities($ResultBooks->location_library,ENT_NOQUOTES,"utf-8");
							}
							
						?>
						</font></b></td>
					</tr>
					<tr>
						<td class="lefttd">Return before:</td>
						<td><?php echo $ResultBooks->status==1?shortDate($ResultBooks->due_date):"" ?></td>
					</tr>
					
				</table>
			</div> <!-- end right -->
		</div> 
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12" style="border:solid 0px #ff0000;padding:5px 20px 5px 20px;">
		<div class="panel panel-info">
		  <div class="panel-heading"><b>Reserve List - 排队等候借阅，书籍被归还时，将为您保留一段时间，原则上按排队顺序先排先借，请随时关注书籍归还时间，过期不候</b></div>
		  <div class="panel-body">
			<div class="thumbnail waitlay" style="background-color:#FF9900;">
				<?php echo $ResultBooks->status==1?$ResultBooks->holder_name:"Available" ?><br>
				<?php echo $ResultBooks->status==1?"Return < ".shortDate($ResultBooks->due_date):"For Borrow" ?>
			</div>
			<?php 
			foreach ($BooksWaiting as $waiting)
			{
			?>
			<span class="glyphicon glyphicon-arrow-left waitlayicon"></span>
				<?php 
				// if current user waiting:
				if(isset($myuser) && $waiting->user_id == $myuser->nsn_id)
				{
					$waiturl = $this->createUrl("cancelWaiting",array(
											"book_id"=>$ResultBooks->id,
											));
				?>
			<div class="thumbnail waitlay" style="background-color:#33CC00;">
				<span class="glyphicon glyphicon-user"></span>
				<a href="<?php echo $waiturl ?>" style="color: #fff;">I'm Here<br>
				Cancel Reserve</a>
			</div>
				<?php 
				}
				else // other user waiting:
				{
				?>
			<div class="thumbnail waitlay" style="background-color:#<?php echo $waiting->status==0?'FF9933':'FF6622'?>;">
				<span class="glyphicon glyphicon-user"></span>
				<?php echo $waiting->user_name ?><br>
				<?php echo cutDate($waiting->join_time) ?>
			</div>
				<?php 
				}
				?>
			<?php 
			}
			if(!isset($mywaiting))
			{
				$waiturl = $this->createUrl("joinWaiting",array(
										"id"=>$ResultBooks->id,
										"book_name"=>$ResultBooks->book_name,
										"book_id"=>$ResultBooks->book_id,
										));
			?>
			<span class="glyphicon glyphicon-arrow-left waitlayicon"></span>
			<div class="thumbnail waitlay" style="background-color:#33CC00;">
				<a href="<?php echo $waiturl ?>" style="color: #fff;">Reserve The<br>
				Book</a>
			</div>
			<?php 	
			}
			?>
		  </div>
		</div>
	</div>	
	
	<div class="col-xs-12 col-sm-12 col-md-12" style="border:solid 0px #ff0000;padding:5px 20px 5px 20px;">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist" id="maintab">
	  <li class="active"><a href="#tbreadhis" role="tab" data-toggle="tab"><b>Read History</b></a></li>
	  <li><a href="#tbsummary" role="tab" data-toggle="tab"><b>Summary</b></a></li>
	  <li><a href="#tbcomment" role="tab" data-toggle="tab" id="btcomments"><b>读后感</b></a></li>
	  <li><a href="#tblikes" role="tab" data-toggle="tab"><b>Who Likes</b></a></li>
	</ul>
	
	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane" id="tbsummary" style="padding:10px 20px 10px 20px;color:#444;">
			<?php echo htmlentities($ResultBooks->book_summary,ENT_NOQUOTES,"utf-8") ?>
			
			<br><br><b>Suggest Reason:</b><br>
			<hr size="1">
			<?php echo htmlentities($ResultBooks->suggest_reason,ENT_NOQUOTES,"utf-8") ?>

			<br><br><b>More Links:</b><br>
			<hr size="1">
			<a href="<?php echo htmlentities($ResultBooks->more_url,ENT_NOQUOTES,"utf-8") ?>" target="_blank">
				<?php echo htmlentities($ResultBooks->more_url,ENT_NOQUOTES,"utf-8") ?>
			</a>
		</div>
		<div class="tab-pane" id="tbcomment" style="padding:10px 10px 10px 10px;">
			<?php 
				$action = $this->createUrl("addComment");
				$bttext = "submit";
				if(!isset(Yii::app()->session['user']))
				{
					$bttext = "Login";
					$action = Yii::app()->createUrl("default/login");
				}
			?>
			<form action="<?php echo $action?>" method="post">
				<div class="form-group">
				<div class="row">
					<div class="col-sm-8">
						<input type="hidden" name="book_id" value="<?php echo $ResultBooks->id?>">
						<textarea class="form-control"  id="comments" name="comments"></textarea>
					</div>
					<div class="col-sm-4">
						<input type="submit" class="btn btn-success" value="<?php echo $bttext ?>" >
					</div>
				</div>		
				</div>
			</form>
			<hr size="1">
			<?php 
				$total = 0;
				foreach($Comments as $model)
				{
					$total = $total+1;
			?>
				<div class="row" style="padding:5px 30px 10px 20px;">
					<?php echo $model->user_name ?> <?php echo $model->add_time ?>
					<hr size="1">
					<?php echo $model->comments ?>
				</div>
			<?php 
				}
				if($total<1)
				{
					echo "No comments!";
				}
			?>
		</div>
		<div class="tab-pane" id="tblikes" style="padding:10px 10px 10px 10px;">
			<?php 
				$total = 0;
				foreach($BookLikes as $model)
				{
					$total = $total+1;
			?>
				<div class="tmlime_line"></div>
				<div class="tmline_body <?php echo $model->is_like==1?"tmline_return" :""?>">
					● 
					<font class="tmline_time"><?php echo $model->add_time ?></font> 
					<font class="tmline_name"><?php echo $model->user_name ?></font>
					<font class="tmline_text <?php echo $model->is_like==1?"tmline_return" :""?>"><?php echo $model->is_like==1?"Like the book.":"Unlike the book."?>.</font>
				</div>  
				<div class="tmlime_line"></div>
			<?php 
				}
				if($total<1)
				{
					echo "No body like the book!";
				}
			?>		
		</div>
		<div class="tab-pane active" id="tbreadhis" style="padding:10px 10px 10px 60px;">
			<?php 
				$total = 0;
				foreach($ReadHistory as $model)
				{
					$total = $total+1;
					$isreturn = $model->is_return==1 ? true : false;
					$days = floor((strtotime($model->actual_return_time)-strtotime($model->borrow_time))/86400);
					if(strtotime($model->actual_return_time)<strtotime($model->borrow_time))
					{
						$isreturn = false;
						$days = 0;
					}
			?>
				<div class="tmlime_line"></div>
				<div style="clear: both;font-size:13px;">
					<div style="float:left;font-size:40px;color:<?php echo $isreturn?"#33CC33;":"#FF9900;"?>">● </div>
					<div style="float:left;padding:24px 10px 0px 10px;">
						<font color="#FF9900"><?php echo $model->user_name ?> </font>
						<br>
						<font color="#666">Borrowed on </font> 
						<?php echo date('Y-m-d',strtotime($model->borrow_time)) ?> 
						<?php 
							if($isreturn)
							{
						?>
						<font color="#666">Returned on  </font> 
						<?php echo date('Y-m-d',strtotime($model->actual_return_time)) ?> 
						<font color="#666">Hold for  </font>
						<?php echo $days ?> 	
						<font color="#666">Days. </font>
						<?php 
							}
						?>
					</div>
				</div>
			<?php 
				}
				if($total<1)
				{
					echo "No body readed!";
				}
			?>
		
		</div>
	</div>	
	</div>
</div>