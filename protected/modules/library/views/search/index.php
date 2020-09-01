
<style type="text/css">
    	.form-group{padding:5px 0px 5px 0px;margin-bottom:0px;font-size:13px;}
    	.form-control{padding:0px 0px 0px 0px;height:28px;}
</style>
<div class="panel-group" id="accordion" style="margin-top: 10px;margin-bottom: 5px;padding:0px 0px 0px 0px;">
  <div class="panel panel-default">
  <!-- 
    <div class="panel-heading" style="padding-top:8px;padding-bottom:8px;">
      <h4 class="panel-title text-right">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-info">
          Search Options
        </a>
      </h4>
    </div> 
    <div id="collapseOne" class="panel-collapse collapse">
    -->  <div class="panel-body" style="padding:10px 0px 10px 0px;">
    		<?php 
    			$showType = isset(Yii::app()->session['showType']) && Yii::app()->session['showType'] == "image"? "image" : "list";
    		?>
			<form id="tbimage_form" action="<?php echo $this->createUrl($showType) ?>" method="post" class="form-horizontal" role="form" style="margin-top:0px;">
				<div class="form-group">
					<label for="book_id" class="col-sm-2 control-label">Book ID</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="book_id" name="Books[book_id]" placeholder="">
					</div>
					<label for="book_name" class="col-sm-2 control-label">Book Name</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="book_name" name="Books[book_name]" placeholder="">
					</div>
				</div>		
				<div class="form-group">
					<label for="owner_team" class="col-sm-2 control-label">Owner Team</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="owner_team" name="Books[owner_team]" placeholder="">
					</div>
					<label for="book_type" class="col-sm-2 control-label">Book Type</label>
					<div class="col-sm-3">
						<select class="form-control" id="book_type" name="Books[book_type]">
						  <option value="0">All</option>
							<?php 
							foreach($BookTypeArray as $key=>$value)
							{
							?>
						  <option value="<?php echo $key?>"><?php echo $value ?></option>
						  <?php 
						  	}
						  ?>
						</select>
					</div>
				</div>		
				<div class="form-group">
					<label for="tags" class="col-sm-2 control-label">Tags</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="tags" name="Books[tags]" placeholder="">
					</div>
					<label for="language" class="col-sm-2 control-label">Language</label>
					<div class="col-sm-3">
						<select class="form-control" id="language" name="Books[language]">
						  <option value="all">All</option>
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
					<label for="author" class="col-sm-2 control-label">Author</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="author" name="Books[author]" placeholder="">
					</div>
						<label for="category_1" class="col-sm-2 control-label">Book Category</label>
						<div class="col-sm-3">
							<select class="form-control" id="category_1" name="Books[category_1]">
								<option value="">All</option>
								<?php 
									foreach ($BookCategory as $model)
									{
										$type_name=isset($BookTypeCodes[$model["category_1"]])?$BookTypeCodes[$model["category_1"]]:$model["category_1"];
								?>
								<option value="<?php echo $model["category_1"] ?>"><?php echo $type_name ?></option>
								<?php 
									}
								?>
							</select>
						</div>
					
					<!--
					<label for="publisher" class="col-sm-2 control-label">Publisher</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="publisher" name="Books[publisher]" placeholder="">
					</div>
					  
					<label for="isbn" class="col-sm-2 control-label">ISBN</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  id="isbn" name="Books[isbn]" placeholder="">
					</div>
					-->
				</div>
				<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-3">
							<select class="form-control" id="status" name="Books[status]">
								<option value="10">All</option>
								<option value="0">Ok For Borrow</option>
								<option value="1">Borrowed</option>
							</select>
						</div>
					<label for="location_building" class="col-sm-2 control-label">Location Building</label>
					<div class="col-sm-3">
							<select class="form-control" id="location_building" name="Books[location_building]">
								<option value="">All</option>
								<option value="0">A4 Chengdu</option>
								<option value="1">E2 Chengdu</option>
							</select>
					</div>
				</div>		
				<div class="form-group">
						<label for="sort_by" class="col-sm-2 control-label"><font color="blue">Sort By</font></label>
						
						<div class="col-sm-3">
							<select class="form-control" id="sort_by" name="Books[sort_by]">
								<option value="total_saygood">Say Good</option>
								<option value="add_time">Add Time </option>
								<option value="add_time_desc">Add Time Desc </option>
								<option value="total_borrowed">Borrowed</option>
								<option value="total_clicks">Searched</option>
								<option value="liked_num">Liked</option>
								<option value="category_2">Book Category</option>
								<option value="book_name">Book Name</option>
								<option value="due_date">Return Date</option>
							</select>
						</div>
						<label for="stock_total" class="col-sm-2 control-label"> </label>
					<div class="col-sm-3">
			        	<button type="button" class="btn btn-info col-sm-8" onclick="ajaxSubmit('tbimage_form', 'tbimage_search_result')">Search</button>
			        	<input type="hidden" id="page" name="page" value="0" >
		        	</div>
				</div>		
			</form>  
	      </div>
	    <!--  </div>-->
	  </div> 
	 </div>	<!-- end panel group  -->	
		<div class="row" id="tbimage_search_result">
		</div>		

<script language="javascript">
	var loadimg="<img src='<?php echo Yii::app()->request->baseUrl.'/img/load2.gif' ?>'>";
	function showPage(tabId, url){
		$('#maintab a[href="#'+tabId+'"]').tab('show');
		if($('#'+tabId+'_search_result').html().length<20){
			$('#'+tabId+'_search_result').html('<br>'+loadimg+' 页面加载中，请稍后...');
			ajaxSubmit(tabId+'_form', tabId+'_search_result');
			//$('#'+tabId+"_search_result").load(url);
		}
	}
	//showPage("tbimage","<?php echo $this->createUrl("image", array('page'=>'1'))?>");

	function ajaxSubmit(formid, tabId){
		ajaxCallUrl=$('#'+formid).attr("action");
		$.ajax({
           type: "POST",
           url:ajaxCallUrl,
           data:$('#'+formid).serialize(),
           async: false,
           error: function(request) {
        	   $('#'+tabId).html("修改失败:网络错误!");
           },
           success: function(data) {
                $('#'+tabId).html(data);
           } // end success
        });	// end ajax
	}
	ajaxSubmit('tbimage_form', 'tbimage_search_result');
	
	function loadPage(page){
		$('#page').val(page);
		//alert($('#page').val());
		ajaxSubmit('tbimage_form', 'tbimage_search_result');
	}
	
</script>