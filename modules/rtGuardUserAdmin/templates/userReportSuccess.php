<?php use_helper('I18N', 'rtAdmin', 'Number', 'Text') ?>

<h1><?php echo __('User Report') ?></h1>

<?php slot('rt-tools') ?>
<ul id="rtPrimaryTools">
  <li class="button-group">
    <button class="download-csv"><?php echo __('Download CSV') ?></button>
    <button class="download-xml"><?php echo __('XML') ?></button>
    <button class="download-json"><?php echo __('JSON') ?></button>
  </li>
  <li><button class="cancel"><?php echo __('Cancel/List') ?></button></li>
</ul>
<script type="text/javascript">
	$(function() {
    $("#rtPrimaryTools .download-csv").button({
      icons: { primary: 'ui-icon-transfer-e-w' }
    }).click(function(){ document.location.href='<?php echo url_for('@rt_guard_user_report_download?sf_format=csv') ?>'; });

    $("#rtPrimaryTools .download-xml").button({
    }).click(function(){ document.location.href='<?php echo url_for('@rt_guard_user_report_download?sf_format=xml') ?>'; });

    $("#rtPrimaryTools .download-json").button({
    }).click(function(){ document.location.href='<?php echo url_for('@rt_guard_user_report_download?sf_format=json') ?>'; });

    $("#rtPrimaryTools .cancel").button({
      icons: { primary: 'ui-icon-cancel' }
    }).click(function(){ document.location.href='<?php echo url_for('rtGuardUserAdmin/index') ?>'; });

    $('.button-group').buttonset();

	});
</script>
<?php end_slot(); ?>

<table>
  <thead>
    <tr>
      <th><?php echo __('Last Name') ?></th>
      <th><?php echo __('First Name') ?></th>
      <th><?php echo __('Email') ?></th>
      <th><?php echo __('Date of birth') ?></th>
      <th><?php echo __('Username') ?></th>
      <th><?php echo __('Status') ?></th>
      <th><?php echo __('Admin') ?></th>
      <th><?php echo __('Company') ?></th>
      <th><?php echo __('URL') ?></th>
      <th><?php echo __('Last Login') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($pager->getResults() as $user): ?>
      <tr>
        <td><a href="<?php echo url_for('rtGuardUserAdmin/edit?id='.$user['u_id']) ?>"><?php echo $user['u_last_name'] ?></a></td>
        <td><?php echo $user['u_first_name'] ?></td>
        <td><?php echo truncate_text($user['u_email_address'],15) ?></td>
        <td><?php echo date('d/m/Y',strtotime($user['u_date_of_birth'])) ?></td>
        <td><?php echo $user['u_username'] ?></td>
        <td><?php echo rt_nice_boolean($user['u_is_active']) ?></td>
        <td><?php echo rt_nice_boolean($user['u_is_super_admin']) ?></td>
        <td><?php echo truncate_text($user['u_company'],15) ?></td>
        <td><?php echo truncate_text($user['u_url'],15) ?></td>
        <td><?php echo $user['u_last_login'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>