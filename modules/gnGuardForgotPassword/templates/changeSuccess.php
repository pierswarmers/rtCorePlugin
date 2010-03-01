<?php use_helper('I18N', 'GnForm') ?>
<h1><?php echo __('Hello %name%', array('%name%' => $user->getName()), 'sf_guard') ?></h1>
<p><?php echo __('Enter your new password in the form below.', null, 'sf_guard') ?></p>
<?php include_partial('gnGuardAuth/flashes')?>
<form action="<?php echo url_for('@sf_guard_forgot_password_change?unique_key='.$sf_request->getParameter('unique_key')) ?>" method="POST">
  <?php echo $form->renderHiddenFields() ?>
  <?php echo render_form_row($form['password']) ?>
  <?php echo render_form_row($form['password_again']) ?>
  <button type="submit" class="button medium positive"><?php echo __('Change', null, 'sf_guard') ?></button>
</form>