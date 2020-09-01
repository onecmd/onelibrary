<div class="row" style="padding:5px 30px 5px 30px;">
<?php 
			$formUrl=$this->createUrl("addBuy");
			$buttonText="Add Request";
			if(isset($ResultBuyRequest)){
				$formUrl=$this->createUrl("editBuyRequest") ;
				$buttonText="Save Request";
			}
		?>
		
		<form id="buy_request_form" action="<?php echo $formUrl ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<label for="book_url" class="col-sm-3 control-label"></label>
				<div class="col-sm-7">
					<font color="orange">以下信息尽量完整正确填写，我们会优先审批、采购资料完整、项目需要、易于采购（网购）的书单。</font><br>
					<font color="red">如果想自购，请在备注中注明。</font><br>
					<font>自购流程：
						<ol>
							<li>会员在下面提交申请，备注自购</li>
							<li>图书馆在预算条件许可情况下Accept到自购采购计划</li>
							<li>员工购买</li>
							<li>员工持发票到图书馆财务(hebihong@163.com)报销</li>
							<li>图书馆标记书籍状态为已购买，录入系统，自购员工可首先借阅</li>
						</ol>
						</font>
					<font>自购书籍所有权属<b>工会图书馆<b>。</font>
				</div>
			</div>
			<div class="form-group">
				<label for="book_name" class="col-sm-3 control-label">书名（必填）</label>
				<div class="col-sm-7">
					<?php 
						if(isset($ResultBuyRequest)){
					?>
					<input type="hidden" class="form-control"  id="id" name="BooksBuyRequest[id]" placeholder="Requried" value="<?php echo $ResultBuyRequest->id ?>">
					<?php 
						}
					?>
					
					<div class="dropdown">
						<input id="newbuy_book_name" type="text" class="form-control" 
						onpropertychange='loadBuyedBooks("<?php echo $this->createUrl("loadExistBooksByName") ?>", this.value)' 
						oninput='loadBuyedBooks("<?php echo $this->createUrl("loadExistBooksByName") ?>", this.value)' 
						
						autoComplete='off' name="BooksBuyRequest[book_name]" placeholder="Requried" value="<?php 
						if(isset($ResultBuyRequest)) {
							echo $ResultBuyRequest->book_name;
						}
						?>"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						 <ul class="dropdown-menu" aria-labelledby="dLabel" id="buyedBooksList">
						    <li>&nbsp; 馆中已存在下面书籍，点击查看详细：</li>
						    <li>&nbsp;</li>
						    <li>&nbsp;</li>
						    <li>&nbsp;</li>
						</ul>
					</div>
				</div>
			</div>		
			<div class="form-group">
				<label for="book_url" class="col-sm-3 control-label">采购网址（必填，最好京东亚马逊当当的）</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="book_url" name="BooksBuyRequest[book_url]" value="<?php 
					if(isset($ResultBuyRequest)) {
						echo $ResultBuyRequest->book_url;
					}
					?>">
				</div>
			</div>
			<?php 
				if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
				{
			?>
			<div class="form-group">
				<label for="user_id" class="col-sm-3 control-label">Request NSN ID</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="user_id" name="BooksBuyRequest[user_id]"  placeholder="Requried" value="<?php 
					if(isset($ResultBuyRequest)) {
						echo $ResultBuyRequest->user_id;
					}
					else{
						echo RoleUtil::getUser()->nsn_id;
					}
					?>">
				</div>
			</div>	
			<?php 
				}
				else 
				{
			?>
					<input type="hidden" class="form-control"  id="user_id" name="BooksBuyRequest[user_id]" value="<?php 
					if(isset($ResultBuyRequest)) {
						echo $ResultBuyRequest->user_id;
					}
					else{
						echo RoleUtil::getUser()->nsn_id;
					}
					?>" placeholder="Requried">
			<?php 		
				}
			?>	
			<div class="form-group">
				<label for="book_url" class="col-sm-3 control-label">标价（填数字）</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="price_origin" name="BooksBuyRequest[price_origin]" value="<?php 
					if(isset($ResultBuyRequest)) {
						echo $ResultBuyRequest->price_origin;
					}
					else{
						echo "0";
					}
					?>">
				</div>
			</div>
			<div class="form-group">
				<label for="book_url" class="col-sm-3 control-label">折后价（填数字）</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="price_discount" name="BooksBuyRequest[price_discount]" value="<?php 
					if(isset($ResultBuyRequest)) {
						echo $ResultBuyRequest->price_discount;
					}
					else{
						echo "0";
					}
					?>">
				</div>
			</div>
			<div class="form-group">
				<label for="book_type" class="col-sm-3 control-label">类别</label>
				<div class="col-sm-7">
					<select class="form-control" id="book_type" name="BooksBuyRequest[book_type]">
						<?php 
						if(isset($ResultBuyRequest)) {
							echo '<option value="'.$ResultBuyRequest->book_type.'">'.$ResultBuyRequest->book_type.'</option>';
						}
						?>
						<option value="1.技术与项目">1.技术与项目</option>
						<option value="2.育儿与教育">2.育儿与教育</option>
						<option value="3.文学与励志">3.文学与励志</option>
						<option value="4.其它（美食、体育、旅游...）">4.其它（美食、体育、旅游...）</option>
					</select>

				</div>
			</div>
			<div class="form-group">
				<label for="request_reason" class="col-sm-3 control-label">推荐理由</label>
				<div class="col-sm-7">
					<textarea class="form-control" style="height: 80px;" id="request_reason" name="BooksBuyRequest[request_reason]" placeholder=""> <?php 
					if(isset($ResultBuyRequest)) {
						echo $ResultBuyRequest->request_reason;
					}
					?></textarea>
				</div>
			</div>		
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
			<?php 
			if(isset($ResultBuyRequest)){
			?>
        	<button type="button" onclick='ajaxSubmit("buy_request_form","dlgbody")' class="btn btn-info"><?php echo $buttonText ?></button>
        	<?php 
			}else{
        	?>
        	<button type="submit" class="btn btn-info"><?php echo $buttonText ?></button>
        	<button type="reset" class="btn btn-default">Reset</button>
        	<?php 
			}
        	?>
        	</div>
        </div>
		</form>
</div>

<script>


</script>
