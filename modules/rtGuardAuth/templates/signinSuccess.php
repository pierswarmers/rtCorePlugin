<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Sign in'))

?>

<div class="rt-section rt-guard-auth">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Sign in') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <?php rt_get_snippet('rt-guard-auth-prefix'); ?>

    <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
      <?php echo $form->renderHiddenFields() ?>
      <fieldset>
        <ul class="rt-form-schema">
          <?php echo $form; ?>
        </ul>
      </fieldset>
      <p class="rt-section-tools-submit">
        <button type="submit"><?php echo __('Sign in', null, 'sf_guard') ?></button>
        <?php $routes = $sf_context->getRouting()->getRoutes() ?>
        <?php if (isset($routes['sf_guard_forgot_password'])): ?>
          <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
        <?php endif; ?>
        <?php if (isset($routes['sf_guard_register']) && !sfConfig::get('app_rt_registration_is_private', false)): ?>
          &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Don\'t have an account?', null, 'sf_guard') ?></a>
        <?php endif; ?>
      </p>
    </form>
  </div>

</div>




