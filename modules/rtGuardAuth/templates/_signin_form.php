<?php use_helper('I18N', 'rtForm') ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
    <ul class="rt-form-schema">
      <li class="rt-form-row"><?php echo $form['username']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['username'] ?>
          <small class="rt-help"><?php echo __('Eg: jenny@example.com') ?></small>
        </div>
      </li>
      <li class="rt-form-row"><?php echo $form['password']->renderLabel() ?><div class="rt-form-field"><?php echo $form['password'] ?></div></li>
      <li class="rt-form-row"><?php echo $form['remember']->renderLabel() ?>
        <div class="rt-form-field">
          <?php echo $form['remember'] ?>
          <small class="rt-help"><?php echo __('Not for use on public or shared computers') ?></small>
        </div>
      </li>
    </ul>
  <p class="rt-form-tools">
    <button><?php echo __('Sign in', null, 'sf_guard') ?></button> 
    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
      <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
    <?php endif; ?>
    <?php if (isset($routes['sf_guard_register']) && !sfConfig::get('app_rt_registration_is_private', false)): ?>
      &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Don\'t have an account?', null, 'sf_guard') ?></a>
    <?php endif; ?>
  </p>
</form>