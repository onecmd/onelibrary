<div class="row" style="padding:5px 30px 5px 30px;">
		<form id="books_create" action="<?php echo $this->createUrl("addDonate") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">Book Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="book_name" name="Books[book_name]" placeholder="Requried">
				</div>
			</div>		
			<div class="form-group">
				<label for="user_id" class="col-sm-3 control-label">Donator NSN ID</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="user_id" name="Books[user_id]" placeholder="Requried">
				</div>
			</div>		
<!--  			<div class="form-group">
				<label for="user_name" class="col-sm-3 control-label">Donator Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="user_name" name="Books[user_name]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="user_email" class="col-sm-3 control-label">Donator Email</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="user_email" name="Books[user_email]" placeholder="">
				</div>
			</div>
			<div class="form-group">
				<label for="donate_time" class="col-sm-3 control-label">Donate Time</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_time" name="Books[donate_time]" value="<?php echo getCurTime(); ?>" placeholder="2015-3-19">
				</div>
			</div>-->
			<div class="form-group">
				<label for="book_id" class="col-sm-3 control-label">Book ID</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="book_id" name="Books[book_id]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="present" class="col-sm-3 control-label">Win Present</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="present" name="Books[present]"  placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="present_status" class="col-sm-3 control-label">Present status</label>
				<div class="col-sm-7">
								<select class="form-control" id="present_status" name="Books[present_status]">
									<option value="0" >Not Giving</option>
									<option value="1" >Has Giving</option>
								</select>
				</div>
			</div>				
			<!--  
			<div class="form-group">
				<label for="present_give_time" class="col-sm-3 control-label">Present Give Time</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="present_give_time" name="Books[present_give_time]"  value="<?php echo getCurTime(); ?>" placeholder="">
				</div>
			</div>	-->	
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="submit" class="btn btn-info">Add Donate</button>
        	<button type="reset" class="btn btn-default">Reset</button>
        	</div>
        </div>
		</form>
</div>
