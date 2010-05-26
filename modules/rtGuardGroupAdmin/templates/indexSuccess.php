<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Groups') ?></h1>

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
    <?php foreach ($sf_guard_groups as $sf_guard_group): ?>
    <tr>
      <td><a href="<?php echo url_for('rtGuardGroupAdmin/edit?id='.$sf_guard_group->getId()) ?>"><?php echo $sf_guard_group->getName() ?></a></td>
      <td><?php echo $sf_guard_group->getDescription() ?></td>
      <td><?php echo $sf_guard_group->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_edit('rtGuardGroupAdmin/edit?id='.$sf_guard_group->getId()) ?></li>
          <li><?php echo rt_button_delete('rtGuardGroupAdmin/delete?id='.$sf_guard_group->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php slot('rt-side') ?>
<p><?php echo button_to(__('Create new group'), 'rtGuardGroupAdmin/new', array('class' => 'button positive')) ?></p>
<?php end_slot(); ?>