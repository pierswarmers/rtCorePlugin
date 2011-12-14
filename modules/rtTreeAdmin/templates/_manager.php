<?php use_helper('I18N', 'Date', 'JavascriptBase') ?>
<div id="sf_admin_container">
    <?php include_partial('rtAdmin/flashes') ?>
		<?php if ($hasManyRoots && !$sf_request->hasParameter('root') ):?>
			<?php include_partial('rtTreeAdmin/manager_roots', array('model' => $model, 'field' => $field, 'root' => $root, 'roots' => $roots)) ?>
		<?php else: ?>
			<?php include_partial('rtTreeAdmin/manager_tree', array('model' => $model, 'field' => $field, 'root' => $root, 'records' => $records, 'hasManyRoots' => $hasManyRoots)) ?>
		<?php endif;?>	
</div>
