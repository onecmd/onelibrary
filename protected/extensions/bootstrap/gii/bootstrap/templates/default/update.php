<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'修改',
);\n";
?>

$this->menu=array(
	array('label'=>'管理 <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
	array('label'=>'创建 <?php echo $this->modelClass; ?>', 'url'=>array('create')),
	array('label'=>'列表 <?php echo $this->modelClass; ?>', 'url'=>array('index')),
	array('label'=>'查看 <?php echo $this->modelClass; ?>', 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
);
?>
<?php /*
    <font style="size:14px;font-weight:bold;">修改 <?php echo $this->modelClass . " <?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></font>
<hr size="1" style="margin-top:5px; margin-bottom:5px;" />
*/ ?>
<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>