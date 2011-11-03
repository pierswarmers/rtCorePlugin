<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('rtGuardUser/update') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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


  <?php if(isset($form['billing_address'])): ?>
  <fieldset>
    <legend><?php echo $form->isAddressModeSimple() ? 'Address Information' : __('Billing Address Information') ?></legend>
    <?php echo $form['billing_address']->render() ?>
  </fieldset>
  <?php endif; ?>

  <?php if(isset($form['shipping_address']) && !$form->isAddressModeSimple()): ?>
  <fieldset>
    <legend><?php echo __('Shipping Address Information') ?></legend>
    <?php echo $form['shipping_address'] ?>
  </fieldset>
  <?php endif; ?>

  <p class="rt-section-tools-submit"><button type="submit"><?php echo __('Save Changes') ?></button></p>
</form>
