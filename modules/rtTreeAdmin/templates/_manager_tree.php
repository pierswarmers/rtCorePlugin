<div class="nested_set_manager_holder" id="<?php echo strtolower($model); ?>_nested_set_manager_holder">
    <?php echo get_partial('rtTreeAdmin/nested_set_list', array('model' => $model, 'field' => $field, 'root' => $root, 'records' => $records)); ?>
    <div style="clear:both">&nbsp;</div>
</div>

<div class="sf_admin_actions">
  <?php include_partial('rtTreeAdmin/list_actions', array('model' => $model, 'field' => $field, 'root' => $root, 'records' => $records, 'hasManyRoots' => $hasManyRoots)); ?>
</div>