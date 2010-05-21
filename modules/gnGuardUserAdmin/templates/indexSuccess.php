<?php use_helper('I18N', 'gnAdmin') ?>

<h1><?php echo __('Listing Users') ?></h1>

<table>
  <thead>
    <tr>
      <th><?php echo __('Name'); ?></th>
      <th><?php echo __('Email address'); ?></th>
      <th><?php echo __('Active'); ?></th>
      <th><?php echo __('Created at'); ?></th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($sf_guard_users as $sf_guard_user): ?>
    <tr>
      <td><a href="<?php echo url_for('gnGuardUserAdmin/edit?id='.$sf_guard_user->getId()) ?>"><?php echo $sf_guard_user ?></a></td>
      <td><?php echo $sf_guard_user->getEmailAddress() ?></td>
      <td><?php echo gn_nice_boolean($sf_guard_user->getIsActive()) ?></td>
      <td><?php echo $sf_guard_user->getCreatedAt() ?></td>
      <td>
        <ul class="gn-admin-tools">
          <li><?php echo gn_button_edit('gnGuardUserAdmin/edit?id='.$sf_guard_user->getId()) ?></li>
          <li><?php echo gn_button_delete('gnGuardUserAdmin/delete?id='.$sf_guard_user->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php slot('gn-side') ?>
<p><?php echo button_to(__('Create new user'), 'gnGuardUserAdmin/new', array('class' => 'button positive')) ?></p>
<?php end_slot(); ?>