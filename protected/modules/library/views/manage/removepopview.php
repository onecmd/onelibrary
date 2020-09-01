	<form id="books_remove" action="<?php echo $this->createUrl("remove") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_logo_new" class="col-sm-3 control-label">Book Logo</label>
				<div class="col-sm-7">
					<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$ResultBooks->book_logo ?>" style="margin:5px 0px 5px 4px;height:110px;width:120px;">
					<input type="hidden" class="form-control"  id="book_id" name="Books[book_id]" value="<?php echo $ResultBooks->id ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">Book Name</label>
				<div class="col-sm-7"><?php echo $ResultBooks->book_name ?></div>
			</div>		
			<div class="form-group">
				<label for="book_id" class="col-sm-3 control-label">Book ID</label>
				<div class="col-sm-7"><?php echo $ResultBooks->book_id ?></div>
			</div>		
			<div class="form-group">
				<label for="owner_team" class="col-sm-3 control-label">Owner Team</label>
				<div class="col-sm-7"><?php echo $ResultBooks->owner_team ?></div>
			</div>		
			<div class="form-group">
				<label for="language" class="col-sm-3 control-label">Language</label>
				<div class="col-sm-7"><?php echo $ResultBooks->language ?></div>
			</div>
			<div class="form-group">
				<label for="author" class="col-sm-3 control-label">author</label>
				<div class="col-sm-7"><?php echo $ResultBooks->author ?></div>
			</div>
			<div class="form-group">
				<label for="publisher" class="col-sm-3 control-label">publisher</label>
				<div class="col-sm-7"><?php echo $ResultBooks->publisher ?></div>
			</div>
			<div class="form-group">
				<label for="publish_time" class="col-sm-3 control-label">publish_time</label>
				<div class="col-sm-7"><?php echo $ResultBooks->publish_time ?></div>
			</div>
			<div class="form-group">
				<label for="comments" class="col-sm-3 control-label">Comments</label>
				<div class="col-sm-7">
					<textarea id="comments" name="comments" class="form-control" rows="2" ><?php echo $ResultBooks->comments ?></textarea>
				</div>
			</div>		
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="button" class="btn btn-success" onclick="ajaxSubmit('books_remove', 'dlgbody')">Remove this book</button>
        	</div>
        </div>
	</form>