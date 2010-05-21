<?php use_helper('I18N', 'gnAdmin') ?>

<h1><?php echo __('Listing Permissions') ?></h1>

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
    <?php foreach ($sf_guard_permissions as $sf_guard_permission): ?>
    <tr>
      <td><a href="<?php echo url_for('gnGuardPermissionAdmin/edit?id='.$sf_guard_permission->getId()) ?>"><?php echo $sf_guard_permission->getName() ?></a></td>
      <td><?php echo $sf_guard_permission->getDescription() ?></td>
      <td><?php echo $sf_guard_permission->getCreatedAt() ?></td>
      <td>
        <ul class="gn-admin-tools">
          <li><?php echo gn_button_edit('gnGuardPermissionAdmin/edit?id='.$sf_guard_permission->getId()) ?></li>
          <li><?php echo gn_button_delete('gnGuardPermissionAdmin/delete?id='.$sf_guard_permission->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php slot('gn-side') ?>
<p><?php echo button_to(__('Create new permission'), 'gnGuardPermissionAdmin/new', array('class' => 'button positive')) ?></p>
<?php end_slot(); ?>