<div id="createBuyListDiv">
	<?php 
			$formUrl=$this->createUrl("addBuyList");
			$buttonText="创建采购计划";
			$createModel=true;
			if(isset($isCreate) && !$isCreate){
				$formUrl=$this->createUrl("editBuyList") ;
				$buttonText="保存采购计划";
				$createModel=false;
			}
		?>
		<form id="buyList_create" action="<?php echo $formUrl ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="margin-top:10px;">
			<div class="form-group">
				<div class="col-sm-7">
					<?php 
						if(isset($ResultBuyList)){
					?>
					<input type="hidden" class="form-control"  id="id" name="BooksBuyList[id]" placeholder="Requried" value="<?php echo $ResultBuyList->id ?>">
					<?php 
						}
					?>
				</div>
			</div>	
			<div class="form-group">
				<label for="list_name" class="col-sm-3 control-label">名称</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="list_name" name="BooksBuyList[list_name]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo $ResultBuyList->list_name;
					}else{
						echo "2017年第三季度新书采购";
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<label for="budget" class="col-sm-3 control-label">预算（￥，填数字）</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="budget" name="BooksBuyList[budget]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo $ResultBuyList->budget;
					}else{
						echo "0";
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<label for="start_time" class="col-sm-3 control-label">开始时间（格式:YYYY-MM-DD）</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="start_time" name="BooksBuyList[start_time]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo longDate($ResultBuyList->start_time);
					}else{
						echo longDate(getCurTime());
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<label for="buyer_names" class="col-sm-3 control-label">采购人员</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="buyer_names" name="BooksBuyList[buyer_names]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo $ResultBuyList->buyer_names;
					}else{
						echo "bihong.he@onelibrary.com";
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<label for="approves_names" class="col-sm-3 control-label">财务人员</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="approves_names" name="BooksBuyList[approves_names]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo $ResultBuyList->approves_names;
					}else{
						echo "hebihong@163.com;frances.yu@onelibrary.com";
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<label for="addtion_info" class="col-sm-3 control-label">备注</label>
				<div class="col-sm-7">
					<textarea id="addtion_info" name="BooksBuyList[addtion_info]" class="form-control" rows="4" placeholder=""><?php 
					if(isset($ResultBuyList)) {
						echo $ResultBuyList->addtion_info;
					}else{
						echo "";
					}
					?></textarea>
				</div>
			</div>	
			<hr>
			<div class="form-group">
				<label for="finished_time" class="col-sm-3 control-label">完成时间（格式:YYYY-MM-DD）</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="finished_time" name="BooksBuyList[finished_time]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo longDate($ResultBuyList->finished_time);
					}else{
						echo longDate("2020-10-1");
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<label for="paid_account" class="col-sm-3 control-label">实际支付</label>
				<div class="col-sm-7">
					<input type="text" class="form-control"  id="paid_account" name="BooksBuyList[paid_account]" placeholder="Requried" value="<?php 
					if(isset($ResultBuyList)) {
						echo $ResultBuyList->paid_account;
					}else{
						echo "0";
					}
					?>">
				</div>
			</div>		
			<div class="form-group">
				<div class="col-sm-7">
				</div>
			</div>
		<div class="form-group">
			<label for="stock_total" class="col-sm-3 control-label"> </label>
			<div class="col-sm-7">
        	<button type="button" onclick="loadCreateBuyList()" class="btn btn-info"><?php echo $buttonText ?></button>
        	</div>
        </div>
		</form>
</div>