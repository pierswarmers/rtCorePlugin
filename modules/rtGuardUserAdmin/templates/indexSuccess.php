<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Users') ?></h1>

<?php slot('rt-tools') ?>
<ul id="rtPrimaryTools">
  <li><button class="create"><?php echo __('Create new person') ?></button></li>
  <li><button class="reports"><?php echo __('View user report') ?></button></li>
</ul>
<script type="text/javascript">
	$(function() {
    $("#rtPrimaryTools .create").button({
      icons: { primary: 'ui-icon-transfer-e-w' }
    }).click(function(){ document.location.href='<?php echo url_for('rtGuardUserAdmin/new') ?>'; });

    $("#rtPrimaryTools .reports").button({
      icons: { primary: 'ui-icon-transfer-e-w' }
    }).click(function(){ document.location.href='<?php echo url_for('rtGuardUserAdmin/userReport') ?>'; });
	});
</script>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

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
    <?php foreach ($pager->getResults() as $sf_guard_user): ?>
    <tr>
      <td><a href="<?php echo url_for('rtGuardUserAdmin/edit?id='.$sf_guard_user->getId()) ?>"><?php echo $sf_guard_user ?></a></td>
      <td><?php echo $sf_guard_user->getEmailAddress() ?></td>
      <td><?php echo rt_nice_boolean($sf_guard_user->getIsActive()) ?></td>
      <td><?php echo $sf_guard_user->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_edit('rtGuardUserAdmin/edit?id='.$sf_guard_user->getId()) ?></li>
          <li><?php echo rt_button_delete('rtGuardUserAdmin/delete?id='.$sf_guard_user->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>