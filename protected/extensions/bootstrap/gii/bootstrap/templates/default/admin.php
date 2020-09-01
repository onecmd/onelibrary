<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>

<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
echo "\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'管理',
);\n";
?>

$this->menu=array(
	array('label'=>'管理 <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
	array('label'=>'创建 <?php echo $this->modelClass; ?>', 'url'=>array('create')),
	array('label'=>'列表 <?php echo $this->modelClass; ?>', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<style type="text/css">
	input.span5{width:60%;height:15px;}
	.control-group {margin-bottom: 0px;}
	div.form label{font-weight:normal;}
	.form-actions{ margin-top:1px; margin-bottom:1px;}
	form{margin-bottom:1px;}
</style>

<div class="text-left" style="padding:5px 5px 5px 5px;float:left;clear:left;">
	可以输入： (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>或 <b>=</b>) 进行条件搜索.
</div>
<div class="text-right" style="padding:5px 5px 5px 5px;float:right;clear:right;">
	<?php echo "<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button btn btn-info')); ?>"; ?>
</div>

<div class="search-form" style="display:none;clear:both;">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
    if (++$count == 7) {
		echo "\t\t/*\n";
	}
    echo "\t\t'" . $column->name . "',\n";
}
if ($count >= 7) {
	echo "\t\t*/\n";
}
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'header'=>'操作',
			'buttons'=>array(
				'view'=>array(
					'url'=>'"javascript:showPopup(\"".Yii::app()->createUrl((Yii::app()->getController()->id)."/ajaxView",array("id"=>$data-><?php echo $this->tableSchema->primaryKey ?> ))."\");"',
				),				
				'update'=>array(
					'url'=>'"javascript:showPopup(\"".Yii::app()->createUrl((Yii::app()->getController()->id)."/ajaxUpdate",array("id"=>$data-><?php echo $this->tableSchema->primaryKey ?>))."\");"',
				),
        	), // end buttons
		), // end array
	), // end columns
)); ?>

<script language="javascript">
	function showPopup(formurl, title)
	{
		//$("#myModalLabel").html(title);
		$.ajax({  
                url: formurl,   
                type : 'POST',  
                success : function(mydata) {  
                        $("#detailform").html(mydata);  
						$('#myModal').modal('show');
                },  
                error : function() {  
                        alert("calc failed");  
                }  
        });  	
	}
</script>

<!-- popup Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h7 id="myModalLabel">&nbsp;</h7>
  </div>
  <div id="detailform" class="modal-body">
    <p>正在加载中，请稍后...</p>
  </div>
  <div class="modal-footer">
    <!--<button class="btn btn-primary">保存</button>-->
    <button class="btn  btn-info" data-dismiss="modal" aria-hidden="true">关闭</button>
  </div>
</div> 
<!-- end popup Modal -->