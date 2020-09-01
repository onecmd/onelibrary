	<form id="books_reserve" action="<?php echo $this->createUrl("reserve") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_logo_new" class="col-sm-3 control-label">Book Logo</label>
				<div class="col-sm-7">
					<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$ResultBooks->book_logo ?>" style="margin:5px 0px 5px 4px;height:110px;width:120px;">
					<input type="hidden" class="form-control"  id="book_id" name="BooksHistory[book_id]" value="<?php echo $ResultBooks->id ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">Book Name</label>
				<div class="col-sm-7"><?php echo $ResultBooks->book_name ?></div>
			</div>		
			<div class="form-group">
				<label for="book_type" class="col-sm-3 control-label">Book Type</label>
				<div class="col-sm-7"><?php echo $BookTypeArray[$ResultBooks->book_type] ?></div>
			</div>		
			<div class="form-group">
				<label for="language" class="col-sm-3 control-label">Language</label>
				<div class="col-sm-7"><?php echo $ResultBooks->language ?></div>
			</div>
			<div class="form-group">
				<label for="owner_team" class="col-sm-3 control-label">Owner Team</label>
				<div class="col-sm-7"><?php echo $ResultBooks->owner_team ?></div>
			</div>		
			<div class="form-group">
				<label for="user_id" class="col-sm-3 control-label">User NSN ID</label>
				<div class="input-group col-sm-6">
					<?php 
						$nsn_id = isset(Yii::app()->session['preBorrower'])?Yii::app()->session['preBorrower']:"";
					?>
					<input type="text" class="form-control" id="user_id" name="BooksHistory[user_id]" value="<?php echo $nsn_id ?>" placeholder="Required">
					<span class="input-group-btn">
						<button type="button" class="btn btn-info" onclick='loadEmail("user_id", "user_email","<?php echo $this->createUrl("loademail",array("nsnid"=>"nsn_id"))?>")'>Load Email</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label for="user_email" class="col-sm-3 control-label">User Email</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="user_email" name="user_email" placeholder="New User Required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-10 control-label"><div id="borrow_fine_msg" style="color:red;padding-left:40px;text-align: center;"></div></label>
			</div>
			<div class="form-group">
				<label for="fine_overdue_per_day" class="col-sm-3 control-label">Fine Per Day</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="fine_overdue_per_day" name="BooksHistory[fine_overdue_per_day]" value="<?php echo $ResultBookType->overdue_fine_per_day ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="return_time" class="col-sm-3 control-label">Due Time</label>
				<div class="col-sm-7">
					<?php 
						$dayslimit = $ResultBookType->borrow_days_limit;
						$duetime = strtotime($dayslimit.' days');
						$week = date("w",$duetime);
						
						// on duty days is tuesday, friday
						if($week==0) // sunday, add 2 days:
							$duetime = date('Y-m-d', strtotime(($dayslimit+2).' days'));
						else if($week==1) // monday, add 1 days:	
							$duetime = date('Y-m-d', strtotime(($dayslimit+1).' days'));
						else if($week==2) // tuesday, add 0 days:	
							$duetime = date('Y-m-d', strtotime(($dayslimit+0).' days'));
						else if($week==3) // wendsday, add 2 days:	
							$duetime = date('Y-m-d', strtotime(($dayslimit+2).' days'));
						else if($week==4) // thirsday, add 1 days:	
							$duetime = date('Y-m-d', strtotime(($dayslimit+1).' days'));
						else if($week==5) // friday, add 0 days:	
							$duetime = date('Y-m-d', strtotime(($dayslimit+0).' days'));
						else if($week==6) // sateday, add 3 days:	
							$duetime = date('Y-m-d', strtotime(($dayslimit+3).' days'));
						?>
					<input type="text" class="form-control"  id="return_time" name="BooksHistory[return_time]" value="<?php echo $duetime ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="comments" class="col-sm-3 control-label">Comments</label>
				<div class="col-sm-7">
					<textarea id="comments" name="BooksHistory[comments]" class="form-control" rows="2"><?php echo $ResultBooks->comments ?></textarea>
				</div>
			</div>		
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="button" class="btn btn-success" onclick="ajaxSubmit('books_reserve', 'dlgbody')">Borrow</button>
        	<button type="reset" class="btn btn-info">Reset</button>
        	</div>
        </div>
	</form>
	