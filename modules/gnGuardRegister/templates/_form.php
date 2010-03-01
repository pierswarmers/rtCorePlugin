<?php use_helper('I18N', 'GnForm') ?>
<form action="<?php echo url_for('@sf_guard_register') ?>" method="post" class="gn-compact">
  <?php echo $form->renderHiddenFields() ?>
  <?php echo render_form_row($form['first_name']) ?>
  <?php echo render_form_row($form['last_name']) ?>
  <?php echo render_form_row($form['email_address']) ?>
  <?php echo render_form_row($form['username']) ?>
  <?php echo render_form_row($form['password']) ?>
  <?php echo render_form_row($form['password_again']) ?>
  <button type="submit" name="register" class="button medium positive"><?php echo __('Register', null, 'sf_guard') ?></button>
</form>