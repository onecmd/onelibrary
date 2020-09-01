<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label',
);\n";
?>

$this->menu=array(
	array('label'=>'管理 <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
	array('label'=>'创建 <?php echo $this->modelClass; ?>', 'url'=>array('create')),
	array('label'=>'列表 <?php echo $this->modelClass; ?>', 'url'=>array('index')),
);
?>

<font style="size:14px;font-weight:bold;"><?php echo $label; ?></font>
<hr size="1" style="margin-top:5px; margin-bottom:5px;" />

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>