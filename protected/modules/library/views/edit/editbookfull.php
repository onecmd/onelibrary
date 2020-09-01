	<form id="books_edit" action="<?php echo Yii::app()->createUrl("library/edit/editfull") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_id" class="col-sm-3 control-label">Book ID</label>
				<div class="col-sm-7">
					<input type="hidden" id="id" name="Books[id]" value="<?php echo $ResultBooks->id ?>">
					<input type="text" class="form-control"  id="book_id" name="Books[book_id]" value="<?php echo htmlspecialchars($ResultBooks->book_id) ?>" placeholder="Requried">
				</div>
			</div>		
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">Book Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="book_name" name="Books[book_name]" value="<?php echo htmlspecialchars($ResultBooks->book_name,ENT_NOQUOTES,"utf-8") ?>" placeholder="Requried">
				</div>
			</div>		
			<div class="form-group">
				<label for="book_logo_new" class="col-sm-3 control-label">Select image</label>
				<div class="col-sm-7">
					<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$ResultBooks->book_logo ?>" style="margin:5px 0px 5px 4px;height:110px;width:120px;">
					<input type="file"   id="book_logo_new" name="book_logo_new">
				</div>
			</div>
			<div class="form-group">
				<label for="book_type" class="col-sm-3 control-label">Book Type</label>
				<div class="col-sm-7">
					<select class="form-control" id="book_type" name="Books[book_type]">
						<?php 
						foreach($ResultBooksType as $result)
						{
							$select = ($result["id"] == $ResultBooks->book_type) ? "selected" : "";
						?>
					  <option value="<?php echo $result["id"]?>" <?php echo $select ?>><?php echo $result["type_name"] ?></option>
					  <?php 
					  	}
					  ?>
					</select>
				</div>
			</div>		
			<div class="form-group">
				<label for="location_library" class="col-sm-3 control-label">Location in Library</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="location_library" name="Books[location_library]" value="<?php echo htmlspecialchars($ResultBooks->location_library,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="owner_team" class="col-sm-3 control-label">Owner Team</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="owner_team" name="Books[owner_team]" value="<?php echo htmlspecialchars($ResultBooks->owner_team,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="tags" class="col-sm-3 control-label">Tags</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="tags" name="Books[tags]" value="<?php echo htmlspecialchars($ResultBooks->tags,ENT_NOQUOTES,"utf-8") ?>" placeholder="If more than one, split by ','">
				</div>
			</div>
			<div class="form-group">
				<label for="language" class="col-sm-3 control-label">Language</label>
				<div class="col-sm-7">
					<select class="form-control" id="language" name="Books[language]">
					  <option value="Chinese" <?php echo $ResultBooks->language == "Chinese"? "selected" : ""?>>Chinese</option>
					  <option value="English" <?php echo $ResultBooks->language == "English"? "selected" : ""?>>English</option>
					  <option value="Finnish" <?php echo $ResultBooks->language == "Finnish"? "selected" : ""?>>Finnish</option>
					  <option value="French" <?php echo $ResultBooks->language == "French"? "selected" : ""?>>French</option>
					  <option value="German" <?php echo $ResultBooks->language == "German"? "selected" : ""?>>German</option>
					  <option value="Spanish" <?php echo $ResultBooks->language == "Spanish"? "selected" : ""?>>Spanish</option>
					  <option value="Japanese" <?php echo $ResultBooks->language == "Japanese"? "selected" : ""?>>Japanese</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="author" class="col-sm-3 control-label">Author</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="author" name="Books[author]" value="<?php echo htmlspecialchars($ResultBooks->author,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>
			<div class="form-group">
				<label for="isbn" class="col-sm-3 control-label">ISBN</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="isbn" name="Books[isbn]" value="<?php echo htmlspecialchars($ResultBooks->isbn,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="total_pages" class="col-sm-3 control-label">Total Pages</label>
				<div class="col-sm-7">
					<input type="number" class="form-control"  id="total_pages" name="Books[total_pages]" value="<?php echo $ResultBooks->total_pages ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="publish_time" class="col-sm-3 control-label">Publish Time</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="publish_time" name="Books[publish_time]" value="<?php echo htmlspecialchars($ResultBooks->publish_time,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="publisher" class="col-sm-3 control-label">Publisher</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="publisher" name="Books[publisher]" value="<?php echo htmlspecialchars($ResultBooks->publisher,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="book_summary" class="col-sm-3 control-label">Book Summary</label>
				<div class="col-sm-7">
					<textarea id="book_summary" name="Books[book_summary]" class="form-control" rows="6" placeholder=""><?php echo htmlspecialchars($ResultBooks->book_summary,ENT_NOQUOTES,"utf-8") ?></textarea>
				</div>
			</div>		
			<div class="form-group">
				<label for="suggest_reason" class="col-sm-3 control-label">Suggest Reason</label>
				<div class="col-sm-7">
					<textarea id="suggest_reason" name="Books[suggest_reason]" class="form-control" rows="2" placeholder=""><?php echo htmlspecialchars($ResultBooks->suggest_reason,ENT_NOQUOTES,"utf-8") ?></textarea>
				</div>
			</div>		
			<div class="form-group">
				<label for="more_url" class="col-sm-3 control-label">More URL</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="more_url" name="Books[more_url]" value="<?php echo htmlspecialchars($ResultBooks->more_url,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<hr size="1">
			<div class="form-group">
				<label for="donate_nsn_id" class="col-sm-3 control-label">Donate NSN ID</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_nsn_id" name="Books[donate_nsn_id]" value="<?php echo htmlspecialchars($ResultBooks->donate_nsn_id,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="donate_name" class="col-sm-3 control-label">Donate Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_name" name="Books[donate_name]" value="<?php echo htmlspecialchars($ResultBooks->donate_name,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="donate_time" class="col-sm-3 control-label">Donate Time</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_time" name="Books[donate_time]" value="<?php echo htmlspecialchars($ResultBooks->donate_time,ENT_NOQUOTES,"utf-8") ?>" placeholder="">
				</div>
			</div>			<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="submit" class="btn btn-info" > &nbsp; Save &nbsp; </button>
        	<button type="reset" class="btn btn-default">Reset</button>
        	</div>
        </div>
	</form>
	