<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('rtGuardUser/update') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php echo $form->renderHiddenFields() ?>
  <input type="hidden" name="rt_post_save_action" value="edit" />

  <fieldset>
  <legend><?php echo __('Login Information') ?></legend>
    <ul class="rt-form-schema">
      <li class="rt-form-row">
        <?php echo $form['email_address']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['email_address']->renderError() ?>
          <?php echo $form['email_address'] ?>
          <?php echo $form['email_address']->renderHelp() ?>
        </div>
      </li>
      <li class="rt-form-row">
        <?php echo $form['username']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
          <?php echo $form['username']->renderHelp() ?>
        </div>
      </li>
      <li class="rt-form-row">
        <?php echo $form['password']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
          <?php echo $form['password']->renderHelp() ?>
        </div>
      </li>
      <li class="rt-form-row">
        <?php echo $form['password_again']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['password_again']->renderError() ?>
          <?php echo $form['password_again'] ?>
          <?php echo $form['password_again']->renderHelp() ?>
        </div>
      </li>
    </ul>
  </fieldset>

  <fieldset>
  <legend><?php echo __('Profile Information') ?></legend>
    <ul class="rt-form-schema">
      <li class="rt-form-row">
        <?php echo $form['first_name']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['first_name']->renderError() ?>
          <?php echo $form['first_name'] ?>
          <?php echo $form['first_name']->renderHelp() ?>
        </div>
      </li>
      <li class="rt-form-row">
        <?php echo $form['last_name']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['last_name']->renderError() ?>
          <?php echo $form['last_name'] ?>
          <?php echo $form['last_name']->renderHelp() ?>
        </div>
      </li>
      <li class="rt-form-row">
        <?php echo $form['date_of_birth']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['date_of_birth']->renderError() ?>
          <?php echo $form['date_of_birth'] ?>
          <?php echo $form['date_of_birth']->renderHelp() ?>
        </div>
      </li>
      <li class="rt-form-row">
        <?php echo $form['url']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['url']->renderError() ?>
          <?php echo $form['url'] ?>
          <?php echo $form['url']->renderHelp() ?>
        </div>
      </li>
    </ul>
  </fieldset>

  <fieldset>
  <legend><?php echo __('Billing Address') ?></legend>
    <?php include_partial('address_form', array('form' => $form['billing_address'])); ?>
  </fieldset>

  <fieldset>
  <legend><?php echo __('Shipping Address') ?></legend>
    <?php include_partial('address_form', array('form' => $form['shipping_address'])); ?>
  </fieldset>
    
  <p class="rt-form-tools"><button type="submit"><?php echo __('Save Changes') ?></button></p>
</form>
