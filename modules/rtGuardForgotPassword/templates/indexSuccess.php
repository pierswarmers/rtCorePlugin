<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Forgot your password?'));

?>

<div class="rt-section rt-guard-forgot-password">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Forgot your password?') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <?php rt_get_snippet('rt-guard-forgot-password-prefix', 'Do not worry, we can help you get back in to your account safely! Fill out the form below to request an e-mail with information on how to reset your password.'); ?>

    <form action="<?php echo url_for('@sf_guard_forgot_password') ?>" method="post">
      <?php echo $form->renderHiddenFields() ?>
      <fieldset>
      <legend><?php echo __('Reset your password') ?></legend>
        <ul class="rt-form-schema">
          <li class="rt-form-row"><?php echo $form['email_address']->renderLabel() ?><div class="rt-form-field"><?php echo $form['email_address'] ?></div></li>
        </ul>
      </fieldset>
      <p class="rt-section-tools-submit">
        <button type="submit"><?php echo __('Reset password', null, 'sf_guard') ?></button>
        <?php echo __('Or, you can') ?> <?php echo link_to(__('sign in here', null, 'sf_guard'), '@sf_guard_signin') ?>.
      </p>
    </form>
  </div>

</div>
