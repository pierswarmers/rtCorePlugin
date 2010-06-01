<?php use_helper('I18N', 'rtForm') ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
  <p><?php echo $form['username']->renderLabel() ?> <?php echo $form['username'] ?></p>
  <p><?php echo $form['password']->renderLabel() ?> <?php echo $form['password'] ?></p>
  <p><?php echo $form['remember'] ?> <?php echo $form['remember']->renderLabel() ?></p>
  <p>
  <button type="submit" class="button medium positive"><?php echo __('Sign in', null, 'sf_guard') ?></button>
  <?php $routes = $sf_context->getRouting()->getRoutes() ?>
  <?php if (isset($routes['sf_guard_forgot_password'])): ?>
    <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
  <?php endif; ?>
  <?php if (isset($routes['sf_guard_register']) && !sfConfig::get('app_rt_registration_is_private', false)): ?>
    &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
  <?php endif; ?>
  </p>
</form>