<?php

use_helper('I18N', 'rtAdmin');

$object_name = 'item';

if(isset($object))
{
  $object      = $sf_data->getRaw('object');
  $model       = isset($model) ? $model : get_class($object);
  $object_name = method_exists($object, 'getTypeNice') ? $object->getTypeNice() : 'item';
  $object_name = strtolower($object_name);
}
$controller  = isset($controller) ? $controller : $model.'Admin';

$action      = $sf_request->getParameterHolder()->get('action');

if(!isset($mode))
{
  switch ($action)
  {
    case 'new':
      $mode = 'save';
    case 'create':
      $mode = 'save';
    case 'update':
      $mode = 'save';
      break;
    case 'edit':
      $mode = 'save';
      break;
    case 'versions':
      $mode = 'versions';
      break;
    case 'index':
      $mode = 'list';
      break;
    default:
      $mode = 'cancel';
      break;
  }
}
?>

<ul id="rtPrimaryTools">
  <?php if($mode == 'save'): ?>
  <li>
    <span class="positive save-set">
      <button class="save"><?php echo __('Save Changes') ?></button>
      <button class="save-list"><?php echo __('Save &amp; Close') ?></button>
      <?php if(isset($show_route_handle) && !$object->isNew()): ?>
      <button class="save-show"><?php echo __('Save &amp; Show') ?></button>
      <?php endif; ?>
    </span>
  </li>
  <?php endif; ?>

  <?php if($mode == 'versions'): ?>
  <li><button class="compare"><?php echo __('Compare Selection') ?></button></li>
  <?php endif; ?>

  <?php if($mode != 'list'): ?>
  <li><button class="cancel"><?php echo __('Cancel/List') ?></button></li>
  <?php else: ?>
  <li><button class="new"><?php echo __('Create new') . ' ' . $object_name ?></button></li>
  <?php endif; ?>

  <?php if($mode == 'save'): ?>
  <?php if(isset($show_route_handle) && !$object->isNew()): ?>
  <li><button class="show"><?php echo __('Show') ?></button></li>
  <?php endif; ?>
  <?php endif; ?>
</ul>

<?php if($mode == 'save' && !$object->isNew()): ?>
<p><?php echo __('Or') ?>, <?php echo link_to('delete this ' . $object_name, $controller.'/delete?id='.$object->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></p>
<?php endif; ?>

<script type="text/javascript">
	$(function() {

    <?php if($mode == 'save'): ?>
    $("#rtPrimaryTools .save").button({
      icons: { primary: 'ui-icon-disk' }
    }).click(function(){ $('#rtAdminForm').submit(); }).next().button({
      text: false,
      icons: { secondary: 'ui-icon-close' }
    }).click(function(){ $('input[name=rt_post_save_action]').attr('value', 'index'); $('#rtAdminForm').submit(); }).next().button({
      text: false,
      icons: { secondary: 'ui-icon-extlink' }
    }).click(function(){ $('input[name=rt_post_save_action]').attr('value', 'show'); $('#rtAdminForm').submit(); });

    $("#rtPrimaryTools .save").parent().buttonset();


    <?php if(isset($show_route_handle) && !$object->isNew()): ?>
    $("#rtPrimaryTools .show").button({
      icons: { primary: 'ui-icon-extlink' }
    }).click(function(){ document.location.href='<?php echo url_for($show_route_handle, $object) ?>'; });
    <?php endif; ?>
    
    <?php endif; ?>

    <?php if($mode == 'versions'): ?>
    $("#rtPrimaryTools .compare").button({
      icons: { primary: 'ui-icon-carat-2-e-w' }
    }).click(function(){ $('#rtAdminForm').submit(); })
    <?php endif; ?>
    
    <?php if($mode != 'list'): ?>
    $("#rtPrimaryTools .cancel").button({
      icons: { primary: 'ui-icon-cancel' }
    }).click(function(){ document.location.href='<?php echo url_for($controller.'/index') ?>'; });
    <?php else: ?>
    $("#rtPrimaryTools .new").button({
      icons: { primary: 'ui-icon-plus' }
    }).click(function(){ document.location.href='<?php echo url_for($controller.'/new') ?>'; });
    <?php endif; ?>
    
	});
</script>

