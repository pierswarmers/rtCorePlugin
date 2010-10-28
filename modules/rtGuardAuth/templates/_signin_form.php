<?php use_helper('I18N', 'rtForm') ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
  <?php if($form['username']->hasError()): ?>
    <p class="error"><?php echo $form['username']->getError() ?></p>
  <?php endif; ?>
  <fieldset>
  <legend><?php echo __('Login') ?></legend>
    <ul class="rt-form-schema">
      <li class="rt-form-row"><?php echo $form['username']->renderLabel() ?><div class="rt-form-field"><?php echo $form['username'] ?></div></li>
      <li class="rt-form-row"><?php echo $form['password']->renderLabel() ?><div class="rt-form-field"><?php echo $form['password'] ?></div></li>
      <li class="rt-form-row"><?php echo $form['remember']->renderLabel() ?><div class="rt-form-field"><?php echo $form['remember'] ?></div></li>
    </ul>
  </fieldset>
  <p>
  <p class="rt-form-tools"><button><?php echo __('Sign in', null, 'sf_guard') ?></button></p>
  <?php $routes = $sf_context->getRouting()->getRoutes() ?>
  <?php if (isset($routes['sf_guard_forgot_password'])): ?>
    <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
  <?php endif; ?>
  <?php if (isset($routes['sf_guard_register']) && !sfConfig::get('app_rt_registration_is_private', false)): ?>
    &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
  <?php endif; ?>
</form>