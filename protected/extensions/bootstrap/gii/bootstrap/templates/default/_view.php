<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */
<?php echo "?>\n"; ?>

<div class="view">

    <?php
    echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
    echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}),array('view','id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n\t<br />\n\n";
    $count = 0;
    foreach ($this->tableSchema->columns as $column) {
        if ($column->isPrimaryKey) {
            continue;
        }
        if (++$count == 7) {
            echo "\t<?php /*\n";
        }
        echo "\t<?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:\n";
        echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
    }
    if ($count >= 7) {
        echo "\t*/ ?>\n";
    }
    ?>

</div>