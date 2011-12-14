<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Hello %name%', array('%name%' => $user->getName()), 'sf_guard'));

?>

<div class="rt-section rt-guard-auth">
  
  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Hello %name%', array('%name%' => $user->getName()), 'sf_guard') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">
    
    <?php rt_get_snippet('rt-guard-forgot-password-change-prefix', __('Enter your new password in the form below to have it saved for next time you sign in.')); ?>

    <form action="<?php echo url_for('@sf_guard_forgot_password_change?unique_key='.$sf_request->getParameter('unique_key')) ?>" method="POST">
      <?php echo $form->renderHiddenFields() ?>
      <fieldset>
      <legend><?php echo __('New password') ?></legend>
        <ul class="rt-form-schema">
          <li class="rt-form-row"><?php echo $form['password']->renderLabel() ?><div class="rt-form-field"><?php echo $form['password'] ?></div></li>
          <li class="rt-form-row"><?php echo $form['password_again']->renderLabel() ?><div class="rt-form-field"><?php echo $form['password_again'] ?></div></li>
        </ul>
      </fieldset>
      <p class="rt-section-tools-submit"><button type="submit"><?php echo __('Change', null, 'sf_guard') ?></button></p>
    </form>
    
  </div>
</div>