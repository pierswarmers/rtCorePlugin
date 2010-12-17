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

      enablePublishToggle('<?php echo url_for('rtGuardUserAdmin/toggle') ?>');
	});
</script>
<h2><?php echo __('Users Summary') ?></h2>
<dl class="rt-admin-summary-panel clearfix">
  <dt class="rt-admin-primary"><?php echo __('Total users') ?></dt>
  <dd class="rt-admin-primary"><?php echo $stats['total']['count'] ?></dd>
  <dt><?php echo __('Users added this month') ?></dt>
  <dd><?php echo $stats['month_current']['count'] ?></dd>
  <dt><?php echo __('Super admin users') ?></dt>
  <dd><?php echo $stats['total_admin']['count'] ?></dd>
  <dt><?php echo __('Active users') ?></dt>
  <dd><?php echo $stats['total_active']['count'] ?></dd>
  <dt><?php echo __('Unused users') ?></dt>
  <dd><?php echo $stats['total_unused']['count'] ?></dd>
</dl>
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
      <td class="rt-admin-publish-toggle">
        <?php echo rt_nice_boolean($sf_guard_user->getIsActive()) ?>
        <div style="display:none;"><?php echo $sf_guard_user->getId() ?></div>
      </td>
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