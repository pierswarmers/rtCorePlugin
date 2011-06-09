<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Register an account'));

?>

<div class="rt-section rt-guard-register">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Register an account') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <?php rt_get_snippet('rt-guard-register-prefix', __('Please fill out your details in the form below to create a new account.')); ?>

    <?php echo get_partial('rtGuardRegister/form', array('form' => $form)) ?>

  </div>
</div>