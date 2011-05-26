<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('@sf_guard_register') ?>" method="post" class="rt-compact">

  <?php echo $form->renderHiddenFields() ?>

  <fieldset>
  <legend><?php echo __('Login Information') ?></legend>
    <ul class="rt-form-schema">
      <?php echo $form['email_address']->renderRow() ?>
      <?php echo $form['username']->renderRow() ?>
      <?php echo $form['password']->renderRow() ?>
      <?php echo $form['password_again']->renderRow() ?>
    </ul>
  </fieldset>

  <fieldset>
  <legend><?php echo __('Profile Information') ?></legend>
    <ul class="rt-form-schema">
      <li class="rt-form-row">
      <?php echo $form['first_name']->renderRow() ?>
      <?php echo $form['last_name']->renderRow() ?>

      <?php if(!$form->isProfileModeSimple()): ?>
      <?php echo $form['date_of_birth']->renderRow() ?>
      <?php echo $form['company']->renderRow() ?>
      <?php echo $form['url']->renderRow() ?>
      <?php endif; ?>
    </ul>
  </fieldset>

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

  <p class="rt-form-tools"><button type="submit"><?php echo __('Save Changes') ?></button></p>
</form>
