		<form action="<?php echo $this->createUrl("loadmagazinefromcsv") ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-9" style="padding:10px 20px 50px 20px;line-height:28px;">
					<b>历史借书记录导入</b><br>
					<b>Steps:</b><br>
					1, Download the template: 
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/upload/old_records_template.xlsx" target="_blank">old_records_template.xlsx</a>;<br>
					2, Fill the books infomation to the excel file and save;<br>
					3, Make sure the operation system support GBK format;<br>
					4, Save the excel file as a new csv file;<br>
					5, Upload the csv file: <br><br>
					<input type="file" name="csv_file_old_records"> 
					<button type="submit" class="btn btn-primary">Upload Old Records</button>
					<br><br>
					6, All done.<br>
				</div>
			</div>	
		</form>	