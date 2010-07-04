<?php use_helper('I18N', 'rtForm') ?>
<div class="rt-container">
  <form action="<?php echo url_for('@sf_guard_register') ?>" method="post" class="rt-compact">
    <?php echo $form->renderHiddenFields() ?>
    <p><?php echo $form['first_name']->renderRow() ?></p>
    <p><?php echo $form['last_name']->renderRow() ?></p>
    <p><?php echo $form['email_address']->renderRow() ?></p>
    <p><?php echo $form['username']->renderRow() ?></p>
    <p><?php echo $form['password']->renderRow() ?></p>
    <p><?php echo $form['password_again']->renderRow() ?></p>
    <p><button type="submit" name="register" class="button medium positive"><?php echo __('Register', null, 'sf_guard') ?></button></p>
  </form>
</div>