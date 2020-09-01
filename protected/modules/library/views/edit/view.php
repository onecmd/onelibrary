<div class="row">
<style type="text/css">
	label{font-weight:normal;}
</style>

	<div style="padding: 0px 10px 10px 10px;">
		<table border="0">
			<tr>
				<td colspan="2" align="center">
					<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$ResultBooks->book_logo ?>" style="margin:5px 0px 5px 4px;height:150px;width:180px;" />
				</td>
				<td colspan="2">
					<table border="0">
						<tr height="18">
							<td width="100" >Book Name:</td>
							<td style="color:#444"><?php echo htmlentities($ResultBooks->book_name,ENT_NOQUOTES,"utf-8") ?></td>
						</tr>	
						<tr height="18">
							<td>Book ID:</td>
							<td style="color:#444"><?php echo $ResultBooks->book_id ?></td>
						</tr>
						<?php 
							// status,0:ok for borrow;1:borrowed;2:removed
							$status = "Ok for borrow";
							$borrowtime = $ResultBooks->borrowed_time;
							$holder_name = $ResultBooks->holder_name;
							$due_date =  $ResultBooks->due_date;
							
							if($ResultBooks->status == 0)
							{
								$status = "<font color=green>Ok for borrow</font>";
								$borrowtime = "";
								$holder_name = "";
								$due_date = "";
							}
							else if($ResultBooks->status == 1)
							{
								$status = "<font color=red>Borrowed by ".$ResultBooks->holder_name."</font>";
								//$borrowtime = $ResultBooks->borrowed_time;
								$holder_name = "<font color=red>".$ResultBooks->holder_name."</font>";
								//$due_date =  $ResultBooks->due_date;
							}
							else 
							{
								$status = "Removed";
								$borrowtime = "";
								$holder_name = "";
								$due_date = "";
							}
						?>
						<tr height="18">
							<td>Status:</td>
							<td style="color:#444"><?php echo $status ?></td>
						</tr>
						<tr height="18">
							<td>Holder Name:</td>
							<td style="color:#444"><?php echo $holder_name ?></td>
						</tr>
						<tr height="18">
							<td>Borrowed Time:</td>
							<td style="color:#444"><?php echo $borrowtime ?></td>
						</tr>
						<tr height="18">
							<td>Due Date:</td>
							<td style="color:#444"><?php echo $due_date ?></td>
						</tr>
						<tr height="18">
							<td>Location:</td>
							<td style="color:#444"><?php echo ($ResultBooks->location_building==0?"A4 ":"E1 ").$ResultBooks->location_library ?></td>
						</tr>
						<tr height="18">
							<td>Category 1:</td>
							<td style="color:#444"><?php echo $ResultBooks->category_1 ?></td>
						</tr>
						<tr height="18">
							<td>Category 2:</td>
							<td style="color:#444"><?php echo $ResultBooks->category_2 ?></td>
						</tr>								
					</table>
				</td>
			</tr>
			<tr>
				<td height="10"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr height="18">
				<td>Tags:</td>
				<td style="color:#444" colspan="3"><?php echo htmlentities($ResultBooks->tags,ENT_NOQUOTES,"utf-8") ?></td>
			</tr>
			<tr>
				<td width="90" height="18">Book Type:</td>
				<td style="color:#444" width="160">
				<?php 
							foreach($ResultBooksType as $result)
							{
								if($result["id"] == $ResultBooks->book_type)
								{
									echo $result["type_name"];
									break;
								}
						  	}
						  ?>
				</td>
				<td width="90">Language:</td>
				<td style="color:#444"><?php echo htmlentities($ResultBooks->language,ENT_NOQUOTES,"utf-8") ?></td>
			</tr>
			<tr>
				<td width="90" height="18">Author:</td>
				<td style="color:#444" width="200"><?php echo htmlentities($ResultBooks->author,ENT_NOQUOTES,"utf-8") ?></td>
				<td width="90">Owner Team:</td>
				<td style="color:#444"><?php echo htmlentities($ResultBooks->owner_team,ENT_NOQUOTES,"utf-8") ?></td>
			</tr>
			<tr>
				<td width="90" height="18">ISBN:</td>
				<td style="color:#444"><?php echo htmlentities($ResultBooks->isbn,ENT_NOQUOTES,"utf-8") ?></td>
				<td width="90">Total Pages:</td>
				<td style="color:#444"><?php echo $ResultBooks->total_pages ?></td>
			</tr>
			<tr>
				<td width="90" height="18">Publish Time:</td>
				<td style="color:#444"><?php echo htmlentities($ResultBooks->publish_time,ENT_NOQUOTES,"utf-8") ?></td>
				<td width="90">Publisher:</td>
				<td style="color:#444"><?php echo htmlentities($ResultBooks->publisher,ENT_NOQUOTES,"utf-8") ?></td>
			</tr>
			<tr height="30">
				<td colspan="4">Book Summary:</td>
			</tr>
			<tr>
				<td colspan="4" style="color:#444">
						<?php
							$summsrc = htmlentities($ResultBooks->book_summary,ENT_NOQUOTES,"utf-8");
							$summ = mb_substr($summsrc, 0, 100, 'utf-8').'<div id = "showdiv" style="display:none;">'.mb_substr($summsrc, 100,mb_strlen($summsrc, 'utf-8'), 'utf-8').'</div>';
						?>
						<label><?php echo $summ ?>&nbsp;<div id="showbutn" style="display:inline">...<a href="#" onclick="showHideCode()">More ...</a></div></label>
						<script type="text/javascript"> 
								  function showHideCode(){
									 $("#showdiv").toggle();
									 $("#showbutn").hide();
								  }
						</script>		
				</td>
			</tr>
			<tr height="30">
				<td colspan="4">Suggest Reason:</td>
			</tr>
			<tr>
				<td colspan="4" style="color:#444">
					<?php echo htmlentities($ResultBooks->suggest_reason,ENT_NOQUOTES,"utf-8") ?>
				</td>
			</tr>
			<tr height="30">
				<td colspan="4">More URL:</td>
			</tr>
			<tr>
				<td colspan="4" style="color:#444">
					<label><a href="<?php echo htmlentities($ResultBooks->more_url,ENT_NOQUOTES,"utf-8") ?>" target="_blank">
							<?php echo htmlentities($ResultBooks->more_url,ENT_NOQUOTES,"utf-8") ?>&nbsp;
						</a></label>
				</td>
			</tr>	
		</table>
	</div>
</div>