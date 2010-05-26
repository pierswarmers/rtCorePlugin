<?php use_helper('I18N', 'rtForm') ?>
<h1><?php echo __('Forgot your password?', null, 'sf_guard') ?></h1>
<p>
  <?php echo __('Do not worry, we can help you get back in to your account safely!', null, 'sf_guard') ?>
  <?php echo __('Fill out the form below to request an e-mail with information on how to reset your password.', null, 'sf_guard') ?>
</p>
<?php include_partial('rtGuardAuth/flashes')?>
<form action="<?php echo url_for('@sf_guard_forgot_password') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
  <?php echo render_form_row($form['email_address']) ?>
  <button type="submit" class="button medium positive"><?php echo __('Request', null, 'sf_guard') ?></button>
</form>