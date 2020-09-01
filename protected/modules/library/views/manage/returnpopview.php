<?php
	header('Content-Type:text/html;charset=gbk');
?>
	<form id="books_return" action="<?php echo $this->createUrl("return") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_logo_new" class="col-sm-3 control-label">Book Logo</label>
				<div class="col-sm-7">
					<img src="<?php echo Yii::app()->request->baseUrl."/".getBookLogoPath()."/".$ResultBooks->book_logo ?>" style="margin:5px 0px 5px 4px;height:110px;width:120px;">
					<input type="hidden" class="form-control"  id="book_id" name="Books[book_id]" value="<?php echo $ResultBooks->id ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">Book Name</label>
				<div class="col-sm-7"><?php echo iconv('UTF-8','GBK', $ResultBooks->book_name) ?></div>
			</div>		
			<div class="form-group">
				<label for="holder_nsn_id" class="col-sm-3 control-label">Holder</label>
				<div class="col-sm-7"><?php echo $ResultBooks->holder_name."[ID:".$ResultBooks->holder_nsn_id.", ".$ResultBooks->holder_email."]" ?></div>
			</div>
			<div class="form-group">
				<label for="borrowed_time" class="col-sm-3 control-label">Borrow Time</label>
				<div class="col-sm-7"><?php echo $ResultBooks->borrowed_time ?></div>
			</div>
			<div class="form-group">
				<label for="due_date" class="col-sm-3 control-label">Due Time</label>
				<div class="col-sm-7"><?php echo $ResultBooks->due_date ?></div>
			</div>
			<div class="form-group">
				<label for="fine_overdue_per_day" class="col-sm-3 control-label">Fine Per Day</label>
				<div class="col-sm-7"><?php echo $ResultBooks->fine_overdue_per_day ?></div>
			</div>
			<?php 
				$totaldays = floor((time()-strtotime($ResultBooks->due_date))/86400);
				$fine = $ResultBooks->fine_overdue_per_day * $totaldays;
				$maxfine=intval(SiteSystemParameters::getParmValue('OverDueMaxFine'));
				if($fine<0)
				{
				 	$fine="0.0";
				}	
				else if($fine>$maxfine)	
				{
				 	$fine =	$maxfine;
				}
			?>
			<div class="form-group">
				<label for="overdue_fine" class="col-sm-3 control-label">Overdue Fine</label>
				<div class="col-sm-7">
					<?php
						if($fine>0){
					?>
					<font color=red>
						请提醒还书者将罚款转账到Tang, Robin的支付宝账号，并发邮件给Tang, Robin与He, Bihong， 不再以现金方式收取。<br>
						<b>请务必正确填写实际需要收取的罚金（扣除假期等时间）</B>：
					</font>
					<?php } ?>
					<input type="text" class="form-control"  id="overdue_fine" name="overdue_fine" value="<?php echo $fine ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="comments" class="col-sm-3 control-label">Comments</label>
				<div class="col-sm-7">
					<textarea id="comments" name="comments" class="form-control" rows="2"><?php echo $ResultBooks->comments ?></textarea>
				</div>
			</div>		
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="button" class="btn btn-success" onclick="ajaxSubmit('books_return', 'dlgbody')">Return The Book</button>
        	</div>
        </div>
	</form>