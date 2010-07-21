<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Permissions') ?></h1>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('controller' => 'rtGuardPermissionAdmin'))?>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<table>
  <thead>
    <tr>
      <th><?php echo __('Name'); ?></th>
      <th><?php echo __('Description'); ?></th>
      <th><?php echo __('Created at'); ?></th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $sf_guard_permission): ?>
    <tr>
      <td><a href="<?php echo url_for('rtGuardPermissionAdmin/edit?id='.$sf_guard_permission->getId()) ?>"><?php echo $sf_guard_permission->getName() ?></a></td>
      <td><?php echo $sf_guard_permission->getDescription() ?></td>
      <td><?php echo $sf_guard_permission->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_edit('rtGuardPermissionAdmin/edit?id='.$sf_guard_permission->getId()) ?></li>
          <li><?php echo rt_button_delete('rtGuardPermissionAdmin/delete?id='.$sf_guard_permission->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>