<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="maintab">
  <li class="active"><a href="#tbAddOneBook" role="tab" data-toggle="tab">Add One Book</a></li>
  <li><a href="#tbAddList" role="tab" data-toggle="tab">Load Books From File</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="tbAddOneBook">
		<form id="books_create" action="<?php echo $this->createUrl("add") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_id" class="col-sm-3 control-label">Book ID</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="book_id" name="Books[book_id]" placeholder="Requried">
				</div>
			</div>		
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">Book Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="book_name" name="Books[book_name]" placeholder="Requried">
				</div>
			</div>		
			<div class="form-group">
				<label for="book_logo_new" class="col-sm-3 control-label">Select image</label>
				<div class="col-sm-7">
					<!--  <img src="" style="margin:5px 0px 5px 4px;height:110px;width:120px;">-->
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
						?>
					  <option value="<?php echo $result["id"]?>"><?php echo $result["type_name"] ?></option>
					  <?php 
					  	}
					  ?>
					</select>
				</div>
			</div>		
			<div class="form-group">
				<label for="location_building" class="col-sm-3 control-label">Location Building</label>
				<div class="col-sm-7">
					<select class="form-control" id="location_building" name="Books[location_building]">
					  <option value="0">A4 Chengdu</option>
					  <option value="1">E1 Chengdu</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="location_library" class="col-sm-3 control-label">Location in Library</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="location_library" name="Books[location_library]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="owner_team" class="col-sm-3 control-label">Owner Team</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="owner_team" name="Books[owner_team]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="tags" class="col-sm-3 control-label">Tags</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="tags" name="Books[tags]" placeholder="If more than one, split by ','">
				</div>
			</div>
			<div class="form-group">
				<label for="language" class="col-sm-3 control-label">Language</label>
				<div class="col-sm-7">
					<select class="form-control" id="language" name="Books[language]">
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
				<label for="author" class="col-sm-3 control-label">Author</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="author" name="Books[author]" placeholder="">
				</div>
			</div>
			<div class="form-group">
				<label for="isbn" class="col-sm-3 control-label">ISBN</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="isbn" name="Books[isbn]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="total_pages" class="col-sm-3 control-label">Total Pages</label>
				<div class="col-sm-7">
					<input type="number" class="form-control"  id="total_pages" name="Books[total_pages]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="publish_time" class="col-sm-3 control-label">Publish Time</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="publish_time" name="Books[publish_time]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="publisher" class="col-sm-3 control-label">Publisher</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="publisher" name="Books[publisher]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="book_summary" class="col-sm-3 control-label">Book Summary</label>
				<div class="col-sm-7">
					<textarea id="book_summary" name="Books[book_summary]" class="form-control" rows="6" placeholder=""></textarea>
				</div>
			</div>		
			<div class="form-group">
				<label for="suggest_reason" class="col-sm-3 control-label">Suggest Reason</label>
				<div class="col-sm-7">
					<textarea id="suggest_reason" name="Books[suggest_reason]" class="form-control" rows="2" placeholder=""></textarea>
				</div>
			</div>		
			<div class="form-group">
				<label for="more_url" class="col-sm-3 control-label">More URL</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="more_url" name="Books[more_url]" placeholder="">
				</div>
			</div>		
			<hr size="1">
			<div class="form-group">
				<label for="donate_nsn_id" class="col-sm-3 control-label">Donate NSN ID</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_nsn_id" name="Books[donate_nsn_id]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="donate_name" class="col-sm-3 control-label">Donate Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_name" name="Books[donate_name]" placeholder="">
				</div>
			</div>		
			<div class="form-group">
				<label for="donate_time" class="col-sm-3 control-label">Donate Time</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="donate_time" name="Books[donate_time]" placeholder="">
				</div>
			</div>		
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="submit" class="btn btn-info">Add this book</button>
        	<button type="reset" class="btn btn-default">Reset</button>
        	</div>
        </div>
		</form>
`	</div> <!--  end tab -->

	<div class="tab-pane" id="tbAddList">
		<form action="<?php echo $this->createUrl("loadfromcsv") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-9" style="padding:10px 20px 50px 20px;line-height:28px;">
					<b>Steps:</b><br>
					1, Download the template: 
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/upload/books_template.xlsx" target="_blank">books_template.xlsx</a>;<br>
					2, Fill the books infomation to the excel file and save;<br>
					3, Make sure the operation system support GBK format;<br>
					4, Save the excel file as a new csv file;<br>
					5, Upload the csv file: <br><br>
					<input type="file" name="csv_file_books"> 
					<button type="submit" class="btn btn-primary">Upload Books</button>
					<br><br>
					6, Upload and change the book logo in the edit page.<br>
				</div>
			</div>	
		</form>	
	</div><!--  end tab -->
</div>
