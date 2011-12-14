<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('@sf_guard_register') ?>" method="post" class="rt-compact">

  <?php echo $form->renderHiddenFields() ?>

  <?php

  // Personal Information

  if(isset($form['first_name']) || isset($form['last_name']) || isset($form['date_of_birth'])): ?>

    <fieldset>
      <legend><?php echo __('Personal Information') ?></legend>
      <ul class="rt-form-schema">
        <?php foreach(array('first_name', 'last_name', 'date_of_birth') as $field): ?>
        <?php if(isset($form[$field])) { echo $form[$field]->renderRow(); } ?>
        <?php endforeach; ?>
      </ul>
    </fieldset>
  <?php endif; ?>

  <?php

  // Account Access Information

  if(isset($form['email_address']) || isset($form['password']) || isset($form['password_again'])): ?>

    <fieldset>
      <legend><?php echo __('Account Information') ?></legend>
      <ul class="rt-form-schema">
        <?php foreach(array('email_address', 'password', 'password_again') as $field): ?>
        <?php if(isset($form[$field])) { echo $form[$field]->renderRow(); } ?>
        <?php endforeach; ?>
      </ul>
    </fieldset>
  <?php endif; ?>

  <?php

  // Captcha

  if(isset($form['captcha'])): ?>

    <fieldset>
      <legend><?php echo __('One more thing') ?>...</legend>
      <ul class="rt-form-schema">
        <?php echo $form['captcha']->renderRow() ?>
      </ul>
    </fieldset>
  <?php endif; ?>



  <p class="rt-section-tools-submit">
    <button type="submit"><?php echo __('Register') ?></button>
    <?php echo __('Or, you can') ?> <?php echo link_to(__('sign in here', null, 'sf_guard'), '@sf_guard_signin') ?>.
  </p>
</form>
