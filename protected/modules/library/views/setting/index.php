<?php 
	$action = isset($_REQUEST["action"])?$_REQUEST["action"]:null;
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="maintab">
  <li class="<?php echo (!isset($action) || $action=="type")? "active":"" ?>"><a href="#tbBookType" role="tab" data-toggle="tab">Book Type</a></li>
  <li class="<?php echo (isset($action) && $action=="category")? "active":"" ?>"><a href="#tbBookType2" role="tab" data-toggle="tab">Book Category</a></li>
  <li class="<?php echo (isset($action) && $action=="user")? "active":"" ?>"><a href="#tbLibration" role="tab" data-toggle="tab">Libration</a></li>
  <li class="<?php echo (isset($action) && $action=="system")? "active":"" ?>"><a href="#tbSystem" role="tab" data-toggle="tab">System</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane <?php echo (!isset($action) || $action=="type")? "active":"" ?>" id="tbBookType">
		<div style="color:red;padding:10px 10px 10px 20px;">
			Note: 这是图书类别管理页面，目前只有book、magazine两种类别，若要删除请确保该类别属下无图书!
		</div>
		<table class="table table-condensed table-hover table-striped">
			<tr>
			  <td>No</td>
			  <td>Type Name</td>
			  <td>Borrow Days Limit</td>
			  <td>Overdue Fine Per Day</td>
			  <td>Action</td>
			</tr>
			<form action="<?php echo $this->createUrl("addtype") ?>" method="post">
			<tr>
			  <td>
			  	<input type="hidden" name="BooksType[grade]" value="0">
			  </td>
			  <td><input type="text" class="form-control" name="BooksType[type_name]" value=""></td>
			  <td><input type="number" class="form-control" name="BooksType[borrow_days_limit]" value="30"></td>
			  <td><input type="text" class="form-control" name="BooksType[overdue_fine_per_day]" value="0.2"></td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm">Add New</button>
			  </td>
			</tr>
			</form>
			<?php 
				$id=0;
				foreach($ResultTypes as $model)
				{
					$id=$id+1;
			?>
			<form action="<?php echo $this->createUrl("changetype") ?>" method="post">
			<tr>
			  <td>
			  	<?php echo $id ?>
			  	<input type="hidden" name="BooksType[id]" value="<?php echo $model->id ?>">
			  	<input type="hidden" name="BooksType[grade]" value="0">
			  </td>
			  <td><input type="text" class="form-control" name="BooksType[type_name]" value="<?php echo $model->type_name ?>"></td>
			  <td><input type="number" class="form-control" name="BooksType[borrow_days_limit]" value="<?php echo $model->borrow_days_limit ?>"></td>
			  <td><input type="text" class="form-control" name="BooksType[overdue_fine_per_day]" value="<?php echo $model->overdue_fine_per_day ?>"></td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm">Save</button>
			 	 <a href="<?php echo $this->createUrl("deltype", array("id"=>$model->id, "grade"=>"0"))?>" class="btn btn-primary btn-sm">Remove</a>
			  </td>
			</tr>
			</form>
			<?php 
				}
			?>
		</table>
	</div>
	
	<div class="tab-pane <?php echo (isset($action) && $action=="category")? "active":"" ?>" id="tbBookType2">
		<div style="color:red;padding:10px 10px 10px 20px;">
			Note: 这是图书分类管理页面，当Parent Category为0时表示一级分类，Category Code为二级分类，是一级分类下属的分类!<br>
			若需删除，请确保该类别下无图书。<br>
			书籍表中已存在以下类别缩写，请确保以下类别缩写在下表中都有对应的配置：<br>
			<?php 
				$db = Yii::app()->db; 
				$sql = "select distinct category_1 from tb_books where category_1<>'';";
				$ResultBooksCategory = $db->createCommand($sql)->query();
				foreach($ResultBooksCategory as $result)
				{
					echo $result["category_1"].", ";
				}
			?>
		</div>
		<table class="table table-condensed table-hover table-striped">
			<tr>
			  <td>No</td>
			  <td>Parent Category</td>
			  <td>Category Code</td>
			  <td>Category Name</td>
			  <td>Action</td>
			</tr>
			<form action="<?php echo $this->createUrl("addtype") ?>" method="post">
			<tr>
			  <td>
			  	<input type="hidden" name="BooksType[grade]" value="1">
			  </td>
			  <td><input type="text" class="form-control" name="BooksType[type_parent]" value=""></td>
			  <td><input type="text" class="form-control" name="BooksType[type_code]" value=""></td>
			  <td><input type="text" class="form-control" name="BooksType[type_name]" value=""></td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm">Add New</button>
			  </td>
			</tr>
			</form>
			<?php 
				$id=0;
				foreach($ResultTypes2 as $model)
				{
					$id=$id+1;
			?>
			<form action="<?php echo $this->createUrl("changetype") ?>" method="post">
			<tr>
			  <td>
			  	<?php echo $id ?>
			  	<input type="hidden" name="BooksType[id]" value="<?php echo $model->id ?>">
			  	<input type="hidden" name="BooksType[grade]" value="1">
			  </td>
			  <td><input type="text" class="form-control" name="BooksType[type_parent]" value="<?php echo $model->type_parent ?>"></td>
			  <td><input type="text" class="form-control" name="BooksType[type_code]" value="<?php echo $model->type_code ?>"></td>
			  <td><input type="text" class="form-control" name="BooksType[type_name]" value="<?php echo $model->type_name ?>"></td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm">Save</button>
			 	 <a href="<?php echo $this->createUrl("deltype", array("id"=>$model->id, "grade"=>"1"))?>" class="btn btn-primary btn-sm">Remove</a>
			  </td>
			</tr>
			</form>
			<?php 
				}
			?>
		</table>	
	</div>
	
	<div class="tab-pane <?php echo (isset($action) && $action=="user")? "active":"" ?>" id="tbLibration">
		<div style="color:red;padding:10px 10px 10px 20px;">
			Note: 这是图书管理员管理页面，设置为管理员之前请确保该账户已注册并能正常登陆!
		</div>
		<table class="table table-condensed table-hover table-striped">
			<tr>
			  <td>No</td>
			  <td>NSN ID</td>
			  <td>User Name</td>
			  <td>Is TU Member</td>
			  <td>Library Role</td>
			  <td>Action</td>
			</tr>
			<form action="<?php echo $this->createUrl("addlibuser") ?>" method="post">
			<tr>
			  <td> </td>
			  <td colspan="3">
			  	<input type="text" class="form-control" name="UsersRole[user_id]" value="" placeholder="NSN ID">
			  </td>
			  <td>
			  		<select class="form-control" name="UsersRole[role_library]">
					  <option value="2">Finance</option>
					  <option value="5" SELECTED>Libration</option>
					  <option value="10">SuperAdmin</option>
					</select>
			  </td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm">Set To Library User</button>
			  </td>
			</tr>
			</form>
			<?php 
				$id=0;
				$emailStr = "";
				foreach($ResultRols as $model)
				{
					if($model["user_id"]=="100")
						continue;
						
					$id=$id+1;
					$emailStr .= $model["email"].";"
			?>
			<form action="<?php echo $this->createUrl("changelibuser") ?>" method="post">
			<tr>
			  <td>
			  	<?php echo $id ?>
			  	<input type="hidden" name="UsersRole[id]" value="<?php echo $model["id"] ?>">
			  </td>
			  <td><?php echo $model["user_id"] ?></td>
			  <td><?php echo $model["user_name"] ?></td>
			  <td><?php echo $model["is_tu"]==1?"Yes":"No" ?></td>
			  <td>
			  		<select class="form-control" name="UsersRole[role_library]">
					  <option value="5"<?php echo $model["role_library"]==5?"SELECTED":"" ?>>Libration</option>
					  <option value="6" <?php echo $model["role_library"]==6?"SELECTED":"" ?>>Finance</option>
					  <option value="10"<?php echo $model["role_library"]==10?"SELECTED":"" ?>>SuperAdmin</option>
					</select>
			  </td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm">Save</button>
			 	 <a href="<?php echo $this->createUrl("dellibuser", array("id"=>$model["id"]))?>" class="btn btn-primary btn-sm">Remove</a>
			  </td>
			</tr>
			</form>
			<?php 
				}
			?>
		</table>
		All Libration Email:<font color="#666"> <?php echo $emailStr ?></font>
	</div>
	
	<div class="tab-pane <?php echo (isset($action) && $action=="system")? "active":"" ?>" id="tbSystem">
		<div style="color:red;padding:10px 10px 10px 20px;">
			Note: 每次只能提交修改一项!
		</div>
		<table class="table table-condensed table-hover table-striped">
			<tr>
			  <td><b>No</b></td>
			  <td><b>Parameter Name</b></td>
			  <td><b>Value</b></td>
			  <td><b>Action</b></td>
			</tr>
			<?php 
				$id=0;
				foreach($ResultSystems as $model)
				{
					$id=$id+1;
					$ctrType="text";
					if($model->parm_key=="NotifyEmailPwd")
					{
						$ctrType="password";
					}
					else if($model->parm_key=="BorrowBookLimits")
					{
						$ctrType="number";
					}
			?>
			<form action="<?php echo $this->createUrl("changeSystem") ?>" method="post">
			<tr>
			  <td>
			  	<?php echo $id ?>
			  	<input type="hidden" name="System[id]" value="<?php echo $model->id ?>">
			  </td>
			  <td><?php echo $model->parm_title ?></td>
			  <td>
			  	<input type="<?php echo $ctrType ?>" class="form-control" name="System[parm_value]" value="<?php echo $model->parm_value ?>">
			  </td>
			  <td>
			 	 <button type="submit" class="btn btn-primary btn-sm"> &nbsp; Save &nbsp; </button>
			  </td>
			</tr>
			</form>
			<?php 
				}
			?>
		</table>
	</div>
</div>