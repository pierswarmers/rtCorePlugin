<?php use_helper('I18N', 'rtForm') ?>
<h1><?php echo __('Hello %name%', array('%name%' => $user->getName()), 'sf_guard') ?></h1>
<div class="rt-container">
<p><?php echo __('Enter your new password in the form below.', null, 'sf_guard') ?></p>
<?php include_partial('rtAdmin/flashes_public')?>
<form action="<?php echo url_for('@sf_guard_forgot_password_change?unique_key='.$sf_request->getParameter('unique_key')) ?>" method="POST">
  <?php echo $form->renderHiddenFields() ?>
  <p><?php echo $form['password']->renderLabel() ?> <?php echo $form['password'] ?></p>
  <p><?php echo $form['password_again']->renderLabel() ?> <?php echo $form['password_again'] ?></p>
  <p><button type="submit" class="button medium positive"><?php echo __('Change', null, 'sf_guard') ?></button></p>
</form>
</div>